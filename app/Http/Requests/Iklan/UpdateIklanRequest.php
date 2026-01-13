<?php

namespace App\Http\Requests\Iklan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIklanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url|max:500',
            'status' => 'sometimes|in:pending,active,inactive',
            'posisi' => 'nullable|in:top,sidebar,bottom,popup',
            'urutan' => 'sometimes|integer|min:0',
        ];
    }
}