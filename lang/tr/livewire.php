<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Livewire Component Localization - Monexa Finance Real-time UI
    |--------------------------------------------------------------------------
    |
    | Bu dosya Livewire component'ları için çeviri key'lerini içerir.
    | Real-time UI bileşenleri, admin paneli, finansal işlemler ve
    | kullanıcı arayüzü için tüm hard-coded string'ler burada tanımlıdır.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Admin Security Dashboard - Güvenlik Paneli
    |--------------------------------------------------------------------------
    */
    'security_dashboard' => [
        'ip_blocked_successfully' => 'IP :ip başarıyla engellendi.',
        'ip_unblocked_successfully' => 'IP :ip başarıyla serbest bırakıldı.',
        'rate_limits_reset' => 'Rate limit istatistikleri sıfırlandı.',
        'security_scan_completed' => 'Güvenlik taraması tamamlandı.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Crypto Withdrawal - Kripto Para Çekme
    |--------------------------------------------------------------------------
    */
    'crypto_withdrawal' => [
        'otp_sent_to_email' => 'OTP e-posta adresinize gönderildi',
        'otp_send_failed' => 'OTP gönderimi başarısız. Lütfen tekrar deneyin.',
        'otp_incorrect' => 'OTP yanlış, lütfen kodu kontrol edin',
        'contact_support_error' => 'Bir şeyler ters gitti, problem devam ederse destek ekibimizle iletişime geçin',
        'withdrawal_submitted' => 'Para çekme talebi başarıyla gönderildi',
        'withdrawal_failed' => 'Para çekme işlemi başarısız',
        'withdrawal_error' => 'Para çekme işleminizde bir hata oluştu',
    ],

    /*
    |--------------------------------------------------------------------------
    | Crypto Payment - Kripto Ödeme
    |--------------------------------------------------------------------------
    */
    'crypto_payment' => [
        'session_expired' => 'Ödeme oturumu süresi doldu. Lütfen tekrar deneyin.',
        'order_creation_failed' => 'Ödeme emri oluşturulamadı. Lütfen tekrar deneyin.',
        'payment_error' => 'Bir hata oluştu. Lütfen tekrar deneyin.',
        'deposit_via_crypto' => 'Kripto ile para yatırma',
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Management - Tema Yönetimi
    |--------------------------------------------------------------------------
    */
    'theme_management' => [
        'upload_zip_file' => 'Lütfen bir zip dosyası yükleyin',
        'theme_uploaded' => 'Tema başarıyla yüklendi',
        'upload_error' => 'Tema yüklenirken bir hata oluştu, lütfen tekrar deneyin.',
        'theme_activated' => 'Tema başarıyla etkinleştirildi',
        'cache_cleared' => 'Önbellek başarıyla temizlendi',
    ],

    /*
    |--------------------------------------------------------------------------
    | Slot Management - Slot Yönetimi
    |--------------------------------------------------------------------------
    */
    'slot_management' => [
        'invalid_slot_number' => 'Geçersiz slot sayısı',
    ],

    /*
    |--------------------------------------------------------------------------
    | Software Module - Yazılım Modülü
    |--------------------------------------------------------------------------
    */
    'software_module' => [
        'action_successful' => 'İşlem başarılı',
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Boundary - Hata Yönetimi
    |--------------------------------------------------------------------------
    */
    'error_boundary' => [
        'general_error' => 'Bir hata oluştu',
        'max_retries_reached' => 'Maksimum deneme sayısına ulaşıldı',
        
        // Network error suggestions
        'check_internet_connection' => 'İnternet bağlantınızı kontrol edin',
        'try_refresh_page' => 'Sayfayı yenilemeyi deneyin',
        
        // Financial error suggestions
        'check_balance' => 'Bakiyenizi kontrol edin',
        'try_different_payment' => 'Farklı bir ödeme yöntemi deneyin',
        
        // Authentication error suggestions
        'try_login_again' => 'Tekrar giriş yapmayı deneyin',
        'reset_password' => 'Parolanızı sıfırlayın',
        
        // Validation error suggestions
        'check_form_info' => 'Form bilgilerinizi kontrol edin',
        'fill_required_fields' => 'Gerekli alanları doldurun',
        
        // General error suggestions
        'refresh_page' => 'Sayfayı yenileyin',
        'contact_support' => 'Destek ekibi ile iletişime geçin',
    ],

    /*
    |--------------------------------------------------------------------------
    | Real-time Messages - Gerçek Zamanlı Mesajlar
    |--------------------------------------------------------------------------
    */
    'realtime' => [
        'loading' => 'Yükleniyor...',
        'processing' => 'İşleniyor...',
        'connecting' => 'Bağlanıyor...',
        'connected' => 'Bağlandı',
        'disconnected' => 'Bağlantı kesildi',
        'reconnecting' => 'Yeniden bağlanıyor...',
        'data_updated' => 'Veriler güncellendi',
        'live_updates' => 'Canlı Güncellemeler',
    ],

    /*
    |--------------------------------------------------------------------------
    | Action Labels - Eylem Etiketleri
    |--------------------------------------------------------------------------
    */
    'actions' => [
        'update' => 'Güncelle',
        'delete' => 'Sil',
        'create' => 'Oluştur',
        'save_changes' => 'Değişiklikleri Kaydet',
        'cancel' => 'İptal Et',
        'confirm' => 'Onayla',
        'retry' => 'Tekrar Dene',
        'reset' => 'Sıfırla',
        'export' => 'Dışa Aktar',
        'import' => 'İçe Aktar',
        'refresh' => 'Yenile',
        'search' => 'Ara',
        'filter' => 'Filtrele',
        'clear_filters' => 'Filtreleri Temizle',
    ],

    /*
    |--------------------------------------------------------------------------
    | Status Labels - Durum Etiketleri
    |--------------------------------------------------------------------------
    */
    'status' => [
        'active' => 'Aktif',
        'inactive' => 'Pasif',
        'pending' => 'Beklemede',
        'approved' => 'Onaylandı',
        'rejected' => 'Reddedildi',
        'completed' => 'Tamamlandı',
        'processing' => 'İşleniyor',
        'cancelled' => 'İptal Edildi',
        'success' => 'Başarılı',
        'failed' => 'Başarısız',
    ],

    /*
    |--------------------------------------------------------------------------
    | Form Labels - Form Etiketleri
    |--------------------------------------------------------------------------
    */
    'form' => [
        'amount' => 'Miktar',
        'currency' => 'Para Birimi',
        'payment_method' => 'Ödeme Yöntemi',
        'description' => 'Açıklama',
        'date' => 'Tarih',
        'time' => 'Zaman',
        'reference' => 'Referans',
        'transaction_id' => 'İşlem ID',
        'user_name' => 'Kullanıcı Adı',
        'email' => 'E-posta',
        'phone' => 'Telefon',
        'address' => 'Adres',
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Messages - Doğrulama Mesajları
    |--------------------------------------------------------------------------
    */
    'validation' => [
        'required_field' => 'Bu alan zorunludur',
        'invalid_email' => 'Geçersiz e-posta adresi',
        'invalid_amount' => 'Geçersiz miktar',
        'insufficient_funds' => 'Yetersiz bakiye',
        'min_amount' => 'Minimum miktar: :amount',
        'max_amount' => 'Maksimum miktar: :amount',
        'invalid_format' => 'Geçersiz format',
    ],
];