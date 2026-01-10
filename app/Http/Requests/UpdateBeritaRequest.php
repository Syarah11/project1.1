<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBeritaRequest extends FormRequest
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
        'judul' => 'sometimes|string|max:255',
        'deskripsi' => 'sometimes|string',
        'thumbnail' => 'nullable|string',
        'status' => 'sometimes|in:draft,publish',
    ];
    }
}
