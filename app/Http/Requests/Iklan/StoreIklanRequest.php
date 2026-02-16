<?php

namespace App\Http\Requests\Iklan;

use Illuminate\Foundation\Http\FormRequest;

class StoreIklanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2000',
            'link' => 'nullable|url|max:500',
            'position' => 'required|in:top,bottom,sidebar',
            'priority' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama iklan wajib diisi',
            'thumbnail.required' => 'Thumbnail wajib diupload',
            'thumbnail.image' => 'File harus berupa gambar',
            'thumbnail.max' => 'Ukuran gambar maksimal 2mb',
            'position.required' => 'Posisi iklan wajib dipilih',
            'position.in' => 'Posisi harus: top, bottom, atau sidebar',
            'priority.required' => 'Priority wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ];
    }
}