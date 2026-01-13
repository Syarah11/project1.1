<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ejurnal\StoreEjurnalRequest;
use App\Http\Requests\Ejurnal\UpdateEjurnalRequest;
use App\Services\EjurnalService;
use Illuminate\Http\Request;

class EjurnalController extends Controller
{
    protected $ejurnalService;

    public function __construct(EjurnalService $ejurnalService)
    {
        $this->ejurnalService = $ejurnalService;
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $ejurnals = $this->ejurnalService->getAllEjurnals($perPage);

            return response()->json([
                'success' => true,
                'data' => $ejurnals
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch e-journals',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(StoreEjurnalRequest $request)
    {
        try {
            $ejurnal = $this->ejurnalService->createEjurnal($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'E-journal created successfully',
                'data' => $ejurnal
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create e-journal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $ejurnal = $this->ejurnalService->getEjurnalById($id);

            return response()->json([
                'success' => true,
                'data' => $ejurnal
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'E-journal not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(UpdateEjurnalRequest $request, $id)
    {
        try {
            $ejurnal = $this->ejurnalService->updateEjurnal($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'E-journal updated successfully',
                'data' => $ejurnal
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update e-journal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->ejurnalService->deleteEjurnal($id);

            return response()->json([
                'success' => true,
                'message' => 'E-journal deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete e-journal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteGambar($id)
    {
        try {
            $this->ejurnalService->deleteGambarEjurnal($id);

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}