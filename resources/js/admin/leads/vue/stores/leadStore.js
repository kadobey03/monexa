/**
 * Lead Assignment Pinia Store - Modern ES6+ Module
 * Vite-optimized state management with TypeScript-like structure
 */

import { defineStore } from 'pinia';
import { ref, computed, reactive } from 'vue';
import { leadAssignmentApi } from '@/admin/leads/vue/services/leadAssignmentApi.js';

export const useLeadStore = defineStore('leadAssignment', () => {
  // State
  const leads = ref([]);
  const totalCount = ref(0);
  const loading = ref(false);
  const error = ref(null);
  const lastError = ref(null);
  
  // Selection State
  const selectedLeads = ref([]);
  
  // Filter State
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
  
  // Pagination State
  const pagination = reactive({
    current_page: 1,
    per_page: 25,
    total: 0,
    last_page: 1,
    from: 1,
    to: 25
  });
  
  // Sorting State
  const sortBy = ref('created_at');
  const sortDirection = ref('desc');
  
  // Dropdown Data State
  const availableAdmins = ref([]);
  const availableStatuses = ref([]);
  const availableSources = ref([]);
  const customFields = ref([]);
  
  // Bulk Operations State
  const bulkProcessing = ref(false);
  const processedCount = ref(0);
  const processingStatus = ref('');
  
  // UI State
  const realTimeEnabled = ref(false);
  const wsConnection = ref(null);
  
  // Computed Properties
  const leadStats = computed(() => ({
    total: totalCount.value,
    assigned: leads.value.filter(lead => lead.assigned_admin_id).length,
    unassigned: leads.value.filter(lead => !lead.assigned_admin_id).length,
    newLeads: leads.value.filter(lead => lead.status === 'new').length
  }));
  
  const selectionStats = computed(() => {
    if (selectedLeads.value.length === 0) return null;
    
    return {
      total: selectedLeads.value.length,
      unassigned: selectedLeads.value.filter(lead => !lead.assigned_admin_id).length,
      newLeads: selectedLeads.value.filter(lead => lead.status === 'new').length,
      statuses: [...new Set(selectedLeads.value.map(lead => lead.status))]
    };
  });
  
  const activeFilterCount = computed(() => {
    let count = 0;
    
    if (filters.search) count++;
    if (filters.date_from) count++;
    if (filters.date_to) count++;
    if (filters.statuses.length > 0) count++;
    if (filters.assigned_admin) count++;
    if (filters.sources.length > 0) count++;
    if (filters.priorities.length > 0) count++;
    
    Object.values(filters.custom_fields).forEach(value => {
      if (value && value !== '') count++;
    });
    
    return count;
  });
  
  const adminStats = computed(() => {
    const stats = {
      total: availableAdmins.value.length,
      available: 0,
      online: 0,
      atCapacity: 0
    };
    
    availableAdmins.value.forEach(admin => {
      if (admin.is_available) stats.available++;
      if (admin.is_online) stats.online++;
      if (admin.capacity_percentage >= 90) stats.atCapacity++;
    });
    
    return stats;
  });
  
  const allSelected = computed(() => {
    return leads.value.length > 0 && selectedLeads.value.length === leads.value.length;
  });
  
  const hasSelection = computed(() => {
    return selectedLeads.value.length > 0;
  });
  
  const totalPages = computed(() => {
    return Math.ceil(pagination.total / pagination.per_page);
  });
  
  // Actions
  async function loadLeads(params = {}) {
    try {
      loading.value = true;
      error.value = null;
      
      const apiParams = {
        ...filters,
        ...params,
        page: pagination.current_page,
        per_page: pagination.per_page,
        sort_by: sortBy.value,
        sort_direction: sortDirection.value
      };
      
      const response = await leadAssignmentApi.getLeads(apiParams);
      
      if (response.success) {
        leads.value = response.data.data || [];
        totalCount.value = response.data.total || 0;
        
        // Update pagination
        Object.assign(pagination, {
          current_page: response.data.current_page || 1,
          per_page: response.data.per_page || 25,
          total: response.data.total || 0,
          last_page: response.data.last_page || 1,
          from: response.data.from || 1,
          to: response.data.to || 25
        });
        
        // Clear invalid selections
        validateSelection();
      } else {
        throw new Error(response.message || 'Failed to load leads');
      }
    } catch (err) {
      error.value = err.message;
      lastError.value = err;
      console.error('Error loading leads:', err);
      throw err;
    } finally {
      loading.value = false;
    }
  }
  
  async function loadDropdownData() {
    try {
      const promises = [
        leadAssignmentApi.getAvailableAdmins(),
        leadAssignmentApi.getLeadStatuses(),
        leadAssignmentApi.getLeadSources()
      ];
      
      const [adminsResponse, statusesResponse, sourcesResponse] = await Promise.all(promises);
      
      if (adminsResponse.success) {
        availableAdmins.value = adminsResponse.data;
      }
      
      if (statusesResponse.success) {
        availableStatuses.value = statusesResponse.data;
      }
      
      if (sourcesResponse.success) {
        availableSources.value = sourcesResponse.data;
      }
    } catch (err) {
      console.error('Error loading dropdown data:', err);
    }
  }
  
  function updateFilters(newFilters) {
    Object.assign(filters, newFilters);
  }
  
  function resetFilters() {
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
  }
  
  function clearAllFilters() {
    resetFilters();
    pagination.current_page = 1;
    loadLeads();
  }
  
  function updateSort(column, direction) {
    sortBy.value = column;
    sortDirection.value = direction;
  }
  
  function goToPage(page) {
    if (page >= 1 && page <= totalPages.value) {
      pagination.current_page = page;
      loadLeads();
    }
  }
  
  function changePerPage(perPage) {
    pagination.per_page = parseInt(perPage);
    pagination.current_page = 1;
    loadLeads();
  }
  
  // Selection Management
  function toggleLeadSelection(leadId) {
    const index = selectedLeads.value.findIndex(lead => {
      return typeof lead === 'object' ? lead.id === leadId : lead === leadId;
    });
    
    if (index > -1) {
      selectedLeads.value.splice(index, 1);
    } else {
      const lead = leads.value.find(l => l.id === leadId);
      if (lead) {
        selectedLeads.value.push(lead);
      }
    }
  }
  
  function selectAllLeads() {
    if (allSelected.value) {
      selectedLeads.value = [];
    } else {
      selectedLeads.value = [...leads.value];
    }
  }
  
  function clearSelection() {
    selectedLeads.value = [];
  }
  
  function validateSelection() {
    const currentIds = new Set(leads.value.map(l => l.id));
    selectedLeads.value = selectedLeads.value.filter(lead => {
      const leadId = typeof lead === 'object' ? lead.id : lead;
      return currentIds.has(leadId);
    });
  }
  
  // Lead Operations
  async function assignLead(leadId, adminId) {
    try {
      const response = await leadAssignmentApi.assignLead(leadId, adminId);
      
      if (response.success) {
        // Update local state
        const lead = leads.value.find(l => l.id === leadId);
        if (lead) {
          lead.assigned_admin_id = adminId;
          lead.assigned_admin = availableAdmins.value.find(a => a.id === adminId) || null;
        }
        return response;
      } else {
        throw new Error(response.message || 'Assignment failed');
      }
    } catch (err) {
      lastError.value = err;
      throw err;
    }
  }
  
  async function updateLeadStatus(leadId, status) {
    try {
      const response = await leadAssignmentApi.updateLeadStatus(leadId, status);
      
      if (response.success) {
        // Update local state
        const lead = leads.value.find(l => l.id === leadId);
        if (lead) {
          lead.status = status;
          lead.status_obj = availableStatuses.value.find(s => s.name === status) || null;
        }
        return response;
      } else {
        throw new Error(response.message || 'Status update failed');
      }
    } catch (err) {
      lastError.value = err;
      throw err;
    }
  }
  
  // Bulk Operations
  async function bulkAssign(leadIds, adminId) {
    try {
      bulkProcessing.value = true;
      processingStatus.value = 'Lead\'ler atanıyor...';
      processedCount.value = 0;
      
      const response = await leadAssignmentApi.bulkAssignLeads(leadIds, adminId);
      
      if (response.success) {
        // Update local state for affected leads
        const admin = availableAdmins.value.find(a => a.id === adminId);
        leads.value.forEach(lead => {
          if (leadIds.includes(lead.id)) {
            lead.assigned_admin_id = adminId;
            lead.assigned_admin = admin;
            processedCount.value++;
          }
        });
        
        clearSelection();
        return response;
      } else {
        throw new Error(response.message || 'Bulk assignment failed');
      }
    } catch (err) {
      lastError.value = err;
      throw err;
    } finally {
      bulkProcessing.value = false;
      processingStatus.value = '';
      processedCount.value = 0;
    }
  }
  
  async function bulkUpdateStatus(leadIds, status) {
    try {
      bulkProcessing.value = true;
      processingStatus.value = 'Durumlar güncelleniyor...';
      processedCount.value = 0;
      
      const response = await leadAssignmentApi.bulkUpdateStatus(leadIds, status);
      
      if (response.success) {
        // Update local state for affected leads
        const statusObj = availableStatuses.value.find(s => s.name === status);
        leads.value.forEach(lead => {
          if (leadIds.includes(lead.id)) {
            lead.status = status;
            lead.status_obj = statusObj;
            processedCount.value++;
          }
        });
        
        clearSelection();
        return response;
      } else {
        throw new Error(response.message || 'Bulk status update failed');
      }
    } catch (err) {
      lastError.value = err;
      throw err;
    } finally {
      bulkProcessing.value = false;
      processingStatus.value = '';
      processedCount.value = 0;
    }
  }
  
  async function bulkDelete(leadIds) {
    try {
      bulkProcessing.value = true;
      processingStatus.value = 'Lead\'ler siliniyor...';
      
      // Use generic request for bulk delete
      const response = await leadAssignmentApi.makeRequest('/api/admin/leads/bulk-delete', {
        method: 'POST',
        body: JSON.stringify({ lead_ids: leadIds })
      });
      
      if (response.success) {
        // Remove leads from local state
        leads.value = leads.value.filter(lead => !leadIds.includes(lead.id));
        totalCount.value = Math.max(0, totalCount.value - leadIds.length);
        
        clearSelection();
        return response;
      } else {
        throw new Error(response.message || 'Bulk delete failed');
      }
    } catch (err) {
      lastError.value = err;
      throw err;
    } finally {
      bulkProcessing.value = false;
      processingStatus.value = '';
    }
  }
  
  // Real-time Updates
  function setupWebSocket() {
    if (!window.Echo || wsConnection.value) return;
    
    try {
      wsConnection.value = window.Echo.private(`admin.leads.${window.user?.id || 1}`)
        .listen('LeadAssigned', (event) => {
          handleLeadAssigned(event.lead);
        })
        .listen('LeadStatusChanged', (event) => {
          handleLeadStatusChanged(event.lead);
        })
        .listen('LeadUpdated', (event) => {
          handleLeadUpdated(event.lead);
        });
      
      realTimeEnabled.value = true;
      console.log('✅ WebSocket connection established for leads');
    } catch (err) {
      console.warn('⚠️  WebSocket setup failed:', err);
      realTimeEnabled.value = false;
    }
  }
  
  function disconnectWebSocket() {
    if (wsConnection.value) {
      wsConnection.value.stopListening('LeadAssigned')
        .stopListening('LeadStatusChanged')
        .stopListening('LeadUpdated');
      wsConnection.value = null;
    }
    realTimeEnabled.value = false;
  }
  
  // WebSocket Event Handlers
  function handleLeadAssigned(updatedLead) {
    const index = leads.value.findIndex(lead => lead.id === updatedLead.id);
    if (index > -1) {
      Object.assign(leads.value[index], updatedLead);
    }
  }
  
  function handleLeadStatusChanged(updatedLead) {
    const index = leads.value.findIndex(lead => lead.id === updatedLead.id);
    if (index > -1) {
      Object.assign(leads.value[index], updatedLead);
    }
  }
  
  function handleLeadUpdated(updatedLead) {
    const index = leads.value.findIndex(lead => lead.id === updatedLead.id);
    if (index > -1) {
      Object.assign(leads.value[index], updatedLead);
    } else {
      // Lead might be new and should be added if it matches current filters
      leads.value.push(updatedLead);
      totalCount.value++;
    }
  }
  
  // Modal/UI Actions
  function openCreateModal() {
    // Emit event for create modal
    window.dispatchEvent(new CustomEvent('lead:create'));
  }
  
  function viewLeadDetails(leadId) {
    // Emit event for lead details
    window.dispatchEvent(new CustomEvent('lead:view', {
      detail: { leadId }
    }));
  }
  
  // Utility Actions
  function refreshData() {
    return loadLeads();
  }
  
  function clearError() {
    error.value = null;
    lastError.value = null;
  }
  
  // Reset store state
  function $reset() {
    leads.value = [];
    totalCount.value = 0;
    loading.value = false;
    error.value = null;
    lastError.value = null;
    selectedLeads.value = [];
    
    resetFilters();
    
    pagination.current_page = 1;
    pagination.per_page = 25;
    pagination.total = 0;
    pagination.last_page = 1;
    
    sortBy.value = 'created_at';
    sortDirection.value = 'desc';
    
    availableAdmins.value = [];
    availableStatuses.value = [];
    availableSources.value = [];
    customFields.value = [];
    
    bulkProcessing.value = false;
    processedCount.value = 0;
    processingStatus.value = '';
    
    disconnectWebSocket();
  }
  
  // Return store interface
  return {
    // State
    leads,
    totalCount,
    loading,
    error,
    lastError,
    selectedLeads,
    filters,
    pagination,
    sortBy,
    sortDirection,
    availableAdmins,
    availableStatuses,
    availableSources,
    customFields,
    bulkProcessing,
    processedCount,
    processingStatus,
    realTimeEnabled,
    wsConnection,
    
    // Computed
    leadStats,
    selectionStats,
    activeFilterCount,
    adminStats,
    allSelected,
    hasSelection,
    totalPages,
    
    // Actions
    loadLeads,
    loadDropdownData,
    updateFilters,
    resetFilters,
    clearAllFilters,
    updateSort,
    goToPage,
    changePerPage,
    
    // Selection
    toggleLeadSelection,
    selectAllLeads,
    clearSelection,
    validateSelection,
    
    // Operations
    assignLead,
    updateLeadStatus,
    bulkAssign,
    bulkUpdateStatus,
    bulkDelete,
    
    // Real-time
    setupWebSocket,
    disconnectWebSocket,
    handleLeadAssigned,
    handleLeadStatusChanged,
    handleLeadUpdated,
    
    // UI
    openCreateModal,
    viewLeadDetails,
    
    // Utilities
    refreshData,
    clearError,
    $reset
  };
});

// HMR support
if (import.meta.hot) {
  import.meta.hot.accept(() => {
    console.log('🔥 HMR: Lead Store reloaded');
  });
}

// Export default for backward compatibility
export default useLeadStore;