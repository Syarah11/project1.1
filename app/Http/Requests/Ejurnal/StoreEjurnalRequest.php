<?php

namespace App\Http\Requests\Ejurnal;

use Illuminate\Foundation\Http\FormRequest;

class StoreEjurnalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:500',
            'description' => 'nullable|string',
            'gambars' => 'nullable|array',
            'gambars.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul e-jurnal wajib diisi',
            'gambars.*.image' => 'File harus berupa gambar',
        ];
    }
}