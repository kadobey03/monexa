/**
 * Lead Assignment Vue.js Application - Modern ES6+ Entry Point
 * Vite-optimized with modern imports and HMR support
 */

import { createApp, ref, reactive, computed, onMounted, watch } from 'vue';
import { createPinia } from 'pinia';
import { leadAssignmentApi } from '@/admin/leads/vue/services/leadAssignmentApi.js';

// Import components dynamically for better code splitting
const FilterPanel = () => import('@/admin/leads/vue/components/FilterPanel.vue');
const LeadAssignmentTable = () => import('@/admin/leads/vue/components/LeadAssignmentTable.vue');
const BulkActionPanel = () => import('@/admin/admin/leads/vue/components/BulkActionPanel.vue');

// Import stores
import { useLeadStore } from '@/admin/leads/vue/stores/leadStore.js';

/**
 * Main Lead Assignment Application Component
 */
const LeadAssignmentApp = {
  name: 'LeadAssignmentApp',
  
  components: {
    FilterPanel,
    LeadAssignmentTable,
    BulkActionPanel
  },
  
  template: `
    <div class="lead-assignment-app" :class="{ 'app-loading': !appMounted }">
      <!-- Loading State -->
      <div v-if="loading && !appMounted" class="loading-state flex items-center justify-center min-h-96">
        <div class="text-center">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
          <p class="text-gray-600">Lead assignment sistemi yükleniyor...</p>
        </div>
      </div>

      <!-- Main Application Content -->
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

      <!-- Success/Error Notifications -->
      <Transition name="slide-up">
        <div v-if="notification.show" 
             class="fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white"
             :class="{
               'bg-green-500': notification.type === 'success',
               'bg-red-500': notification.type === 'error',
               'bg-yellow-500': notification.type === 'warning',
               'bg-blue-500': notification.type === 'info'
             }">
          <div class="flex items-center">
            <i class="fas mr-2"
               :class="{
                 'fa-check-circle': notification.type === 'success',
                 'fa-exclamation-circle': notification.type === 'error',
                 'fa-exclamation-triangle': notification.type === 'warning',
                 'fa-info-circle': notification.type === 'info'
               }"></i>
            {{ notification.message }}
          </div>
        </div>
      </Transition>
    </div>
  `,
  
  setup() {
    // Pinia store
    const leadStore = useLeadStore();
    
    // App State
    const appMounted = ref(false);
    const loading = ref(true);
    
    // Lead Data
    const leads = ref([]);
    const totalCount = ref(0);
    const selectedLeads = ref([]);
    
    // Available Options
    const availableAdmins = ref([]);
    const availableStatuses = ref([]);
    const availableSources = ref([]);
    const customFields = ref([]);
    
    // Filters & Pagination
    const filters = reactive({
      search: '',
      date_from: '',
      date_to: '',
      statuses: [],
      assigned_admin: '',
      sources: [],
      priorities: [],
      custom_fields: {}
    });
    
    const pagination = reactive({
      current_page: 1,
      per_page: 25,
      total: 0,
      last_page: 1
    });
    
    // Sorting
    const sortBy = ref('created_at');
    const sortDirection = ref('desc');
    
    // Table Columns
    const visibleColumns = ref([
      'checkbox',
      'name',
      'email',
      'phone',
      'status',
      'assigned_admin',
      'source',
      'created_at',
      'actions'
    ]);
    
    // Bulk Operations
    const bulkProcessing = ref(false);
    const processedCount = ref(0);
    const processingStatus = ref('');
    
    // Notifications
    const notification = reactive({
      show: false,
      type: 'success',
      message: ''
    });
    
    // Computed Properties
    const allSelected = computed(() => {
      return leads.value.length > 0 && selectedLeads.value.length === leads.value.length;
    });
    
    const someSelected = computed(() => {
      return selectedLeads.value.length > 0 && selectedLeads.value.length < leads.value.length;
    });
    
    // Methods
    const showNotification = (type, message) => {
      notification.type = type;
      notification.message = message;
      notification.show = true;
      
      setTimeout(() => {
        notification.show = false;
      }, 5000);
    };
    
    const loadLeads = async () => {
      try {
        loading.value = true;
        
        const params = {
          ...filters,
          page: pagination.current_page,
          per_page: pagination.per_page,
          sort_by: sortBy.value,
          sort_direction: sortDirection.value
        };
        
        const response = await leadAssignmentApi.getLeads(params);
        
        if (response.success) {
          leads.value = response.data.data;
          totalCount.value = response.data.total;
          
          // Update pagination
          Object.assign(pagination, {
            current_page: response.data.current_page,
            per_page: response.data.per_page,
            total: response.data.total,
            last_page: response.data.last_page
          });
        }
      } catch (error) {
        console.error('Error loading leads:', error);
        showNotification('error', 'Lead\'ler yüklenirken hata oluştu');
      } finally {
        loading.value = false;
      }
    };
    
    const loadDropdownData = async () => {
      try {
        // Load admins
        const adminsResponse = await leadAssignmentApi.getAvailableAdmins();
        if (adminsResponse.success) {
          availableAdmins.value = adminsResponse.data;
        }
        
        // Load statuses
        const statusesResponse = await leadAssignmentApi.getLeadStatuses();
        if (statusesResponse.success) {
          availableStatuses.value = statusesResponse.data;
        }
        
        // Load sources
        const sourcesResponse = await leadAssignmentApi.getLeadSources();
        if (sourcesResponse.success) {
          availableSources.value = sourcesResponse.data;
        }
      } catch (error) {
        console.error('Error loading dropdown data:', error);
      }
    };
    
    const updateFilters = (newFilters) => {
      Object.assign(filters, newFilters);
    };
    
    const applyFilters = (newFilters) => {
      if (newFilters) {
        updateFilters(newFilters);
      }
      pagination.current_page = 1;
      loadLeads();
    };
    
    const resetFilters = () => {
      Object.assign(filters, {
        search: '',
        date_from: '',
        date_to: '',
        statuses: [],
        assigned_admin: '',
        sources: [],
        priorities: [],
        custom_fields: {}
      });
      pagination.current_page = 1;
      loadLeads();
    };
    
    const handleSort = ({ column, direction }) => {
      sortBy.value = column;
      sortDirection.value = direction;
      loadLeads();
    };
    
    const changePage = (page) => {
      pagination.current_page = page;
      loadLeads();
    };
    
    const toggleLeadSelection = (lead) => {
      const index = selectedLeads.value.findIndex(l => l.id === lead.id);
      if (index > -1) {
        selectedLeads.value.splice(index, 1);
      } else {
        selectedLeads.value.push(lead);
      }
    };
    
    const toggleSelectAll = () => {
      if (allSelected.value) {
        selectedLeads.value = [];
      } else {
        selectedLeads.value = [...leads.value];
      }
    };
    
    const clearSelection = () => {
      selectedLeads.value = [];
    };
    
    const assignLead = async ({ leadId, adminId }) => {
      try {
        const response = await leadAssignmentApi.assignLead(leadId, adminId);
        
        if (response.success) {
          showNotification('success', 'Lead başarıyla atandı');
          loadLeads();
        } else {
          showNotification('error', response.message || 'Atama işlemi başarısız');
        }
      } catch (error) {
        console.error('Error assigning lead:', error);
        showNotification('error', 'Atama işlemi sırasında hata oluştu');
      }
    };
    
    const changeLeadStatus = async ({ leadId, status }) => {
      try {
        const response = await leadAssignmentApi.updateLeadStatus(leadId, status);
        
        if (response.success) {
          showNotification('success', 'Lead durumu güncellendi');
          loadLeads();
        } else {
          showNotification('error', response.message || 'Durum güncelleme başarısız');
        }
      } catch (error) {
        console.error('Error updating lead status:', error);
        showNotification('error', 'Durum güncelleme sırasında hata oluştu');
      }
    };
    
    const handleBulkAssignment = async ({ leadIds, adminId }) => {
      try {
        bulkProcessing.value = true;
        processingStatus.value = 'Lead\'ler atanıyor...';
        processedCount.value = 0;
        
        const response = await leadAssignmentApi.bulkAssignLeads(leadIds, adminId);
        
        if (response.success) {
          showNotification('success', `${leadIds.length} lead başarıyla atandı`);
          clearSelection();
          loadLeads();
        } else {
          showNotification('error', response.message || 'Toplu atama başarısız');
        }
      } catch (error) {
        console.error('Error in bulk assignment:', error);
        showNotification('error', 'Toplu atama sırasında hata oluştu');
      } finally {
        bulkProcessing.value = false;
        processingStatus.value = '';
        processedCount.value = 0;
      }
    };
    
    const handleBulkStatusChange = async ({ leadIds, status }) => {
      try {
        bulkProcessing.value = true;
        processingStatus.value = 'Durumlar güncelleniyor...';
        processedCount.value = 0;
        
        const response = await leadAssignmentApi.bulkUpdateStatus(leadIds, status);
        
        if (response.success) {
          showNotification('success', `${leadIds.length} lead durumu güncellendi`);
          clearSelection();
          loadLeads();
        } else {
          showNotification('error', response.message || 'Toplu durum güncelleme başarısız');
        }
      } catch (error) {
        console.error('Error in bulk status update:', error);
        showNotification('error', 'Toplu durum güncelleme sırasında hata oluştu');
      } finally {
        bulkProcessing.value = false;
        processingStatus.value = '';
        processedCount.value = 0;
      }
    };
    
    const handleBulkDelete = async (leadIds) => {
      try {
        bulkProcessing.value = true;
        processingStatus.value = 'Lead\'ler siliniyor...';
        
        const response = await leadStore.bulkDelete(leadIds);
        
        if (response.success) {
          showNotification('success', `${leadIds.length} lead silindi`);
          clearSelection();
          loadLeads();
        } else {
          showNotification('error', response.message || 'Toplu silme başarısız');
        }
      } catch (error) {
        console.error('Error in bulk delete:', error);
        showNotification('error', 'Toplu silme sırasında hata oluştu');
      } finally {
        bulkProcessing.value = false;
        processingStatus.value = '';
      }
    };
    
    const exportSelected = async (leadIds) => {
      try {
        await leadAssignmentApi.exportLeads({ lead_ids: leadIds });
        showNotification('success', 'Export başlatıldı');
      } catch (error) {
        console.error('Error exporting leads:', error);
        showNotification('error', 'Export sırasında hata oluştu');
      }
    };
    
    const addToSequence = async (leadIds) => {
      // TODO: Implement sequence functionality
      showNotification('info', 'Sıralama özelliği yakında gelecek');
    };
    
    const toggleColumn = (column) => {
      const index = visibleColumns.value.indexOf(column);
      if (index > -1) {
        visibleColumns.value.splice(index, 1);
      } else {
        visibleColumns.value.push(column);
      }
    };
    
    // Initialize Application
    const initializeApp = async () => {
      try {
        loading.value = true;
        
        // Load dropdown data first
        await loadDropdownData();
        
        // Load leads
        await loadLeads();
        
        // Mark app as mounted
        appMounted.value = true;
        
      } catch (error) {
        console.error('Error initializing app:', error);
        showNotification('error', 'Uygulama başlatılamadı');
      }
    };
    
    // Lifecycle
    onMounted(() => {
      initializeApp();
    });
    
    // Watch for filter changes with debounce
    const debouncedSearch = ref(null);
    watch(() => filters.search, (newValue) => {
      if (debouncedSearch.value) {
        clearTimeout(debouncedSearch.value);
      }
      
      debouncedSearch.value = setTimeout(() => {
        if (newValue.length === 0 || newValue.length >= 3) {
          pagination.current_page = 1;
          loadLeads();
        }
      }, 500);
    });
    
    return {
      appMounted,
      loading,
      leads,
      totalCount,
      selectedLeads,
      availableAdmins,
      availableStatuses,
      availableSources,
      customFields,
      filters,
      pagination,
      sortBy,
      sortDirection,
      visibleColumns,
      bulkProcessing,
      processedCount,
      processingStatus,
      notification,
      allSelected,
      someSelected,
      updateFilters,
      applyFilters,
      resetFilters,
      handleSort,
      changePage,
      toggleLeadSelection,
      toggleSelectAll,
      clearSelection,
      assignLead,
      changeLeadStatus,
      handleBulkAssignment,
      handleBulkStatusChange,
      handleBulkDelete,
      exportSelected,
      addToSequence,
      toggleColumn,
      showNotification
    };
  }
};

/**
 * Application Factory Function
 */
export function createLeadAssignmentApp() {
  return createApp(LeadAssignmentApp);
}

/**
 * Mount Lead Assignment Application
 */
export function mountLeadAssignmentApp(selector = '#lead-assignment-app') {
  try {
    // Create Vue app instance
    const app = createLeadAssignmentApp();
    
    // Install Pinia
    app.use(createPinia());
    
    // Global error handler
    app.config.errorHandler = (err, instance, info) => {
      console.error('Vue Error:', err, info);
      
      // Show user-friendly error message
      if (window.showToast) {
        window.showToast('Uygulama hatası oluştu', 'error');
      }
    };
    
    // Performance optimization for production
    if (import.meta.env.PROD) {
      app.config.performance = false;
    }
    
    // Mount the application
    const mountedApp = app.mount(selector);
    
    console.log('✅ Lead Assignment App mounted successfully');
    
    // Store reference for global access (backward compatibility)
    window.leadAssignmentApp = {
      app,
      mountedApp,
      showNotification: mountedApp.showNotification,
      refreshData: () => mountedApp.loadLeads?.(),
    };
    
    return mountedApp;
    
  } catch (error) {
    console.error('❌ Error mounting Lead Assignment App:', error);
    
    // Show fallback error message
    const container = document.querySelector(selector);
    if (container) {
      container.innerHTML = `
        <div class="flex items-center justify-center min-h-96 bg-red-50 rounded-lg">
          <div class="text-center p-6">
            <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
            <h3 class="text-lg font-semibold text-red-800 mb-2">Uygulama Başlatılamadı</h3>
            <p class="text-red-600 mb-4">Lead Assignment sistemi başlatılırken hata oluştu.</p>
            <button onclick="window.location.reload()" 
                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
              Sayfayı Yenile
            </button>
          </div>
        </div>
      `;
    }
    
    throw error;
  }
}

// Auto-mount if DOM is ready and container exists
if (import.meta.env.DEV) {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      const container = document.querySelector('#lead-assignment-app');
      if (container) {
        mountLeadAssignmentApp();
      }
    });
  } else {
    const container = document.querySelector('#lead-assignment-app');
    if (container) {
      mountLeadAssignmentApp();
    }
  }
}

// HMR support
if (import.meta.hot) {
  import.meta.hot.accept(() => {
    console.log('🔥 HMR: Lead Assignment App reloaded');
  });
}

// Default export for backward compatibility
export default { createLeadAssignmentApp, mountLeadAssignmentApp, LeadAssignmentApp };