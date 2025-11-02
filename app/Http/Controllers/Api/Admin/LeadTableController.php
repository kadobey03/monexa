<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\LeadTableService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LeadTableController extends Controller
{
    protected $tableService;

    public function __construct(LeadTableService $tableService)
    {
        $this->tableService = $tableService;
    }

    /**
     * Get table configuration for current admin.
     */
    public function configuration(): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $config = $this->tableService->getTableConfiguration($admin);

            return response()->json([
                'success' => true,
                'data' => $config,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get table configuration', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get table configuration.',
            ], 500);
        }
    }

    /**
     * Update table settings.
     */
    public function updateSettings(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Validate request
            $validator = Validator::make($request->all(), [
                'visible_columns' => 'sometimes|array',
                'visible_columns.*' => 'string',
                'column_order' => 'sometimes|array',
                'column_order.*' => 'string',
                'column_widths' => 'sometimes|array',
                'column_widths.*' => 'integer|min:50|max:500',
                'pinned_columns' => 'sometimes|array',
                'pinned_columns.*' => 'string',
                'default_sort_column' => 'sometimes|string',
                'default_sort_direction' => 'sometimes|string|in:asc,desc',
                'default_per_page' => 'sometimes|integer|in:10,25,50,100,200',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Update settings
            $settings = $this->tableService->updateTableSettings($admin, $request->all());

            Log::info('Table settings updated', [
                'admin_id' => $admin->id,
                'settings' => $request->all(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Table settings updated successfully.',
                'data' => $settings,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update table settings', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
                'settings' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update table settings.',
            ], 500);
        }
    }

    /**
     * Reset table settings to default.
     */
    public function resetSettings(): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $settings = $this->tableService->resetTableSettings($admin);

            Log::info('Table settings reset to default', [
                'admin_id' => $admin->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Table settings reset to default successfully.',
                'data' => $settings,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to reset table settings', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to reset table settings.',
            ], 500);
        }
    }

    /**
     * Get dropdown options for specific column.
     */
    public function columnOptions(Request $request, string $column): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            
            // Validate column
            $allowedColumns = ['lead_status', 'assigned_admin', 'lead_priority'];
            if (!in_array($column, $allowedColumns)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid column specified.',
                ], 400);
            }

            $options = $this->tableService->getDropdownOptions($admin, $column);

            return response()->json([
                'success' => true,
                'data' => $options,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get column options', [
                'admin_id' => auth('admin')->id(),
                'column' => $column,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get column options.',
            ], 500);
        }
    }

    /**
     * Update single column width.
     */
    public function updateColumnWidth(Request $request, string $column): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Validate request
            $validator = Validator::make($request->all(), [
                'width' => 'required|integer|min:50|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid width value.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Get current settings
            $settings = $this->tableService->getUserTableSettings($admin);
            $columnWidths = $settings->column_widths ?? [];
            $columnWidths[$column] = $request->input('width');

            // Update settings
            $updatedSettings = $this->tableService->updateTableSettings($admin, [
                'column_widths' => $columnWidths,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Column width updated successfully.',
                'data' => $updatedSettings,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update column width', [
                'admin_id' => auth('admin')->id(),
                'column' => $column,
                'width' => $request->input('width'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update column width.',
            ], 500);
        }
    }

    /**
     * Toggle column visibility.
     */
    public function toggleColumnVisibility(Request $request, string $column): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Get current settings
            $settings = $this->tableService->getUserTableSettings($admin);
            $visibleColumns = $settings->visible_columns ?? [];

            // Toggle visibility
            if (in_array($column, $visibleColumns)) {
                $visibleColumns = array_values(array_diff($visibleColumns, [$column]));
            } else {
                $visibleColumns[] = $column;
            }

            // Update settings
            $updatedSettings = $this->tableService->updateTableSettings($admin, [
                'visible_columns' => $visibleColumns,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Column visibility updated successfully.',
                'data' => $updatedSettings,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to toggle column visibility', [
                'admin_id' => auth('admin')->id(),
                'column' => $column,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update column visibility.',
            ], 500);
        }
    }

    /**
     * Update column order.
     */
    public function updateColumnOrder(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Validate request
            $validator = Validator::make($request->all(), [
                'column_order' => 'required|array',
                'column_order.*' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid column order.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Update settings
            $updatedSettings = $this->tableService->updateTableSettings($admin, [
                'column_order' => $request->input('column_order'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Column order updated successfully.',
                'data' => $updatedSettings,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update column order', [
                'admin_id' => auth('admin')->id(),
                'column_order' => $request->input('column_order'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update column order.',
            ], 500);
        }
    }

    /**
     * Pin/Unpin column.
     */
    public function toggleColumnPin(Request $request, string $column): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Get current settings
            $settings = $this->tableService->getUserTableSettings($admin);
            $pinnedColumns = $settings->pinned_columns ?? [];

            // Toggle pin status
            if (in_array($column, $pinnedColumns)) {
                $pinnedColumns = array_values(array_diff($pinnedColumns, [$column]));
            } else {
                $pinnedColumns[] = $column;
            }

            // Update settings
            $updatedSettings = $this->tableService->updateTableSettings($admin, [
                'pinned_columns' => $pinnedColumns,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Column pin status updated successfully.',
                'data' => $updatedSettings,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to toggle column pin', [
                'admin_id' => auth('admin')->id(),
                'column' => $column,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update column pin status.',
            ], 500);
        }
    }

    /**
     * Save table preset.
     */
    public function savePreset(Request $request): JsonResponse
    {
        try {
            $admin = auth('admin')->user();

            // Validate request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'visible_columns' => 'required|array',
                'column_order' => 'required|array',
                'column_widths' => 'sometimes|array',
                'pinned_columns' => 'sometimes|array',
                'default_sort_column' => 'sometimes|string',
                'default_sort_direction' => 'sometimes|string|in:asc,desc',
                'default_per_page' => 'sometimes|integer|in:10,25,50,100,200',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // For now, we'll save as the user's current settings
            // In the future, this could be extended to support multiple presets
            $settings = $this->tableService->updateTableSettings($admin, $request->except(['name', 'description']));

            Log::info('Table preset saved', [
                'admin_id' => $admin->id,
                'preset_name' => $request->input('name'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Table preset saved successfully.',
                'data' => [
                    'preset' => [
                        'name' => $request->input('name'),
                        'description' => $request->input('description'),
                    ],
                    'settings' => $settings,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to save table preset', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save table preset.',
            ], 500);
        }
    }

    /**
     * Get available column definitions.
     */
    public function availableColumns(): JsonResponse
    {
        try {
            $admin = auth('admin')->user();
            $config = $this->tableService->getTableConfiguration($admin);

            return response()->json([
                'success' => true,
                'data' => $config['available_columns'],
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get available columns', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get available columns.',
            ], 500);
        }
    }

    /**
     * Validate table configuration.
     */
    public function validateConfiguration(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'visible_columns' => 'required|array|min:1',
                'visible_columns.*' => 'string',
                'column_order' => 'required|array',
                'column_order.*' => 'string',
                'column_widths' => 'sometimes|array',
                'column_widths.*' => 'integer|min:50|max:500',
                'pinned_columns' => 'sometimes|array',
                'pinned_columns.*' => 'string',
                'default_sort_column' => 'sometimes|string',
                'default_sort_direction' => 'sometimes|string|in:asc,desc',
                'default_per_page' => 'sometimes|integer|in:10,25,50,100,200',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'valid' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Additional validation logic
            $visibleColumns = $request->input('visible_columns', []);
            $columnOrder = $request->input('column_order', []);

            // Check if all visible columns are in column order
            $missingInOrder = array_diff($visibleColumns, $columnOrder);
            if (!empty($missingInOrder)) {
                return response()->json([
                    'success' => false,
                    'valid' => false,
                    'errors' => [
                        'column_order' => ['Column order is missing some visible columns: ' . implode(', ', $missingInOrder)]
                    ],
                ], 422);
            }

            return response()->json([
                'success' => true,
                'valid' => true,
                'message' => 'Configuration is valid.',
            ]);

        } catch (\Exception $e) {
            Log::error('Table configuration validation failed', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
            ], 500);
        }
    }
}