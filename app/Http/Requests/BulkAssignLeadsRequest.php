<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BulkAssignLeadsRequest extends FormRequest
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
            'lead_ids' => ['required', 'array', 'min:1', 'max:100'],
            'lead_ids.*' => ['required', 'integer', 'exists:users,id'],
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
            'lead_ids.required' => 'Please select at least one lead to assign.',
            'lead_ids.array' => 'Invalid lead selection format.',
            'lead_ids.min' => 'Please select at least one lead to assign.',
            'lead_ids.max' => 'Cannot assign more than 100 leads at once.',
            'lead_ids.*.required' => 'Each lead ID is required.',
            'lead_ids.*.integer' => 'Invalid lead ID format.',
            'lead_ids.*.exists' => 'One or more selected leads do not exist.',
            'admin_id.required' => 'Please select an admin to assign leads to.',
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
                'message' => 'Bulk assignment validation failed.',
                'errors' => $validator->errors(),
                'error_code' => 'BULK_VALIDATION_FAILED'
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

    /**
     * Get unique lead IDs to prevent duplicates
     */
    public function getUniqueLeadIds(): array
    {
        return array_unique($this->input('lead_ids', []));
    }
}