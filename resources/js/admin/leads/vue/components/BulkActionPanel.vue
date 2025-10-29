<template>
  <div class="bulk-action-panel">
    <!-- Bulk Actions Bar -->
    <Transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="opacity-0 translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 translate-y-2"
    >
      <div
        v-if="selectedLeads.length > 0"
        class="bulk-actions-bar fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-white border border-gray-300 rounded-lg shadow-xl px-6 py-4 z-50"
        :class="{ 'w-full max-w-4xl mx-4': selectedLeads.length > 0 }"
      >
        <div class="flex items-center justify-between">
          <!-- Selection Info -->
          <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
              <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                <span class="text-sm font-semibold text-blue-600">{{ selectedLeads.length }}</span>
              </div>
              <span class="text-sm text-gray-700">
                {{ selectedLeads.length }} lead seçildi
              </span>
            </div>
            
            <!-- Quick Stats -->
            <div v-if="selectionStats" class="text-xs text-gray-500 space-x-3">
              <span v-if="selectionStats.unassigned > 0">
                {{ selectionStats.unassigned }} atanmamış
              </span>
              <span v-if="selectionStats.newLeads > 0">
                {{ selectionStats.newLeads }} yeni
              </span>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center space-x-2">
            <!-- Assign to Admin Dropdown -->
            <div class="relative" ref="assignDropdownRef">
              <button
                @click="toggleAssignDropdown"
                :disabled="processing || selectedLeads.length === 0"
                class="flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
              >
                <i class="fas fa-user-plus w-4 h-4 mr-2"></i>
                Admin Ata
                <i class="fas fa-chevron-down w-3 h-3 ml-2"></i>
              </button>

              <!-- Assign Dropdown Menu -->
              <Transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 translate-y-1"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition ease-in duration-150"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 translate-y-1"
              >
                <div
                  v-if="showAssignDropdown"
                  class="absolute bottom-full mb-2 w-80 bg-white border border-gray-300 rounded-lg shadow-lg max-h-64 overflow-hidden"
                >
                  <!-- Search -->
                  <div class="p-3 border-b border-gray-200">
                    <div class="relative">
                      <input
                        v-model="adminSearchQuery"
                        type="text"
                        placeholder="Admin ara..."
                        class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                      />
                      <i class="fas fa-search absolute left-2.5 top-1/2 transform -translate-y-1/2 w-3 h-3 text-gray-400"></i>
                    </div>
                  </div>

                  <!-- Admin List -->
                  <div class="max-h-48 overflow-y-auto">
                    <div
                      v-for="admin in filteredAdmins"
                      :key="admin.id"
                      @click="assignToAdmin(admin)"
                      class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-50 transition-colors duration-150"
                    >
                      <!-- Avatar -->
                      <img
                        v-if="admin.avatar"
                        :src="admin.avatar"
                        :alt="admin.name"
                        class="w-8 h-8 rounded-full mr-3 flex-shrink-0"
                      />
                      <div
                        v-else
                        class="w-8 h-8 rounded-full mr-3 flex-shrink-0 bg-gray-300 flex items-center justify-center"
                      >
                        <span class="text-xs font-semibold text-gray-600">
                          {{ admin.name?.charAt(0)?.toUpperCase() }}
                        </span>
                      </div>

                      <!-- Admin Info -->
                      <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900 truncate">
                          {{ admin.name }}
                        </div>
                        <div class="text-xs text-gray-500 truncate">
                          {{ admin.department?.name || 'Departman yok' }}
                        </div>
                      </div>

                      <!-- Capacity Indicator -->
                      <div class="flex-shrink-0 ml-2">
                        <div 
                          class="w-2 h-2 rounded-full"
                          :class="{
                            'bg-green-400': admin.capacity_percentage < 70,
                            'bg-yellow-400': admin.capacity_percentage >= 70 && admin.capacity_percentage < 90,
                            'bg-red-400': admin.capacity_percentage >= 90
                          }"
                        ></div>
                      </div>
                    </div>

                    <!-- No Admins Found -->
                    <div v-if="filteredAdmins.length === 0" class="p-4 text-center text-gray-500">
                      <i class="fas fa-users w-6 h-6 text-gray-300 mx-auto mb-2"></i>
                      <p class="text-sm">Admin bulunamadı</p>
                    </div>
                  </div>
                </div>
              </Transition>
            </div>

            <!-- Change Status Dropdown -->
            <div class="relative" ref="statusDropdownRef">
              <button
                @click="toggleStatusDropdown"
                :disabled="processing || selectedLeads.length === 0"
                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
              >
                <i class="fas fa-tags w-4 h-4 mr-2"></i>
                Durum Değiştir
                <i class="fas fa-chevron-down w-3 h-3 ml-2"></i>
              </button>

              <!-- Status Dropdown Menu -->
              <Transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 translate-y-1"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition ease-in duration-150"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 translate-y-1"
              >
                <div
                  v-if="showStatusDropdown"
                  class="absolute bottom-full mb-2 w-64 bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-hidden"
                >
                  <div class="max-h-48 overflow-y-auto">
                    <div
                      v-for="status in availableStatuses"
                      :key="status.name"
                      @click="changeStatus(status)"
                      class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-50 transition-colors duration-150"
                    >
                      <span 
                        class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full mr-3 flex-shrink-0"
                        :style="getStatusStyle(status)"
                      >
                        {{ status.display_name || status.name }}
                      </span>
                      <span class="text-sm text-gray-900 flex-1 truncate">
                        {{ status.display_name || status.name }}
                      </span>
                    </div>
                  </div>
                </div>
              </Transition>
            </div>

            <!-- More Actions Dropdown -->
            <div class="relative" ref="moreActionsRef">
              <button
                @click="toggleMoreActions"
                :disabled="processing || selectedLeads.length === 0"
                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
              >
                <i class="fas fa-ellipsis-h w-4 h-4 mr-2"></i>
                Diğer
              </button>

              <!-- More Actions Menu -->
              <Transition
                enter-active-class="transition ease-out duration-200"
                enter-from-class="opacity-0 translate-y-1"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition ease-in duration-150"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 translate-y-1"
              >
                <div
                  v-if="showMoreActions"
                  class="absolute bottom-full mb-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden"
                >
                  <button
                    @click="exportSelected"
                    class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150 text-left"
                  >
                    <i class="fas fa-download w-4 h-4 mr-3 text-gray-400"></i>
                    Export
                  </button>
                  
                  <button
                    @click="addToSequence"
                    class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150 text-left"
                  >
                    <i class="fas fa-play w-4 h-4 mr-3 text-gray-400"></i>
                    Sıralamaya Ekle
                  </button>
                  
                  <div class="border-t border-gray-200"></div>
                  
                  <button
                    @click="confirmBulkDelete"
                    class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150 text-left"
                  >
                    <i class="fas fa-trash w-4 h-4 mr-3 text-red-400"></i>
                    Sil
                  </button>
                </div>
              </Transition>
            </div>

            <!-- Close Button -->
            <button
              @click="clearSelection"
              class="p-2 text-gray-400 hover:text-gray-600 rounded-md hover:bg-gray-100 transition-colors duration-200"
            >
              <i class="fas fa-times w-4 h-4"></i>
            </button>
          </div>
        </div>

        <!-- Progress Bar (when processing) -->
        <div v-if="processing" class="mt-3">
          <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
            <span>{{ processingStatus }}</span>
            <span>{{ processedCount }}/{{ selectedLeads.length }}</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div 
              class="bg-blue-600 h-2 rounded-full transition-all duration-300"
              :style="{ width: `${progressPercentage}%` }"
            ></div>
          </div>
        </div>
      </div>
    </Transition>

    <!-- Confirmation Modals -->
    <!-- Delete Confirmation Modal -->
    <Transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="showDeleteConfirmation" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
          <div class="flex items-center mb-4">
            <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
              <i class="fas fa-exclamation-triangle w-6 h-6 text-red-600"></i>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-medium text-gray-900">Lead'leri Sil</h3>
              <p class="text-sm text-gray-500">Bu işlem geri alınamaz</p>
            </div>
          </div>
          
          <p class="text-sm text-gray-600 mb-6">
            {{ selectedLeads.length }} adet lead'i silmek istediğinizden emin misiniz?
          </p>
          
          <div class="flex justify-end space-x-3">
            <button
              @click="showDeleteConfirmation = false"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
            >
              İptal
            </button>
            <button
              @click="deleteBulk"
              class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700"
            >
              Sil
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'

export default {
  name: 'BulkActionPanel',
  
  props: {
    selectedLeads: {
      type: Array,
      default: () => []
    },
    
    availableAdmins: {
      type: Array,
      default: () => []
    },
    
    availableStatuses: {
      type: Array,
      default: () => []
    },
    
    processing: {
      type: Boolean,
      default: false
    },
    
    processedCount: {
      type: Number,
      default: 0
    },
    
    processingStatus: {
      type: String,
      default: ''
    }
  },
  
  emits: [
    'assign-bulk',
    'change-status-bulk', 
    'delete-bulk',
    'export-selected',
    'add-to-sequence',
    'clear-selection'
  ],
  
  setup(props, { emit }) {
    // Refs
    const assignDropdownRef = ref(null)
    const statusDropdownRef = ref(null)
    const moreActionsRef = ref(null)
    
    const showAssignDropdown = ref(false)
    const showStatusDropdown = ref(false)
    const showMoreActions = ref(false)
    const showDeleteConfirmation = ref(false)
    
    const adminSearchQuery = ref('')
    
    // Computed
    const selectionStats = computed(() => {
      if (props.selectedLeads.length === 0) return null
      
      return {
        unassigned: props.selectedLeads.filter(lead => !lead.assigned_admin_id).length,
        newLeads: props.selectedLeads.filter(lead => lead.status === 'new').length
      }
    })
    
    const filteredAdmins = computed(() => {
      let filtered = props.availableAdmins || []
      
      if (adminSearchQuery.value.trim()) {
        const query = adminSearchQuery.value.toLowerCase()
        filtered = filtered.filter(admin =>
          admin.name.toLowerCase().includes(query) ||
          (admin.department?.name && admin.department.name.toLowerCase().includes(query))
        )
      }
      
      // Sort by availability and capacity
      return filtered.sort((a, b) => {
        if (a.is_available !== b.is_available) {
          return b.is_available - a.is_available
        }
        return (a.capacity_percentage || 0) - (b.capacity_percentage || 0)
      })
    })
    
    const progressPercentage = computed(() => {
      if (props.selectedLeads.length === 0) return 0
      return Math.round((props.processedCount / props.selectedLeads.length) * 100)
    })
    
    // Methods
    const toggleAssignDropdown = () => {
      showAssignDropdown.value = !showAssignDropdown.value
      showStatusDropdown.value = false
      showMoreActions.value = false
    }
    
    const toggleStatusDropdown = () => {
      showStatusDropdown.value = !showStatusDropdown.value
      showAssignDropdown.value = false
      showMoreActions.value = false
    }
    
    const toggleMoreActions = () => {
      showMoreActions.value = !showMoreActions.value
      showAssignDropdown.value = false
      showStatusDropdown.value = false
    }
    
    const assignToAdmin = (admin) => {
      emit('assign-bulk', {
        leadIds: props.selectedLeads.map(lead => lead.id),
        adminId: admin.id,
        admin: admin
      })
      showAssignDropdown.value = false
      adminSearchQuery.value = ''
    }
    
    const changeStatus = (status) => {
      emit('change-status-bulk', {
        leadIds: props.selectedLeads.map(lead => lead.id),
        status: status.name,
        statusData: status
      })
      showStatusDropdown.value = false
    }
    
    const confirmBulkDelete = () => {
      showDeleteConfirmation.value = true
      showMoreActions.value = false
    }
    
    const deleteBulk = () => {
      emit('delete-bulk', props.selectedLeads.map(lead => lead.id))
      showDeleteConfirmation.value = false
    }
    
    const exportSelected = () => {
      emit('export-selected', props.selectedLeads.map(lead => lead.id))
      showMoreActions.value = false
    }
    
    const addToSequence = () => {
      emit('add-to-sequence', props.selectedLeads.map(lead => lead.id))
      showMoreActions.value = false
    }
    
    const clearSelection = () => {
      emit('clear-selection')
    }
    
    const getStatusStyle = (status) => {
      return {
        color: 'white',
        backgroundColor: status.color || '#6B7280'
      }
    }
    
    const closeAllDropdowns = () => {
      showAssignDropdown.value = false
      showStatusDropdown.value = false
      showMoreActions.value = false
    }
    
    // Handle clicks outside
    const handleClickOutside = (event) => {
      if (assignDropdownRef.value && !assignDropdownRef.value.contains(event.target)) {
        showAssignDropdown.value = false
      }
      if (statusDropdownRef.value && !statusDropdownRef.value.contains(event.target)) {
        showStatusDropdown.value = false
      }
      if (moreActionsRef.value && !moreActionsRef.value.contains(event.target)) {
        showMoreActions.value = false
      }
    }
    
    // Escape key handler
    const handleEscape = (event) => {
      if (event.key === 'Escape') {
        if (showDeleteConfirmation.value) {
          showDeleteConfirmation.value = false
        } else {
          closeAllDropdowns()
        }
      }
    }
    
    // Lifecycle
    onMounted(() => {
      document.addEventListener('click', handleClickOutside)
      document.addEventListener('keydown', handleEscape)
    })
    
    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside)
      document.removeEventListener('keydown', handleEscape)
    })
    
    return {
      assignDropdownRef,
      statusDropdownRef,
      moreActionsRef,
      showAssignDropdown,
      showStatusDropdown,
      showMoreActions,
      showDeleteConfirmation,
      adminSearchQuery,
      selectionStats,
      filteredAdmins,
      progressPercentage,
      toggleAssignDropdown,
      toggleStatusDropdown,
      toggleMoreActions,
      assignToAdmin,
      changeStatus,
      confirmBulkDelete,
      deleteBulk,
      exportSelected,
      addToSequence,
      clearSelection,
      getStatusStyle
    }
  }
}
</script>

<style scoped>
.bulk-action-panel {
  @apply relative;
}

.bulk-actions-bar {
  backdrop-filter: blur(8px);
  border: 1px solid rgba(229, 231, 235, 0.8);
}

/* Custom scrollbar */
.overflow-y-auto {
  scrollbar-width: thin;
  scrollbar-color: #cbd5e0 #f7fafc;
}

.overflow-y-auto::-webkit-scrollbar {
  width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f7fafc;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #cbd5e0;
  border-radius: 2px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #a0aec0;
}

/* Animation improvements */
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>