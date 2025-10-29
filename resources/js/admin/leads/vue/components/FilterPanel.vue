<template>
  <div class="filter-panel bg-white border border-gray-200 rounded-lg shadow-sm">
    <!-- Filter Header -->
    <div class="filter-header flex items-center justify-between p-4 border-b border-gray-200">
      <div class="flex items-center space-x-3">
        <i class="fas fa-filter text-gray-500"></i>
        <h3 class="text-lg font-semibold text-gray-900">Filtreler</h3>
        <span 
          v-if="activeFilterCount > 0"
          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
        >
          {{ activeFilterCount }} aktif filtre
        </span>
      </div>
      
      <div class="flex items-center space-x-2">
        <!-- Quick Actions -->
        <button
          v-if="activeFilterCount > 0"
          @click="clearAllFilters"
          class="text-sm text-gray-600 hover:text-gray-900 underline"
        >
          Tümünü Temizle
        </button>
        
        <!-- Toggle Collapse -->
        <button
          @click="toggleCollapsed"
          class="p-2 text-gray-400 hover:text-gray-600 rounded-md hover:bg-gray-100"
        >
          <i 
            class="fas fa-chevron-up transition-transform duration-200"
            :class="{ 'rotate-180': isCollapsed }"
          ></i>
        </button>
      </div>
    </div>

    <!-- Filter Content -->
    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 max-h-0"
      enter-to-class="opacity-100 max-h-screen"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 max-h-screen"
      leave-to-class="opacity-0 max-h-0"
    >
      <div v-if="!isCollapsed" class="filter-content overflow-hidden">
        <div class="p-4 space-y-6">
          <!-- Search Filter -->
          <div class="filter-group">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Arama
            </label>
            <div class="relative">
              <input
                v-model="localFilters.search"
                type="text"
                placeholder="İsim, email veya telefon numarasına göre ara..."
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                @input="debouncedSearch"
              />
              <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
              <button
                v-if="localFilters.search"
                @click="clearSearch"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
              >
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>

          <!-- Date Range Filter -->
          <div class="filter-group">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Tarih Aralığı
            </label>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <input
                  v-model="localFilters.date_from"
                  type="date"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
                <span class="text-xs text-gray-500 mt-1">Başlangıç</span>
              </div>
              <div>
                <input
                  v-model="localFilters.date_to"
                  type="date"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
                <span class="text-xs text-gray-500 mt-1">Bitiş</span>
              </div>
            </div>
          </div>

          <!-- Status Filter -->
          <div class="filter-group">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Durum
            </label>
            <div class="space-y-2">
              <div
                v-for="status in availableStatuses"
                :key="status.id || status.name"
                class="flex items-center"
              >
                <input
                  :id="`status-${status.name}`"
                  v-model="localFilters.statuses"
                  :value="status.name"
                  type="checkbox"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label
                  :for="`status-${status.name}`"
                  class="ml-2 flex items-center cursor-pointer"
                >
                  <span 
                    class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full mr-2"
                    :style="getStatusStyle(status)"
                  >
                    {{ status.display_name || status.name }}
                  </span>
                  <span class="text-sm text-gray-700">
                    {{ status.display_name || status.name }}
                  </span>
                  <span 
                    v-if="status.count !== undefined"
                    class="ml-1 text-xs text-gray-500"
                  >
                    ({{ status.count }})
                  </span>
                </label>
              </div>
            </div>
          </div>

          <!-- Assigned Admin Filter -->
          <div class="filter-group">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Atanan Admin
            </label>
            <select
              v-model="localFilters.assigned_admin"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">Tüm Adminler</option>
              <option value="unassigned">Atanmamış</option>
              <option
                v-for="admin in availableAdmins"
                :key="admin.id"
                :value="admin.id"
              >
                {{ admin.name }} ({{ admin.department?.name || 'Departman yok' }})
              </option>
            </select>
          </div>

          <!-- Source Filter -->
          <div class="filter-group">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Kaynak
            </label>
            <div class="space-y-2">
              <div
                v-for="source in availableSources"
                :key="source.id || source.name"
                class="flex items-center"
              >
                <input
                  :id="`source-${source.name}`"
                  v-model="localFilters.sources"
                  :value="source.name"
                  type="checkbox"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label
                  :for="`source-${source.name}`"
                  class="ml-2 text-sm text-gray-700 cursor-pointer"
                >
                  {{ source.display_name || source.name }}
                  <span 
                    v-if="source.count !== undefined"
                    class="ml-1 text-xs text-gray-500"
                  >
                    ({{ source.count }})
                  </span>
                </label>
              </div>
            </div>
          </div>

          <!-- Priority Filter -->
          <div class="filter-group">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Öncelik
            </label>
            <div class="flex space-x-2">
              <button
                v-for="priority in availablePriorities"
                :key="priority.value"
                @click="togglePriority(priority.value)"
                class="px-3 py-2 text-sm border rounded-lg transition-colors duration-200"
                :class="{
                  'bg-blue-100 border-blue-500 text-blue-700': localFilters.priorities.includes(priority.value),
                  'border-gray-300 text-gray-700 hover:bg-gray-50': !localFilters.priorities.includes(priority.value)
                }"
              >
                {{ priority.label }}
              </button>
            </div>
          </div>

          <!-- Custom Fields Filter (if any) -->
          <div v-if="customFields.length > 0" class="filter-group">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Özel Alanlar
            </label>
            <div class="space-y-3">
              <div
                v-for="field in customFields"
                :key="field.name"
                class="space-y-2"
              >
                <label class="text-sm text-gray-600">{{ field.label }}</label>
                
                <!-- Text Input -->
                <input
                  v-if="field.type === 'text'"
                  v-model="localFilters.custom_fields[field.name]"
                  type="text"
                  :placeholder="`${field.label} filtrele...`"
                  class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
                
                <!-- Select Input -->
                <select
                  v-else-if="field.type === 'select'"
                  v-model="localFilters.custom_fields[field.name]"
                  class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="">Tümü</option>
                  <option
                    v-for="option in field.options"
                    :key="option.value"
                    :value="option.value"
                  >
                    {{ option.label }}
                  </option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- Filter Actions -->
        <div class="filter-actions flex justify-between items-center px-4 py-3 bg-gray-50 border-t border-gray-200 rounded-b-lg">
          <div class="text-sm text-gray-600">
            {{ resultsCount !== null ? `${resultsCount} sonuç bulundu` : '' }}
          </div>
          
          <div class="flex space-x-2">
            <button
              @click="resetFilters"
              class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200"
            >
              Sıfırla
            </button>
            
            <button
              @click="applyFilters"
              :disabled="!hasChanges"
              class="px-4 py-2 text-sm text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
            >
              Filtrele
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script>
import { ref, computed, watch, onMounted } from 'vue'
import { debounce } from 'lodash-es'

export default {
  name: 'FilterPanel',
  
  props: {
    filters: {
      type: Object,
      default: () => ({})
    },
    
    availableStatuses: {
      type: Array,
      default: () => []
    },
    
    availableAdmins: {
      type: Array,
      default: () => []
    },
    
    availableSources: {
      type: Array,
      default: () => []
    },
    
    customFields: {
      type: Array,
      default: () => []
    },
    
    resultsCount: {
      type: Number,
      default: null
    },
    
    loading: {
      type: Boolean,
      default: false
    }
  },
  
  emits: ['update:filters', 'apply-filters', 'reset-filters'],
  
  setup(props, { emit }) {
    // Refs
    const isCollapsed = ref(false)
    const localFilters = ref({
      search: '',
      date_from: '',
      date_to: '',
      statuses: [],
      assigned_admin: '',
      sources: [],
      priorities: [],
      custom_fields: {}
    })
    
    // Available priorities
    const availablePriorities = ref([
      { value: 'high', label: 'Yüksek' },
      { value: 'medium', label: 'Orta' },
      { value: 'low', label: 'Düşük' }
    ])
    
    // Computed
    const activeFilterCount = computed(() => {
      let count = 0
      
      if (localFilters.value.search) count++
      if (localFilters.value.date_from) count++
      if (localFilters.value.date_to) count++
      if (localFilters.value.statuses.length > 0) count++
      if (localFilters.value.assigned_admin) count++
      if (localFilters.value.sources.length > 0) count++
      if (localFilters.value.priorities.length > 0) count++
      
      // Count custom fields
      Object.values(localFilters.value.custom_fields).forEach(value => {
        if (value && value !== '') count++
      })
      
      return count
    })
    
    const hasChanges = computed(() => {
      return JSON.stringify(localFilters.value) !== JSON.stringify(props.filters)
    })
    
    // Methods
    const toggleCollapsed = () => {
      isCollapsed.value = !isCollapsed.value
    }
    
    const togglePriority = (priority) => {
      const index = localFilters.value.priorities.indexOf(priority)
      if (index > -1) {
        localFilters.value.priorities.splice(index, 1)
      } else {
        localFilters.value.priorities.push(priority)
      }
    }
    
    const clearSearch = () => {
      localFilters.value.search = ''
      debouncedSearch()
    }
    
    const clearAllFilters = () => {
      resetFilters()
      applyFilters()
    }
    
    const resetFilters = () => {
      localFilters.value = {
        search: '',
        date_from: '',
        date_to: '',
        statuses: [],
        assigned_admin: '',
        sources: [],
        priorities: [],
        custom_fields: {}
      }
    }
    
    const applyFilters = () => {
      emit('update:filters', { ...localFilters.value })
      emit('apply-filters', { ...localFilters.value })
    }
    
    const getStatusStyle = (status) => {
      return {
        color: 'white',
        backgroundColor: status.color || '#6B7280'
      }
    }
    
    // Debounced search
    const debouncedSearch = debounce(() => {
      applyFilters()
    }, 500)
    
    // Initialize filters from props
    const initializeFilters = () => {
      if (props.filters) {
        localFilters.value = {
          search: props.filters.search || '',
          date_from: props.filters.date_from || '',
          date_to: props.filters.date_to || '',
          statuses: props.filters.statuses || [],
          assigned_admin: props.filters.assigned_admin || '',
          sources: props.filters.sources || [],
          priorities: props.filters.priorities || [],
          custom_fields: props.filters.custom_fields || {}
        }
      }
    }
    
    // Watchers
    watch(() => props.filters, initializeFilters, { deep: true })
    
    // Lifecycle
    onMounted(() => {
      initializeFilters()
    })
    
    return {
      isCollapsed,
      localFilters,
      availablePriorities,
      activeFilterCount,
      hasChanges,
      toggleCollapsed,
      togglePriority,
      clearSearch,
      clearAllFilters,
      resetFilters,
      applyFilters,
      getStatusStyle,
      debouncedSearch
    }
  }
}
</script>

<style scoped>
.filter-panel {
  @apply w-full;
}

.rotate-180 {
  transform: rotate(180deg);
}

/* Custom transitions */
.filter-content {
  transition: max-height 0.3s ease-in-out;
}

/* Custom scrollbar for long filter lists */
.filter-group {
  max-height: 200px;
  overflow-y: auto;
  scrollbar-width: thin;
  scrollbar-color: #cbd5e0 #f7fafc;
}

.filter-group::-webkit-scrollbar {
  width: 4px;
}

.filter-group::-webkit-scrollbar-track {
  background: #f7fafc;
}

.filter-group::-webkit-scrollbar-thumb {
  background: #cbd5e0;
  border-radius: 2px;
}

.filter-group::-webkit-scrollbar-thumb:hover {
  background: #a0aec0;
}
</style>