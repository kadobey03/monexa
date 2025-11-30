<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserCorrect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin tablosuna test admin kullanıcısı oluştur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Admin tablosuna test admin kullanıcısı oluşturuluyor...');

        // Admin tablosunda mevcut admin var mı kontrol et
        $existingAdmin = Admin::where('email', 'admin@monexa.com')->first();
        
        if ($existingAdmin) {
            $this->warn('admin@monexa.com emailli admin zaten mevcut:');
            $this->line("ID: {$existingAdmin->id}");
            $this->line("Ad: {$existingAdmin->firstName} {$existingAdmin->lastName}");
            $this->line("Status: {$existingAdmin->status}");
            return;
        }

        try {
            $admin = Admin::create([
                'firstName' => 'Test',
                'lastName' => 'Admin',
                'email' => 'admin@monexa.com',
                'password' => Hash::make('password123'),
                'status' => Admin::STATUS_ACTIVE,  // 'Active'
                'type' => Admin::TYPE_ADMIN,       // 'admin'
                'department' => 'IT',
                'position' => 'System Administrator',
                'is_available' => true,
                'language' => 'tr',
                'time_zone' => 'Europe/Istanbul'
            ]);

            $this->info('✅ Admin başarıyla oluşturuldu:');
            $this->line("ID: {$admin->id}");
            $this->line("Email: {$admin->email}");
            $this->line("Şifre: password123");
            $this->line("Guard: admin");
            $this->line("Status: {$admin->status}");
            
        } catch (\Exception $e) {
            $this->error('❌ Admin oluşturma hatası:');
            $this->error($e->getMessage());
        }
    }
}