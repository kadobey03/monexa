<template>
  <div class="status-dropdown relative" ref="dropdownRef">
    <!-- Trigger Button -->
    <button
      @click="toggleDropdown"
      :disabled="disabled || loading"
      class="status-dropdown-trigger w-full flex items-center justify-between px-3 py-2 text-sm rounded-lg border border-gray-200 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
      :class="{
        'bg-gray-50 cursor-not-allowed': disabled,
        'bg-white': !disabled,
        'border-blue-500 ring-2 ring-blue-500': isOpen
      }"
    >
      <span class="flex items-center min-w-0 flex-1">
        <span 
          v-if="selectedStatus"
          class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full"
          :style="getStatusStyle(selectedStatus)"
        >
          {{ selectedStatus.display_name || selectedStatus.name }}
        </span>
        <span v-else class="text-gray-500 italic">
          {{ placeholder }}
        </span>
      </span>
      
      <!-- Loading Spinner or Dropdown Arrow -->
      <div class="flex-shrink-0 ml-2">
        <div v-if="loading" class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
        <i 
          v-else
          class="fas fa-chevron-down w-4 h-4 text-gray-400 transition-transform duration-200"
          :class="{ 'rotate-180': isOpen }"
        ></i>
      </div>
    </button>

    <!-- Dropdown Panel -->
    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 translate-y-1"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 translate-y-1"
    >
      <div
        v-if="isOpen"
        class="status-dropdown-panel absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-hidden"
        :class="dropdownPosition"
      >
        <!-- Search Input (if searchable) -->
        <div v-if="searchable" class="p-3 border-b border-gray-200">
          <div class="relative">
            <input
              v-model="searchQuery"
              ref="searchInput"
              type="text"
              placeholder="Durum ara..."
              class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              @keydown.escape="closeDropdown"
              @keydown.enter.prevent="selectFirstStatus"
            />
            <i class="fas fa-search absolute left-2.5 top-1/2 transform -translate-y-1/2 w-3 h-3 text-gray-400"></i>
          </div>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="p-4 text-center">
          <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mx-auto"></div>
          <p class="text-sm text-gray-500 mt-2">Durumlar yükleniyor...</p>
        </div>

        <!-- Status List -->
        <div v-else-if="filteredStatuses.length > 0" class="max-h-48 overflow-y-auto">
          <div
            v-for="status in filteredStatuses"
            :key="status.id || status.name"
            @click="selectStatus(status)"
            class="status-option flex items-center px-3 py-2 cursor-pointer transition-colors duration-150 hover:bg-gray-50"
            :class="{
              'bg-blue-50 text-blue-700': selectedStatus && selectedStatus.name === status.name
            }"
          >
            <!-- Status Badge -->
            <span 
              class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full mr-3 flex-shrink-0"
              :style="getStatusStyle(status)"
            >
              {{ status.display_name || status.name }}
            </span>

            <!-- Status Info -->
            <div class="flex-1 min-w-0">
              <div class="text-sm font-medium text-gray-900 truncate">
                {{ status.display_name || status.name }}
              </div>
              <div v-if="status.description" class="text-xs text-gray-500 mt-0.5 truncate">
                {{ status.description }}
              </div>
            </div>

            <!-- Selection Indicator -->
            <i 
              v-if="selectedStatus && selectedStatus.name === status.name"
              class="fas fa-check w-4 h-4 text-blue-600 flex-shrink-0"
            ></i>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="p-4 text-center text-gray-500">
          <i class="fas fa-tags w-8 h-8 text-gray-300 mx-auto mb-2"></i>
          <p class="text-sm">
            {{ searchQuery ? 'Durum bulunamadı' : 'Durum mevcut değil' }}
          </p>
        </div>

        <!-- Clear Option -->
        <div v-if="allowClear && selectedStatus" class="border-t border-gray-200">
          <button
            @click="selectStatus(null)"
            class="w-full flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 transition-colors duration-150"
          >
            <i class="fas fa-times-circle w-4 h-4 mr-3 text-gray-400"></i>
            Durumu Temizle
          </button>
        </div>

        <!-- Status Statistics (optional) -->
        <div v-if="showStats && statusStats" class="border-t border-gray-200 p-2 bg-gray-50">
          <div class="flex justify-between text-xs text-gray-500">
            <span>{{ filteredStatuses.length }} durum</span>
            <span v-if="statusStats.total">{{ statusStats.total }} toplam lead</span>
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script>
import { ref, computed, watch, onMounted, onUnmounted, nextTick } from 'vue'

export default {
  name: 'StatusDropdown',
  
  props: {
    modelValue: {
      type: [Object, String, null],
      default: null
    },
    
    statuses: {
      type: Array,
      default: () => []
    },
    
    loading: {
      type: Boolean,
      default: false
    },
    
    disabled: {
      type: Boolean,
      default: false
    },
    
    placeholder: {
      type: String,
      default: 'Durum seçin...'
    },
    
    allowClear: {
      type: Boolean,
      default: true
    },
    
    searchable: {
      type: Boolean,
      default: false
    },
    
    showStats: {
      type: Boolean,
      default: false
    },
    
    statusStats: {
      type: Object,
      default: null
    }
  },
  
  emits: ['update:modelValue', 'select', 'search'],
  
  setup(props, { emit }) {
    // Refs
    const dropdownRef = ref(null)
    const searchInput = ref(null)
    const isOpen = ref(false)
    const searchQuery = ref('')
    
    // Computed
    const selectedStatus = computed(() => {
      if (!props.modelValue) return null
      
      if (typeof props.modelValue === 'object') {
        return props.modelValue
      }
      
      // Find by name or id
      return props.statuses.find(status => 
        status.name === props.modelValue || 
        status.id === props.modelValue
      )
    })
    
    const filteredStatuses = computed(() => {
      let filtered = props.statuses || []
      
      // Apply search filter
      if (searchQuery.value.trim()) {
        const query = searchQuery.value.toLowerCase().trim()
        filtered = filtered.filter(status => 
          (status.name && status.name.toLowerCase().includes(query)) ||
          (status.display_name && status.display_name.toLowerCase().includes(query)) ||
          (status.description && status.description.toLowerCase().includes(query))
        )
      }
      
      // Sort by priority or alphabetically
      return filtered.sort((a, b) => {
        // Sort by priority if available
        if (a.priority !== undefined && b.priority !== undefined) {
          return a.priority - b.priority
        }
        
        // Fallback to alphabetical sort
        const aName = a.display_name || a.name || ''
        const bName = b.display_name || b.name || ''
        return aName.localeCompare(bName)
      })
    })
    
    const dropdownPosition = computed(() => {
      // Calculate if dropdown should open upward
      const rect = dropdownRef.value?.getBoundingClientRect()
      if (!rect) return 'top-full'
      
      const spaceBelow = window.innerHeight - rect.bottom
      const spaceAbove = rect.top
      
      return spaceBelow < 250 && spaceAbove > spaceBelow ? 'bottom-full mb-1' : 'top-full'
    })
    
    // Methods
    const toggleDropdown = () => {
      if (props.disabled || props.loading) return
      
      isOpen.value = !isOpen.value
      
      if (isOpen.value && props.searchable) {
        nextTick(() => {
          searchInput.value?.focus()
        })
      }
    }
    
    const closeDropdown = () => {
      isOpen.value = false
      searchQuery.value = ''
    }
    
    const selectStatus = (status) => {
      emit('update:modelValue', status?.name || status)
      emit('select', status)
      closeDropdown()
    }
    
    const selectFirstStatus = () => {
      if (filteredStatuses.value.length > 0) {
        selectStatus(filteredStatuses.value[0])
      }
    }
    
    const getStatusStyle = (status) => {
      if (!status) return {}
      
      const style = {
        color: 'white',
        backgroundColor: status.color || '#6B7280'
      }
      
      // Add border for better visibility
      if (status.color) {
        style.border = `1px solid ${status.color}40`
      }
      
      return style
    }
    
    const getDefaultStatusColor = (statusName) => {
      const colorMap = {
        'new': '#3B82F6',           // Blue
        'contacted': '#F59E0B',     // Amber
        'qualified': '#10B981',     // Emerald
        'proposal': '#8B5CF6',      // Purple
        'negotiation': '#F97316',   // Orange
        'won': '#059669',           // Green
        'lost': '#EF4444',          // Red
        'nurture': '#6366F1',       // Indigo
        'follow_up': '#EC4899',     // Pink
        'unqualified': '#6B7280'    // Gray
      }
      
      return colorMap[statusName] || '#6B7280'
    }
    
    // Handle clicks outside
    const handleClickOutside = (event) => {
      if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        closeDropdown()
      }
    }
    
    // Watchers
    watch(searchQuery, (newValue) => {
      emit('search', newValue)
    })
    
    watch(isOpen, (newValue) => {
      if (newValue) {
        document.addEventListener('click', handleClickOutside)
      } else {
        document.removeEventListener('click', handleClickOutside)
      }
    })
    
    // Lifecycle
    onMounted(() => {
      // Any initialization
    })
    
    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside)
    })
    
    return {
      dropdownRef,
      searchInput,
      isOpen,
      searchQuery,
      selectedStatus,
      filteredStatuses,
      dropdownPosition,
      toggleDropdown,
      closeDropdown,
      selectStatus,
      selectFirstStatus,
      getStatusStyle,
      getDefaultStatusColor
    }
  }
}
</script>

<style scoped>
.status-dropdown {
  @apply relative inline-block w-full;
}

.status-dropdown-trigger:focus {
  @apply outline-none ring-2 ring-blue-500 border-blue-500;
}

.status-dropdown-panel {
  /* Custom scrollbar */
  scrollbar-width: thin;
  scrollbar-color: #cbd5e0 #f7fafc;
}

.status-dropdown-panel::-webkit-scrollbar {
  width: 4px;
}

.status-dropdown-panel::-webkit-scrollbar-track {
  background: #f7fafc;
}

.status-dropdown-panel::-webkit-scrollbar-thumb {
  background: #cbd5e0;
  border-radius: 2px;
}

.status-dropdown-panel::-webkit-scrollbar-thumb:hover {
  background: #a0aec0;
}

.rotate-180 {
  transform: rotate(180deg);
}

/* Smooth status badge transitions */
.status-option .status-badge {
  transition: all 0.2s ease;
}

.status-option:hover .status-badge {
  transform: scale(1.05);
}
</style>