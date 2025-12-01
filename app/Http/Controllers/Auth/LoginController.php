<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Settings;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login', [
            'title' => __('auth.login.title'),
            'settings' => Settings::first() ?: (object)['site_name' => 'Trading Platform', 'favicon' => null],
        ]);
    }

    public function login(Request $request)
    {
        // Basic validation
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ], [
            'email.required' => __('auth.validation.email_required'),
            'email.email' => __('auth.validation.email_format'),
            'password.required' => __('auth.validation.password_required'),
        ]);

        $user = User::where('email', $request->email)->first();

        // Ajax request için hata mesajlarını hazırla
        $errorHandler = function($fieldName, $messages) use ($request) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => [$fieldName => $messages]
                ], 422);
            }
            throw ValidationException::withMessages([$fieldName => $messages]);
        };

        // Eğer kullanıcı yoksa, kayıt önerisi yap
        if (!$user) {
            return $errorHandler('email', [__('auth.errors.email_not_registered', ['register_url' => route('register')])]);
        }

        // Hesap kilitli mi kontrol et
        if ($user->locked_until && $user->locked_until->isFuture()) {
            $remainingMinutes = now()->diffInMinutes($user->locked_until);
            return $errorHandler('email', [__('auth.errors.account_locked_minutes', ['minutes' => $remainingMinutes])]);
        }

        // Hesap durumu kontrol et
        if (in_array($user->status, ['blocked', 'suspended', 'inactive'])) {
            $statusMessages = [
                'blocked' => __('auth.errors.account_blocked'),
                'suspended' => __('auth.errors.account_suspended'),
                'inactive' => __('auth.errors.account_inactive'),
            ];
            return $errorHandler('email', [$statusMessages[$user->status] ?? __('auth.errors.account_unusable')]);
        }

        // Şifre kontrol et
        if (!Hash::check($request->password, $user->password)) {
            // Failed attempts sayısını artır
            $user->increment('failed_login_attempts');
            $remainingAttempts = 3 - $user->failed_login_attempts;
            
            if ($remainingAttempts <= 0) {
                // 3. yanlış denemeden sonra hesabı 1 dakika kilitle
                $user->update([
                    'locked_until' => now()->addMinutes(1)
                ]);
                
                return $errorHandler('email', [__('auth.errors.password_failed_locked')]);
            }
            
            // Hala deneme hakkı var
            return $errorHandler('email', [__('auth.errors.password_failed_attempts', ['attempts' => $remainingAttempts])]);
        }

        // Başarılı giriş - failed attempts'ı sıfırla
        if ($user->failed_login_attempts > 0) {
            $user->update([
                'failed_login_attempts' => 0,
                'locked_until' => null
            ]);
        }

        // Son giriş bilgilerini güncelle
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        // Kullanıcıyı login et
        Auth::login($user, $request->boolean('remember'));

        // Ajax request ise JSON response dön
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('auth.login.success_message', ['name' => $user->name]),
                'redirect_url' => route('dashboard'),
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
        }

        // Normal redirect
        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        $key = strtolower($request->input('email')).'|'.$request->ip();
        
        if (\RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = \RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);

            throw ValidationException::withMessages([
                'email' => [
                    __('auth.errors.rate_limit_exceeded', ['minutes' => $minutes])
                ],
            ]);
        }

        \RateLimiter::hit($key, 600); // 10 dakika block
    }

    protected function clearRateLimiter(Request $request): void
    {
        $key = strtolower($request->input('email')).'|'.$request->ip();
        \RateLimiter::clear($key);
    }
}