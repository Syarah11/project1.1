<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
use App\Services\ImageService;
use Illuminate\Http\Request;

class IklanController extends Controller
{
    public function index()
    {
        $iklans = Iklan::with('user')->orderBy('priority')->get();
        
        return response()->json([
            'success' => true,
            'data' => $iklans
        ]);
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated. Please login first.'
            ], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'link' => 'nullable|url',
            'position' => 'required|in:top,bottom,sidebar',
            'priority' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        // Upload thumbnail dengan ImageService
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = ImageService::upload(
                $request->file('thumbnail'),
                'iklans',
                300 // Max 300KB
            );
        }

        $iklan = Iklan::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'thumbnail' => $thumbnailPath,
            'link' => $validated['link'] ?? null,
            'position' => $validated['position'],
            'priority' => $validated['priority'],
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Iklan berhasil ditambahkan',
            'data' => $iklan->load('user')
        ], 201);
    }

    public function show($id)
    {
        $iklan = Iklan::with('user')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $iklan
        ]);
    }

    public function update(Request $request, $id)
    {
        $iklan = Iklan::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'link' => 'nullable|url',
            'position' => 'sometimes|in:top,bottom,sidebar',
            'priority' => 'sometimes|integer',
            'status' => 'sometimes|in:active,inactive',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama
            ImageService::delete($iklan->thumbnail);
            
            // Upload gambar baru
            $validated['thumbnail'] = ImageService::upload(
                $request->file('thumbnail'),
                'iklans',
                300
            );
        }

        $iklan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Iklan berhasil diupdate',
            'data' => $iklan->load('user')
        ]);
    }

    public function destroy($id)
    {
        $iklan = Iklan::findOrFail($id);
        
        // Hapus thumbnail
        ImageService::delete($iklan->thumbnail);
        
        $iklan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Iklan berhasil dihapus'
        ]);
    }
}