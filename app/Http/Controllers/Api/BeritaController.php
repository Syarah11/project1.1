<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::with(['user', 'kategoris', 'tags'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $beritas
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:500',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:published,draft',
            'kategori_ids' => 'nullable|array',
            'kategori_ids.*' => 'exists:kategoris,id',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
        ]);

        // Handle thumbnail upload
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('beritas', 'public');
        }

        $berita = Berita::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'thumbnail' => $thumbnailPath,
            'status' => $validated['status'],
        ]);

        // Attach kategoris
        if (!empty($validated['kategori_ids'])) {
            $berita->kategoris()->attach($validated['kategori_ids']);
        }

        // Attach tags
        if (!empty($validated['tag_ids'])) {
            $berita->tags()->attach($validated['tag_ids']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil ditambahkan',
            'data' => $berita->load(['user', 'kategoris', 'tags'])
        ], 201);
    }

    public function show($id)
    {
        $berita = Berita::with(['user', 'kategoris', 'tags'])->findOrFail($id);
        
        // Increment view count
        $berita->increment('view_count');

        return response()->json([
            'success' => true,
            'data' => $berita
        ]);
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:500',
            'description' => 'sometimes|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'sometimes|in:published,draft',
            'kategori_ids' => 'nullable|array',
            'kategori_ids.*' => 'exists:kategoris,id',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($berita->thumbnail) {
                Storage::disk('public')->delete($berita->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('beritas', 'public');
        }

        $berita->update($validated);

        // Sync kategoris
        if (isset($validated['kategori_ids'])) {
            $berita->kategoris()->sync($validated['kategori_ids']);
        }

        // Sync tags
        if (isset($validated['tag_ids'])) {
            $berita->tags()->sync($validated['tag_ids']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diupdate',
            'data' => $berita->load(['user', 'kategoris', 'tags'])
        ]);
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        
        // Delete thumbnail
        if ($berita->thumbnail) {
            Storage::disk('public')->delete($berita->thumbnail);
        }
        
        $berita->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus'
        ]);
    }
}