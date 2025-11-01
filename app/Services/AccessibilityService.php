<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

/**
 * Accessibility Service - ARIA Live Regions ve Screen Reader Desteği
 * 
 * Finansal platformda dinamik içerik güncellemelerini yönetir
 * Gerçek zamanlı bildirimleri screen reader'lara iletir
 * WCAG 2.1 AA uyumluluğu sağlar
 */
class AccessibilityService
{
    /**
     * Live region containers'ları ve özelliklerini saklar
     */
    private array $liveRegions = [];

    /**
     * Announcement kuyruğu - spam önlemek için
     */
    private array $announcementQueue = [];

    /**
     * Son announcement zamanları
     */
    private array $lastAnnouncements = [];

    /**
     * Öncelik seviyeleri
     */
    const PRIORITY_OFF = 'off';
    const PRIORITY_POLITE = 'polite';
    const PRIORITY_ASSERTIVE = 'assertive';

    /**
     * Announcement türleri
     */
    const TYPE_FINANCIAL = 'financial';
    const TYPE_NOTIFICATION = 'notification';
    const TYPE_FORM_ERROR = 'form_error';
    const TYPE_FORM_SUCCESS = 'form_success';
    const TYPE_STATUS_UPDATE = 'status_update';
    const TYPE_PRICE_UPDATE = 'price_update';
    const TYPE_MODAL = 'modal';

    /**
     * Live region oluştur
     */
    public function createLiveRegion(string $id, string $priority = self::PRIORITY_POLITE): array
    {
        $liveRegion = [
            'id' => $id,
            'priority' => $priority,
            'ariaLive' => $priority,
            'ariaAtomic' => 'true',
            'role' => 'status',
            'created_at' => now(),
            'announcementCount' => 0
        ];

        $this->liveRegions[$id] = $liveRegion;

        return $liveRegion;
    }

    /**
     * Financial data için özelleştirilmiş live region
     */
    public function createFinancialLiveRegion(string $id = 'financial-announcements'): array
    {
        $this->createLiveRegion($id, self::PRIORITY_ASSERTIVE);
        
        // Financial data için özel metadata
        $this->liveRegions[$id]['type'] = 'financial';
        $this->liveRegions[$id]['data-aria-label'] = 'Finansal veri bildirimleri';
        $this->liveRegions[$id]['class'] = 'sr-only financial-announcements';

        return $this->liveRegions[$id];
    }

    /**
     * Bildirimler için live region
     */
    public function createNotificationLiveRegion(string $id = 'notification-announcements'): array
    {
        $this->createLiveRegion($id, self::PRIORITY_POLITE);
        
        $this->liveRegions[$id]['type'] = 'notification';
        $this->liveRegions[$id]['data-aria-label'] = 'Sistem bildirimleri';
        $this->liveRegions[$id]['class'] = 'sr-only notification-announcements';

        return $this->liveRegions[$id];
    }

    /**
     * Form error'ları için live region
     */
    public function createFormErrorLiveRegion(string $id = 'form-error-announcements'): array
    {
        $this->createLiveRegion($id, self::PRIORITY_ASSERTIVE);
        
        $this->liveRegions[$id]['type'] = 'form_error';
        $this->liveRegions[$id]['data-aria-label'] = 'Form hata mesajları';
        $this->liveRegions[$id]['class'] = 'sr-only form-error-announcements';

        return $this->liveRegions[$id];
    }

    /**
     * Announcement yap
     */
    public function announce(string $message, string $type = self::TYPE_STATUS_UPDATE, string $regionId = null): bool
    {
        // Spam önleme - aynı mesajı son 3 saniyede göndermiş miyiz?
        $messageHash = md5($message . $type);
        if (isset($this->lastAnnouncements[$messageHash])) {
            if (now()->diffInMilliseconds($this->lastAnnouncements[$messageHash]) < 3000) {
                return false;
            }
        }

        $this->lastAnnouncements[$messageHash] = now();

        // Region belirle
        if (!$regionId) {
            $regionId = $this->getRegionIdByType($type);
        }

        // Announcement kuyruğuna ekle
        $announcement = [
            'message' => $message,
            'type' => $type,
            'regionId' => $regionId,
            'timestamp' => now(),
            'locale' => app()->getLocale(),
            'priority' => $this->getPriorityByType($type)
        ];

        $this->announcementQueue[] = $announcement;

        // Session'da sakla
        Session::put('accessibility_announcements', $this->announcementQueue);

        // Log kaydı
        Log::info('Accessibility announcement', [
            'type' => $type,
            'region' => $regionId,
            'message' => $message,
            'locale' => app()->getLocale()
        ]);

        return true;
    }

    /**
     * Finansal veri güncellemesi announcement'ı
     */
    public function announceFinancialUpdate(string $symbol, float $oldValue, float $newValue, string $change = null): bool
    {
        $locale = app()->getLocale();
        
        if ($locale === 'tr') {
            $direction = $newValue > $oldValue ? 'arttı' : ($newValue < $oldValue ? 'azaldı' : 'değişmedi');
            $message = "{$symbol} fiyatı {$oldValue} değerinden {$newValue} değerine {$direction}";
            if ($change) {
                $message .= " (%{$change})";
            }
        } else {
            $direction = $newValue > $oldValue ? 'increased to' : ($newValue < $oldValue ? 'decreased to' : 'remained at');
            $message = "{$symbol} price {$direction} {$newValue}";
            if ($change) {
                $message .= " ({$change}%)";
            }
        }

        return $this->announce($message, self::TYPE_PRICE_UPDATE, 'financial-announcements');
    }

    /**
     * Balance güncelleme announcement'ı
     */
    public function announceBalanceUpdate(float $oldBalance, float $newBalance, string $currency = 'USD'): bool
    {
        $locale = app()->getLocale();
        $change = $newBalance - $oldBalance;
        $changeText = '';

        if ($locale === 'tr') {
            $changeText = $change > 0 
                ? number_format($change, 2) . ' ' . $currency . ' artışla' 
                : number_format(abs($change), 2) . ' ' . $currency . ' azalışla';
            $message = "Hesap bakiyeniz " . number_format($oldBalance, 2) . " " . $currency . "'den " . 
                      number_format($newBalance, 2) . " " . $currency . "'ye {$changeText} güncellendi";
        } else {
            $changeText = $change > 0 
                ? 'increased by ' . number_format($change, 2) . ' ' . $currency 
                : 'decreased by ' . number_format(abs($change), 2) . ' ' . $currency;
            $message = "Your account balance has been updated from {$oldBalance} {$currency} to {$newBalance} {$currency}, {$changeText}";
        }

        return $this->announce($message, self::TYPE_FINANCIAL, 'financial-announcements');
    }

    /**
     * Transaction başarılı announcement'ı
     */
    public function announceTransactionSuccess(string $type, float $amount, string $currency = 'USD'): bool
    {
        $locale = app()->getLocale();
        
        if ($locale === 'tr') {
            $typeText = $type === 'deposit' ? 'yatırma' : ($type === 'withdrawal' ? 'çekme' : 'işlem');
            $message = "{$typeText} işleminiz başarıyla tamamlandı. {$amount} {$currency} işleme alındı.";
        } else {
            $typeText = $type === 'deposit' ? 'deposit' : ($type === 'withdrawal' ? 'withdrawal' : 'transaction');
            $message = "Your {$typeText} has been completed successfully. {$amount} {$currency} has been processed.";
        }

        return $this->announce($message, self::TYPE_STATUS_UPDATE, 'notification-announcements');
    }

    /**
     * Form validation error announcement'ı
     */
    public function announceFormError(string $field, string $error): bool
    {
        $locale = app()->getLocale();
        
        if ($locale === 'tr') {
            $message = "{$field} alanında hata: {$error}";
        } else {
            $message = "Error in {$field} field: {$error}";
        }

        return $this->announce($message, self::TYPE_FORM_ERROR, 'form-error-announcements');
    }

    /**
     * Form success announcement'ı
     */
    public function announceFormSuccess(string $action): bool
    {
        $locale = app()->getLocale();
        
        if ($locale === 'tr') {
            $message = "{$action} işlemi başarıyla tamamlandı.";
        } else {
            $message = "{$action} completed successfully.";
        }

        return $this->announce($message, self::TYPE_FORM_SUCCESS, 'notification-announcements');
    }

    /**
     * Modal açılma announcement'ı
     */
    public function announceModalOpen(string $title): bool
    {
        $locale = app()->getLocale();
        
        if ($locale === 'tr') {
            $message = "{$title} penceresi açıldı. İçeriğe odaklanmak için Tab tuşuna basın.";
        } else {
            $message = "{$title} dialog opened. Press Tab to focus on content.";
        }

        return $this->announce($message, self::TYPE_MODAL, 'modal-announcements');
    }

    /**
     * Live region HTML'ini render et
     */
    public function renderLiveRegion(string $regionId): string
    {
        if (!isset($this->liveRegions[$regionId])) {
            return '';
        }

        $region = $this->liveRegions[$regionId];
        
        $attributes = [
            'id' => $region['id'],
            'aria-live' => $region['priority'],
            'aria-atomic' => $region['ariaAtomic'] ?? 'true',
            'role' => $region['role'] ?? 'status',
            'data-aria-label' => $region['data-aria-label'] ?? 'Live announcements',
            'class' => $region['class'] ?? 'sr-only',
        ];

        return '<div ' . $this->buildAttributes($attributes) . '></div>';
    }

    /**
     * Tüm live regions'ları render et
     */
    public function renderAllLiveRegions(): string
    {
        $html = '';
        
        // Varsayılan live regions oluştur
        $this->ensureDefaultRegions();
        
        foreach ($this->liveRegions as $region) {
            $html .= $this->renderLiveRegion($region['id']);
        }
        
        return $html;
    }

    /**
     * Kullanıcının erişilebilirlik tercihlerini güncelle
     */
    public function updateUserAccessibilityPreferences(array $preferences): void
    {
        $userId = auth()->id();
        if ($userId) {
            // Kullanıcının erişilebilirlik tercihlerini kaydet
            session(['user_accessibility_preferences' => $preferences]);
        }
    }

    /**
     * Kullanıcının erişilebilirlik tercihlerini al
     */
    public function getUserAccessibilityPreferences(): array
    {
        return session('user_accessibility_preferences', [
            'reduced_motion' => false,
            'high_contrast' => false,
            'screen_reader' => false,
            'announcements_enabled' => true,
            'auto_play_disabled' => true,
        ]);
    }

    /**
     * Desteklenen announcement tiplerini döndür
     */
    public function getSupportedAnnouncementTypes(): array
    {
        return [
            self::TYPE_FINANCIAL,
            self::TYPE_NOTIFICATION,
            self::TYPE_FORM_ERROR,
            self::TYPE_FORM_SUCCESS,
            self::TYPE_STATUS_UPDATE,
            self::TYPE_PRICE_UPDATE,
            self::TYPE_MODAL
        ];
    }

    /**
     * Announcement kuyruğunu temizle
     */
    public function clearAnnouncementQueue(): void
    {
        $this->announcementQueue = [];
        session()->forget('accessibility_announcements');
    }

    /**
     * Live region bilgilerini döndür
     */
    public function getLiveRegionInfo(string $regionId): ?array
    {
        return $this->liveRegions[$regionId] ?? null;
    }

    /**
     * Type'a göre region ID belirle
     */
    private function getRegionIdByType(string $type): string
    {
        return match($type) {
            self::TYPE_FINANCIAL, self::TYPE_PRICE_UPDATE => 'financial-announcements',
            self::TYPE_NOTIFICATION, self::TYPE_STATUS_UPDATE => 'notification-announcements',
            self::TYPE_FORM_ERROR => 'form-error-announcements',
            self::TYPE_FORM_SUCCESS => 'notification-announcements',
            self::TYPE_MODAL => 'modal-announcements',
            default => 'notification-announcements'
        };
    }

    /**
     * Type'a göre öncelik belirle
     */
    private function getPriorityByType(string $type): string
    {
        return match($type) {
            self::TYPE_FORM_ERROR, self::TYPE_MODAL => self::PRIORITY_ASSERTIVE,
            self::TYPE_FINANCIAL, self::TYPE_PRICE_UPDATE => self::PRIORITY_ASSERTIVE,
            default => self::PRIORITY_POLITE
        };
    }

    /**
     * Varsayılan live regions'ları oluştur
     */
    private function ensureDefaultRegions(): void
    {
        if (!isset($this->liveRegions['financial-announcements'])) {
            $this->createFinancialLiveRegion();
        }
        
        if (!isset($this->liveRegions['notification-announcements'])) {
            $this->createNotificationLiveRegion();
        }
        
        if (!isset($this->liveRegions['form-error-announcements'])) {
            $this->createFormErrorLiveRegion();
        }
        
        if (!isset($this->liveRegions['modal-announcements'])) {
            $this->createLiveRegion('modal-announcements', self::PRIORITY_ASSERTIVE);
        }
    }

    /**
     * HTML attributes oluştur
     */
    private function buildAttributes(array $attributes): string
    {
        $html = [];
        foreach ($attributes as $key => $value) {
            if ($value !== null && $value !== '') {
                $html[] = $key . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
            }
        }
        
        return implode(' ', $html);
    }
}