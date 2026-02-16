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
            'title' => 'required|string|max:500',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2000',
            'status' => 'required|in:published,draft',
            'kategori_ids' => 'nullable|array',
            'kategori_ids.*' => 'exists:kategoris,id',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul berita wajib diisi',
            'title.max' => 'Judul berita maksimal 500 karakter',
            'description.required' => 'Deskripsi berita wajib diisi',
            'thumbnail.image' => 'File harus berupa gambar',
            'thumbnail.mimes' => 'Format gambar harus: jpeg, png, jpg, gif, atau webp',
            'thumbnail.max' => 'Ukuran gambar maksimal 2MB',
            'status.required' => 'Status berita wajib dipilih',
            'status.in' => 'Status harus published atau draft',
            'kategori_ids.array' => 'Kategori harus berupa array',
            'kategori_ids.*.exists' => 'Kategori yang dipilih tidak valid',
            'tag_ids.array' => 'Tag harus berupa array',
            'tag_ids.*.exists' => 'Tag yang dipilih tidak valid',
        ];
    }

    /**
     * Prepare data for validation
     */
    protected function prepareForValidation(): void
    {
        // Convert string to array if needed (for form-data)
        if ($this->has('kategori_ids') && is_string($this->kategori_ids)) {
            $this->merge([
                'kategori_ids' => json_decode($this->kategori_ids, true) ?? []
            ]);
        }

        if ($this->has('tag_ids') && is_string($this->tag_ids)) {
            $this->merge([
                'tag_ids' => json_decode($this->tag_ids, true) ?? []
            ]);
        }
    }
}