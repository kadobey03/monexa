<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AssignLeadRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'admin_id' => ['required', 'integer', 'exists:admins,id'],
            'reason' => ['nullable', 'string', 'max:500'],
            'priority' => ['nullable', 'in:low,medium,high,urgent'],
            'notify_admin' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'admin_id.required' => 'Please select an admin to assign this lead to.',
            'admin_id.integer' => 'Invalid admin ID format.',
            'admin_id.exists' => 'Selected admin does not exist.',
            'reason.max' => 'Assignment reason cannot exceed 500 characters.',
            'priority.in' => 'Priority must be one of: low, medium, high, urgent.',
            'notes.max' => 'Notes cannot exceed 1000 characters.',
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
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
                'error_code' => 'VALIDATION_FAILED'
            ], 422)
        );
    }

    /**
     * Get the validated data with defaults.
     */
    public function getValidatedData(): array
    {
        $data = $this->validated();
        
        // Set defaults
        $data['priority'] = $data['priority'] ?? 'medium';
        $data['notify_admin'] = $data['notify_admin'] ?? true;
        
        return $data;
    }
}