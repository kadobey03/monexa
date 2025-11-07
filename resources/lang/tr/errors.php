<?php

return [
    // General Error Messages
    'something_went_wrong' => 'Bir hata oluştu',
    'try_again' => 'Lütfen tekrar deneyin',
    'contact_support' => 'Destek ekibi ile iletişime geçin',
    'refresh_page' => 'Sayfayı yenileyin',
    'retry' => 'Tekrar dene',
    'dismiss' => 'Kapat',
    'show_details' => 'Detayları göster',
    'hide_details' => 'Detayları gizle',
    'suggestions' => 'Öneriler',
    
    // Financial Error Messages
    'insufficient_balance' => 'Yetersiz bakiye',
    'invalid_amount' => 'Geçersiz miktar',
    'transaction_failed' => 'İşlem başarısız',
    'limit_exceeded' => 'Limit aşıldı',
    
    // Authentication Error Messages
    'authentication_required' => 'Kimlik doğrulama gerekli',
    'session_expired' => 'Oturum süresi dolmuş',
    'invalid_credentials' => 'Geçersiz kimlik bilgileri',
    
    // Login Error Messages - User Giriş Hataları
    'user_email_not_found' => 'Bu e-posta adresi ile kayıtlı bir hesap bulunamadı. Kayıt olmak için üye ol sekmesini kullanın.',
    'user_wrong_password' => 'Şifreniz hatalı. Kalan deneme hakkınız: :attempts. Şifremi unuttum seçeneğini kullanabilirsiniz.',
    'user_account_locked' => 'Hesabınız güvenlik nedeniyle kilitlenmiştir. :minutes dakika sonra tekrar deneyin.',
    'user_email_not_verified' => 'E-posta adresiniz doğrulanmamış. Lütfen e-posta kutunuzu kontrol edin ve doğrulama linkine tıklayın.',
    
    // Admin Login Error Messages - Admin Giriş Hataları
    'admin_email_not_found' => 'Bu e-posta adresi ile kayıtlı bir admin hesabı bulunamadı.',
    'admin_wrong_password' => 'Şifreniz hatalı. Kalan deneme hakkınız: :attempts',
    'admin_account_locked' => 'Hesabınız güvenlik nedeniyle kilitlenmiştir. :minutes dakika sonra tekrar deneyin.',
    'admin_too_many_attempts' => 'Çok fazla hatalı deneme. Hesabınız güvenlik nedeniyle 30 dakika kilitlenmiştir.',
    
    // Account Status Error Messages - Hesap Durumu Hataları
    'account_inactive' => 'Hesabınız aktif değil. Lütfen sistem yöneticisi ile iletişime geçin.',
    'account_blocked' => 'Hesabınız engellenmiş durumda. Sistem yöneticisi ile iletişime geçin.',
    'account_suspended' => 'Hesabınız geçici olarak askıya alınmıştır.',
    'account_banned' => 'Hesabınız yönetici tarafından engellenmiştir. Destek ekibi ile iletişime geçin.',
    'account_pending' => 'Hesabınız onay beklemektedir. Lütfen bekleyiniz.',
    'account_unavailable' => 'Hesabınız kullanılamaz durumda.',
    
    // Security Error Messages - Güvenlik Hataları
    'too_many_login_attempts' => 'Çok fazla giriş denemesi. :seconds saniye sonra tekrar deneyin.',
    'security_rate_limit' => 'Güvenlik nedeniyle geçici olarak engellendiniz. Lütfen :minutes dakika sonra tekrar deneyin.',
    'suspicious_activity' => 'Şüpheli aktivite tespit edildi. Güvenliğiniz için hesabınız geçici olarak kısıtlandı.',
    'login_from_new_device' => 'Yeni bir cihazdan giriş denemesi tespit edildi. E-posta adresinizi kontrol edin.',
    'ip_address_blocked' => 'IP adresiniz güvenlik nedeniyle engellenmiştir.',
    
    // Two-Factor Authentication Error Messages - 2FA Hataları
    '2fa_code_required' => 'İki faktörlü doğrulama kodu gereklidir.',
    '2fa_code_invalid' => 'Doğrulama kodu hatalı. Lütfen tekrar deneyin.',
    '2fa_code_expired' => 'Doğrulama kodunun süresi dolmuş. Yeni kod talep edin.',
    '2fa_email_send_failed' => '2FA kodu gönderilemedi. Lütfen sistem yöneticisi ile iletişime geçin.',
    '2fa_code_sent' => 'İki faktörlü doğrulama kodu e-posta adresinize gönderildi.',
    '2fa_verification_required' => 'Giriş işlemini tamamlamak için 2FA kodunu girin.',
    
    // Password Policy Error Messages - Şifre Politikası Hataları
    'password_too_short' => 'Şifre en az :min karakter olmalıdır.',
    'password_no_uppercase' => 'Şifre en az bir büyük harf içermelidir.',
    'password_no_lowercase' => 'Şifre en az bir küçük harf içermelidir.',
    'password_no_number' => 'Şifre en az bir rakam içermelidir.',
    'password_no_special' => 'Şifre en az bir özel karakter içermelidir.',
    'password_weak' => 'Şifre en az bir büyük harf, bir küçük harf ve bir rakam içermelidir.',
    
    // Success Messages - Başarı Mesajları
    'login_success' => 'Başarıyla giriş yaptınız. Hoş geldiniz!',
    'admin_login_success' => 'Admin paneline başarıyla giriş yaptınız.',
    '2fa_setup_success' => 'İki faktörlü doğrulama başarıyla ayarlandı.',
    'password_changed_success' => 'Şifreniz başarıyla değiştirildi.',
    'account_verified_success' => 'Hesabınız başarıyla doğrulandı.',
    
    // Network Error Messages
    'network_error' => 'Ağ bağlantı hatası',
    'server_unavailable' => 'Sunucu geçici olarak kullanılamıyor',
    'request_timeout' => 'İstek zaman aşımı',
    
    // Validation Error Messages
    'validation_failed' => 'Doğrulama başarısız',
    'required_field' => 'Bu alan gereklidir',
    'invalid_format' => 'Geçersiz format',
    
    // System Error Messages
    'maintenance_mode' => 'Sistem bakım modunda',
    'overloaded' => 'Sistem geçici olarak yoğun',
    'temporary_error' => 'Geçici bir hata oluştu',
    
    // Specific Error Messages
    'server_error' => 'Sunucu hatası',
    'page_not_found' => 'Sayfa bulunamadı',
    'access_denied' => 'Erişim engellendi',
    'rate_limit_exceeded' => 'İstek limiti aşıldı',
    
    // Error Actions
    'go_back' => 'Geri dön',
    'go_home' => 'Ana sayfaya git',
    'login_again' => 'Tekrar giriş yap',
    'reset_password' => 'Şifreyi sıfırla',
    'check_connection' => 'Bağlantıyı kontrol et',
    'wait_and_retry' => 'Bekleyip tekrar deneyin',
];