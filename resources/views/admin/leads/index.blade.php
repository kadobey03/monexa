@extends('layouts.admin')

@section('title', 'Lead Management')

@section('content')
<div class="leads-management-container">
    <!-- Page Header -->
    <div class="page-header bg-white border-b border-gray-200 px-6 py-4 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Lead Management</h1>
                <p class="text-sm text-gray-600 mt-1">Lead assignment ve yönetim sistemi</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Export Button -->
                <button 
                    type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onclick="exportLeads()"
                >
                    <i class="fas fa-download w-4 h-4 mr-2"></i>
                    Export
                </button>
                
                <!-- Import Button -->
                <button 
                    type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onclick="importLeads()"
                >
                    <i class="fas fa-upload w-4 h-4 mr-2"></i>
                    Import
                </button>
                
                <!-- Add New Lead -->
                <button 
                    type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onclick="addNewLead()"
                >
                    <i class="fas fa-plus w-4 h-4 mr-2"></i>
                    Yeni Lead
                </button>
            </div>
        </div>
    </div>

    <!-- Vue.js Lead Assignment App -->
    <div id="lead-assignment-app" class="lead-assignment-wrapper">
        <!-- Loading State (shown until Vue app mounts) -->
        <div class="loading-state flex items-center justify-center min-h-96" v-if="!appMounted">
            <div class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                <p class="text-gray-600">Lead assignment sistemi yükleniyor...</p>
            </div>
        </div>

        <!-- Vue App Content (shown after mounting) -->
        <div v-show="appMounted" class="vue-content">
            <!-- Filter Panel -->
            <FilterPanel
                :filters="filters"
                :available-statuses="availableStatuses"
                :available-admins="availableAdmins"
                :available-sources="availableSources"
                :custom-fields="customFields"
                :results-count="totalCount"
                :loading="loading"
                @update:filters="updateFilters"
                @apply-filters="applyFilters"
                @reset-filters="resetFilters"
            />

            <!-- Main Content Area -->
            <div class="main-content mt-6">
                <!-- Lead Assignment Table -->
                <LeadAssignmentTable
                    :leads="leads"
                    :columns="visibleColumns"
                    :loading="loading"
                    :pagination="pagination"
                    :sort-by="sortBy"
                    :sort-direction="sortDirection"
                    :selected-leads="selectedLeads"
                    :available-admins="availableAdmins"
                    :available-statuses="availableStatuses"
                    @select-lead="toggleLeadSelection"
                    @select-all="toggleSelectAll"
                    @sort="handleSort"
                    @change-page="changePage"
                    @assign-lead="assignLead"
                    @change-status="changeLeadStatus"
                    @toggle-column="toggleColumn"
                />

                <!-- Bulk Action Panel -->
                <BulkActionPanel
                    :selected-leads="selectedLeads"
                    :available-admins="availableAdmins"
                    :available-statuses="availableStatuses"
                    :processing="bulkProcessing"
                    :processed-count="processedCount"
                    :processing-status="processingStatus"
                    @assign-bulk="handleBulkAssignment"
                    @change-status-bulk="handleBulkStatusChange"
                    @delete-bulk="handleBulkDelete"
                    @export-selected="exportSelected"
                    @add-to-sequence="addToSequence"
                    @clear-selection="clearSelection"
                />
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" id="success-message">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg" id="error-message">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
@endif

@endsection

@section('styles')
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Lead Assignment CSS will be included in main app.css via Vite */
        .leads-management-container {
            max-width: 100%;
        }
        .loading-state {
            min-height: 24rem;
        }
    </style>
@endsection

@section('scripts')
    <!-- Core Dependencies -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/pinia@2/dist/pinia.iife.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/lodash/lodash.min.js"></script>
    
    <!-- Laravel Echo for WebSocket support (optional) -->
    @if(config('broadcasting.default') !== 'null')
        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
        <script src="https://unpkg.com/laravel-echo/dist/echo.iife.js"></script>
    @endif

    <!-- Vue.js Lead Assignment Components -->
    <script src="{{ asset('js/admin/leads/vue/services/leadAssignmentApi.js') }}"></script>
    <script src="{{ asset('js/admin/leads/vue/stores/leadStore.js') }}"></script>
    <script src="{{ asset('js/admin/leads/vue/components/AdminDropdown.vue.js') }}"></script>
    <script src="{{ asset('js/admin/leads/vue/components/StatusDropdown.vue.js') }}"></script>
    <script src="{{ asset('js/admin/leads/vue/components/FilterPanel.vue.js') }}"></script>
    <script src="{{ asset('js/admin/leads/vue/components/LeadAssignmentRow.vue.js') }}"></script>
    <script src="{{ asset('js/admin/leads/vue/components/LeadAssignmentTable.vue.js') }}"></script>
    <script src="{{ asset('js/admin/leads/vue/components/BulkActionPanel.vue.js') }}"></script>
    <script src="{{ asset('js/admin/leads/vue/LeadAssignmentApp.js') }}"></script>

    <script>
        // Global configuration from Laravel
        window.leadAssignmentConfig = {
            // API endpoints
            apiEndpoints: {
                leads: '{{ route("admin.leads.api.index") }}',
                admins: '{{ route("admin.leads.api.admins") }}',
                statuses: '{{ route("admin.leads.api.statuses") }}',
                assign: '{{ route("admin.leads.api.assign") }}',
                bulkAssign: '{{ route("admin.leads.api.bulk-assign") }}',
                updateStatus: '{{ route("admin.leads.api.update-status") }}',
                bulkStatusUpdate: '{{ route("admin.leads.api.bulk-status-update") }}',
                bulkDelete: '{{ route("admin.leads.api.bulk-delete") }}',
                export: '{{ route("admin.leads.api.export") }}',
            },
            
            // CSRF Token
            csrfToken: '{{ csrf_token() }}',
            
            // Current user info
            currentUser: @json(auth()->user()),
            
            // Permissions
            permissions: {
                canAssign: {{ auth()->user()->can('assign-leads') ? 'true' : 'false' }},
                canDelete: {{ auth()->user()->can('delete-leads') ? 'true' : 'false' }},
                canExport: {{ auth()->user()->can('export-leads') ? 'true' : 'false' }},
                canViewAll: {{ auth()->user()->can('view-all-leads') ? 'true' : 'false' }}
            },
            
            // WebSocket configuration (if enabled)
            @if(config('broadcasting.default') !== 'null')
            broadcasting: {
                enabled: true,
                driver: '{{ config("broadcasting.default") }}',
                key: '{{ config("broadcasting.connections.pusher.key") }}',
                cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
                wsHost: '{{ config("broadcasting.connections.pusher.options.host") }}',
                wsPort: {{ config("broadcasting.connections.pusher.options.port", 6001) }},
                wssPort: {{ config("broadcasting.connections.pusher.options.port", 6001) }},
                forceTLS: {{ config("broadcasting.connections.pusher.options.useTLS", false) ? 'true' : 'false' }},
                enabledTransports: ['ws', 'wss']
            },
            @else
            broadcasting: {
                enabled: false
            },
            @endif
            
            // Default settings
            settings: {
                defaultPageSize: 25,
                refreshInterval: 30000, // 30 seconds
                autoSaveInterval: 5000,  // 5 seconds
                maxBulkOperations: 100
            }
        };

        // Initialize Vue.js Lead Assignment App
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof LeadAssignmentApp !== 'undefined') {
                LeadAssignmentApp.mount('#lead-assignment-app');
            } else {
                console.error('LeadAssignmentApp not loaded properly');
            }
        });

        // Legacy function support (for backward compatibility)
        function exportLeads() {
            if (window.leadAssignmentApp && window.leadAssignmentApp.exportAll) {
                window.leadAssignmentApp.exportAll();
            } else {
                window.location.href = window.leadAssignmentConfig.apiEndpoints.export;
            }
        }

        function importLeads() {
            // TODO: Implement import modal
            alert('Import özelliği yakında gelecek');
        }

        function addNewLead() {
            // TODO: Implement add lead modal
            alert('Yeni lead ekleme özelliği yakında gelecek');
        }

        // Auto-hide flash messages
        setTimeout(function() {
            const successMsg = document.getElementById('success-message');
            const errorMsg = document.getElementById('error-message');
            
            if (successMsg) {
                successMsg.style.transition = 'opacity 0.5s ease';
                successMsg.style.opacity = '0';
                setTimeout(() => successMsg.remove(), 500);
            }
            
            if (errorMsg) {
                errorMsg.style.transition = 'opacity 0.5s ease';
                errorMsg.style.opacity = '0';
                setTimeout(() => errorMsg.remove(), 500);
            }
        }, 5000);
    </script>
@endsection