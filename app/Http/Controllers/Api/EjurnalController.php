<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ejurnal\StoreEjurnalRequest;
use App\Http\Requests\Ejurnal\UpdateEjurnalRequest;
use App\Models\Ejurnal;
use App\Models\GambarEjurnal;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EjurnalController extends Controller
{
    /**
     * Display a listing of ejurnals
     * PUBLIC - Tanpa Auth
     */
    public function index(): JsonResponse
    {
        try {
            // Hanya tampilkan yang published untuk public
            $ejurnals = Ejurnal::with(['user', 'gambarEjurnals'])
                ->where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $ejurnals,
                'media' => env('MEDIA')
            ]);
        } catch (\Exception $e) {
            Log::error('Get Ejurnals Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data e-jurnal',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Display ejurnal by ID (UUID)
     * PUBLIC - Tanpa Auth
     */
    public function show($id): JsonResponse
    {
        try {
            $ejurnal = Ejurnal::with(['user', 'gambarEjurnals'])
                ->where('status', 'published')
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $ejurnal
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'E-jurnal tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Show Ejurnal Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data e-jurnal',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Display ejurnal by SLUG (SEO Friendly)
     * PUBLIC - Tanpa Auth
     */
    public function showBySlug($slug): JsonResponse
    {
        try {
            $ejurnal = Ejurnal::with(['user', 'gambarEjurnals'])
                ->where('slug', $slug)
                ->where('status', 'published')
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $ejurnal
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'E-jurnal tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Show Ejurnal by Slug Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data e-jurnal',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Store a new ejurnal
     * PROTECTED - API Key + Token + Role (Admin/Super Admin only)
     */
    public function store(StoreEjurnalRequest $request): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $validated = $request->validated();

            // Generate unique slug
            $slug = $this->generateUniqueSlug($validated['title']);

            // Upload thumbnail (jika ada)
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = ImageService::upload(
                    $request->file('thumbnail'),
                    'ejurnals/thumbnails',
                    300
                );
            }

            // Create ejurnal
            $ejurnal = Ejurnal::create([
                'user_id' => auth()->id(),
                'title' => $validated['title'],
                'slug' => $slug,
                'description' => $validated['description'] ?? null,
                'thumbnail' => $thumbnailPath,
                'status' => $validated['status'] ?? 'published',
            ]);

            // Upload gambar-gambar ejurnal (jika ada)
            if ($request->hasFile('gambar_ejurnals')) {
                foreach ($request->file('gambar_ejurnals') as $gambar) {
                    $gambarPath = ImageService::upload(
                        $gambar,
                        'ejurnals/galeri',
                        800
                    );

                    GambarEjurnal::create([
                        'ejurnal_id' => $ejurnal->id,
                        'user_id' => auth()->id(),
                        'image' => $gambarPath,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'E-jurnal berhasil ditambahkan',
                'data' => $ejurnal->fresh(['user', 'gambarEjurnals'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Hapus file yang sudah diupload jika terjadi error
            if (isset($thumbnailPath)) {
                ImageService::delete($thumbnailPath);
            }
            
            Log::error('Store Ejurnal Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan e-jurnal',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Update ejurnal
     * PROTECTED - API Key + Token + Role (Admin/Super Admin only)
     */
    public function update(UpdateEjurnalRequest $request, $id): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $ejurnal = Ejurnal::findOrFail($id);

            // Authorization check (hanya admin/super_admin yang bisa)
            if (!$this->canModifyEjurnal()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Only admin can modify e-journals.'
                ], 403);
            }

            $validated = $request->validated();

            // Jika tidak ada data yang dikirim
            if (empty($validated) && !$request->hasFile('thumbnail') && !$request->hasFile('gambar_ejurnals')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data provided for update'
                ], 422);
            }

            // Update slug jika title berubah
            if (isset($validated['title']) && $validated['title'] !== $ejurnal->title) {
                $validated['slug'] = $this->generateUniqueSlug($validated['title'], $id);
            }

            // Handle thumbnail
            if ($request->hasFile('thumbnail')) {
                // Hapus thumbnail lama
                if ($ejurnal->thumbnail) {
                    ImageService::delete($ejurnal->thumbnail);
                }
                
                // Upload thumbnail baru
                $validated['thumbnail'] = ImageService::upload(
                    $request->file('thumbnail'),
                    'ejurnals/thumbnails',
                    300
                );
            }

            // Update data ejurnal
            $ejurnal->update($validated);

            // Upload gambar-gambar baru (jika ada)
            if ($request->hasFile('gambar_ejurnals')) {
                foreach ($request->file('gambar_ejurnals') as $gambar) {
                    $gambarPath = ImageService::upload(
                        $gambar,
                        'ejurnals/galeri',
                        800
                    );

                    GambarEjurnal::create([
                        'ejurnal_id' => $ejurnal->id,
                        'user_id' => auth()->id(),
                        'image' => $gambarPath,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'E-jurnal berhasil diupdate',
                'data' => $ejurnal->fresh(['user', 'gambarEjurnals'])
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'E-jurnal tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Update Ejurnal Error: ' . $e->getMessage(), [
                'ejurnal_id' => $id,
                'request_data' => $request->except(['thumbnail', 'gambar_ejurnals']),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat update e-jurnal',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Delete ejurnal
     * PROTECTED - API Key + Token + Role (Admin/Super Admin only)
     */
    public function destroy($id): JsonResponse
    {
        DB::beginTransaction();
        
        try {
            $ejurnal = Ejurnal::findOrFail($id);
            
            // Authorization check
            if (!$this->canModifyEjurnal()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Only admin can delete e-journals.'
                ], 403);
            }
            
            // Hapus thumbnail
            if ($ejurnal->thumbnail) {
                ImageService::delete($ejurnal->thumbnail);
            }
            
            // Hapus semua gambar terkait
            if ($ejurnal->gambarEjurnals->count() > 0) {
                foreach ($ejurnal->gambarEjurnals as $gambar) {
                    ImageService::delete($gambar->image);
                    $gambar->delete();
                }
            }
            
            // Hapus ejurnal
            $ejurnal->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'E-jurnal berhasil dihapus'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'E-jurnal tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Delete Ejurnal Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus e-jurnal',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Delete gambar ejurnal saja (tanpa hapus ejurnal)
     * PROTECTED - API Key + Token + Role (Admin/Super Admin only)
     */
    public function deleteGambar($id): JsonResponse
    {
        try {
            $gambar = GambarEjurnal::findOrFail($id);
            
            // Authorization check
            if (!$this->canModifyEjurnal()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Only admin can delete images.'
                ], 403);
            }
            
            // Hapus file gambar
            ImageService::delete($gambar->image);
            
            // Hapus record dari database
            $gambar->delete();

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gambar tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            Log::error('Delete Gambar Ejurnal Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus gambar',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Generate unique slug
     * Compatible dengan UUID
     */
    private function generateUniqueSlug(string $title, ?string $excludeId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;
        
        $query = Ejurnal::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            
            $query = Ejurnal::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }
        
        return $slug;
    }

    /**
     * Check if user can modify ejurnal
     * Hanya Super Admin & Admin yang bisa modify ejurnal
     */
    private function canModifyEjurnal(): bool
    {
        $user = auth()->user();
        
        if (!$user) {
            return false;
        }
        
        // Hanya Super Admin & Admin yang bisa modify ejurnal
        return in_array($user->role, ['super_admin', 'admin']);
    }
}