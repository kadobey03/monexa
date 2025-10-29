/**
 * Lead Assignment API Service
 * Laravel backend API'si ile entegrasyon
 */

class LeadAssignmentApiService {
  constructor() {
    this.baseUrl = '/api/admin/leads'
    this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
    
    // Request defaults
    this.defaultHeaders = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
    
    if (this.csrfToken) {
      this.defaultHeaders['X-CSRF-TOKEN'] = this.csrfToken
    }
  }
  
  /**
   * Generic request method with error handling
   */
  async makeRequest(url, options = {}) {
    const config = {
      headers: {
        ...this.defaultHeaders,
        ...options.headers
      },
      ...options
    }
    
    try {
      const response = await fetch(url, config)
      
      // Handle non-2xx responses
      if (!response.ok) {
        const errorData = await response.json().catch(() => null)
        throw new Error(
          errorData?.message || 
          `HTTP ${response.status}: ${response.statusText}`
        )
      }
      
      return await response.json()
    } catch (error) {
      console.error('API Request Error:', error)
      
      // Enhanced error messages
      if (error.name === 'TypeError' && error.message.includes('fetch')) {
        throw new Error('Bağlantı hatası. İnternet bağlantınızı kontrol edin.')
      }
      
      throw error
    }
  }
  
  /**
   * Get leads with pagination and filters
   */
  async getLeads(params = {}) {
    const queryParams = new URLSearchParams({
      page: params.page || 1,
      per_page: params.per_page || 25,
      search: params.search || '',
      sort_by: params.sort_by || 'created_at',
      sort_direction: params.sort_direction || 'desc',
      ...this.cleanParams(params)
    })
    
    return await this.makeRequest(`${this.baseUrl}?${queryParams}`)
  }
  
  /**
   * Get single lead by ID
   */
  async getLead(id) {
    return await this.makeRequest(`${this.baseUrl}/${id}`)
  }
  
  /**
   * Create new lead
   */
  async createLead(leadData) {
    return await this.makeRequest(this.baseUrl, {
      method: 'POST',
      body: JSON.stringify(leadData)
    })
  }
  
  /**
   * Update existing lead
   */
  async updateLead(id, leadData) {
    return await this.makeRequest(`${this.baseUrl}/${id}`, {
      method: 'PUT',
      body: JSON.stringify(leadData)
    })
  }
  
  /**
   * Delete lead
   */
  async deleteLead(id) {
    return await this.makeRequest(`${this.baseUrl}/${id}`, {
      method: 'DELETE'
    })
  }
  
  /**
   * Assign lead to admin
   */
  async assignLead(leadId, adminId) {
    return await this.makeRequest(`${this.baseUrl}/${leadId}/assign`, {
      method: 'POST',
      body: JSON.stringify({
        admin_id: adminId
      })
    })
  }
  
  /**
   * Bulk assign leads to admin
   */
  async bulkAssignLeads(leadIds, adminId) {
    return await this.makeRequest(`${this.baseUrl}/bulk-assign`, {
      method: 'POST',
      body: JSON.stringify({
        lead_ids: leadIds,
        admin_id: adminId
      })
    })
  }
  
  /**
   * Update lead status
   */
  async updateLeadStatus(leadId, status) {
    return await this.makeRequest(`${this.baseUrl}/${leadId}/status`, {
      method: 'PATCH',
      body: JSON.stringify({
        lead_status: status
      })
    })
  }
  
  /**
   * Bulk update lead statuses
   */
  async bulkUpdateStatus(leadIds, status) {
    return await this.makeRequest(`${this.baseUrl}/bulk-status`, {
      method: 'POST',
      body: JSON.stringify({
        lead_ids: leadIds,
        status: status
      })
    })
  }
  
  /**
   * Get available admins with capacity information
   */
  async getAvailableAdmins() {
    return await this.makeRequest('/api/admin/available-admins')
  }
  
  /**
   * Get admin details with real-time status
   */
  async getAdminDetails(adminId) {
    return await this.makeRequest(`/api/admin/admins/${adminId}`)
  }
  
  /**
   * Search admins by name, email, department
   */
  async searchAdmins(query) {
    const params = new URLSearchParams({ search: query })
    return await this.makeRequest(`/api/admin/available-admins?${params}`)
  }
  
  /**
   * Get lead statuses
   */
  async getLeadStatuses() {
    return await this.makeRequest('/api/admin/lead-statuses')
  }
  
  /**
   * Get lead sources
   */
  async getLeadSources() {
    return await this.makeRequest('/api/admin/lead-sources')
  }
  
  /**
   * Get dashboard statistics
   */
  async getStats() {
    return await this.makeRequest('/api/admin/leads/stats')
  }
  
  /**
   * Export leads
   */
  async exportLeads(params = {}) {
    const queryParams = new URLSearchParams(this.cleanParams(params))
    const url = `/admin/leads/export?${queryParams}`
    
    // For file downloads, we don't use JSON response
    try {
      const response = await fetch(url, {
        headers: {
          'X-CSRF-TOKEN': this.csrfToken,
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      
      if (!response.ok) {
        throw new Error(`Export failed: ${response.status}`)
      }
      
      // Trigger file download
      const blob = await response.blob()
      const downloadUrl = window.URL.createObjectURL(blob)
      const a = document.createElement('a')
      
      a.href = downloadUrl
      a.download = `leads_${new Date().toISOString().split('T')[0]}.${params.format || 'xlsx'}`
      document.body.appendChild(a)
      a.click()
      
      window.URL.revokeObjectURL(downloadUrl)
      document.body.removeChild(a)
      
      return { success: true }
    } catch (error) {
      console.error('Export error:', error)
      throw error
    }
  }
  
  /**
   * Duplicate lead
   */
  async duplicateLead(leadId) {
    return await this.makeRequest(`${this.baseUrl}/${leadId}/duplicate`, {
      method: 'POST'
    })
  }
  
  /**
   * Get lead communication history
   */
  async getLeadCommunications(leadId) {
    return await this.makeRequest(`${this.baseUrl}/${leadId}/communications`)
  }
  
  /**
   * Add communication/note to lead
   */
  async addCommunication(leadId, communicationData) {
    return await this.makeRequest(`${this.baseUrl}/${leadId}/communications`, {
      method: 'POST',
      body: JSON.stringify(communicationData)
    })
  }
  
  /**
   * Schedule follow-up for lead
   */
  async scheduleFollowUp(leadId, followUpData) {
    return await this.makeRequest(`${this.baseUrl}/${leadId}/follow-up`, {
      method: 'POST',
      body: JSON.stringify(followUpData)
    })
  }
  
  /**
   * Get lead assignment history
   */
  async getAssignmentHistory(leadId) {
    return await this.makeRequest(`${this.baseUrl}/${leadId}/assignment-history`)
  }
  
  /**
   * Real-time admin capacity check
   */
  async checkAdminCapacity(adminId) {
    return await this.makeRequest(`/api/admin/admins/${adminId}/capacity`)
  }
  
  /**
   * Get admin workload statistics
   */
  async getAdminWorkload(adminId) {
    return await this.makeRequest(`/api/admin/admins/${adminId}/workload`)
  }
  
  /**
   * Advanced search with filters
   */
  async advancedSearch(searchCriteria) {
    return await this.makeRequest(`${this.baseUrl}/search`, {
      method: 'POST',
      body: JSON.stringify(searchCriteria)
    })
  }
  
  /**
   * Get lead recommendations for assignment
   */
  async getAssignmentRecommendations(leadId) {
    return await this.makeRequest(`${this.baseUrl}/${leadId}/recommendations`)
  }
  
  /**
   * Batch operations
   */
  async batchOperation(operation, leadIds, data = {}) {
    return await this.makeRequest(`${this.baseUrl}/batch`, {
      method: 'POST',
      body: JSON.stringify({
        operation,
        lead_ids: leadIds,
        ...data
      })
    })
  }
  
  /**
   * Get filter options (for dropdowns)
   */
  async getFilterOptions() {
    return await this.makeRequest('/api/admin/leads/filter-options')
  }
  
  /**
   * Save user preferences
   */
  async saveUserPreferences(preferences) {
    return await this.makeRequest('/api/admin/user/preferences', {
      method: 'POST',
      body: JSON.stringify(preferences)
    })
  }
  
  /**
   * Get user preferences
   */
  async getUserPreferences() {
    return await this.makeRequest('/api/admin/user/preferences')
  }
  
  /**
   * Utility: Clean parameters (remove empty values)
   */
  cleanParams(params) {
    const cleaned = {}
    
    Object.entries(params).forEach(([key, value]) => {
      if (value !== null && value !== undefined && value !== '') {
        cleaned[key] = value
      }
    })
    
    return cleaned
  }
  
  /**
   * Utility: Format date for API
   */
  formatDate(date) {
    if (!date) return null
    
    if (date instanceof Date) {
      return date.toISOString().split('T')[0]
    }
    
    return date
  }
  
  /**
   * Utility: Handle file upload
   */
  async uploadFile(file, type = 'lead_attachment') {
    const formData = new FormData()
    formData.append('file', file)
    formData.append('type', type)
    
    return await this.makeRequest('/api/admin/upload', {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': this.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
        // Don't set Content-Type for FormData
      }
    })
  }
  
  /**
   * WebSocket connection helper
   */
  setupWebSocketConnection() {
    if (window.Echo && window.Echo.connector) {
      return {
        adminStatus: window.Echo.channel('admin-status'),
        leadAssignments: window.Echo.channel('lead-assignments'),
        notifications: window.Echo.private('admin.notifications')
      }
    }
    
    console.warn('Laravel Echo not available for real-time updates')
    return null
  }
}

// Create and export singleton instance
export const leadAssignmentApi = new LeadAssignmentApiService()

// Export class for testing
export { LeadAssignmentApiService }