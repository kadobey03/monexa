<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Wdmethod;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;

class WithdrawalRequest extends FormRequest
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
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string',
            'withdrawal_code' => 'required_if:sendotpemail,Yes|string',
            'otpcode' => 'required_if:sendotpemail,Yes|string|size:5',
        ];

        // Additional rules based on payment method
        if ($this->method) {
            $method = Wdmethod::where('name', $this->method)->first();

            if ($method) {
                // Set minimum amount based on method
                if ($method->minimum > 0) {
                    $rules['amount'] = 'required|numeric|min:' . $method->minimum;
                }

                // Additional fields for crypto methods
                if ($method->methodtype === 'crypto') {
                    $rules['details'] = 'required|string|min:20';
                }

                // Bank transfer specific fields
                if ($this->method === 'Bank Transfer') {
                    $rules['bank_name'] = 'required|string|max:255';
                    $rules['account_name'] = 'required|string|max:255';
                    $rules['swift_code'] = 'required|string|size:8|regex:/^[A-Z]{6}[A-Z0-9]{2}([A-Z0-9]{3})?$/';
                    $rules['account_no'] = 'required|string|min:8|max:20';
                }
            }
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        $settings = Settings::where('id', '1')->first();
        $currency = $settings ? $settings->currency : '$';

        return [
            'amount.required' => 'Withdrawal amount is required',
            'amount.numeric' => 'Withdrawal amount must be a number',
            'amount.min' => 'Amount must be greater than 0',
            'method.required' => 'Payment method is required',
            'withdrawal_code.required_if' => 'Withdrawal code is required',
            'otpcode.required_if' => 'OTP code is required',
            'otpcode.size' => 'OTP code must be exactly 5 characters',
            'details.required' => 'Wallet address is required for crypto withdrawals',
            'details.min' => 'Wallet address must be at least 20 characters',
            'bank_name.required' => 'Bank name is required',
            'account_name.required' => 'Account name is required',
            'swift_code.required' => 'SWIFT code is required',
            'swift_code.regex' => 'Invalid SWIFT code format',
            'account_no.required' => 'Account number is required',
            'account_no.min' => 'Account number must be at least 8 characters',
            'account_no.max' => 'Account number must not exceed 20 characters',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $method = Wdmethod::where('name', $this->method)->first();

            if (!$method) {
                $validator->errors()->add('method', 'Invalid payment method selected');
                return;
            }

            if (!$method->status) {
                $validator->errors()->add('method', 'This payment method is currently unavailable');
            }

            // Validate minimum withdrawal amount
            if ($this->amount && $this->amount < $method->minimum) {
                $settings = Settings::where('id', '1')->first();
                $currency = $settings ? $settings->currency : '$';
                $validator->errors()->add('amount', "Minimum withdrawal amount is {$currency}{$method->minimum}");
            }

            // Validate withdrawal code if required
            if ($this->sendotpemail === 'Yes' && $this->withdrawal_code !== Auth::user()->user_withdrawalcode) {
                $validator->errors()->add('withdrawal_code', 'Invalid withdrawal code');
            }

            // Validate OTP if required
            if ($this->sendotpemail === 'Yes' && $this->otpcode !== Auth::user()->withdrawotp) {
                $validator->errors()->add('otpcode', 'Invalid OTP code');
            }
        });
    }
}