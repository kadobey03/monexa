<?php

namespace App\Http\Requests\Admin\Lead;

use Illuminate\Foundation\Http\FormRequest;

class BulkLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'action' => 'required|string|in:delete,assign,update_status,update_priority',
            'lead_ids' => 'required|array|min:1|max:100',
            'lead_ids.*' => 'integer|exists:users,id',
            'options' => 'sometimes|array',
            'options.assign_to' => 'required_if:action,assign|integer|exists:admins,id',
            'options.status_id' => 'required_if:action,update_status|integer|exists:lead_statuses,id',
            'options.priority' => 'required_if:action,update_priority|string|in:low,medium,high,urgent',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'action.required' => 'Action is required.',
            'action.in' => 'Invalid action specified.',
            'lead_ids.required' => 'At least one lead must be selected.',
            'lead_ids.max' => 'Cannot process more than 100 leads at once.',
            'lead_ids.*.exists' => 'One or more selected leads do not exist.',
            'options.assign_to.required_if' => 'Admin assignment is required for assign action.',
            'options.assign_to.exists' => 'Selected admin does not exist.',
            'options.status_id.required_if' => 'Status is required for update status action.',
            'options.status_id.exists' => 'Selected status does not exist.',
            'options.priority.required_if' => 'Priority is required for update priority action.',
            'options.priority.in' => 'Priority must be low, medium, high, or urgent.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'action' => 'bulk action',
            'lead_ids' => 'selected leads',
            'options.assign_to' => 'assigned admin',
            'options.status_id' => 'lead status',
            'options.priority' => 'priority level',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Custom validation logic
            $action = $this->input('action');
            $options = $this->input('options', []);

            switch ($action) {
                case 'assign':
                    if (!isset($options['assign_to'])) {
                        $validator->errors()->add('options.assign_to', 'Admin assignment is required.');
                    }
                    break;

                case 'update_status':
                    if (!isset($options['status_id'])) {
                        $validator->errors()->add('options.status_id', 'Status selection is required.');
                    }
                    break;

                case 'update_priority':
                    if (!isset($options['priority'])) {
                        $validator->errors()->add('options.priority', 'Priority selection is required.');
                    }
                    break;

                case 'delete':
                    // Additional validation for delete action could be added here
                    break;
            }
        });
    }
}