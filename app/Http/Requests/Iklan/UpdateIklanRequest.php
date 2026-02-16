<?php

namespace App\Http\Requests\Iklan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIklanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:600',
            'link' => 'nullable|url|max:500',
            'position' => 'sometimes|in:top,bottom,sidebar',
            'priority' => 'sometimes|integer|min:0',
            'status' => 'sometimes|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Nama harus berupa text',
            'thumbnail.image' => 'File harus berupa gambar',
            'thumbnail.max' => 'Ukuran gambar maksimal 600',
            'position.in' => 'Posisi harus: top, bottom, atau sidebar',
        ];
    }
}