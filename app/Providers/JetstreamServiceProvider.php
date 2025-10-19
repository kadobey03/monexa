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
use App\Models\Settings;
use Jenssegers\Agent\Agent;

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
             $user = User::where('email', $request->email) ->orWhere('username', $request->email)->first();
            // $user = User::where('email', $request->email)->first();
            
            if (
                $user &&
                Hash::check($request->password, $user->password)
            ) {
                $request->session()->put('getAnouc', 'true');
                
                // Agent bilgilerini güvenli şekilde al
                $device = 'Unknown';
                $browser = 'Unknown';
                $os = 'Unknown';
                
                try {
                    if (class_exists('Jenssegers\Agent\Agent')) {
                        $agent = new Agent();
                        $device = $agent->device() ?: 'Unknown';
                        $browser = $agent->browser() ?: 'Unknown';
                        $os = $agent->platform() ?: 'Unknown';
                    }
                } catch (\Exception $e) {
                    // Agent paketi yoksa varsayılan değerler kullan
                }
                
                DB::table('activities')->insert([
                    'user' => $user->id,
                    'ip_address' => $request->ip(),
                    'device' => $device,
                    'browser' => $browser,
                    'os' => $os,
                ]);
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
