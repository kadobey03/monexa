<template>
  <tr 
    class="lead-assignment-row hover:bg-gray-50 transition-colors duration-200"
    :class="{ 'bg-blue-50': selected }"
  >
    <!-- Checkbox Column -->
    <td class="px-6 py-4 w-12">
      <input
        type="checkbox"
        :checked="selected"
        @change="$emit('select', lead.id)"
        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
      />
    </td>

    <!-- Dynamic Columns -->
    <td
      v-for="column in visibleColumns"
      :key="column.key"
      class="px-6 py-4"
      :class="getColumnClass(column.key)"
    >
      <!-- Country Column -->
      <template v-if="column.key === 'country'">
        <div class="flex items-center">
          <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
            <i class="fas fa-globe w-3 h-3 mr-1"></i>
            {{ lead.country || 'Belirtilmemiş' }}
          </span>
        </div>
      </template>

      <!-- Name Column -->
      <template v-else-if="column.key === 'name'">
        <div class="flex items-center">
          <div class="flex-shrink-0 h-8 w-8">
            <div 
              class="rounded-full h-8 w-8 flex items-center justify-center text-white text-xs font-medium"
              :style="{ backgroundColor: getAvatarColor(lead.name) }"
            >
              {{ getInitials(lead.name) }}
            </div>
          </div>
          <div class="ml-3">
            <div class="text-sm font-medium text-gray-900">
              {{ lead.name || 'İsimsiz' }}
            </div>
            <div class="text-xs text-gray-500">
              ID: #{{ lead.id }}
            </div>
          </div>
        </div>
      </template>

      <!-- Phone Column -->
      <template v-else-if="column.key === 'phone'">
        <div v-if="lead.phone" class="flex items-center">
          <i class="fas fa-phone w-4 h-4 text-gray-400 mr-2"></i>
          <a 
            :href="`tel:${lead.phone}`"
            class="text-blue-600 hover:text-blue-900 transition-colors"
          >
            {{ lead.phone }}
          </a>
        </div>
        <span v-else class="text-gray-400 italic">Telefon yok</span>
      </template>

      <!-- Email Column -->
      <template v-else-if="column.key === 'email'">
        <div v-if="lead.email" class="flex items-center">
          <i class="fas fa-envelope w-4 h-4 text-gray-400 mr-2"></i>
          <a 
            :href="`mailto:${lead.email}`"
            class="text-blue-600 hover:text-blue-900 transition-colors truncate max-w-xs"
          >
            {{ lead.email }}
          </a>
        </div>
        <span v-else class="text-gray-400 italic">Email yok</span>
      </template>

      <!-- Assignment Column -->
      <template v-else-if="column.key === 'assigned_to'">
        <AdminDropdown
          :model-value="lead.assign_to"
          :admins="leadStore.availableAdmins"
          :loading="assignmentLoading"
          placeholder="Atanmamış"
          @update:model-value="handleAssignmentChange"
          @refresh="leadStore.loadAvailableAdmins"
          class="min-w-[180px]"
        />
      </template>

      <!-- Status Column -->
      <template v-else-if="column.key === 'status'">
        <StatusDropdown
          :model-value="lead.lead_status"
          :statuses="leadStore.leadStatuses"
          :loading="statusLoading"
          @update:model-value="handleStatusChange"
          class="min-w-[120px]"
        />
      </template>

      <!-- Organization Column -->
      <template v-else-if="column.key === 'organization'">
        <div v-if="lead.organization" class="flex items-center">
          <i class="fas fa-building w-4 h-4 text-gray-400 mr-2"></i>
          <span>{{ lead.organization }}</span>
        </div>
        <span v-else class="text-gray-400 italic">Varonka yok</span>
      </template>

      <!-- Source Column -->
      <template v-else-if="column.key === 'source'">
        <span 
          class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
          :class="getSourceBadgeClass(lead.lead_source)"
        >
          {{ getSourceName(lead.lead_source) }}
        </span>
      </template>

      <!-- Company Column -->
      <template v-else-if="column.key === 'company'">
        <div v-if="lead.company_name" class="flex items-center">
          <i class="fas fa-briefcase w-4 h-4 text-gray-400 mr-2"></i>
          <span>{{ lead.company_name }}</span>
        </div>
        <span v-else class="text-gray-400 italic">Şirket yok</span>
      </template>

      <!-- Created At Column -->
      <template v-else-if="column.key === 'created_at'">
        <div class="text-sm text-gray-500">
          <div>{{ formatDate(lead.created_at) }}</div>
          <div class="text-xs">{{ formatTime(lead.created_at) }}</div>
        </div>
      </template>

      <!-- Actions Column -->
      <template v-else-if="column.key === 'actions'">
        <div class="flex items-center space-x-2">
          <button
            @click="$emit('view-details', lead.id)"
            class="text-blue-600 hover:text-blue-900 transition-colors"
            title="Detayları Görüntüle"
          >
            <i class="fas fa-eye w-4 h-4"></i>
          </button>
          
          <button
            v-if="lead.phone"
            @click="callLead(lead.phone)"
            class="text-green-600 hover:text-green-900 transition-colors"
            title="Ara"
          >
            <i class="fas fa-phone w-4 h-4"></i>
          </button>
          
          <button
            v-if="lead.email"
            @click="emailLead(lead.email)"
            class="text-purple-600 hover:text-purple-900 transition-colors"
            title="Email Gönder"
          >
            <i class="fas fa-envelope w-4 h-4"></i>
          </button>
          
          <button
            @click="editLead"
            class="text-yellow-600 hover:text-yellow-900 transition-colors"
            title="Düzenle"
          >
            <i class="fas fa-edit w-4 h-4"></i>
          </button>

          <!-- More Actions Dropdown -->
          <div class="relative" ref="actionsDropdownRef">
            <button
              @click="showActionsMenu = !showActionsMenu"
              class="text-gray-600 hover:text-gray-900 transition-colors"
              title="Daha Fazla"
            >
              <i class="fas fa-ellipsis-v w-4 h-4"></i>
            </button>
            
            <!-- Actions Menu -->
            <div
              v-if="showActionsMenu"
              class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg z-20"
            >
              <div class="py-1">
                <button
                  @click="duplicateLead"
                  class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  <i class="fas fa-copy w-4 h-4 mr-2"></i>
                  Kopyala
                </button>
                
                <button
                  @click="addNote"
                  class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  <i class="fas fa-sticky-note w-4 h-4 mr-2"></i>
                  Not Ekle
                </button>
                
                <button
                  @click="scheduleFollowUp"
                  class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  <i class="fas fa-calendar-plus w-4 h-4 mr-2"></i>
                  Takip Planla
                </button>
                
                <div class="border-t border-gray-200"></div>
                
                <button
                  @click="deleteLead"
                  class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50"
                >
                  <i class="fas fa-trash w-4 h-4 mr-2"></i>
                  Sil
                </button>
              </div>
            </div>
          </div>
        </div>
      </template>
    </td>
  </tr>
</template>

<script>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useLeadStore } from '../stores/leadStore'
import AdminDropdown from './AdminDropdown.vue'
import StatusDropdown from './StatusDropdown.vue'

export default {
  name: 'LeadAssignmentRow',
  
  components: {
    AdminDropdown,
    StatusDropdown
  },
  
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
      required: true
    }
  },
  
  emits: ['select', 'assign', 'update-status', 'view-details'],
  
  setup(props, { emit }) {
    // Store
    const leadStore = useLeadStore()
    
    // Refs
    const actionsDropdownRef = ref(null)
    const showActionsMenu = ref(false)
    const assignmentLoading = ref(false)
    const statusLoading = ref(false)
    
    // Methods
    const handleAssignmentChange = async (adminId) => {
      assignmentLoading.value = true
      
      try {
        await emit('assign', props.lead.id, adminId)
        leadStore.showNotification('Lead başarıyla atandı', 'success')
      } catch (error) {
        leadStore.showNotification('Atama işlemi başarısız', 'error')
        console.error('Assignment error:', error)
      } finally {
        assignmentLoading.value = false
      }
    }
    
    const handleStatusChange = async (status) => {
      statusLoading.value = true
      
      try {
        await emit('update-status', props.lead.id, status)
        leadStore.showNotification('Durum başarıyla güncellendi', 'success')
      } catch (error) {
        leadStore.showNotification('Durum güncellenemedi', 'error')
        console.error('Status update error:', error)
      } finally {
        statusLoading.value = false
      }
    }
    
    const getColumnClass = (columnKey) => {
      const classes = {
        country: 'text-sm',
        name: '',
        phone: 'text-sm text-gray-900',
        email: 'text-sm',
        assigned_to: '',
        status: '',
        organization: 'text-sm text-gray-900',
        source: '',
        company: 'text-sm text-gray-900',
        created_at: 'text-sm text-gray-500',
        actions: 'text-sm font-medium'
      }
      
      return classes[columnKey] || ''
    }
    
    const getInitials = (name) => {
      if (!name) return 'N'
      return name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase()
    }
    
    const getAvatarColor = (name) => {
      const colors = ['#3B82F6', '#10B981', '#8B5CF6', '#F59E0B', '#EF4444', '#06B6D4']
      if (!name) return colors[0]
      
      const hash = name.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0)
      return colors[hash % colors.length]
    }
    
    const getSourceBadgeClass = (source) => {
      const classes = {
        website: 'bg-blue-100 text-blue-800',
        social: 'bg-purple-100 text-purple-800',
        email: 'bg-green-100 text-green-800',
        phone: 'bg-yellow-100 text-yellow-800',
        referral: 'bg-pink-100 text-pink-800',
        other: 'bg-gray-100 text-gray-800'
      }
      
      return classes[source] || 'bg-gray-100 text-gray-800'
    }
    
    const getSourceName = (source) => {
      const names = {
        website: 'Website',
        social: 'Sosyal Medya',
        email: 'Email',
        phone: 'Telefon',
        referral: 'Referans',
        other: 'Diğer'
      }
      
      return names[source] || 'Bilinmeyen'
    }
    
    const formatDate = (dateString) => {
      if (!dateString) return ''
      
      return new Date(dateString).toLocaleDateString('tr-TR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
      })
    }
    
    const formatTime = (dateString) => {
      if (!dateString) return ''
      
      return new Date(dateString).toLocaleTimeString('tr-TR', {
        hour: '2-digit',
        minute: '2-digit'
      })
    }
    
    const callLead = (phone) => {
      window.open(`tel:${phone}`)
    }
    
    const emailLead = (email) => {
      window.open(`mailto:${email}`)
    }
    
    const editLead = () => {
      leadStore.openEditModal(props.lead)
      showActionsMenu.value = false
    }
    
    const duplicateLead = () => {
      leadStore.duplicateLead(props.lead.id)
      showActionsMenu.value = false
    }
    
    const addNote = () => {
      leadStore.openNoteModal(props.lead.id)
      showActionsMenu.value = false
    }
    
    const scheduleFollowUp = () => {
      leadStore.openFollowUpModal(props.lead.id)
      showActionsMenu.value = false
    }
    
    const deleteLead = () => {
      if (confirm('Bu lead\'i silmek istediğinizden emin misiniz?')) {
        leadStore.deleteLead(props.lead.id)
      }
      showActionsMenu.value = false
    }
    
    const handleClickOutside = (event) => {
      if (actionsDropdownRef.value && !actionsDropdownRef.value.contains(event.target)) {
        showActionsMenu.value = false
      }
    }
    
    // Watch for actions menu
    const toggleActionsMenu = (show) => {
      if (show) {
        document.addEventListener('click', handleClickOutside)
      } else {
        document.removeEventListener('click', handleClickOutside)
      }
    }
    
    // Watchers and lifecycle
    onMounted(() => {
      // Any initialization
    })
    
    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside)
    })
    
    return {
      leadStore,
      actionsDropdownRef,
      showActionsMenu,
      assignmentLoading,
      statusLoading,
      handleAssignmentChange,
      handleStatusChange,
      getColumnClass,
      getInitials,
      getAvatarColor,
      getSourceBadgeClass,
      getSourceName,
      formatDate,
      formatTime,
      callLead,
      emailLead,
      editLead,
      duplicateLead,
      addNote,
      scheduleFollowUp,
      deleteLead
    }
  }
}
</script>

<style scoped>
.lead-assignment-row {
  transition: all 0.2s ease;
}

.lead-assignment-row:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

/* Animation for action buttons */
.lead-assignment-row .fas {
  transition: transform 0.2s ease;
}

.lead-assignment-row button:hover .fas {
  transform: scale(1.1);
}

/* Truncate long text */
.truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>