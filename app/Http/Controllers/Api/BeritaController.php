<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Berita\StoreBeritaRequest;
use App\Http\Requests\Berita\UpdateBeritaRequest;
use App\Services\BeritaService;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    protected $beritaService;

    public function __construct(BeritaService $beritaService)
    {
        $this->beritaService = $beritaService;
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $filters = [
                'status' => $request->input('status'),
                'search' => $request->input('search'),
            ];

            $beritas = $this->beritaService->getAllBeritas($perPage, $filters);

            return response()->json([
                'success' => true,
                'data' => $beritas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch news',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(StoreBeritaRequest $request)
    {
        try {
            $berita = $this->beritaService->createBerita($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'News created successfully',
                'data' => $berita
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create news',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $berita = $this->beritaService->getBeritaById($id);

            return response()->json([
                'success' => true,
                'data' => $berita
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'News not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function showBySlug($slug)
    {
        try {
            $berita = $this->beritaService->getBeritaBySlug($slug);

            return response()->json([
                'success' => true,
                'data' => $berita
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'News not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(UpdateBeritaRequest $request, $id)
    {
        try {
            $berita = $this->beritaService->updateBerita($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'News updated successfully',
                'data' => $berita
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update news',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->beritaService->deleteBerita($id);

            return response()->json([
                'success' => true,
                'message' => 'News deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete news',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function published(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $beritas = $this->beritaService->getPublishedBeritas($perPage);

            return response()->json([
                'success' => true,
                'data' => $beritas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch published news',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function popular(Request $request)
    {
        try {
            $limit = $request->input('limit', 5);
            $beritas = $this->beritaService->getPopularBeritas($limit);

            return response()->json([
                'success' => true,
                'data' => $beritas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch popular news',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}