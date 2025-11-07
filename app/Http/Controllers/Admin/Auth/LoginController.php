<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\NewNotification;
use App\Mail\Twofa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
   // use AuthenticatesUsers;
/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating admin users for the application and
    | redirecting them to your admin dashboard.
    |
    */

    /**
     * This trait has all the login throttling functionality.
     */
    // use ThrottlesLogins;


   

    /**
     * Show the login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.adminlogin',[
            'title' => 'Admin Login',
            'settings' => Settings::where('id', '=', '1')->first() ?? new Settings(),
        ]);
    }

    /**
     * Login the admin.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminlogin(Request $request)
    {
        $key = 'admin-login:' . $request->ip();
        
        // Rate limiting - 5 deneme / dakika
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            Log::warning('Admin login rate limit exceeded', [
                'ip' => $request->ip(),
                'email' => $request->email,
                'user_agent' => $request->userAgent()
            ]);
            
            throw ValidationException::withMessages([
                'email' => __('Çok fazla giriş denemesi. :seconds saniye sonra tekrar deneyin.', [
                    'seconds' => $seconds
                ]),
            ]);
        }

        try {
            // Güvenli validation - email enumeration'ı engellemek için exists kullanmıyoruz
            $data = $this->validate($request, [
                'email'    => 'required|string|email|min:5|max:191',
                'password' => 'required|string|min:8|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ], [
                'password.regex' => 'Şifre en az bir büyük harf, bir küçük harf ve bir rakam içermelidir.',
                'password.min' => 'Şifre en az 8 karakter olmalıdır.',
            ]);

            $email = $request->input('email');
            $password = $request->input('password');

            // Authentication attempt
            if (Auth::guard('admin')->attempt([
                'email' => $email,
                'password' => $password,
                'status' => 'active'
            ])) {
                // Clear rate limit on successful login
                RateLimiter::clear($key);
                
                $request->session()->regenerate();
                $user = Auth::guard('admin')->user();
                
                // Security logging
                Log::info('Admin successful login', [
                    'admin_id' => $user->id,
                    'email' => $user->email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);

                // 2FA kontrolü
                if ($user->enable_2fa === "enabled") {
                    // Güvenli token generation
                    $token = random_int(100000, 999999);
                    
                    Admin::where('id', $user->id)->update([
                        'token_2fa' => $token,
                        'pass_2fa' => 'false',
                        'token_2fa_expiry' => now()->addMinutes(5), // Token 5 dakika geçerli
                    ]);

                    $settings = Settings::where('id', '=', '1')->first() ?? new Settings();
                    
                    try {
                        $objDemo = new \stdClass();
                        $objDemo->message = $token;
                        $objDemo->sender = $settings->site_name;
                        $objDemo->subject = "Two Factor Authentication Code";
                        $objDemo->date = \Carbon\Carbon::Now();
                        
                        Mail::bcc($user->email)->send(new Twofa($objDemo));
                        
                        Log::info('2FA token sent', [
                            'admin_id' => $user->id,
                            'email' => $user->email
                        ]);
                    } catch (\Exception $mailException) {
                        Log::error('2FA email send failed', [
                            'admin_id' => $user->id,
                            'email' => $user->email,
                            'error' => $mailException->getMessage()
                        ]);
                        // 2FA email gönderilememişse token'ı sıfırla
                        Admin::where('id', $user->id)->update([
                            'token_2fa' => null,
                            'pass_2fa' => 'false',
                        ]);
                    }
                    
                    return redirect()->intended('/admin/2fa');
                }

                return redirect()->intended('admin/dashboard');
            }

            // Failed login attempt
            RateLimiter::hit($key, 60); // 1 dakika decay
            
            Log::warning('Admin failed login attempt', [
                'email' => $email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            return back()->withErrors([
                'email' => 'Giriş bilgileri hatalı.',
            ])->onlyInput('email');

        } catch (ValidationException $e) {
            // Validation hatası - rate limit ekleme
            RateLimiter::hit($key, 60);
            throw $e;
        } catch (\Exception $e) {
            // Genel hata - güvenlik için detayları logla ama kullanıcıya gösterme
            Log::error('Admin login system error', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return back()->withErrors([
                'email' => 'Bir sistem hatası oluştu. Lütfen tekrar deneyin.',
            ])->onlyInput('email');
        }
    }


    public function validate_admin(){
        if (Auth::guard('admin')->check()){
            return redirect()
            ->intended(route('admin.dashboard'))
            ->with('message','You are Logged in as Admin!');
        }else {
            return redirect()
            ->route('adminloginform')
            ->with('message','Not allowed');
        }
    }

    /**
     * Logout the admin.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminlogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()
            ->route('adminloginform')
            ->with('status','Admin has been logged out!');
    }

   
}
