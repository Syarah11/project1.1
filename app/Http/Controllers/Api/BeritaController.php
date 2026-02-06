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
     * Display a listing of beritas
     * PUBLIC - Tanpa Auth
     */
    public function index(): JsonResponse
    {
        $beritas = Berita::with(['user', 'kategoris', 'tags'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $beritas
        ]);
    }

    /**
     * Display berita by ID
     * PUBLIC - Tanpa Auth
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
     * Display berita by SLUG (SEO Friendly)
     * PUBLIC - Tanpa Auth
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
     * Store a new berita
     * PROTECTED - API Key (Mode 1) atau API Key + Token (Mode 2)
     */
    public function store(StoreBeritaRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Upload thumbnail
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = ImageService::upload(
                $request->file('thumbnail'),
                'beritas',
                300
            );
        }

        // Generate unique slug
        $slug = $this->generateUniqueSlug($validated['title']);

        $berita = Berita::create([
            'user_id' => auth()->id() ?? 1,
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'thumbnail' => $thumbnailPath,
            'status' => $validated['status'],
        ]);

        // Attach kategoris dan tags
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
     * Update berita
     * PROTECTED - API Key (Mode 1) atau API Key + Token (Mode 2)
     */
    public function update(UpdateBeritaRequest $request, $id): JsonResponse
    {
        $berita = Berita::findOrFail($id);

        // Authorization check
        if (!$this->canModifyBerita($berita)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You can only edit your own articles.'
            ], 403);
        }

        $validated = $request->validated();

        // Update slug jika title berubah
        if (isset($validated['title']) && $validated['title'] !== $berita->title) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $id);
        }

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            ImageService::delete($berita->thumbnail);
            $validated['thumbnail'] = ImageService::upload(
                $request->file('thumbnail'),
                'beritas',
                300
            );
        }

        $berita->update($validated);

        // Sync relations
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
     * Delete berita
     * PROTECTED - API Key (Mode 1) atau API Key + Token (Mode 2)
     */
    public function destroy($id): JsonResponse
    {
        $berita = Berita::findOrFail($id);
        
        // Authorization check
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
    private function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;
        
        $query = Berita::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            
            $query = Berita::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }
        
        return $slug;
    }

    /**
     * Check if user can modify berita
     */
    private function canModifyBerita(Berita $berita): bool
    {
        // Mode 1: Tidak ada auth, izinkan semua
        if (!auth()->check()) {
            return true;
        }

        $user = auth()->user();
        
        // Super Admin & Admin bisa modify semua
        if (in_array($user->role, ['super_admin', 'admin'])) {
            return true;
        }
        
        // User hanya bisa modify miliknya sendiri
        return $berita->user_id === $user->id;
    }
}