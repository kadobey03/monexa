<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        
        // Hiyerarşik Rol Sistemi Policy'leri
        'App\Models\Admin' => 'App\Policies\AdminPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Role' => 'App\Policies\RolePolicy',
        'App\Models\Permission' => 'App\Policies\PermissionPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Translation Management Gates
        $this->defineTranslationGates();

        // VerifyEmail::toMailUsing(function ($notifiable, $url) {
        //     return (new MailMessage)
        //         ->subject('Verify Email Address')
        //         ->line('Click the button below to verify your email address.')
        //         ->action('Verify Email Address', $url);
        // });
    }

    /**
     * Define translation management gates.
     */
    protected function defineTranslationGates(): void
    {
        // Translation Management - Full access (create, edit, delete)
        Gate::define('manage-translations', function ($admin) {
            return $admin->hasPermission('translations.manage') || $admin->isSuperAdmin();
        });

        // Translation Review - Can approve translations
        Gate::define('approve-translations', function ($admin) {
            return $admin->hasPermission('translations.approve') ||
                   $admin->hasPermission('translations.manage') ||
                   $admin->isSuperAdmin();
        });

        // Translation View - Can view translations (read-only)
        Gate::define('view-translations', function ($admin) {
            return $admin->hasPermission('translations.view') ||
                   $admin->hasPermission('translations.approve') ||
                   $admin->hasPermission('translations.manage') ||
                   $admin->isSuperAdmin();
        });

        // Language Management - Can manage supported languages
        Gate::define('manage-languages', function ($admin) {
            return $admin->hasPermission('languages.manage') ||
                   $admin->hasPermission('translations.manage') ||
                   $admin->isSuperAdmin();
        });

        // Translation Statistics - Can view usage and statistics
        Gate::define('view-translation-stats', function ($admin) {
            return $admin->hasPermission('translations.stats') ||
                   $admin->hasPermission('translations.manage') ||
                   $admin->isSuperAdmin();
        });

        // Translation Import/Export - Can import/export translations
        Gate::define('import-export-translations', function ($admin) {
            return $admin->hasPermission('translations.import_export') ||
                   $admin->hasPermission('translations.manage') ||
                   $admin->isSuperAdmin();
        });

        // Translation Cache Management - Can clear and manage cache
        Gate::define('manage-translation-cache', function ($admin) {
            return $admin->hasPermission('translations.cache') ||
                   $admin->hasPermission('translations.manage') ||
                   $admin->isSuperAdmin();
        });

        // Dynamic permission check for specific phrases
        Gate::define('manage-phrase', function ($admin, $phrase = null) {
            // Super admin can manage any phrase
            if ($admin->isSuperAdmin()) {
                return true;
            }

            // Must have base translation management permission
            if (!$admin->hasPermission('translations.manage')) {
                return false;
            }

            // If no specific phrase provided, allow
            if (!$phrase) {
                return true;
            }

            // Check phrase group restrictions
            $restrictedGroups = ['admin', 'system', 'security'];
            if (in_array($phrase->group, $restrictedGroups)) {
                return $admin->hasPermission('translations.manage_restricted') || $admin->isSuperAdmin();
            }

            return true;
        });

        // Language-specific permissions
        Gate::define('manage-language', function ($admin, $language = null) {
            if ($admin->isSuperAdmin()) {
                return true;
            }

            if (!$admin->hasPermission('languages.manage')) {
                return false;
            }

            // If no specific language provided, allow
            if (!$language) {
                return true;
            }

            // Check if admin can manage this specific language
            $adminLanguages = $admin->getSetting('allowed_languages', []);
            if (!empty($adminLanguages) && !in_array($language->code, $adminLanguages)) {
                return false;
            }

            return true;
        });
    }
}
