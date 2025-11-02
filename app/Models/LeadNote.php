<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'note_category',
        'note_title',
        'note_content',
        'note_color',
        'is_pinned',
        'is_private',
        'reminder_date',
        'tags',
        'attachments',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_private' => 'boolean',
        'reminder_date' => 'datetime',
        'tags' => 'array',
        'attachments' => 'array',
    ];

    /**
     * Get the user that owns the note.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin that created the note.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Check if the note is overdue for reminder.
     */
    public function isOverdue(): bool
    {
        return $this->reminder_date && $this->reminder_date->isPast();
    }

    /**
     * Get formatted reminder date.
     */
    public function getFormattedReminderDate(): ?string
    {
        return $this->reminder_date?->format('d.m.Y H:i');
    }

    /**
     * Get relative reminder time.
     */
    public function getReminderRelative(): ?string
    {
        return $this->reminder_date?->diffForHumans();
    }
}