<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User_plans;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateUserPlansCachedData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-plans:update-cached-data 
                            {--dry-run : Sadece rapor göster, değişiklik yapma}
                            {--batch-size=100 : Her seferde işlenecek kayıt sayısı}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User_plans tablosundaki boş user_name ve user_email alanlarını kullanıcı bilgileriyle doldurur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $batchSize = (int) $this->option('batch-size');

        $this->info('🚀 User Plans Cache Data Güncelleme Başlatılıyor...');
        $this->info('Dry Run: ' . ($dryRun ? 'Evet' : 'Hayır'));
        $this->info('Batch Size: ' . $batchSize);
        $this->newLine();

        try {
            // İstatistikleri topla
            $stats = $this->getStatistics();
            $this->displayStatistics($stats);

            if ($stats['needs_update'] === 0) {
                $this->info('✅ Tüm kayıtlar zaten güncel! Güncelleme gerekmiyor.');
                return Command::SUCCESS;
            }

            if ($dryRun) {
                $this->warn('🔍 DRY RUN MODU: Değişiklik yapılmayacak, sadece rapor gösteriliyor.');
                $this->showSampleRecords();
                return Command::SUCCESS;
            }

            // Kullanıcıdan onay al
            if (!$this->confirm('Bu işlem devam etsin mi?')) {
                $this->warn('❌ İşlem iptal edildi.');
                return Command::FAILURE;
            }

            // Güncelleme işlemini başlat
            $updated = $this->updateCachedData($batchSize);
            
            $this->newLine();
            $this->info("✅ İşlem tamamlandı!");
            $this->info("📊 Güncellenen kayıt sayısı: {$updated}");
            
            // Final istatistikler
            $finalStats = $this->getStatistics();
            $this->newLine();
            $this->info('📈 Final İstatistikler:');
            $this->displayStatistics($finalStats);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Hata oluştu: ' . $e->getMessage());
            Log::error('UpdateUserPlansCachedData command failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }
    }

    /**
     * İstatistikleri topla
     */
    private function getStatistics(): array
    {
        $totalRecords = User_plans::count();
        $recordsWithValidUser = User_plans::whereNotNull('user')->where('user', '!=', 0)->count();
        $recordsWithCachedData = User_plans::whereNotNull('user_name')
                                          ->whereNotNull('user_email')
                                          ->where('user_name', '!=', '')
                                          ->where('user_email', '!=', '')
                                          ->count();
        
        $needsUpdate = User_plans::whereNotNull('user')
                                ->where('user', '!=', 0)
                                ->where(function($q) {
                                    $q->whereNull('user_name')
                                      ->orWhereNull('user_email')
                                      ->orWhere('user_name', '')
                                      ->orWhere('user_email', '');
                                })
                                ->count();

        $invalidUserIds = User_plans::whereNotNull('user')
                                   ->where('user', '!=', 0)
                                   ->whereNotExists(function($q) {
                                       $q->select(DB::raw(1))
                                         ->from('users')
                                         ->whereRaw('users.id = user_plans.user');
                                   })
                                   ->count();

        return [
            'total_records' => $totalRecords,
            'records_with_valid_user' => $recordsWithValidUser,
            'records_with_cached_data' => $recordsWithCachedData,
            'needs_update' => $needsUpdate,
            'invalid_user_ids' => $invalidUserIds
        ];
    }

    /**
     * İstatistikleri göster
     */
    private function displayStatistics(array $stats): void
    {
        $this->table(
            ['Metrik', 'Değer', 'Açıklama'],
            [
                ['Toplam Kayıt', number_format($stats['total_records']), 'User_plans tablosundaki toplam kayıt'],
                ['Geçerli User ID', number_format($stats['records_with_valid_user']), 'NULL olmayan ve 0\'dan farklı user ID\'li kayıtlar'],
                ['Cache\'li Veriler', number_format($stats['records_with_cached_data']), 'user_name ve user_email dolu kayıtlar'],
                ['Güncellenmeli', number_format($stats['needs_update']), 'Cache verileri eksik kayıtlar'],
                ['Geçersiz User ID', number_format($stats['invalid_user_ids']), 'Users tablosunda bulunmayan ID\'ler']
            ]
        );
    }

    /**
     * Örnek kayıtları göster (dry-run için)
     */
    private function showSampleRecords(): void
    {
        $this->info('🔍 Güncellenmesi gereken örnek kayıtlar:');
        
        $sampleRecords = User_plans::with('user:id,name,email')
                                  ->whereNotNull('user')
                                  ->where('user', '!=', 0)
                                  ->where(function($q) {
                                      $q->whereNull('user_name')
                                        ->orWhereNull('user_email')
                                        ->orWhere('user_name', '')
                                        ->orWhere('user_email', '');
                                  })
                                  ->limit(5)
                                  ->get();

        if ($sampleRecords->isEmpty()) {
            $this->info('Örnek kayıt bulunamadı.');
            return;
        }

        $tableData = [];
        foreach ($sampleRecords as $record) {
            $tableData[] = [
                'ID' => $record->id,
                'User ID' => $record->user,
                'Mevcut Name' => $record->user_name ?: 'BOŞ',
                'Mevcut Email' => $record->user_email ?: 'BOŞ',
                'Gerçek Name' => $record->user ? $record->user->name : 'USER YOK',
                'Gerçek Email' => $record->user ? $record->user->email : 'USER YOK'
            ];
        }

        $this->table(
            ['ID', 'User ID', 'Mevcut Name', 'Mevcut Email', 'Gerçek Name', 'Gerçek Email'],
            $tableData
        );
    }

    /**
     * Cache verilerini güncelle
     */
    private function updateCachedData(int $batchSize): int
    {
        $totalUpdated = 0;
        $bar = null;

        // Toplam işlenecek kayıt sayısını hesapla
        $totalToProcess = User_plans::whereNotNull('user')
                                   ->where('user', '!=', 0)
                                   ->where(function($q) {
                                       $q->whereNull('user_name')
                                         ->orWhereNull('user_email')
                                         ->orWhere('user_name', '')
                                         ->orWhere('user_email', '');
                                   })
                                   ->count();

        if ($totalToProcess > 0) {
            $bar = $this->output->createProgressBar($totalToProcess);
            $bar->setFormat('verbose');
            $bar->start();
        }

        // Batch'ler halinde işle
        User_plans::with('user:id,name,email')
                  ->whereNotNull('user')
                  ->where('user', '!=', 0)
                  ->where(function($q) {
                      $q->whereNull('user_name')
                        ->orWhereNull('user_email')
                        ->orWhere('user_name', '')
                        ->orWhere('user_email', '');
                  })
                  ->chunk($batchSize, function($trades) use (&$totalUpdated, $bar) {
                      DB::transaction(function() use ($trades, &$totalUpdated, $bar) {
                          foreach ($trades as $trade) {
                              if ($trade->user) {
                                  $trade->update([
                                      'user_name' => $trade->user->name,
                                      'user_email' => $trade->user->email
                                  ]);
                                  $totalUpdated++;
                              } else {
                                  // Geçersiz user ID'yi null yap
                                  $trade->update(['user' => null]);
                              }
                              
                              if ($bar) {
                                  $bar->advance();
                              }
                          }
                      });
                  });

        if ($bar) {
            $bar->finish();
            $this->newLine();
        }

        return $totalUpdated;
    }
}