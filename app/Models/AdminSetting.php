<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class AdminSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'category',
        'type',
        'value',
        'default_value',
        'description',
        'display_name',
        'validation_rules',
        'options',
        'help_text',
        'is_required',
        'is_encrypted',
        'allowed_roles',
        'view_roles',
        'is_system',
        'requires_restart',
        'group_name',
        'sort_order',
        'is_visible',
        'input_type',
        'environment_specific',
        'affects_performance',
        'affects_security',
        'dependencies',
        'modified_by',
        'last_modified',
        'change_history',
        'change_reason',
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
        'validation_rules' => 'array',
        'options' => 'array',
        'allowed_roles' => 'array',
        'view_roles' => 'array',
        'environment_specific' => 'array',
        'dependencies' => 'array',
        'change_history' => 'array',
        'is_required' => 'boolean',
        'is_encrypted' => 'boolean',
        'is_system' => 'boolean',
        'requires_restart' => 'boolean',
        'is_visible' => 'boolean',
        'affects_performance' => 'boolean',
        'affects_security' => 'boolean',
        'sort_order' => 'integer',
        'last_modified' => 'datetime',
    ];

    /**
     * Setting types.
     */
    public const TYPE_STRING = 'string';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_JSON = 'json';
    public const TYPE_ARRAY = 'array';
    public const TYPE_FLOAT = 'float';
    public const TYPE_TEXT = 'text';

    /**
     * Input types for UI.
     */
    public const INPUT_TEXT = 'text';
    public const INPUT_SELECT = 'select';
    public const INPUT_CHECKBOX = 'checkbox';
    public const INPUT_TEXTAREA = 'textarea';
    public const INPUT_NUMBER = 'number';
    public const INPUT_EMAIL = 'email';
    public const INPUT_PASSWORD = 'password';
    public const INPUT_FILE = 'file';

    /**
     * Setting categories.
     */
    public const CATEGORIES = [
        'general' => 'General Settings',
        'lead_assignment' => 'Lead Assignment',
        'notifications' => 'Notifications',
        'security' => 'Security',
        'performance' => 'Performance',
        'reporting' => 'Reporting',
        'system' => 'System',
        'ui' => 'User Interface',
        'integration' => 'Integrations',
        'email' => 'Email Settings',
    ];

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::updated(function ($setting) {
            // Clear cache when setting is updated
            Cache::forget("admin_setting_{$setting->key}");
            Cache::forget('admin_settings_all');
            
            // Log the change
            if ($setting->isDirty('value')) {
                $setting->logChange();
            }
        });

        static::created(function ($setting) {
            Cache::forget('admin_settings_all');
        });

        static::deleted(function ($setting) {
            Cache::forget("admin_setting_{$setting->key}");
            Cache::forget('admin_settings_all');
        });
    }

    /**
     * Get the admin who last modified this setting.
     */
    public function modifiedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'modified_by');
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to get visible settings.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope a query to get system settings.
     */
    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }

    /**
     * Scope a query to get non-system settings.
     */
    public function scopeNonSystem($query)
    {
        return $query->where('is_system', false);
    }

    /**
     * Scope a query to order by group and sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('group_name')->orderBy('sort_order')->orderBy('display_name');
    }

    /**
     * Scope a query to filter by group.
     */
    public function scopeByGroup($query, string $group)
    {
        return $query->where('group_name', $group);
    }

    /**
     * Get the typed value of the setting.
     */
    public function getTypedValue()
    {
        if ($this->is_encrypted && $this->value) {
            $decryptedValue = Crypt::decryptString($this->value);
        } else {
            $decryptedValue = $this->value;
        }

        return $this->castValue($decryptedValue, $this->type);
    }

    /**
     * Set the value with proper typing and encryption.
     */
    public function setTypedValue($value, Admin $modifiedBy = null): bool
    {
        // Validate the value
        if (!$this->validateValue($value)) {
            return false;
        }

        // Convert to string for storage
        $stringValue = $this->valueToString($value);

        // Encrypt if needed
        if ($this->is_encrypted) {
            $stringValue = Crypt::encryptString($stringValue);
        }

        // Update the setting
        $this->value = $stringValue;
        $this->last_modified = now();
        
        if ($modifiedBy) {
            $this->modified_by = $modifiedBy->id;
        }

        return $this->save();
    }

    /**
     * Cast value to appropriate type.
     */
    protected function castValue($value, string $type)
    {
        if ($value === null) {
            return null;
        }

        switch ($type) {
            case self::TYPE_BOOLEAN:
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
                
            case self::TYPE_INTEGER:
                return (int) $value;
                
            case self::TYPE_FLOAT:
                return (float) $value;
                
            case self::TYPE_JSON:
            case self::TYPE_ARRAY:
                return json_decode($value, true);
                
            default:
                return $value;
        }
    }

    /**
     * Convert value to string for storage.
     */
    protected function valueToString($value): string
    {
        if (is_array($value) || is_object($value)) {
            return json_encode($value);
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return (string) $value;
    }

    /**
     * Validate the value according to rules.
     */
    protected function validateValue($value): bool
    {
        if ($this->is_required && ($value === null || $value === '')) {
            return false;
        }

        $rules = $this->validation_rules;
        if (!$rules) {
            return true;
        }

        // Basic validation for different types
        switch ($this->type) {
            case self::TYPE_INTEGER:
                if (!is_numeric($value)) {
                    return false;
                }
                break;
                
            case self::TYPE_BOOLEAN:
                if (!in_array($value, [true, false, 'true', 'false', 0, 1, '0', '1'])) {
                    return false;
                }
                break;
                
            case self::TYPE_JSON:
            case self::TYPE_ARRAY:
                if (is_string($value)) {
                    json_decode($value);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        return false;
                    }
                }
                break;
        }

        return true;
    }

    /**
     * Reset to default value.
     */
    public function resetToDefault(Admin $modifiedBy = null): bool
    {
        return $this->setTypedValue($this->default_value, $modifiedBy);
    }

    /**
     * Check if current value is different from default.
     */
    public function isModified(): bool
    {
        return $this->getTypedValue() !== $this->castValue($this->default_value, $this->type);
    }

    /**
     * Check if admin can view this setting.
     */
    public function canBeViewedBy(Admin $admin): bool
    {
        if (!$this->view_roles) {
            return true; // No restrictions
        }

        return $admin->role && in_array($admin->role->name, $this->view_roles);
    }

    /**
     * Check if admin can modify this setting.
     */
    public function canBeModifiedBy(Admin $admin): bool
    {
        if ($this->is_system && !$admin->role?->isSuperAdmin()) {
            return false;
        }

        if (!$this->allowed_roles) {
            return $admin->role?->isManagementRole() ?? false;
        }

        return $admin->role && in_array($admin->role->name, $this->allowed_roles);
    }

    /**
     * Get display name.
     */
    public function getDisplayName(): string
    {
        return $this->display_name ?: ucwords(str_replace('_', ' ', $this->key));
    }

    /**
     * Get category display name.
     */
    public function getCategoryDisplayName(): string
    {
        return static::CATEGORIES[$this->category] ?? ucwords(str_replace('_', ' ', $this->category));
    }

    /**
     * Get help text or generate one.
     */
    public function getHelpText(): ?string
    {
        return $this->help_text ?: $this->description;
    }

    /**
     * Log setting change.
     */
    protected function logChange(): void
    {
        if (!$this->isDirty('value')) {
            return;
        }

        $history = $this->change_history ?? [];
        $history[] = [
            'old_value' => $this->getOriginal('value'),
            'new_value' => $this->value,
            'changed_by' => $this->modified_by,
            'changed_at' => now()->toISOString(),
            'reason' => $this->change_reason,
        ];

        // Keep only last 10 changes
        if (count($history) > 10) {
            $history = array_slice($history, -10);
        }

        $this->change_history = $history;

        // Also log in audit log if it exists
        if (class_exists(AdminAuditLog::class) && $this->modifiedBy) {
            AdminAuditLog::logAction([
                'admin_id' => $this->modified_by,
                'action' => 'update_setting',
                'entity_type' => 'AdminSetting',
                'entity_id' => $this->id,
                'entity_name' => $this->key,
                'category' => 'system_configuration',
                'description' => "Updated setting: {$this->key}",
                'old_values' => ['value' => $this->getOriginal('value')],
                'new_values' => ['value' => $this->value],
                'is_sensitive' => $this->affects_security || $this->is_encrypted,
            ]);
        }
    }

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("admin_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }

            return $setting->getTypedValue() ?? $default;
        });
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, $value, Admin $modifiedBy = null, string $reason = null): bool
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return false;
        }

        if ($reason) {
            $setting->change_reason = $reason;
        }

        return $setting->setTypedValue($value, $modifiedBy);
    }

    /**
     * Get all settings grouped by category.
     */
    public static function getAllGrouped(): array
    {
        return Cache::remember('admin_settings_all', 1800, function () {
            return static::visible()
                        ->ordered()
                        ->get()
                        ->groupBy('category')
                        ->map(function ($settings, $category) {
                            return [
                                'category' => $category,
                                'display_name' => static::CATEGORIES[$category] ?? ucwords(str_replace('_', ' ', $category)),
                                'groups' => $settings->groupBy('group_name'),
                            ];
                        });
        });
    }

    /**
     * Get settings that require restart.
     */
    public static function getRequiringRestart(): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('requires_restart', true)->get();
    }

    /**
     * Check if any settings require restart after changes.
     */
    public static function hasChangesRequiringRestart(): bool
    {
        return static::where('requires_restart', true)
                    ->whereColumn('value', '!=', 'default_value')
                    ->exists();
    }

    /**
     * Convert the model to its string representation.
     */
    public function __toString(): string
    {
        return $this->getDisplayName();
    }
}