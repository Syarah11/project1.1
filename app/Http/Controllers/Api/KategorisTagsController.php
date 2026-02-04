<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class KategorisTagsController extends Controller
{
    /**
     * Get all categories and tags in one response
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Ambil semua kategori, diurutkan berdasarkan nama
            $kategoris = Kategori::select('id', 'name', 'slug', 'description', 'created_at')
                ->orderBy('name', 'asc')
                ->get();

            // Ambil semua tag dengan relasi creator, diurutkan berdasarkan nama
            $tags = Tag::with('creator:id,name')
                ->select('id', 'name', 'slug', 'created_by', 'created_at')
                ->orderBy('name', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Kategoris and tags retrieved successfully',
                'data' => [
                    'Kategoris' => $kategoris,
                    'tags' => $tags
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}