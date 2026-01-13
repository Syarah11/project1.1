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
            'id_user' => 'required|exists:users,id',
            'judul' => 'required|string|max:500',
            'deskripsi' => 'nullable|string',
            'gambars' => 'nullable|array',
            'gambars.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul e-jurnal wajib diisi',
            'gambars.*.image' => 'File harus berupa gambar',
        ];
    }
}