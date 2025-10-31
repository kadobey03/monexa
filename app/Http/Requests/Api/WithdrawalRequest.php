<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:20|max:50000',
            'payment_method' => 'required|in:crypto,bank_transfer',
            'wallet_address' => 'required_if:payment_method,crypto|string|max:255',
            'bank_details' => 'required_if:payment_method,bank_transfer|array',
            'otp_code' => 'required|string|size:6',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Withdrawal amount is required',
            'amount.min' => 'Minimum withdrawal amount is $20',
            'wallet_address.required_if' => 'Wallet address is required for crypto withdrawals',
            'otp_code.required' => 'OTP code is required for withdrawals',
        ];
    }
}