<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{User, Admin, LeadNote};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AdminLeadNotesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private Admin $admin;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = Admin::factory()->create();
        $this->user = User::factory()->create();
        
        // Admin olarak giriş yap
        $this->actingAs($this->admin, 'admin');
    }

    /** @test */
    public function admin_can_create_lead_note_for_user(): void
    {
        // Arrange
        $noteData = [
            'note_title' => 'İlk Görüşme Notları',
            'note_content' => 'Kullanıcı yatırım yapmak istiyor, detaylı bilgi talep etti.',
            'note_category' => 'follow_up',
            'note_color' => 'blue',
            'is_pinned' => false,
            'reminder_date' => '2024-12-15 10:00:00'
        ];

        // Act
        $response = $this->post("/admin/dashboard/users/{$this->user->id}/notes", $noteData);

        // Assert
        $response->assertStatus(302); // Redirect after successful creation
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('lead_notes', [
            'user_id' => $this->user->id,
            'admin_id' => $this->admin->id,
            'note_title' => $noteData['note_title'],
            'note_content' => $noteData['note_content'],
            'note_category' => $noteData['note_category'],
            'note_color' => $noteData['note_color']
        ]);
    }

    /** @test */
    public function admin_can_view_lead_note(): void
    {
        // Arrange
        $note = LeadNote::factory()->create([
            'user_id' => $this->user->id,
            'admin_id' => $this->admin->id,
            'note_title' => 'Test Not Başlığı',
            'note_content' => 'Test not içeriği'
        ]);

        // Act
        $response = $this->get("/admin/dashboard/users/{$this->user->id}/notes/{$note->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'note' => [
                'id' => $note->id,
                'note_title' => $note->note_title,
                'note_content' => $note->note_content,
                'note_category' => $note->note_category,
                'note_color' => $note->note_color
            ]
        ]);
    }

    /** @test */
    public function admin_can_update_own_lead_note(): void
    {
        // Arrange
        $note = LeadNote::factory()->create([
            'user_id' => $this->user->id,
            'admin_id' => $this->admin->id,
            'note_title' => 'Eski Başlık'
        ]);

        $updateData = [
            'note_title' => 'Güncellenmiş Başlık',
            'note_content' => 'Güncellenmiş içerik',
            'note_category' => 'investment',
            'note_color' => 'green',
            'is_pinned' => true
        ];

        // Act
        $response = $this->put("/admin/dashboard/users/{$this->user->id}/notes/{$note->id}", $updateData);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('success');
        
        $note->refresh();
        $this->assertEquals($updateData['note_title'], $note->note_title);
        $this->assertEquals($updateData['note_content'], $note->note_content);
        $this->assertEquals($updateData['note_category'], $note->note_category);
        $this->assertTrue($note->is_pinned);
    }

    /** @test */
    public function admin_cannot_update_other_admins_lead_note(): void
    {
        // Arrange
        $otherAdmin = Admin::factory()->create();
        $note = LeadNote::factory()->create([
            'user_id' => $this->user->id,
            'admin_id' => $otherAdmin->id,
            'title' => 'Başka Admin Notu'
        ]);

        $updateData = [
            'title' => 'Güncellenmiş Başlık',
            'content' => 'Güncellenmiş içerik',
            'category' => 'investment',
            'color' => 'red'
        ];

        // Act
        $response = $this->put("/admin/dashboard/users/{$this->user->id}/notes/{$note->id}", $updateData);

        // Assert
        $response->assertStatus(403); // Forbidden
        
        $note->refresh();
        $this->assertNotEquals($updateData['title'], $note->title);
    }

    /** @test */
    public function admin_can_delete_own_lead_note(): void
    {
        // Arrange
        $note = LeadNote::factory()->create([
            'user_id' => $this->user->id,
            'admin_id' => $this->admin->id
        ]);

        // Act
        $response = $this->delete("/admin/dashboard/users/{$this->user->id}/notes/{$note->id}");

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('success');
        $this->assertModelMissing($note);
    }

    /** @test */
    public function admin_cannot_delete_other_admins_lead_note(): void
    {
        // Arrange
        $otherAdmin = Admin::factory()->create();
        $note = LeadNote::factory()->create([
            'user_id' => $this->user->id,
            'admin_id' => $otherAdmin->id
        ]);

        // Act
        $response = $this->delete("/admin/dashboard/users/{$this->user->id}/notes/{$note->id}");

        // Assert
        $response->assertStatus(403); // Forbidden
        $this->assertModelExists($note);
    }

    /** @test */
    public function admin_can_view_all_notes_for_user(): void
    {
        // Arrange
        $otherAdmin = Admin::factory()->create();
        
        $myNote = LeadNote::factory()->create([
            'user_id' => $this->user->id,
            'admin_id' => $this->admin->id,
            'title' => 'Benim Notum'
        ]);

        $otherNote = LeadNote::factory()->create([
            'user_id' => $this->user->id,
            'admin_id' => $otherAdmin->id,
            'title' => 'Başka Admin Notu'
        ]);

        // Act
        $response = $this->get("/admin/dashboard/user-details/{$this->user->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee($myNote->title);
        $response->assertSee($otherNote->title);
        $response->assertSee($this->admin->name);
        $response->assertSee($otherAdmin->name);
    }

    /** @test */
    public function create_lead_note_validates_required_fields(): void
    {
        // Act
        $response = $this->post("/admin/dashboard/users/{$this->user->id}/notes", []);

        // Assert
        $response->assertSessionHasErrors(['title', 'content']);
    }

    /** @test */
    public function create_lead_note_validates_title_length(): void
    {
        // Act - Başlık 255 karakterden fazla
        $response = $this->post("/admin/dashboard/users/{$this->user->id}/notes", [
            'title' => str_repeat('a', 256),
            'content' => 'Valid content'
        ]);

        // Assert
        $response->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function create_lead_note_validates_content_length(): void
    {
        // Act - İçerik 2000 karakterden fazla
        $response = $this->post("/admin/dashboard/users/{$this->user->id}/notes", [
            'title' => 'Valid title',
            'content' => str_repeat('a', 2001)
        ]);

        // Assert
        $response->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function create_lead_note_validates_category(): void
    {
        // Act - Geçersiz kategori
        $response = $this->post("/admin/dashboard/users/{$this->user->id}/notes", [
            'title' => 'Valid title',
            'content' => 'Valid content',
            'category' => 'invalid_category'
        ]);

        // Assert
        $response->assertSessionHasErrors(['category']);
    }

    /** @test */
    public function create_lead_note_validates_color(): void
    {
        // Act - Geçersiz renk
        $response = $this->post("/admin/dashboard/users/{$this->user->id}/notes", [
            'title' => 'Valid title',
            'content' => 'Valid content',
            'color' => 'invalid_color'
        ]);

        // Assert
        $response->assertSessionHasErrors(['color']);
    }

    /** @test */
    public function create_lead_note_validates_reminder_date_format(): void
    {
        // Act - Geçersiz tarih formatı
        $response = $this->post("/admin/dashboard/users/{$this->user->id}/notes", [
            'title' => 'Valid title',
            'content' => 'Valid content',
            'reminder_date' => 'invalid-date-format'
        ]);

        // Assert
        $response->assertSessionHasErrors(['reminder_date']);
    }

    /** @test */
    public function create_lead_note_validates_reminder_date_future(): void
    {
        // Act - Geçmiş tarih
        $response = $this->post("/admin/dashboard/users/{$this->user->id}/notes", [
            'title' => 'Valid title',
            'content' => 'Valid content',
            'reminder_date' => '2023-01-01 10:00:00'
        ]);

        // Assert
        $response->assertSessionHasErrors(['reminder_date']);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_lead_notes(): void
    {
        // Arrange - Çıkış yap
        auth('admin')->logout();

        // Act
        $response = $this->post("/admin/dashboard/users/{$this->user->id}/notes", [
            'title' => 'Test',
            'content' => 'Test content'
        ]);

        // Assert
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function regular_user_cannot_access_admin_lead_notes(): void
    {
        // Arrange - Normal kullanıcı olarak giriş yap
        $regularUser = User::factory()->create();
        auth('admin')->logout();
        $this->actingAs($regularUser);

        // Act
        $response = $this->post("/admin/dashboard/users/{$this->user->id}/notes", [
            'title' => 'Test',
            'content' => 'Test content'
        ]);

        // Assert
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function admin_can_pin_and_unpin_lead_note(): void
    {
        // Arrange
        $note = LeadNote::factory()->create([
            'user_id' => $this->user->id,
            'admin_id' => $this->admin->id,
            'pinned' => false
        ]);

        // Act - Pin the note
        $response = $this->put("/admin/dashboard/users/{$this->user->id}/notes/{$note->id}", [
            'title' => $note->title,
            'content' => $note->content,
            'category' => $note->category,
            'color' => $note->color,
            'pinned' => true
        ]);

        // Assert
        $response->assertStatus(302);
        $note->refresh();
        $this->assertTrue($note->pinned);

        // Act - Unpin the note
        $response = $this->put("/admin/dashboard/users/{$this->user->id}/notes/{$note->id}", [
            'title' => $note->title,
            'content' => $note->content,
            'category' => $note->category,
            'color' => $note->color,
            'pinned' => false
        ]);

        // Assert
        $response->assertStatus(302);
        $note->refresh();
        $this->assertFalse($note->pinned);
    }

    /** @test */
    public function notes_are_displayed_with_pinned_notes_first(): void
    {
        // Arrange
        $regularNote = LeadNote::factory()->create([
            'user_id' => $this->user->id,
            'admin_id' => $this->admin->id,
            'title' => 'Normal Not',
            'pinned' => false,
            'created_at' => now()->subDays(2)
        ]);

        $pinnedNote = LeadNote::factory()->create([
            'user_id' => $this->user->id,
            'admin_id' => $this->admin->id,
            'title' => 'Sabitlenmiş Not',
            'pinned' => true,
            'created_at' => now()->subDays(1)
        ]);

        // Act
        $response = $this->get("/admin/dashboard/user-details/{$this->user->id}");

        // Assert
        $response->assertStatus(200);
        
        // Sabitlenmiş not önce görünmeli
        $content = $response->getContent();
        $pinnedPosition = strpos($content, 'Sabitlenmiş Not');
        $regularPosition = strpos($content, 'Normal Not');
        
        $this->assertLessThan($regularPosition, $pinnedPosition);
    }

    /** @test */
    public function admin_can_search_notes_by_category(): void
    {
        // Arrange
        LeadNote::factory()->create([
            'user_id' => $this->user->id,
            'admin_id' => $this->admin->id,
            'title' => 'Takip Notu',
            'category' => 'follow_up'
        ]);

        LeadNote::factory()->create([
            'user_id' => $this->user->id,
            'admin_id' => $this->admin->id,
            'title' => 'Yatırım Notu',
            'category' => 'investment'
        ]);

        // Act
        $response = $this->get("/admin/dashboard/user-details/{$this->user->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Takip Notu');
        $response->assertSee('Yatırım Notu');
        $response->assertSee('follow_up');
        $response->assertSee('investment');
    }

    /** @test */
    public function lead_note_tracks_created_and_updated_timestamps(): void
    {
        // Arrange
        $noteData = [
            'title' => 'Zaman Testi Notu',
            'content' => 'Zaman damgası kontrolü için test notu'
        ];

        // Act - Create
        $this->post("/admin/dashboard/users/{$this->user->id}/notes", $noteData);
        
        $note = LeadNote::where('title', $noteData['title'])->first();
        $originalUpdatedAt = $note->updated_at;

        // Wait a moment and update
        sleep(1);
        $this->put("/admin/dashboard/users/{$this->user->id}/notes/{$note->id}", [
            'title' => 'Güncellenmiş Başlık',
            'content' => $noteData['content']
        ]);

        // Assert
        $note->refresh();
        $this->assertNotNull($note->created_at);
        $this->assertNotNull($note->updated_at);
        $this->assertGreaterThan($originalUpdatedAt, $note->updated_at);
    }
}