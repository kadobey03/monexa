<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Models\Settings;
//use App\Models\TermsPrivacy;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Login validation - Production'da güvenli çalışması için özel validation ekleyelim
        Fortify::authenticateUsing(function (Request $request) {
            try {
                // Validation rules
                $request->validate([
                    'email' => ['required', 'email'],
                    'password' => ['required', 'string']
                ], [
                    'email.required' => 'E-posta adresi gereklidir.',
                    'email.email' => 'Geçerli bir e-posta adresi giriniz.',
                    'password.required' => 'Şifre gereklidir.',
                ]);

                $user = \App\Models\User::where('email', $request->email)->first();

                if ($user && \Hash::check($request->password, $user->password)) {
                    // Kullanıcı banned kontrolü
                    if ($user->status === 'blocked' || $user->status === 'banned') {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'email' => ['Hesabınız askıya alınmıştır. Lütfen destek ekibi ile iletişime geçin.']
                        ]);
                    }
                    
                    return $user;
                }

                // Hatalı credentials için validation exception
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'email' => ['E-posta adresi veya şifre hatalı.']
                ]);

            } catch (\Illuminate\Validation\ValidationException $e) {
                throw $e;
            } catch (\Exception $e) {
                // Production'da beklenmeyen hatalar için fallback
                \Log::error('Login error: ' . $e->getMessage(), [
                    'email' => $request->email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);
                
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'email' => ['Giriş yapılırken bir hata oluştu. Lütfen tekrar deneyiniz.']
                ]);
            }
        });
        
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge', [
                'title' => 'Two Factor Authentication',
            ]);
        });

        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password', [
                'title' => 'Password Confirmation',
            ]);
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password',[
                'title' => 'Enter email to reset your password',
                'settings' => Settings::first() ?: (object)['site_name' => 'Trading Platform', 'favicon' => null],
            ]);
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', [
                'title' => 'Reset Password',
                'settings' => Settings::first() ?: (object)['site_name' => 'Trading Platform', 'favicon' => null],
                'request' => $request,
            ]);
        });

        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge', [
                'title' => 'Two Factor Authentication',
                'settings' => Settings::first() ?: (object)['site_name' => 'Trading Platform', 'favicon' => null],
            ]);
        });

        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password', [
                'title' => 'Password Confirmation',
                'settings' => Settings::first() ?: (object)['site_name' => 'Trading Platform', 'favicon' => null],
            ]);
        });

        Fortify::loginView(function () {
            return view('auth.login', [
                'title' => 'Giriş Yap',
                'settings' => Settings::first() ?: (object)['site_name' => 'Trading Platform', 'favicon' => null],
            ]);
        });

        Fortify::registerView(function () {
            // Include currencies if the file exists
            $currencies = [];
            $currenciesFile = app_path('Providers/currencies.php');
            if (file_exists($currenciesFile)) {
                include $currenciesFile;
            }
            
            return view('auth.register', [
                'title' => 'Kayıt Ol',
                'settings' => Settings::first() ?: (object)['site_name' => 'Trading Platform', 'favicon' => null],
                'currencies' => $currencies ?? [],
            ]);
        });

        // Fortify::registerView(function () {
        //     return view('auth.registers',[
        //         'terms' => TermsPrivacy::find(1),
        //     ]);
        // });
    }
}
