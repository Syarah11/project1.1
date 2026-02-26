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
            'name'      => 'sometimes|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link'      => 'nullable|url|max:500',
            // FIX: value harus sesuai enum di DB (slide_1x1, right_3x1, left_3x1)
            'position'  => 'sometimes|in:slide_1x1,right_3x1,left_3x1',
            'priority'  => 'sometimes|integer|min:0',
            'status'    => 'sometimes|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string'       => 'Nama harus berupa text',
            'thumbnail.image'   => 'File harus berupa gambar',
            'thumbnail.mimes'   => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'thumbnail.max'     => 'Ukuran gambar maksimal 2MB',
            'position.in'       => 'Posisi harus: slide_1x1, right_3x1, atau left_3x1',
        ];
    }
}