<tr 
    class="hover:bg-gray-50 dark:hover:bg-admin-700/50 transition-colors group"
    :class="{ 'bg-blue-50 dark:bg-blue-900/20': selectedLeads.includes(lead.id) }"
    x-data="{ showActions: false }"
    @mouseenter="showActions = true"
    @mouseleave="showActions = false"
>
    <!-- Select Checkbox -->
    <td class="px-6 py-4 whitespace-nowrap w-12">
        <input 
            type="checkbox" 
            :value="lead.id"
            x-model="selectedLeads"
            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
        >
    </td>
    
    <!-- Dynamic Columns -->
    <template x-for="column in visibleColumns" :key="column.key">
        <td 
            class="px-6 py-4 whitespace-nowrap text-sm"
            :class="{
                'sticky left-12 z-10 bg-inherit': column.pinned,
                'font-medium text-gray-900 dark:text-white': column.key === 'name',
                'text-gray-500 dark:text-gray-400': column.key !== 'name' && column.key !== 'actions'
            }"
            :style="column.width ? `width: ${column.width}px; min-width: ${column.width}px;` : ''"
        >
            <!-- Name Column -->
            <template x-if="column.key === 'name'">
                <div>
                    <div class="font-medium text-gray-900 dark:text-white" x-text="lead.name"></div>
                    <div class="text-sm text-gray-500 dark:text-gray-400" x-text="lead.country || 'Belirtilmemiş'"></div>
                </div>
            </template>
            
            <!-- Email Column -->
            <template x-if="column.key === 'email'">
                <div>
                    <a 
                        :href="'mailto:' + lead.email" 
                        class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                        x-text="lead.email"
                    ></a>
                </div>
            </template>
            
            <!-- Phone Column -->
            <template x-if="column.key === 'phone'">
                <div>
                    <a 
                        :href="'tel:' + lead.phone" 
                        class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 flex items-center"
                    >
                        <i data-lucide="phone" class="w-4 h-4 mr-1"></i>
                        <span x-text="lead.phone"></span>
                    </a>
                </div>
            </template>
            
            <!-- Status Column with Dropdown -->
            <template x-if="column.key === 'lead_status_id'">
                <div x-data="statusDropdown(lead)" class="relative">
                    <button 
                        @click="toggleDropdown()"
                        class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full cursor-pointer hover:opacity-80 transition-opacity"
                        :style="`background-color: ${currentStatus?.color || '#6B7280'}; color: white;`"
                    >
                        <span x-text="currentStatus?.display_name || 'Belirlenmemiş'"></span>
                        <i data-lucide="chevron-down" class="w-3 h-3 ml-1"></i>
                    </button>
                    
                    <div 
                        x-show="isOpen" 
                        @click.away="isOpen = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        class="absolute z-20 mt-1 w-48 bg-white dark:bg-admin-800 rounded-md shadow-lg border border-gray-200 dark:border-admin-700 py-1"
                        style="display: none;"
                    >
                        <template x-for="status in availableStatuses" :key="status.id">
                            <button 
                                @click="updateStatus(status)"
                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-admin-700 transition-colors"
                                :class="{ 'bg-blue-50 dark:bg-blue-900/20': status.id === lead.lead_status_id }"
                            >
                                <span 
                                    class="inline-block w-3 h-3 rounded-full mr-2"
                                    :style="`background-color: ${status.color}`"
                                ></span>
                                <span x-text="status.display_name"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </template>
            
            <!-- Assignment Column with Dropdown -->
            <template x-if="column.key === 'assign_to'">
                <div x-data="assignmentDropdown(lead)" class="relative">
                    <button 
                        @click="toggleDropdown()"
                        class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-admin-700 transition-colors cursor-pointer min-w-[120px]"
                    >
                        <template x-if="currentAdmin">
                            <div class="flex items-center space-x-2">
                                <div 
                                    class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-medium"
                                    x-text="getInitials(currentAdmin.name)"
                                ></div>
                                <div class="flex-1 text-left">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="currentAdmin.name"></div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Admin</div>
                                </div>
                            </div>
                        </template>
                        <template x-if="!currentAdmin">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Atanmamış</div>
                        </template>
                        <i data-lucide="chevron-down" class="w-3 h-3 opacity-50"></i>
                    </button>
                    
                    <div 
                        x-show="isOpen" 
                        @click.away="isOpen = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        class="absolute z-20 mt-1 w-64 bg-white dark:bg-admin-800 rounded-md shadow-lg border border-gray-200 dark:border-admin-700 py-1"
                        style="display: none;"
                    >
                        <button 
                            @click="updateAssignment(null)"
                            class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-admin-700 transition-colors"
                            :class="{ 'bg-blue-50 dark:bg-blue-900/20': !lead.assign_to }"
                        >
                            <span class="text-gray-500 dark:text-gray-400">Atanmamış</span>
                        </button>
                        
                        <template x-for="admin in availableAdmins" :key="admin.id">
                            <button 
                                @click="updateAssignment(admin)"
                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-admin-700 transition-colors"
                                :class="{ 'bg-blue-50 dark:bg-blue-900/20': admin.id === lead.assign_to }"
                            >
                                <div class="flex items-center space-x-2">
                                    <div 
                                        class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-medium"
                                        x-text="getInitials(admin.name)"
                                    ></div>
                                    <div>
                                        <div class="font-medium" x-text="admin.name"></div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400" x-text="admin.role || 'Admin'"></div>
                                    </div>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>
            </template>
            
            <!-- Lead Score Column -->
            <template x-if="column.key === 'lead_score'">
                <div class="flex items-center space-x-2">
                    <div class="w-12 bg-gray-200 dark:bg-admin-600 rounded-full h-2">
                        <div 
                            class="h-2 rounded-full transition-all duration-300"
                            :class="{
                                'bg-red-500': lead.lead_score < 30,
                                'bg-yellow-500': lead.lead_score >= 30 && lead.lead_score < 70,
                                'bg-green-500': lead.lead_score >= 70
                            }"
                            :style="`width: ${lead.lead_score || 0}%`"
                        ></div>
                    </div>
                    <span 
                        class="text-xs font-medium"
                        :class="{
                            'text-red-600 dark:text-red-400': lead.lead_score < 30,
                            'text-yellow-600 dark:text-yellow-400': lead.lead_score >= 30 && lead.lead_score < 70,
                            'text-green-600 dark:text-green-400': lead.lead_score >= 70
                        }"
                        x-text="lead.lead_score || 0"
                    ></span>
                </div>
            </template>
            
            <!-- Lead Priority Column -->
            <template x-if="column.key === 'lead_priority'">
                <span 
                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full"
                    :class="{
                        'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300': lead.lead_priority === 'low',
                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300': lead.lead_priority === 'medium',
                        'bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-300': lead.lead_priority === 'high',
                        'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300': lead.lead_priority === 'urgent'
                    }"
                >
                    <span x-text="getPriorityLabel(lead.lead_priority)"></span>
                </span>
            </template>
            
            <!-- Created At Column -->
            <template x-if="column.key === 'created_at'">
                <div>
                    <div x-text="formatDate(lead.created_at)"></div>
                    <div class="text-xs text-gray-400" x-text="getTimeAgo(lead.created_at)"></div>
                </div>
            </template>
            
            <!-- Actions Column -->
            <template x-if="column.key === 'actions'">
                <div class="flex items-center space-x-2" :class="{ 'opacity-100': showActions, 'opacity-0 group-hover:opacity-100': !showActions }">
                    <button 
                        @click="viewLead(lead.id)"
                        class="p-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 rounded"
                        title="Görüntüle"
                    >
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </button>
                    
                    @can('edit_leads')
                    <button 
                        @click="editLead(lead.id)"
                        class="p-1 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 rounded"
                        title="Düzenle"
                    >
                        <i data-lucide="edit" class="w-4 h-4"></i>
                    </button>
                    @endcan
                    
                    @can('call_leads')
                    <a 
                        :href="'tel:' + lead.phone" 
                        class="p-1 text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 rounded"
                        title="Ara"
                    >
                        <i data-lucide="phone" class="w-4 h-4"></i>
                    </a>
                    @endcan
                    
                    <button 
                        @click="showLeadMenu = !showLeadMenu"
                        class="p-1 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 rounded relative"
                        title="Daha fazla"
                        x-data="{ showLeadMenu: false }"
                    >
                        <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                        
                        <div 
                            x-show="showLeadMenu" 
                            @click.away="showLeadMenu = false"
                            class="absolute right-0 top-8 w-48 bg-white dark:bg-admin-800 rounded-md shadow-lg border border-gray-200 dark:border-admin-700 py-1 z-30"
                            style="display: none;"
                        >
                            <button 
                                @click="addNote(lead.id); showLeadMenu = false"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700"
                            >
                                <i data-lucide="file-text" class="w-4 h-4 mr-2 inline"></i>
                                Not Ekle
                            </button>
                            
                            <button 
                                @click="scheduleFollowUp(lead.id); showLeadMenu = false"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700"
                            >
                                <i data-lucide="calendar" class="w-4 h-4 mr-2 inline"></i>
                                Takip Planla
                            </button>
                        </div>
                    </button>
                </div>
            </template>
            
            <!-- Default Column Content -->
            <template x-if="!['name', 'email', 'phone', 'lead_status_id', 'assign_to', 'lead_score', 'lead_priority', 'created_at', 'actions'].includes(column.key)">
                <span x-text="getColumnValue(lead, column.key)"></span>
            </template>
        </td>
    </template>
</tr>

@pushOnce('scripts')
<script>
// Status dropdown functionality
function statusDropdown(lead) {
    return {
        isOpen: false,
        currentStatus: null,
        availableStatuses: [],
        
        init() {
            this.loadStatuses();
            this.currentStatus = this.availableStatuses.find(s => s.id === lead.lead_status_id);
        },
        
        toggleDropdown() {
            this.isOpen = !this.isOpen;
        },
        
        async loadStatuses() {
            try {
                const response = await fetch('/admin/dashboard/leads/statuses');
                const data = await response.json();
                if (data.success) {
                    this.availableStatuses = data.data;
                }
            } catch (error) {
                console.error('Failed to load statuses:', error);
            }
        },
        
        async updateStatus(status) {
            try {
                const response = await fetch(`/admin/dashboard/leads/${lead.id}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        lead_status_id: status.id
                    })
                });
                
                const result = await response.json();
                if (result.success) {
                    this.currentStatus = status;
                    lead.lead_status_id = status.id;
                    this.isOpen = false;
                } else {
                    throw new Error(result.message || 'Status güncellenemedi');
                }
            } catch (error) {
                console.error('Status update failed:', error);
                alert('Status güncellenirken hata oluştu');
            }
        }
    }
}

// Assignment dropdown functionality
function assignmentDropdown(lead) {
    return {
        isOpen: false,
        currentAdmin: null,
        availableAdmins: [],
        
        init() {
            this.loadAdmins();
            this.currentAdmin = this.availableAdmins.find(a => a.id === lead.assign_to);
        },
        
        toggleDropdown() {
            this.isOpen = !this.isOpen;
        },
        
        async loadAdmins() {
            try {
                const response = await fetch('/admin/dashboard/leads/assignable-admins');
                const data = await response.json();
                if (data.success) {
                    this.availableAdmins = data.data.admins;
                }
            } catch (error) {
                console.error('Failed to load admins:', error);
            }
        },
        
        async updateAssignment(admin) {
            try {
                const response = await fetch(`/admin/dashboard/leads/${lead.id}/assignment`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        assigned_to_admin_id: admin?.id || null
                    })
                });
                
                const result = await response.json();
                if (result.success) {
                    this.currentAdmin = admin;
                    lead.assign_to = admin?.id || null;
                    this.isOpen = false;
                } else {
                    throw new Error(result.message || 'Atama güncellenemedi');
                }
            } catch (error) {
                console.error('Assignment update failed:', error);
                alert('Atama güncellenirken hata oluştu');
            }
        },
        
        getInitials(name) {
            return name.split(' ').map(n => n[0]).join('').toUpperCase();
        }
    }
}
</script>
@endPushOnce