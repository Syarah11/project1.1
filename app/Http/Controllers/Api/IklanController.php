<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Iklan\StoreIklanRequest;
use App\Http\Requests\Iklan\UpdateIklanRequest;
use App\Models\Iklan;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;

class IklanController extends Controller
{
    /**
     * Display a listing of iklans
     * PUBLIC - Tanpa Auth (Tidak perlu API Key & Sanctum)
     */
    public function index(): JsonResponse
    {
        $iklans = Iklan::with('user')
            ->where('status', 'active')
            ->orderBy('priority', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $iklans,
            'media' => env('MEDIA')
        ]);
    }

    /**
     * Display iklan by ID
     * PUBLIC - Tanpa Auth (Tidak perlu API Key & Sanctum)
     */
    public function show($id): JsonResponse
    {
        $iklan = Iklan::with('user')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $iklan
        ]);
    }

    /**
     * Store a new iklan
     * PROTECTED - Perlu API Key & Sanctum Token
     */
    public function store(StoreIklanRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Upload thumbnail (WAJIB untuk iklan)
        $thumbnailPath = ImageService::upload(
            $request->file('thumbnail'),
            'iklans',
            300
        );

        $iklan = Iklan::create([
            'user_id' => auth()->id(), // Pasti ada karena sudah auth
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
            'data' => $iklan->fresh('user')
        ], 201);
    }

    /**
     * Update iklan
     * PROTECTED - Perlu API Key & Sanctum Token
     */
    public function update(UpdateIklanRequest $request, $id): JsonResponse
    {
        $iklan = Iklan::findOrFail($id);

        // Authorization check (user harus login karena protected route)
        if (!$this->canModifyIklan($iklan)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You can only edit your own ads.'
            ], 403);
        }

        $validated = $request->validated();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {

            ImageService::delete($iklan->thumbnail);
    
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
            'data' => $iklan->fresh('user')
        ]);
    }

    /**
     * Delete iklan
     * PROTECTED - Perlu API Key & Sanctum Token
     */
    public function destroy($id): JsonResponse
    {
        $iklan = Iklan::findOrFail($id);
        
        // Authorization check (user harus login karena protected route)
        if (!$this->canModifyIklan($iklan)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. You can only delete your own ads.'
            ], 403);
        }
        
        ImageService::delete($iklan->thumbnail);

        $iklan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Iklan berhasil dihapus'
        ]);
    }

    /**
     * Check if user can modify iklan
     * Hanya dipanggil di protected routes (store, update, destroy)
     */
    private function canModifyIklan(Iklan $iklan): bool
    {
        $user = auth()->user(); // Pasti ada karena route protected
        
        // Super Admin & Admin bisa modify semua
        if (in_array($user->role, ['super_admin', 'admin'])) {
            return true;
        }
        
        // User hanya bisa modify miliknya sendiri
        return $iklan->user_id === $user->id;
    }
}