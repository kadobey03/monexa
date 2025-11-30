<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Test',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'is_admin' => 1,
            ]
        );

        $this->info('Admin user created successfully: ' . $admin->email);
        $this->info('Password: password123');
        return 0;
    }
}