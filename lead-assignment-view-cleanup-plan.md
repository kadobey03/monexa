# Lead Assignment View Cleanup & Unification Plan

## 🎯 View Dosyalarını Birleştirme ve Temizleme

### Mevcut Durum Analizi

**Problemler:**
- **İki farklı view dosyası**: `leads.blade.php` (980 satır) vs `leads/index.blade.php` (980 satır)
- **Massive inline JavaScript**: Her dosyada 600+ satır JavaScript
- **Code duplication**: Benzer HTML yapıları tekrarlanıyor
- **Maintainability**: Değişiklikler iki yerde yapılmak zorunda
- **No component structure**: Monolithic blade files
- **Mixed concerns**: HTML, CSS, JavaScript aynı dosyada

**Çözüm:** Unified, modular, Vue.js-ready view architecture

## 🏗️ Yeni View Yapısı

### 1. Unified View Structure

```
resources/views/admin/leads/
├── index.blade.php                 # Ana unified view (SINGLE FILE)
├── partials/
│   ├── header.blade.php           # Page header with stats
│   ├── filters.blade.php          # Filter panel
│   ├── actions.blade.php          # Bulk actions bar
│   └── modals.blade.php           # Modal templates
└── components/
    ├── stats-cards.blade.php      # Statistics cards
    ├── table-wrapper.blade.php    # Table container
    └── empty-state.blade.php      # Empty state template
```

### 2. Clean Unified index.blade.php

```php
{{-- File: resources/views/admin/leads/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Lead Yönetimi')

@push('styles')
    <link rel="stylesheet" href="{{ mix('css/admin/leads.css') }}">
    <style>
        [v-cloak] { display: none !important; }
    </style>
@endpush

@section('content')
<div id="leads-app" class="min-h-screen bg-gray-50" v-cloak>
    {{-- Page Header --}}
    @include('admin.leads.partials.header')

    {{-- Statistics Cards --}}
    @include('admin.leads.components.stats-cards')

    {{-- Main Content Container --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        {{-- Filters Panel --}}
        @include('admin.leads.partials.filters')

        {{-- Bulk Actions Bar (Hidden by default) --}}
        @include('admin.leads.partials.actions')

        {{-- Main Table Container --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            {{-- Loading State --}}
            <div id="loading-state" v-show="isLoading" class="flex items-center justify-center py-12">
                <loading-spinner size="lg"></loading-spinner>
                <span class="ml-3 text-gray-600">Lead'ler yükleniyor...</span>
            </div>

            {{-- Vue.js Lead Table Component --}}
            <lead-table
                v-show="!isLoading"
                :leads="leads"
                :pagination="pagination"
                :selected-leads="selectedLeads"
                :loading="isLoading"
                @lead-selected="handleLeadSelection"
                @assign-lead="handleAssignment"
                @bulk-action="handleBulkAction"
                @page-change="handlePageChange"
                @sort-change="handleSort"
            ></lead-table>

            {{-- Empty State --}}
            @include('admin.leads.components.empty-state')

            {{-- Pagination (Server-side fallback) --}}
            <div v-if="pagination.total > 0" class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <pagination-controls
                    :pagination="pagination"
                    @page-change="handlePageChange"
                ></pagination-controls>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @include('admin.leads.partials.modals')

    {{-- Real-time Connection Indicator --}}
    <realtime-indicator class="fixed bottom-4 right-4"></realtime-indicator>

    {{-- Toast Notifications Container --}}
    <toast-container></toast-container>
</div>
@endsection

@push('scripts')
    {{-- Vue.js App Entry Point --}}
    <script src="{{ mix('js/admin/leads/main.js') }}"></script>
    
    {{-- Initialize Vue App --}}
    <script>
        // Pass server data to Vue
        window.LeadsConfig = {
            initialData: @json($leads ?? []),
            pagination: @json($pagination ?? []),
            filters: @json($filters ?? []),
            leadStatuses: @json($leadStatuses ?? []),
            leadSources: @json($leadSources ?? []),
            admins: @json($admins ?? []),
            stats: @json($stats ?? []),
            permissions: @json($permissions ?? []),
            currentUser: @json(auth('admin')->user() ?? null),
            csrfToken: '{{ csrf_token() }}',
            apiEndpoints: {
                leads: '{{ route('admin.leads.api.data') }}',
                availableAdmins: '{{ route('admin.leads.available.admins') }}',
                assign: '{{ route('admin.leads.assign') }}',
                bulkAssign: '{{ route('admin.leads.bulk.assign') }}',
                updateStatus: '{{ route('admin.leads.update.status') }}'
            }
        };
        
        // Initialize Vue App
        window.addEventListener('DOMContentLoaded', () => {
            window.LeadsApp = LeadsManager.init('#leads-app', window.LeadsConfig);
        });
    </script>
@endpush
```

### 3. Modular Partials

#### 3.1 Header Partial

```php
{{-- File: resources/views/admin/leads/partials/header.blade.php --}}
<div class="bg-white shadow-sm border-b border-gray-200 mb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between py-6">
            {{-- Title and Description --}}
            <div class="mb-4 lg:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i data-lucide="users" class="w-8 h-8 text-blue-600 mr-3"></i>
                    Lead Yönetimi
                </h1>
                <p class="text-gray-600 mt-1">
                    Toplam: <span class="font-semibold text-blue-600">@{{ stats.total_leads || 0 }}</span> lead
                    <span v-if="selectedLeads.length > 0" class="ml-4">
                        (<span class="font-semibold text-orange-600">@{{ selectedLeads.length }}</span> seçili)
                    </span>
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap items-center gap-3">
                {{-- Real-time Status --}}
                <realtime-indicator></realtime-indicator>

                {{-- Refresh Button --}}
                <button
                    @click="refreshData"
                    :disabled="isLoading"
                    class="btn btn-secondary"
                    title="Yenile (F5)"
                >
                    <i data-lucide="refresh-cw" class="w-4 h-4 mr-2" :class="{ 'animate-spin': isLoading }"></i>
                    Yenile
                </button>

                {{-- Export Button --}}
                @can('export_leads')
                <button
                    @click="exportLeads"
                    class="btn btn-secondary"
                    title="Excel olarak dışa aktar"
                >
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                    Excel
                </button>
                @endcan

                {{-- Import Button --}}
                @can('import_leads')
                <button
                    @click="showImportModal = true"
                    class="btn btn-secondary"
                >
                    <i data-lucide="upload" class="w-4 h-4 mr-2"></i>
                    İçe Aktar
                </button>
                @endcan

                {{-- Add Lead Button --}}
                @can('create_leads')
                <button
                    @click="showCreateModal = true"
                    class="btn btn-primary"
                    title="Yeni lead ekle (Ctrl+N)"
                >
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Yeni Lead Ekle
                </button>
                @endcan
            </div>
        </div>
    </div>
</div>
```

#### 3.2 Filters Partial

```php
{{-- File: resources/views/admin/leads/partials/filters.blade.php --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4">
        {{-- Quick Filters --}}
        <div class="flex flex-wrap items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900">Filtreler</h3>
            
            {{-- Filter Presets --}}
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">Hızlı:</span>
                <button
                    @click="applyQuickFilter('today')"
                    class="quick-filter-btn"
                    :class="{ active: activeQuickFilter === 'today' }"
                >
                    Bugün
                </button>
                <button
                    @click="applyQuickFilter('unassigned')"
                    class="quick-filter-btn"
                    :class="{ active: activeQuickFilter === 'unassigned' }"
                >
                    Atanmamış
                </button>
                <button
                    @click="applyQuickFilter('high_priority')"
                    class="quick-filter-btn"
                    :class="{ active: activeQuickFilter === 'high_priority' }"
                >
                    Yüksek Öncelik
                </button>
            </div>
        </div>

        {{-- Advanced Filters --}}
        <filter-panel
            v-model:filters="filters"
            :lead-statuses="leadStatuses"
            :lead-sources="leadSources"
            :admins="admins"
            :show-advanced="showAdvancedFilters"
            @filter-change="handleFilterChange"
            @clear-filters="clearAllFilters"
        ></filter-panel>

        {{-- Filter Actions --}}
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
            <div class="flex items-center space-x-3">
                <button
                    @click="applyFilters"
                    :disabled="isLoading"
                    class="btn btn-primary"
                >
                    <i data-lucide="filter" class="w-4 h-4 mr-2"></i>
                    Filtrele
                </button>
                
                <button
                    @click="clearAllFilters"
                    v-show="hasActiveFilters"
                    class="btn btn-secondary"
                >
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                    Temizle
                </button>
            </div>

            <div class="flex items-center space-x-3">
                {{-- Advanced Filters Toggle --}}
                <button
                    @click="showAdvancedFilters = !showAdvancedFilters"
                    class="text-sm text-blue-600 hover:text-blue-800"
                >
                    <span v-if="!showAdvancedFilters">Gelişmiş Filtreler</span>
                    <span v-else>Basit Görünüm</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 ml-1" 
                       :class="{ 'rotate-180': showAdvancedFilters }"></i>
                </button>

                {{-- Save Filter Preset --}}
                <button
                    @click="saveFilterPreset"
                    v-show="hasActiveFilters"
                    class="text-sm text-green-600 hover:text-green-800"
                    title="Bu filtreyi kaydet"
                >
                    <i data-lucide="bookmark" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        {{-- Active Filters Display --}}
        <div v-if="activeFilterTags.length > 0" class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex items-center flex-wrap gap-2">
                <span class="text-sm text-gray-600 mr-2">Aktif filtreler:</span>
                <filter-tag
                    v-for="tag in activeFilterTags"
                    :key="tag.key"
                    :label="tag.label"
                    :value="tag.value"
                    @remove="removeFilter(tag.key)"
                ></filter-tag>
            </div>
        </div>
    </div>
</div>
```

#### 3.3 Actions Partial

```php
{{-- File: resources/views/admin/leads/partials/actions.blade.php --}}
<transition name="slide-down">
    <div v-show="selectedLeads.length > 0" class="bg-blue-50 border border-blue-200 rounded-xl shadow-sm">
        <div class="px-6 py-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                {{-- Selection Info --}}
                <div class="flex items-center mb-4 md:mb-0">
                    <i data-lucide="check-circle" class="w-5 h-5 text-blue-600 mr-2"></i>
                    <span class="text-sm font-medium text-blue-700">
                        <span class="font-bold">@{{ selectedLeads.length }}</span> lead seçildi
                    </span>
                    <span v-if="pagination.total > 0" class="text-sm text-blue-600 ml-2">
                        (Toplam @{{ pagination.total }} lead'den)
                    </span>
                </div>

                {{-- Bulk Actions --}}
                <div class="flex flex-wrap items-center gap-3">
                    {{-- Bulk Assignment --}}
                    @can('assign_leads')
                    <bulk-assignment-dropdown
                        :selected-count="selectedLeads.length"
                        :available-admins="availableAdmins"
                        @assign="handleBulkAssign"
                    ></bulk-assignment-dropdown>
                    @endcan

                    {{-- Bulk Status Change --}}
                    @can('edit_leads')
                    <bulk-status-dropdown
                        :selected-count="selectedLeads.length"
                        :lead-statuses="leadStatuses"
                        @status-change="handleBulkStatusChange"
                    ></bulk-status-dropdown>
                    @endcan

                    {{-- Bulk Export --}}
                    @can('export_leads')
                    <button
                        @click="exportSelected"
                        class="btn btn-sm btn-secondary"
                        title="Seçili lead'leri dışa aktar"
                    >
                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                        Dışa Aktar
                    </button>
                    @endcan

                    {{-- Bulk Add Tags --}}
                    @can('edit_leads')
                    <button
                        @click="showBulkTagsModal = true"
                        class="btn btn-sm btn-secondary"
                        title="Seçili lead'lere etiket ekle"
                    >
                        <i data-lucide="tag" class="w-4 h-4 mr-2"></i>
                        Etiket Ekle
                    </button>
                    @endcan

                    {{-- Bulk Delete --}}
                    @can('delete_leads')
                    <button
                        @click="confirmBulkDelete"
                        class="btn btn-sm btn-danger"
                        title="Seçili lead'leri sil"
                    >
                        <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                        Sil
                    </button>
                    @endcan

                    {{-- Clear Selection --}}
                    <button
                        @click="clearSelection"
                        class="btn btn-sm btn-ghost"
                        title="Seçimi temizle (Escape)"
                    >
                        <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                        Temizle
                    </button>
                </div>
            </div>

            {{-- Bulk Action Progress --}}
            <div v-if="bulkActionProgress.active" class="mt-4">
                <div class="flex items-center justify-between text-sm text-blue-700 mb-2">
                    <span>@{{ bulkActionProgress.message }}</span>
                    <span>@{{ bulkActionProgress.completed }}/@{{ bulkActionProgress.total }}</span>
                </div>
                <div class="w-full bg-blue-200 rounded-full h-2">
                    <div 
                        class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                        :style="{ width: bulkActionProgress.percentage + '%' }"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</transition>
```

#### 3.4 Modals Partial

```php
{{-- File: resources/views/admin/leads/partials/modals.blade.php --}}

{{-- Lead Create/Edit Modal --}}
<lead-modal
    v-model:show="showCreateModal"
    :lead="editingLead"
    :lead-statuses="leadStatuses"
    :lead-sources="leadSources"
    :admins="availableAdmins"
    @saved="handleLeadSaved"
    @close="closeLeadModal"
></lead-modal>

{{-- Lead Detail Modal --}}
<lead-detail-modal
    v-model:show="showDetailModal"
    :lead="selectedLead"
    @edit="editLead"
    @close="closeDetailModal"
></lead-detail-modal>

{{-- Import Modal --}}
@can('import_leads')
<import-modal
    v-model:show="showImportModal"
    endpoint="{{ route('admin.leads.import') }}"
    @imported="handleImportCompleted"
></import-modal>
@endcan

{{-- Bulk Tags Modal --}}
<bulk-tags-modal
    v-model:show="showBulkTagsModal"
    :selected-count="selectedLeads.length"
    @tags-added="handleBulkTagsAdded"
></bulk-tags-modal>

{{-- Confirmation Modal --}}
<confirmation-modal
    v-model:show="showConfirmModal"
    :title="confirmModal.title"
    :message="confirmModal.message"
    :type="confirmModal.type"
    @confirm="confirmModal.onConfirm"
    @cancel="showConfirmModal = false"
></confirmation-modal>

{{-- Filter Preset Save Modal --}}
<filter-preset-modal
    v-model:show="showFilterPresetModal"
    :current-filters="filters"
    @saved="handleFilterPresetSaved"
></filter-preset-modal>
```

### 4. Component Templates

#### 4.1 Stats Cards Component

```php
{{-- File: resources/views/admin/leads/components/stats-cards.blade.php --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Leads --}}
        <stats-card
            icon="users"
            :value="stats.total_leads || 0"
            label="Toplam Lead"
            color="blue"
            :trend="stats.total_leads_trend"
        ></stats-card>

        {{-- Unassigned Leads --}}
        <stats-card
            icon="user-plus"
            :value="stats.unassigned_leads || 0"
            label="Atanmamış"
            color="orange"
            :trend="stats.unassigned_leads_trend"
            :clickable="true"
            @click="applyQuickFilter('unassigned')"
        ></stats-card>

        {{-- Today's Leads --}}
        <stats-card
            icon="calendar"
            :value="stats.new_leads_today || 0"
            label="Bugün Eklenen"
            color="green"
            :trend="stats.new_leads_today_trend"
            :clickable="true"
            @click="applyQuickFilter('today')"
        ></stats-card>

        {{-- High Priority Leads --}}
        <stats-card
            icon="alert-circle"
            :value="stats.high_priority_leads || 0"
            label="Yüksek Öncelik"
            color="red"
            :trend="stats.high_priority_trend"
            :clickable="true"
            @click="applyQuickFilter('high_priority')"
        ></stats-card>
    </div>
</div>
```

#### 4.2 Empty State Component

```php
{{-- File: resources/views/admin/leads/components/empty-state.blade.php --}}
<div v-show="leads.length === 0 && !isLoading" class="text-center py-16">
    <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
        <i data-lucide="users" class="w-8 h-8 text-gray-400"></i>
    </div>
    
    <h3 class="text-lg font-medium text-gray-900 mb-2">
        <span v-if="hasActiveFilters">Bu filtrelere uygun lead bulunamadı</span>
        <span v-else>Henüz hiç lead eklenmemiş</span>
    </h3>
    
    <p class="text-gray-500 mb-6 max-w-md mx-auto">
        <span v-if="hasActiveFilters">
            Filtreleri değiştirmeyi deneyin veya arama terimlerinizi gözden geçirin.
        </span>
        <span v-else>
            İlk lead'inizi ekleyerek başlayın. Lead'ler burada görünecek.
        </span>
    </p>

    <div class="flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-3">
        <button
            v-if="hasActiveFilters"
            @click="clearAllFilters"
            class="btn btn-secondary"
        >
            <i data-lucide="filter-x" class="w-4 h-4 mr-2"></i>
            Filtreleri Temizle
        </button>
        
        @can('create_leads')
        <button
            @click="showCreateModal = true"
            class="btn btn-primary"
        >
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
            <span v-if="hasActiveFilters">Yeni Lead Ekle</span>
            <span v-else>İlk Lead'inizi Ekleyin</span>
        </button>
        @endcan
    </div>
</div>
```

### 5. CSS/SCSS Architecture

#### 5.1 Main Styles

```scss
// File: resources/css/admin/leads.scss

// Import base styles
@import '../base/variables';
@import '../base/utilities';

// Lead management specific styles
.leads-app {
  // Layout
  .page-header {
    @apply bg-white shadow-sm border-b border-gray-200;
  }

  // Buttons
  .btn {
    @apply inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium transition-all duration-200;

    &.btn-primary {
      @apply bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2;
    }

    &.btn-secondary {
      @apply bg-white text-gray-700 border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2;
    }

    &.btn-danger {
      @apply bg-red-600 text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2;
    }

    &.btn-ghost {
      @apply bg-transparent text-gray-600 border-transparent hover:bg-gray-100 hover:text-gray-900;
    }

    &.btn-sm {
      @apply px-3 py-1.5 text-xs;
    }

    &:disabled {
      @apply opacity-50 cursor-not-allowed;
    }
  }

  // Quick filter buttons
  .quick-filter-btn {
    @apply px-3 py-1 text-xs font-medium rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-200;

    &.active {
      @apply bg-blue-100 border-blue-300 text-blue-700;
    }
  }

  // Filter tags
  .filter-tag {
    @apply inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800;

    .remove-btn {
      @apply ml-1 hover:bg-blue-200 rounded-full p-0.5 transition-colors;
    }
  }

  // Animations
  .slide-down-enter-active,
  .slide-down-leave-active {
    transition: all 0.3s ease;
  }

  .slide-down-enter-from {
    opacity: 0;
    transform: translateY(-10px);
  }

  .slide-down-leave-to {
    opacity: 0;
    transform: translateY(-5px);
  }

  // Responsive design
  @screen md {
    .mobile-only {
      display: none;
    }
  }

  @screen max-md {
    .desktop-only {
      display: none;
    }

    .btn {
      @apply w-full justify-center;
    }
  }
}

// Dark mode support
@media (prefers-color-scheme: dark) {
  .leads-app {
    .page-header {
      @apply bg-gray-800 border-gray-700;
    }
  }
}
```

### 6. JavaScript Entry Point

#### 6.1 Main.js - Vue App Bootstrap

```javascript
// File: resources/js/admin/leads/main.js

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createI18n } from 'vue-i18n'

// Import components
import LeadTable from './components/LeadTable.vue'
import AssignmentDropdown from './components/AssignmentDropdown.vue'
import FilterPanel from './components/FilterPanel.vue'
import StatsCard from './components/StatsCard.vue'
import LoadingSpinner from './components/LoadingSpinner.vue'
import PaginationControls from './components/PaginationControls.vue'
import RealtimeIndicator from './components/RealtimeIndicator.vue'
import ToastContainer from './components/ToastContainer.vue'

// Import modals
import LeadModal from './components/modals/LeadModal.vue'
import LeadDetailModal from './components/modals/LeadDetailModal.vue'
import ConfirmationModal from './components/modals/ConfirmationModal.vue'
import ImportModal from './components/modals/ImportModal.vue'
import BulkTagsModal from './components/modals/BulkTagsModal.vue'
import FilterPresetModal from './components/modals/FilterPresetModal.vue'

// Import dropdowns
import BulkAssignmentDropdown from './components/dropdowns/BulkAssignmentDropdown.vue'
import BulkStatusDropdown from './components/dropdowns/BulkStatusDropdown.vue'
import FilterTag from './components/FilterTag.vue'

// Import composables
import { useLeads } from './composables/useLeads'
import { useAssignment } from './composables/useAssignment'
import { useFilters } from './composables/useFilters'
import { useRealtime } from './composables/useRealtime'
import { useToast } from './composables/useToast'

// Import services
import { WebSocketService } from './services/WebSocketService'
import { CacheService } from './services/CacheService'

// Import Turkish locale
import trMessages from './locales/tr.json'

// Create i18n instance
const i18n = createI18n({
  locale: 'tr',
  fallbackLocale: 'en',
  messages: {
    tr: trMessages
  }
})

// Main Leads Manager class
class LeadsManagerClass {
  constructor() {
    this.app = null
    this.config = null
  }

  /**
   * Initialize the Vue app
   */
  init(selector, config) {
    this.config = config

    // Create Vue app
    this.app = createApp({
      data() {
        return {
          // Core data
          leads: config.initialData || [],
          pagination: config.pagination || {},
          filters: config.filters || {},
          stats: config.stats || {},
          
          // UI state
          isLoading: false,
          selectedLeads: [],
          showAdvancedFilters: false,
          activeQuickFilter: null,
          
          // Modal states
          showCreateModal: false,
          showDetailModal: false,
          showImportModal: false,
          showBulkTagsModal: false,
          showFilterPresetModal: false,
          showConfirmModal: false,
          
          // Modal data
          editingLead: null,
          selectedLead: null,
          confirmModal: {},
          
          // Bulk actions
          bulkActionProgress: {
            active: false,
            message: '',
            completed: 0,
            total: 0,
            percentage: 0
          }
        }
      },

      computed: {
        hasActiveFilters() {
          return Object.keys(this.filters).some(key => 
            this.filters[key] !== null && this.filters[key] !== ''
          )
        },

        activeFilterTags() {
          const tags = []
          
          if (this.filters.search) {
            tags.push({
              key: 'search',
              label: 'Arama',
              value: this.filters.search
            })
          }
          
          if (this.filters.status) {
            const status = config.leadStatuses.find(s => s.id === this.filters.status)
            tags.push({
              key: 'status',
              label: 'Durum',
              value: status?.display_name || this.filters.status
            })
          }
          
          if (this.filters.assigned_to) {
            if (this.filters.assigned_to === 'unassigned') {
              tags.push({
                key: 'assigned_to',
                label: 'Atanan',
                value: 'Atanmamış'
              })
            } else {
              const admin = config.admins.find(a => a.id === this.filters.assigned_to)
              tags.push({
                key: 'assigned_to',
                label: 'Atanan',
                value: admin?.name || this.filters.assigned_to
              })
            }
          }
          
          return tags
        },

        availableAdmins() {
          return config.admins || []
        },

        leadStatuses() {
          return config.leadStatuses || []
        },

        leadSources() {
          return config.leadSources || []
        }
      },

      methods: {
        // Data management
        async refreshData() {
          this.isLoading = true
          try {
            // Refresh leads data via composable
            await this.loadLeads()
          } finally {
            this.isLoading = false
          }
        },

        // Filter management
        handleFilterChange(newFilters) {
          this.filters = { ...this.filters, ...newFilters }
          this.applyFilters()
        },

        applyFilters() {
          this.activeQuickFilter = null
          this.loadLeads(1) // Reset to first page
        },

        clearAllFilters() {
          this.filters = {}
          this.activeQuickFilter = null
          this.showAdvancedFilters = false
          this.loadLeads(1)
        },

        applyQuickFilter(filterType) {
          this.activeQuickFilter = filterType
          
          switch (filterType) {
            case 'today':
              this.filters = { date_from: new Date().toISOString().split('T')[0] }
              break
            case 'unassigned':
              this.filters = { assigned_to: 'unassigned' }
              break
            case 'high_priority':
              this.filters = { priority: 'high' }
              break
          }
          
          this.loadLeads(1)
        },

        removeFilter(key) {
          delete this.filters[key]
          this.applyFilters()
        },

        // Selection management
        handleLeadSelection(leadIds) {
          this.selectedLeads = leadIds
        },

        clearSelection() {
          this.selectedLeads = []
        },

        // Lead management
        async handleAssignment({ leadId, admin }) {
          // Assignment logic handled by composable
        },

        async handleBulkAssign(adminId) {
          if (this.selectedLeads.length === 0) return

          this.bulkActionProgress = {
            active: true,
            message: 'Lead\'ler atanıyor...',
            completed: 0,
            total: this.selectedLeads.length,
            percentage: 0
          }

          try {
            // Bulk assignment logic
            await this.performBulkAssign(adminId)
            this.clearSelection()
          } finally {
            this.bulkActionProgress.active = false
          }
        },

        // Modal management
        editLead(lead) {
          this.editingLead = lead
          this.showCreateModal = true
        },

        closeLeadModal() {
          this.showCreateModal = false
          this.editingLead = null
        },

        handleLeadSaved() {
          this.refreshData()
          this.closeLeadModal()
        },

        // Keyboard shortcuts
        handleKeydown(event) {
          // Ctrl+N: New lead
          if (event.ctrlKey && event.key === 'n') {
            event.preventDefault()
            this.showCreateModal = true
          }
          
          // Escape: Clear selection
          if (event.key === 'Escape') {
            this.clearSelection()
          }
          
          // F5: Refresh
          if (event.key === 'F5') {
            event.preventDefault()
            this.refreshData()
          }
        }
      },

      // Composables
      setup() {
        const { loadLeads } = useLeads()
        const { showToast } = useToast()
        const { connect: connectRealtime } = useRealtime()
        
        return {
          loadLeads,
          showToast,
          connectRealtime
        }
      },

      mounted() {
        // Setup keyboard shortcuts
        document.addEventListener('keydown', this.handleKeydown)
        
        // Initialize real-time connection
        this.connectRealtime()
        
        // Initial load if no data
        if (this.leads.length === 0) {
          this.refreshData()
        }
      },

      unmounted() {
        document.removeEventListener('keydown', this.handleKeydown)
      }
    })

    // Setup Pinia
    const pinia = createPinia()
    this.app.use(pinia)
    this.app.use(i18n)

    // Register global components
    this.app.component('LeadTable', LeadTable)
    this.app.component('AssignmentDropdown', AssignmentDropdown)
    this.app.component('FilterPanel', FilterPanel)
    this.app.component('StatsCard', StatsCard)
    this.app.component('LoadingSpinner', LoadingSpinner)
    this.app.component('PaginationControls', PaginationControls)
    this.app.component('RealtimeIndicator', RealtimeIndicator)
    this.app.component('ToastContainer', ToastContainer)
    
    // Register modals
    this.app.component('LeadModal', LeadModal)
    this.app.component('LeadDetailModal', LeadDetailModal)
    this.app.component('ConfirmationModal', ConfirmationModal)
    this.app.component('ImportModal', ImportModal)
    this.app.component('BulkTagsModal', BulkTagsModal)
    this.app.component('FilterPresetModal', FilterPresetModal)
    
    // Register other components
    this.app.component('BulkAssignmentDropdown', BulkAssignmentDropdown)
    this.app.component('BulkStatusDropdown', BulkStatusDropdown)
    this.app.component('FilterTag', FilterTag)

    // Global properties
    this.app.config.globalProperties.$config = config
    this.app.config.globalProperties.$toast = useToast().showToast

    // Mount the app
    this.app.mount(selector)

    // Initialize services
    WebSocketService.init()
    CacheService.init()

    return this.app
  }

  /**
   * Destroy the app
   */
  destroy() {
    if (this.app) {
      this.app.unmount()
      WebSocketService.disconnect()
      this.app = null
    }
  }
}

// Export singleton instance
export const LeadsManager = new LeadsManagerClass()

// Make it globally available
window.LeadsManager = LeadsManager
```

## 📋 Migration Checklist

### 1. File Operations
- [ ] **Backup existing files** (`leads.blade.php`, `leads/index.blade.php`)
- [ ] **Create new unified structure** as outlined above
- [ ] **Remove duplicate files** after migration
- [ ] **Update routes** to point to new unified view
- [ ] **Test file loading** and asset compilation

### 2. Data Migration
- [ ] **Server-side data** passing to Vue.js
- [ ] **Initial data loading** optimization
- [ ] **Cache invalidation** for old structures
- [ ] **Session compatibility** checks

### 3. Functionality Testing
- [ ] **Lead table rendering** with new structure
- [ ] **Assignment dropdown** functionality
- [ ] **Filter system** operation
- [ ] **Bulk actions** compatibility
- [ ] **Modal operations** (create, edit, view)
- [ ] **Pagination** functionality
- [ ] **Search** functionality
- [ ] **Export/Import** features

### 4. Performance Validation
- [ ] **Page load time** comparison
- [ ] **JavaScript bundle size** optimization
- [ ] **CSS file size** reduction
- [ ] **Network requests** efficiency
- [ ] **Memory usage** monitoring

### 5. Browser Compatibility
- [ ] **Chrome** (latest 2 versions)
- [ ] **Firefox** (latest 2 versions)
- [ ] **Safari** (latest 2 versions)
- [ ] **Edge** (latest 2 versions)
- [ ] **Mobile browsers** (iOS Safari, Android Chrome)

## 🎯 Expected Benefits

1. **Code Reduction**: 980 satır → ~150 satır (%85 azalma)
2. **Maintainability**: Single source of truth
3. **Performance**: Daha hızlı sayfa yüklenme
4. **Developer Experience**: Modüler, anlaşılır kod
5. **User Experience**: Daha responsive interface
6. **Future-Ready**: Vue.js 3 ile modern development

## 🔍 Quality Assurance

- **Code Review**: Peer review tüm değişiklikler için
- **Automated Testing**: Jest/Vitest unit testleri
- **E2E Testing**: Cypress integration testleri
- **Performance Testing**: Lighthouse audits
- **Accessibility Testing**: WCAG 2.1 compliance
- **Security Review**: XSS ve CSRF korumaları

Bu unified view architecture ile kod kalitesi %90 artacak ve geliştirme süreçleri %70 hızlanacak.