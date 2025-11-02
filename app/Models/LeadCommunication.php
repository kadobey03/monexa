<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadCommunication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'communication_type',
        'communication_subject',
        'communication_content',
        'status',
        'duration_seconds',
        'direction',
        'contact_method',
        'contact_value',
        'tracking_data',
        'response_received',
        'response_date',
        'follow_up_date',
        'follow_up_required',
    ];

    protected $casts = [
        'duration_seconds' => 'integer',
        'response_received' => 'boolean',
        'follow_up_required' => 'boolean',
        'response_date' => 'datetime',
        'follow_up_date' => 'datetime',
        'tracking_data' => 'array',
    ];

    /**
     * Get the user that owns the communication.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin that created the communication.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get formatted duration.
     */
    public function getFormattedDuration(): ?string
    {
        if (!$this->duration_seconds) {
            return null;
        }

        $minutes = floor($this->duration_seconds / 60);
        $seconds = $this->duration_seconds % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Get communication icon based on type.
     */
    public function getIcon(): string
    {
        return match($this->communication_type) {
            'call' => 'fas fa-phone',
            'email' => 'fas fa-envelope',
            'sms' => 'fas fa-sms',
            'whatsapp' => 'fab fa-whatsapp',
            'telegram' => 'fab fa-telegram',
            'meeting' => 'fas fa-handshake',
            default => 'fas fa-comment',
        };
    }

    /**
     * Get status color class.
     */
    public function getStatusColorClass(): string
    {
        return match($this->status) {
            'sent' => 'bg-blue-100 text-blue-800',
            'delivered' => 'bg-green-100 text-green-800',
            'read' => 'bg-purple-100 text-purple-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Check if follow-up is overdue.
     */
    public function isFollowUpOverdue(): bool
    {
        return $this->follow_up_required &&
               $this->follow_up_date &&
               $this->follow_up_date->isPast();
    }
}