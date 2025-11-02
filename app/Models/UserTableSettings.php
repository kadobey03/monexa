<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTableSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'table_name',
        'visible_columns',
        'column_widths',
        'column_order',
        'filters',
        'page_size',
        'sort_column',
        'sort_direction',
    ];

    protected $casts = [
        'visible_columns' => 'array',
        'column_widths' => 'array',
        'column_order' => 'array',
        'filters' => 'array',
        'page_size' => 'integer',
    ];

    /**
     * Get the admin that owns the table settings.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get default column configuration for leads table.
     */
    public static function getDefaultColumns(): array
    {
        return [
            'name' => [
                'label' => 'Ad Soyad',
                'visible' => true,
                'width' => 200,
                'sortable' => true,
                'filterable' => true,
                'order' => 1
            ],
            'email' => [
                'label' => 'E-posta',
                'visible' => true,
                'width' => 200,
                'sortable' => true,
                'filterable' => true,
                'order' => 2
            ],
            'phone' => [
                'label' => 'Telefon',
                'visible' => true,
                'width' => 150,
                'sortable' => false,
                'filterable' => false,
                'order' => 3
            ],
            'country' => [
                'label' => 'Ülke',
                'visible' => true,
                'width' => 120,
                'sortable' => true,
                'filterable' => true,
                'order' => 4
            ],
            'lead_status_id' => [
                'label' => 'Lead Durumu',
                'visible' => true,
                'width' => 120,
                'sortable' => true,
                'filterable' => true,
                'order' => 5
            ],
            'assign_to' => [
                'label' => 'Atanan Admin',
                'visible' => true,
                'width' => 150,
                'sortable' => true,
                'filterable' => true,
                'order' => 6
            ],
            'lead_score' => [
                'label' => 'Lead Skoru',
                'visible' => true,
                'width' => 80,
                'sortable' => true,
                'filterable' => false,
                'order' => 7
            ],
            'estimated_value' => [
                'label' => 'Tahmini Değer',
                'visible' => false,
                'width' => 120,
                'sortable' => true,
                'filterable' => false,
                'order' => 8
            ],
            'lead_source' => [
                'label' => 'Kaynak',
                'visible' => true,
                'width' => 120,
                'sortable' => true,
                'filterable' => true,
                'order' => 9
            ],
            'last_contact_date' => [
                'label' => 'Son İletişim',
                'visible' => false,
                'width' => 120,
                'sortable' => true,
                'filterable' => false,
                'order' => 10
            ],
            'next_follow_up_date' => [
                'label' => 'Sonraki Takip',
                'visible' => false,
                'width' => 120,
                'sortable' => true,
                'filterable' => false,
                'order' => 11
            ],
            'created_at' => [
                'label' => 'Kayıt Tarihi',
                'visible' => true,
                'width' => 120,
                'sortable' => true,
                'filterable' => false,
                'order' => 12
            ]
        ];
    }

    /**
     * Get settings for a specific admin and table.
     */
    public static function getSettingsFor(Admin $admin, string $tableName = 'leads'): array
    {
        $settings = static::where('admin_id', $admin->id)
                         ->where('table_name', $tableName)
                         ->first();

        $defaultColumns = static::getDefaultColumns();

        if (!$settings) {
            return [
                'visible_columns' => $defaultColumns,
                'column_widths' => [],
                'column_order' => array_keys($defaultColumns),
                'filters' => [],
                'page_size' => 25,
                'sort_column' => 'created_at',
                'sort_direction' => 'desc',
            ];
        }

        return [
            'visible_columns' => $settings->visible_columns ?: $defaultColumns,
            'column_widths' => $settings->column_widths ?: [],
            'column_order' => $settings->column_order ?: array_keys($defaultColumns),
            'filters' => $settings->filters ?: [],
            'page_size' => $settings->page_size ?: 25,
            'sort_column' => $settings->sort_column ?: 'created_at',
            'sort_direction' => $settings->sort_direction ?: 'desc',
        ];
    }

    /**
     * Update or create settings for a specific admin and table.
     */
    public static function updateSettingsFor(Admin $admin, array $settings, string $tableName = 'leads'): bool
    {
        $tableSettings = static::updateOrCreate(
            [
                'admin_id' => $admin->id,
                'table_name' => $tableName
            ],
            [
                'visible_columns' => $settings['visible_columns'] ?? null,
                'column_widths' => $settings['column_widths'] ?? null,
                'column_order' => $settings['column_order'] ?? null,
                'filters' => $settings['filters'] ?? null,
                'page_size' => $settings['page_size'] ?? 25,
                'sort_column' => $settings['sort_column'] ?? 'created_at',
                'sort_direction' => $settings['sort_direction'] ?? 'desc',
            ]
        );

        return $tableSettings->wasRecentlyCreated || $tableSettings->wasChanged();
    }

    /**
     * Get visible columns only.
     */
    public function getVisibleColumns(): array
    {
        $columns = $this->visible_columns ?: static::getDefaultColumns();
        
        return array_filter($columns, function($column) {
            return $column['visible'] ?? false;
        });
    }

    /**
     * Get columns ordered by their order value.
     */
    public function getOrderedColumns(): array
    {
        $columns = $this->visible_columns ?: static::getDefaultColumns();
        $order = $this->column_order ?: array_keys($columns);

        $orderedColumns = [];
        foreach ($order as $columnKey) {
            if (isset($columns[$columnKey])) {
                $orderedColumns[$columnKey] = $columns[$columnKey];
            }
        }

        // Add any missing columns at the end
        foreach ($columns as $key => $column) {
            if (!isset($orderedColumns[$key])) {
                $orderedColumns[$key] = $column;
            }
        }

        return $orderedColumns;
    }

    /**
     * Reset settings to default.
     */
    public function resetToDefault(): bool
    {
        $defaultColumns = static::getDefaultColumns();
        
        return $this->update([
            'visible_columns' => $defaultColumns,
            'column_widths' => [],
            'column_order' => array_keys($defaultColumns),
            'filters' => [],
            'page_size' => 25,
            'sort_column' => 'created_at',
            'sort_direction' => 'desc',
        ]);
    }
}