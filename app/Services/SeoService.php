<?php

namespace App\Services;

use App\Models\Settings;
use App\Models\User;
use App\Models\User_plans;
use App\Models\Deposit;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class SeoService
{
    protected Settings $settings;
    protected string $baseUrl;
    protected string $locale;

    public function __construct()
    {
        $this->settings = Settings::first();
        $this->baseUrl = config('app.url');
        $this->locale = config('app.locale', 'tr');
    }

    /**
     * Get complete SEO data for current page
     */
    public function generateSeoData(string $pageType = 'homepage', array $additionalData = []): array
    {
        $seoData = [
            'meta' => $this->generateMetaTags($pageType, $additionalData),
            'structuredData' => $this->generateStructuredData($pageType, $additionalData),
            'openGraph' => $this->generateOpenGraphTags($pageType, $additionalData),
            'twitterCard' => $this->generateTwitterCardTags($pageType, $additionalData),
            'canonicalUrl' => $this->getCanonicalUrl($pageType, $additionalData),
            'breadcrumb' => $this->generateBreadcrumb($pageType, $additionalData),
        ];

        return $seoData;
    }

    /**
     * Generate comprehensive meta tags
     */
    protected function generateMetaTags(string $pageType, array $data): array
    {
        $metaTags = [
            'title' => $this->getPageTitle($pageType, $data),
            'description' => $this->getPageDescription($pageType, $data),
            'keywords' => $this->getPageKeywords($pageType, $data),
            'robots' => $this->getRobotsIndex($pageType),
            'author' => $this->settings->site_name ?? 'MonexaFinans',
            'language' => $this->locale,
            'geo.region' => $this->getGeoRegion(),
            'geo.placename' => $this->getGeoPlaceName(),
            'geo.position' => $this->getGeoPosition(),
            'ICBM' => $this->getICBMCoordinates(),
        ];

        return $metaTags;
    }

    /**
     * Generate structured data based on page type
     */
    protected function generateStructuredData(string $pageType, array $data): array
    {
        $schemas = [];

        // Financial Service Organization for all pages
        $schemas[] = $this->generateFinancialServiceOrganization();

        // Page-specific schemas
        switch ($pageType) {
            case 'homepage':
                $schemas[] = $this->generateBreadcrumbList($data);
                $schemas[] = $this->generateLocalBusiness();
                break;
            
            case 'investment-plans':
            case 'plans':
                $schemas[] = $this->generateProductSchemas($data);
                $schemas[] = $this->generateBreadcrumbList($data);
                break;
            
            case 'faq':
                $schemas[] = $this->generateFAQSchema($data);
                $schemas[] = $this->generateBreadcrumbList($data);
                break;
            
            case 'about':
            case 'contact':
                $schemas[] = $this->generateLocalBusiness();
                $schemas[] = $this->generateBreadcrumbList($data);
                break;
            
            case 'article':
            case 'education':
                $schemas[] = $this->generateArticleSchema($data);
                $schemas[] = $this->generateBreadcrumbList($data);
                break;
            
            case 'trading':
                $schemas[] = $this->generateProductSchemas($data, 'service');
                $schemas[] = $this->generateBreadcrumbList($data);
                break;
            
            default:
                $schemas[] = $this->generateBreadcrumbList($data);
                break;
        }

        return array_filter($schemas);
    }

    /**
     * Financial Service Organization Schema
     */
    protected function generateFinancialServiceOrganization(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FinancialService',
            'name' => $this->settings->site_name ?? 'MonexaFinans',
            'description' => 'Professional trading and investment platform providing cryptocurrency, forex, and traditional investment solutions.',
            'url' => $this->baseUrl,
            'logo' => $this->getLogoUrl(),
            'favicon' => $this->getFaviconUrl(),
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'TR',
                'addressRegion' => 'Istanbul',
                'addressLocality' => 'Istanbul',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+90-212-XXX-XXXX',
                'contactType' => 'customer service',
                'availableLanguage' => ['Turkish', 'English'],
                'areaServed' => ['TR', 'EU', 'US'],
            ],
            'sameAs' => $this->getSocialMediaLinks(),
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Investment Plans',
                'itemListElement' => $this->getInvestmentPlansCatalog(),
            ],
            'makesOffer' => [
                [
                    '@type' => 'Offer',
                    'name' => 'Cryptocurrency Trading',
                    'description' => 'Professional cryptocurrency trading platform with real-time analysis.',
                ],
                [
                    '@type' => 'Offer',
                    'name' => 'Forex Trading',
                    'description' => 'Comprehensive forex trading with advanced tools and analysis.',
                ],
                [
                    '@type' => 'Offer',
                    'name' => 'Investment Plans',
                    'description' => 'Diversified investment opportunities with competitive returns.',
                ],
            ],
            'areaServed' => [
                [
                    '@type' => 'Country',
                    'name' => 'Turkey',
                ],
                [
                    '@type' => 'Country',
                    'name' => 'Germany',
                ],
                [
                    '@type' => 'Country',
                    'name' => 'United Kingdom',
                ],
                [
                    '@type' => 'Country',
                    'name' => 'United States',
                ],
            ],
            'knowsAbout' => [
                'Cryptocurrency Trading',
                'Forex Trading',
                'Investment Management',
                'Financial Planning',
                'Portfolio Management',
                'Risk Management',
            ],
        ];
    }

    /**
     * Product/Service Schemas for Investment Plans
     */
    protected function generateProductSchemas(array $data, string $type = 'product'): array
    {
        $plans = User_plans::with('plan')
            ->whereHas('plan')
            ->get()
            ->pluck('plan')
            ->unique('id')
            ->take(10);

        $products = [];

        foreach ($plans as $plan) {
            $products[] = [
                '@type' => $type === 'service' ? 'Service' : 'Product',
                'name' => $plan->name ?? 'Investment Plan',
                'description' => $plan->description ?? 'Professional investment plan',
                'provider' => [
                    '@type' => 'Organization',
                    'name' => $this->settings->site_name ?? 'MonexaFinans',
                    'url' => $this->baseUrl,
                ],
                'offers' => [
                    '@type' => 'Offer',
                    'price' => $plan->price ?? 0,
                    'priceCurrency' => 'USD',
                    'availability' => 'https://schema.org/InStock',
                    'validFrom' => now()->toISOString(),
                    'url' => $this->baseUrl . '/plans/' . ($plan->slug ?? $plan->id),
                ],
                'category' => 'Investment Plan',
                'audience' => [
                    '@type' => 'Audience',
                    'audienceType' => 'Investors',
                ],
            ];
        }

        return $products;
    }

    /**
     * FAQ Schema
     */
    protected function generateFAQSchema(array $data): array
    {
        $faqs = [
            [
                'question' => 'MonexaFinans güvenli bir platform mu?',
                'answer' => 'MonexaFinans, sektördeki en güvenli ve şeffaf platformlardan biridir. Tüm fonlarınız en üst seviye güvenlik protokolleri ile korunmaktadır.',
            ],
            [
                'question' => 'Minimum yatırım tutarı nedir?',
                'answer' => 'Minimum yatırım tutarı plan türüne göre değişmektedir. Detaylı bilgi için yatırım planlarımızı inceleyebilirsiniz.',
            ],
            [
                'question' => 'Kripto para yatırımları nasıl çalışır?',
                'answer' => 'Kripto para yatırımları, profesyonel traderlarımız tarafından yönetilen algoritmalarla gerçekleştirilir ve piyasa analizleri ile desteklenir.',
            ],
            [
                'question' => 'Çekim işlemleri ne kadar sürer?',
                'answer' => 'Çekim işlemleri genellikle 24-48 saat içinde tamamlanır. Banka tatilleri ve resmi tatiller hariç tutulur.',
            ],
            [
                'question' => 'Demo hesap açabilir miyim?',
                'answer' => 'Evet, risk almadan platformu test etmek için ücretsiz demo hesap açabilirsiniz.',
            ],
        ];

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(function ($faq) {
                return [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer'],
                    ],
                ];
            }, $faqs),
        ];
    }

    /**
     * BreadcrumbList Schema
     */
    protected function generateBreadcrumbList(array $data): array
    {
        $breadcrumbs = $data['breadcrumbs'] ?? $this->getDefaultBreadcrumbs(Route::currentRouteName());

        $breadcrumbItems = [];
        $position = 1;

        foreach ($breadcrumbs as $breadcrumb) {
            $breadcrumbItems[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $breadcrumb['name'],
                'item' => $breadcrumb['url'] ?? ($position === 1 ? $this->baseUrl : ''),
            ];
            $position++;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbItems,
        ];
    }

    /**
     * Article Schema for Educational Content
     */
    protected function generateArticleSchema(array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $data['title'] ?? 'Investment Guide',
            'description' => $data['description'] ?? 'Comprehensive investment guide',
            'image' => $data['image'] ?? $this->getLogoUrl(),
            'author' => [
                '@type' => 'Organization',
                'name' => $this->settings->site_name ?? 'MonexaFinans',
                'url' => $this->baseUrl,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $this->settings->site_name ?? 'MonexaFinans',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $this->getLogoUrl(),
                ],
            ],
            'datePublished' => $data['published_at'] ?? now()->toISOString(),
            'dateModified' => $data['updated_at'] ?? now()->toISOString(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $this->baseUrl . request()->getPathInfo(),
            ],
            'articleSection' => 'Financial Education',
            'keywords' => 'investment, finance, trading, cryptocurrency, forex',
            'inLanguage' => $this->locale,
        ];
    }

    /**
     * LocalBusiness Schema
     */
    protected function generateLocalBusiness(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FinancialService',
            '@id' => $this->baseUrl . '/#localbusiness',
            'name' => $this->settings->site_name ?? 'MonexaFinans',
            'description' => 'Professional financial services platform for cryptocurrency and forex trading.',
            'url' => $this->baseUrl,
            'logo' => $this->getLogoUrl(),
            'image' => $this->getLogoUrl(),
            'telephone' => '+90-212-XXX-XXXX',
            'email' => 'info@monexafinans.com',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Levent Mahallesi',
                'addressLocality' => 'Istanbul',
                'addressRegion' => 'Istanbul',
                'postalCode' => '34394',
                'addressCountry' => 'TR',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => '41.0082',
                'longitude' => '28.9784',
            ],
            'openingHours' => 'Mo-Fr 09:00-18:00',
            'priceRange' => '$$$',
            'currenciesAccepted' => 'USD, EUR, TRY, BTC, ETH',
            'paymentAccepted' => 'Credit Card, Bank Transfer, Cryptocurrency',
            'areaServed' => [
                'Turkey',
                'Germany',
                'United Kingdom',
                'United States',
                'European Union',
            ],
            'serviceArea' => [
                '@type' => 'GeoCircle',
                'geoMidpoint' => [
                    '@type' => 'GeoCoordinates',
                    'latitude' => '41.0082',
                    'longitude' => '28.9784',
                ],
                'geoRadius' => '50000000',
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Financial Services',
                'itemListElement' => [
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'Cryptocurrency Trading',
                            'description' => 'Professional cryptocurrency trading services',
                        ],
                    ],
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'Forex Trading',
                            'description' => 'Comprehensive forex trading services',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Generate Open Graph tags
     */
    protected function generateOpenGraphTags(string $pageType, array $data): array
    {
        $title = $this->getPageTitle($pageType, $data);
        $description = $this->getPageDescription($pageType, $data);
        $image = $data['og_image'] ?? $this->getLogoUrl();
        $url = $this->getCanonicalUrl($pageType, $data);

        return [
            'og:title' => $title,
            'og:description' => $description,
            'og:image' => $image,
            'og:url' => $url,
            'og:type' => $this->getOpenGraphType($pageType),
            'og:site_name' => $this->settings->site_name ?? 'MonexaFinans',
            'og:locale' => $this->locale . '_' . strtoupper($this->locale),
            'og:locale:alternate' => 'en_US',
        ];
    }

    /**
     * Generate Twitter Card tags
     */
    protected function generateTwitterCardTags(string $pageType, array $data): array
    {
        $title = $this->getPageTitle($pageType, $data);
        $description = $this->getPageDescription($pageType, $data);
        $image = $data['twitter_image'] ?? $this->getLogoUrl();

        return [
            'twitter:card' => 'summary_large_image',
            'twitter:site' => '@MonexaFinans',
            'twitter:creator' => '@MonexaFinans',
            'twitter:title' => $title,
            'twitter:description' => $description,
            'twitter:image' => $image,
            'twitter:image:alt' => $this->settings->site_name ?? 'MonexaFinans',
        ];
    }

    /**
     * Generate XML Sitemap
     */
    public function generateSitemap(): string
    {
        $urls = collect($this->getSitemapUrls())
            ->map(function ($url) {
                return [
                    'loc' => $url['url'],
                    'lastmod' => $url['lastmod'] ?? now()->toISOString(),
                    'changefreq' => $url['changefreq'] ?? 'weekly',
                    'priority' => $url['priority'] ?? '0.8',
                ];
            });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc']) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Get sitemap URLs
     */
    protected function getSitemapUrls(): array
    {
        $urls = [
            [
                'url' => $this->baseUrl,
                'priority' => '1.0',
                'changefreq' => 'daily',
            ],
            [
                'url' => $this->baseUrl . '/about',
                'priority' => '0.8',
                'changefreq' => 'monthly',
            ],
            [
                'url' => $this->baseUrl . '/contact',
                'priority' => '0.8',
                'changefreq' => 'monthly',
            ],
            [
                'url' => $this->baseUrl . '/faq',
                'priority' => '0.7',
                'changefreq' => 'weekly',
            ],
            [
                'url' => $this->baseUrl . '/investment-plans',
                'priority' => '0.9',
                'changefreq' => 'weekly',
            ],
            [
                'url' => $this->baseUrl . '/terms',
                'priority' => '0.6',
                'changefreq' => 'yearly',
            ],
            [
                'url' => $this->baseUrl . '/privacy',
                'priority' => '0.6',
                'changefreq' => 'yearly',
            ],
        ];

        // Add dynamic plan URLs
        $plans = User_plans::with('plan')
            ->whereHas('plan')
            ->get()
            ->pluck('plan')
            ->unique('id');

        foreach ($plans as $plan) {
            $urls[] = [
                'url' => $this->baseUrl . '/plans/' . ($plan->slug ?? $plan->id),
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'lastmod' => $plan->updated_at?->toISOString(),
            ];
        }

        return $urls;
    }

    // Helper methods for titles, descriptions, etc.
    protected function getPageTitle(string $pageType, array $data): string
    {
        $siteName = $this->settings->site_name ?? 'MonexaFinans';
        
        $titles = [
            'homepage' => $siteName . ' - Professional Trading Platform',
            'about' => 'About Us - ' . $siteName,
            'contact' => 'Contact Us - ' . $siteName,
            'faq' => 'Frequently Asked Questions - ' . $siteName,
            'investment-plans' => 'Investment Plans - ' . $siteName,
            'plans' => 'Investment Plans - ' . $siteName,
            'trading' => 'Trading Services - ' . $siteName,
            'terms' => 'Terms of Service - ' . $siteName,
            'privacy' => 'Privacy Policy - ' . $siteName,
        ];

        return $data['title'] ?? $titles[$pageType] ?? $siteName;
    }

    protected function getPageDescription(string $pageType, array $data): string
    {
        $descriptions = [
            'homepage' => 'Professional cryptocurrency, forex, and investment platform. Secure trading with advanced tools and competitive rates.',
            'about' => 'Learn about MonexaFinans - your trusted financial services partner for secure and profitable investments.',
            'contact' => 'Contact MonexaFinans for support, inquiries, and partnership opportunities. Professional customer service.',
            'faq' => 'Find answers to common questions about our trading platform, investment plans, and services.',
            'investment-plans' => 'Explore our diverse investment plans with competitive returns and professional management.',
            'trading' => 'Professional trading services including cryptocurrency and forex with advanced analytics and tools.',
            'terms' => 'Terms of service and user agreement for MonexaFinans platform.',
            'privacy' => 'Privacy policy and data protection information for MonexaFinans users.',
        ];

        return $data['description'] ?? $descriptions[$pageType] ?? 'Professional financial services platform';
    }

    protected function getPageKeywords(string $pageType, array $data): string
    {
        $keywords = [
            'homepage' => 'cryptocurrency, forex, trading, investment, finance, portfolio, bitcoin, ethereum',
            'investment-plans' => 'investment plans, portfolio management, financial planning, returns',
            'trading' => 'crypto trading, forex trading, professional trading, analysis, charts',
            'about' => 'about, company, team, mission, vision, financial services',
            'contact' => 'contact, support, customer service, help, inquiry',
            'faq' => 'FAQ, questions, answers, help, support',
        ];

        return $data['keywords'] ?? $keywords[$pageType] ?? 'trading, investment, finance, cryptocurrency';
    }

    protected function getRobotsIndex(string $pageType): string
    {
        $noIndexPages = ['dashboard', 'admin', 'user', 'profile', 'settings'];
        return in_array($pageType, $noIndexPages) ? 'noindex, nofollow' : 'index, follow';
    }

    protected function getCanonicalUrl(string $pageType, array $data): string
    {
        return $data['canonical_url'] ?? URL::full();
    }

    protected function getDefaultBreadcrumbs(string $routeName): array
    {
        $breadcrumbs = [
            'home' => [
                ['name' => 'Ana Sayfa', 'url' => $this->baseUrl],
            ],
            'about' => [
                ['name' => 'Ana Sayfa', 'url' => $this->baseUrl],
                ['name' => 'Hakkımızda', 'url' => $this->baseUrl . '/about'],
            ],
            'contact' => [
                ['name' => 'Ana Sayfa', 'url' => $this->baseUrl],
                ['name' => 'İletişim', 'url' => $this->baseUrl . '/contact'],
            ],
            'faq' => [
                ['name' => 'Ana Sayfa', 'url' => $this->baseUrl],
                ['name' => 'SSS', 'url' => $this->baseUrl . '/faq'],
            ],
            'investment-plans' => [
                ['name' => 'Ana Sayfa', 'url' => $this->baseUrl],
                ['name' => 'Yatırım Planları', 'url' => $this->baseUrl . '/investment-plans'],
            ],
            'plans.show' => [
                ['name' => 'Ana Sayfa', 'url' => $this->baseUrl],
                ['name' => 'Yatırım Planları', 'url' => $this->baseUrl . '/investment-plans'],
                ['name' => 'Plan Detayı', 'url' => ''],
            ],
        ];

        return $breadcrumbs[$routeName] ?? [['name' => 'Ana Sayfa', 'url' => $this->baseUrl]];
    }

    protected function getOpenGraphType(string $pageType): string
    {
        $types = [
            'homepage' => 'website',
            'article' => 'article',
            'about' => 'website',
            'contact' => 'website',
        ];

        return $types[$pageType] ?? 'website';
    }

    // Utility methods
    protected function getLogoUrl(): string
    {
        $logo = $this->settings->logo ?? null;
        return $logo ? asset('storage/' . $logo) : asset('images/logo.png');
    }

    protected function getFaviconUrl(): string
    {
        $favicon = $this->settings->favicon ?? null;
        return $favicon ? asset('storage/' . $favicon) : asset('favicon.ico');
    }

    protected function getSocialMediaLinks(): array
    {
        return [
            'https://twitter.com/MonexaFinans',
            'https://linkedin.com/company/MonexaFinans',
            'https://facebook.com/MonexaFinans',
        ];
    }

    protected function getInvestmentPlansCatalog(): array
    {
        $plans = User_plans::with('plan')
            ->whereHas('plan')
            ->get()
            ->pluck('plan')
            ->unique('id')
            ->take(5);

        return $plans->map(function ($plan) {
            return [
                '@type' => 'Offer',
                'itemOffered' => [
                    '@type' => 'Product',
                    'name' => $plan->name ?? 'Investment Plan',
                    'description' => $plan->description ?? 'Investment opportunity',
                ],
            ];
        })->toArray();
    }

    protected function getGeoRegion(): string
    {
        return 'TR-34';
    }

    protected function getGeoPlaceName(): string
    {
        return 'Istanbul, Turkey';
    }

    protected function getGeoPosition(): string
    {
        return '41.0082;28.9784';
    }

    protected function getICBMCoordinates(): string
    {
        return '41.0082, 28.9784';
    }

    protected function generateBreadcrumb(string $pageType, array $data): array
    {
        return $data['breadcrumbs'] ?? $this->getDefaultBreadcrumbs(Route::currentRouteName());
    }
}