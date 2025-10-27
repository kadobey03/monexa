<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class LeadActivity extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lead_activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'admin_id',
        'activity_type',
        'title',
        'description',
        'metadata',
        'ip_address',
        'user_agent',
        'outcome',
        'next_action',
        'next_action_date',
        'is_important',
        'tags'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'next_action_date' => 'datetime',
        'is_important' => 'boolean',
        'tags' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Activity type constants
     */
    const TYPE_CALL = 'call';
    const TYPE_EMAIL = 'email';
    const TYPE_SMS = 'sms';
    const TYPE_MEETING = 'meeting';
    const TYPE_VISIT = 'visit';
    const TYPE_NOTE = 'note';
    const TYPE_STATUS_CHANGE = 'status_change';
    const TYPE_ASSIGNMENT = 'assignment';
    const TYPE_LOGIN = 'login';
    const TYPE_REGISTRATION = 'registration';
    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPE_TRADE = 'trade';
    const TYPE_DOCUMENT = 'document';
    const TYPE_VERIFICATION = 'verification';
    const TYPE_COMPLAINT = 'complaint';
    const TYPE_FOLLOW_UP = 'follow_up';
    const TYPE_CONVERSION = 'conversion';
    const TYPE_SYSTEM = 'system';

    /**
     * Get all available activity types.
     *
     * @return array
     */
    public static function getActivityTypes(): array
    {
        return [
            self::TYPE_CALL => 'Telefon Araması',
            self::TYPE_EMAIL => 'E-posta',
            self::TYPE_SMS => 'SMS',
            self::TYPE_MEETING => 'Toplantı',
            self::TYPE_VISIT => 'Ziyaret',
            self::TYPE_NOTE => 'Not',
            self::TYPE_STATUS_CHANGE => 'Durum Değişikliği',
            self::TYPE_ASSIGNMENT => 'Atama',
            self::TYPE_LOGIN => 'Giriş',
            self::TYPE_REGISTRATION => 'Kayıt',
            self::TYPE_DEPOSIT => 'Para Yatırma',
            self::TYPE_WITHDRAWAL => 'Para Çekme',
            self::TYPE_TRADE => 'İşlem',
            self::TYPE_DOCUMENT => 'Doküman',
            self::TYPE_VERIFICATION => 'Doğrulama',
            self::TYPE_COMPLAINT => 'Şikayet',
            self::TYPE_FOLLOW_UP => 'Takip',
            self::TYPE_CONVERSION => 'Dönüşüm',
            self::TYPE_SYSTEM => 'Sistem'
        ];
    }

    /**
     * Get the user (lead) associated with this activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who performed this activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the lead source through user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function leadSource()
    {
        return $this->hasOneThrough(LeadSource::class, User::class, 'id', 'id', 'user_id', 'lead_source_id');
    }

    /**
     * Scope to get activities by type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * Scope to get important activities.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    /**
     * Scope to get activities within date range.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateRange($query, Carbon $startDate, Carbon $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope to get recent activities.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }

    /**
     * Scope to get activities requiring follow-up.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRequiresFollowUp($query)
    {
        return $query->whereNotNull('next_action_date')->where('next_action_date', '<=', Carbon::now());
    }

    /**
     * Get the activity type display name.
     *
     * @return string
     */
    public function getActivityTypeNameAttribute(): string
    {
        $types = self::getActivityTypes();
        return $types[$this->activity_type] ?? $this->activity_type;
    }

    /**
     * Get time ago formatted string.
     *
     * @return string
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get formatted metadata for display.
     *
     * @return string
     */
    public function getFormattedMetadataAttribute(): string
    {
        if (!$this->metadata || !is_array($this->metadata)) {
            return '';
        }

        $formatted = [];
        foreach ($this->metadata as $key => $value) {
            $formatted[] = ucfirst(str_replace('_', ' ', $key)) . ': ' . $value;
        }

        return implode(', ', $formatted);
    }

    /**
     * Get the CSS class for activity type icon.
     *
     * @return string
     */
    public function getIconClassAttribute(): string
    {
        $iconMap = [
            self::TYPE_CALL => 'fas fa-phone text-blue-500',
            self::TYPE_EMAIL => 'fas fa-envelope text-green-500',
            self::TYPE_SMS => 'fas fa-sms text-yellow-500',
            self::TYPE_MEETING => 'fas fa-calendar text-purple-500',
            self::TYPE_VISIT => 'fas fa-map-marker-alt text-red-500',
            self::TYPE_NOTE => 'fas fa-sticky-note text-orange-500',
            self::TYPE_STATUS_CHANGE => 'fas fa-exchange-alt text-indigo-500',
            self::TYPE_ASSIGNMENT => 'fas fa-user-tag text-pink-500',
            self::TYPE_LOGIN => 'fas fa-sign-in-alt text-gray-500',
            self::TYPE_REGISTRATION => 'fas fa-user-plus text-green-600',
            self::TYPE_DEPOSIT => 'fas fa-plus-circle text-green-700',
            self::TYPE_WITHDRAWAL => 'fas fa-minus-circle text-red-600',
            self::TYPE_TRADE => 'fas fa-chart-line text-blue-600',
            self::TYPE_DOCUMENT => 'fas fa-file-alt text-gray-600',
            self::TYPE_VERIFICATION => 'fas fa-check-circle text-green-500',
            self::TYPE_COMPLAINT => 'fas fa-exclamation-triangle text-red-500',
            self::TYPE_FOLLOW_UP => 'fas fa-clock text-yellow-600',
            self::TYPE_CONVERSION => 'fas fa-trophy text-gold-500',
            self::TYPE_SYSTEM => 'fas fa-cog text-gray-400'
        ];

        return $iconMap[$this->activity_type] ?? 'fas fa-circle text-gray-400';
    }

    /**
     * Check if activity needs follow-up.
     *
     * @return bool
     */
    public function needsFollowUpAttribute(): bool
    {
        return $this->next_action_date && $this->next_action_date <= Carbon::now();
    }

    /**
     * Get formatted next action date.
     *
     * @return string|null
     */
    public function getFormattedNextActionDateAttribute(): ?string
    {
        return $this->next_action_date ? $this->next_action_date->format('d M Y H:i') : null;
    }

    /**
     * Create an activity log entry.
     *
     * @param array $data
     * @return static
     */
    public static function log(array $data): self
    {
        $data['ip_address'] = $data['ip_address'] ?? request()->ip();
        $data['user_agent'] = $data['user_agent'] ?? request()->userAgent();

        return self::create($data);
    }
}