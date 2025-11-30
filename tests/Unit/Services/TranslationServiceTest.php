<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\TranslationService;
use App\Services\CacheService;
use App\Services\PerformanceMonitoringService;
use App\Contracts\Repositories\TranslationRepositoryInterface;
use App\Models\Language;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TranslationService $translationService;
    protected $mockRepository;
    protected $mockCacheService;
    protected $mockPerformanceService;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock dependencies
        $this->mockRepository = Mockery::mock(TranslationRepositoryInterface::class);
        $this->mockCacheService = Mockery::mock(CacheService::class);
        $this->mockPerformanceService = Mockery::mock(PerformanceMonitoringService::class);

        // Create service instance with mocked dependencies
        $this->translationService = new TranslationService(
            $this->mockRepository,
            $this->mockCacheService,
            $this->mockPerformanceService
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_get_translation_from_cache()
    {
        // Arrange
        $key = 'welcome.message';
        $locale = 'tr';
        $translation = 'Hoş geldiniz';
        
        $mockTranslation = Mockery::mock(PhraseTranslation::class);
        $mockTranslation->translation = $translation;

        $this->mockCacheService->shouldReceive('has')->andReturn(true);
        $this->mockCacheService->shouldReceive('remember')->andReturn($mockTranslation);
        
        $this->mockPerformanceService->shouldReceive('recordTranslationLookup')->once();

        // Act
        $result = $this->translationService->get($key);

        // Assert
        $this->assertEquals($translation, $result);
    }

    /** @test */
    public function it_returns_key_when_translation_not_found()
    {
        // Arrange
        $key = 'nonexistent.key';
        
        $this->mockCacheService->shouldReceive('has')->andReturn(false);
        $this->mockCacheService->shouldReceive('remember')->andReturn(null);
        
        $this->mockPerformanceService->shouldReceive('recordTranslationLookup')->once();

        // Act
        $result = $this->translationService->get($key);

        // Assert
        $this->assertEquals($key, $result);
    }

    /** @test */
    public function it_falls_back_to_default_locale()
    {
        // Arrange
        $key = 'welcome.message';
        $locale = 'ru';
        $defaultTranslation = 'Welcome';
        
        $mockDefaultTranslation = Mockery::mock(PhraseTranslation::class);
        $mockDefaultTranslation->translation = $defaultTranslation;

        $this->mockCacheService->shouldReceive('has')->andReturn(false, true);
        $this->mockCacheService->shouldReceive('remember')
            ->andReturn(null, $mockDefaultTranslation);
        
        $this->mockPerformanceService->shouldReceive('recordTranslationLookup')->twice();

        // Set locale to non-default
        $this->translationService->setLocale($locale);

        // Act
        $result = $this->translationService->get($key);

        // Assert
        $this->assertEquals($defaultTranslation, $result);
    }

    /** @test */
    public function it_can_handle_plural_translations()
    {
        // Arrange
        $key = 'items.count';
        $count = 5;
        $pluralTranslation = ':count öğe';
        
        $mockTranslation = Mockery::mock(PhraseTranslation::class);
        $mockTranslation->translation = 'öğe';
        $mockTranslation->plural_translation = $pluralTranslation;

        $this->mockCacheService->shouldReceive('has')->andReturn(true);
        $this->mockCacheService->shouldReceive('remember')->andReturn($mockTranslation);

        // Act
        $result = $this->translationService->getPlural($key, $count, ['count' => $count]);

        // Assert
        $this->assertEquals('5 öğe', $result);
    }

    /** @test */
    public function it_can_process_translation_parameters()
    {
        // Arrange
        $key = 'greeting.user';
        $translation = 'Merhaba :name, hoş geldiniz!';
        $parameters = ['name' => 'Ahmet'];
        
        $mockTranslation = Mockery::mock(PhraseTranslation::class);
        $mockTranslation->translation = $translation;

        $this->mockCacheService->shouldReceive('has')->andReturn(true);
        $this->mockCacheService->shouldReceive('remember')->andReturn($mockTranslation);
        
        $this->mockPerformanceService->shouldReceive('recordTranslationLookup')->once();

        // Act
        $result = $this->translationService->get($key, $parameters);

        // Assert
        $this->assertEquals('Merhaba Ahmet, hoş geldiniz!', $result);
    }

    /** @test */
    public function it_can_get_available_languages()
    {
        // Arrange
        $languages = collect([
            Language::factory()->make(['code' => 'tr', 'name' => 'Türkçe']),
            Language::factory()->make(['code' => 'ru', 'name' => 'Русский'])
        ]);

        $this->mockCacheService->shouldReceive('has')->andReturn(false);
        $this->mockCacheService->shouldReceive('remember')->andReturn($languages);
        $this->mockRepository->shouldReceive('getActiveLanguages')->andReturn($languages);
        
        $this->mockPerformanceService->shouldReceive('recordCacheMiss')->once();

        // Act
        $result = $this->translationService->getAvailableLanguages();

        // Assert
        $this->assertCount(2, $result);
        $this->assertEquals('tr', $result->first()->code);
    }

    /** @test */
    public function it_can_create_phrase()
    {
        // Arrange
        $data = [
            'key' => 'new.phrase',
            'group' => 'general',
            'description' => 'Test phrase'
        ];
        
        $phrase = Phrase::factory()->make($data);
        
        $this->mockRepository->shouldReceive('createOrUpdatePhrase')
            ->with($data)
            ->andReturn($phrase);
            
        $this->mockCacheService->shouldReceive('forgetPattern')->andReturn(5);
        $this->mockPerformanceService->shouldReceive('recordCacheInvalidation')->once();

        // Act
        $result = $this->translationService->createPhrase($data);

        // Assert
        $this->assertEquals($data['key'], $result->key);
    }

    /** @test */
    public function it_can_create_translation()
    {
        // Arrange
        $phraseKey = 'test.phrase';
        $languageCode = 'tr';
        $data = [
            'translation' => 'Test çevirisi',
            'group' => 'general'
        ];
        
        $translation = PhraseTranslation::factory()->make($data);
        
        $this->mockRepository->shouldReceive('createOrUpdateTranslation')
            ->with($phraseKey, $languageCode, $data)
            ->andReturn($translation);
            
        $this->mockCacheService->shouldReceive('forget')->andReturn(true);
        $this->mockCacheService->shouldReceive('forgetPattern')->andReturn(3);
        $this->mockPerformanceService->shouldReceive('recordCacheInvalidation')->times(4);

        // Act
        $result = $this->translationService->createTranslation($phraseKey, $languageCode, $data);

        // Assert
        $this->assertEquals($data['translation'], $result->translation);
    }

    /** @test */
    public function it_can_bulk_import_translations()
    {
        // Arrange
        $languageCode = 'tr';
        $translations = [
            'key1' => 'Çeviri 1',
            'key2' => 'Çeviri 2'
        ];
        $group = 'general';
        
        $importResult = [
            'imported' => 2,
            'skipped' => 0,
            'errors' => []
        ];

        $this->mockRepository->shouldReceive('bulkImportTranslations')
            ->with($languageCode, $translations, $group)
            ->andReturn($importResult);
            
        $this->mockCacheService->shouldReceive('forgetPattern')
            ->andReturn(10, 5);
            
        $this->mockPerformanceService->shouldReceive('recordCacheInvalidation')->once();

        // Act
        $result = $this->translationService->bulkImportTranslations($languageCode, $translations, $group);

        // Assert
        $this->assertEquals(2, $result['imported']);
        $this->assertEquals(0, $result['skipped']);
    }

    /** @test */
    public function it_can_warm_up_cache()
    {
        // Arrange
        $languageCode = 'tr';
        $translations = collect([
            (object) [
                'phrase' => (object) ['key' => 'key1', 'group' => 'general'],
                'translation' => 'Çeviri 1'
            ],
            (object) [
                'phrase' => (object) ['key' => 'key2', 'group' => 'general'],
                'translation' => 'Çeviri 2'
            ]
        ]);

        $this->mockRepository->shouldReceive('getTranslationsByLanguage')
            ->with($languageCode, null)
            ->andReturn($translations);
            
        $this->mockCacheService->shouldReceive('put')->twice()->andReturn(true);

        // Act
        $result = $this->translationService->warmUpCache($languageCode);

        // Assert
        $this->assertEquals(2, $result);
    }

    /** @test */
    public function it_can_clear_language_cache()
    {
        // Arrange
        $languageCode = 'tr';
        
        $this->mockCacheService->shouldReceive('forgetPattern')
            ->times(3)
            ->andReturn(5, 3, 2);
            
        $this->mockPerformanceService->shouldReceive('recordCacheInvalidation')
            ->times(3);

        // Act
        $result = $this->translationService->clearLanguageCache($languageCode);

        // Assert
        $this->assertTrue($result);
    }

    /** @test */
    public function it_handles_exceptions_gracefully()
    {
        // Arrange
        $key = 'test.key';
        
        $this->mockCacheService->shouldReceive('has')
            ->andThrow(new \Exception('Cache error'));

        // Act
        $result = $this->translationService->get($key);

        // Assert
        $this->assertEquals($key, $result);
    }

    /** @test */
    public function it_records_performance_metrics()
    {
        // Arrange
        $key = 'test.key';
        
        $this->mockCacheService->shouldReceive('has')->andReturn(true);
        $this->mockCacheService->shouldReceive('remember')->andReturn(null);
        
        $this->mockPerformanceService->shouldReceive('recordTranslationLookup')
            ->once()
            ->with($key, 'tr', Mockery::type('float'), true);

        // Act
        $this->translationService->get($key);

        // Assert - Expectations verified by Mockery
        $this->assertTrue(true);
    }

    /** @test */
    public function it_can_set_and_get_locale()
    {
        // Act
        $this->translationService->setLocale('ru');

        // Assert
        $this->assertEquals('ru', $this->translationService->getLocale());
        $this->assertEquals('ru', app()->getLocale());
    }
}