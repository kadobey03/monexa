<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use App\Models\Settings;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * Send the email verification notification.
     *
     * @return void
     */

    public function sendEmailVerificationNotification()
    {
        $settings = Settings::where('id', 1)->first();

        if ($settings->enable_verification == 'true') {
            $this->notify(new VerifyEmail);
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'l_name', 'email', 'phone', 'country', 'password', 'ref_by', 'status', 'taxtype ','taxamount ', 'currency', 'notify', 'email_verified_at', 'account_bal', 'demo_balance', 'demo_mode', 'roi', 'bonus', 'ref_bonus',
        'lead_status', 'lead_notes', 'last_contact_date', 'next_follow_up_date', 'lead_source', 'lead_source_id', 'lead_tags', 'estimated_value', 'lead_score', 'preferred_contact_method', 'contact_history', 'assign_to',
        'company_name', 'organization'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_contact_date' => 'datetime',
        'next_follow_up_date' => 'datetime',
        'lead_tags' => 'array',
        'contact_history' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    /**
     * Optimized financial relationships
     */
    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class, 'user');
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class, 'user');
    }

    public function userPlans(): HasMany
    {
        return $this->hasMany(User_plans::class, 'user', 'id');
    }

    public function activePlans(): HasMany
    {
        return $this->userPlans()->where('status', 'active');
    }

    public function investments(): HasMany
    {
        return $this->hasMany(Investment::class, 'user', 'id');
    }

    /**
     * Lead management relationships
     */
    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assign_to');
    }

    public function leadAssignmentHistory(): HasMany
    {
        return $this->hasMany(LeadAssignmentHistory::class, 'user_id');
    }

    public function currentAssignment(): HasOne
    {
        return $this->hasOne(LeadAssignmentHistory::class, 'user_id')
                    ->where('assignment_outcome', LeadAssignmentHistory::OUTCOME_ACTIVE)
                    ->whereNull('assignment_ended_at')
                    ->latest('assignment_started_at');
    }

    public function latestAssignment(): HasOne
    {
        return $this->hasOne(LeadAssignmentHistory::class, 'user_id')
                    ->latest('assignment_started_at');
    }

    /**
     * Legacy relationships (kept for backward compatibility)
     */
    public function dp()
    {
        return $this->deposits();
    }

    public function wd()
    {
        return $this->withdrawals();
    }

    public function tuser()
    {
        return $this->assignedAdmin();
    }

    public function dplan()
    {
        return $this->belongsTo(Plans::class, 'plan');
    }

    public function plans()
    {
        return $this->userPlans();
    }

    public function uplans()
    {
        return $this->investments();
    }

    /**
     * Get the lead status for the user
     */
    public function leadStatus()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status', 'name');
    }

    /**
     * Get the lead source for the user
     */
    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class, 'lead_source_id');
    }

    /**
     * Get lead_status with default fallback to 'new'
     */
    public function getLeadStatusDisplayAttribute()
    {
        return $this->lead_status ?: 'new';
    }
    
    /**
     * Get lead status name for display
     */
    public function getLeadStatusNameAttribute()
    {
        // Türkçe karşılıkları
        $statusMap = [
            'new' => 'Yeni',
            'contacted' => 'İletişimde',
            'qualified' => 'Nitelikli',
            'converted' => 'Dönüştürülmüş',
            'lost' => 'Kayıp',
            'interested' => 'İlgileniyor',
            'negotiation' => 'Görüşme Aşamasında',
            'New' => 'Yeni',
            'Contacted' => 'İletişimde',
            'Qualified' => 'Nitelikli',
            'Converted' => 'Dönüştürülmüş',
            'Lost' => 'Kayıp',
            'Interested' => 'İlgileniyor',
            'Negotiation' => 'Görüşme Aşamasında'
        ];

        // Önce leadStatus relationship'ini dene
        if ($this->leadStatus) {
            $displayName = $this->leadStatus->display_name;
            $name = $this->leadStatus->name;
            
            // Eğer display_name boş değilse ve mapped değerden farklıysa onu kullan
            if ($displayName && $displayName !== $name && !isset($statusMap[$displayName])) {
                return $displayName;
            }
            
            // Değilse mapping kullan
            return $statusMap[$name] ?? ucfirst($name);
        }
        
        // Eğer leadStatus relationship null ise, raw lead_status değerini mapping'le döndür
        if ($this->lead_status) {
            return $statusMap[$this->lead_status] ?? ucfirst($this->lead_status);
        }
        
        return 'Atanmadı';
    }

    /**
     * Get lead_source with default fallback to 1
     */
    public function getLeadSourceIdAttribute($value)
    {
        return $value ?: 1;
    }

    /**
     * Get lead_source (legacy string field) with "Panda" fallback for null/1
     */
    public function getLeadSourceAttribute($value)
    {
        if (!$value || $value === '1' || $value === 1) {
            return 'Panda';
        }
        return $value;
    }


    /**
     * Get all notes for this lead.
     */
    public function leadNotes(): HasMany
    {
        return $this->hasMany(LeadNote::class);
    }

    /**
     * Get all communications for this lead.
     */
    public function leadCommunications(): HasMany
    {
        return $this->hasMany(LeadCommunication::class);
    }

    /**
     * Get lead score history.
     */
    public function leadScoreHistory(): HasMany
    {
        return $this->hasMany(LeadScoreHistory::class);
    }

    /**
     * Get quick actions performed on this lead.
     */
    public function leadQuickActions(): HasMany
    {
        return $this->hasMany(LeadQuickAction::class);
    }

    /**
     * Get pinned notes only.
     */
    public function pinnedNotes()
    {
        return $this->leadNotes()->where('is_pinned', true)->orderBy('created_at', 'desc');
    }

    /**
     * Get recent communications (last 30 days).
     */
    public function recentCommunications()
    {
        return $this->leadCommunications()
                    ->where('created_at', '>=', now()->subDays(30))
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Check if user is a lead (not a customer yet)
     */
    public function isLead()
    {
        return is_null($this->cstatus) || $this->cstatus !== 'Customer';
    }

    /**
     * Check if user has been assigned to an admin
     */
    public function isAssigned()
    {
        return !is_null($this->assign_to);
    }

    /**
     * Get leads that are not assigned
     */
    public static function unassignedLeads()
    {
        return self::whereNull('assign_to')
                   ->where(function($query) {
                       $query->whereNull('cstatus')
                             ->orWhere('cstatus', '!=', 'Customer');
                   });
    }

    /**
     * Get leads assigned to specific admin
     */
    public static function leadsAssignedTo($adminId)
    {
        return self::where('assign_to', $adminId)
                   ->where(function($query) {
                       $query->whereNull('cstatus')
                             ->orWhere('cstatus', '!=', 'Customer');
                   });
    }

    /**
     * Get leads by status
     */
    public static function leadsByStatus($statusName)
    {
        return self::where('lead_status', $statusName)
                   ->where(function($query) {
                       $query->whereNull('cstatus')
                             ->orWhere('cstatus', '!=', 'Customer');
                   });
    }

    /**
     * Add contact history entry
     */
    public function addContactHistory($type, $note, $adminId = null)
    {
        $history = $this->contact_history ?? [];
        $history[] = [
            'type' => $type, // call, email, meeting, note, etc.
            'note' => $note,
            'admin_id' => $adminId,
            'created_at' => now()->toISOString(),
        ];
        
        $this->contact_history = $history;
        $this->last_contact_date = now();
        $this->save();

        // Create communication summary in current assignment if exists
        $currentAssignment = $this->currentAssignment;
        if ($currentAssignment) {
            $currentAssignment->addCommunication($type, $note, [
                'admin_id' => $adminId,
                'user_id' => $this->id,
            ]);
        }
        
        return $this;
    }

    /**
     * Assign user to an admin with enhanced safety and validation.
     */
    public function assignToAdmin(Admin $admin, Admin $assignedBy = null, string $reason = null): bool
    {
        if (!$admin->isAvailableForAssignment()) {
            \Log::warning('Assignment failed: Admin not available', [
                'user_id' => $this->id,
                'admin_id' => $admin->id,
                'admin_status' => $admin->status,
                'admin_available' => $admin->is_available
            ]);
            return false;
        }

        $previousAdminId = $this->assign_to;
        
        // Skip if already assigned to same admin
        if ($previousAdminId == $admin->id) {
            return true;
        }

        try {
            \DB::beginTransaction();

            // End current assignment if exists
            $currentAssignment = $this->currentAssignment;
            if ($currentAssignment && $currentAssignment->assigned_to_admin_id !== $admin->id) {
                $currentAssignment->endAssignment(LeadAssignmentHistory::OUTCOME_REASSIGNED);
            }

            // Update admin counters with safe increment/decrement
            if ($previousAdminId && $previousAdminId != $admin->id) {
                Admin::where('id', $previousAdminId)
                     ->where('leads_assigned_count', '>', 0)
                     ->decrement('leads_assigned_count');
            }

            // Update user assignment
            $this->assign_to = $admin->id;
            $this->save();

            // Create new assignment history with comprehensive data
            LeadAssignmentHistory::createAssignment([
                'user_id' => $this->id,
                'assigned_from_admin_id' => $previousAdminId,
                'assigned_to_admin_id' => $admin->id,
                'assigned_by_admin_id' => $assignedBy?->id,
                'assignment_type' => $previousAdminId ? LeadAssignmentHistory::TYPE_REASSIGNMENT : LeadAssignmentHistory::TYPE_INITIAL,
                'assignment_method' => LeadAssignmentHistory::METHOD_MANUAL,
                'assignment_outcome' => LeadAssignmentHistory::OUTCOME_ACTIVE,
                'reason' => $reason,
                'priority' => $this->lead_priority ?? 'normal',
                'lead_status_at_assignment' => $this->lead_status ?? 'new',
                'lead_score_at_assignment' => $this->lead_score,
                'estimated_value_at_assignment' => $this->estimated_value,
                'lead_tags_at_assignment' => $this->lead_tags,
                'admin_lead_count_before' => $admin->leads_assigned_count,
                'admin_lead_count_after' => $admin->leads_assigned_count + 1,
                'admin_performance_score' => $admin->current_performance,
                'admin_availability_status' => $admin->is_available ? 'available' : 'busy',
                'lead_timezone' => $this->getTimezone(),
                'lead_region' => $this->getRegion(),
                'admin_timezone' => $admin->time_zone ?? 'UTC',
                'lead_source' => $this->lead_source,
                'department' => $admin->department,
                'admin_group_id' => $admin->admin_group_id,
                'assignment_started_at' => now(),
            ]);

            // Safely increment admin counter
            $admin->increment('leads_assigned_count');

            \DB::commit();

            \Log::info('User assigned to admin successfully', [
                'user_id' => $this->id,
                'user_name' => $this->name,
                'previous_admin_id' => $previousAdminId,
                'new_admin_id' => $admin->id,
                'assigned_by' => $assignedBy?->id,
                'reason' => $reason
            ]);

            return true;

        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error('Assignment to admin failed', [
                'user_id' => $this->id,
                'admin_id' => $admin->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }

    /**
     * Mark lead as converted.
     */
    public function markAsConverted(float $conversionValue = null, Admin $convertedBy = null): bool
    {
        $this->cstatus = 'Customer';
        $this->save();

        // End current assignment as converted
        $currentAssignment = $this->currentAssignment;
        if ($currentAssignment) {
            $currentAssignment->endAssignment(LeadAssignmentHistory::OUTCOME_CONVERTED, [
                'final_conversion_value' => $conversionValue,
            ]);

            // Update admin performance
            if ($currentAssignment->assignedToAdmin) {
                $currentAssignment->assignedToAdmin->updatePerformance(
                    $currentAssignment->assignedToAdmin->current_performance + ($conversionValue ?? 0),
                    true
                );
            }
        }

        return true;
    }

    /**
     * Get user's timezone.
     */
    public function getTimezone(): string
    {
        // Try to determine timezone from country or return UTC
        $timezoneMap = [
            'Turkey' => 'Europe/Istanbul',
            'Germany' => 'Europe/Berlin',
            'UK' => 'Europe/London',
            'USA' => 'America/New_York',
        ];

        return $timezoneMap[$this->country] ?? 'UTC';
    }

    /**
     * Get user's region.
     */
    public function getRegion(): string
    {
        $regionMap = [
            'Turkey' => 'europe',
            'Germany' => 'europe',
            'UK' => 'europe',
            'USA' => 'america',
            'Canada' => 'america',
        ];

        return $regionMap[$this->country] ?? 'other';
    }

    /**
     * Get assignment statistics for this user.
     */
    public function getAssignmentStats(): array
    {
        $assignments = $this->leadAssignmentHistory;
        
        return [
            'total_assignments' => $assignments->count(),
            'total_admins_assigned' => $assignments->pluck('assigned_to_admin_id')->unique()->count(),
            'average_assignment_duration' => $assignments->whereNotNull('days_assigned')->avg('days_assigned'),
            'total_contacts_received' => $assignments->sum('contacts_made'),
            'conversion_status' => $this->cstatus === 'Customer' ? 'converted' : 'pending',
            'current_admin' => $this->assignedAdmin?->getDisplayName(),
            'assignment_date' => $this->currentAssignment?->assignment_started_at,
        ];
    }

    /**
     * Get lead engagement level.
     */
    public function getEngagementLevel(): string
    {
        $score = $this->lead_score ?? 0;
        
        if ($score >= 80) {
            return 'high';
        } elseif ($score >= 50) {
            return 'medium';
        } elseif ($score >= 20) {
            return 'low';
        } else {
            return 'very_low';
        }
    }

    /**
     * Check if lead is hot (high priority).
     */
    public function isHotLead(): bool
    {
        return $this->lead_score >= 70 ||
               ($this->estimated_value ?? 0) >= 10000 ||
               ($this->last_contact_date && $this->last_contact_date->diffInDays() <= 1);
    }

    /**
     * Check if lead needs follow-up.
     */
    public function needsFollowUp(): bool
    {
        if (!$this->next_follow_up_date) {
            return false;
        }

        return $this->next_follow_up_date->isPast();
    }

    /**
     * Update lead score based on various factors.
     */
    public function updateLeadScore(): float
    {
        return $this->calculateLeadScore();
    }

    /**
     * Get lead status display name.
     */
    public function getLeadStatusName(): string
    {
        \Log::info('DEBUG - getLeadStatusName called', [
            'user_id' => $this->id,
            'lead_status_raw' => $this->lead_status,
            'leadStatus_relationship' => $this->leadStatus,
            'leadStatus_display_name' => $this->leadStatus?->display_name,
            'leadStatus_name' => $this->leadStatus?->name,
        ]);
        
        return $this->leadStatus?->display_name ?? $this->leadStatus?->name ?? 'Bilinmeyen';
    }

    /**
     * Get days since last contact.
     */
    public function getDaysSinceLastContact(): ?int
    {
        if (!$this->last_contact_date) {
            return null;
        }

        return $this->last_contact_date->diffInDays();
    }

    /**
     * Get days until next follow-up.
     */
    public function getDaysUntilFollowUp(): ?int
    {
        if (!$this->next_follow_up_date) {
            return null;
        }

        return now()->diffInDays($this->next_follow_up_date, false);
    }

    /**
     * Scope for high-value leads (enhanced with return type).
     */
    public function scopeHighValue(Builder $query, float $threshold = 5000): Builder
    {
        return $query->where('estimated_value', '>=', $threshold);
    }

    /**
     * Scope for hot leads.
     */
    public function scopeHotLeads($query)
    {
        return $query->where('lead_score', '>=', 70);
    }

    /**
     * Scope for leads needing follow-up.
     */
    public function scopeNeedsFollowUp($query)
    {
        return $query->where('next_follow_up_date', '<=', now());
    }

    /**
     * Scope for recent leads.
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for leads from specific source.
     */
    public function scopeFromSource($query, string $source)
    {
        return $query->where('lead_source', $source);
    }

    /**
     * Update lead score based on various factors
     */
    public function calculateLeadScore()
    {
        $score = 0;
        
        // Base score
        $score += 10;
        
        // Phone number provided
        if ($this->phone) $score += 15;
        
        // Country scoring (customize based on your target markets)
        if (in_array($this->country, ['Turkey', 'Germany', 'UK', 'USA'])) {
            $score += 20;
        }
        
        // Recent contact
        if ($this->last_contact_date && $this->last_contact_date->diffInDays() <= 7) {
            $score += 25;
        }
        
        // Contact history length
        $contactCount = count($this->contact_history ?? []);
        $score += min($contactCount * 5, 30);
        
        // Estimated value
        if ($this->estimated_value > 0) {
            $score += min($this->estimated_value / 1000 * 10, 50);
        }
        
        $this->lead_score = min($score, 100); // Cap at 100
        $this->save();
        
        return $this->lead_score;
    }


    /**
     * Enhanced search method with lead fields
     */
    public static function search($search): \Illuminate\Database\Eloquent\Builder
    {
        if (empty($search)) {
            return static::query();
        }

        return static::query()->where(function ($query) use ($search) {
            $query->where('id', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('company_name', 'like', '%' . $search . '%')
                  ->orWhere('lead_status', 'like', '%' . $search . '%')
                  ->orWhere('lead_source', 'like', '%' . $search . '%');
        });
    }
}
