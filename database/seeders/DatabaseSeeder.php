<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // SettingsSeeder::class, // Disabled - causing scurrency column error in production
            
            // === USER MANAGEMENT PHRASES SEEDERS ===
            UserManagementPhrasesSeeder::class,           // 480 phrases - Ana user management terimleri
            UsersManagementBladePhrasesSeeder::class,     // 176 phrases - Users management blade specific
            CustomerBladePhrasesSeeder::class,            // 2 phrases - Customer blade
            MadminBladePhrasesSeeder::class,              // 1 phrase - Madmin blade
            ViewAgentBladePhrasesSeeder::class,           // 2 phrases - View agent blade
            AddAdminBladePhrasesSeeder::class,            // 1 phrase - Add admin blade
            ReferUserBladePhrasesSeeder::class,           // 3 phrases - Refer user blade
            UsersModernBladePhrasesSeeder::class,         // 115 phrases - Users modern blade
            FinalUserManagementPhrasesSeeder::class,      // 347 phrases - Final comprehensive seeder
            AdditionalUserManagementPhrasesSeeder::class, // 425+ phrases - Most comprehensive seeder
            
            // === JAVASCRIPT PHRASES SEEDER ===
            JavascriptPhrasesSeeder::class,               // 101+ phrases - JavaScript localization (TR + RU)
        ]);
        
        // \App\Models\Adverts::factory(7)->create(); // Commented out - table doesn't exist
    }
}
