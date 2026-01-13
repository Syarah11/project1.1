<?php

namespace App\Http\Requests\Iklan;

use Illuminate\Foundation\Http\FormRequest;

class StoreIklanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_user' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url|max:500',
            'status' => 'sometimes|in:pending,active,inactive',
            'posisi' => 'nullable|in:top,sidebar,bottom,popup',
            'urutan' => 'sometimes|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama iklan wajib diisi',
            'email.required' => 'Email wajib diisi',
            'link.url' => 'Link harus berupa URL yang valid',
        ];
    }
}