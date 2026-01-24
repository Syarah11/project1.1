<?php

namespace App\Http\Requests\Berita;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeritaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_user' => 'required|exists:users,id',
            'judul' => 'required|string|max:500',
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'sometimes|in:draft,published,archived',
            'kategori_ids' => 'nullable|array',
            'kategori_ids.*' => 'exists:kategoris,id_kategori',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id_tag',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul berita wajib diisi',
            'id_user.exists' => 'User tidak ditemukan',
            'kategori_ids.*.exists' => 'Kategori tidak valid',
            'tag_ids.*.exists' => 'Tag tidak valid',
        ];

    }
}
