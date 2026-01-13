<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Iklan\StoreIklanRequest;
use App\Http\Requests\Iklan\UpdateIklanRequest;
use App\Services\IklanService;
use Illuminate\Http\Request;

class IklanController extends Controller
{
    protected $iklanService;

    public function __construct(IklanService $iklanService)
    {
        $this->iklanService = $iklanService;
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $filters = [
                'status' => $request->input('status'),
                'posisi' => $request->input('posisi'),
            ];

            $iklans = $this->iklanService->getAllIklans($perPage, $filters);

            return response()->json([
                'success' => true,
                'data' => $iklans
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch ads',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(StoreIklanRequest $request)
    {
        try {
            $iklan = $this->iklanService->createIklan($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Ad created successfully',
                'data' => $iklan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create ad',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $iklan = $this->iklanService->getIklanById($id);

            return response()->json([
                'success' => true,
                'data' => $iklan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ad not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(UpdateIklanRequest $request, $id)
    {
        try {
            $iklan = $this->iklanService->updateIklan($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Ad updated successfully',
                'data' => $iklan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update ad',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->iklanService->deleteIklan($id);

            return response()->json([
                'success' => true,
                'message' => 'Ad deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete ad',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function active(Request $request)
    {
        try {
            $posisi = $request->input('posisi');
            $iklans = $this->iklanService->getActiveIklans($posisi);

            return response()->json([
                'success' => true,
                'data' => $iklans
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch active ads',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}