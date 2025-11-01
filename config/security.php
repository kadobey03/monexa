<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MonexaFinans Production Security Configuration
    |--------------------------------------------------------------------------
    |
    | Bu dosya MonexaFinans fintech platformu için özel olarak tasarlanmış
    | production güvenlik yapılandırmalarını içerir. Finansal servisler
    | için endüstri standardı güvenlik gereksinimlerini karşılar.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Security Headers Configuration
    |--------------------------------------------------------------------------
    */
    'headers' => [
        'content_security_policy' => [
            'enabled' => env('SECURITY_CSP_ENABLED', true),
            'report_only' => env('SECURITY_CSP_REPORT_ONLY', false),
            'directives' => [
                'default-src' => ["'self'"],
                'script-src' => [
                    "'self'",
                    "'unsafe-inline'",
                    "'unsafe-eval'",
                    'https://cdn.jsdelivr.net',
                    'https://cdnjs.cloudflare.com',
                    'https://fonts.googleapis.com',
                    'blob:'
                ],
                'style-src' => [
                    "'self'",
                    "'unsafe-inline'",
                    'https://fonts.googleapis.com',
                    'https://cdnjs.cloudflare.com'
                ],
                'font-src' => ["'self'", 'https://fonts.gstatic.com', 'data:'],
                'img-src' => ["'self'", 'data:', 'blob:', 'https:'],
                'media-src' => ["'self'", 'blob:'],
                'frame-src' => [
                    "'self'",
                    'https://js.stripe.com',
                    'https://checkout.stripe.com',
                    'https://js.paystack.co',
                    'https://api.paystack.co'
                ],
                'connect-src' => [
                    "'self'",
                    'https://api.stripe.com',
                    'https://api.paystack.co',
                    'https://api.coinbase.com',
                    'https://api.coingecko.com',
                    'wss:', 'ws:'
                ],
                'object-src' => ["'none'"],
                'base-uri' => ["'self'"],
                'form-action' => ["'self'"],
                'frame-ancestors' => ["'none'"],
                'worker-src' => ["'self'", 'blob:'],
                'manifest-src' => ["'self'"]
            ]
        ],

        'strict_transport_security' => [
            'enabled' => env('SECURITY_HSTS_ENABLED', true),
            'max_age' => env('SECURITY_HSTS_MAX_AGE', 31536000), // 1 year
            'include_subdomains' => env('SECURITY_HSTS_SUBDOMAINS', true),
            'preload' => env('SECURITY_HSTS_PRELOAD', true)
        ],

        'x_frame_options' => env('SECURITY_X_FRAME_OPTIONS', 'SAMEORIGIN'),
        'x_content_type_options' => env('SECURITY_X_CONTENT_TYPE_OPTIONS', 'nosniff'),
        'x_xss_protection' => env('SECURITY_X_XSS_PROTECTION', '1; mode=block'),
        'referrer_policy' => env('SECURITY_REFERRER_POLICY', 'strict-origin-when-cross-origin'),
        'permissions_policy' => env('SECURITY_PERMISSIONS_POLICY', 'geolocation=(), microphone=(), camera=(), payment=(), usb=()'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting Configuration
    |--------------------------------------------------------------------------
    */
    'rate_limiting' => [
        'enabled' => env('SECURITY_RATE_LIMITING_ENABLED', true),
        'storage' => env('SECURITY_RATE_LIMIT_STORAGE', 'redis'),
        
        'tiers' => [
            'financial' => [
                'max_attempts' => env('SECURITY_RATE_FINANCIAL_MAX', 3),
                'decay_minutes' => env('SECURITY_RATE_FINANCIAL_DECAY', 15)
            ],
            'login' => [
                'max_attempts' => env('SECURITY_RATE_LOGIN_MAX', 5),
                'decay_minutes' => env('SECURITY_RATE_LOGIN_DECAY', 15)
            ],
            'api' => [
                'max_attempts' => env('SECURITY_RATE_API_MAX', 60),
                'decay_minutes' => env('SECURITY_RATE_API_DECAY', 1)
            ],
            'form' => [
                'max_attempts' => env('SECURITY_RATE_FORM_MAX', 10),
                'decay_minutes' => env('SECURITY_RATE_FORM_DECAY', 5)
            ],
            'kyc' => [
                'max_attempts' => env('SECURITY_RATE_KYC_MAX', 3),
                'decay_minutes' => env('SECURITY_RATE_KYC_DECAY', 60)
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Input Sanitization Configuration
    |--------------------------------------------------------------------------
    */
    'input_sanitization' => [
        'enabled' => env('SECURITY_INPUT_SANITIZATION_ENABLED', true),
        'strip_tags' => env('SECURITY_STRIP_TAGS', true),
        'escape_html' => env('SECURITY_ESCAPE_HTML', true),
        'validate_financial_data' => env('SECURITY_VALIDATE_FINANCIAL', true),
        'file_upload_validation' => env('SECURITY_FILE_UPLOAD_VALIDATION', true),
        'max_upload_size' => env('SECURITY_MAX_UPLOAD_SIZE', 10 * 1024 * 1024), // 10MB
        'allowed_file_types' => [
            'image/jpeg', 'image/png', 'image/gif', 'image/webp',
            'application/pdf', 'text/plain'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | CSRF Configuration
    |--------------------------------------------------------------------------
    */
    'csrf' => [
        'enabled' => env('SECURITY_CSRF_ENABLED', true),
        'token_lifetime' => env('SECURITY_CSRF_TOKEN_LIFETIME', 3600), // 1 hour
        'cookie_secure' => env('SECURITY_CSRF_COOKIE_SECURE', true),
        'cookie_httponly' => env('SECURITY_CSRF_COOKIE_HTTPONLY', true),
        'cookie_samesite' => env('SECURITY_CSRF_COOKIE_SAMESITE', 'strict')
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Security Configuration
    |--------------------------------------------------------------------------
    */
    'session' => [
        'secure' => env('SECURITY_SESSION_SECURE', true),
        'httponly' => env('SECURITY_SESSION_HTTPONLY', true),
        'samesite' => env('SECURITY_SESSION_SAMESITE', 'strict'),
        'lifetime' => env('SECURITY_SESSION_LIFETIME', 120), // 2 hours
        'regenerate_on_login' => env('SECURITY_SESSION_REGENERATE_LOGIN', true),
        'regenerate_on_sensitive_operation' => env('SECURITY_SESSION_REGENERATE_SENSITIVE', true)
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Security
    |--------------------------------------------------------------------------
    */
    'authentication' => [
        'password_policy' => [
            'min_length' => env('SECURITY_PASSWORD_MIN_LENGTH', 8),
            'require_uppercase' => env('SECURITY_PASSWORD_REQUIRE_UPPERCASE', true),
            'require_lowercase' => env('SECURITY_PASSWORD_REQUIRE_LOWERCASE', true),
            'require_numbers' => env('SECURITY_PASSWORD_REQUIRE_NUMBERS', true),
            'require_symbols' => env('SECURITY_PASSWORD_REQUIRE_SYMBOLS', true)
        ],
        'two_factor' => [
            'enabled' => env('SECURITY_2FA_ENABLED', true),
            'issuer' => env('SECURITY_2FA_ISSUER', 'MonexaFinans'),
            'window' => env('SECURITY_2FA_WINDOW', 1)
        ],
        'account_lockout' => [
            'enabled' => env('SECURITY_LOCKOUT_ENABLED', true),
            'max_attempts' => env('SECURITY_LOCKOUT_MAX_ATTEMPTS', 5),
            'lockout_duration' => env('SECURITY_LOCKOUT_DURATION', 1800) // 30 minutes
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging & Monitoring Configuration
    |--------------------------------------------------------------------------
    */
    'logging' => [
        'enabled' => env('SECURITY_LOGGING_ENABLED', true),
        'channels' => [
            'security' => [
                'driver' => env('SECURITY_LOG_CHANNEL', 'daily'),
                'path' => storage_path('logs/security.log'),
                'level' => env('SECURITY_LOG_LEVEL', 'warning'),
                'days' => env('SECURITY_LOG_DAYS', 30)
            ],
            'security_critical' => [
                'driver' => env('SECURITY_CRITICAL_LOG_CHANNEL', 'daily'),
                'path' => storage_path('logs/security-critical.log'),
                'level' => env('SECURITY_CRITICAL_LOG_LEVEL', 'critical'),
                'days' => env('SECURITY_CRITICAL_LOG_DAYS', 90)
            ]
        ],
        'audit_trail' => [
            'enabled' => env('SECURITY_AUDIT_TRAIL_ENABLED', true),
            'events' => [
                'login', 'logout', 'password_change', 'profile_update',
                'deposit', 'withdrawal', 'investment', 'kyc_submission',
                'admin_access', 'api_access', 'file_upload'
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Security
    |--------------------------------------------------------------------------
    */
    'database' => [
        'encryption' => [
            'enabled' => env('SECURITY_DB_ENCRYPTION_ENABLED', true),
            'fields' => [
                'users.email',
                'users.phone',
                'users.address',
                'deposits.transaction_id',
                'withdrawals.transaction_id',
                'kyc.documents',
                'kyc.personal_info'
            ]
        ],
        'queries' => [
            'log_slow_queries' => env('SECURITY_LOG_SLOW_QUERIES', true),
            'slow_query_threshold' => env('SECURITY_SLOW_QUERY_THRESHOLD', 1000) // milliseconds
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | API Security
    |--------------------------------------------------------------------------
    */
    'api' => [
        'authentication' => [
            'provider' => env('SECURITY_API_AUTH_PROVIDER', 'sanctum'),
            'token_lifetime' => env('SECURITY_API_TOKEN_LIFETIME', 3600)
        ],
        'versioning' => [
            'enabled' => env('SECURITY_API_VERSIONING_ENABLED', true),
            'default_version' => env('SECURITY_API_DEFAULT_VERSION', 'v1')
        ],
        'documentation' => [
            'enabled' => env('SECURITY_API_DOC_ENABLED', false), // Disabled in production
            'path' => env('SECURITY_API_DOC_PATH', '/docs')
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Compliance & Regulations
    |--------------------------------------------------------------------------
    */
    'compliance' => [
        'gdpr' => [
            'enabled' => env('SECURITY_GDPR_ENABLED', true),
            'data_retention_days' => env('SECURITY_GDPR_RETENTION_DAYS', 2555), // 7 years
            'right_to_be_forgotten' => env('SECURITY_GDPR_RIGHT_TO_FORGOTTEN', true)
        ],
        'pci_dss' => [
            'enabled' => env('SECURITY_PCI_DSS_ENABLED', true),
            'data_encryption' => env('SECURITY_PCI_DSS_ENCRYPTION', true),
            'access_control' => env('SECURITY_PCI_DSS_ACCESS_CONTROL', true)
        ],
        'sox' => [
            'enabled' => env('SECURITY_SOX_ENABLED', true),
            'financial_controls' => env('SECURITY_SOX_CONTROLS', true),
            'audit_trail' => env('SECURITY_SOX_AUDIT', true)
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment Specific Settings
    |--------------------------------------------------------------------------
    */
    'environment' => [
        'production' => [
            'debug' => env('SECURITY_PROD_DEBUG', false),
            'maintenance_mode' => env('SECURITY_MAINTENANCE_MODE', false),
            'admin_access_restriction' => env('SECURITY_ADMIN_RESTRICTION', true),
            'ip_whitelist' => explode(',', env('SECURITY_IP_WHITELIST', '')),
            'allowed_domains' => explode(',', env('SECURITY_ALLOWED_DOMAINS', ''))
        ],
        'staging' => [
            'debug' => env('SECURITY_STAGING_DEBUG', true),
            'maintenance_mode' => env('SECURITY_STAGING_MAINTENANCE', false),
            'admin_access_restriction' => env('SECURITY_STAGING_ADMIN_RESTRICTION', false)
        ]
    ]
];