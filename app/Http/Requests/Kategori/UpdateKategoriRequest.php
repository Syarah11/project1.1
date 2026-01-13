<?php

namespace App\Http\Requests\Kategori;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kategori' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('kategoris', 'nama_kategori')->ignore($this->route('kategori'))
            ],
            'deskripsi' => 'nullable|string',
        ];
    }
}