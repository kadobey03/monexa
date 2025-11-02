<?php

namespace App\Http\Requests\Admin\Lead;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadRequest extends FormRequest
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
        $leadId = $this->route('id') ?? $this->route('lead');

        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($leadId),
            ],
            'phone' => 'sometimes|nullable|string|max:20',
            'country' => 'sometimes|nullable|string|max:100',
            'company_name' => 'sometimes|nullable|string|max:255',
            'organization' => 'sometimes|nullable|string|max:255',
            'lead_status' => 'sometimes|nullable|string|exists:lead_statuses,name',
            'lead_source' => 'sometimes|nullable|string|max:255',
            'lead_source_id' => 'sometimes|nullable|integer|exists:lead_sources,id',
            'lead_notes' => 'sometimes|nullable|string|max:2000',
            'lead_score' => 'sometimes|nullable|integer|min:0|max:100',
            'estimated_value' => 'sometimes|nullable|numeric|min:0',
            'assign_to' => 'sometimes|nullable|integer|exists:admins,id',
            'next_follow_up_date' => 'sometimes|nullable|date',
            'preferred_contact_method' => 'sometimes|nullable|string|in:phone,email,sms,whatsapp',
            'lead_tags' => 'sometimes|nullable|array',
            'lead_tags.*' => 'string|max:50',
            'last_contact_date' => 'sometimes|nullable|date',
            'cstatus' => 'sometimes|nullable|string|in:Customer,Lead',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Lead name is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered by another user.',
            'phone.max' => 'Phone number should not exceed 20 characters.',
            'company_name.max' => 'Company name should not exceed 255 characters.',
            'organization.max' => 'Organization name should not exceed 255 characters.',
            'lead_score.min' => 'Lead score cannot be negative.',
            'lead_score.max' => 'Lead score cannot exceed 100.',
            'estimated_value.min' => 'Estimated value cannot be negative.',
            'lead_tags.*.max' => 'Each tag should not exceed 50 characters.',
            'preferred_contact_method.in' => 'Contact method must be phone, email, sms, or whatsapp.',
            'cstatus.in' => 'Status must be either Customer or Lead.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'lead name',
            'email' => 'email address',
            'phone' => 'phone number',
            'company_name' => 'company name',
            'organization' => 'organization',
            'lead_status' => 'lead status',
            'lead_source_id' => 'lead source',
            'lead_notes' => 'notes',
            'lead_score' => 'lead score',
            'estimated_value' => 'estimated value',
            'assign_to' => 'assigned admin',
            'next_follow_up_date' => 'follow-up date',
            'last_contact_date' => 'last contact date',
            'preferred_contact_method' => 'contact method',
            'lead_tags' => 'tags',
            'cstatus' => 'customer status',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Trim whitespace from string fields that are present
        $data = [];
        
        foreach (['name', 'email', 'phone', 'company_name', 'organization', 'lead_notes', 'lead_source'] as $field) {
            if ($this->has($field)) {
                $data[$field] = trim($this->input($field) ?? '');
            }
        }
        
        if (!empty($data)) {
            $this->merge($data);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Custom validation logic can be added here
            
            // Ensure at least email or phone is provided if this is a new lead
            if ($this->has(['email', 'phone']) && 
                empty($this->input('email')) && 
                empty($this->input('phone'))) {
                $validator->errors()->add('contact', 'Either email or phone number must be provided.');
            }
        });
    }
}