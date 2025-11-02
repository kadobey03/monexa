<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Settings;

class JetstreamServiceProvider extends ServiceProvider
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
        $this->configurePermissions();
        Jetstream::deleteUsersUsing(DeleteUser::class);

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
            
            if (
                $user &&
                Hash::check($request->password, $user->password)
            ) {
                $request->session()->put('getAnouc', 'true');
                
                // Request'ten temel bilgileri al
                $userAgent = $request->header('User-Agent', 'Unknown');
                $device = 'Web Browser';
                $browser = 'Unknown';
                $os = 'Unknown';
                
                // Basit user agent parsing
                if (strpos($userAgent, 'Mobile') !== false) {
                    $device = 'Mobile';
                } elseif (strpos($userAgent, 'Tablet') !== false) {
                    $device = 'Tablet';
                }
                
                if (strpos($userAgent, 'Chrome') !== false) {
                    $browser = 'Chrome';
                } elseif (strpos($userAgent, 'Firefox') !== false) {
                    $browser = 'Firefox';
                } elseif (strpos($userAgent, 'Safari') !== false) {
                    $browser = 'Safari';
                } elseif (strpos($userAgent, 'Edge') !== false) {
                    $browser = 'Edge';
                }
                
                if (strpos($userAgent, 'Windows') !== false) {
                    $os = 'Windows';
                } elseif (strpos($userAgent, 'Mac') !== false) {
                    $os = 'macOS';
                } elseif (strpos($userAgent, 'Linux') !== false) {
                    $os = 'Linux';
                } elseif (strpos($userAgent, 'Android') !== false) {
                    $os = 'Android';
                } elseif (strpos($userAgent, 'iOS') !== false) {
                    $os = 'iOS';
                }
                
                try {
                    DB::table('activities')->insert([
                        'user' => $user->id,
                        'ip_address' => $request->ip(),
                        'device' => $device,
                        'browser' => $browser,
                        'os' => $os,
                    ]);
                } catch (\Exception $e) {
                    // Activity logging failed, but continue authentication
                    \Log::debug('Activity logging failed: ' . $e->getMessage());
                }
                return $user;
            }
        });
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
