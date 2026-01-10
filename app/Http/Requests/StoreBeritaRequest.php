<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeritaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
        'id_user' => 'required|exists:users,id_user',
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'thumbnail' => 'nullable|string',
        'status' => 'required|in:draft,publish',
    ];
    }
}

