<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Wdmethod;

class DepositRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'amount' => 'required|numeric|min:10',
            'payment_method' => 'required|string',
            'proof' => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
        ];

        // Additional validation for crypto payments
        if ($this->payment_method === 'crypto') {
            $rules['asset'] = 'required|string';
            $rules['wallet_address'] = 'required|string';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'amount.required' => 'Deposit amount is required',
            'amount.numeric' => 'Deposit amount must be a number',
            'amount.min' => 'Minimum deposit amount is $10',
            'payment_method.required' => 'Payment method is required',
            'proof.image' => 'Proof must be an image file',
            'proof.mimes' => 'Proof must be a file of type: jpg, jpeg, png',
            'proof.max' => 'Proof file size must not exceed 1MB',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure payment method is properly formatted
        if ($this->payment_method) {
            $this->merge([
                'payment_method' => ucfirst(strtolower($this->payment_method))
            ]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $method = Wdmethod::where('name', $this->payment_method)->first();

            if (!$method) {
                $validator->errors()->add('payment_method', 'Invalid payment method selected');
                return;
            }

            if (!$method->status) {
                $validator->errors()->add('payment_method', 'This payment method is currently unavailable');
            }
        });
    }
}