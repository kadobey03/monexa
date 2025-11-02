<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class LeadTableService
{
    protected $authService;
    protected $cachePrefix = 'lead_table_';
    protected $cacheExpiry = 600; // 10 minutes

    /**
     * Available columns for the leads table.
     */
    protected $availableColumns = [
        'id' => [
            'key' => 'id',
            'label' => 'ID',
            'sortable' => true,
            'searchable' => false,
            'default_visible' => true,
            'default_order' => 1,
            'width' => 80,
            'type' => 'number',
            'pinnable' => true,
        ],
        'name' => [
            'key' => 'name',
            'label' => 'Name',
            'sortable' => true,
            'searchable' => true,
            'default_visible' => true,
            'default_order' => 2,
            'width' => 200,
            'type' => 'text',
            'pinnable' => true,
        ],
        'email' => [
            'key' => 'email',
            'label' => 'Email',
            'sortable' => true,
            'searchable' => true,
            'default_visible' => true,
            'default_order' => 3,
            'width' => 250,
            'type' => 'email',
            'pinnable' => true,
        ],
        'phone' => [
            'key' => 'phone',
            'label' => 'Phone',
            'sortable' => true,
            'searchable' => true,
            'default_visible' => true,
            'default_order' => 4,
            'width' => 180,
            'type' => 'phone',
            'pinnable' => true,
            'clickable' => true,
        ],
        'country' => [
            'key' => 'country',
            'label' => 'Country',
            'sortable' => true,
            'searchable' => true,
            'default_visible' => true,
            'default_order' => 5,
            'width' => 120,
            'type' => 'text',
            'pinnable' => false,
        ],
        'lead_status' => [
            'key' => 'lead_status',
            'label' => 'Status',
            'sortable' => true,
            'searchable' => false,
            'default_visible' => true,
            'default_order' => 6,
            'width' => 150,
            'type' => 'dropdown',
            'pinnable' => false,
            'editable' => true,
            'relationship' => 'leadStatus',
        ],
        'assigned_admin' => [
            'key' => 'assign_to',
            'label' => 'Assigned To',
            'sortable' => true,
            'searchable' => false,
            'default_visible' => true,
            'default_order' => 7,
            'width' => 180,
            'type' => 'dropdown',
            'pinnable' => false,
            'editable' => true,
            'relationship' => 'assignedAdmin',
        ],
        'lead_source' => [
            'key' => 'lead_source',
            'label' => 'Source',
            'sortable' => true,
            'searchable' => true,
            'default_visible' => true,
            'default_order' => 8,
            'width' => 120,
            'type' => 'text',
            'pinnable' => false,
        ],
        'lead_score' => [
            'key' => 'lead_score',
            'label' => 'Score',
            'sortable' => true,
            'searchable' => false,
            'default_visible' => true,
            'default_order' => 9,
            'width' => 100,
            'type' => 'score',
            'pinnable' => false,
        ],
        'lead_priority' => [
            'key' => 'lead_priority',
            'label' => 'Priority',
            'sortable' => true,
            'searchable' => false,
            'default_visible' => false,
            'default_order' => 10,
            'width' => 120,
            'type' => 'badge',
            'pinnable' => false,
        ],
        'created_at' => [
            'key' => 'created_at',
            'label' => 'Created',
            'sortable' => true,
            'searchable' => false,
            'default_visible' => true,
            'default_order' => 11,
            'width' => 150,
            'type' => 'datetime',
            'pinnable' => false,
        ],
        'last_contact_date' => [
            'key' => 'last_contact_date',
            'label' => 'Last Contact',
            'sortable' => true,
            'searchable' => false,
            'default_visible' => false,
            'default_order' => 12,
            'width' => 150,
            'type' => 'datetime',
            'pinnable' => false,
        ],
        'next_follow_up_date' => [
            'key' => 'next_follow_up_date',
            'label' => 'Next Follow Up',
            'sortable' => true,
            'searchable' => false,
            'default_visible' => false,
            'default_order' => 13,
            'width' => 150,
            'type' => 'datetime',
            'pinnable' => false,
        ],
        'lead_notes' => [
            'key' => 'lead_notes',
            'label' => 'Notes',
            'sortable' => false,
            'searchable' => true,
            'default_visible' => false,
            'default_order' => 14,
            'width' => 200,
            'type' => 'text',
            'pinnable' => false,
            'truncate' => 100,
        ],
        'actions' => [
            'key' => 'actions',
            'label' => 'Actions',
            'sortable' => false,
            'searchable' => false,
            'default_visible' => true,
            'default_order' => 15,
            'width' => 120,
            'type' => 'actions',
            'pinnable' => true,
            'fixed_right' => true,
        ],
    ];

    public function __construct(LeadAuthorizationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Get table configuration for admin.
     */
    public function getTableConfiguration(Admin $admin): array
    {
        $settings = $this->getUserTableSettings($admin);
        $availableColumns = $this->getAvailableColumns($admin);

        return [
            'columns' => $this->buildColumnsConfiguration($settings, $availableColumns),
            'settings' => $settings,
            'available_columns' => $availableColumns,
            'default_sort' => $settings->default_sort_column ?? 'created_at',
            'default_sort_direction' => $settings->default_sort_direction ?? 'desc',
            'per_page_options' => [10, 25, 50, 100, 200],
            'default_per_page' => $settings->default_per_page ?? 25,
        ];
    }

    /**
     * Get user's table settings.
     */
    public function getUserTableSettings(Admin $admin): object
    {
        // Temporary fallback without database dependency
        return (object) [
            'admin_id' => $admin->id,
            'table_name' => 'leads',
            'visible_columns' => $this->getDefaultVisibleColumns(),
            'column_order' => $this->getDefaultColumnOrder(),
            'column_widths' => $this->getDefaultColumnWidths(),
            'pinned_columns' => $this->getDefaultPinnedColumns(),
            'default_sort_column' => 'created_at',
            'default_sort_direction' => 'desc',
            'default_per_page' => 25,
        ];
    }

    /**
     * Update table settings for admin.
     */
    public function updateTableSettings(Admin $admin, array $settings): object
    {
        // Temporary fallback - just return updated settings object without persistence
        $currentSettings = $this->getUserTableSettings($admin);
        
        Log::info('Lead table settings updated (memory only)', [
            'admin_id' => $admin->id,
            'settings' => $settings,
        ]);

        return $currentSettings;
    }

    /**
     * Get available columns based on admin permissions.
     */
    protected function getAvailableColumns(Admin $admin): array
    {
        $columns = $this->availableColumns;

        // Restrict columns based on role if needed
        if (!$this->authService->canAssignLead($admin, new User())) {
            // If user can't assign leads, make assigned_admin column read-only
            if (isset($columns['assigned_admin'])) {
                $columns['assigned_admin']['editable'] = false;
            }
        }

        return $columns;
    }

    /**
     * Build columns configuration for frontend.
     */
    protected function buildColumnsConfiguration(object $settings, array $availableColumns): array
    {
        $visibleColumns = $settings->visible_columns ?? $this->getDefaultVisibleColumns();
        $columnOrder = $settings->column_order ?? $this->getDefaultColumnOrder();
        $columnWidths = $settings->column_widths ?? [];
        $pinnedColumns = $settings->pinned_columns ?? [];

        $columns = [];

        // Sort columns by order
        $orderedColumnKeys = [];
        foreach ($columnOrder as $key) {
            if (in_array($key, $visibleColumns) && isset($availableColumns[$key])) {
                $orderedColumnKeys[] = $key;
            }
        }

        // Add any missing visible columns at the end
        foreach ($visibleColumns as $key) {
            if (!in_array($key, $orderedColumnKeys) && isset($availableColumns[$key])) {
                $orderedColumnKeys[] = $key;
            }
        }

        foreach ($orderedColumnKeys as $key) {
            $column = $availableColumns[$key];
            $column['visible'] = true;
            $column['pinned'] = in_array($key, $pinnedColumns);
            
            if (isset($columnWidths[$key])) {
                $column['width'] = $columnWidths[$key];
            }

            $columns[] = $column;
        }

        return $columns;
    }

    /**
     * Get paginated leads data for table.
     */
    public function getLeadsData(Admin $admin, array $params = []): array
    {
        $query = $this->authService->getAuthorizedLeadsQuery($admin);
        $initialCount = $query->count();
        
        Log::info('🪲 TABLE QUERY DEBUG - Starting', [
            'admin_id' => $admin->id,
            'initial_authorized_count' => $initialCount,
            'params' => $params
        ]);
        
        // Apply filters
        if (!empty($params['filters'])) {
            $query = $this->authService->applyFilters($query, $params['filters']);
            $afterFiltersCount = $query->count();
            Log::info('🪲 TABLE QUERY DEBUG - After filters', [
                'count' => $afterFiltersCount,
                'filters' => $params['filters']
            ]);
        }

        // Apply search
        if (!empty($params['search'])) {
            $query = $this->applyGlobalSearch($query, $params['search']);
            $afterSearchCount = $query->count();
            Log::info('🪲 TABLE QUERY DEBUG - After search', [
                'count' => $afterSearchCount,
                'search' => $params['search']
            ]);
        }

        // Apply sorting
        $sortColumn = $params['sort_column'] ?? 'created_at';
        $sortDirection = $params['sort_direction'] ?? 'desc';
        $query = $this->applySorting($query, $sortColumn, $sortDirection);
        $afterSortCount = $query->count();
        Log::info('🪲 TABLE QUERY DEBUG - After sorting', [
            'count' => $afterSortCount,
            'sort_column' => $sortColumn,
            'sort_direction' => $sortDirection
        ]);

        // Get pagination parameters
        $perPage = $params['per_page'] ?? 25;
        $page = $params['page'] ?? 1;

        // Execute query with relationships
        $results = $query->with([
            'assignedAdmin:id,firstName,lastName',
            'leadStatus:id,name,display_name,color',
        ])->paginate($perPage, ['*'], 'page', $page);
        
        Log::info('🪲 TABLE QUERY DEBUG - Final results', [
            'total_leads' => $results->total(),
            'current_page_items' => $results->count(),
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => $results->lastPage()
        ]);

        return [
            'data' => $results->items(),
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'per_page' => $results->perPage(),
                'total' => $results->total(),
                'from' => $results->firstItem(),
                'to' => $results->lastItem(),
            ],
            'meta' => [
                'sort_column' => $sortColumn,
                'sort_direction' => $sortDirection,
                'search' => $params['search'] ?? null,
                'filters' => $params['filters'] ?? [],
            ],
        ];
    }

    /**
     * Apply global search to query.
     */
    protected function applyGlobalSearch(Builder $query, string $search): Builder
    {
        $searchableColumns = array_keys(array_filter($this->availableColumns, function($col) {
            return $col['searchable'] ?? false;
        }));

        return $query->where(function($q) use ($search, $searchableColumns) {
            foreach ($searchableColumns as $column) {
                $columnKey = $this->availableColumns[$column]['key'];
                $q->orWhere($columnKey, 'LIKE', "%{$search}%");
            }
        });
    }

    /**
     * Apply sorting to query.
     */
    protected function applySorting(Builder $query, string $column, string $direction): Builder
    {
        $sortableColumns = array_keys(array_filter($this->availableColumns, function($col) {
            return $col['sortable'] ?? false;
        }));

        if (!in_array($column, $sortableColumns)) {
            $column = 'created_at';
        }

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $columnKey = $this->availableColumns[$column]['key'];

        // Handle special sorting cases
        switch ($column) {
            case 'assigned_admin':
                return $query->leftJoin('admins as assigned_admin', 'users.assign_to', '=', 'assigned_admin.id')
                           ->orderBy('assigned_admin.firstName', $direction)
                           ->select('users.*');

            case 'lead_status':
                return $query->leftJoin('lead_statuses', 'users.lead_status', '=', 'lead_statuses.name')
                           ->orderBy('lead_statuses.name', $direction)
                           ->select('users.*');

            default:
                return $query->orderBy($columnKey, $direction);
        }
    }

    /**
     * Export leads data for current table view.
     */
    public function exportLeadsData(Admin $admin, array $params = []): array
    {
        $query = $this->authService->getAuthorizedLeadsQuery($admin);
        
        // Apply same filters as table view
        if (!empty($params['filters'])) {
            $query = $this->authService->applyFilters($query, $params['filters']);
        }

        if (!empty($params['search'])) {
            $query = $this->applyGlobalSearch($query, $params['search']);
        }

        // Apply sorting
        $sortColumn = $params['sort_column'] ?? 'created_at';
        $sortDirection = $params['sort_direction'] ?? 'desc';
        $query = $this->applySorting($query, $sortColumn, $sortDirection);

        // Get user's visible columns for export
        $settings = $this->getUserTableSettings($admin);
        $visibleColumns = $settings->visible_columns ?? $this->getDefaultVisibleColumns();
        
        // Remove action column from export
        $exportColumns = array_filter($visibleColumns, function($col) {
            return $col !== 'actions';
        });

        return [
            'query' => $query,
            'columns' => $exportColumns,
            'column_config' => $this->availableColumns,
        ];
    }

    /**
     * Get default visible columns.
     */
    protected function getDefaultVisibleColumns(): array
    {
        return array_keys(array_filter($this->availableColumns, function($col) {
            return $col['default_visible'] ?? false;
        }));
    }

    /**
     * Get default column order.
     */
    protected function getDefaultColumnOrder(): array
    {
        $columns = $this->availableColumns;
        uasort($columns, function($a, $b) {
            return ($a['default_order'] ?? 999) <=> ($b['default_order'] ?? 999);
        });
        return array_keys($columns);
    }

    /**
     * Get default column widths.
     */
    protected function getDefaultColumnWidths(): array
    {
        $widths = [];
        foreach ($this->availableColumns as $key => $column) {
            if (isset($column['width'])) {
                $widths[$key] = $column['width'];
            }
        }
        return $widths;
    }

    /**
     * Get default pinned columns.
     */
    protected function getDefaultPinnedColumns(): array
    {
        return ['id', 'name'];
    }

    /**
     * Reset table settings to default.
     */
    public function resetTableSettings(Admin $admin): object
    {
        Log::info('Lead table settings reset to default (memory only)', ['admin_id' => $admin->id]);
        
        return $this->getUserTableSettings($admin);
    }

    /**
     * Clear table cache for admin.
     */
    protected function clearTableCache(Admin $admin): void
    {
        $keys = [
            $this->cachePrefix . 'config_' . $admin->id,
            $this->cachePrefix . 'data_' . $admin->id,
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Get dropdown options for editable columns.
     */
    public function getDropdownOptions(Admin $admin, string $column): array
    {
        switch ($column) {
            case 'lead_status':
                return $this->getLeadStatusOptions();

            case 'assigned_admin':
                return $this->authService->getAvailableAdminsForAssignment($admin);

            case 'lead_priority':
                return $this->getLeadPriorityOptions();

            case 'lead_source':
                return $this->getLeadSourceOptions();

            default:
                return [];
        }
    }

    /**
     * Get lead status options.
     */
    protected function getLeadStatusOptions(): array
    {
        return Cache::remember('lead_status_options', 3600, function() {
            return \App\Models\LeadStatus::active()
                ->orderBy('sort_order')
                ->get()
                ->map(function($status) {
                    return [
                        'value' => $status->name,
                        'label' => $status->display_name ?: $status->name,
                        'color' => $status->color,
                    ];
                })
                ->toArray();
        });
    }

    /**
     * Get lead priority options.
     */
    protected function getLeadPriorityOptions(): array
    {
        return [
            ['value' => 'low', 'label' => 'Low', 'color' => '#28a745'],
            ['value' => 'medium', 'label' => 'Medium', 'color' => '#ffc107'],
            ['value' => 'high', 'label' => 'High', 'color' => '#dc3545'],
            ['value' => 'urgent', 'label' => 'Urgent', 'color' => '#6f42c1'],
        ];
    }

    /**
     * Get lead source options.
     */
    protected function getLeadSourceOptions(): array
    {
        return Cache::remember('lead_source_options', 3600, function() {
            return \App\Models\LeadSource::active()
                ->orderBy('sort_order')
                ->get()
                ->map(function($source) {
                    return [
                        'id' => $source->id,
                        'value' => $source->id,
                        'label' => $source->display_name ?: $source->name,
                        'name' => $source->display_name ?: $source->name,
                        'color' => $source->color,
                    ];
                })
                ->toArray();
        });
    }
}