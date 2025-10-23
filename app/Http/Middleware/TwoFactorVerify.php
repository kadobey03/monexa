<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class TwoFactorVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if admin user is logged in
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('validate_admin');
        }
        
        $logg = Auth::guard('admin')->user();
        $user = Admin::where('email',$logg->email)->first();
        
        // Skip 2FA check if admin user not found in database (development safety)
        if (!$user) {
            return $next($request);
        }
        
        if($user->enable_2fa == "enabled" && $user->token_2fa_expiry < \Carbon\Carbon::now() && ($user->pass_2fa == "false" || $user->pass_2fa == NULL)){
            return redirect('/admin/2fa');
        }
        else{
            return $next($request);
        }
    }
}