// Lead Assignment Pinia Store - Compiled for Browser (without Pinia dependency)
// Note: This is a simplified version that works without Pinia, using reactive Vue state

window.LeadStore = (function() {
  'use strict';
  
  // Create a simple store using Vue's reactive system
  const createLeadStore = () => {
    const { reactive, computed } = Vue;
    
    // Store State
    const state = reactive({
      // Lead Data
      leads: [],
      totalCount: 0,
      loading: false,
      
      // Selected Leads
      selectedLeads: [],
      
      // Filters
      filters: {
        search: '',
        date_from: '',
        date_to: '',
        statuses: [],
        assigned_admin: '',
        sources: [],
        priorities: [],
        custom_fields: {}
      },
      
      // Pagination
      pagination: {
        current_page: 1,
        per_page: 25,
        total: 0,
        last_page: 1
      },
      
      // Sorting
      sortBy: 'created_at',
      sortDirection: 'desc',
      
      // Dropdown Data
      availableAdmins: [],
      availableStatuses: [],
      availableSources: [],
      
      // UI State
      bulkProcessing: false,
      processedCount: 0,
      processingStatus: '',
      
      // Error Handling
      error: null,
      lastError: null,
      
      // WebSocket/Real-time
      wsConnection: null,
      realTimeEnabled: false
    });
    
    // Computed Properties
    const getters = {
      // Lead Statistics
      leadStats: computed(() => {
        return {
          total: state.totalCount,
          assigned: state.leads.filter(lead => lead.assigned_admin_id).length,
          unassigned: state.leads.filter(lead => !lead.assigned_admin_id).length,
          newLeads: state.leads.filter(lead => lead.status === 'new').length
        };
      }),
      
      // Selection Statistics
      selectionStats: computed(() => {
        if (state.selectedLeads.length === 0) return null;
        
        return {
          total: state.selectedLeads.length,
          unassigned: state.selectedLeads.filter(lead => !lead.assigned_admin_id).length,
          newLeads: state.selectedLeads.filter(lead => lead.status === 'new').length,
          statuses: [...new Set(state.selectedLeads.map(lead => lead.status))]
        };
      }),
      
      // Filter Statistics
      activeFilterCount: computed(() => {
        let count = 0;
        
        if (state.filters.search) count++;
        if (state.filters.date_from) count++;
        if (state.filters.date_to) count++;
        if (state.filters.statuses.length > 0) count++;
        if (state.filters.assigned_admin) count++;
        if (state.filters.sources.length > 0) count++;
        if (state.filters.priorities.length > 0) count++;
        
        // Count custom fields
        Object.values(state.filters.custom_fields).forEach(value => {
          if (value && value !== '') count++;
        });
        
        return count;
      }),
      
      // Admin Statistics
      adminStats: computed(() => {
        const stats = {
          total: state.availableAdmins.length,
          available: 0,
          online: 0,
          atCapacity: 0
        };
        
        state.availableAdmins.forEach(admin => {
          if (admin.is_available) stats.available++;
          if (admin.is_online) stats.online++;
          if (admin.capacity_percentage >= 90) stats.atCapacity++;
        });
        
        return stats;
      }),
      
      // Filtered Leads (for client-side filtering if needed)
      filteredLeads: computed(() => {
        let filtered = [...state.leads];
        
        // Apply search filter
        if (state.filters.search) {
          const query = state.filters.search.toLowerCase();
          filtered = filtered.filter(lead =>
            (lead.first_name && lead.first_name.toLowerCase().includes(query)) ||
            (lead.last_name && lead.last_name.toLowerCase().includes(query)) ||
            (lead.email && lead.email.toLowerCase().includes(query)) ||
            (lead.phone && lead.phone.includes(query)) ||
            (lead.company_name && lead.company_name.toLowerCase().includes(query))
          );
        }
        
        return filtered;
      }),
      
      // Is All Selected
      allSelected: computed(() => {
        return state.leads.length > 0 && state.selectedLeads.length === state.leads.length;
      }),
      
      // Has Selection
      hasSelection: computed(() => {
        return state.selectedLeads.length > 0;
      })
    };
    
    // Actions
    const actions = {
      // Load Leads
      async loadLeads(params = {}) {
        try {
          state.loading = true;
          state.error = null;
          
          const apiParams = {
            ...state.filters,
            ...params,
            page: state.pagination.current_page,
            per_page: state.pagination.per_page,
            sort_by: state.sortBy,
            sort_direction: state.sortDirection
          };
          
          const response = await window.LeadAssignmentAPI.prototype.getLeads(apiParams);
          
          if (response.success) {
            state.leads = response.data.data || [];
            state.totalCount = response.data.total || 0;
            
            // Update pagination
            Object.assign(state.pagination, {
              current_page: response.data.current_page,
              per_page: response.data.per_page,
              total: response.data.total,
              last_page: response.data.last_page
            });
            
            // Clear invalid selections
            actions.validateSelection();
          } else {
            throw new Error(response.message || 'Failed to load leads');
          }
        } catch (error) {
          state.error = error.message;
          state.lastError = error;
          console.error('Error loading leads:', error);
        } finally {
          state.loading = false;
        }
      },
      
      // Load Dropdown Data
      async loadDropdownData() {
        try {
          const api = new window.LeadAssignmentAPI();
          
          // Load admins
          const adminsResponse = await api.getAssignableAdmins();
          if (adminsResponse.success) {
            state.availableAdmins = adminsResponse.data;
          }
          
          // Load statuses
          const statusesResponse = await api.getStatuses();
          if (statusesResponse.success) {
            state.availableStatuses = statusesResponse.data;
          }
          
          // Load sources
          const sourcesResponse = await api.getLeadSources();
          if (sourcesResponse.success) {
            state.availableSources = sourcesResponse.data;
          }
        } catch (error) {
          console.error('Error loading dropdown data:', error);
        }
      },
      
      // Update Filters
      updateFilters(newFilters) {
        Object.assign(state.filters, newFilters);
      },
      
      // Reset Filters
      resetFilters() {
        state.filters = {
          search: '',
          date_from: '',
          date_to: '',
          statuses: [],
          assigned_admin: '',
          sources: [],
          priorities: [],
          custom_fields: {}
        };
      },
      
      // Update Sorting
      updateSort(column, direction) {
        state.sortBy = column;
        state.sortDirection = direction;
      },
      
      // Update Pagination
      updatePagination(page, perPage = null) {
        state.pagination.current_page = page;
        if (perPage) {
          state.pagination.per_page = perPage;
        }
      },
      
      // Selection Management
      selectLead(lead) {
        const index = state.selectedLeads.findIndex(l => l.id === lead.id);
        if (index > -1) {
          state.selectedLeads.splice(index, 1);
        } else {
          state.selectedLeads.push(lead);
        }
      },
      
      selectAllLeads() {
        if (getters.allSelected.value) {
          state.selectedLeads = [];
        } else {
          state.selectedLeads = [...state.leads];
        }
      },
      
      clearSelection() {
        state.selectedLeads = [];
      },
      
      validateSelection() {
        // Remove selected leads that are no longer in the current leads list
        const currentIds = new Set(state.leads.map(l => l.id));
        state.selectedLeads = state.selectedLeads.filter(lead => currentIds.has(lead.id));
      },
      
      // Lead Operations
      async assignLead(leadId, adminId) {
        try {
          const api = new window.LeadAssignmentAPI();
          const response = await api.assignLead(leadId, adminId);
          
          if (response.success) {
            // Update local state
            const lead = state.leads.find(l => l.id === leadId);
            if (lead) {
              lead.assigned_admin_id = adminId;
              lead.assigned_admin = state.availableAdmins.find(a => a.id === adminId) || null;
            }
            return response;
          } else {
            throw new Error(response.message || 'Assignment failed');
          }
        } catch (error) {
          state.lastError = error;
          throw error;
        }
      },
      
      async updateLeadStatus(leadId, status) {
        try {
          const api = new window.LeadAssignmentAPI();
          const response = await api.updateStatus(leadId, status);
          
          if (response.success) {
            // Update local state
            const lead = state.leads.find(l => l.id === leadId);
            if (lead) {
              lead.status = status;
              lead.status_obj = state.availableStatuses.find(s => s.name === status) || null;
            }
            return response;
          } else {
            throw new Error(response.message || 'Status update failed');
          }
        } catch (error) {
          state.lastError = error;
          throw error;
        }
      },
      
      // Bulk Operations
      async bulkAssign(leadIds, adminId) {
        try {
          state.bulkProcessing = true;
          state.processingStatus = 'Lead\'ler atanıyor...';
          state.processedCount = 0;
          
          const api = new window.LeadAssignmentAPI();
          const response = await api.bulkAssign(leadIds, adminId);
          
          if (response.success) {
            // Update local state for affected leads
            const admin = state.availableAdmins.find(a => a.id === adminId);
            state.leads.forEach(lead => {
              if (leadIds.includes(lead.id)) {
                lead.assigned_admin_id = adminId;
                lead.assigned_admin = admin;
                state.processedCount++;
              }
            });
            
            actions.clearSelection();
            return response;
          } else {
            throw new Error(response.message || 'Bulk assignment failed');
          }
        } catch (error) {
          state.lastError = error;
          throw error;
        } finally {
          state.bulkProcessing = false;
          state.processingStatus = '';
          state.processedCount = 0;
        }
      },
      
      async bulkUpdateStatus(leadIds, status) {
        try {
          state.bulkProcessing = true;
          state.processingStatus = 'Durumlar güncelleniyor...';
          state.processedCount = 0;
          
          const api = new window.LeadAssignmentAPI();
          const response = await api.bulkUpdateStatus(leadIds, status);
          
          if (response.success) {
            // Update local state for affected leads
            const statusObj = state.availableStatuses.find(s => s.name === status);
            state.leads.forEach(lead => {
              if (leadIds.includes(lead.id)) {
                lead.status = status;
                lead.status_obj = statusObj;
                state.processedCount++;
              }
            });
            
            actions.clearSelection();
            return response;
          } else {
            throw new Error(response.message || 'Bulk status update failed');
          }
        } catch (error) {
          state.lastError = error;
          throw error;
        } finally {
          state.bulkProcessing = false;
          state.processingStatus = '';
          state.processedCount = 0;
        }
      },
      
      async bulkDelete(leadIds) {
        try {
          state.bulkProcessing = true;
          state.processingStatus = 'Lead\'ler siliniyor...';
          
          const api = new window.LeadAssignmentAPI();
          const response = await api.bulkDelete(leadIds);
          
          if (response.success) {
            // Remove leads from local state
            state.leads = state.leads.filter(lead => !leadIds.includes(lead.id));
            state.totalCount = Math.max(0, state.totalCount - leadIds.length);
            
            actions.clearSelection();
            return response;
          } else {
            throw new Error(response.message || 'Bulk delete failed');
          }
        } catch (error) {
          state.lastError = error;
          throw error;
        } finally {
          state.bulkProcessing = false;
          state.processingStatus = '';
        }
      },
      
      // Real-time Updates
      setupWebSocket() {
        if (!window.Echo || state.wsConnection) return;
        
        try {
          state.wsConnection = window.Echo.private(`admin.leads.${window.leadAssignmentConfig.currentUser.id}`)
            .listen('LeadAssigned', (event) => {
              actions.handleLeadAssigned(event.lead);
            })
            .listen('LeadStatusChanged', (event) => {
              actions.handleLeadStatusChanged(event.lead);
            })
            .listen('LeadUpdated', (event) => {
              actions.handleLeadUpdated(event.lead);
            });
          
          state.realTimeEnabled = true;
        } catch (error) {
          console.warn('WebSocket setup failed:', error);
          state.realTimeEnabled = false;
        }
      },
      
      disconnectWebSocket() {
        if (state.wsConnection) {
          state.wsConnection.stopListening('LeadAssigned')
            .stopListening('LeadStatusChanged')
            .stopListening('LeadUpdated');
          state.wsConnection = null;
        }
        state.realTimeEnabled = false;
      },
      
      // WebSocket Event Handlers
      handleLeadAssigned(updatedLead) {
        const index = state.leads.findIndex(lead => lead.id === updatedLead.id);
        if (index > -1) {
          Object.assign(state.leads[index], updatedLead);
        }
      },
      
      handleLeadStatusChanged(updatedLead) {
        const index = state.leads.findIndex(lead => lead.id === updatedLead.id);
        if (index > -1) {
          Object.assign(state.leads[index], updatedLead);
        }
      },
      
      handleLeadUpdated(updatedLead) {
        const index = state.leads.findIndex(lead => lead.id === updatedLead.id);
        if (index > -1) {
          Object.assign(state.leads[index], updatedLead);
        } else {
          // Lead might be new and should be added if it matches current filters
          state.leads.push(updatedLead);
          state.totalCount++;
        }
      },
      
      // Utility Actions
      refreshData() {
        return actions.loadLeads();
      },
      
      clearError() {
        state.error = null;
        state.lastError = null;
      }
    };
    
    return {
      // Expose state (read-only)
      state: Vue.readonly(state),
      
      // Expose getters
      ...getters,
      
      // Expose actions
      ...actions
    };
  };
  
  // Return the store factory
  return {
    create: createLeadStore
  };
})();

// Auto-create global store instance if not exists
if (!window.leadStore) {
  window.leadStore = window.LeadStore.create();
  
  // Initialize store when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
      window.leadStore.loadDropdownData();
    });
  } else {
    window.leadStore.loadDropdownData();
  }
}