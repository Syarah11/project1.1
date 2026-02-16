<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Untuk UUID, gunakan route parameter 'id'
        $tagId = $this->route('id');
        
        return [
            'name' => [
                'sometimes',
                'string',
                'max:100',
                Rule::unique('tags', 'name')->ignore($tagId) // UUID compatible
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Nama tag sudah digunakan',
            'name.max' => 'Nama tag maksimal 100 karakter',
        ];
    }
}