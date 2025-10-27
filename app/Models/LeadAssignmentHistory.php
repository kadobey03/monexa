<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class LeadAssignmentHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'assigned_from_admin_id',
        'assigned_to_admin_id',
        'assigned_by_admin_id',
        'assignment_type',
        'assignment_method',
        'assignment_outcome',
        'assignment_started_at',
        'assignment_ended_at',
        'assignment_reason',
        'assignment_metadata',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'lead_tags_at_assignment' => 'array',
        'assignment_rules_applied' => 'array',
        'communication_summary' => 'array',
        'algorithm_factors' => 'array',
        'metadata' => 'array',
        'custom_fields' => 'array',
        'flags' => 'array',
        'lead_score_at_assignment' => 'decimal:2',
        'estimated_value_at_assignment' => 'decimal:2',
        'admin_performance_score' => 'decimal:2',
        'final_conversion_value' => 'decimal:2',
        'response_time_hours' => 'decimal:2',
        'engagement_score_start' => 'decimal:2',
        'engagement_score_end' => 'decimal:2',
        'assignment_confidence' => 'decimal:2',
        'admin_lead_count_before' => 'integer',
        'admin_lead_count_after' => 'integer',
        'days_assigned' => 'integer',
        'contacts_made' => 'integer',
        'follow_up_count' => 'integer',
        'bulk_assignment_batch_size' => 'integer',
        'bulk_assignment_sequence' => 'integer',
        'sla_met' => 'boolean',
        'was_automated' => 'boolean',
        'requires_manager_approval' => 'boolean',
        'is_compliant' => 'boolean',
        'assignment_started_at' => 'datetime',
        'assignment_ended_at' => 'datetime',
        'first_contact_at' => 'datetime',
        'last_contact_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * Assignment types.
     */
    public const TYPE_INITIAL = 'initial';
    public const TYPE_REASSIGNMENT = 'reassignment';
    public const TYPE_BULK_ASSIGNMENT = 'bulk_assignment';
    public const TYPE_AUTO_ASSIGNMENT = 'auto_assignment';

    /**
     * Assignment methods.
     */
    public const METHOD_MANUAL = 'manual';
    public const METHOD_ROUND_ROBIN = 'round_robin';
    public const METHOD_LOAD_BASED = 'load_based';
    public const METHOD_SKILL_BASED = 'skill_based';
    public const METHOD_GEOGRAPHIC = 'geographic';

    /**
     * Assignment priorities.
     */
    public const PRIORITY_LOW = 'low';
    public const PRIORITY_NORMAL = 'normal';
    public const PRIORITY_HIGH = 'high';
    public const PRIORITY_URGENT = 'urgent';

    /**
     * Assignment outcomes.
     */
    public const OUTCOME_CONVERTED = 'converted';
    public const OUTCOME_REASSIGNED = 'reassigned';
    public const OUTCOME_LOST = 'lost';
    public const OUTCOME_ACTIVE = 'active';

    /**
     * Get the lead (user) this assignment belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the admin who was previously assigned.
     */
    public function assignedFromAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_from_admin_id');
    }

    /**
     * Get the admin who is currently assigned.
     */
    public function assignedToAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_to_admin_id');
    }

    /**
     * Get the admin who performed the assignment.
     */
    public function assignedByAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_by_admin_id');
    }

    /**
     * Get the admin who approved the assignment.
     */
    public function approvedByAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by_admin_id');
    }

    /**
     * Get the admin group at the time of assignment.
     */
    public function adminGroup(): BelongsTo
    {
        return $this->belongsTo(AdminGroup::class, 'admin_group_id');
    }

    /**
     * Scope a query to filter by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to filter by assigned admin.
     */
    public function scopeByAssignedAdmin($query, $adminId)
    {
        return $query->where('assigned_to_admin_id', $adminId);
    }

    /**
     * Scope a query to filter by assignment type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('assignment_type', $type);
    }

    /**
     * Scope a query to filter by assignment method.
     */
    public function scopeByMethod($query, string $method)
    {
        return $query->where('assignment_method', $method);
    }

    /**
     * Scope a query to filter by outcome.
     */
    public function scopeByOutcome($query, string $outcome)
    {
        return $query->where('assignment_outcome', $outcome);
    }

    /**
     * Scope a query to filter by department.
     */
    public function scopeByDepartment($query, string $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, Carbon $startDate, Carbon $endDate)
    {
        return $query->whereBetween('assignment_started_at', [$startDate, $endDate]);
    }

    /**
     * Scope a query to get active assignments.
     */
    public function scopeActive($query)
    {
        return $query->where('assignment_outcome', self::OUTCOME_ACTIVE)
                    ->whereNull('assignment_ended_at');
    }

    /**
     * Scope a query to get completed assignments.
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('assignment_ended_at')
                    ->whereIn('assignment_outcome', [self::OUTCOME_CONVERTED, self::OUTCOME_LOST, self::OUTCOME_REASSIGNED]);
    }

    /**
     * Scope a query to get conversions.
     */
    public function scopeConversions($query)
    {
        return $query->where('assignment_outcome', self::OUTCOME_CONVERTED);
    }

    /**
     * Scope a query to get automated assignments.
     */
    public function scopeAutomated($query)
    {
        return $query->where('was_automated', true);
    }

    /**
     * Scope a query to get bulk assignments.
     */
    public function scopeBulkAssignments($query)
    {
        return $query->where('assignment_type', self::TYPE_BULK_ASSIGNMENT);
    }

    /**
     * Scope a query to get assignments requiring approval.
     */
    public function scopeRequiringApproval($query)
    {
        return $query->where('requires_manager_approval', true)
                    ->whereNull('approved_at');
    }

    /**
     * Create an assignment history record.
     */
    public static function createAssignment(array $data): self
    {
        // Set default values
        $data = array_merge([
            'assignment_started_at' => now(),
            'assignment_type' => self::TYPE_INITIAL,
            'assignment_method' => self::METHOD_MANUAL,
            'assignment_outcome' => self::OUTCOME_ACTIVE,
        ], $data);

        // Remove priority field if not exists in database
        if (array_key_exists('priority', $data)) {
            unset($data['priority']);
        }

        return static::create($data);
    }

    /**
     * End the assignment with outcome.
     */
    public function endAssignment(string $outcome, array $data = []): bool
    {
        $this->assignment_ended_at = now();
        $this->assignment_outcome = $outcome;
        $this->days_assigned = $this->assignment_started_at->diffInDays(now());

        if (isset($data['final_conversion_value'])) {
            $this->final_conversion_value = $data['final_conversion_value'];
        }

        foreach ($data as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->$key = $value;
            }
        }

        return $this->save();
    }

    /**
     * Calculate assignment duration in days.
     */
    public function getAssignmentDuration(): int
    {
        $endDate = $this->assignment_ended_at ?? now();
        return $this->assignment_started_at->diffInDays($endDate);
    }

    /**
     * Calculate response time in hours.
     */
    public function calculateResponseTime(): ?float
    {
        if (!$this->first_contact_at) {
            return null;
        }

        return $this->assignment_started_at->diffInHours($this->first_contact_at, true);
    }

    /**
     * Check if assignment is still active.
     */
    public function isActive(): bool
    {
        return $this->assignment_outcome === self::OUTCOME_ACTIVE && 
               is_null($this->assignment_ended_at);
    }

    /**
     * Check if assignment resulted in conversion.
     */
    public function wasConverted(): bool
    {
        return $this->assignment_outcome === self::OUTCOME_CONVERTED;
    }

    /**
     * Check if SLA was met.
     */
    public function metSLA(): bool
    {
        return $this->sla_met === true;
    }

    /**
     * Get performance score for this assignment.
     */
    public function getPerformanceScore(): array
    {
        $score = [
            'response_time_score' => 0,
            'engagement_score' => 0,
            'conversion_score' => 0,
            'overall_score' => 0,
        ];

        // Response time score (0-25 points)
        if ($this->response_time_hours !== null) {
            if ($this->response_time_hours <= 1) {
                $score['response_time_score'] = 25;
            } elseif ($this->response_time_hours <= 4) {
                $score['response_time_score'] = 20;
            } elseif ($this->response_time_hours <= 24) {
                $score['response_time_score'] = 15;
            } else {
                $score['response_time_score'] = 10;
            }
        }

        // Engagement score (0-25 points)
        if ($this->engagement_score_end !== null) {
            $score['engagement_score'] = min(25, ($this->engagement_score_end / 100) * 25);
        }

        // Conversion score (0-50 points)
        if ($this->wasConverted()) {
            $score['conversion_score'] = 50;
        } elseif ($this->assignment_outcome === self::OUTCOME_ACTIVE) {
            $score['conversion_score'] = 25; // Still has potential
        }

        $score['overall_score'] = array_sum($score);

        return $score;
    }

    /**
     * Get assignment statistics for an admin.
     */
    public static function getAdminStats($adminId, Carbon $startDate = null, Carbon $endDate = null): array
    {
        $query = static::where('assigned_to_admin_id', $adminId);
        
        if ($startDate && $endDate) {
            $query->whereBetween('assignment_started_at', [$startDate, $endDate]);
        }

        $assignments = $query->get();
        
        return [
            'total_assignments' => $assignments->count(),
            'active_assignments' => $assignments->where('assignment_outcome', self::OUTCOME_ACTIVE)->count(),
            'conversions' => $assignments->where('assignment_outcome', self::OUTCOME_CONVERTED)->count(),
            'conversion_rate' => $assignments->count() > 0 ? 
                ($assignments->where('assignment_outcome', self::OUTCOME_CONVERTED)->count() / $assignments->count()) * 100 : 0,
            'total_conversion_value' => $assignments->sum('final_conversion_value'),
            'average_response_time' => $assignments->whereNotNull('response_time_hours')->avg('response_time_hours'),
            'average_assignment_duration' => $assignments->whereNotNull('days_assigned')->avg('days_assigned'),
            'sla_compliance' => $assignments->whereNotNull('sla_met')->where('sla_met', true)->count(),
        ];
    }

    /**
     * Get bulk assignment details.
     */
    public function getBulkAssignmentDetails(): array
    {
        if (!$this->bulk_assignment_id) {
            return [];
        }

        $bulkAssignments = static::where('bulk_assignment_id', $this->bulk_assignment_id)->get();
        
        return [
            'total_leads' => $bulkAssignments->count(),
            'batch_size' => $this->bulk_assignment_batch_size,
            'current_sequence' => $this->bulk_assignment_sequence,
            'admins_involved' => $bulkAssignments->pluck('assigned_to_admin_id')->unique()->count(),
            'completion_rate' => $bulkAssignments->whereNotNull('assignment_ended_at')->count() / $bulkAssignments->count() * 100,
        ];
    }

    /**
     * Add communication summary entry.
     */
    public function addCommunication(string $type, string $summary, array $details = []): bool
    {
        $communications = $this->communication_summary ?? [];
        
        $communications[] = [
            'type' => $type,
            'summary' => $summary,
            'details' => $details,
            'timestamp' => now()->toISOString(),
        ];

        $this->communication_summary = $communications;
        $this->contacts_made = count($communications);
        $this->last_contact_at = now();

        if (!$this->first_contact_at) {
            $this->first_contact_at = now();
            $this->response_time_hours = $this->calculateResponseTime();
        }

        return $this->save();
    }

    /**
     * Get priority display name.
     */
    public function getPriorityDisplayName(): string
    {
        return match($this->priority) {
            self::PRIORITY_LOW => 'Low',
            self::PRIORITY_HIGH => 'High',
            self::PRIORITY_URGENT => 'Urgent',
            default => 'Normal',
        };
    }

    /**
     * Get outcome display name.
     */
    public function getOutcomeDisplayName(): string
    {
        return match($this->assignment_outcome) {
            self::OUTCOME_CONVERTED => 'Converted',
            self::OUTCOME_REASSIGNED => 'Reassigned',
            self::OUTCOME_LOST => 'Lost',
            default => 'Active',
        };
    }

    /**
     * Get method display name.
     */
    public function getMethodDisplayName(): string
    {
        return match($this->assignment_method) {
            self::METHOD_ROUND_ROBIN => 'Round Robin',
            self::METHOD_LOAD_BASED => 'Load Based',
            self::METHOD_SKILL_BASED => 'Skill Based',
            self::METHOD_GEOGRAPHIC => 'Geographic',
            default => 'Manual',
        };
    }

    /**
     * Convert the model to its string representation.
     */
    public function __toString(): string
    {
        return "Assignment #{$this->id} - User #{$this->user_id} to Admin #{$this->assigned_to_admin_id}";
    }
}