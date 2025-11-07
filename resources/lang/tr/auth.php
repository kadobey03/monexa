<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Girdiğiniz e-posta adresi ve şifre kombinasyonu sistemimizde bulunamadı.',
    'password' => 'Girilen şifre hatalıdır.',
    'throttle' => 'Çok fazla giriş denemesi yapıldı. Lütfen :seconds saniye sonra tekrar deneyin.',

    // Two Factor Authentication
    'two_factor_recovery_codes_generated' => 'İki faktörlü kimlik doğrulama kurtarma kodları oluşturuldu.',
    'two_factor_authentication_enabled' => 'İki faktörlü kimlik doğrulama etkinleştirildi.',
    'two_factor_authentication_disabled' => 'İki faktörlü kimlik doğrulama devre dışı bırakıldı.',
    'two_factor_recovery_codes_regenerated' => 'İki faktörlü kimlik doğrulama kurtarma kodları yeniden oluşturuldu.',
    
    // Account Status Messages
    'account_suspended' => 'Hesabınız askıya alınmıştır. Lütfen müşteri hizmetleri ile iletişime geçin.',
    'account_banned' => 'Hesabınız kalıcı olarak yasaklanmıştır. Destek ekibi ile iletişime geçebilirsiniz.',
    'account_inactive' => 'Hesabınız aktif değildir. Lütfen e-posta adresinizi doğrulayın.',
    'account_pending' => 'Hesabınız onay beklemektedir. Lütfen yönetici onayını bekleyin.',
    
    // Login Security Messages  
    'too_many_attempts' => 'Çok fazla başarısız giriş denemesi. Hesabınız :minutes dakika kilitlenmiştir.',
    'account_locked' => 'Hesabınız güvenlik nedeniyle kilitlenmiştir. :time sonra tekrar deneyebilirsiniz.',
    'suspicious_activity' => 'Hesabınızda şüpheli aktivite tespit edilmiştir. Güvenlik kontrolleri aktifleştirilmiştir.',
    
    // Password Related
    'password_expired' => 'Şifrenizin süresi dolmuştur. Lütfen yeni bir şifre belirleyin.',
    'password_weak' => 'Şifreniz güvenlik gereksinimlerini karşılamıyor. Lütfen daha güçlü bir şifre seçin.',
    'password_recently_used' => 'Bu şifreyi yakın zamanda kullanmışsınız. Lütfen farklı bir şifre seçin.',
    
    // Email Verification
    'email_not_verified' => 'E-posta adresiniz doğrulanmamıştır. Lütfen gelen kutunuzu kontrol edin.',
    'verification_link_sent' => 'Doğrulama bağlantısı e-posta adresinize gönderilmiştir.',
    
    // KYC Messages
    'kyc_required' => 'Bu işlemi gerçekleştirmek için kimlik doğrulama (KYC) işlemini tamamlamanız gerekmektedir.',
    'kyc_pending' => 'Kimlik doğrulama belgeleriniz inceleme altındadır. Lütfen bekleyin.',
    'kyc_rejected' => 'Kimlik doğrulama belgeleriniz reddedilmiştir. Lütfen geçerli belgeler ile tekrar deneyin.',
    
];