<?php

namespace App\Http\Requests\Admin\Lead;

use Illuminate\Foundation\Http\FormRequest;

class CreateLeadRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'company_name' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'lead_status_id' => 'nullable|integer|exists:lead_statuses,id',
            'lead_source' => 'nullable|string|max:255',
            'lead_source_id' => 'nullable|integer|exists:lead_sources,id',
            'lead_notes' => 'nullable|string|max:2000',
            'lead_score' => 'nullable|integer|min:0|max:100',
            'estimated_value' => 'nullable|numeric|min:0',
            'assign_to' => 'nullable|integer|exists:admins,id',
            'next_follow_up_date' => 'nullable|date|after:today',
            'preferred_contact_method' => 'nullable|string|in:phone,email,sms,whatsapp',
            'lead_tags' => 'nullable|array',
            'lead_tags.*' => 'string|max:50',
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
            'email.unique' => 'This email address is already registered.',
            'phone.max' => 'Phone number should not exceed 20 characters.',
            'company_name.max' => 'Company name should not exceed 255 characters.',
            'organization.max' => 'Organization name should not exceed 255 characters.',
            'lead_score.min' => 'Lead score cannot be negative.',
            'lead_score.max' => 'Lead score cannot exceed 100.',
            'estimated_value.min' => 'Estimated value cannot be negative.',
            'next_follow_up_date.after' => 'Follow-up date must be in the future.',
            'lead_tags.*.max' => 'Each tag should not exceed 50 characters.',
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
            'lead_status_id' => 'lead status',
            'lead_source_id' => 'lead source',
            'lead_notes' => 'notes',
            'lead_score' => 'lead score',
            'estimated_value' => 'estimated value',
            'assign_to' => 'assigned admin',
            'next_follow_up_date' => 'follow-up date',
            'preferred_contact_method' => 'contact method',
            'lead_tags' => 'tags',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Trim whitespace from string fields
        $this->merge([
            'name' => trim($this->name ?? ''),
            'email' => trim($this->email ?? ''),
            'phone' => trim($this->phone ?? ''),
            'company_name' => trim($this->company_name ?? ''),
            'organization' => trim($this->organization ?? ''),
            'lead_notes' => trim($this->lead_notes ?? ''),
        ]);
    }
}