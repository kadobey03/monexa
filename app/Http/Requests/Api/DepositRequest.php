<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:10|max:100000',
            'payment_method' => 'required|in:crypto,bank_transfer,card',
            'currency' => 'required|in:USD,EUR,BTC,ETH',
            'screenshot' => 'nullable|image|max:5120', // 5MB max
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Deposit amount is required',
            'amount.min' => 'Minimum deposit amount is $10',
            'amount.max' => 'Maximum deposit amount is $100,000',
            'payment_method.required' => 'Payment method is required',
            'payment_method.in' => 'Invalid payment method',
        ];
    }
}