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
            'title' => 'sometimes|string|max:500',
            'description' => 'nullable|string',
            'gambars' => 'nullable|array',
            'gambars.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}