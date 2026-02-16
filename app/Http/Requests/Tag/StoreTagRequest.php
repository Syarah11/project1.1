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
            'name' => 'required|string|max:100|unique:tags,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tag wajib diisi',
            'name.unique' => 'Nama tag sudah digunakan',
            'name.max' => 'Nama tag maksimal 100 karakter',
        ];
    }
}