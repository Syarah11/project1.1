<?php

namespace App\Http\Requests\Berita;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBeritaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'sometimes|string|max:500',
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'sometimes|in:draft,published,archived',
            'kategori_ids' => 'nullable|array',
            'kategori_ids.*' => 'exists:kategoris,id_kategori',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id_tag',
        ];
        
    }
}