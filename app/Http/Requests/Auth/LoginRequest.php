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
        $this->rateLimitKey = Str::lower($this->input('email')).'|'.$this->ip();
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
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', // En az 1 küçük, 1 büyük harf, 1 rakam
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
            'password.regex' => 'Şifre en az 1 büyük harf, 1 küçük harf ve 1 rakam içermelidir.',
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
        $this->processFailedLogin();
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
        if (!RateLimiter::tooManyAttempts($this->rateLimitKey, 3)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->rateLimitKey);
        $minutes = ceil($seconds / 60);

        $this->logSecurityEvent('rate_limit_exceeded', [
            'attempts_key' => $this->rateLimitKey,
            'blocked_for_seconds' => $seconds,
        ]);

        throw ValidationException::withMessages([
            'email' => [
                "Güvenlik nedeniyle geçici olarak engellendiniz. Lütfen {$minutes} dakika sonra tekrar deneyin."
            ],
        ]);
    }

    /**
     * Increment the rate limiter.
     */
    public function hitRateLimiter(): void
    {
        RateLimiter::hit($this->rateLimitKey, 600); // 10 dakika block
    }

    /**
     * Clear the rate limiter.
     */
    public function clearRateLimiter(): void
    {
        RateLimiter::clear($this->rateLimitKey);
    }

    /**
     * Validate credentials and handle security checks.
     */
    public function validateCredentials(): bool
    {
        $user = User::where('email', $this->input('email'))->first();
        
        if (!$user) {
            $this->logSecurityEvent('email_not_found');
            return false;
        }

        // Hesap kilitli mi kontrol et
        if ($user->locked_until && $user->locked_until->isFuture()) {
            $this->logSecurityEvent('account_locked');
            return false;
        }

        // Hesap durumu kontrol et
        if (in_array($user->status, ['blocked', 'suspended', 'inactive'])) {
            $this->logSecurityEvent('account_blocked');
            return false;
        }

        // E-posta doğrulaması kontrol et
        if (!$user->hasVerifiedEmail()) {
            $this->logSecurityEvent('email_not_verified');
            return false;
        }

        // Şifre kontrol et
        if (!Hash::check($this->input('password'), $user->password)) {
            $this->logSecurityEvent('wrong_password');
            $this->incrementFailedAttempts($user);
            return false;
        }

        // Başarılı giriş - sayaçları sıfırla
        $this->resetFailedAttempts($user);
        $this->updateLastLogin($user);
        return true;
    }

    /**
     * Get the authenticated user.
     */
    public function getUser(): ?User
    {
        return User::where('email', $this->input('email'))->first();
    }

    /**
     * Process failed login attempt with specific error messages.
     */
    protected function processFailedLogin(): void
    {
        $user = User::where('email', $this->input('email'))->first();
        
        if (!$user) {
            $this->logSecurityEvent('email_not_found');
            throw ValidationException::withMessages([
                'email' => ['Bu e-posta adresi ile kayıtlı bir hesap bulunamadı. Kayıt olmak için üye ol sekmesini kullanın.'],
            ]);
        }

        // Hesap kilitli mi kontrol et
        if ($user->locked_until && $user->locked_until->isFuture()) {
            $remainingMinutes = $user->locked_until->diffInMinutes(now());
            $this->logSecurityEvent('account_locked');
            throw ValidationException::withMessages([
                'email' => ["Hesabınız güvenlik nedeniyle kilitlenmiştir. {$remainingMinutes} dakika sonra tekrar deneyin."],
            ]);
        }

        // Hesap durumu kontrol et
        if (in_array($user->status, ['blocked', 'suspended', 'inactive'])) {
            $this->logSecurityEvent('account_blocked');
            $statusMessages = [
                'blocked' => 'Hesabınız yönetici tarafından engellenmiştir. Destek ekibi ile iletişime geçin.',
                'suspended' => 'Hesabınız geçici olarak askıya alınmıştır. Lütfen destek ekibi ile iletişime geçin.',
                'inactive' => 'Hesabınız aktif durumda değil. Lütfen hesabınızı aktifleştirin.',
            ];
            throw ValidationException::withMessages([
                'email' => [$statusMessages[$user->status] ?? 'Hesabınız kullanılamaz durumda.'],
            ]);
        }

        // E-posta doğrulaması kontrol et
        if (!$user->hasVerifiedEmail()) {
            $this->logSecurityEvent('email_not_verified');
            throw ValidationException::withMessages([
                'email' => ['E-posta adresiniz doğrulanmamış. Lütfen e-posta kutunuzu kontrol edin ve doğrulama linkine tıklayın.'],
            ]);
        }

        // Şifre kontrol et
        if (!Hash::check($this->input('password'), $user->password)) {
            $this->logSecurityEvent('wrong_password');
            $this->incrementFailedAttempts($user);
            
            $remainingAttempts = max(0, 5 - ($user->failed_login_attempts ?? 0));
            throw ValidationException::withMessages([
                'password' => ["Şifreniz hatalı. Kalan deneme hakkınız: {$remainingAttempts}. Şifremi unuttum seçeneğini kullanabilirsiniz."],
            ]);
        }

        // Bu noktaya gelinmemesi gerekir
        throw ValidationException::withMessages([
            'email' => ['Giriş işlemi başarısız. Lütfen tekrar deneyin.'],
        ]);
    }

    /**
     * Increment failed login attempts for user.
     */
    protected function incrementFailedAttempts(User $user): void
    {
        $attempts = ($user->failed_login_attempts ?? 0) + 1;
        
        $updateData = [
            'failed_login_attempts' => $attempts,
        ];

        // 5 başarısız denemeden sonra hesabı kilitle
        if ($attempts >= 5) {
            $updateData['locked_until'] = now()->addMinutes(30);
            $this->logSecurityEvent('account_auto_locked', [
                'failed_attempts' => $attempts,
                'locked_until' => $updateData['locked_until'],
            ]);
        }

        $user->update($updateData);
    }

    /**
     * Reset failed login attempts for user.
     */
    protected function resetFailedAttempts(User $user): void
    {
        if ($user->failed_login_attempts > 0 || $user->locked_until) {
            $user->update([
                'failed_login_attempts' => 0,
                'locked_until' => null,
            ]);
        }
    }

    /**
     * Update last login information.
     */
    protected function updateLastLogin(User $user): void
    {
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $this->ip(),
        ]);
    }

    /**
     * Log security events with comprehensive data.
     */
    protected function logSecurityEvent(string $event, array $additional = []): void
    {
        $logData = array_merge([
            'event' => $event,
            'email' => $this->input('email'),
            'ip' => $this->ip(),
            'user_agent' => $this->userAgent(),
            'session_id' => session()->getId(),
            'timestamp' => now(),
            'rate_limit_key' => $this->rateLimitKey,
        ], $additional);

        Log::channel('auth')->warning("User login security event: {$event}", $logData);

        // User security events alanına da kaydet (eğer user varsa)
        $user = User::where('email', $this->input('email'))->first();
        if ($user) {
            $events = $user->security_events ?? [];
            $events[] = $logData;
            
            // Son 50 eventi tut
            if (count($events) > 50) {
                $events = array_slice($events, -50);
            }
            
            $user->update(['security_events' => $events]);
        }
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
        return $user && ($user->enable_2fa === true || $user->two_factor_secret !== null);
    }

    /**
     * Generate secure 2FA token for user.
     */
    public function generate2FAToken(User $user): string
    {
        $token = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->update([
            'token_2fa' => $token,
            'token_2fa_expiry' => now()->addMinutes(10),
            'pass_2fa' => false,
        ]);

        $this->logSecurityEvent('2fa_token_generated');
        return $token;
    }

    /**
     * Validate 2FA token.
     */
    public function validate2FAToken(User $user, string $token): bool
    {
        if (!$user->token_2fa || !$user->token_2fa_expiry) {
            return false;
        }

        if ($user->token_2fa_expiry->isPast()) {
            $this->logSecurityEvent('2fa_token_expired');
            return false;
        }

        if ($user->token_2fa !== $token) {
            $this->logSecurityEvent('2fa_token_invalid');
            return false;
        }

        // Token doğru - kullanıldı olarak işaretle
        $user->update([
            'token_2fa' => null,
            'token_2fa_expiry' => null,
            'pass_2fa' => true,
        ]);

        $this->logSecurityEvent('2fa_token_validated');
        return true;
    }
}
