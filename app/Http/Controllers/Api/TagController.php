<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of tags
     * PUBLIC - Tanpa Auth
     */
    public function index(): JsonResponse
    {
        $tags = Tag::with('creator')
            ->withCount('beritas')
            ->orderBy('name', 'asc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $tags
        ]);
    }

    /**
     * Display tag by ID (UUID)
     * PUBLIC - Tanpa Auth
     */
    public function show($id): JsonResponse
    {
        $tag = Tag::with(['beritas', 'creator'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $tag
        ]);
    }

    /**
     * Display tag by SLUG (SEO Friendly)
     * PUBLIC - Tanpa Auth
     */
    public function showBySlug($slug): JsonResponse
    {
        $tag = Tag::with(['beritas', 'creator'])
            ->where('slug', $slug)
            ->firstOrFail();
        
        return response()->json([
            'success' => true,
            'data' => $tag
        ]);
    }

    /**
     * Store a new tag
     * PROTECTED - API Key + Sanctum Token
     */
    public function store(StoreTagRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Generate unique slug
        $slug = $this->generateUniqueSlug($validated['name']);

        $tag = Tag::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'created_by' => auth()->id(), // Pasti ada karena protected route
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil ditambahkan',
            'data' => $tag->fresh('creator')
        ], 201);
    }

    /**
     * Update tag
     * PROTECTED - API Key + Sanctum Token
     */
    public function update(UpdateTagRequest $request, $id): JsonResponse
    {
        $tag = Tag::findOrFail($id); // UUID compatible

        // Authorization check
        if (!$this->canModifyTag($tag)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can modify tags.'
            ], 403);
        }

        $validated = $request->validated();

        // Update slug jika name berubah
        if (isset($validated['name']) && $validated['name'] !== $tag->name) {
            $validated['slug'] = $this->generateUniqueSlug($validated['name'], $id);
        }

        $tag->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil diupdate',
            'data' => $tag->fresh('creator')
        ]);
    }

    /**
     * Delete tag
     * PROTECTED - API Key + Sanctum Token
     */
    public function destroy($id): JsonResponse
    {
        $tag = Tag::findOrFail($id); // UUID compatible
        
        // Authorization check
        if (!$this->canModifyTag($tag)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can delete tags.'
            ], 403);
        }

        // Cek apakah tag masih digunakan oleh berita
        if ($tag->beritas()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tag tidak dapat dihapus karena masih digunakan oleh berita.'
            ], 422);
        }
        
        $tag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil dihapus'
        ]);
    }

    /**
     * Generate unique slug
     * Compatible dengan UUID
     */
    private function generateUniqueSlug(string $name, ?string $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;
        
        $query = Tag::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId); // UUID compatible
        }
        
        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            
            $query = Tag::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }
        
        return $slug;
    }

    /**
     * Check if user can modify tag
     * Hanya Super Admin & Admin yang bisa modify tag
     */
    private function canModifyTag(Tag $tag): bool
    {
        $user = auth()->user(); // Pasti ada karena route protected
        
        // Hanya Super Admin & Admin yang bisa modify tag
        return in_array($user->role, ['super_admin', 'admin']);
    }
}