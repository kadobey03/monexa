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

        // Login authentication handled by custom LoginController
        // @see App\Http\Controllers\Auth\LoginController
        
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
