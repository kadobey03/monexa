<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'color',
        'description',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Get all users with this status
     */
    public function users()
    {
        return $this->hasMany(User::class, 'lead_status', 'name');
    }

    /**
     * Get active statuses only
     */
    public static function active()
    {
        return self::where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Get statuses ordered by sort_order
     */
    public static function ordered()
    {
        return self::orderBy('sort_order');
    }

    /**
     * Get status by name
     */
    public static function getByName($name)
    {
        return self::where('name', $name)->first();
    }

    /**
     * Get next status in sequence
     */
    public function getNextStatus()
    {
        return self::where('sort_order', '>', $this->sort_order)
                   ->where('is_active', true)
                   ->orderBy('sort_order')
                   ->first();
    }

    /**
     * Get previous status in sequence
     */
    public function getPreviousStatus()
    {
        return self::where('sort_order', '<', $this->sort_order)
                   ->where('is_active', true)
                   ->orderBy('sort_order', 'desc')
                   ->first();
    }

    /**
     * Check if this is a final status (converted or lost)
     */
    public function isFinalStatus()
    {
        return in_array($this->name, ['converted', 'lost']);
    }

    /**
     * Get count of users in this status
     */
    public function getUserCount()
    {
        return $this->users()->count();
    }

    /**
     * Get users in this status assigned to specific admin
     */
    public function getUsersAssignedTo($adminId)
    {
        return $this->users()->where('assign_to', $adminId);
    }
}