// LeadAssignmentTable Vue Component - Compiled for Browser
window.LeadAssignmentTable = {
  name: 'LeadAssignmentTable',
  
  props: {
    leads: {
      type: Array,
      default: () => []
    },
    
    columns: {
      type: Array,
      default: () => []
    },
    
    loading: {
      type: Boolean,
      default: false
    },
    
    pagination: {
      type: Object,
      default: () => ({
        current_page: 1,
        per_page: 25,
        total: 0,
        last_page: 1
      })
    },
    
    sortBy: {
      type: String,
      default: 'created_at'
    },
    
    sortDirection: {
      type: String,
      default: 'desc'
    },
    
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
    }
  },
  
  emits: [
    'select-lead',
    'select-all',
    'sort',
    'change-page',
    'assign-lead',
    'change-status',
    'toggle-column'
  ],
  
  template: `
    <div class="lead-assignment-table">
      <!-- Table Controls -->
      <div class="table-controls flex items-center justify-between p-4 bg-white border-b border-gray-200">
        <div class="flex items-center space-x-4">
          <!-- Results Count -->
          <div class="text-sm text-gray-700">
            {{ leads.length > 0 ? \`\${pagination.total} sonuçtan \${startIndex}-\${endIndex} arası gösteriliyor\` : 'Sonuç bulunamadı' }}
          </div>
          
          <!-- Loading Indicator -->
          <div v-if="loading" class="flex items-center text-sm text-gray-500">
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600 mr-2"></div>
            Yükleniyor...
          </div>
        </div>
        
        <div class="flex items-center space-x-2">
          <!-- Column Visibility Toggle -->
          <div class="relative" ref="columnToggleRef">
            <button
              @click="showColumnToggle = !showColumnToggle"
              class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
            >
              <i class="fas fa-columns w-4 h-4 mr-2"></i>
              Sütunlar
            </button>
            
            <!-- Column Toggle Dropdown -->
            <Transition
              enter-active-class="transition ease-out duration-200"
              enter-from-class="opacity-0 translate-y-1"
              enter-to-class="opacity-100 translate-y-0"
              leave-active-class="transition ease-in duration-150"
              leave-from-class="opacity-100 translate-y-0"
              leave-to-class="opacity-0 translate-y-1"
            >
              <div
                v-if="showColumnToggle"
                class="absolute right-0 z-10 mt-2 w-56 bg-white border border-gray-300 rounded-lg shadow-lg"
              >
                <div class="p-3">
                  <h4 class="text-sm font-medium text-gray-900 mb-3">Görünür Sütunlar</h4>
                  <div class="space-y-2">
                    <label
                      v-for="column in availableColumns"
                      :key="column.key"
                      class="flex items-center cursor-pointer"
                    >
                      <input
                        :checked="columns.includes(column.key)"
                        @change="toggleColumn(column.key)"
                        type="checkbox"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2"
                      />
                      <span class="text-sm text-gray-700">{{ column.label }}</span>
                    </label>
                  </div>
                </div>
              </div>
            </Transition>
          </div>
          
          <!-- Per Page Selector -->
          <select
            :value="pagination.per_page"
            @change="changePerPage($event.target.value)"
            class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="10">10 / sayfa</option>
            <option value="25">25 / sayfa</option>
            <option value="50">50 / sayfa</option>
            <option value="100">100 / sayfa</option>
          </select>
        </div>
      </div>

      <!-- Table Container -->
      <div class="table-container bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <!-- Loading Overlay -->
        <div v-if="loading" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
          <div class="text-center">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-2"></div>
            <p class="text-sm text-gray-600">Yükleniyor...</p>
          </div>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <!-- Table Header -->
            <thead class="table-header">
              <tr>
                <!-- Checkbox Header -->
                <th v-if="columns.includes('checkbox')" scope="col" class="px-6 py-3 text-left">
                  <input
                    :checked="allSelected"
                    :indeterminate="someSelected"
                    @change="toggleSelectAll"
                    type="checkbox"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                  />
                </th>

                <!-- Sortable Headers -->
                <th
                  v-for="column in visibleHeaderColumns"
                  :key="column.key"
                  scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  :class="{
                    'cursor-pointer hover:bg-gray-100 sortable': column.sortable
                  }"
                  @click="column.sortable && handleSort(column.key)"
                >
                  <div class="flex items-center">
                    {{ column.label }}
                    
                    <!-- Sort Indicator -->
                    <span 
                      v-if="column.sortable"
                      class="sort-indicator ml-1"
                      :class="{
                        'active': sortBy === column.key,
                        'text-blue-600': sortBy === column.key
                      }"
                    >
                      <i 
                        class="fas"
                        :class="{
                          'fa-sort': sortBy !== column.key,
                          'fa-sort-up': sortBy === column.key && sortDirection === 'asc',
                          'fa-sort-down': sortBy === column.key && sortDirection === 'desc'
                        }"
                      ></i>
                    </span>
                  </div>
                </th>
              </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="table-body bg-white divide-y divide-gray-200">
              <!-- Lead Rows -->
              <LeadAssignmentRow
                v-for="lead in leads"
                :key="lead.id"
                :lead="lead"
                :selected="isLeadSelected(lead)"
                :visible-columns="columns"
                :available-admins="availableAdmins"
                :available-statuses="availableStatuses"
                :loading="loading"
                @select="handleLeadSelect"
                @assign-admin="handleAssignAdmin"
                @change-status="handleChangeStatus"
                @call-lead="handleCallLead"
                @email-lead="handleEmailLead"
                @edit-lead="handleEditLead"
                @view-lead="handleViewLead"
              />

              <!-- Empty State -->
              <tr v-if="leads.length === 0 && !loading">
                <td :colspan="visibleColumnCount" class="px-6 py-12 text-center">
                  <div class="text-center">
                    <i class="fas fa-inbox w-12 h-12 text-gray-300 mx-auto mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Lead bulunamadı</h3>
                    <p class="text-gray-500 mb-4">Arama kriterlerinizi değiştirmeyi deneyin.</p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.last_page > 1" class="pagination bg-white px-6 py-3 border-t border-gray-200">
        <div class="flex items-center justify-between">
          <!-- Pagination Info -->
          <div class="pagination-info">
            <span class="text-sm text-gray-700">
              Sayfa {{ pagination.current_page }} / {{ pagination.last_page }}
            </span>
          </div>

          <!-- Pagination Controls -->
          <div class="pagination-controls flex items-center space-x-2">
            <!-- First Page -->
            <button
              @click="goToPage(1)"
              :disabled="pagination.current_page === 1"
              class="pagination-button"
              title="İlk Sayfa"
            >
              <i class="fas fa-angle-double-left"></i>
            </button>

            <!-- Previous Page -->
            <button
              @click="goToPage(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="pagination-button"
              title="Önceki"
            >
              <i class="fas fa-angle-left"></i>
            </button>

            <!-- Page Numbers -->
            <button
              v-for="page in visiblePages"
              :key="page"
              @click="goToPage(page)"
              class="pagination-button"
              :class="{ 'active': page === pagination.current_page }"
            >
              {{ page }}
            </button>

            <!-- Next Page -->
            <button
              @click="goToPage(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="pagination-button"
              title="Sonraki"
            >
              <i class="fas fa-angle-right"></i>
            </button>

            <!-- Last Page -->
            <button
              @click="goToPage(pagination.last_page)"
              :disabled="pagination.current_page === pagination.last_page"
              class="pagination-button"
              title="Son Sayfa"
            >
              <i class="fas fa-angle-double-right"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  `,
  
  setup(props, { emit }) {
    const { ref, computed, onMounted, onUnmounted } = Vue;
    
    // Refs
    const columnToggleRef = ref(null);
    const showColumnToggle = ref(false);
    
    // Available columns configuration
    const availableColumns = [
      { key: 'checkbox', label: 'Seçim', sortable: false },
      { key: 'name', label: 'İsim', sortable: true },
      { key: 'email', label: 'Email', sortable: true },
      { key: 'phone', label: 'Telefon', sortable: false },
      { key: 'status', label: 'Durum', sortable: true },
      { key: 'assigned_admin', label: 'Atanan Admin', sortable: true },
      { key: 'source', label: 'Kaynak', sortable: true },
      { key: 'priority', label: 'Öncelik', sortable: true },
      { key: 'created_at', label: 'Oluşturma Tarihi', sortable: true },
      { key: 'last_activity', label: 'Son Aktivite', sortable: true },
      { key: 'score', label: 'Skor', sortable: true },
      { key: 'tags', label: 'Etiketler', sortable: false },
      { key: 'actions', label: 'İşlemler', sortable: false }
    ];
    
    // Computed Properties
    const allSelected = computed(() => {
      return props.leads.length > 0 && props.selectedLeads.length === props.leads.length;
    });
    
    const someSelected = computed(() => {
      return props.selectedLeads.length > 0 && props.selectedLeads.length < props.leads.length;
    });
    
    const visibleHeaderColumns = computed(() => {
      return availableColumns.filter(column => 
        props.columns.includes(column.key) && column.key !== 'checkbox'
      );
    });
    
    const visibleColumnCount = computed(() => {
      return props.columns.length;
    });
    
    const startIndex = computed(() => {
      return ((props.pagination.current_page - 1) * props.pagination.per_page) + 1;
    });
    
    const endIndex = computed(() => {
      const end = props.pagination.current_page * props.pagination.per_page;
      return Math.min(end, props.pagination.total);
    });
    
    const visiblePages = computed(() => {
      const current = props.pagination.current_page;
      const last = props.pagination.last_page;
      const delta = 2;
      
      const range = [];
      const start = Math.max(1, current - delta);
      const end = Math.min(last, current + delta);
      
      for (let i = start; i <= end; i++) {
        range.push(i);
      }
      
      return range;
    });
    
    // Methods
    const isLeadSelected = (lead) => {
      return props.selectedLeads.some(selected => selected.id === lead.id);
    };
    
    const handleLeadSelect = (lead) => {
      emit('select-lead', lead);
    };
    
    const toggleSelectAll = () => {
      emit('select-all');
    };
    
    const handleSort = (column) => {
      const newDirection = props.sortBy === column && props.sortDirection === 'asc' ? 'desc' : 'asc';
      emit('sort', { column, direction: newDirection });
    };
    
    const goToPage = (page) => {
      if (page >= 1 && page <= props.pagination.last_page) {
        emit('change-page', page);
      }
    };
    
    const changePerPage = (perPage) => {
      // This would typically emit an event to change per_page and reload
      emit('change-page', 1); // Reset to first page when changing per page
    };
    
    const toggleColumn = (columnKey) => {
      emit('toggle-column', columnKey);
    };
    
    const handleAssignAdmin = (data) => {
      emit('assign-lead', data);
    };
    
    const handleChangeStatus = (data) => {
      emit('change-status', data);
    };
    
    const handleCallLead = (lead) => {
      // Open phone dialer or phone system integration
      if (lead.phone) {
        window.location.href = `tel:${lead.phone}`;
      }
    };
    
    const handleEmailLead = (lead) => {
      // Open email client or email modal
      if (lead.email) {
        window.location.href = `mailto:${lead.email}`;
      }
    };
    
    const handleEditLead = (lead) => {
      // TODO: Open edit modal or navigate to edit page
      console.log('Edit lead:', lead);
    };
    
    const handleViewLead = (lead) => {
      // TODO: Open view modal or navigate to view page
      console.log('View lead:', lead);
    };
    
    // Handle clicks outside column toggle
    const handleClickOutside = (event) => {
      if (columnToggleRef.value && !columnToggleRef.value.contains(event.target)) {
        showColumnToggle.value = false;
      }
    };
    
    // Lifecycle
    onMounted(() => {
      document.addEventListener('click', handleClickOutside);
    });
    
    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside);
    });
    
    return {
      columnToggleRef,
      showColumnToggle,
      availableColumns,
      allSelected,
      someSelected,
      visibleHeaderColumns,
      visibleColumnCount,
      startIndex,
      endIndex,
      visiblePages,
      isLeadSelected,
      handleLeadSelect,
      toggleSelectAll,
      handleSort,
      goToPage,
      changePerPage,
      toggleColumn,
      handleAssignAdmin,
      handleChangeStatus,
      handleCallLead,
      handleEmailLead,
      handleEditLead,
      handleViewLead
    };
  }
};