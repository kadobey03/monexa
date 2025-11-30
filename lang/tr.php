<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Email Template Localization - Monexa Finance Platform
    |--------------------------------------------------------------------------
    |
    | Bu çeviri dosyası Monexa Finance email template'leri için localization
    | key'lerini içerir. Tüm email bildirimleri bu key'ler kullanılarak
    | çok dilli destek sağlar.
    |
    */

    'mail' => [
        
        /*
        |--------------------------------------------------------------------------
        | Mail Subjects - Email Başlıkları
        |--------------------------------------------------------------------------
        */
        'subjects' => [
            'plan_completed' => 'Yatırım Planı Tamamlandı: :planName',
            'welcome' => ':siteName\'e Hoşgeldiniz',
            'deposit_confirmation' => 'Para Yatırma Onayı',
            'withdrawal_update' => 'Para Çekme Güncellemesi',
            'roi_generated' => 'Portföy Güncellemesi - Yatırım Getirileri',
            'two_factor_code' => '2FA Kodu',
            'investment_completed' => 'Yatırım Tamamlandı',
            'demo_account' => 'Demo Hesap Bilgileri',
        ],

        /*
        |--------------------------------------------------------------------------
        | Mail Headers - Email Başlıkları
        |--------------------------------------------------------------------------
        */
        'headers' => [
            'deposit_success' => 'Para Yatırma Onayı - :type',
            'deposit_success_admin' => 'Yeni Para Yatırma İşlemi - Yönetici Bildirimi',
            'withdrawal_status' => 'Para Çekme Talebi - :status',
            'roi_update' => 'Portföy Güncellemesi - Yatırım Getirileri Oluşturuldu 📈',
            'plan_completed' => 'Yatırım Planı Tamamlandı',
            'welcome' => ':siteName\'a hoş geldiniz, :userName!',
            'security_alert' => 'Güvenlik Bildirimi',
            'important_update' => 'Önemli Güncelleme',
            'account_notification' => 'Hesap Bildirimi',
            'congratulations' => 'Tebrikler!',
        ],

        /*
        |--------------------------------------------------------------------------
        | Financial Content - Mali İçerik
        |--------------------------------------------------------------------------
        */
        'financial' => [
            'deposit_processed' => 'Tebrikler! Para yatırmanız başarıyla işlendi.',
            'deposit_amount_received' => ':currency:amount tutarındaki para yatırmanızın alındığını doğrulamaktan memnuniyet duyuyoruz.',
            'withdrawal_completed' => 'Para çekme işleminiz başarıyla işlendi! 🎉',
            'withdrawal_processed' => 'Para çekme talebiniz işlendi ve ödeme sürecine alınmıştır.',
            'withdrawal_pending_review' => 'Para çekme talebiniz inceleme aşamasında. Lütfen biraz bekleyin.',
            'roi_generated' => 'Tebrikler! Yatırım portföyünüz yeni getiriler oluşturdu.',
            'investment_details' => 'Yatırım Detayları',
            'transaction_details' => 'İşlem Detayları',
            'amount' => 'Miktar',
            'status' => 'Durum',
            'plan' => 'Plan',
            'profit' => 'Kar',
            'total_return' => 'Toplam Getiri',
            'balance_update' => 'Bakiye Güncellemesi',
            'deposit_method' => 'Para Yatırma Yöntemi',
            'reference_number' => 'Referans Numarası',
            'processing_time' => 'İşleme Süresi',
            'admin_review_required' => 'Admin onayı bekleniyor',
            'automatically_processed' => 'Otomatik olarak işlendi',
        ],

        /*
        |--------------------------------------------------------------------------
        | Investment Content - Yatırım İçeriği
        |--------------------------------------------------------------------------
        */
        'investment' => [
            'performance_summary' => 'Yatırım Performans Özeti',
            'next_steps' => 'Sonraki Adımlar',
            'growth_potential' => 'Büyüme Potansiyelinizi Azami Düzeye Çıkarın',
            'portfolio_optimization' => 'Portföy optimizasyonu',
            'market_analysis' => 'Piyasa Analizi',
            'risk_management' => 'Risk Yönetimi',
            'roi_calculation' => 'ROI Hesaplaması',
            'investment_duration' => 'Yatırım Süresi',
            'expected_returns' => 'Beklenen Getiriler',
            'market_insights' => 'Piyasa İçgörüleri',
            'performance_metrics' => 'Performans Metrikleri',
            'diversification' => 'Çeşitlendirme',
            'compound_interest' => 'Bileşik Faiz',
            'reinvestment_options' => 'Yeniden Yatırım Seçenekleri',
            'capital_growth' => 'Sermaye Büyümesi',
            'dividend_income' => 'Temettü Geliri',
            'quarterly_review' => 'Üç Aylık İnceleme',
            'annual_summary' => 'Yıllık Özet',
            'milestone_achieved' => 'Hedef Başarıldı',
        ],

        /*
        |--------------------------------------------------------------------------
        | Action Buttons - Eylem Butonları
        |--------------------------------------------------------------------------
        */
        'actions' => [
            'start_trading' => 'Şimdi Ticaret Başlat',
            'view_account' => 'Hesabımı Görüntüle',
            'contact_support' => 'Destek ile İletişime Geçin',
            'contact_support_team' => 'Destek Ekibiyle İletişime Geçin',
            'view_dashboard' => 'Panonuza Erişin',
            'track_withdrawal' => 'Para Çekme Durumunu Takip Et',
            'view_portfolio' => 'Portföy Performansını Görüntüle',
            'manage_notifications' => 'Bildirimleri Yönet',
            'access_dashboard' => 'Panoya Erişin',
            'explore_plans' => 'Yatırım Planlarını Keşfet',
            'reinvest_now' => 'Şimdi Yeniden Yatırım Yap',
            'withdraw_funds' => 'Para Çek',
        ],

        /*
        |--------------------------------------------------------------------------
        | Security & Alerts - Güvenlik ve Uyarılar
        |--------------------------------------------------------------------------
        */
        'security' => [
            'two_factor_code' => '2FA kodu',
            'account_verification' => 'Hesabınız kullanılarak geçici bir 2FA kodu isteği yapıldı.',
            'verify_identity' => 'Lütfen aşağıdaki detayları kullanarak kimlik doğrulayın',
            'warning' => 'Güvenlik Bildirimi',
            'never_ask_credentials' => 'hiçbir zaman giriş kimlik bilgilerinizi e-posta yoluyla sormayacaktır.',
            'never_ask_credentials_detailed' => ':appName hiçbir zaman giriş kimlik bilgilerinizi, şifrelerinizi veya hassas hesap bilgilerinizi e-posta yoluyla sormayacaktır. Şüpheli iletişimler alırsanız, lütfen güvenlik ekibimizle hemen iletişime geçin.',
            'security_notice_title' => 'Güvenlik Bildirimi',
            'important_label' => 'Önemli',
            'code_expires' => 'Bu kod 10 dakika içinde geçerliliğini yitirecektir',
            'do_not_share_code' => 'Bu kodu kimseyle paylaşmayın',
            'suspicious_activity' => 'Şüpheli aktivite bildirin',
        ],

        /*
        |--------------------------------------------------------------------------
        | Support & Help - Destek ve Yardım
        |--------------------------------------------------------------------------
        */
        'support' => [
            'need_help_title' => 'Yardıma İhtiyacınız Var mı?',
            'notification_questions' => 'Bu bildirimle ilgili sorularınız varsa veya yatırım ile ilgili konularda açıklama ihtiyacınız varsa, profesyonel destek ekibimiz burada yardımcı olmaya hazır.',
            'quick_options_title' => 'Hızlı Destek Seçenekleri',
            'live_chat' => '7/24 Canlı Sohbet',
            'instant_help_dashboard' => 'Panonuz aracılığıyla anında yardım',
            'email_support' => 'E-posta Desteği',
            'phone_support' => 'Telefon Desteği',
            'business_hours' => 'İş saatleri boyunca mevcut',
            'investment_advisory' => 'Yatırım Danışmanlığı',
            'schedule_consultation' => 'Uzmanlarımızla danışmanlık planlayın',
            'customer_success' => 'Müşteri Başarı Ekibi',
            'technical_support' => 'Teknik Destek',
            'account_assistance' => 'Hesap Yardımı',
        ],

        /*
        |--------------------------------------------------------------------------
        | Notifications & Updates - Bildirimler ve Güncellemeler
        |--------------------------------------------------------------------------
        */
        'notifications' => [
            'preferences_title' => 'Bildirim Tercihleri',
            'manage_preferences_desc' => 'Bildirim tercihlerinizi yönetebilir ve hesap ayarlarınız üzerinden hangi güncellemeleri almak istediğinizi seçebilirsiniz.',
        ],

        'updates' => [
            'stay_informed_title' => 'Bilgilendirilmiş Kalın',
            'track_journey' => 'Yatırım yolculuğunuzu takip edin',
            'portfolio_performance' => 'Portföy performans güncellemeleri',
            'market_insights' => 'Piyasa içgörüleri ve analizleri',
            'trading_opportunities' => 'Ticaret fırsatları ve uyarıları',
            'security_notifications' => 'Hesap güvenliği bildirimleri',
            'platform_updates' => 'Platform güncellemeleri ve yeni özellikler',
        ],

        /*
        |--------------------------------------------------------------------------
        | Attachments - Ekler
        |--------------------------------------------------------------------------
        */
        'attachments' => [
            'document_attached' => 'Eklenen Belge',
            'review_details' => 'Bu bildirimle ilgili ek detaylar için lütfen eklenen belgeyi inceleyin.',
        ],

        /*
        |--------------------------------------------------------------------------
        | Footer & Legal - Altbilgi ve Hukuki
        |--------------------------------------------------------------------------
        */
        'footer' => [
            'regards' => 'Saygılarımla',
            'team' => ':siteName Ekibi',
            'app_team' => ':appName Ekibi',
            'financial_team' => ':siteName Finansal Operasyon Ekibi',
            'investment_team' => ':siteName Yatırım Ekibi',
            'trusted_investment_partner' => 'Güvenilir Yatırım Ortağınız',
            'auto_generated' => 'Bu e-posta otomatik olarak gönderilmiştir.',
            'do_not_reply' => 'Lütfen bu e-postaya yanıt vermeyin.',
        ],

        'legal' => [
            'risk_disclaimer' => 'Yatırım Sorumluluk Reddi',
            'past_performance' => 'Geçmiş performans gelecek sonuçları garanti etmez.',
            'investment_risk' => 'Tüm yatırımlar risk taşır.',
            'financial_advice' => 'Bu bildirim sadece bilgilendirme amaçlıdır.',
            'notification_sent_disclaimer' => 'Bu bildirim, :appName hesap iletişimlerinizin bir parçası olarak size gönderildi. Bu e-postayı yanlışlıkla aldığınızı düşünüyorsanız veya hesap güvenliğiniz hakkında endişeleriniz varsa, lütfen destek ekibimizle hemen iletişime geçin.',
            'update_preferences_info' => 'İletişim tercihlerinizi güncelleyebilir veya belirli bildirimlerden çıkabilirsiniz',
            'account_settings_link' => 'Hesap Ayarları',
            'security_notifications_recommendation' => 'aracılığıyla. Önemli güvenlik ve hesap ile ilgili bildirimler için, bildirimleri etkin tutmanızı öneririz.',
            'all_rights_reserved' => 'Tüm hakları saklıdır.',
            'privacy_policy' => 'Gizlilik Politikası',
            'terms_of_service' => 'Hizmet Şartları',
        ],

        /*
        |--------------------------------------------------------------------------
        | Plans & Investment Management - Plan ve Yatırım Yönetimi
        |--------------------------------------------------------------------------
        */
        'plans' => [
            'expiry_notification' => 'Bu, yatırım planınızın (:planName planı) süresi dolduğunu ve bu plan için sermayenizin çekim için hesabınıza eklendiğini bildirmek için.',
            'plan_details' => 'Plan Detayları',
            'completion_message' => 'Yatırım planınız başarıyla tamamlandı!',
            'capital_returned' => 'Sermayeniz hesabınıza iade edildi',
            'profit_earned' => 'Kazandığınız kar',
            'next_investment' => 'Sonraki Yatırım Fırsatları',
        ],

        /*
        |--------------------------------------------------------------------------
        | Demo Account - Demo Hesap
        |--------------------------------------------------------------------------
        */
        'demo' => [
            'welcome_title' => ':siteName\'a hoş geldiniz!',
            'registration_success' => 'Kayıt işleminiz başarılı ve sizi :siteName topluluğuna katılmanızdan gerçekten heyecanlıyız!',
            'generated_password_label' => 'Sistem tarafından oluşturulan şifreniz:',
            'change_password_instruction' => 'Lütfen bu şifreyi tercih ettiğiniz bir şifreye değiştirin.',
            'help_contact_message' => 'Herhangi bir yardıma ihtiyacınız olursa, bizimle iletişime geçmekten çekinmeyin',
        ],

        /*
        |--------------------------------------------------------------------------
        | Common Elements - Ortak Elemanlar
        |--------------------------------------------------------------------------
        */
        'common' => [
            'date' => 'Tarih',
            'time' => 'Zaman',
            'reference' => 'Referans',
            'confirmation' => 'Onay',
            'processing' => 'İşleniyor',
            'completed' => 'Tamamlandı',
            'pending' => 'Beklemede',
            'approved' => 'Onaylandı',
            'rejected' => 'Reddedildi',
            'cancelled' => 'İptal Edildi',
        ],

        /*
        |--------------------------------------------------------------------------
        | Greetings - Selamlamalar
        |--------------------------------------------------------------------------
        */
        'greetings' => [
            'hello' => 'Merhaba',
            'dear' => 'Sayın',
            'welcome' => 'Hoş Geldiniz',
            'good_morning' => 'Günaydın',
            'good_evening' => 'İyi Akşamlar',
        ],

        /*
        |--------------------------------------------------------------------------
        | Admin Notifications - Yönetici Bildirimleri
        |--------------------------------------------------------------------------
        */
        'admin' => [
            'new_deposit' => 'Yeni Para Yatırma İşlemi',
            'deposit_notification' => ':userName tarafından yeni bir para yatırma işlemi gerçekleştirildi.',
            'user_details' => 'Kullanıcı Detayları',
            'immediate_action' => 'Hemen İnceleme Gerekli',
            'admin_panel_access' => 'Yönetici Paneline Erişin',
        ],

        /*
        |--------------------------------------------------------------------------
        | Status Messages - Durum Mesajları
        |--------------------------------------------------------------------------
        */
        'status' => [
            'successful' => 'Başarılı',
            'failed' => 'Başarısız',
            'in_progress' => 'Devam Ediyor',
            'under_review' => 'İnceleme Altında',
            'requires_action' => 'Eylem Gerekiyor',
        ],

        /*
        |--------------------------------------------------------------------------
        | Trading & Markets - Ticaret ve Piyasalar
        |--------------------------------------------------------------------------
        */
        'trading' => [
            'market_update' => 'Piyasa Güncellemesi',
            'price_alert' => 'Fiyat Uyarısı',
            'trading_opportunity' => 'Ticaret Fırsatı',
            'market_analysis' => 'Piyasa Analizi',
            'technical_analysis' => 'Teknik Analiz',
            'fundamental_analysis' => 'Temel Analiz',
            'risk_assessment' => 'Risk Değerlendirmesi',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | API Response Localization - Monexa Finance Backend-Frontend İletişimi
    |--------------------------------------------------------------------------
    |
    | Bu bölüm API response'ları için çeviri key'lerini içerir.
    | Controller, Service, AJAX endpoint'leri ve tüm API iletişiminde
    | kullanılan hard-coded mesajlar burada tanımlıdır.
    |
    */

    'api' => [

        /*
        |--------------------------------------------------------------------------
        | Financial API Responses - Mali İşlem API Response'ları
        |--------------------------------------------------------------------------
        */
        'financial' => [
            // Deposit responses
            'deposit_successful' => 'Para yatırma işleminiz başarıyla tamamlandı',
            'deposit_failed' => 'Para yatırma işlemi başarısız',
            'deposit_processing' => 'Para yatırma işleminiz işleniyor, lütfen bekleyiniz',
            'deposit_verified' => 'Para yatırma işleminiz doğrulandı',
            
            // Withdrawal responses
            'withdrawal_successful' => 'Para çekme işleminiz başarıyla tamamlandı',
            'withdrawal_failed' => 'Para çekme işlemi başarısız',
            'withdrawal_processing' => 'Para çekme işleminiz işleniyor',
            'withdrawal_pending_review' => 'Para çekme talebiniz inceleme aşamasında',
            
            // Balance & Amount responses
            'insufficient_balance' => 'Yetersiz bakiye',
            'invalid_amount' => 'Geçersiz miktar',
            'amount_required' => 'Miktar alanı zorunludur',
            'minimum_amount_error' => 'Minimum miktar: :amount :currency',
            'maximum_amount_error' => 'Maksimum miktar: :amount :currency',
            'balance_updated' => 'Bakiyeniz güncellendi',
            
            // Transaction responses
            'transaction_successful' => 'İşlem başarıyla tamamlandı',
            'transaction_failed' => 'İşlem başarısız',
            'transaction_processing' => 'İşleminiz işleniyor, lütfen bekleyiniz',
            'transaction_completed' => 'İşlem başarıyla tamamlandı',
            'transaction_cancelled' => 'İşlem iptal edildi',
            
            // Payment responses
            'payment_successful' => 'Ödeme başarılı',
            'payment_failed' => 'Ödeme başarısız',
            'payment_verified' => 'Ödeme doğrulandı',
            'payment_processing' => 'Ödeme işleniyor',
            'payment_cancelled' => 'Ödeme iptal edildi',
            
            // Currency & Exchange responses
            'currency_invalid' => 'Geçersiz para birimi',
            'exchange_rate_error' => 'Döviz kuru alınamadı',
            'currency_not_supported' => 'Para birimi desteklenmiyor',
            
            // Financial limits & restrictions
            'daily_limit_exceeded' => 'Günlük limit aşıldı',
            'monthly_limit_exceeded' => 'Aylık limit aşıldı',
            'transaction_limit_exceeded' => 'İşlem limiti aşıldı',
            'account_restricted' => 'Hesabınız kısıtlanmış',
            
            // Investment responses
            'investment_successful' => 'Yatırım başarıyla oluşturuldu',
            'investment_failed' => 'Yatırım oluşturulamadı',
            'plan_not_found' => 'Yatırım planı bulunamadı',
            'plan_not_active' => 'Yatırım planı aktif değil',
            'investment_completed' => 'Yatırımınız tamamlandı',
            
            // Transfer responses
            'transfer_successful' => 'Transfer işlemi tamamlandı, sayfa yenileniyor',
            'transfer_self_error' => 'Kendi kendinize para gönderemezsiniz',
            
            // Exchange responses
            'exchange_successful' => 'Döviz işlemi başarıyla tamamlandı! Bakiyeleriniz yenileniyor',
            'exchange_failed' => 'Döviz işlemi başarısız. Lütfen tekrar deneyin',
            'same_currency_error' => 'Kaynak ve hedef para birimleri aynı olamaz',
            'exchange_rate_unavailable' => 'Döviz kuru alınamadı: :currency. Lütfen tekrar deneyin',
            'insufficient_crypto_balance' => 'Yetersiz :currency bakiyesi. Mevcut: :balance',
            'insufficient_usd_balance' => 'Yetersiz USD bakiyesi. Mevcut: :balance',
            'withdrawal_info_updated' => 'Para çekme bilgileri başarıyla güncellendi',
        ],

        /*
        |--------------------------------------------------------------------------
        | Security API Responses - Güvenlik API Response'ları
        |--------------------------------------------------------------------------
        */
        'security' => [
            // Authentication responses
            'login_successful' => 'Giriş başarılı, yönlendiriliyorsunuz',
            'login_failed' => 'Giriş başarısız, bilgilerinizi kontrol edin',
            'logout_successful' => 'Güvenli çıkış yapıldı',
            'session_expired' => 'Oturum süresi doldu, lütfen tekrar giriş yapın',
            
            // Authorization responses
            'unauthorized_access' => 'Yetkisiz erişim denemesi',
            'access_denied' => 'Erişim reddedildi',
            'permission_denied' => 'Bu işlem için yetkiniz yok',
            'account_suspended' => 'Hesabınız askıya alınmış',
            
            // 2FA & Security responses
            'two_factor_required' => '2FA doğrulaması gerekli',
            'two_factor_verified' => '2FA doğrulaması başarılı',
            'two_factor_failed' => '2FA doğrulaması başarısız',
            'invalid_2fa_code' => 'Geçersiz 2FA kodu',
            'two_factor_code_sent' => '2FA kodu gönderildi',
            
            // Account security responses
            'account_locked' => 'Hesabınız geçici olarak kilitlendi',
            'account_verified' => 'Hesabınız doğrulandı',
            'email_verification_required' => 'E-posta doğrulaması gerekli',
            'email_verified' => 'E-posta adresiniz doğrulandı',
            
            // Password responses
            'password_reset_sent' => 'Şifre sıfırlama bağlantısı gönderildi',
            'password_reset_successful' => 'Şifreniz başarıyla güncellendi',
            'password_reset_failed' => 'Şifre sıfırlama başarısız',
            'current_password_incorrect' => 'Mevcut şifre yanlış',
            'password_changed' => 'Şifreniz değiştirildi',
            
            // KYC responses
            'kyc_required' => 'KYC doğrulaması gerekli',
            'kyc_pending' => 'KYC doğrulamanız beklemede',
            'kyc_approved' => 'KYC doğrulamanız onaylandı',
            'kyc_rejected' => 'KYC doğrulamanız reddedildi',
            'kyc_documents_uploaded' => 'KYC dokümanları yüklendi',
            
            // Security alerts
            'suspicious_activity' => 'Şüpheli aktivite tespit edildi',
            'security_alert' => 'Güvenlik uyarısı',
            'ip_blocked' => 'IP adresiniz engellenmiştir',
            'multiple_failed_attempts' => 'Çoklu başarısız giriş denemesi',
        ],

        /*
        |--------------------------------------------------------------------------
        | Validation API Responses - Doğrulama API Response'ları
        |--------------------------------------------------------------------------
        */
        'validation' => [
            // General validation
            'validation_failed' => 'Doğrulama başarısız',
            'required_field' => ':field alanı zorunludur',
            'invalid_format' => 'Geçersiz format',
            'data_invalid' => 'Geçersiz veri',
            
            // Email validation
            'invalid_email' => 'Geçersiz e-posta adresi',
            'email_already_exists' => 'Bu e-posta adresi zaten kullanılıyor',
            'email_required' => 'E-posta adresi zorunludur',
            
            // Phone validation
            'invalid_phone' => 'Geçersiz telefon numarası',
            'phone_required' => 'Telefon numarası zorunludur',
            'phone_already_exists' => 'Bu telefon numarası zaten kullanılıyor',
            
            // Password validation
            'password_required' => 'Şifre zorunludur',
            'password_too_short' => 'Şifre en az 8 karakter olmalıdır',
            'password_too_weak' => 'Şifre çok zayıf',
            'password_mismatch' => 'Şifreler eşleşmiyor',
            'password_confirmation_required' => 'Şifre onayı zorunludur',
            
            // Numeric validation
            'numeric_required' => 'Sayısal değer gerekli',
            'invalid_number' => 'Geçersiz sayı',
            'number_too_small' => 'Sayı çok küçük',
            'number_too_large' => 'Sayı çok büyük',
            
            // Date validation
            'invalid_date' => 'Geçersiz tarih formatı',
            'date_required' => 'Tarih zorunludur',
            'future_date_required' => 'Gelecek tarih gerekli',
            'past_date_required' => 'Geçmiş tarih gerekli',
            
            // File validation
            'file_required' => 'Dosya zorunludur',
            'file_too_large' => 'Dosya boyutu çok büyük (Max: :size)',
            'invalid_file_type' => 'Geçersiz dosya türü',
            'file_upload_failed' => 'Dosya yükleme başarısız',
            
            // Custom business validation
            'age_restriction' => 'Yaş sınırı: En az 18 yaşında olmalısınız',
            'country_not_supported' => 'Ülkeniz desteklenmiyor',
            'duplicate_entry' => 'Kayıt zaten mevcut',
            'invalid_selection' => 'Geçersiz seçim',
        ],

        /*
        |--------------------------------------------------------------------------
        | Admin API Responses - Yönetici API Response'ları
        |--------------------------------------------------------------------------
        */
        'admin' => [
            // General admin actions
            'action_successful' => 'İşlem başarıyla tamamlandı',
            'action_failed' => 'İşlem başarısız',
            'changes_saved' => 'Değişiklikler kaydedildi',
            'settings_updated' => 'Ayarlar güncellendi',
            
            // User management
            'user_created' => 'Kullanıcı başarıyla oluşturuldu',
            'user_updated' => 'Kullanıcı bilgileri güncellendi',
            'user_deleted' => 'Kullanıcı silindi',
            'user_not_found' => 'Kullanıcı bulunamadı',
            'user_blocked' => 'Kullanıcı engellendi',
            'user_unblocked' => 'Kullanıcı engellemesi kaldırıldı',
            'user_activated' => 'Kullanıcı aktifleştirildi',
            'user_deactivated' => 'Kullanıcı pasifleştirildi',
            
            // Content management
            'content_created' => 'İçerik oluşturuldu',
            'content_updated' => 'İçerik güncellendi',
            'content_deleted' => 'İçerik silindi',
            'content_published' => 'İçerik yayınlandı',
            'content_unpublished' => 'İçerik yayından kaldırıldı',
            
            // System operations
            'cache_cleared' => 'Önbellek temizlendi',
            'database_backup_created' => 'Veritabanı yedeği oluşturuldu',
            'system_maintenance_enabled' => 'Sistem bakım modu etkinleştirildi',
            'system_maintenance_disabled' => 'Sistem bakım modu devre dışı bırakıldı',
            'logs_cleared' => 'Loglar temizlendi',
            
            // Import/Export operations
            'import_successful' => 'İçe aktarma başarılı',
            'import_failed' => 'İçe aktarma başarısız',
            'export_successful' => 'Dışa aktarma başarılı',
            'export_failed' => 'Dışa aktarma başarısız',
            'data_processed' => 'Veriler işlendi',
            
            // Permission & Role management
            'permission_granted' => 'İzin verildi',
            'permission_revoked' => 'İzin iptal edildi',
            'role_assigned' => 'Rol atandı',
            'role_removed' => 'Rol kaldırıldı',
            'access_level_changed' => 'Erişim seviyesi değiştirildi',
            
            // Financial admin operations
            'deposit_approved' => 'Para yatırma onaylandı',
            'deposit_rejected' => 'Para yatırma reddedildi',
            'withdrawal_approved' => 'Para çekme onaylandı',
            'withdrawal_rejected' => 'Para çekme reddedildi',
            'transaction_reversed' => 'İşlem tersine çevrildi',
            'balance_adjusted' => 'Bakiye düzenlendi',
        ],

        /*
        |--------------------------------------------------------------------------
        | User Management API Responses - Kullanıcı Yönetimi API Response'ları
        |--------------------------------------------------------------------------
        */
        'user' => [
            // Profile operations
            'profile_updated' => 'Profil bilgileri güncellendi',
            'profile_update_failed' => 'Profil güncellemesi başarısız',
            'avatar_updated' => 'Profil resmi güncellendi',
            'avatar_removed' => 'Profil resmi kaldırıldı',
            
            // Contact information
            'email_updated' => 'E-posta adresi güncellendi',
            'phone_updated' => 'Telefon numarası güncellendi',
            'address_updated' => 'Adres bilgileri güncellendi',
            'contact_info_verified' => 'İletişim bilgileri doğrulandı',
            
            // Account settings
            'preferences_saved' => 'Tercihleriniz kaydedildi',
            'notification_settings_updated' => 'Bildirim ayarları güncellendi',
            'privacy_settings_updated' => 'Gizlilik ayarları güncellendi',
            'language_changed' => 'Dil değiştirildi',
            'timezone_updated' => 'Saat dilimi güncellendi',
            
            // Document management
            'document_uploaded' => 'Doküman başarıyla yüklendi',
            'document_rejected' => 'Doküman reddedildi',
            'document_approved' => 'Doküman onaylandı',
            'document_deleted' => 'Doküman silindi',
            
            // Notifications
            'notification_sent' => 'Bildirim gönderildi',
            'notification_read' => 'Bildirim okundu olarak işaretlendi',
            'all_notifications_read' => 'Tüm bildirimler okundu olarak işaretlendi',
            'notification_deleted' => 'Bildirim silindi',
        ],

        /*
        |--------------------------------------------------------------------------
        | Trading API Responses - İşlem Platformu API Response'ları
        |--------------------------------------------------------------------------
        */
        'trading' => [
            // Order management
            'order_placed' => 'Emir başarıyla verildi',
            'order_cancelled' => 'Emir iptal edildi',
            'order_executed' => 'Emir gerçekleştirildi',
            'order_expired' => 'Emrin süresi doldu',
            'order_rejected' => 'Emir reddedildi',
            'order_modified' => 'Emir değiştirildi',
            
            // Position management
            'position_opened' => 'Pozisyon açıldı',
            'position_closed' => 'Pozisyon kapatıldı',
            'position_modified' => 'Pozisyon değiştirildi',
            'position_liquidated' => 'Pozisyon tasfiye edildi',
            
            // Market status
            'market_open' => 'Piyasa açık',
            'market_closed' => 'Piyasa kapalı',
            'market_suspended' => 'Piyasa askıda',
            'trading_halted' => 'İşlemler durduruldu',
            
            // Risk management
            'insufficient_margin' => 'Yetersiz marjin',
            'margin_call' => 'Marjin tamamlama uyarısı',
            'stop_loss_triggered' => 'Zarar durdur tetiklendi',
            'take_profit_triggered' => 'Kar al tetiklendi',
            'risk_limit_exceeded' => 'Risk limiti aşıldı',
            
            // Copy trading
            'copy_trade_started' => 'Kopya işlem başlatıldı',
            'copy_trade_stopped' => 'Kopya işlem durduruldu',
            'master_trader_followed' => 'Ana işlemci takip edildi',
            'master_trader_unfollowed' => 'Ana işlemci takipten çıkarıldı',
        ],

        /*
        |--------------------------------------------------------------------------
        | System Error API Responses - Sistem Hata API Response'ları
        |--------------------------------------------------------------------------
        */
        'errors' => [
            // General errors
            'server_error' => 'Sunucu hatası oluştu',
            'service_unavailable' => 'Servis geçici olarak kullanılamıyor',
            'maintenance_mode' => 'Site bakım modunda',
            'too_many_requests' => 'Çok fazla istek, lütfen bekleyiniz',
            'request_timeout' => 'İstek zaman aşımına uğradı',
            
            // Database errors
            'database_error' => 'Veritabanı bağlantı hatası',
            'database_timeout' => 'Veritabanı zaman aşımı',
            'data_not_found' => 'Veri bulunamadı',
            'database_maintenance' => 'Veritabanı bakım modunda',
            
            // API errors
            'external_api_error' => 'Harici API hatası',
            'api_rate_limit_exceeded' => 'API istek limiti aşıldı',
            'api_connection_failed' => 'API bağlantısı başarısız',
            'invalid_api_response' => 'Geçersiz API yanıtı',
            
            // Network errors
            'network_error' => 'Ağ bağlantı hatası',
            'connection_timeout' => 'Bağlantı zaman aşımı',
            'connection_refused' => 'Bağlantı reddedildi',
            'network_unreachable' => 'Ağa erişilemiyor',
            
            // Processing errors
            'processing_failed' => 'İşleme hatası',
            'calculation_error' => 'Hesaplama hatası',
            'data_corruption' => 'Veri bozulması',
            'operation_failed' => 'İşlem başarısız',
        ],

        /*
        |--------------------------------------------------------------------------
        | Success API Responses - Başarı API Response'ları
        |--------------------------------------------------------------------------
        */
        'success' => [
            // General success messages
            'operation_completed' => 'İşlem başarıyla tamamlandı',
            'data_saved' => 'Veriler başarıyla kaydedildi',
            'data_updated' => 'Veriler başarıyla güncellendi',
            'data_deleted' => 'Veriler başarıyla silindi',
            'changes_applied' => 'Değişiklikler uygulandı',
            
            // Communication success
            'email_sent' => 'E-posta başarıyla gönderildi',
            'sms_sent' => 'SMS başarıyla gönderildi',
            'notification_delivered' => 'Bildirim başarıyla iletildi',
            'message_sent' => 'Mesaj gönderildi',
            
            // File operations success
            'file_uploaded' => 'Dosya başarıyla yüklendi',
            'file_deleted' => 'Dosya başarıyla silindi',
            'backup_created' => 'Yedek başarıyla oluşturuldu',
            'export_completed' => 'Dışa aktarma tamamlandı',
            'import_completed' => 'İçe aktarma tamamlandı',
            
            // System operations success
            'sync_completed' => 'Senkronizasyon tamamlandı',
            'update_completed' => 'Güncelleme tamamlandı',
            'installation_completed' => 'Kurulum tamamlandı',
            'configuration_saved' => 'Yapılandırma kaydedildi',
            'system_optimized' => 'Sistem optimize edildi',
            'registration_successful' => 'Kayıt işlemi başarılı',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire Component Localization - Monexa Finance Real-time UI
    |--------------------------------------------------------------------------
    |
    | Bu bölüm Livewire component'ları için çeviri key'lerini içerir.
    | Real-time UI bileşenleri, admin paneli, finansal işlemler ve
    | kullanıcı arayüzü için tüm hard-coded string'ler burada tanımlıdır.
    |
    */

    'livewire' => [

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

    ],

    /*
    |--------------------------------------------------------------------------
    | JavaScript Frontend Localization - Monexa Finance JavaScript Entegrasyonu
    |--------------------------------------------------------------------------
    |
    | Bu bölüm frontend JavaScript dosyalarındaki hard-coded string'ler için
    | çeviri key'lerini içerir. Alert mesajları, form validation, AJAX responses,
    | trading interface ve real-time bildirimler için tanımlanmıştır.
    |
    */

    'js' => [

        /*
        |--------------------------------------------------------------------------
        | JavaScript Success Messages - Başarı Mesajları
        |--------------------------------------------------------------------------
        */
        'success' => [
            'operation_completed' => 'İşlem başarıyla tamamlandı',
            'data_saved' => 'Veriler başarıyla kaydedildi',
            'data_updated' => 'Veriler başarıyla güncellendi',
            'data_deleted' => 'Veriler başarıyla silindi',
            'file_uploaded' => 'Dosya başarıyla yüklendi',
            'email_sent' => 'E-posta başarıyla gönderildi',
            'changes_saved' => 'Değişiklikler kaydedildi',
            'settings_updated' => 'Ayarlar güncellendi',
            'profile_updated' => 'Profil güncellendi',
            'password_changed' => 'Şifre başarıyla değiştirildi',
            'registration_successful' => 'Kayıt işlemi başarıyla tamamlandı',
            'login_successful' => 'Giriş başarılı, yönlendiriliyorsunuz',
            'logout_successful' => 'Güvenli çıkış yapıldı',
            'copy_successful' => 'Başarıyla kopyalandı',
            'action_completed' => 'İşlem tamamlandı',
        ],

        /*
        |--------------------------------------------------------------------------
        | JavaScript Error Messages - Hata Mesajları
        |--------------------------------------------------------------------------
        */
        'errors' => [
            'server_error' => 'Sunucu hatası oluştu',
            'network_error' => 'Ağ bağlantı hatası',
            'timeout_error' => 'İstek zaman aşımına uğradı',
            'unknown_error' => 'Bilinmeyen hata oluştu',
            'permission_denied' => 'Bu işlem için yetkiniz yok',
            'invalid_response' => 'Geçersiz sunucu yanıtı',
            'file_too_large' => 'Dosya boyutu çok büyük',
            'invalid_file_type' => 'Geçersiz dosya türü',
            'connection_lost' => 'Bağlantı kesildi',
            'session_expired' => 'Oturum süresi doldu',
            'access_denied' => 'Erişim reddedildi',
            'operation_failed' => 'İşlem başarısız',
            'loading_failed' => 'Yükleme başarısız',
            'processing_error' => 'İşlem hatası oluştu',
            'authentication_failed' => 'Kimlik doğrulama başarısız',
        ],

        /*
        |--------------------------------------------------------------------------
        | JavaScript Validation Messages - Doğrulama Mesajları
        |--------------------------------------------------------------------------
        */
        'validation' => [
            'required_field' => 'Bu alan zorunludur',
            'invalid_email' => 'Geçersiz e-posta adresi',
            'invalid_phone' => 'Geçersiz telefon numarası',
            'password_mismatch' => 'Şifreler eşleşmiyor',
            'password_min_length' => 'Şifre en az 8 karakter olmalıdır',
            'invalid_amount' => 'Geçersiz miktar',
            'min_amount' => 'Minimum miktar: :amount :currency',
            'max_amount' => 'Maksimum miktar: :amount :currency',
            'invalid_date' => 'Geçersiz tarih formatı',
            'future_date_required' => 'Gelecek bir tarih seçiniz',
            'past_date_required' => 'Geçmiş bir tarih seçiniz',
            'numeric_required' => 'Sayısal değer gerekli',
            'invalid_format' => 'Geçersiz format',
            'field_too_long' => 'Alan çok uzun',
            'field_too_short' => 'Alan çok kısa',
            'invalid_selection' => 'Geçersiz seçim',
            'url_invalid' => 'Geçersiz URL formatı',
            'file_required' => 'Dosya seçimi zorunludur',
        ],

        /*
        |--------------------------------------------------------------------------
        | JavaScript Financial Messages - Mali İşlem Mesajları
        |--------------------------------------------------------------------------
        */
        'financial' => [
            'deposit_successful' => 'Para yatırma işlemi başarılı',
            'withdrawal_successful' => 'Para çekme işlemi başarılı',
            'insufficient_balance' => 'Yetersiz bakiye',
            'transaction_processing' => 'İşleminiz işleniyor...',
            'payment_failed' => 'Ödeme işlemi başarısız',
            'order_placed' => 'Emir başarıyla verildi',
            'position_opened' => 'Pozisyon açıldı',
            'position_closed' => 'Pozisyon kapatıldı',
            'margin_call' => 'Margin call uyarısı',
            'stop_loss_triggered' => 'Stop loss tetiklendi',
            'take_profit_triggered' => 'Kar al tetiklendi',
            'balance_updated' => 'Bakiyeniz güncellendi',
            'currency_converted' => 'Para birimi çevirme işlemi tamamlandı',
            'transfer_completed' => 'Transfer işlemi tamamlandı',
            'investment_created' => 'Yatırım başarıyla oluşturuldu',
            'plan_activated' => 'Plan aktifleştirildi',
            'commission_earned' => 'Komisyon kazanıldı',
            'roi_calculated' => 'Getiri hesaplandı',
        ],

        /*
        |--------------------------------------------------------------------------
        | JavaScript Confirmation Messages - Onay Mesajları
        |--------------------------------------------------------------------------
        */
        'confirmations' => [
            'delete_item' => 'Bu öğeyi silmek istediğinizden emin misiniz?',
            'delete_user' => 'Bu kullanıcıyı silmek istediğinizden emin misiniz?',
            'cancel_order' => 'Bu emri iptal etmek istediğinizden emin misiniz?',
            'close_position' => 'Bu pozisyonu kapatmak istediğinizden emin misiniz?',
            'logout' => 'Çıkış yapmak istediğinizden emin misiniz?',
            'discard_changes' => 'Değişiklikleri kaydetmeden çıkmak istediğinizden emin misiniz?',
            'reset_form' => 'Formu sıfırlamak istediğinizden emin misiniz?',
            'send_money' => ':amount :currency göndermek istediğinizden emin misiniz?',
            'delete_account' => 'Hesabınızı silmek istediğinizden emin misiniz?',
            'approve_transaction' => 'Bu işlemi onaylamak istediğinizden emin misiniz?',
            'reject_application' => 'Bu başvuruyu reddetmek istediğinizden emin misiniz?',
            'activate_user' => 'Bu kullanıcıyı aktifleştirmek istediğinizden emin misiniz?',
            'deactivate_user' => 'Bu kullanıcıyı pasifleştirmek istediğinizden emin misiniz?',
            'clear_data' => 'Tüm verileri temizlemek istediğinizden emin misiniz?',
            'restore_backup' => 'Yedeği geri yüklemek istediğinizden emin misiniz?',
        ],

        /*
        |--------------------------------------------------------------------------
        | JavaScript Trading Interface Messages - İşlem Arayüzü Mesajları
        |--------------------------------------------------------------------------
        */
        'trading' => [
            'market_closed' => 'Piyasa kapalı',
            'order_pending' => 'Emir beklemede',
            'order_executed' => 'Emir gerçekleştirildi',
            'order_cancelled' => 'Emir iptal edildi',
            'price_updated' => 'Fiyat güncellendi',
            'connection_lost' => 'Piyasa bağlantısı kesildi',
            'reconnecting' => 'Yeniden bağlanıyor...',
            'connected' => 'Piyasaya bağlandı',
            'volume_too_low' => 'Hacim çok düşük',
            'spread_too_high' => 'Spread çok yüksek',
            'insufficient_margin' => 'Yetersiz margin',
            'risk_limit_exceeded' => 'Risk limiti aşıldı',
            'trading_suspended' => 'İşlemler askıya alındı',
            'market_volatility' => 'Yüksek piyasa volatilitesi',
            'order_modified' => 'Emir değiştirildi',
            'position_liquidated' => 'Pozisyon tasfiye edildi',
        ],

        /*
        |--------------------------------------------------------------------------
        | JavaScript Real-time Messages - Gerçek Zamanlı Mesajlar
        |--------------------------------------------------------------------------
        */
        'realtime' => [
            'connecting' => 'Bağlanıyor...',
            'connected' => 'Bağlandı',
            'disconnected' => 'Bağlantı kesildi',
            'reconnecting' => 'Yeniden bağlanıyor...',
            'new_message' => 'Yeni mesaj',
            'new_notification' => 'Yeni bildirim',
            'update_available' => 'Güncelleme mevcut',
            'data_refreshed' => 'Veriler yenilendi',
            'live_updates' => 'Canlı güncellemeler',
            'sync_completed' => 'Senkronizasyon tamamlandı',
            'online' => 'Çevrimiçi',
            'offline' => 'Çevrimdışı',
            'typing' => 'Yazıyor...',
            'user_joined' => 'Kullanıcı katıldı',
            'user_left' => 'Kullanıcı ayrıldı',
            'message_sent' => 'Mesaj gönderildi',
            'message_delivered' => 'Mesaj iletildi',
            'message_read' => 'Mesaj okundu',
        ],

        /*
        |--------------------------------------------------------------------------
        | JavaScript Status Messages - Durum Mesajları
        |--------------------------------------------------------------------------
        */
        'status' => [
            'loading' => 'Yükleniyor...',
            'processing' => 'İşleniyor...',
            'saving' => 'Kaydediliyor...',
            'uploading' => 'Yükleniyor...',
            'downloading' => 'İndiriliyor...',
            'generating' => 'Oluşturuluyor...',
            'calculating' => 'Hesaplanıyor...',
            'validating' => 'Doğrulanıyor...',
            'sending' => 'Gönderiliyor...',
            'retrieving' => 'Alınıyor...',
            'updating' => 'Güncelleniyor...',
            'deleting' => 'Siliniyor...',
            'copying' => 'Kopyalanıyor...',
            'moving' => 'Taşınıyor...',
            'compressing' => 'Sıkıştırılıyor...',
            'extracting' => 'Çıkarılıyor...',
            'syncing' => 'Senkronize ediliyor...',
            'analyzing' => 'Analiz ediliyor...',
        ],

        /*
        |--------------------------------------------------------------------------
        | JavaScript Action Labels - Eylem Etiketleri
        |--------------------------------------------------------------------------
        */
        'actions' => [
            'ok' => 'Tamam',
            'cancel' => 'İptal',
            'confirm' => 'Onayla',
            'save' => 'Kaydet',
            'delete' => 'Sil',
            'edit' => 'Düzenle',
            'update' => 'Güncelle',
            'create' => 'Oluştur',
            'add' => 'Ekle',
            'remove' => 'Kaldır',
            'close' => 'Kapat',
            'open' => 'Aç',
            'view' => 'Görüntüle',
            'download' => 'İndir',
            'upload' => 'Yükle',
            'copy' => 'Kopyala',
            'paste' => 'Yapıştır',
            'cut' => 'Kes',
            'print' => 'Yazdır',
            'search' => 'Ara',
            'filter' => 'Filtrele',
            'sort' => 'Sırala',
            'refresh' => 'Yenile',
            'reset' => 'Sıfırla',
            'submit' => 'Gönder',
            'apply' => 'Uygula',
            'back' => 'Geri',
            'next' => 'İleri',
            'previous' => 'Önceki',
            'continue' => 'Devam Et',
            'retry' => 'Tekrar Dene',
            'skip' => 'Atla',
            'finish' => 'Bitir',
        ],

        /*
        |--------------------------------------------------------------------------
        | JavaScript Notification Messages - Bildirim Mesajları
        |--------------------------------------------------------------------------
        */
        'notifications' => [
            'title' => 'Bildirim',
            'info' => 'Bilgi',
            'warning' => 'Uyarı',
            'error' => 'Hata',
            'success' => 'Başarılı',
            'question' => 'Soru',
            'confirmation' => 'Onay',
            'alert' => 'Uyarı',
            'notice' => 'Duyuru',
            'reminder' => 'Hatırlatma',
            'new_update' => 'Yeni Güncelleme',
            'system_maintenance' => 'Sistem Bakımı',
            'security_alert' => 'Güvenlik Uyarısı',
            'payment_reminder' => 'Ödeme Hatırlatması',
            'account_verification' => 'Hesap Doğrulama',
            'password_expiry' => 'Şifre Süresi Dolacak',
        ],

    ],

];