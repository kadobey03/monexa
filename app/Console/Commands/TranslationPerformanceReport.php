<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PerformanceMonitoringService;
use Illuminate\Support\Carbon;

class TranslationPerformanceReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation:performance-report 
                            {--date= : Specific date for report (Y-m-d format)}
                            {--cleanup : Clean up old metrics after report}
                            {--days=30 : Days to keep for cleanup}
                            {--export= : Export format (json, csv)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate translation system performance report';

    /**
     * Performance monitoring service.
     */
    protected PerformanceMonitoringService $performanceService;

    /**
     * Constructor.
     */
    public function __construct(PerformanceMonitoringService $performanceService)
    {
        parent::__construct();
        $this->performanceService = $performanceService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔍 Çeviri Sistemi Performans Raporu');
        $this->newLine();

        try {
            // Genel sistem sağlığı kontrolü
            $this->checkSystemHealth();

            // Ana performans raporu
            $this->generateMainReport();

            // Tarih bazlı rapor (eğer belirtilmişse)
            if ($date = $this->option('date')) {
                $this->generateDailyReport($date);
            }

            // Redis sağlık kontrolü
            $this->checkRedisHealth();

            // Yavaş sorgular raporu
            $this->generateSlowQueryReport();

            // Cleanup işlemi (eğer belirtilmişse)
            if ($this->option('cleanup')) {
                $this->performCleanup();
            }

            // Export işlemi (eğer belirtilmişse)
            if ($format = $this->option('export')) {
                $this->exportReport($format);
            }

            $this->newLine();
            $this->info('✅ Performans raporu başarıyla oluşturuldu.');
            
            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Performans raporu oluşturulurken hata: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    /**
     * Sistem sağlık durumunu kontrol et.
     */
    private function checkSystemHealth(): void
    {
        $this->info('🏥 Sistem Sağlık Durumu');
        
        $summary = $this->performanceService->getPerformanceSummary();
        $health = $summary['system_health'];
        
        $healthIcon = match($health) {
            'excellent' => '🟢',
            'good' => '🟡',
            'fair' => '🟠',
            'poor' => '🔴',
            default => '❓'
        };
        
        $healthText = match($health) {
            'excellent' => 'Mükemmel',
            'good' => 'İyi',
            'fair' => 'Orta',
            'poor' => 'Kötü',
            default => 'Bilinmiyor'
        };
        
        $this->line("Genel Sağlık: {$healthIcon} {$healthText}");
        $this->newLine();
    }

    /**
     * Ana performans raporunu oluştur.
     */
    private function generateMainReport(): void
    {
        $this->info('📊 Ana Performans Metrikleri');
        
        $summary = $this->performanceService->getPerformanceSummary();
        
        // Cache performansı
        $cache = $summary['cache'];
        $this->table(
            ['Metrik', 'Değer'],
            [
                ['Cache Hit Oranı', $cache['hit_rate'] . '%'],
                ['Toplam Cache Hit', number_format($cache['cache_hits'])],
                ['Toplam Cache Miss', number_format($cache['cache_misses'])],
                ['Toplam İstek', number_format($cache['total_requests'])],
            ]
        );

        // Query performansı
        $queries = $summary['queries'];
        $this->table(
            ['Query Metrik', 'Değer'],
            [
                ['Toplam Sorgu', number_format($queries['total_queries'])],
                ['Yavaş Sorgu', number_format($queries['slow_queries'])],
                ['Yavaş Sorgu Oranı', $queries['slow_query_rate'] . '%'],
                ['Ortalama Sorgu Süresi', round($queries['average_query_time'], 2) . 'ms'],
            ]
        );

        // Çeviri istatistikleri
        $translations = $summary['translations'];
        $this->table(
            ['Çeviri Metrik', 'Değer'],
            [
                ['Toplam Arama', number_format($translations['total_lookups'])],
                ['Cache\'ten Gelen', number_format($translations['cached_lookups'])],
                ['DB\'den Gelen', number_format($translations['database_lookups'])],
                ['Türkçe Aramalar', number_format($translations['languages']['tr'])],
                ['Rusça Aramalar', number_format($translations['languages']['ru'])],
            ]
        );

        $this->newLine();
    }

    /**
     * Günlük rapor oluştur.
     */
    private function generateDailyReport(string $date): void
    {
        $this->info("📅 {$date} Tarihli Günlük Rapor");
        
        try {
            $parsedDate = Carbon::parse($date)->format('Y-m-d');
            $dailyReport = $this->performanceService->getDailyReport($parsedDate);
            
            $this->table(
                ['Kategori', 'Metrik', 'Değer'],
                [
                    ['Cache', 'Hits', number_format($dailyReport['cache']['hits']['count'] ?? 0)],
                    ['Cache', 'Misses', number_format($dailyReport['cache']['misses']['count'] ?? 0)],
                    ['Queries', 'Toplam', number_format($dailyReport['queries']['count']['count'] ?? 0)],
                    ['Queries', 'Ortalama Süre', round($dailyReport['queries']['avg_time']['avg'] ?? 0, 2) . 'ms'],
                    ['Türkçe', 'Ortalama Süre', round($dailyReport['translations']['tr']['avg'] ?? 0, 2) . 'ms'],
                    ['Rusça', 'Ortalama Süre', round($dailyReport['translations']['ru']['avg'] ?? 0, 2) . 'ms'],
                ]
            );
        } catch (\Exception $e) {
            $this->error("❌ Günlük rapor oluşturulamadı: " . $e->getMessage());
        }
        
        $this->newLine();
    }

    /**
     * Redis sağlık kontrolü yap.
     */
    private function checkRedisHealth(): void
    {
        $this->info('🔴 Redis Sağlık Durumu');
        
        $redisHealth = $this->performanceService->checkRedisHealth();
        
        if ($redisHealth['status'] === 'healthy') {
            $this->table(
                ['Metrik', 'Değer'],
                [
                    ['Durum', '🟢 Sağlıklı'],
                    ['Gecikme', $redisHealth['latency'] . 'ms'],
                    ['Bellek Kullanımı', $redisHealth['memory_usage']],
                    ['Bağlı İstemci', $redisHealth['connected_clients']],
                    ['İşlenen Komutlar', number_format($redisHealth['total_commands_processed'])],
                ]
            );
        } else {
            $this->error('🔴 Redis Problemi: ' . $redisHealth['error']);
        }
        
        $this->newLine();
    }

    /**
     * Yavaş sorgu raporu oluştur.
     */
    private function generateSlowQueryReport(): void
    {
        $this->info('🐌 Yavaş Sorgu Raporu');
        
        $queryReport = $this->performanceService->getQueryPerformanceReport();
        
        if (!empty($queryReport['recent_slow_queries'])) {
            $slowQueries = array_slice($queryReport['recent_slow_queries'], 0, 5); // Son 5 yavaş sorgu
            
            foreach ($slowQueries as $index => $query) {
                $this->line(sprintf(
                    "%d. %s (%sms) - %s",
                    $index + 1,
                    $query['query'] ?? 'Bilinmeyen sorgu',
                    round($query['execution_time'] ?? 0, 2),
                    Carbon::parse($query['timestamp'])->format('d.m.Y H:i:s')
                ));
            }
        } else {
            $this->line('✅ Yavaş sorgu bulunamadı.');
        }
        
        $this->newLine();
    }

    /**
     * Eski metrikleri temizle.
     */
    private function performCleanup(): void
    {
        $days = (int) $this->option('days');
        
        if ($this->confirm("⚠️  {$days} günden eski metrikleri silmek istediğinizden emin misiniz?")) {
            $this->info('🧹 Eski metrikler temizleniyor...');
            
            $this->performanceService->cleanupOldMetrics($days);
            
            $this->info('✅ Temizlik işlemi tamamlandı.');
        }
        
        $this->newLine();
    }

    /**
     * Raporu dışa aktar.
     */
    private function exportReport(string $format): void
    {
        $this->info("📤 Rapor {$format} formatında dışa aktarılıyor...");
        
        $summary = $this->performanceService->getPerformanceSummary();
        $fileName = 'translation_performance_' . now()->format('Y-m-d_H-i-s');
        
        try {
            switch (strtolower($format)) {
                case 'json':
                    $this->exportToJson($summary, $fileName);
                    break;
                case 'csv':
                    $this->exportToCsv($summary, $fileName);
                    break;
                default:
                    $this->error("❌ Desteklenmeyen format: {$format}");
                    return;
            }
            
            $this->info("✅ Rapor başarıyla dışa aktarıldı: storage/app/{$fileName}.{$format}");
        } catch (\Exception $e) {
            $this->error("❌ Dışa aktarma hatası: " . $e->getMessage());
        }
        
        $this->newLine();
    }

    /**
     * JSON formatında dışa aktar.
     */
    private function exportToJson(array $data, string $fileName): void
    {
        $jsonData = json_encode([
            'generated_at' => now()->toISOString(),
            'performance_data' => $data
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        file_put_contents(storage_path("app/{$fileName}.json"), $jsonData);
    }

    /**
     * CSV formatında dışa aktar.
     */
    private function exportToCsv(array $data, string $fileName): void
    {
        $csvData = [];
        $csvData[] = ['Kategori', 'Alt Kategori', 'Metrik', 'Değer'];
        
        // Cache verileri
        foreach ($data['cache'] as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    $csvData[] = ['Cache', $key, $subKey, $subValue];
                }
            } else {
                $csvData[] = ['Cache', '', $key, $value];
            }
        }
        
        // Query verileri
        foreach ($data['queries'] as $key => $value) {
            $csvData[] = ['Queries', '', $key, $value];
        }
        
        // Translation verileri
        foreach ($data['translations'] as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    $csvData[] = ['Translations', $key, $subKey, $subValue];
                }
            } else {
                $csvData[] = ['Translations', '', $key, $value];
            }
        }
        
        $fp = fopen(storage_path("app/{$fileName}.csv"), 'w');
        foreach ($csvData as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
    }
}