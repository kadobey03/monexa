<?php

namespace Tests\Integration;

use Tests\TestCase;
use App\Models\Language;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use App\Services\TranslationService;
use App\Services\CacheService;
use App\Services\PerformanceMonitoringService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Config;

class TranslationSystemIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected TranslationService $translationService;
    protected CacheService $cacheService;
    protected PerformanceMonitoringService $performanceService;
    
    protected Language $turkish;
    protected Language $russian;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create real service instances (not mocked)
        $this->translationService = app(TranslationService::class);
        $this->cacheService = app(CacheService::class);
        $this->performanceService = app(PerformanceMonitoringService::class);

        // Set up test languages
        $this->turkish = Language::factory()->turkish()->create();
        $this->russian = Language::factory()->russian()->create();
        
        // Set default locale
        app()->setLocale('tr');
        Config::set('app.locale', 'tr');
    }

    /** @test */
    public function complete_translation_workflow_works_correctly()
    {
        // 1. Create a phrase
        $phrase = Phrase::factory()->create([
            'key' => 'integration.test',
            'group' => 'testing',
            'description' => 'Integration test phrase'
        ]);

        // 2. Create translations
        $turkishTranslation = PhraseTranslation::factory()
            ->forPhrase($phrase)
            ->forLanguage($this->turkish)
            ->withTranslation('Entegrasyon testi')
            ->approved()
            ->create();

        $russianTranslation = PhraseTranslation::factory()
            ->forPhrase($phrase)
            ->forLanguage($this->russian)
            ->withTranslation('Интеграционный тест')
            ->approved()
            ->create();

        // 3. Test translation retrieval in Turkish
        app()->setLocale('tr');
        $result = $this->translationService->get('testing.integration.test');
        $this->assertEquals('Entegrasyon testi', $result);

        // 4. Test translation retrieval in Russian
        $this->translationService->setLocale('ru');
        $result = $this->translationService->get('testing.integration.test');
        $this->assertEquals('Интеграционный тест', $result);

        // 5. Test fallback to default language
        // Create a phrase with only Turkish translation
        $phraseOnlyTurkish = Phrase::factory()->create([
            'key' => 'turkish.only',
            'group' => 'testing'
        ]);

        PhraseTranslation::factory()
            ->forPhrase($phraseOnlyTurkish)
            ->forLanguage($this->turkish)
            ->withTranslation('Sadece Türkçe')
            ->create();

        // Try to get Russian translation, should fallback to Turkish
        $this->translationService->setLocale('ru');
        $result = $this->translationService->get('testing.turkish.only');
        $this->assertEquals('Sadece Türkçe', $result);
    }

    /** @test */
    public function cache_system_works_correctly()
    {
        // Clear any existing cache
        $this->cacheService->flush();

        // Create test phrase and translation
        $phrase = Phrase::factory()->create([
            'key' => 'cache.test',
            'group' => 'general'
        ]);

        $translation = PhraseTranslation::factory()
            ->forPhrase($phrase)
            ->forLanguage($this->turkish)
            ->withTranslation('Önbellek testi')
            ->create();

        // First call should miss cache and hit database
        $result1 = $this->translationService->get('general.cache.test');
        $this->assertEquals('Önbellek testi', $result1);

        // Second call should hit cache
        $result2 = $this->translationService->get('general.cache.test');
        $this->assertEquals('Önbellek testi', $result2);

        // Verify cache statistics
        $cacheReport = $this->performanceService->getCachePerformanceReport();
        $this->assertGreaterThan(0, $cacheReport['cache_hits']);
        $this->assertGreaterThan(0, $cacheReport['cache_misses']);
    }

    /** @test */
    public function bulk_import_works_correctly()
    {
        $translations = [
            'bulk.test.1' => 'Toplu test 1',
            'bulk.test.2' => 'Toplu test 2',
            'bulk.test.3' => 'Toplu test 3',
        ];

        $result = $this->translationService->bulkImportTranslations('tr', $translations, 'bulk');

        $this->assertEquals(3, $result['imported']);
        $this->assertEquals(0, $result['skipped']);
        $this->assertEmpty($result['errors']);

        // Verify phrases were created
        foreach ($translations as $key => $translation) {
            $this->assertDatabaseHas('phrases', [
                'key' => $key,
                'group' => 'bulk'
            ]);

            $phrase = Phrase::where('key', $key)->first();
            $this->assertDatabaseHas('phrase_translations', [
                'phrase_id' => $phrase->id,
                'language_id' => $this->turkish->id,
                'translation' => $translation
            ]);
        }
    }

    /** @test */
    public function translation_export_works_correctly()
    {
        // Create test phrases
        $phrases = [
            ['key' => 'export.test.1', 'translation' => 'Dışa aktarma testi 1'],
            ['key' => 'export.test.2', 'translation' => 'Dışa aktarma testi 2'],
        ];

        foreach ($phrases as $phraseData) {
            $phrase = Phrase::factory()->create([
                'key' => $phraseData['key'],
                'group' => 'export'
            ]);

            PhraseTranslation::factory()
                ->forPhrase($phrase)
                ->forLanguage($this->turkish)
                ->withTranslation($phraseData['translation'])
                ->create();
        }

        // Export translations
        $exported = $this->translationService->exportTranslations('tr', 'export');

        $this->assertArrayHasKey('export.test.1', $exported);
        $this->assertArrayHasKey('export.test.2', $exported);
        $this->assertEquals('Dışa aktarma testi 1', $exported['export.test.1']);
        $this->assertEquals('Dışa aktarma testi 2', $exported['export.test.2']);
    }

    /** @test */
    public function cache_warming_works_correctly()
    {
        // Clear cache
        $this->cacheService->flush();

        // Create test phrases
        $phrases = [];
        for ($i = 1; $i <= 5; $i++) {
            $phrase = Phrase::factory()->create([
                'key' => "warm.test.{$i}",
                'group' => 'warming'
            ]);

            PhraseTranslation::factory()
                ->forPhrase($phrase)
                ->forLanguage($this->turkish)
                ->withTranslation("Isınma testi {$i}")
                ->create();

            $phrases[] = $phrase;
        }

        // Warm up cache
        $warmedCount = $this->translationService->warmUpCache('tr', 'warming');
        $this->assertEquals(5, $warmedCount);

        // Verify translations are cached (should be fast retrieval)
        foreach ($phrases as $phrase) {
            $result = $this->translationService->get("warming.{$phrase->key}");
            $this->assertStringContains('Isınma testi', $result);
        }
    }

    /** @test */
    public function plural_translations_work_correctly()
    {
        $phrase = Phrase::factory()->create([
            'key' => 'items.count',
            'group' => 'general'
        ]);

        PhraseTranslation::factory()
            ->forPhrase($phrase)
            ->forLanguage($this->turkish)
            ->withTranslation(':count öğe')
            ->withPluralTranslation(':count öğeler')
            ->create();

        // Test singular
        $result = $this->translationService->getPlural('general.items.count', 1, ['count' => 1]);
        $this->assertEquals('1 öğe', $result);

        // Test plural
        $result = $this->translationService->getPlural('general.items.count', 5, ['count' => 5]);
        $this->assertEquals('5 öğeler', $result);
    }

    /** @test */
    public function parameter_substitution_works_correctly()
    {
        $phrase = Phrase::factory()->create([
            'key' => 'greeting.user',
            'group' => 'general'
        ]);

        PhraseTranslation::factory()
            ->forPhrase($phrase)
            ->forLanguage($this->turkish)
            ->withTranslation('Merhaba :name, hesabınızda :amount TL bulunmaktadır.')
            ->create();

        $result = $this->translationService->get('general.greeting.user', [
            'name' => 'Ahmet',
            'amount' => '1,500'
        ]);

        $this->assertEquals('Merhaba Ahmet, hesabınızda 1,500 TL bulunmaktadır.', $result);
    }

    /** @test */
    public function performance_monitoring_records_metrics()
    {
        // Clear existing metrics
        $this->performanceService->cleanupOldMetrics(0);

        $phrase = Phrase::factory()->create([
            'key' => 'performance.test',
            'group' => 'general'
        ]);

        PhraseTranslation::factory()
            ->forPhrase($phrase)
            ->forLanguage($this->turkish)
            ->withTranslation('Performans testi')
            ->create();

        // Make several translation requests
        for ($i = 0; $i < 5; $i++) {
            $this->translationService->get('general.performance.test');
        }

        // Check performance metrics
        $summary = $this->performanceService->getPerformanceSummary();
        
        $this->assertGreaterThan(0, $summary['translations']['total_lookups']);
        $this->assertArrayHasKey('system_health', $summary);
        $this->assertContains($summary['system_health'], ['excellent', 'good', 'fair', 'poor']);
    }

    /** @test */
    public function translation_statistics_are_accurate()
    {
        // Create phrases with different completion levels
        $phrases = [];
        
        // Phrase with both Turkish and Russian
        $phrase1 = Phrase::factory()->create(['key' => 'stats.complete', 'group' => 'stats']);
        PhraseTranslation::factory()->forPhrase($phrase1)->forLanguage($this->turkish)->create();
        PhraseTranslation::factory()->forPhrase($phrase1)->forLanguage($this->russian)->create();
        
        // Phrase with only Turkish
        $phrase2 = Phrase::factory()->create(['key' => 'stats.partial', 'group' => 'stats']);
        PhraseTranslation::factory()->forPhrase($phrase2)->forLanguage($this->turkish)->create();

        $stats = $this->translationService->getTranslationStats();
        
        $this->assertEquals(2, $stats['total_phrases']);
        $this->assertArrayHasKey('languages', $stats);
        $this->assertArrayHasKey('completion', $stats);
    }

    /** @test */
    public function error_handling_works_correctly()
    {
        // Test nonexistent key
        $result = $this->translationService->get('nonexistent.key');
        $this->assertEquals('nonexistent.key', $result);

        // Test with parameters on nonexistent key
        $result = $this->translationService->get('nonexistent.key', ['param' => 'value']);
        $this->assertEquals('nonexistent.key', $result);

        // Test invalid locale
        $this->translationService->setLocale('invalid');
        $phrase = Phrase::factory()->create(['key' => 'error.test', 'group' => 'general']);
        PhraseTranslation::factory()
            ->forPhrase($phrase)
            ->forLanguage($this->turkish)
            ->withTranslation('Hata testi')
            ->create();

        // Should fallback to default language
        $result = $this->translationService->get('general.error.test');
        $this->assertEquals('Hata testi', $result);
    }

    /** @test */
    public function language_management_works_correctly()
    {
        // Test getting available languages
        $languages = $this->translationService->getAvailableLanguages();
        $this->assertCount(2, $languages); // Turkish and Russian

        // Test getting default language
        $defaultLanguage = $this->translationService->getDefaultLanguage();
        $this->assertEquals('tr', $defaultLanguage->code);

        // Test language statistics
        $languageStats = $this->translationService->getLanguageStats();
        $this->assertNotEmpty($languageStats);
    }
}