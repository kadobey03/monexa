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

            // Admin hesabını kontrol et
            $admin = Admin::where('email', $email)->first();
            
            if (!$admin) {
                RateLimiter::hit($key, 60);
                
                Log::warning('Admin login attempt with non-existent email', [
                    'email' => $email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);
                
                return back()->withErrors([
                    'email' => 'Bu e-posta adresi ile kayıtlı bir admin hesabı bulunamadı.',
                ])->onlyInput('email');
            }

            // Admin hesap durumunu kontrol et
            if ($admin->status !== 'active') {
                RateLimiter::hit($key, 60);
                
                Log::warning('Admin login attempt with inactive account', [
                    'admin_id' => $admin->id,
                    'email' => $email,
                    'status' => $admin->status,
                    'ip' => $request->ip()
                ]);
                
                $statusMessages = [
                    'inactive' => 'Hesabınız aktif değil. Lütfen sistem yöneticisi ile iletişime geçin.',
                    'blocked' => 'Hesabınız engellenmiş durumda. Sistem yöneticisi ile iletişime geçin.',
                    'suspended' => 'Hesabınız geçici olarak askıya alınmıştır.',
                ];
                
                return back()->withErrors([
                    'email' => $statusMessages[$admin->status] ?? 'Hesabınız kullanılamaz durumda.',
                ])->onlyInput('email');
            }

            // Hesap kilidi kontrolü
            if ($admin->locked_until && $admin->locked_until->isFuture()) {
                $remainingMinutes = $admin->locked_until->diffInMinutes(now());
                
                Log::warning('Admin login attempt on locked account', [
                    'admin_id' => $admin->id,
                    'email' => $email,
                    'locked_until' => $admin->locked_until,
                    'ip' => $request->ip()
                ]);
                
                return back()->withErrors([
                    'email' => "Hesabınız güvenlik nedeniyle kilitlenmiştir. {$remainingMinutes} dakika sonra tekrar deneyin.",
                ])->onlyInput('email');
            }

            // Şifre kontrolü
            if (!password_verify($password, $admin->password)) {
                RateLimiter::hit($key, 60);
                
                // Başarısız deneme sayısını artır
                $failedAttempts = ($admin->failed_login_attempts ?? 0) + 1;
                $updateData = ['failed_login_attempts' => $failedAttempts];
                
                // 5 başarısız denemeden sonra hesabı kilitle
                if ($failedAttempts >= 5) {
                    $updateData['locked_until'] = now()->addMinutes(30);
                    
                    Log::warning('Admin account auto-locked after failed attempts', [
                        'admin_id' => $admin->id,
                        'email' => $email,
                        'failed_attempts' => $failedAttempts,
                        'ip' => $request->ip()
                    ]);
                    
                    $admin->update($updateData);
                    
                    return back()->withErrors([
                        'email' => 'Çok fazla hatalı deneme. Hesabınız güvenlik nedeniyle 30 dakika kilitlenmiştir.',
                    ])->onlyInput('email');
                }
                
                $admin->update($updateData);
                
                Log::warning('Admin failed login - wrong password', [
                    'admin_id' => $admin->id,
                    'email' => $email,
                    'failed_attempts' => $failedAttempts,
                    'ip' => $request->ip()
                ]);
                
                $remainingAttempts = 5 - $failedAttempts;
                return back()->withErrors([
                    'password' => "Şifreniz hatalı. Kalan deneme hakkınız: {$remainingAttempts}",
                ])->onlyInput('email');
            }

            // Başarılı giriş - Laravel Auth kullan
            if (Auth::guard('admin')->attempt([
                'email' => $email,
                'password' => $password,
                'status' => 'active'
            ])) {
                // Clear rate limit on successful login
                RateLimiter::clear($key);
                
                // Başarısız deneme sayısını sıfırla
                $admin->update([
                    'failed_login_attempts' => 0,
                    'locked_until' => null,
                    'last_login_at' => now(),
                    'last_login_ip' => $request->ip()
                ]);
                
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
                        $objDemo->subject = "İki Faktörlü Doğrulama Kodu";
                        $objDemo->date = \Carbon\Carbon::Now();
                        
                        Mail::bcc($user->email)->send(new Twofa($objDemo));
                        
                        Log::info('2FA token sent', [
                            'admin_id' => $user->id,
                            'email' => $user->email
                        ]);
                        
                        return redirect()->intended('/admin/2fa')
                            ->with('success', 'İki faktörlü doğrulama kodu e-posta adresinize gönderildi.');
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
                        
                        return back()->withErrors([
                            'email' => '2FA kodu gönderilemedi. Lütfen sistem yöneticisi ile iletişime geçin.',
                        ])->onlyInput('email');
                    }
                }

                return redirect()->intended('admin/dashboard')
                    ->with('success', 'Başarıyla giriş yaptınız. Hoş geldiniz!');
            }

            // Bu noktaya normal şartlarda gelinmemeli
            RateLimiter::hit($key, 60);
            
            Log::error('Admin login unexpected failure', [
                'email' => $email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            return back()->withErrors([
                'email' => 'Giriş işlemi başarısız. Lütfen tekrar deneyin.',
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
