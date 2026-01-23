<?php

namespace App\Http\Requests\Ejurnal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEjurnalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:500',
            'description' => 'sometimes|string',
           'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'sometimes|in:published,draft',
        ];
    }
}