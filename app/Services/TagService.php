<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Str;

class TagService
{
    public function getAllTags($perPage = 10)
    {
        return Tag::with('creator')->paginate($perPage);
    }

    public function getTagById($id)
    {
        return Tag::with('creator')->findOrFail($id);
    }

    public function createTag(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return Tag::create($data);
    }

    public function updateTag($id, array $data)
    {
        $tag = Tag::findOrFail($id);
        
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        $tag->update($data);
        return $tag->fresh();
    }

    public function deleteTag($id)
    {
        $tag = Tag::findOrFail($id);
        return $tag->delete();
    }

    public function getTagWithBeritas($id)
    {
        return Tag::with('beritas')->findOrFail($id);
    }
}