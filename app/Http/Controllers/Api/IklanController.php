<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
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
        $validated = $request->validate([
            'name' => 'required|string',                    // ← Dari 'nama'
            'thumbnail' => 'nullable|image',
            'link' => 'nullable|url',
            'position' => 'required|in:top,bottom,sidebar', // ← Dari 'posisi'
            'priority' => 'required|integer',               // ← Dari 'urutan'
            'status' => 'required|in:active,inactive',
        ]);

        $iklan = Iklan::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'thumbnail' => $request->file('thumbnail')?->store('iklans', 'public'),
            'link' => $validated['link'] ?? null,
            'position' => $validated['position'],
            'priority' => $validated['priority'],
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Iklan berhasil ditambahkan',
            'data' => $iklan
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
            'thumbnail' => 'nullable|image',
            'link' => 'nullable|url',
            'position' => 'sometimes|in:top,bottom,sidebar',
            'priority' => 'sometimes|integer',
            'status' => 'sometimes|in:active,inactive',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('iklans', 'public');
        }

        $iklan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Iklan berhasil diupdate',
            'data' => $iklan
        ]);
    }

    public function destroy($id)
    {
        $iklan = Iklan::findOrFail($id);
        $iklan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Iklan berhasil dihapus'
        ]);
    }
}