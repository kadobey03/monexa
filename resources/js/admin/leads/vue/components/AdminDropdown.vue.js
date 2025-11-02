// AdminDropdown Vue Component - Compiled for Browser
window.AdminDropdown = {
  name: 'AdminDropdown',
  
  props: {
    modelValue: {
      type: [Object, Number, null],
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
    
    allowClear: {
      type: Boolean,
      default: true
    },
    
    showCapacity: {
      type: Boolean,
      default: true
    },
    
    showStatus: {
      type: Boolean,
      default: true
    },
    
    searchable: {
      type: Boolean,
      default: true
    },
    
    size: {
      type: String,
      default: 'medium',
      validator: value => ['small', 'medium', 'large'].includes(value)
    }
  },
  
  emits: ['update:modelValue', 'select', 'search'],
  
  template: `
    <div class="admin-dropdown relative" ref="dropdownRef">
      <!-- Trigger Button -->
      <button
        @click="toggleDropdown"
        :disabled="disabled || loading"
        class="admin-dropdown-trigger"
        :class="{
          'opacity-50 cursor-not-allowed': disabled,
          'is-open': isOpen,
          'text-sm px-3 py-2': size === 'small',
          'text-sm px-3 py-2': size === 'medium', 
          'text-base px-4 py-3': size === 'large'
        }"
      >
        <span class="flex items-center min-w-0 flex-1">
          <img
            v-if="selectedAdmin && selectedAdmin.avatar"
            :src="selectedAdmin.avatar"
            :alt="selectedAdmin.name"
            class="w-6 h-6 rounded-full mr-2 flex-shrink-0"
          />
          <div
            v-else-if="selectedAdmin"
            class="w-6 h-6 rounded-full mr-2 flex-shrink-0 bg-gray-300 flex items-center justify-center"
          >
            <span class="text-xs font-semibold text-gray-600">
              {{ selectedAdmin.name?.charAt(0)?.toUpperCase() }}
            </span>
          </div>
          
          <span v-if="selectedAdmin" class="truncate">
            {{ selectedAdmin.name }}
            <span v-if="selectedAdmin.department" class="text-xs text-gray-500 ml-1">
              ({{ selectedAdmin.department.name }})
            </span>
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
          class="admin-dropdown-panel"
          :class="dropdownPosition"
        >
          <!-- Search Input -->
          <div v-if="searchable" class="p-3 border-b border-gray-200">
            <div class="relative">
              <input
                v-model="searchQuery"
                ref="searchInput"
                type="text"
                placeholder="Admin ara..."
                class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                @keydown.escape="closeDropdown"
                @keydown.enter.prevent="selectFirstAdmin"
              />
              <i class="fas fa-search absolute left-2.5 top-1/2 transform -translate-y-1/2 w-3 h-3 text-gray-400"></i>
            </div>
          </div>

          <!-- Loading State -->
          <div v-if="loading" class="p-4 text-center">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mx-auto"></div>
            <p class="text-sm text-gray-500 mt-2">Adminler yükleniyor...</p>
          </div>

          <!-- Admin List -->
          <div v-else-if="filteredAdmins.length > 0" class="max-h-64 overflow-y-auto custom-scrollbar">
            <div
              v-for="admin in filteredAdmins"
              :key="admin.id"
              @click="selectAdmin(admin)"
              class="admin-option"
              :class="{
                'selected': selectedAdmin && selectedAdmin.id === admin.id
              }"
            >
              <!-- Avatar -->
              <img
                v-if="admin.avatar"
                :src="admin.avatar"
                :alt="admin.name"
                class="admin-avatar"
              />
              <div
                v-else
                class="admin-avatar-fallback"
              >
                <span class="text-sm font-semibold text-gray-600">
                  {{ admin.name?.charAt(0)?.toUpperCase() }}
                </span>
              </div>

              <!-- Admin Info -->
              <div class="admin-info">
                <div class="admin-name">
                  {{ admin.name }}
                </div>
                <div class="admin-department">
                  {{ admin.department?.name || 'Departman yok' }}
                  <span v-if="admin.email" class="ml-1">• {{ admin.email }}</span>
                </div>
              </div>

              <!-- Status & Capacity -->
              <div class="flex-shrink-0 ml-2 text-right">
                <!-- Availability Status -->
                <div v-if="showStatus" class="admin-status mb-1">
                  <span 
                    class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium"
                    :class="{
                      'bg-green-100 text-green-800': admin.is_available && admin.is_online,
                      'bg-yellow-100 text-yellow-800': admin.is_available && !admin.is_online,
                      'bg-red-100 text-red-800': !admin.is_available
                    }"
                  >
                    {{ getStatusText(admin) }}
                  </span>
                </div>

                <!-- Capacity Bar -->
                <div v-if="showCapacity && admin.capacity_percentage !== undefined" class="capacity-bar">
                  <div 
                    class="capacity-fill"
                    :class="{
                      'capacity-low': admin.capacity_percentage < 70,
                      'capacity-medium': admin.capacity_percentage >= 70 && admin.capacity_percentage < 90,
                      'capacity-high': admin.capacity_percentage >= 90
                    }"
                    :style="{ width: admin.capacity_percentage + '%' }"
                  ></div>
                </div>
                
                <!-- Capacity Text -->
                <div v-if="showCapacity" class="text-xs text-gray-500 mt-0.5">
                  {{ admin.current_leads || 0 }}/{{ admin.max_leads || 'Sınırsız' }}
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
              {{ searchQuery ? 'Admin bulunamadı' : 'Uygun admin yok' }}
            </p>
          </div>

          <!-- Clear Option -->
          <div v-if="allowClear && selectedAdmin" class="border-t border-gray-200">
            <button
              @click="selectAdmin(null)"
              class="w-full flex items-center px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 transition-colors duration-150 text-left"
            >
              <i class="fas fa-times-circle w-4 h-4 mr-3 text-gray-400"></i>
              Atamayı Temizle
            </button>
          </div>

          <!-- Admin Statistics -->
          <div v-if="adminStats" class="border-t border-gray-200 p-2 bg-gray-50">
            <div class="flex justify-between text-xs text-gray-500">
              <span>{{ filteredAdmins.length }} admin</span>
              <span>{{ adminStats.available || 0 }} uygun</span>
            </div>
          </div>
        </div>
      </Transition>
    </div>
  `,
  
  setup(props, { emit }) {
    const { ref, computed, watch, onMounted, onUnmounted, nextTick } = Vue;
    
    // Refs
    const dropdownRef = ref(null);
    const searchInput = ref(null);
    const isOpen = ref(false);
    const searchQuery = ref('');
    
    // Computed
    const selectedAdmin = computed(() => {
      if (!props.modelValue) return null;
      
      if (typeof props.modelValue === 'object') {
        return props.modelValue;
      }
      
      // Find by ID
      return props.admins.find(admin => admin.id === props.modelValue);
    });
    
    const filteredAdmins = computed(() => {
      let filtered = props.admins || [];
      
      // Apply search filter
      if (searchQuery.value.trim()) {
        const query = searchQuery.value.toLowerCase().trim();
        filtered = filtered.filter(admin => 
          (admin.name && admin.name.toLowerCase().includes(query)) ||
          (admin.email && admin.email.toLowerCase().includes(query)) ||
          (admin.department?.name && admin.department.name.toLowerCase().includes(query))
        );
      }
      
      // Sort by availability and capacity
      return filtered.sort((a, b) => {
        // Available admins first
        if (a.is_available !== b.is_available) {
          return b.is_available - a.is_available;
        }
        
        // Online admins first among available
        if (a.is_online !== b.is_online) {
          return b.is_online - a.is_online;
        }
        
        // Lower capacity first
        const aCapacity = a.capacity_percentage || 0;
        const bCapacity = b.capacity_percentage || 0;
        return aCapacity - bCapacity;
      });
    });
    
    const dropdownPosition = computed(() => {
      const rect = dropdownRef.value?.getBoundingClientRect();
      if (!rect) return 'top-full';
      
      const spaceBelow = window.innerHeight - rect.bottom;
      const spaceAbove = rect.top;
      
      return spaceBelow < 300 && spaceAbove > spaceBelow ? 'position-up' : 'top-full';
    });
    
    const adminStats = computed(() => {
      const stats = {
        total: props.admins.length,
        available: 0,
        online: 0
      };
      
      props.admins.forEach(admin => {
        if (admin.is_available) stats.available++;
        if (admin.is_online) stats.online++;
      });
      
      return stats;
    });
    
    // Methods
    const toggleDropdown = () => {
      if (props.disabled || props.loading) return;
      
      isOpen.value = !isOpen.value;
      
      if (isOpen.value && props.searchable) {
        nextTick(() => {
          searchInput.value?.focus();
        });
      }
    };
    
    const closeDropdown = () => {
      isOpen.value = false;
      searchQuery.value = '';
    };
    
    const selectAdmin = (admin) => {
      emit('update:modelValue', admin?.id || admin);
      emit('select', admin);
      closeDropdown();
    };
    
    const selectFirstAdmin = () => {
      if (filteredAdmins.value.length > 0) {
        selectAdmin(filteredAdmins.value[0]);
      }
    };
    
    const getStatusText = (admin) => {
      if (!admin.is_available) return 'Müsait Değil';
      if (admin.is_online) return 'Çevrimiçi';
      return 'Çevrimdışı';
    };
    
    // Handle clicks outside
    const handleClickOutside = (event) => {
      if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        closeDropdown();
      }
    };
    
    // Watchers
    watch(searchQuery, (newValue) => {
      emit('search', newValue);
    });
    
    watch(isOpen, (newValue) => {
      if (newValue) {
        document.addEventListener('click', handleClickOutside);
      } else {
        document.removeEventListener('click', handleClickOutside);
      }
    });
    
    // Lifecycle
    onMounted(() => {
      // Any initialization
    });
    
    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside);
    });
    
    return {
      dropdownRef,
      searchInput,
      isOpen,
      searchQuery,
      selectedAdmin,
      filteredAdmins,
      dropdownPosition,
      adminStats,
      toggleDropdown,
      closeDropdown,
      selectAdmin,
      selectFirstAdmin,
      getStatusText
    };
  }
};