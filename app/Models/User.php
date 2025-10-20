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
        'name', 'l_name', 'email', 'phone', 'country', 'password', 'ref_by', 'status', 'taxtype ','taxamount ', 'currency', 'notify','username', 'email_verified_at', 'account_bal', 'demo_balance', 'demo_mode', 'roi', 'bonus', 'ref_bonus',
        'lead_status_id', 'lead_notes', 'last_contact_date', 'next_follow_up_date', 'lead_source', 'lead_tags', 'estimated_value', 'lead_score', 'preferred_contact_method', 'contact_history', 'assign_to'
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


    public function dp()
    {
        return $this->hasMany(Deposit::class, 'user');
    }

    public function wd()
    {
        return $this->hasMany(Withdrawal::class, 'user');
    }

    public function tuser()
    {
        return $this->belongsTo(Admin::class, 'assign_to');
    }

    public function dplan()
    {
        return $this->belongsTo(Plans::class, 'plan');
    }

    public function plans()
    {
        return $this->hasMany(User_plans::class, 'user', 'id');
    }

    public function uplans()
    {
        return $this->hasMany(Investment::class, 'user', 'id');
    }

    /**
     * Get the lead status for the user
     */
    public function leadStatus()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }

    /**
     * Get the admin assigned to this user
     */
    public function assignedAdmin()
    {
        return $this->belongsTo(Admin::class, 'assign_to');
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
    public static function leadsByStatus($statusId)
    {
        return self::where('lead_status_id', $statusId)
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
        
        return $this;
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

    public static function search($search): \Illuminate\Database\Eloquent\Builder
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')
            ->orWhere('username', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
    }
}
