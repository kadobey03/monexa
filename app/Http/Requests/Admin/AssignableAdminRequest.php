<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssignableAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:255',
            'only_available' => 'nullable|boolean',
            'limit' => 'nullable|integer|min:1|max:1000',
            'department' => 'nullable|string|max:100',
            'role_id' => 'nullable|exists:roles,id',
            'hierarchy_level' => 'nullable|integer|min:0|max:10',
            'include_inactive' => 'nullable|boolean',
            'with_capacity' => 'nullable|boolean',
            'format' => 'nullable|in:simple,detailed,minimal'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'search' => 'arama terimi',
            'only_available' => 'sadece müsait olanlar',
            'limit' => 'limit',
            'department' => 'departman',
            'role_id' => 'rol ID',
            'hierarchy_level' => 'hiyerarşi seviyesi',
            'include_inactive' => 'pasif olanları dahil et',
            'with_capacity' => 'kapasiteli olanlar',
            'format' => 'format'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'search.string' => 'Arama terimi metin olmalıdır.',
            'search.max' => 'Arama terimi en fazla :max karakter olmalıdır.',
            'only_available.boolean' => 'Müsaitlik durumu boolean olmalıdır.',
            'limit.integer' => 'Limit sayı olmalıdır.',
            'limit.min' => 'Limit en az :min olmalıdır.',
            'limit.max' => 'Limit en fazla :max olmalıdır.',
            'department.string' => 'Departman metin olmalıdır.',
            'department.max' => 'Departman en fazla :max karakter olmalıdır.',
            'role_id.exists' => 'Seçilen rol geçerli değildir.',
            'hierarchy_level.integer' => 'Hiyerarşi seviyesi sayı olmalıdır.',
            'hierarchy_level.min' => 'Hiyerarşi seviyesi en az :min olmalıdır.',
            'hierarchy_level.max' => 'Hiyerarşi seviyesi en fazla :max olmalıdır.',
            'include_inactive.boolean' => 'Pasif dahil etme durumu boolean olmalıdır.',
            'with_capacity.boolean' => 'Kapasite durumu boolean olmalıdır.',
            'format.in' => 'Format :values değerlerinden biri olmalıdır.'
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation hatası',
                'error_code' => 'VALIDATION_FAILED',
                'errors' => $validator->errors(),
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'endpoint' => $this->path(),
                    'method' => $this->method()
                ]
            ], 422)
        );
    }

    /**
     * Get the validated data from the request with default values.
     */
    public function getValidatedData(): array
    {
        $validated = $this->validated();
        
        return array_merge([
            'search' => null,
            'only_available' => false,
            'limit' => null,
            'department' => null,
            'role_id' => null,
            'hierarchy_level' => null,
            'include_inactive' => false,
            'with_capacity' => false,
            'format' => 'detailed'
        ], $validated);
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'only_available' => $this->boolean('only_available'),
            'include_inactive' => $this->boolean('include_inactive'),
            'with_capacity' => $this->boolean('with_capacity')
        ]);
    }
}