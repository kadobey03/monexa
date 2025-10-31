<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FinancialService;
use App\Services\UserService;
use App\Services\PlanService;
use App\Services\NotificationService;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FinancialService::class);
        $this->app->singleton(UserService::class);
        $this->app->singleton(PlanService::class);
        $this->app->singleton(NotificationService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}