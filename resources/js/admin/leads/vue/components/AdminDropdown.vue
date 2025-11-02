<template>
  <div class="admin-dropdown relative" ref="dropdownRef">
    <!-- Trigger Button -->
    <button
      @click="toggleDropdown"
      :disabled="disabled || loading"
      class="admin-dropdown-trigger w-full flex items-center justify-between px-3 py-2 text-sm rounded-lg border border-gray-200 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
      :class="{
        'bg-gray-50 cursor-not-allowed': disabled,
        'bg-white': !disabled,
        'border-blue-500 ring-2 ring-blue-500': isOpen
      }"
    >
      <span class="flex items-center min-w-0 flex-1">
        <div v-if="selectedAdmin" class="flex items-center">
          <!-- Admin Avatar -->
          <div 
            class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-medium mr-2 flex-shrink-0"
            :style="{ backgroundColor: selectedAdmin.avatar_color || '#3B82F6' }"
          >
            {{ getInitials(selectedAdmin.name) }}
          </div>
          <div class="flex-1 min-w-0">
            <div class="text-sm font-medium text-gray-900 truncate">
              {{ selectedAdmin.name }}
            </div>
            <div class="text-xs text-gray-500 truncate">
              {{ selectedAdmin.department || 'Admin' }}
              <span v-if="selectedAdmin.capacity_info" class="ml-1">
                ({{ selectedAdmin.capacity_info.assigned }}/{{ selectedAdmin.capacity_info.max_capacity }})
              </span>
            </div>
          </div>
          <!-- Status Indicator -->
          <div
            class="w-2 h-2 rounded-full flex-shrink-0 ml-2"
            :class="{
              'bg-green-500': selectedAdmin.is_available,
              'bg-yellow-500': selectedAdmin.is_busy,
              'bg-red-500': !selectedAdmin.is_available && !selectedAdmin.is_busy,
              'bg-gray-400': selectedAdmin.is_offline
            }"
            :title="getStatusText(selectedAdmin)"
          ></div>
        </div>
        
        <span v-else class="text-gray-500 italic">
          {{ placeholder }}
        </span>
      </span>
      
      <!-- Dropdown Arrow -->
      <i 
        class="fas fa-chevron-down w-4 h-4 text-gray-400 transition-transform duration-200 flex-shrink-0 ml-2"
        :class="{ 'rotate-180': isOpen }"
      ></i>
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
        class="admin-dropdown-panel absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-80 overflow-hidden"
        :class="dropdownPosition"
      >
        <!-- Search Input -->
        <div class="p-3 border-b border-gray-200">
          <div class="relative">
            <input
              v-model="searchQuery"
              ref="searchInput"
              type="text"
              placeholder="Admin ara..."
              class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              @keydown.escape="closeDropdown"
              @keydown.enter.prevent="selectFirstAdmin"
              @keydown.arrow-down.prevent="highlightNext"
              @keydown.arrow-up.prevent="highlightPrevious"
            />
            <i class="fas fa-search absolute left-2.5 top-1/2 transform -translate-y-1/2 w-3 h-3 text-gray-400"></i>
          </div>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="p-4 text-center">
          <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mx-auto"></div>
          <p class="text-sm text-gray-500 mt-2">Admin'ler yükleniyor...</p>
        </div>

        <!-- Admin List -->
        <div v-else-if="filteredAdmins.length > 0" class="max-h-60 overflow-y-auto">
          <div
            v-for="(admin, index) in filteredAdmins"
            :key="admin.id"
            @click="selectAdmin(admin)"
            @mouseenter="highlightedIndex = index"
            class="admin-option flex items-center px-3 py-2 cursor-pointer transition-colors duration-150"
            :class="{
              'bg-blue-50 text-blue-700': highlightedIndex === index,
              'hover:bg-gray-50': highlightedIndex !== index,
              'bg-gray-100 cursor-not-allowed opacity-60': !admin.is_available && !allowUnavailable
            }"
          >
            <!-- Avatar -->
            <div 
              class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-medium mr-3 flex-shrink-0"
              :style="{ backgroundColor: admin.avatar_color || '#3B82F6' }"
            >
              {{ getInitials(admin.name) }}
            </div>

            <!-- Admin Info -->
            <div class="flex-1 min-w-0">
              <div class="flex items-center">
                <span class="text-sm font-medium text-gray-900 truncate">
                  {{ admin.name }}
                </span>
                <!-- Status Badge -->
                <span
                  class="ml-2 px-2 py-0.5 text-xs rounded-full flex-shrink-0"
                  :class="{
                    'bg-green-100 text-green-800': admin.is_available,
                    'bg-yellow-100 text-yellow-800': admin.is_busy,
                    'bg-red-100 text-red-800': !admin.is_available && !admin.is_busy,
                    'bg-gray-100 text-gray-800': admin.is_offline
                  }"
                >
                  {{ getStatusText(admin) }}
                </span>
              </div>
              
              <div class="text-xs text-gray-500 mt-0.5 flex items-center justify-between">
                <span>{{ admin.department || 'Admin' }}</span>
                <span v-if="admin.capacity_info" class="text-xs">
                  {{ admin.capacity_info.assigned }}/{{ admin.capacity_info.max_capacity }} lead
                </span>
              </div>

              <!-- Capacity Bar -->
              <div v-if="admin.capacity_info && admin.capacity_info.max_capacity > 0" class="mt-1">
                <div class="w-full bg-gray-200 rounded-full h-1.5">
                  <div
                    class="h-1.5 rounded-full transition-all duration-300"
                    :class="{
                      'bg-green-500': admin.capacity_info.utilization < 0.7,
                      'bg-yellow-500': admin.capacity_info.utilization >= 0.7 && admin.capacity_info.utilization < 0.9,
                      'bg-red-500': admin.capacity_info.utilization >= 0.9
                    }"
                    :style="{ width: `${Math.min(admin.capacity_info.utilization * 100, 100)}%` }"
                  ></div>
                </div>
              </div>
            </div>

            <!-- Selection Indicator -->
            <i 
              v-if="selectedAdmin && selectedAdmin.id === admin.id"
              class="fas fa-check w-4 h-4 text-blue-600 flex-shrink-0 ml-2"
            ></i>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="p-4 text-center text-gray-500">
          <i class="fas fa-users w-8 h-8 text-gray-300 mx-auto mb-2"></i>
          <p class="text-sm">
            {{ searchQuery ? 'Admin bulunamadı' : 'Müsait admin yok' }}
          </p>
        </div>

        <!-- Unassign Option -->
        <div v-if="allowUnassign" class="border-t border-gray-200">
          <button
            @click="selectAdmin(null)"
            class="w-full flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 transition-colors duration-150"
          >
            <i class="fas fa-times-circle w-4 h-4 mr-3 text-gray-400"></i>
            Atamayı Kaldır
          </button>
        </div>

        <!-- Footer Actions -->
        <div v-if="showFooterActions" class="border-t border-gray-200 p-2 bg-gray-50">
          <div class="flex justify-between text-xs text-gray-500">
            <span>{{ filteredAdmins.length }} admin</span>
            <button
              @click="refreshAdmins"
              class="text-blue-600 hover:text-blue-800"
            >
              <i class="fas fa-refresh w-3 h-3 mr-1"></i>
              Yenile
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script>
import { ref, computed, watch, onMounted, onUnmounted, nextTick } from 'vue'

export default {
  name: 'AdminDropdown',
  
  props: {
    modelValue: {
      type: [Object, Number, String, null],
      default: null
    },
    
    admins: {
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
      default: 'Admin seçin...'
    },
    
    allowUnassign: {
      type: Boolean,
      default: true
    },
    
    allowUnavailable: {
      type: Boolean,
      default: false
    },
    
    showFooterActions: {
      type: Boolean,
      default: true
    },
    
    maxHeight: {
      type: String,
      default: 'max-h-80'
    }
  },
  
  emits: ['update:modelValue', 'select', 'refresh', 'search'],
  
  setup(props, { emit }) {
    // Refs
    const dropdownRef = ref(null)
    const searchInput = ref(null)
    const isOpen = ref(false)
    const searchQuery = ref('')
    const highlightedIndex = ref(-1)
    
    // Computed
    const selectedAdmin = computed(() => {
      if (!props.modelValue) return null
      
      if (typeof props.modelValue === 'object') {
        return props.modelValue
      }
      
      return props.admins.find(admin => admin.id === props.modelValue)
    })
    
    const filteredAdmins = computed(() => {
      let filtered = props.admins || []
      
      // Apply search filter
      if (searchQuery.value.trim()) {
        const query = searchQuery.value.toLowerCase().trim()
        filtered = filtered.filter(admin => 
          admin.name.toLowerCase().includes(query) ||
          (admin.email && admin.email.toLowerCase().includes(query)) ||
          (admin.department && admin.department.toLowerCase().includes(query))
        )
      }
      
      // Sort by availability and capacity
      return filtered.sort((a, b) => {
        // Available admins first
        if (a.is_available && !b.is_available) return -1
        if (!a.is_available && b.is_available) return 1
        
        // Then by capacity utilization (lower first)
        const aUtil = a.capacity_info?.utilization || 0
        const bUtil = b.capacity_info?.utilization || 0
        
        return aUtil - bUtil
      })
    })
    
    const dropdownPosition = computed(() => {
      // Calculate if dropdown should open upward
      const rect = dropdownRef.value?.getBoundingClientRect()
      if (!rect) return 'top-full'
      
      const spaceBelow = window.innerHeight - rect.bottom
      const spaceAbove = rect.top
      
      return spaceBelow < 320 && spaceAbove > spaceBelow ? 'bottom-full mb-1' : 'top-full'
    })
    
    // Methods
    const toggleDropdown = () => {
      if (props.disabled || props.loading) return
      
      isOpen.value = !isOpen.value
      
      if (isOpen.value) {
        nextTick(() => {
          searchInput.value?.focus()
        })
      }
    }
    
    const closeDropdown = () => {
      isOpen.value = false
      searchQuery.value = ''
      highlightedIndex.value = -1
    }
    
    const selectAdmin = (admin) => {
      emit('update:modelValue', admin)
      emit('select', admin)
      closeDropdown()
    }
    
    const selectFirstAdmin = () => {
      if (filteredAdmins.value.length > 0) {
        selectAdmin(filteredAdmins.value[0])
      }
    }
    
    const highlightNext = () => {
      highlightedIndex.value = Math.min(
        highlightedIndex.value + 1,
        filteredAdmins.value.length - 1
      )
    }
    
    const highlightPrevious = () => {
      highlightedIndex.value = Math.max(highlightedIndex.value - 1, -1)
    }
    
    const refreshAdmins = () => {
      emit('refresh')
    }
    
    const getInitials = (name) => {
      if (!name) return 'A'
      return name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase()
    }
    
    const getStatusText = (admin) => {
      if (admin.is_offline) return 'Çevrimdışı'
      if (admin.is_available) return 'Müsait'
      if (admin.is_busy) return 'Meşgul'
      return 'Müsait Değil'
    }
    
    // Handle clicks outside
    const handleClickOutside = (event) => {
      if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        closeDropdown()
      }
    }
    
    // Handle keyboard shortcuts
    const handleKeydown = (event) => {
      if (!isOpen.value) return
      
      switch (event.key) {
        case 'Enter':
          if (highlightedIndex.value >= 0 && filteredAdmins.value[highlightedIndex.value]) {
            selectAdmin(filteredAdmins.value[highlightedIndex.value])
          }
          break
          
        case 'Escape':
          closeDropdown()
          break
      }
    }
    
    // Watchers
    watch(searchQuery, (newValue) => {
      emit('search', newValue)
      highlightedIndex.value = -1
    })
    
    watch(isOpen, (newValue) => {
      if (newValue) {
        document.addEventListener('click', handleClickOutside)
        document.addEventListener('keydown', handleKeydown)
      } else {
        document.removeEventListener('click', handleClickOutside)
        document.removeEventListener('keydown', handleKeydown)
      }
    })
    
    // Lifecycle
    onMounted(() => {
      // Any initialization logic
    })
    
    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside)
      document.removeEventListener('keydown', handleKeydown)
    })
    
    return {
      dropdownRef,
      searchInput,
      isOpen,
      searchQuery,
      highlightedIndex,
      selectedAdmin,
      filteredAdmins,
      dropdownPosition,
      toggleDropdown,
      closeDropdown,
      selectAdmin,
      selectFirstAdmin,
      highlightNext,
      highlightPrevious,
      refreshAdmins,
      getInitials,
      getStatusText
    }
  }
}
</script>

<style scoped>
.admin-dropdown {
  @apply relative inline-block w-full;
}

.admin-dropdown-trigger:focus {
  @apply outline-none ring-2 ring-blue-500 border-blue-500;
}

.admin-dropdown-panel {
  /* Custom scrollbar for webkit browsers */
  scrollbar-width: thin;
  scrollbar-color: #cbd5e0 #f7fafc;
}

.admin-dropdown-panel::-webkit-scrollbar {
  width: 4px;
}

.admin-dropdown-panel::-webkit-scrollbar-track {
  background: #f7fafc;
}

.admin-dropdown-panel::-webkit-scrollbar-thumb {
  background: #cbd5e0;
  border-radius: 2px;
}

.admin-dropdown-panel::-webkit-scrollbar-thumb:hover {
  background: #a0aec0;
}

.rotate-180 {
  transform: rotate(180deg);
}
</style>