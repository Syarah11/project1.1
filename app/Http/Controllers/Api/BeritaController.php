<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Berita\StoreBeritaRequest;
use App\Http\Requests\Berita\UpdateBeritaRequest;
use App\Models\Berita;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * PUBLIC: List berita published
     */
    public function index(): JsonResponse
    {
        $beritas = Berita::with(['user', 'kategoris', 'tags'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $beritas,
            'media' => env('MEDIA')
        ]);
    }

    /**
     * PUBLIC: Show berita by ID (published only)
     */
    public function show($id): JsonResponse
    {
        $berita = Berita::with(['user', 'kategoris', 'tags'])
            ->where('status', 'published')
            ->findOrFail($id);

        $berita->increment('view_count');

        return response()->json([
            'success' => true,
            'data' => $berita
        ]);
    }

    /**
     * PUBLIC: Show berita by slug (SEO friendly)
     */
    public function showBySlug($slug): JsonResponse
    {
        $berita = Berita::with(['user', 'kategoris', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $berita->increment('view_count');

        return response()->json([
            'success' => true,
            'data' => $berita
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
            'data' => $beritas,
            'media' => env('MEDIA')
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

        $slug = $this->generateUniqueSlug($validated['title']);

        $berita = Berita::create([
            'user_id' => auth()->id() ?? 1,
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'thumbnail' => $thumbnailPath,
            'status' => $validated['status'], // draft / published
            'published_at' => $validated['status'] === 'published' ? now() : null
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
            'data' => $berita->fresh(['user', 'kategoris', 'tags'])
        ], 201);
    }

    /**
     * UPDATE: Edit berita + publish draft
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

        if (isset($validated['status']) && $validated['status'] === 'published' && !$berita->published_at) {
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
            'data' => $berita->fresh(['user', 'kategoris', 'tags'])
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

    /**
     * Generate unique slug
     */
    private function generateUniqueSlug(string $title, ?string $excludeId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        $query = Berita::where('slug', $slug);
        if ($excludeId) $query->where('id', '!=', $excludeId);

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            $query = Berita::where('slug', $slug);
            if ($excludeId) $query->where('id', '!=', $excludeId);
        }

        return $slug;
    }

    /**
     * Check if user can modify berita
     */
    private function canModifyBerita(Berita $berita): bool
    {
        if (!auth()->check()) return true;

        $user = auth()->user();
        if (in_array($user->role, ['super_admin', 'admin'])) return true;

        return $berita->user_id === $user->id;
    }
}
