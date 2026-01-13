<?php

namespace App\Http\Requests\Ejurnal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEjurnalRequest extends FormRequest
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
            'gambars' => 'nullable|array',
            'gambars.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}