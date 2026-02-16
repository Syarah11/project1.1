<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kategori\StoreKategoriRequest;
use App\Http\Requests\Kategori\UpdateKategoriRequest;
use App\Models\Kategori;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Display a listing of kategoris
     * PUBLIC - Tanpa Auth
     */
    public function index(): JsonResponse
    {
        $kategoris = Kategori::withCount('beritas')
            ->orderBy('name', 'asc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $kategoris
        ]);
    }

    /**
     * Display kategori by ID
     * PUBLIC - Tanpa Auth
     */
    public function show($id): JsonResponse
    {
        $kategori = Kategori::with('beritas')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $kategori
        ]);
    }

    /**
     * Display kategori by SLUG (SEO Friendly)
     * PUBLIC - Tanpa Auth
     */
    public function showBySlug($slug): JsonResponse
    {
        $kategori = Kategori::with('beritas')
            ->where('slug', $slug)
            ->firstOrFail();
        
        return response()->json([
            'success' => true,
            'data' => $kategori
        ]);
    }

    /**
     * Store a new kategori
     * PROTECTED - API Key + Sanctum Token
     */
    public function store(StoreKategoriRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Generate unique slug
        $slug = $this->generateUniqueSlug($validated['name']);

        $kategori = Kategori::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $kategori
        ], 201);
    }

    /**
     * Update kategori
     * PROTECTED - API Key + Sanctum Token
     */
    public function update(UpdateKategoriRequest $request, string $id): JsonResponse
    {
        $kategori = Kategori::findOrFail($id);

        // Authorization check
        if (!$this->canModifyKategori($kategori)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can modify categories.'
            ], 403);
        }

        $validated = $request->validated();

        // Update slug jika name berubah
        if (isset($validated['name']) && $validated['name'] !== $kategori->name) {
            $validated['slug'] = $this->generateUniqueSlug($validated['name'], $id);
        }

        $kategori->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diupdate',
            'data' => $kategori->fresh()
        ]);
    }

    /**
     * Delete kategori
     * PROTECTED - API Key + Sanctum Token
     */
    public function destroy($id): JsonResponse
    {
        $kategori = Kategori::findOrFail($id);
        
        // Authorization check
        if (!$this->canModifyKategori($kategori)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can delete categories.'
            ], 403);
        }

        // Cek apakah kategori masih digunakan
        if ($kategori->beritas()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak dapat dihapus karena masih digunakan oleh berita.'
            ], 422);
        }
        
        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }

    /**
     * Generate unique slug
     */
    private function generateUniqueSlug(string $name, ?string $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;
        
        $query = Kategori::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            
            $query = Kategori::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }
        
        return $slug;
    }

    /**
     * Check if user can modify kategori
     * Hanya Super Admin & Admin yang bisa modify kategori
     */
    private function canModifyKategori(Kategori $kategori): bool
    {
        $user = auth()->user(); // Pasti ada karena route protected
        
        // Hanya Super Admin & Admin yang bisa modify kategori
        return in_array($user->role, ['super_admin', 'admin']);
    }
}