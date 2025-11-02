<?php

namespace App\Providers;

use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use App\Models\Settings;
use App\Models\SettingsCont;
use App\Models\TermsPrivacy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        FacadesStorage::extend('sftp', function ($app, $config) {
            return new Filesystem(new SftpAdapter($config));
        });

        Paginator::useBootstrap();

        // Sharing settings with all view
        try {
            $settings = Settings::where('id', '1')->first();
            $terms = TermsPrivacy::find(1);
            $moreset = SettingsCont::find(1);

            // Create fallback settings if not found
            if (!$settings) {
                $settings = (object) [
                    'site_name' => 'Monexa',
                    'favicon' => 'favicon.ico',
                    'currency' => '$',
                    'modules' => null,
                    'contact_email' => 'admin@site.com'
                ];
            }

            View::share('settings', $settings);
            View::share('terms', $terms);
            View::share('moresettings', $moreset);
            View::share('mod', $settings->modules ?? null);
        } catch (\Exception $e) {
            // Database might not be ready during migrations or initial setup
            // Create fallback settings object instead of null
            $fallbackSettings = (object) [
                'site_name' => 'Monexa',
                'favicon' => 'favicon.ico',
                'currency' => '$',
                'modules' => null,
                'contact_email' => 'admin@site.com'
            ];
            
            View::share('settings', $fallbackSettings);
            View::share('terms', null);
            View::share('moresettings', null);
            View::share('mod', null);
        }
    }
}