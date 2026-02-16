<?php

namespace App\Http\Requests\Ejurnal;

use Illuminate\Foundation\Http\FormRequest;

class StoreEjurnalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:500',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2000',
            'status' => 'nullable|in:published,draft',
            
            // ✅ Upload multiple gambar ejurnal
            'gambar_ejurnals' => 'nullable|array',
            'gambar_ejurnals.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2000',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul e-jurnal wajib diisi.',
            'title.max' => 'Judul e-jurnal maksimal 500 karakter.',
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Thumbnail harus berformat: jpeg, png, jpg, gif, atau webp.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
            'status.in' => 'Status harus published atau draft.',
            'gambar_ejurnals.array' => 'Gambar ejurnal harus berupa array.',
            'gambar_ejurnals.*.image' => 'Setiap file harus berupa gambar.',
            'gambar_ejurnals.*.mimes' => 'Gambar harus berformat: jpeg, png, jpg, gif, atau webp.',
            'gambar_ejurnals.*.max' => 'Ukuran setiap gambar maksimal 2mb.',
        ];
    }

    /**
     * Prepare data for validation
     */
    protected function prepareForValidation(): void
    {
        // Trim title jika ada
        if ($this->has('title')) {
            $this->merge([
                'title' => trim($this->input('title'))
            ]);
        }
    }
}