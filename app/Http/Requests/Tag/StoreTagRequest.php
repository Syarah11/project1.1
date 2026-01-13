<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_tag' => 'required|string|max:255|unique:tags,nama_tag',
            'created_by' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_tag.required' => 'Nama tag wajib diisi',
            'nama_tag.unique' => 'Nama tag sudah ada',
            'created_by.exists' => 'User tidak ditemukan',
        ];
    }
}