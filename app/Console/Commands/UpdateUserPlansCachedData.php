<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User_plans;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateUserPlansCachedData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-plans:update-cache {--dry-run : Show what would be updated without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user_name and user_email cache fields in user_plans table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 User Plans Cache Update Command');
        $this->info('=====================================');

        // Kolonların varlığını kontrol et
        if (!$this->checkColumns()) {
            $this->error('❌ user_name ve user_email kolonları bulunamadı!');
            $this->error('Önce migration çalıştırılmalı: php artisan migrate');
            return 1;
        }

        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn('🔍 DRY RUN MODE - Hiçbir değişiklik yapılmayacak');
        }

        // Toplam kayıt sayısını al
        $totalRecords = User_plans::count();
        $this->info("📊 Toplam user_plans kaydı: {$totalRecords}");

        // Cache alanları boş olan kayıtları bul
        $emptyCache = User_plans::where(function($query) {
            $query->whereNull('user_name')
                  ->orWhereNull('user_email')
                  ->orWhere('user_name', '')
                  ->orWhere('user_email', '');
        })->count();

        $this->info("🔍 Cache alanları boş olan kayıt sayısı: {$emptyCache}");

        if ($emptyCache === 0) {
            $this->info('✅ Tüm kayıtlarda cache verileri mevcut!');
            return 0;
        }

        // Progress bar oluştur
        $bar = $this->output->createProgressBar($emptyCache);
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %message%');

        $updated = 0;
        $failed = 0;

        // Batch olarak işle (1000'erli gruplar)
        User_plans::where(function($query) {
            $query->whereNull('user_name')
                  ->orWhereNull('user_email')
                  ->orWhere('user_name', '')
                  ->orWhere('user_email', '');
        })
        ->with('user:id,name,email')
        ->chunk(1000, function ($trades) use (&$updated, &$failed, $bar, $dryRun) {
            foreach ($trades as $trade) {
                $bar->setMessage("İşleniyor Trade ID: {$trade->id}");
                
                if ($trade->user && is_object($trade->user)) {
                    // Cache verilerini güncelle
                    if (!$dryRun) {
                        try {
                            $trade->update([
                                'user_name' => $trade->user->name,
                                'user_email' => $trade->user->email
                            ]);
                            $updated++;
                        } catch (\Exception $e) {
                            $failed++;
                            $this->error("\n❌ Trade ID {$trade->id} güncellenemedi: " . $e->getMessage());
                        }
                    } else {
                        $updated++;
                        $this->line("\n[DRY RUN] Trade ID {$trade->id}: {$trade->user->name} / {$trade->user->email}");
                    }
                } else {
                    // User bulunamayan kayıtlar için null set et
                    if (!$dryRun) {
                        try {
                            $trade->update([
                                'user' => null,
                                'user_name' => null,
                                'user_email' => null
                            ]);
                            $updated++;
                        } catch (\Exception $e) {
                            $failed++;
                            $this->error("\n❌ Trade ID {$trade->id} temizlenemedi: " . $e->getMessage());
                        }
                    } else {
                        $updated++;
                        $this->line("\n[DRY RUN] Trade ID {$trade->id}: User bulunamadı - temizlenecek");
                    }
                }
                
                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine(2);

        // Sonuçları göster
        $this->info('📈 İşlem Sonuçları:');
        $this->info("✅ Güncellenen kayıt: {$updated}");
        
        if ($failed > 0) {
            $this->error("❌ Başarısız kayıt: {$failed}");
        }

        if ($dryRun) {
            $this->warn('💡 Gerçek güncelleme için: php artisan user-plans:update-cache');
        } else {
            $this->info('🎉 Cache güncelleme işlemi tamamlandı!');
            
            // Son durumu kontrol et
            $remainingEmpty = User_plans::where(function($query) {
                $query->whereNull('user_name')
                      ->orWhereNull('user_email')
                      ->orWhere('user_name', '')
                      ->orWhere('user_email', '');
            })->count();
            
            if ($remainingEmpty > 0) {
                $this->warn("⚠️  Hala {$remainingEmpty} kayıtta cache verisi eksik");
            } else {
                $this->info('✅ Tüm cache verileri güncellendi!');
            }
        }

        return 0;
    }

    /**
     * user_name ve user_email kolonlarının varlığını kontrol et
     */
    private function checkColumns(): bool
    {
        try {
            return Schema::hasColumns('user_plans', ['user_name', 'user_email']);
        } catch (\Exception $e) {
            return false;
        }
    }
}