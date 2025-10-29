// LeadAssignmentRow Vue Component - Compiled for Browser
window.LeadAssignmentRow = {
  name: 'LeadAssignmentRow',
  
  props: {
    lead: {
      type: Object,
      required: true
    },
    
    selected: {
      type: Boolean,
      default: false
    },
    
    visibleColumns: {
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
    
    loading: {
      type: Boolean,
      default: false
    }
  },
  
  emits: [
    'select',
    'assign-admin',
    'change-status',
    'call-lead',
    'email-lead',
    'edit-lead',
    'view-lead'
  ],
  
  template: `
    <tr 
      class="lead-row"
      :class="{
        'selected': selected,
        'opacity-50': loading
      }"
    >
      <!-- Checkbox Column -->
      <td v-if="visibleColumns.includes('checkbox')" class="table-cell">
        <input
          :checked="selected"
          @change="toggleSelection"
          type="checkbox"
          class="lead-checkbox"
          :disabled="loading"
        />
      </td>

      <!-- Lead Name Column -->
      <td v-if="visibleColumns.includes('name')" class="table-cell">
        <div class="flex items-center">
          <div class="flex-shrink-0 w-10 h-10">
            <img
              v-if="lead.avatar"
              :src="lead.avatar"
              :alt="lead.first_name + ' ' + lead.last_name"
              class="w-10 h-10 rounded-full"
            />
            <div
              v-else
              class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center"
            >
              <span class="text-sm font-medium text-gray-700">
                {{ getInitials(lead.first_name, lead.last_name) }}
              </span>
            </div>
          </div>
          <div class="ml-4">
            <div class="lead-name">
              {{ lead.first_name }} {{ lead.last_name }}
            </div>
            <div v-if="lead.company_name" class="text-sm text-gray-500">
              {{ lead.company_name }}
            </div>
          </div>
        </div>
      </td>

      <!-- Email Column -->
      <td v-if="visibleColumns.includes('email')" class="table-cell truncate">
        <div class="lead-email">
          <a 
            v-if="lead.email"
            :href="\`mailto:\${lead.email}\`"
            class="text-blue-600 hover:text-blue-900"
          >
            {{ lead.email }}
          </a>
          <span v-else class="text-gray-400">Email yok</span>
        </div>
      </td>

      <!-- Phone Column -->
      <td v-if="visibleColumns.includes('phone')" class="table-cell">
        <div class="lead-phone">
          <a 
            v-if="lead.phone"
            :href="\`tel:\${lead.phone}\`"
            class="text-blue-600 hover:text-blue-900"
          >
            {{ lead.phone }}
          </a>
          <span v-else class="text-gray-400">Telefon yok</span>
        </div>
      </td>

      <!-- Status Column -->
      <td v-if="visibleColumns.includes('status')" class="table-cell">
        <StatusDropdown
          :model-value="lead.status"
          :statuses="availableStatuses"
          :disabled="loading"
          :allow-clear="false"
          placeholder="Durum seç..."
          @select="handleStatusChange"
        />
      </td>

      <!-- Assigned Admin Column -->
      <td v-if="visibleColumns.includes('assigned_admin')" class="table-cell">
        <AdminDropdown
          :model-value="lead.assigned_admin_id"
          :admins="availableAdmins"
          :disabled="loading"
          :allow-clear="true"
          :show-capacity="true"
          :show-status="true"
          placeholder="Admin ata..."
          @select="handleAdminAssign"
        />
      </td>

      <!-- Source Column -->
      <td v-if="visibleColumns.includes('source')" class="table-cell">
        <span 
          v-if="lead.lead_source"
          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
          :style="getSourceStyle(lead.lead_source)"
        >
          {{ lead.lead_source.display_name || lead.lead_source.name }}
        </span>
        <span v-else class="text-gray-400">Kaynak yok</span>
      </td>

      <!-- Priority Column -->
      <td v-if="visibleColumns.includes('priority')" class="table-cell">
        <span 
          v-if="lead.priority"
          class="priority-indicator"
          :class="{
            'priority-high': lead.priority === 'high',
            'priority-medium': lead.priority === 'medium',
            'priority-low': lead.priority === 'low'
          }"
        >
          {{ getPriorityText(lead.priority) }}
        </span>
        <span v-else class="text-gray-400">Öncelik yok</span>
      </td>

      <!-- Created Date Column -->
      <td v-if="visibleColumns.includes('created_at')" class="table-cell">
        <div class="text-sm text-gray-900">
          {{ formatDate(lead.created_at) }}
        </div>
        <div class="text-sm text-gray-500">
          {{ formatTime(lead.created_at) }}
        </div>
      </td>

      <!-- Last Activity Column -->
      <td v-if="visibleColumns.includes('last_activity')" class="table-cell">
        <div v-if="lead.last_activity_at" class="text-sm">
          <div class="text-gray-900">
            {{ formatDate(lead.last_activity_at) }}
          </div>
          <div class="text-gray-500">
            {{ lead.last_activity_type || 'Aktivite' }}
          </div>
        </div>
        <span v-else class="text-gray-400">Aktivite yok</span>
      </td>

      <!-- Score Column -->
      <td v-if="visibleColumns.includes('score')" class="table-cell">
        <div v-if="lead.score !== undefined" class="flex items-center">
          <div class="flex-1">
            <div class="w-full bg-gray-200 rounded-full h-2">
              <div 
                class="h-2 rounded-full transition-all duration-300"
                :class="{
                  'bg-red-400': lead.score < 30,
                  'bg-yellow-400': lead.score >= 30 && lead.score < 70,
                  'bg-green-400': lead.score >= 70
                }"
                :style="{ width: \`\${Math.max(lead.score, 5)}%\` }"
              ></div>
            </div>
          </div>
          <span class="ml-2 text-sm font-medium text-gray-700">
            {{ Math.round(lead.score) }}
          </span>
        </div>
        <span v-else class="text-gray-400">Skor yok</span>
      </td>

      <!-- Tags Column -->
      <td v-if="visibleColumns.includes('tags')" class="table-cell">
        <div v-if="lead.tags && lead.tags.length > 0" class="flex flex-wrap gap-1">
          <span
            v-for="tag in lead.tags.slice(0, 2)"
            :key="tag.id"
            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
          >
            {{ tag.name }}
          </span>
          <span 
            v-if="lead.tags.length > 2"
            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-600"
          >
            +{{ lead.tags.length - 2 }}
          </span>
        </div>
        <span v-else class="text-gray-400">Tag yok</span>
      </td>

      <!-- Actions Column -->
      <td v-if="visibleColumns.includes('actions')" class="table-cell">
        <div class="lead-actions">
          <!-- Call Button -->
          <button
            v-if="lead.phone"
            @click="callLead"
            class="action-button"
            title="Ara"
            :disabled="loading"
          >
            <i class="fas fa-phone"></i>
          </button>

          <!-- Email Button -->
          <button
            v-if="lead.email"
            @click="emailLead"
            class="action-button"
            title="Email Gönder"
            :disabled="loading"
          >
            <i class="fas fa-envelope"></i>
          </button>

          <!-- Edit Button -->
          <button
            @click="editLead"
            class="action-button"
            title="Düzenle"
            :disabled="loading"
          >
            <i class="fas fa-edit"></i>
          </button>

          <!-- View Button -->
          <button
            @click="viewLead"
            class="action-button"
            title="Detayları Gör"
            :disabled="loading"
          >
            <i class="fas fa-eye"></i>
          </button>

          <!-- More Actions Dropdown -->
          <div class="relative" ref="actionsDropdownRef">
            <button
              @click="toggleActionsDropdown"
              class="action-button"
              title="Diğer İşlemler"
              :disabled="loading"
            >
              <i class="fas fa-ellipsis-v"></i>
            </button>

            <!-- Actions Dropdown Menu -->
            <Transition
              enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <div
                v-if="showActionsDropdown"
                class="absolute right-0 z-10 mt-2 w-48 origin-top-right bg-white border border-gray-300 rounded-md shadow-lg"
              >
                <div class="py-1">
                  <button
                    @click="duplicateLead"
                    class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 text-left"
                  >
                    <i class="fas fa-copy w-4 h-4 mr-3 text-gray-400"></i>
                    Kopyala
                  </button>
                  
                  <button
                    @click="addNote"
                    class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 text-left"
                  >
                    <i class="fas fa-sticky-note w-4 h-4 mr-3 text-gray-400"></i>
                    Not Ekle
                  </button>
                  
                  <button
                    @click="viewHistory"
                    class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 text-left"
                  >
                    <i class="fas fa-history w-4 h-4 mr-3 text-gray-400"></i>
                    Geçmiş
                  </button>
                  
                  <div class="border-t border-gray-200"></div>
                  
                  <button
                    @click="deleteLead"
                    class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 text-left"
                  >
                    <i class="fas fa-trash w-4 h-4 mr-3 text-red-400"></i>
                    Sil
                  </button>
                </div>
              </div>
            </Transition>
          </div>
        </div>
      </td>
    </tr>
  `,
  
  setup(props, { emit }) {
    const { ref, onMounted, onUnmounted } = Vue;
    
    // Refs
    const actionsDropdownRef = ref(null);
    const showActionsDropdown = ref(false);
    
    // Methods
    const toggleSelection = () => {
      emit('select', props.lead);
    };
    
    const handleAdminAssign = (admin) => {
      emit('assign-admin', {
        leadId: props.lead.id,
        adminId: admin?.id || null,
        admin: admin
      });
    };
    
    const handleStatusChange = (status) => {
      emit('change-status', {
        leadId: props.lead.id,
        status: status?.name || status,
        statusData: status
      });
    };
    
    const callLead = () => {
      emit('call-lead', props.lead);
    };
    
    const emailLead = () => {
      emit('email-lead', props.lead);
    };
    
    const editLead = () => {
      emit('edit-lead', props.lead);
      showActionsDropdown.value = false;
    };
    
    const viewLead = () => {
      emit('view-lead', props.lead);
    };
    
    const duplicateLead = () => {
      // TODO: Implement duplicate functionality
      console.log('Duplicate lead:', props.lead);
      showActionsDropdown.value = false;
    };
    
    const addNote = () => {
      // TODO: Implement add note functionality
      console.log('Add note to lead:', props.lead);
      showActionsDropdown.value = false;
    };
    
    const viewHistory = () => {
      // TODO: Implement view history functionality
      console.log('View history for lead:', props.lead);
      showActionsDropdown.value = false;
    };
    
    const deleteLead = () => {
      // TODO: Implement delete confirmation
      if (confirm(\`\${props.lead.first_name} \${props.lead.last_name} adlı lead'i silmek istediğinizden emin misiniz?\`)) {
        console.log('Delete lead:', props.lead);
      }
      showActionsDropdown.value = false;
    };
    
    const toggleActionsDropdown = () => {
      showActionsDropdown.value = !showActionsDropdown.value;
    };
    
    const getInitials = (firstName, lastName) => {
      const first = firstName?.charAt(0)?.toUpperCase() || '';
      const last = lastName?.charAt(0)?.toUpperCase() || '';
      return first + last || '??';
    };
    
    const getPriorityText = (priority) => {
      const map = {
        high: 'Yüksek',
        medium: 'Orta', 
        low: 'Düşük'
      };
      return map[priority] || priority;
    };
    
    const getSourceStyle = (source) => {
      return {
        backgroundColor: source.color || '#6B7280',
        color: 'white'
      };
    };
    
    const formatDate = (dateString) => {
      if (!dateString) return '';
      
      const date = new Date(dateString);
      return date.toLocaleDateString('tr-TR', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });
    };
    
    const formatTime = (dateString) => {
      if (!dateString) return '';
      
      const date = new Date(dateString);
      return date.toLocaleTimeString('tr-TR', {
        hour: '2-digit',
        minute: '2-digit'
      });
    };
    
    // Handle clicks outside
    const handleClickOutside = (event) => {
      if (actionsDropdownRef.value && !actionsDropdownRef.value.contains(event.target)) {
        showActionsDropdown.value = false;
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
      actionsDropdownRef,
      showActionsDropdown,
      toggleSelection,
      handleAdminAssign,
      handleStatusChange,
      callLead,
      emailLead,
      editLead,
      viewLead,
      duplicateLead,
      addNote,
      viewHistory,
      deleteLead,
      toggleActionsDropdown,
      getInitials,
      getPriorityText,
      getSourceStyle,
      formatDate,
      formatTime
    };
  }
};