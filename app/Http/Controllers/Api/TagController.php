<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $tags = $this->tagService->getAllTags($perPage);

            return response()->json([
                'success' => true,
                'data' => $tags
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch tags',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(StoreTagRequest $request)
    {
        try {
            $tag = $this->tagService->createTag($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Tag created successfully',
                'data' => $tag
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create tag',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $tag = $this->tagService->getTagById($id);

            return response()->json([
                'success' => true,
                'data' => $tag
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tag not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function update(UpdateTagRequest $request, $id)
    {
        try {
            $tag = $this->tagService->updateTag($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Tag updated successfully',
                'data' => $tag
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update tag',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->tagService->deleteTag($id);

            return response()->json([
                'success' => true,
                'message' => 'Tag deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete tag',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function withBeritas($id)
    {
        try {
            $tag = $this->tagService->getTagWithBeritas($id);

            return response()->json([
                'success' => true,
                'data' => $tag
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tag not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}