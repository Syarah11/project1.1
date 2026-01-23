<?php

namespace App\Http\Requests\Ejurnal;

use Illuminate\Foundation\Http\FormRequest;

class StoreEjurnalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:500',
            'description' => 'required|string',
          'thumbnail'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'required|in:published,draft',
        ];
    }
}