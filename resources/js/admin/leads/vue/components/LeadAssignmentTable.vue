<template>
  <div class="lead-assignment-table bg-white rounded-xl shadow-sm border border-gray-200">
    <!-- Table Header -->
    <div class="px-6 py-4 border-b border-gray-200">
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium text-gray-900">
          Lead Listesi
          <span class="text-sm text-gray-500 ml-2">
            ({{ leadStore.pagination.total }} kayıt)
          </span>
        </h3>
        
        <!-- Table Actions -->
        <div class="flex items-center space-x-3">
          <!-- Column Visibility Toggle -->
          <div class="relative" ref="columnToggleRef">
            <button
              @click="showColumnToggle = !showColumnToggle"
              class="inline-flex items-center px-3 py-2 text-sm text-gray-600 hover:text-gray-900 border border-gray-300 rounded-md hover:bg-gray-50"
            >
              <i class="fas fa-columns w-4 h-4 mr-2"></i>
              Sütunlar
            </button>
            
            <!-- Column Toggle Panel -->
            <div
              v-if="showColumnToggle"
              class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg z-10"
            >
              <div class="p-3">
                <div class="space-y-2">
                  <label
                    v-for="column in availableColumns"
                    :key="column.key"
                    class="flex items-center text-sm"
                  >
                    <input
                      v-model="column.visible"
                      type="checkbox"
                      class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2"
                    />
                    {{ column.label }}
                  </label>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Items Per Page -->
          <select
            v-model="leadStore.pagination.perPage"
            @change="leadStore.changePerPage($event.target.value)"
            class="text-sm border border-gray-300 rounded-md px-2 py-1"
          >
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>
    </div>
    
    <!-- Table Content -->
    <div class="overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <!-- Table Header -->
          <thead class="bg-gray-50">
            <tr>
              <!-- Select All Checkbox -->
              <th class="px-6 py-3 w-12">
                <input
                  type="checkbox"
                  :checked="isAllSelected"
                  :indeterminate="isPartialSelected"
                  @change="toggleSelectAll"
                  class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                />
              </th>
              
              <!-- Dynamic Columns -->
              <th
                v-for="column in visibleColumns"
                :key="column.key"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                :class="column.sortable ? 'cursor-pointer hover:bg-gray-100' : ''"
                @click="column.sortable ? handleSort(column.key) : null"
              >
                <div class="flex items-center space-x-1">
                  <span>{{ column.label }}</span>
                  <template v-if="column.sortable">
                    <i
                      class="fas fa-sort w-3 h-3 text-gray-400"
                      v-if="leadStore.sortBy !== column.key"
                    ></i>
                    <i
                      class="fas fa-sort-up w-3 h-3 text-blue-600"
                      v-else-if="leadStore.sortDirection === 'asc'"
                    ></i>
                    <i
                      class="fas fa-sort-down w-3 h-3 text-blue-600"
                      v-else
                    ></i>
                  </template>
                </div>
              </th>
            </tr>
          </thead>
          
          <!-- Table Body -->
          <tbody class="bg-white divide-y divide-gray-200">
            <LeadAssignmentRow
              v-for="lead in leadStore.leads"
              :key="lead.id"
              :lead="lead"
              :selected="leadStore.selectedLeads.includes(lead.id)"
              :visible-columns="visibleColumns"
              @select="handleLeadSelect"
              @assign="handleLeadAssign"
              @update-status="handleStatusUpdate"
              @view-details="handleViewDetails"
            />
          </tbody>
        </table>
      </div>
      
      <!-- Empty State -->
      <div v-if="!leadStore.loading && leadStore.leads.length === 0" class="text-center py-16">
        <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
          <i class="fas fa-users w-8 h-8 text-gray-400"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Lead bulunamadı</h3>
        <p class="text-gray-500 mb-6 max-w-md mx-auto">
          {{ leadStore.filters.search || Object.values(leadStore.filters).some(v => v) 
              ? 'Filtrelenmiş sonuç bulunamadı. Filtreleri değiştirmeyi deneyin.' 
              : 'Henüz hiç lead eklenmemiş. İlk lead\'inizi ekleyerek başlayın.' }}
        </p>
        <button
          v-if="!leadStore.filters.search && !Object.values(leadStore.filters).some(v => v)"
          @click="leadStore.openCreateModal"
          class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
        >
          <i class="fas fa-plus w-4 h-4 mr-2"></i>
          İlk Lead'inizi Ekleyin
        </button>
        <button
          v-else
          @click="leadStore.clearAllFilters"
          class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200"
        >
          <i class="fas fa-times w-4 h-4 mr-2"></i>
          Filtreleri Temizle
        </button>
      </div>
      
      <!-- Loading State -->
      <div v-if="leadStore.loading" class="text-center py-16">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
        <p class="mt-4 text-gray-600">Lead'ler yükleniyor...</p>
      </div>
      
      <!-- Pagination -->
      <div 
        v-if="!leadStore.loading && leadStore.leads.length > 0 && leadStore.pagination.totalPages > 1"
        class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200"
      >
        <!-- Mobile Pagination -->
        <div class="flex-1 flex justify-between sm:hidden">
          <button
            @click="leadStore.goToPage(leadStore.pagination.currentPage - 1)"
            :disabled="leadStore.pagination.currentPage <= 1"
            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <i class="fas fa-chevron-left w-4 h-4 mr-2"></i>
            Önceki
          </button>
          <span class="text-sm text-gray-700 flex items-center">
            {{ leadStore.pagination.currentPage }} / {{ leadStore.pagination.totalPages }}
          </span>
          <button
            @click="leadStore.goToPage(leadStore.pagination.currentPage + 1)"
            :disabled="leadStore.pagination.currentPage >= leadStore.pagination.totalPages"
            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            Sonraki
            <i class="fas fa-chevron-right w-4 h-4 ml-2"></i>
          </button>
        </div>
        
        <!-- Desktop Pagination -->
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
          <div>
            <p class="text-sm text-gray-700">
              <span class="font-medium">{{ leadStore.pagination.from }}</span>
              -
              <span class="font-medium">{{ leadStore.pagination.to }}</span>
              /
              <span class="font-medium">{{ leadStore.pagination.total }}</span>
              kayıt gösteriliyor
            </p>
          </div>
          
          <div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
              <!-- Previous Button -->
              <button
                @click="leadStore.goToPage(leadStore.pagination.currentPage - 1)"
                :disabled="leadStore.pagination.currentPage <= 1"
                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <i class="fas fa-chevron-left w-4 h-4"></i>
              </button>
              
              <!-- Page Numbers -->
              <template v-for="page in visiblePages" :key="page">
                <button
                  v-if="page !== '...'"
                  @click="leadStore.goToPage(page)"
                  class="relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors"
                  :class="page === leadStore.pagination.currentPage 
                    ? 'z-10 bg-blue-50 border-blue-500 text-blue-600' 
                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'"
                >
                  {{ page }}
                </button>
                <span
                  v-else
                  class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"
                >
                  ...
                </span>
              </template>
              
              <!-- Next Button -->
              <button
                @click="leadStore.goToPage(leadStore.pagination.currentPage + 1)"
                :disabled="leadStore.pagination.currentPage >= leadStore.pagination.totalPages"
                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <i class="fas fa-chevron-right w-4 h-4"></i>
              </button>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'
import { useLeadStore } from '../stores/leadStore'
import LeadAssignmentRow from './LeadAssignmentRow.vue'

export default {
  name: 'LeadAssignmentTable',
  
  components: {
    LeadAssignmentRow
  },
  
  setup() {
    // Store
    const leadStore = useLeadStore()
    
    // Refs
    const columnToggleRef = ref(null)
    const showColumnToggle = ref(false)
    
    // Available columns configuration
    const availableColumns = ref([
      { key: 'country', label: 'Ülke', visible: true, sortable: true },
      { key: 'name', label: 'Ad Soyad', visible: true, sortable: true },
      { key: 'phone', label: 'Telefon', visible: true, sortable: false },
      { key: 'email', label: 'Email', visible: true, sortable: true },
      { key: 'assigned_to', label: 'Atanan', visible: true, sortable: true },
      { key: 'status', label: 'Durum', visible: true, sortable: true },
      { key: 'organization', label: 'Varonka', visible: true, sortable: false },
      { key: 'source', label: 'Kaynak', visible: true, sortable: true },
      { key: 'company', label: 'Şirket', visible: true, sortable: false },
      { key: 'created_at', label: 'Tarih', visible: false, sortable: true },
      { key: 'actions', label: 'İşlemler', visible: true, sortable: false }
    ])
    
    // Computed properties
    const visibleColumns = computed(() => {
      return availableColumns.value.filter(col => col.visible)
    })
    
    const isAllSelected = computed(() => {
      return leadStore.leads.length > 0 && 
             leadStore.leads.every(lead => leadStore.selectedLeads.includes(lead.id))
    })
    
    const isPartialSelected = computed(() => {
      return leadStore.selectedLeads.length > 0 && !isAllSelected.value
    })
    
    const visiblePages = computed(() => {
      const current = leadStore.pagination.currentPage
      const total = leadStore.pagination.totalPages
      const pages = []
      
      // Always show first page
      if (current > 3) {
        pages.push(1)
        if (current > 4) pages.push('...')
      }
      
      // Show current page and surrounding pages
      const start = Math.max(1, current - 1)
      const end = Math.min(total, current + 1)
      
      for (let i = start; i <= end; i++) {
        pages.push(i)
      }
      
      // Always show last page
      if (current < total - 2) {
        if (current < total - 3) pages.push('...')
        pages.push(total)
      }
      
      return pages
    })
    
    // Methods
    const handleSort = (column) => {
      leadStore.sortBy = column
      
      if (leadStore.sortDirection === 'asc') {
        leadStore.sortDirection = 'desc'
      } else {
        leadStore.sortDirection = 'asc'
      }
      
      leadStore.loadLeads()
    }
    
    const toggleSelectAll = () => {
      if (isAllSelected.value) {
        leadStore.clearSelection()
      } else {
        leadStore.selectedLeads = leadStore.leads.map(lead => lead.id)
      }
    }
    
    const handleLeadSelect = (leadId) => {
      leadStore.toggleLeadSelection(leadId)
    }
    
    const handleLeadAssign = async (leadId, adminId) => {
      try {
        await leadStore.assignLead(leadId, adminId)
      } catch (error) {
        console.error('Assignment error:', error)
      }
    }
    
    const handleStatusUpdate = async (leadId, status) => {
      try {
        await leadStore.updateLeadStatus(leadId, status)
      } catch (error) {
        console.error('Status update error:', error)
      }
    }
    
    const handleViewDetails = (leadId) => {
      leadStore.viewLeadDetails(leadId)
    }
    
    const handleClickOutside = (event) => {
      if (columnToggleRef.value && !columnToggleRef.value.contains(event.target)) {
        showColumnToggle.value = false
      }
    }
    
    // Save column preferences to localStorage
    const saveColumnPreferences = () => {
      const preferences = availableColumns.value.reduce((acc, col) => {
        acc[col.key] = col.visible
        return acc
      }, {})
      
      localStorage.setItem('lead_table_columns', JSON.stringify(preferences))
    }
    
    const loadColumnPreferences = () => {
      try {
        const saved = localStorage.getItem('lead_table_columns')
        if (saved) {
          const preferences = JSON.parse(saved)
          availableColumns.value.forEach(col => {
            if (preferences.hasOwnProperty(col.key)) {
              col.visible = preferences[col.key]
            }
          })
        }
      } catch (error) {
        console.error('Error loading column preferences:', error)
      }
    }
    
    // Watchers
    watch(availableColumns, () => {
      saveColumnPreferences()
    }, { deep: true })
    
    watch(showColumnToggle, (newValue) => {
      if (newValue) {
        document.addEventListener('click', handleClickOutside)
      } else {
        document.removeEventListener('click', handleClickOutside)
      }
    })
    
    // Lifecycle
    onMounted(() => {
      loadColumnPreferences()
    })
    
    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside)
    })
    
    return {
      leadStore,
      columnToggleRef,
      showColumnToggle,
      availableColumns,
      visibleColumns,
      isAllSelected,
      isPartialSelected,
      visiblePages,
      handleSort,
      toggleSelectAll,
      handleLeadSelect,
      handleLeadAssign,
      handleStatusUpdate,
      handleViewDetails
    }
  }
}
</script>

<style scoped>
/* Custom table styling */
.lead-assignment-table table {
  border-collapse: separate;
  border-spacing: 0;
}

.lead-assignment-table th:first-child {
  border-top-left-radius: 0;
}

.lead-assignment-table th:last-child {
  border-top-right-radius: 0;
}

/* Smooth transitions for sorting indicators */
.fas.fa-sort,
.fas.fa-sort-up,
.fas.fa-sort-down {
  transition: color 0.2s ease;
}

/* Custom scrollbar for horizontal scroll */
.overflow-x-auto {
  scrollbar-width: thin;
  scrollbar-color: #cbd5e0 #f7fafc;
}

.overflow-x-auto::-webkit-scrollbar {
  height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
  background: #f7fafc;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
  background: #cbd5e0;
  border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
  background: #a0aec0;
}
</style>