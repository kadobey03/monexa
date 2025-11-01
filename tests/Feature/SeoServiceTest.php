<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\SeoService;
use App\Models\Settings;
use App\Models\User;
use App\Models\User_plans;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create settings
        Settings::factory()->create([
            'site_name' => 'Test MonexaFinans',
            'logo' => 'logo.png',
            'favicon' => 'favicon.ico'
        ]);
    }

    /** @test */
    public function it_generates_seo_data_for_homepage()
    {
        $seoService = new SeoService();
        $seoData = $seoService->generateSeoData('homepage');

        $this->assertArrayHasKey('meta', $seoData);
        $this->assertArrayHasKey('structuredData', $seoData);
        $this->assertArrayHasKey('openGraph', $seoData);
        $this->assertArrayHasKey('twitterCard', $seoData);
        $this->assertArrayHasKey('canonicalUrl', $seoData);
        $this->assertArrayHasKey('breadcrumb', $seoData);

        // Check meta tags
        $this->assertStringContainsString('Test MonexaFinans', $seoData['meta']['title']);
        $this->assertStringContainsString('Professional trading', $seoData['meta']['description']);

        // Check structured data
        $this->assertNotEmpty($seoData['structuredData']);
        
        // Check if FinancialService organization is included
        $financialService = collect($seoData['structuredData'])->firstWhere('@type', 'FinancialService');
        $this->assertNotNull($financialService);
        $this->assertEquals('Test MonexaFinans', $financialService['name']);
    }

    /** @test */
    public function it_generates_financial_service_organization_schema()
    {
        $seoService = new SeoService();
        $seoData = $seoService->generateSeoData('homepage');
        $financialService = collect($seoData['structuredData'])->firstWhere('@type', 'FinancialService');

        $this->assertNotNull($financialService);
        $this->assertEquals('FinancialService', $financialService['@type']);
        $this->assertEquals('Test MonexaFinans', $financialService['name']);
        $this->assertArrayHasKey('contactPoint', $financialService);
        $this->assertArrayHasKey('sameAs', $financialService);
        $this->assertArrayHasKey('hasOfferCatalog', $financialService);
    }

    /** @test */
    public function it_generates_faq_schema_for_faq_page()
    {
        $seoService = new SeoService();
        $seoData = $seoService->generateSeoData('faq');
        
        $faqSchema = collect($seoData['structuredData'])->firstWhere('@type', 'FAQPage');
        $this->assertNotNull($faqSchema);
        $this->assertEquals('FAQPage', $faqSchema['@type']);
        $this->assertArrayHasKey('mainEntity', $faqSchema);
        $this->assertNotEmpty($faqSchema['mainEntity']);
        
        // Check if Turkish FAQ content is included
        $firstQuestion = $faqSchema['mainEntity'][0];
        $this->assertStringContainsString('güvenli', $firstQuestion['name']);
    }

    /** @test */
    public function it_generates_product_schemas_for_investment_plans()
    {
        // Create a plan
        $plan = \App\Models\Plans::factory()->create([
            'name' => 'Test Investment Plan',
            'description' => 'Test Description',
            'price' => 1000,
            'slug' => 'test-plan'
        ]);

        $userPlan = User_plans::factory()->create([
            'plan' => $plan->id
        ]);

        $seoService = new SeoService();
        $seoData = $seoService->generateSeoData('investment-plans');
        
        $productSchemas = collect($seoData['structuredData'])->filter(function ($schema) {
            return isset($schema['@type']) && in_array($schema['@type'], ['Product', 'Service']);
        });

        $this->assertNotEmpty($productSchemas);
        
        $productSchema = $productSchemas->first();
        $this->assertEquals('Product', $productSchema['@type']);
        $this->assertEquals('Test Investment Plan', $productSchema['name']);
    }

    /** @test */
    public function it_generates_breadcrumb_schema()
    {
        $seoService = new SeoService();
        $seoData = $seoService->generateSeoData('about');
        
        $breadcrumbSchema = collect($seoData['structuredData'])->firstWhere('@type', 'BreadcrumbList');
        $this->assertNotNull($breadcrumbSchema);
        $this->assertEquals('BreadcrumbList', $breadcrumbSchema['@type']);
        $this->assertArrayHasKey('itemListElement', $breadcrumbSchema);
        $this->assertNotEmpty($breadcrumbSchema['itemListElement']);
        
        // Check Turkish breadcrumb content
        $firstItem = $breadcrumbSchema['itemListElement'][0];
        $this->assertEquals('Ana Sayfa', $firstItem['name']);
    }

    /** @test */
    public function it_generates_local_business_schema()
    {
        $seoService = new SeoService();
        $seoData = $seoService->generateSeoData('contact');
        
        $localBusiness = collect($seoData['structuredData'])->firstWhere('@type', 'FinancialService');
        $this->assertNotNull($localBusiness);
        $this->assertArrayHasKey('address', $localBusiness);
        $this->assertArrayHasKey('geo', $localBusiness);
        $this->assertArrayHasKey('areaServed', $localBusiness);
        
        // Check Turkish location
        $this->assertEquals('TR', $localBusiness['address']['addressCountry']);
        $this->assertEquals('Istanbul', $localBusiness['address']['addressLocality']);
    }

    /** @test */
    public function it_generates_open_graph_tags()
    {
        $seoService = new SeoService();
        $seoData = $seoService->generateSeoData('homepage');
        
        $this->assertArrayHasKey('og:title', $seoData['openGraph']);
        $this->assertArrayHasKey('og:description', $seoData['openGraph']);
        $this->assertArrayHasKey('og:image', $seoData['openGraph']);
        $this->assertArrayHasKey('og:url', $seoData['openGraph']);
        $this->assertArrayHasKey('og:type', $seoData['openGraph']);
        $this->assertArrayHasKey('og:site_name', $seoData['openGraph']);
        
        $this->assertStringContainsString('Test MonexaFinans', $seoData['openGraph']['og:title']);
    }

    /** @test */
    public function it_generates_twitter_card_tags()
    {
        $seoService = new SeoService();
        $seoData = $seoService->generateSeoData('homepage');
        
        $this->assertArrayHasKey('twitter:card', $seoData['twitterCard']);
        $this->assertArrayHasKey('twitter:site', $seoData['twitterCard']);
        $this->assertArrayHasKey('twitter:title', $seoData['twitterCard']);
        $this->assertArrayHasKey('twitter:description', $seoData['twitterCard']);
        $this->assertArrayHasKey('twitter:image', $seoData['twitterCard']);
        
        $this->assertEquals('summary_large_image', $seoData['twitterCard']['twitter:card']);
    }

    /** @test */
    public function it_generates_xml_sitemap()
    {
        $seoService = new SeoService();
        $sitemap = $seoService->generateSitemap();
        
        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $sitemap);
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $sitemap);
        $this->assertStringContainsString('<loc>', $sitemap);
        $this->assertStringContainsString('<priority>', $sitemap);
        
        // Check if homepage is included
        $this->assertStringContainsString(config('app.url'), $sitemap);
    }

    /** @test */
    public function it_handles_custom_additional_data()
    {
        $seoService = new SeoService();
        $customData = [
            'title' => 'Custom Title',
            'description' => 'Custom Description',
            'keywords' => 'custom, keywords'
        ];
        
        $seoData = $seoService->generateSeoData('homepage', $customData);
        
        $this->assertEquals('Custom Title', $seoData['meta']['title']);
        $this->assertEquals('Custom Description', $seoData['meta']['description']);
        $this->assertEquals('custom, keywords', $seoData['meta']['keywords']);
    }

    /** @test */
    public function it_generates_article_schema_for_educational_content()
    {
        $articleData = [
            'title' => 'Investment Guide',
            'description' => 'Complete investment guide',
            'published_at' => now()->toISOString(),
            'updated_at' => now()->toISOString()
        ];
        
        $seoService = new SeoService();
        $seoData = $seoService->generateSeoData('article', $articleData);
        
        $articleSchema = collect($seoData['structuredData'])->firstWhere('@type', 'Article');
        $this->assertNotNull($articleSchema);
        $this->assertEquals('Article', $articleSchema['@type']);
        $this->assertEquals('Investment Guide', $articleSchema['headline']);
        $this->assertEquals('Complete investment guide', $articleSchema['description']);
    }

    /** @test */
    public function it_validates_schema_structure()
    {
        $seoService = new SeoService();
        $seoData = $seoService->generateSeoData('homepage');
        
        foreach ($seoData['structuredData'] as $schema) {
            $this->assertArrayHasKey('@context', $schema);
            $this->assertArrayHasKey('@type', $schema);
            $this->assertEquals('https://schema.org', $schema['@context']);
            
            // Validate specific schema types
            switch ($schema['@type']) {
                case 'FinancialService':
                    $this->assertArrayHasKey('name', $schema);
                    $this->assertArrayHasKey('description', $schema);
                    break;
                    
                case 'BreadcrumbList':
                    $this->assertArrayHasKey('itemListElement', $schema);
                    foreach ($schema['itemListElement'] as $item) {
                        $this->assertArrayHasKey('@type', $item);
                        $this->assertArrayHasKey('position', $item);
                        $this->assertArrayHasKey('name', $item);
                        $this->assertArrayHasKey('item', $item);
                    }
                    break;
                    
                case 'FAQPage':
                    $this->assertArrayHasKey('mainEntity', $schema);
                    break;
            }
        }
    }
}