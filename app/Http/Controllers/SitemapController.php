<?php

namespace App\Http\Controllers;

use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    protected SeoService $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Generate and return XML sitemap
     */
    public function index(): Response
    {
        $sitemap = $this->seoService->generateSitemap();
        
        return response($sitemap, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600', // Cache for 1 hour
        ]);
    }

    /**
     * Generate specific sitemap type
     */
    public function type(string $type): Response
    {
        $allowedTypes = ['pages', 'plans', 'articles', 'posts'];
        
        if (!in_array($type, $allowedTypes)) {
            abort(404);
        }

        $sitemap = $this->generateTypeSitemap($type);
        
        return response($sitemap, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * Generate sitemap for specific type
     */
    protected function generateTypeSitemap(string $type): string
    {
        $urls = collect($this->getTypeUrls($type))
            ->map(function ($url) {
                return [
                    'loc' => $url['url'],
                    'lastmod' => $url['lastmod'] ?? now()->toISOString(),
                    'changefreq' => $url['changefreq'] ?? 'weekly',
                    'priority' => $url['priority'] ?? '0.8',
                ];
            });

        if ($urls->isEmpty()) {
            abort(404);
        }

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
     * Get URLs for specific sitemap type
     */
    protected function getTypeUrls(string $type): array
    {
        $baseUrl = config('app.url');
        
        switch ($type) {
            case 'pages':
                return [
                    [
                        'url' => $baseUrl,
                        'priority' => '1.0',
                        'changefreq' => 'daily',
                    ],
                    [
                        'url' => $baseUrl . '/about',
                        'priority' => '0.8',
                        'changefreq' => 'monthly',
                    ],
                    [
                        'url' => $baseUrl . '/contact',
                        'priority' => '0.8',
                        'changefreq' => 'monthly',
                    ],
                    [
                        'url' => $baseUrl . '/faq',
                        'priority' => '0.7',
                        'changefreq' => 'weekly',
                    ],
                    [
                        'url' => $baseUrl . '/investment-plans',
                        'priority' => '0.9',
                        'changefreq' => 'weekly',
                    ],
                    [
                        'url' => $baseUrl . '/terms',
                        'priority' => '0.6',
                        'changefreq' => 'yearly',
                    ],
                    [
                        'url' => $baseUrl . '/privacy',
                        'priority' => '0.6',
                        'changefreq' => 'yearly',
                    ],
                ];

            case 'plans':
                // Get dynamic plan URLs
                $plans = \App\Models\User_plans::with('plan')
                    ->whereHas('plan')
                    ->get()
                    ->pluck('plan')
                    ->unique('id');

                $urls = [];
                foreach ($plans as $plan) {
                    $urls[] = [
                        'url' => $baseUrl . '/plans/' . ($plan->slug ?? $plan->id),
                        'priority' => '0.8',
                        'changefreq' => 'weekly',
                        'lastmod' => $plan->updated_at?->toISOString(),
                    ];
                }
                return $urls;

            case 'articles':
                // Add article URLs if you have an articles system
                return [];

            default:
                return [];
        }
    }
}