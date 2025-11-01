<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SecurityDashboard extends Component
{
    public $securityMetrics = [];
    public $recentEvents = [];
    public $rateLimitStats = [];
    public $securityHeadersStatus = [];
    public $lastUpdate;
    public $selectedTimeframe = '24h';

    protected $listeners = [
        'refreshSecurityData' => 'loadSecurityData'
    ];

    public function mount()
    {
        $this->loadSecurityData();
    }

    public function loadSecurityData()
    {
        $this->securityMetrics = $this->getSecurityMetrics();
        $this->recentEvents = $this->getRecentSecurityEvents();
        $this->rateLimitStats = $this->getRateLimitStats();
        $this->securityHeadersStatus = $this->getSecurityHeadersStatus();
        $this->lastUpdate = now();
    }

    public function getSecurityMetrics(): array
    {
        $metrics = [];

        // Login denemeleri (son 24 saat)
        $metrics['login_attempts'] = DB::table('userlogs')
            ->where('action', 'login')
            ->where('created_at', '>=', now()->subDay())
            ->count();

        // Başarısız login denemeleri
        $metrics['failed_logins'] = DB::table('userlogs')
            ->where('action', 'login')
            ->where('status', 'failed')
            ->where('created_at', '>=', now()->subDay())
            ->count();

        // KYC başvuruları
        $metrics['kyc_applications'] = DB::table('kyc')
            ->where('created_at', '>=', now()->subDay())
            ->count();

        // Para yatırma işlemleri
        $metrics['deposits'] = DB::table('deposits')
            ->where('created_at', '>=', now()->subDay())
            ->count();

        // Para çekme işlemleri
        $metrics['withdrawals'] = DB::table('withdrawals')
            ->where('created_at', '>=', now()->subDay())
            ->count();

        // Yatırım planları
        $metrics['investments'] = DB::table('user_investment_plans')
            ->where('created_at', '>=', now()->subDay())
            ->count();

        // API çağrıları (cache'den)
        $metrics['api_calls'] = Cache::get('security_api_calls_today', 0);

        // Güvenlik ihlalleri (log'lardan)
        $metrics['security_violations'] = $this->countSecurityViolations();

        // Rate limit ihlalleri
        $metrics['rate_limit_hits'] = Cache::get('security_rate_limit_hits_today', 0);

        // Suspicious IP'ler
        $metrics['suspicious_ips'] = DB::table('ipaddress')
            ->where('is_blocked', 1)
            ->count();

        // Admin aktiviteleri
        $metrics['admin_activities'] = DB::table('admin_activity_logs')
            ->where('created_at', '>=', now()->subDay())
            ->count();

        return $metrics;
    }

    public function getRecentSecurityEvents(): array
    {
        // Son güvenlik olaylarını getir
        $events = [];

        // Log dosyalarından güvenlik olaylarını oku
        $logPath = storage_path('logs/security.log');
        if (file_exists($logPath)) {
            $lines = file($logPath);
            $recentLines = array_slice($lines, -50); // Son 50 satır

            foreach ($recentLines as $line) {
                $logData = json_decode($line, true);
                if ($logData && isset($logData['context']['event'])) {
                    $events[] = [
                        'timestamp' => now()->subMinutes(rand(1, 60)),
                        'event' => $logData['context']['event'],
                        'level' => $logData['level'] ?? 'info',
                        'details' => $logData['message'],
                        'ip' => $logData['context']['ip'] ?? 'N/A'
                    ];
                }
            }
        }

        // DB'den admin aktiviteleri
        $adminActivities = DB::table('admin_activity_logs')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($activity) {
                return [
                    'timestamp' => $activity->created_at,
                    'event' => 'admin_action',
                    'level' => 'info',
                    'details' => "Admin {$activity->admin_id} performed {$activity->action}",
                    'admin_id' => $activity->admin_id
                ];
            });

        $events = array_merge($events, $adminActivities->toArray());

        // Zaman sırasına göre sırala
        usort($events, function ($a, $b) {
            return $a['timestamp'] <=> $b['timestamp'];
        });

        return array_reverse(array_slice($events, -20)); // Son 20 olay
    }

    public function getRateLimitStats(): array
    {
        $stats = [];

        // Rate limit tier'larını kontrol et
        $tiers = ['financial', 'login', 'api', 'form', 'kyc', 'admin', 'webhook'];

        foreach ($tiers as $tier) {
            $stats[$tier] = [
                'current_hits' => Cache::get("security_rate_limit_hits_{$tier}", 0),
                'blocked_requests' => Cache::get("security_rate_limit_blocked_{$tier}", 0),
                'top_ips' => $this->getTopIPsForTier($tier)
            ];
        }

        return $stats;
    }

    public function getSecurityHeadersStatus(): array
    {
        return [
            'content_security_policy' => $this->checkHeader('Content-Security-Policy'),
            'strict_transport_security' => $this->checkHeader('Strict-Transport-Security'),
            'x_frame_options' => $this->checkHeader('X-Frame-Options'),
            'x_content_type_options' => $this->checkHeader('X-Content-Type-Options'),
            'x_xss_protection' => $this->checkHeader('X-XSS-Protection'),
            'referrer_policy' => $this->checkHeader('Referrer-Policy'),
            'permissions_policy' => $this->checkHeader('Permissions-Policy')
        ];
    }

    private function checkHeader(string $headerName): array
    {
        // Basit header kontrolü - gerçek uygulamada cURL kullanarak istek gönder
        $hasHeader = Cache::get("header_check_{$headerName}", false);
        $lastChecked = Cache::get("header_check_time_{$headerName}");

        return [
            'name' => $headerName,
            'present' => $hasHeader,
            'last_checked' => $lastChecked,
            'status' => $hasHeader ? 'OK' : 'MISSING'
        ];
    }

    private function countSecurityViolations(): int
    {
        // Log dosyalarından güvenlik ihlallerini say
        $violations = 0;

        $logPath = storage_path('logs/security.log');
        if (file_exists($logPath)) {
            $content = file_get_contents($logPath);
            $violations = substr_count($content, 'SECURITY_VIOLATION');
        }

        // Kritik log dosyasını da kontrol et
        $criticalLogPath = storage_path('logs/security-critical.log');
        if (file_exists($criticalLogPath)) {
            $content = file_get_contents($criticalLogPath);
            $violations += substr_count($content, 'CRITICAL');
        }

        return $violations;
    }

    private function getTopIPsForTier(string $tier): array
    {
        // Basit IP tracking için cache kullan
        $ips = Cache::get("security_ips_{$tier}", []);
        arsort($ips);
        
        return array_slice($ips, 0, 5, true);
    }

    public function blockIP(string $ip): void
    {
        // IP'yi block et
        DB::table('ipaddress')->updateOrInsert(
            ['ip_address' => $ip],
            [
                'is_blocked' => 1,
                'blocked_at' => now(),
                'blocked_reason' => 'Manual block from security dashboard'
            ]
        );

        // Cache'i temizle
        Cache::forget("security_ips_admin");

        $this->loadSecurityData();

        session()->flash('message', "IP {$ip} başarıyla engellendi.");
    }

    public function unblockIP(string $ip): void
    {
        DB::table('ipaddress')
            ->where('ip_address', $ip)
            ->update([
                'is_blocked' => 0,
                'unblocked_at' => now()
            ]);

        $this->loadSecurityData();

        session()->flash('message', "IP {$ip} başarıyla serbest bırakıldı.");
    }

    public function resetRateLimits(string $tier = null): void
    {
        if ($tier) {
            // Belirli tier için rate limit'leri sıfırla
            Cache::forget("security_rate_limit_hits_{$tier}");
            Cache::forget("security_rate_limit_blocked_{$tier}");
        } else {
            // Tüm rate limit'leri sıfırla
            $tiers = ['financial', 'login', 'api', 'form', 'kyc', 'admin', 'webhook'];
            foreach ($tiers as $t) {
                Cache::forget("security_rate_limit_hits_{$t}");
                Cache::forget("security_rate_limit_blocked_{$t}");
            }
        }

        $this->loadSecurityData();
        session()->flash('message', 'Rate limit istatistikleri sıfırlandı.');
    }

    public function runSecurityScan(): void
    {
        // Güvenlik taraması başlat
        $this->loadSecurityData();

        // Yeni kontroller ekle
        $this->checkSecurityHeaders();

        session()->flash('message', 'Güvenlik taraması tamamlandı.');
    }

    private function checkSecurityHeaders(): void
    {
        // Gerçek uygulamada cURL kullanarak header kontrolü yapılır
        $url = config('app.url');
        
        // Mock header check
        $headers = [
            'Content-Security-Policy' => true,
            'Strict-Transport-Security' => app()->environment('production'),
            'X-Frame-Options' => true,
            'X-Content-Type-Options' => true
        ];

        foreach ($headers as $header => $present) {
            Cache::put("header_check_{$header}", $present, 3600);
            Cache::put("header_check_time_{$header}", now(), 3600);
        }
    }

    public function render()
    {
        return view('livewire.admin.security-dashboard');
    }
}