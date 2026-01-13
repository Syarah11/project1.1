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
        return [
            'nama_tag' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('tags', 'nama_tag')->ignore($this->route('tag'))
            ],
        ];
    }
}