<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadQuickAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'action_type',
        'action_title',
        'action_description',
        'action_data',
        'old_values',
        'new_values',
        'status',
        'result_message',
        'result_data',
        'ip_address',
        'user_agent',
        'request_url',
        'risk_level',
        'requires_approval',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'action_data' => 'array',
        'old_values' => 'array',
        'new_values' => 'array',
        'result_data' => 'array',
        'requires_approval' => 'boolean',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the user that owns the action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin that performed the action.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get the admin that approved the action.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    /**
     * Get status color class.
     */
    public function getStatusColorClass(): string
    {
        return match($this->status) {
            'completed' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'failed' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get risk level color class.
     */
    public function getRiskLevelColorClass(): string
    {
        return match($this->risk_level) {
            'low' => 'bg-green-100 text-green-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'high' => 'bg-orange-100 text-orange-800',
            'critical' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Check if action is pending approval.
     */
    public function isPendingApproval(): bool
    {
        return $this->requires_approval && !$this->approved_at;
    }

    /**
     * Check if action can be executed by admin.
     */
    public function canExecute(Admin $admin): bool
    {
        // Check if admin has required permissions
        $permissions = [
            'block_user' => 'lead_block_user',
            'credit_debit' => 'lead_financial_manage',
            'admin_switch' => 'lead_admin_switch',
            'tax_calculation' => 'lead_financial_manage',
            'withdrawal_code' => 'lead_financial_manage',
            'set_limits' => 'lead_financial_manage',
        ];

        $requiredPermission = $permissions[$this->action_type] ?? null;

        if ($requiredPermission && !$admin->hasPermission($requiredPermission)) {
            return false;
        }

        // Check risk level permissions
        if (in_array($this->risk_level, ['high', 'critical'])) {
            return $admin->hasPermission('lead_high_risk_actions');
        }

        return true;
    }
}