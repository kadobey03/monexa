<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Error Handling Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the unified error handling system across MonexaFinans
    |
    */

    'response_format' => [
        'include_debug' => env('APP_DEBUG', false),
        'default_locale' => 'tr',
        'supported_locales' => ['tr', 'en'],
        'include_context' => true,
        'include_trace' => env('APP_DEBUG', false),
    ],

    'logging' => [
        'channels' => [
            'financial_errors' => [
                'driver' => 'daily',
                'path' => storage_path('logs/financial_errors.log'),
                'level' => 'error',
                'days' => 30,
            ],
            'api_errors' => [
                'driver' => 'daily',
                'path' => storage_path('logs/api_errors.log'),
                'level' => 'error',
                'days' => 14,
            ],
            'kyc_errors' => [
                'driver' => 'daily',
                'path' => storage_path('logs/kyc_errors.log'),
                'level' => 'warning',
                'days' => 30,
            ],
            'financial_audit' => [
                'driver' => 'daily',
                'path' => storage_path('logs/financial_audit.log'),
                'level' => 'info',
                'days' => 90,
            ],
            'alerts' => [
                'driver' => 'daily',
                'path' => storage_path('logs/alerts.log'),
                'level' => 'critical',
                'days' => 365,
            ],
        ],

        'error_logging' => [
            'enabled' => true,
            'model' => 'App\\Models\\ErrorLog',
            'critical_threshold' => 10, // Critical errors per hour
            'alert_email' => env('ERROR_ALERT_EMAIL'),
        ],
    ],

    'financial_limits' => [
        'min_transaction_amount' => 0.01,
        'max_transaction_amount' => 1000000,
        'daily_withdrawal_limit' => 10000,
        'daily_transfer_limit' => 50000,
        'daily_investment_limit' => 100000,
        'daily_limit' => 50000,
    ],

    'retry_mechanisms' => [
        'max_attempts' => 3,
        'base_delay' => 1000, // milliseconds
        'max_delay' => 10000,
        'jitter' => true,
    ],

    'circuit_breaker' => [
        'failure_threshold' => 5,
        'recovery_timeout' => 60, // seconds
        'half_open_max_calls' => 3,
    ],

    'monitoring' => [
        'health_check_interval' => 300, // seconds
        'performance_threshold' => 2000, // milliseconds
        'error_rate_threshold' => 0.05, // 5%
        'response_time_threshold' => 1000, // milliseconds
    ],

    'notifications' => [
        'email' => [
            'enabled' => env('ERROR_NOTIFICATIONS_EMAIL', true),
            'recipients' => explode(',', env('ERROR_NOTIFICATION_RECIPIENTS', '')),
            'subject_prefix' => '[MonexaFinans Error]',
        ],
        
        'slack' => [
            'enabled' => env('SLACK_NOTIFICATIONS', false),
            'webhook_url' => env('SLACK_WEBHOOK_URL'),
            'channel' => env('SLACK_ERROR_CHANNEL', '#alerts'),
        ],
    ],

    'client_side' => [
        'error_boundary' => [
            'max_retries' => 3,
            'retry_delay' => 1000,
            'show_suggestions' => true,
            'capture_console_errors' => true,
        ],
        
        'notification_system' => [
            'enabled' => true,
            'auto_hide_duration' => 5000,
            'max_visible' => 5,
        ],
    ],

    'localization' => [
        'fallback_locale' => 'tr',
        'supported_locales' => ['tr', 'en'],
        'error_message_namespace' => 'errors',
    ],
];