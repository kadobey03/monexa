<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class KycUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'document_type' => 'required|in:id_card,passport,drivers_license',
            'document_front' => 'required|image|max:5120|mimes:jpeg,png,jpg',
            'document_back' => 'nullable|image|max:5120|mimes:jpeg,png,jpg',
            'selfie' => 'required|image|max:5120|mimes:jpeg,png,jpg',
        ];
    }

    public function messages(): array
    {
        return [
            'document_type.required' => 'Document type is required',
            'document_front.required' => 'Front document image is required',
            'selfie.required' => 'Selfie image is required',
        ];
    }
}