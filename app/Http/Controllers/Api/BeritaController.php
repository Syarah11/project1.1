<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Berita\StoreBeritaRequest;
use App\Http\Requests\Berita\UpdateBeritaRequest;
use App\Models\Berita;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BeritaController extends Controller
{
    /**
     * PUBLIC: List berita published
     */
    public function index(): JsonResponse
    {
        $beritas = Berita::with(['user', 'kategoris', 'tags'])
            ->whereIn('status', ['published', 'draft'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $beritas,
            'media'   => env('MEDIA')
        ]);
    }

    /**
     * PUBLIC: Show berita by ID
     */
    public function show(Request $request, $id): JsonResponse
    {
        $query = Berita::with(['user', 'kategoris', 'tags'])->where('id', $id);

        if (!$this->isAdmin()) {
            $query->where('status', 'published');
        }

        $berita = $query->firstOrFail();

        if ($berita->status === 'published') {
            $this->recordView($request, $berita);
        }

        return response()->json([
            'success' => true,
            'data'    => $berita
        ]);
    }

    /**
     * PUBLIC: Show berita by slug
     */
    public function showBySlug(Request $request, $slug): JsonResponse
    {
        $berita = Berita::with(['user', 'kategoris', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $this->recordView($request, $berita);

        return response()->json([
            'success' => true,
            'data'    => $berita
        ]);
    }

    /**
     * ADMIN: List semua berita (draft + published)
     */
    public function adminIndex(): JsonResponse
    {
        $beritas = Berita::with(['user', 'kategoris', 'tags'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $beritas,
            'media'   => env('MEDIA')
        ]);
    }

    /**
     * NEW: Berita terpopuler berdasarkan view_count
     * GET /api/beritas/populer?limit=5
     */
    public function populer(Request $request): JsonResponse
    {
        $limit = (int) $request->query('limit', 5);
        $limit = min(max($limit, 1), 50);

        $beritas = Berita::with(['user', 'kategoris', 'tags'])
            ->where('status', 'published')
            ->orderBy('view_count', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $beritas
        ]);
    }

    /**
     * NEW: Statistik viewers per hari untuk diagram
     * GET /api/beritas/statistik?days=7
     */
    public function statistik(Request $request): JsonResponse
    {
        $days = (int) $request->query('days', 7);
        $days = min(max($days, 1), 90);

        // Coba ambil dari tabel berita_views
        // Jika gagal (tabel belum ada) → fallback ke view_count
        $labels = [];
        $data   = [];

        try {
            $rows = DB::table('berita_views')
                ->selectRaw('DATE(viewed_at) as tanggal, COUNT(*) as total')
                ->where('viewed_at', '>=', Carbon::now()->subDays($days - 1)->startOfDay())
                ->groupByRaw('DATE(viewed_at)')
                ->orderBy('tanggal')
                ->get()
                ->keyBy('tanggal');

            for ($i = $days - 1; $i >= 0; $i--) {
                $date     = Carbon::now()->subDays($i)->format('Y-m-d');
                $label    = Carbon::now()->subDays($i)->locale('id')->isoFormat('ddd, D MMM');
                $labels[] = $label;
                $data[]   = isset($rows[$date]) ? (int) $rows[$date]->total : 0;
            }

        } catch (\Exception $e) {
            // Fallback jika tabel berita_views belum ada
            $totalViews = (int) Berita::where('status', 'published')->sum('view_count');

            for ($i = $days - 1; $i >= 0; $i--) {
                $labels[] = Carbon::now()->subDays($i)->locale('id')->isoFormat('ddd, D MMM');
                $data[]   = 0;
            }
            if (!empty($data)) {
                $data[count($data) - 1] = $totalViews;
            }
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'labels' => $labels,
                'views'  => $data,
                'days'   => $days,
            ]
        ]);
    }

    /**
     * STORE: Tambah berita draft atau published
     */
    public function store(StoreBeritaRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = ImageService::upload(
                $request->file('thumbnail'),
                'beritas',
                300
            );
        }

        $slug   = $this->generateUniqueSlug($validated['title']);
        $berita = Berita::create([
            'user_id'      => auth()->id() ?? 1,
            'title'        => $validated['title'],
            'slug'         => $slug,
            'description'  => $validated['description'],
            'thumbnail'    => $thumbnailPath,
            'status'       => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        if (!empty($validated['kategori_ids'])) {
            $berita->kategoris()->attach($validated['kategori_ids']);
        }

        if (!empty($validated['tag_ids'])) {
            $berita->tags()->attach($validated['tag_ids']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil ditambahkan',
            'data'    => $berita->fresh(['user', 'kategoris', 'tags'])
        ], 201);
    }

    /**
     * UPDATE: Edit berita
     */
    public function update(UpdateBeritaRequest $request, $id): JsonResponse
    {
        $berita = Berita::findOrFail($id);

        if (!$this->canModifyBerita($berita)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You can only edit your own articles.'
            ], 403);
        }

        $validated = $request->validated();

        if (isset($validated['title']) && $validated['title'] !== $berita->title) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $id);
        }

        if ($request->hasFile('thumbnail')) {
            ImageService::delete($berita->thumbnail);
            $validated['thumbnail'] = ImageService::upload(
                $request->file('thumbnail'),
                'beritas',
                300
            );
        }

        if (isset($validated['status'])
            && $validated['status'] === 'published'
            && !$berita->published_at
        ) {
            $validated['published_at'] = now();
        }

        $berita->update($validated);

        if (isset($validated['kategori_ids'])) {
            $berita->kategoris()->sync($validated['kategori_ids']);
        }

        if (isset($validated['tag_ids'])) {
            $berita->tags()->sync($validated['tag_ids']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diupdate',
            'data'    => $berita->fresh(['user', 'kategoris', 'tags'])
        ]);
    }

    /**
     * DELETE berita
     */
    public function destroy($id): JsonResponse
    {
        $berita = Berita::findOrFail($id);

        if (!$this->canModifyBerita($berita)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You can only delete your own articles.'
            ], 403);
        }

        ImageService::delete($berita->thumbnail);
        $berita->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus'
        ]);
    }

    // =========================================================================
    //  PRIVATE HELPERS
    // =========================================================================

    /**
     * Catat view ke tabel berita_views + increment view_count.
     * Anti double-count: 1 session = 1 hit per berita.
     * Semua error ditangkap agar tidak mengganggu response utama.
     */
    private function recordView(Request $request, Berita $berita): void
    {
        try {
            $sessionKey = 'viewed_berita_' . str_replace('-', '_', $berita->id);

            if ($request->session()->has($sessionKey)) {
                return;
            }

            $request->session()->put($sessionKey, true);
            $berita->increment('view_count');

            DB::table('berita_views')->insert([
                'berita_id' => (string) $berita->id,
                'viewed_at' => now(),
            ]);

        } catch (\Exception $e) {
            // Silent fail — tidak ganggu response, tidak ganggu kategori/tag
        }
    }

    private function generateUniqueSlug(string $title, ?string $excludeId = null): string
    {
        $slug         = Str::slug($title);
        $originalSlug = $slug;
        $counter      = 1;

        $query = Berita::where('slug', $slug);
        if ($excludeId) $query->where('id', '!=', $excludeId);

        while ($query->exists()) {
            $slug    = $originalSlug . '-' . $counter;
            $counter++;
            $query   = Berita::where('slug', $slug);
            if ($excludeId) $query->where('id', '!=', $excludeId);
        }

        return $slug;
    }

    private function isAdmin(): bool
    {
        if (!auth()->check()) return false;
        return in_array(auth()->user()->role, ['super_admin', 'admin']);
    }

    private function canModifyBerita(Berita $berita): bool
    {
        if (!auth()->check()) return true;

        $user = auth()->user();
        if (in_array($user->role, ['super_admin', 'admin'])) return true;

        return (string) $berita->user_id === (string) $user->id;
    }
}