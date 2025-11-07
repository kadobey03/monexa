<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LoginRequest extends FormRequest
{
    /**
     * Rate limit key for login attempts
     */
    protected string $rateLimitKey;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->rateLimitKey = Str::lower($this->input('email')).'.|'..$this->ip();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                function ($attribute, $value, $fail) {
                    // E-posta formatı kontrolü
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('Lütfen geçerli bir e-posta adresi girin.');
                        return;
                    }
                    
                    // Kullanıcı var mı kontrolü
                    $user = User::where('email', $value)->first();
                    if (!$user) {
                        $this->logFailedAttempt($value, 'email_not_found');
                        $fail('Bu e-posta adresi ile kayıtlı bir hesap bulunamadı.');
                        return;
                    }

                    // Hesap aktif mi kontrolü
                    if ($user->status === 'blocked' || $user->status === 'suspended') {
                        $this->logFailedAttempt($value, 'account_blocked');
                        $fail('Hesabınız engellenmiştir. Lütfen destek ile iletişime geçin.');
                        return;
                    }

                    // E-posta doğrulanmış mı kontrolü
                    if (!$user->hasVerifiedEmail()) {
                        $fail('E-posta adresinizi doğrulamanız gerekiyor. Lütfen gelen kutunuzu kontrol edin.');
                        return;
                    }
                },
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                function ($attribute, $value, $fail) {
                    $email = $this->input('email');
                    if (!$email) return;

                    $user = User::where('email', $email)->first();
                    if (!$user) return;

                    // Şifre kontrolü
                    if (!Hash::check($value, $user->password)) {
                        $this->logFailedAttempt($email, 'wrong_password');
                        $fail('Şifreniz yanlış. Lütfen tekrar deneyin.');
                        return;
                    }
                },
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'E-posta adresi gereklidir.',
            'email.email' => 'Lütfen geçerli bir e-posta adresi girin.',
            'email.max' => 'E-posta adresi çok uzun.',
            'password.required' => 'Şifre gereklidir.',
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
        ];
    }

    /**
     * Get custom attribute names for validation.
     */
    public function attributes(): array
    {
        return [
            'email' => 'E-posta adresi',
            'password' => 'Şifre',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        $this->ensureIsNotRateLimited();
        $this->hitRateLimiter();

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    /**
     * Ensure the request is not rate limited.
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->rateLimitKey, 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->rateLimitKey);
        $minutes = ceil($seconds / 60);

        throw ValidationException::withMessages([
            'email' => [
                "Çok fazla giriş denemesi yaptınız. Lütfen {$minutes} dakika sonra tekrar deneyin."
            ],
        ]);
    }

    /**
     * Increment the rate limiter.
     */
    public function hitRateLimiter(): void
    {
        RateLimiter::hit($this->rateLimitKey, 300); // 5 dakika block
    }

    /**
     * Clear the rate limiter.
     */
    public function clearRateLimiter(): void
    {
        RateLimiter::clear($this->rateLimitKey);
    }

    /**
     * Get the authenticated user.
     */
    public function getUser(): ?User
    {
        return User::where('email', $this->input('email'))->first();
    }

    /**
     * Log failed authentication attempt.
     */
    protected function logFailedAttempt(string $email, string $reason): void
    {
        Log::channel('auth')->warning('Failed login attempt', [
            'email' => $email,
            'ip' => $this->ip(),
            'user_agent' => $this->userAgent(),
            'reason' => $reason,
            'timestamp' => now(),
        ]);
    }

    /**
     * Generate success message after validation.
     */
    public function getSuccessMessage(): string
    {
        $user = $this->getUser();
        $firstName = $user ? explode(' ', $user->name)[0] : '';
        
        $messages = [
            "Hoş geldiniz {$firstName}! Giriş yapılıyor, lütfen bekleyiniz...",
            "Başarıyla giriş yapıyorsunuz. Panel yükleniyor...",
            "Giriş başarılı! Hesabınıza yönlendiriliyorsunuz...",
            "Hoş geldiniz! Lütfen bekleyiniz, sisteme giriş yapılıyor...",
        ];

        return $messages[array_rand($messages)];
    }

    /**
     * Get additional validation data for security checks.
     */
    public function getSecurityData(): array
    {
        return [
            'ip' => $this->ip(),
            'user_agent' => $this->userAgent(),
            'session_id' => session()->getId(),
            'timestamp' => now(),
            'rate_limit_key' => $this->rateLimitKey,
        ];
    }

    /**
     * Check if login should require 2FA.
     */
    public function shouldRequire2FA(): bool
    {
        $user = $this->getUser();
        return $user && $user->two_factor_secret !== null;
    }
}
