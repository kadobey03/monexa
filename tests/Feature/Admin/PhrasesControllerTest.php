<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Language;
use App\Models\Phrase;
use App\Models\PhraseTranslation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PhrasesControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected Admin $admin;
    protected Language $turkish;
    protected Language $russian;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = Admin::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password')
        ]);

        // Create languages
        $this->turkish = Language::factory()->create([
            'code' => 'tr',
            'name' => 'Türkçe',
            'is_active' => true,
            'is_default' => true,
            'sort_order' => 1
        ]);

        $this->russian = Language::factory()->create([
            'code' => 'ru',
            'name' => 'Русский',
            'is_active' => true,
            'is_default' => false,
            'sort_order' => 2
        ]);
    }

    /** @test */
    public function unauthenticated_admin_cannot_access_phrases_index()
    {
        $response = $this->get(route('admin.phrases.index'));

        $response->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function authenticated_admin_can_access_phrases_index()
    {
        $this->actingAs($this->admin, 'admin');

        $response = $this->get(route('admin.phrases.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.phrases.index');
        $response->assertViewHas(['languages', 'phrases', 'stats']);
    }

    /** @test */
    public function admin_can_view_phrases_with_filters()
    {
        $this->actingAs($this->admin, 'admin');

        // Create test phrases
        $phrase1 = Phrase::factory()->create([
            'key' => 'welcome.message',
            'group' => 'general',
            'description' => 'Welcome message'
        ]);

        $phrase2 = Phrase::factory()->create([
            'key' => 'auth.login',
            'group' => 'auth',
            'description' => 'Login related text'
        ]);

        // Create translations
        PhraseTranslation::factory()->create([
            'phrase_id' => $phrase1->id,
            'language_id' => $this->turkish->id,
            'translation' => 'Hoş geldiniz'
        ]);

        PhraseTranslation::factory()->create([
            'phrase_id' => $phrase2->id,
            'language_id' => $this->turkish->id,
            'translation' => 'Giriş'
        ]);

        // Test with group filter
        $response = $this->get(route('admin.phrases.index', ['group' => 'auth']));

        $response->assertStatus(200);
        $response->assertSeeText('auth.login');
        $response->assertDontSeeText('welcome.message');
    }

    /** @test */
    public function admin_can_search_phrases()
    {
        $this->actingAs($this->admin, 'admin');

        $phrase = Phrase::factory()->create([
            'key' => 'search.test',
            'group' => 'general',
            'description' => 'Test search functionality'
        ]);

        PhraseTranslation::factory()->create([
            'phrase_id' => $phrase->id,
            'language_id' => $this->turkish->id,
            'translation' => 'Arama testi'
        ]);

        $response = $this->get(route('admin.phrases.index', ['search' => 'arama']));

        $response->assertStatus(200);
        $response->assertSeeText('search.test');
    }

    /** @test */
    public function admin_can_create_new_phrase()
    {
        $this->actingAs($this->admin, 'admin');

        $phraseData = [
            'key' => 'new.phrase',
            'group' => 'test',
            'description' => 'New test phrase',
            'translations' => [
                'tr' => 'Yeni test ifadesi',
                'ru' => 'Новая тестовая фраза'
            ]
        ];

        $response = $this->post(route('admin.phrases.store'), $phraseData);

        $response->assertRedirect(route('admin.phrases.index'));
        $response->assertSessionHas('success');

        // Verify phrase was created
        $this->assertDatabaseHas('phrases', [
            'key' => 'new.phrase',
            'group' => 'test',
            'description' => 'New test phrase'
        ]);

        // Verify translations were created
        $phrase = Phrase::where('key', 'new.phrase')->first();
        $this->assertDatabaseHas('phrase_translations', [
            'phrase_id' => $phrase->id,
            'language_id' => $this->turkish->id,
            'translation' => 'Yeni test ifadesi'
        ]);

        $this->assertDatabaseHas('phrase_translations', [
            'phrase_id' => $phrase->id,
            'language_id' => $this->russian->id,
            'translation' => 'Новая тестовая фраза'
        ]);
    }

    /** @test */
    public function admin_cannot_create_duplicate_phrase_key()
    {
        $this->actingAs($this->admin, 'admin');

        // Create existing phrase
        Phrase::factory()->create([
            'key' => 'existing.phrase',
            'group' => 'general'
        ]);

        $phraseData = [
            'key' => 'existing.phrase',
            'group' => 'general',
            'description' => 'Duplicate phrase',
            'translations' => [
                'tr' => 'Mükerrer ifade'
            ]
        ];

        $response = $this->post(route('admin.phrases.store'), $phraseData);

        $response->assertSessionHasErrors(['key']);
    }

    /** @test */
    public function admin_can_update_phrase()
    {
        $this->actingAs($this->admin, 'admin');

        $phrase = Phrase::factory()->create([
            'key' => 'update.test',
            'group' => 'general',
            'description' => 'Original description'
        ]);

        $translation = PhraseTranslation::factory()->create([
            'phrase_id' => $phrase->id,
            'language_id' => $this->turkish->id,
            'translation' => 'Orijinal çeviri'
        ]);

        $updateData = [
            'key' => 'update.test',
            'group' => 'updated',
            'description' => 'Updated description',
            'translations' => [
                'tr' => 'Güncellenmiş çeviri',
                'ru' => 'Обновленный перевод'
            ]
        ];

        $response = $this->put(route('admin.phrases.update', $phrase), $updateData);

        $response->assertRedirect(route('admin.phrases.index'));
        $response->assertSessionHas('success');

        // Verify phrase was updated
        $phrase->refresh();
        $this->assertEquals('updated', $phrase->group);
        $this->assertEquals('Updated description', $phrase->description);

        // Verify translations were updated/created
        $this->assertDatabaseHas('phrase_translations', [
            'phrase_id' => $phrase->id,
            'language_id' => $this->turkish->id,
            'translation' => 'Güncellenmiş çeviri'
        ]);

        $this->assertDatabaseHas('phrase_translations', [
            'phrase_id' => $phrase->id,
            'language_id' => $this->russian->id,
            'translation' => 'Обновленный перевод'
        ]);
    }

    /** @test */
    public function admin_can_delete_phrase()
    {
        $this->actingAs($this->admin, 'admin');

        $phrase = Phrase::factory()->create([
            'key' => 'delete.test',
            'group' => 'general'
        ]);

        $translation = PhraseTranslation::factory()->create([
            'phrase_id' => $phrase->id,
            'language_id' => $this->turkish->id,
            'translation' => 'Silinecek çeviri'
        ]);

        $response = $this->delete(route('admin.phrases.destroy', $phrase));

        $response->assertRedirect(route('admin.phrases.index'));
        $response->assertSessionHas('success');

        // Verify phrase and its translations were deleted
        $this->assertDatabaseMissing('phrases', ['id' => $phrase->id]);
        $this->assertDatabaseMissing('phrase_translations', ['id' => $translation->id]);
    }

    /** @test */
    public function admin_can_bulk_delete_phrases()
    {
        $this->actingAs($this->admin, 'admin');

        $phrase1 = Phrase::factory()->create(['key' => 'bulk.delete.1']);
        $phrase2 = Phrase::factory()->create(['key' => 'bulk.delete.2']);
        $phrase3 = Phrase::factory()->create(['key' => 'keep.this']);

        $response = $this->post(route('admin.phrases.bulk-delete'), [
            'phrase_ids' => [$phrase1->id, $phrase2->id]
        ]);

        $response->assertRedirect(route('admin.phrases.index'));
        $response->assertSessionHas('success');

        // Verify selected phrases were deleted
        $this->assertDatabaseMissing('phrases', ['id' => $phrase1->id]);
        $this->assertDatabaseMissing('phrases', ['id' => $phrase2->id]);
        
        // Verify unselected phrase remains
        $this->assertDatabaseHas('phrases', ['id' => $phrase3->id]);
    }

    /** @test */
    public function admin_can_export_translations()
    {
        $this->actingAs($this->admin, 'admin');

        $phrase = Phrase::factory()->create([
            'key' => 'export.test',
            'group' => 'general'
        ]);

        PhraseTranslation::factory()->create([
            'phrase_id' => $phrase->id,
            'language_id' => $this->turkish->id,
            'translation' => 'Dışa aktarma testi'
        ]);

        $response = $this->get(route('admin.phrases.export', [
            'language' => 'tr',
            'format' => 'json'
        ]));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
        
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('export.test', $data);
        $this->assertEquals('Dışa aktarma testi', $data['export.test']);
    }

    /** @test */
    public function admin_can_import_translations()
    {
        $this->actingAs($this->admin, 'admin');

        $importData = [
            'language_code' => 'tr',
            'group' => 'imported',
            'translations' => [
                'imported.key1' => 'İçe aktarılan 1',
                'imported.key2' => 'İçe aktarılan 2'
            ]
        ];

        $response = $this->post(route('admin.phrases.import'), $importData);

        $response->assertRedirect(route('admin.phrases.index'));
        $response->assertSessionHas('success');

        // Verify phrases were created
        $this->assertDatabaseHas('phrases', [
            'key' => 'imported.key1',
            'group' => 'imported'
        ]);

        $this->assertDatabaseHas('phrases', [
            'key' => 'imported.key2',
            'group' => 'imported'
        ]);

        // Verify translations were created
        $phrase1 = Phrase::where('key', 'imported.key1')->first();
        $this->assertDatabaseHas('phrase_translations', [
            'phrase_id' => $phrase1->id,
            'language_id' => $this->turkish->id,
            'translation' => 'İçe aktarılan 1'
        ]);
    }

    /** @test */
    public function admin_can_clear_cache()
    {
        $this->actingAs($this->admin, 'admin');

        $response = $this->post(route('admin.phrases.clear-cache'));

        $response->assertRedirect(route('admin.phrases.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function admin_can_warm_cache()
    {
        $this->actingAs($this->admin, 'admin');

        // Create test data
        $phrase = Phrase::factory()->create(['key' => 'cache.test']);
        PhraseTranslation::factory()->create([
            'phrase_id' => $phrase->id,
            'language_id' => $this->turkish->id,
            'translation' => 'Önbellek testi'
        ]);

        $response = $this->post(route('admin.phrases.warm-cache'), [
            'language_code' => 'tr'
        ]);

        $response->assertRedirect(route('admin.phrases.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function admin_can_inline_update_translation()
    {
        $this->actingAs($this->admin, 'admin');

        $phrase = Phrase::factory()->create(['key' => 'inline.test']);
        $translation = PhraseTranslation::factory()->create([
            'phrase_id' => $phrase->id,
            'language_id' => $this->turkish->id,
            'translation' => 'Orijinal metin'
        ]);

        $response = $this->patch(route('admin.phrases.inline-update'), [
            'translation_id' => $translation->id,
            'translation' => 'Güncellenmiş metin'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Verify translation was updated
        $translation->refresh();
        $this->assertEquals('Güncellenmiş metin', $translation->translation);
    }

    /** @test */
    public function phrases_validation_works_correctly()
    {
        $this->actingAs($this->admin, 'admin');

        // Test empty key
        $response = $this->post(route('admin.phrases.store'), [
            'key' => '',
            'group' => 'test',
            'description' => 'Test phrase'
        ]);

        $response->assertSessionHasErrors(['key']);

        // Test invalid key format
        $response = $this->post(route('admin.phrases.store'), [
            'key' => 'invalid key with spaces',
            'group' => 'test',
            'description' => 'Test phrase'
        ]);

        $response->assertSessionHasErrors(['key']);

        // Test empty group
        $response = $this->post(route('admin.phrases.store'), [
            'key' => 'valid.key',
            'group' => '',
            'description' => 'Test phrase'
        ]);

        $response->assertSessionHasErrors(['group']);
    }

    /** @test */
    public function admin_can_view_translation_statistics()
    {
        $this->actingAs($this->admin, 'admin');

        // Create test data for statistics
        $phrase1 = Phrase::factory()->create(['key' => 'stats.test1']);
        $phrase2 = Phrase::factory()->create(['key' => 'stats.test2']);

        // Turkish translations only
        PhraseTranslation::factory()->create([
            'phrase_id' => $phrase1->id,
            'language_id' => $this->turkish->id,
            'translation' => 'Test 1'
        ]);

        // Both languages
        PhraseTranslation::factory()->create([
            'phrase_id' => $phrase2->id,
            'language_id' => $this->turkish->id,
            'translation' => 'Test 2 TR'
        ]);

        PhraseTranslation::factory()->create([
            'phrase_id' => $phrase2->id,
            'language_id' => $this->russian->id,
            'translation' => 'Test 2 RU'
        ]);

        $response = $this->get(route('admin.phrases.stats'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.phrases.stats');
        $response->assertViewHas(['languageStats', 'globalStats']);
    }
}