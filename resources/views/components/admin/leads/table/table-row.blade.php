@props(['lead', 'statuses', 'agents'])

<tr class="hover:bg-gray-50 dark:hover:bg-admin-800 transition-colors duration-200 border-b border-gray-200 dark:border-admin-700"
    :class="{'bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500': selectedLeads.includes({{ $lead->id }})}">
    
    <!-- Select Checkbox -->
    <td class="px-6 py-4 whitespace-nowrap">
        <input 
            type="checkbox" 
            value="{{ $lead->id }}"
            x-model="selectedLeads"
            @change="updateSelectAllState"
            class="lead-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
        >
    </td>
    
    <!-- ÜLKE Column -->
    <td class="px-6 py-4">
        @if($lead->country)
            <div class="flex items-center">
                <i data-lucide="map-pin" class="w-4 h-4 mr-2 text-gray-500"></i>
                <span class="text-sm font-medium text-gray-900 dark:text-white">
                    {{ $lead->country }}
                </span>
            </div>
        @else
            <span class="text-sm text-gray-500">Belirtilmedi</span>
        @endif
    </td>
    
    <!-- AD SOYAD Column -->
    <td class="px-6 py-4">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-3">
                <span class="text-white text-sm font-semibold">
                    {{ substr($lead->name ?? 'N', 0, 1) }}
                </span>
            </div>
            <div>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    {{ $lead->name ?? 'Belirtilmedi' }}
                </div>
            </div>
        </div>
    </td>
    
    <!-- TELEFON NUMARASI Column -->
    <td class="px-6 py-4">
        @if($lead->phone)
            <div class="flex items-center">
                <i data-lucide="phone" class="w-4 h-4 mr-2 text-gray-500"></i>
                <a href="tel:{{ $lead->phone }}" 
                   class="text-sm text-green-600 hover:text-green-800 hover:underline transition-colors">
                    {{ $lead->phone }}
                </a>
            </div>
        @else
            <span class="text-sm text-gray-500">Belirtilmedi</span>
        @endif
    </td>
    
    <!-- EMAİL Column -->
    <td class="px-6 py-4">
        @if($lead->email)
            <div class="flex items-center">
                <i data-lucide="mail" class="w-4 h-4 mr-2 text-gray-500"></i>
                <a href="mailto:{{ $lead->email }}" 
                   class="text-sm text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                    {{ $lead->email }}
                </a>
            </div>
        @else
            <span class="text-sm text-gray-500">Belirtilmedi</span>
        @endif
    </td>
    
    <!-- ASSIGNED Column -->
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="relative" x-data="{ 
            showAssignedDropdown: false, 
            leadId: {{ $lead->id }}, 
            currentAssigned: {{ $lead->assign_to ?? 'null' }} 
        }">
            <!-- Assigned Display/Button -->
            <button 
                @click="showAssignedDropdown = !showAssignedDropdown"
                @click.outside="showAssignedDropdown = false"
                class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium border transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                :class="{
                    'bg-blue-50 border-blue-200 text-blue-700 hover:bg-blue-100': currentAssigned,
                    'bg-gray-50 border-gray-200 text-gray-600 hover:bg-gray-100': !currentAssigned
                }"
            >
                @if($lead->assignedAgent)
                    <div class="w-6 h-6 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mr-2">
                        <span class="text-white text-xs font-semibold">
                            {{ substr($lead->assignedAgent->name, 0, 1) }}
                        </span>
                    </div>
                    <span>{{ $lead->assignedAgent->name }}</span>
                @else
                    <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                    <span>Atanmadı</span>
                @endif
                <i data-lucide="chevron-down" class="ml-2 w-4 h-4 transition-transform duration-200" :class="{'rotate-180': showAssignedDropdown}"></i>
            </button>
            
            <!-- Dropdown Menu -->
            <div x-show="showAssignedDropdown" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute z-50 mt-1 w-56 bg-white dark:bg-admin-800 rounded-lg shadow-lg border border-gray-200 dark:border-admin-600 py-1"
                 style="display: none;">
                
                <!-- Unassign Option -->
                <button @click="updateLeadAssignment(leadId, null, 'Atanmadı'); showAssignedDropdown = false"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-admin-200 hover:bg-gray-100 dark:hover:bg-admin-700 transition-colors"
                        :class="{'bg-blue-50 dark:bg-blue-900/30 text-blue-600': currentAssigned === null}">
                    <i data-lucide="user-x" class="w-4 h-4 mr-3 text-red-500"></i>
                    Atamayı Kaldır
                </button>
                
                <hr class="my-1 border-gray-200 dark:border-admin-600">
                
                @foreach($agents as $agent)
                <button @click="updateLeadAssignment(leadId, {{ $agent->id }}, '{{ $agent->name }}'); showAssignedDropdown = false"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-admin-200 hover:bg-gray-100 dark:hover:bg-admin-700 transition-colors"
                        :class="{'bg-blue-50 dark:bg-blue-900/30 text-blue-600': currentAssigned === {{ $agent->id }}}">
                    <div class="w-6 h-6 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mr-3">
                        <span class="text-white text-xs font-semibold">
                            {{ substr($agent->name, 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <div class="font-medium">{{ $agent->name }}</div>
                        <div class="text-xs text-gray-500">{{ $agent->email }}</div>
                    </div>
                </button>
                @endforeach
            </div>
        </div>
    </td>
    
    <!-- STATUS Column -->
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="relative" x-data="{ 
            showStatusDropdown: false, 
            leadId: {{ $lead->id }}, 
            currentStatus: {{ $lead->lead_status_id ?? 'null' }},
            currentStatusName: '{{ $lead->leadStatus->name ?? 'Atanmadı' }}'
        }">
            <!-- Status Display/Button -->
            <button 
                @click="showStatusDropdown = !showStatusDropdown"
                @click.outside="showStatusDropdown = false"
                class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2"
                :class="{
                    @if($lead->leadStatus)
                        @switch($lead->leadStatus->name)
                            @case('New')
                                'bg-green-100 text-green-800 border border-green-200 hover:bg-green-200 focus:ring-green-500': true
                                @break
                            @case('Contacted') 
                                'bg-blue-100 text-blue-800 border border-blue-200 hover:bg-blue-200 focus:ring-blue-500': true
                                @break
                            @case('Qualified')
                                'bg-yellow-100 text-yellow-800 border border-yellow-200 hover:bg-yellow-200 focus:ring-yellow-500': true
                                @break
                            @case('Converted')
                                'bg-emerald-100 text-emerald-800 border border-emerald-200 hover:bg-emerald-200 focus:ring-emerald-500': true
                                @break
                            @case('Lost')
                                'bg-red-100 text-red-800 border border-red-200 hover:bg-red-200 focus:ring-red-500': true
                                @break
                            @default
                                'bg-gray-100 text-gray-800 border border-gray-200 hover:bg-gray-200 focus:ring-gray-500': true
                        @endswitch
                    @else
                        'bg-gray-100 text-gray-800 border border-gray-200 hover:bg-gray-200 focus:ring-gray-500': true
                    @endif
                }"
            >
                <span x-text="currentStatusName">{{ $lead->leadStatus->name ?? 'Atanmadı' }}</span>
                <i data-lucide="chevron-down" class="ml-2 w-4 h-4 transition-transform duration-200" :class="{'rotate-180': showStatusDropdown}"></i>
            </button>
            
            <!-- Dropdown Menu -->
            <div x-show="showStatusDropdown" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute z-50 mt-1 w-48 bg-white dark:bg-admin-800 rounded-lg shadow-lg border border-gray-200 dark:border-admin-600 py-1"
                 style="display: none;">
                @foreach($statuses as $status)
                <button @click="updateLeadStatus(leadId, {{ $status->id }}, '{{ $status->name }}'); showStatusDropdown = false; currentStatus = {{ $status->id }}; currentStatusName = '{{ $status->name }}'"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-admin-200 hover:bg-gray-100 dark:hover:bg-admin-700 transition-colors"
                        :class="{'bg-blue-50 dark:bg-blue-900/30 text-blue-600': currentStatus === {{ $status->id }}}">
                    <div class="w-3 h-3 rounded-full mr-3"
                         @class([
                             'bg-green-500' => strtolower($status->name) === 'new' || strtolower($status->name) === 'yeni',
                             'bg-blue-500' => strtolower($status->name) === 'contacted' || strtolower($status->name) === 'iletişimde',
                             'bg-yellow-500' => strtolower($status->name) === 'qualified' || strtolower($status->name) === 'nitelikli',
                             'bg-emerald-500' => strtolower($status->name) === 'converted' || strtolower($status->name) === 'dönüştürülmüş',
                             'bg-red-500' => strtolower($status->name) === 'lost' || strtolower($status->name) === 'kayıp',
                             'bg-gray-400' => !in_array(strtolower($status->name), ['new', 'yeni', 'contacted', 'iletişimde', 'qualified', 'nitelikli', 'converted', 'dönüştürülmüş', 'lost', 'kayıp'])
                         ])></div>
                    {{ $status->name }}
                </button>
                @endforeach
            </div>
        </div>
    </td>
    
    <!-- VARONKA Column -->
    <td class="px-6 py-4">
        <div class="text-sm font-medium text-gray-900 dark:text-white">
            {{ $lead->organization ?? 'Belirtilmedi' }}
        </div>
    </td>
    
    <!-- KAYNAK Column -->
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
              @class([
                  'bg-purple-100 text-purple-800 border border-purple-200' => $lead->leadSource?->name === 'Website',
                  'bg-indigo-100 text-indigo-800 border border-indigo-200' => $lead->leadSource?->name === 'Social Media',
                  'bg-pink-100 text-pink-800 border border-pink-200' => $lead->leadSource?->name === 'Email Campaign',
                  'bg-orange-100 text-orange-800 border border-orange-200' => $lead->leadSource?->name === 'Cold Call',
                  'bg-teal-100 text-teal-800 border border-teal-200' => $lead->leadSource?->name === 'Referral',
                  'bg-gray-100 text-gray-800 border border-gray-200' => !$lead->leadSource || !in_array($lead->leadSource->name, ['Website', 'Social Media', 'Email Campaign', 'Cold Call', 'Referral'])
              ])>
            @if($lead->leadSource)
                <i data-lucide="{{ $lead->leadSource->name === 'Website' ? 'globe' : 
                                 ($lead->leadSource->name === 'Social Media' ? 'users' :
                                 ($lead->leadSource->name === 'Email Campaign' ? 'mail' :
                                 ($lead->leadSource->name === 'Cold Call' ? 'phone' : 'user-plus'))) }}" 
                   class="w-4 h-4 mr-2"></i>
                {{ $lead->leadSource->name }}
            @else
                <i data-lucide="help-circle" class="w-4 h-4 mr-2"></i>
                Belirtilmedi
            @endif
        </span>
    </td>
    
    <!-- ŞİRKET Column -->
    <td class="px-6 py-4">
        <div class="text-sm font-medium text-gray-900 dark:text-white">
            {{ $lead->company_name ?? 'Belirtilmedi' }}
        </div>
    </td>
</tr>

@pushOnce('styles')
<style>
/* Modern Table Row Styling */
.table-row-modern {
    transition: all 0.2s ease;
    position: relative;
}

.table-row-modern:hover {
    background-color: rgba(59, 130, 246, 0.02);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.table-row-modern.selected {
    background-color: rgba(59, 130, 246, 0.05);
    border-left: 4px solid #3b82f6;
}

/* Cell styling */
.table-row-modern td {
    padding: 1rem 1.5rem;
    vertical-align: top;
    border-bottom: 1px solid #e5e7eb;
}

/* Status dropdown styling */
.status-dropdown {
    position: relative;
}

.status-button {
    transition: all 0.2s ease;
    border-radius: 9999px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    cursor: pointer;
    border: 1px solid transparent;
}

.status-button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
}

.status-button:focus {
    outline: none;
    ring: 2px;
    ring-offset: 2px;
}

/* Source badges */
.source-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 9999px;
    border: 1px solid;
}

/* Avatar styling */
.avatar {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    color: white;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
}

/* Contact info styling */
.contact-info {
    display: flex;
    align-items: center;
    margin-bottom: 0.25rem;
}

.contact-info:last-child {
    margin-bottom: 0;
}

.contact-info i {
    width: 1rem;
    height: 1rem;
    margin-right: 0.5rem;
    color: #6b7280;
}

/* Assigned dropdown */
.assigned-dropdown {
    min-width: 14rem;
}

.assigned-button {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
    cursor: pointer;
}

.assigned-button:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Dropdown menu styling */
.dropdown-menu {
    position: absolute;
    z-index: 50;
    margin-top: 0.25rem;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    border: 1px solid #e5e7eb;
    padding: 0.25rem 0;
    max-height: 16rem;
    overflow-y: auto;
}

.dropdown-menu button {
    width: 100%;
    text-align: left;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    color: #374151;
    transition: background-color 0.15s ease;
    display: flex;
    align-items: center;
}

.dropdown-menu button:hover {
    background-color: #f3f4f6;
}

.dropdown-menu button.active {
    background-color: #dbeafe;
    color: #2563eb;
}

/* Checkbox styling */
.lead-checkbox {
    width: 1rem;
    height: 1rem;
    border-radius: 0.25rem;
    border: 1px solid #d1d5db;
    accent-color: #3b82f6;
}

.lead-checkbox:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .table-row-modern td {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }
    
    .status-button, .assigned-button {
        padding: 0.375rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .avatar {
        width: 1.5rem;
        height: 1.5rem;
        font-size: 0.75rem;
    }
    
    .dropdown-menu {
        min-width: 12rem;
    }
}

/* Dark mode enhancements */
.dark .table-row-modern {
    border-bottom-color: #374151;
}

.dark .table-row-modern:hover {
    background-color: rgba(59, 130, 246, 0.05);
}

.dark .dropdown-menu {
    background: #1f2937;
    border-color: #374151;
}

.dark .dropdown-menu button {
    color: #d1d5db;
}

.dark .dropdown-menu button:hover {
    background-color: #374151;
}

.dark .dropdown-menu button.active {
    background-color: rgba(59, 130, 246, 0.2);
    color: #60a5fa;
}

/* Loading states */
.loading {
    opacity: 0.7;
    pointer-events: none;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.dropdown-menu {
    animation: fadeIn 0.15s ease-out;
}

/* Focus states */
.status-button:focus,
.assigned-button:focus {
    outline: none;
    ring: 2px;
    ring-color: #3b82f6;
    ring-offset: 2px;
}

/* Success/Error states */
.status-updated {
    background-color: #ecfdf5 !important;
    border-color: #10b981 !important;
}

.status-error {
    background-color: #fef2f2 !important;
    border-color: #ef4444 !important;
}
</style>
@endPushOnce

@pushOnce('scripts')
<script>
// Enhanced table row functionality
document.addEventListener('DOMContentLoaded', function() {
    
    // Individual checkbox handling
    function setupRowCheckboxes() {
        const checkboxes = document.querySelectorAll('.lead-checkbox');
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const row = this.closest('tr');
                const leadId = this.value;
                
                if (this.checked) {
                    row.classList.add('selected', 'bg-blue-50', 'border-l-4', 'border-blue-500');
                } else {
                    row.classList.remove('selected', 'bg-blue-50', 'border-l-4', 'border-blue-500');
                }
                
                updateBulkActionUI();
                updateSelectAllState();
            });
        });
    }
    
    // Update select all state
    function updateSelectAllState() {
        const allCheckboxes = document.querySelectorAll('.lead-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.lead-checkbox:checked');
        const selectAllCheckbox = document.querySelector('thead input[type="checkbox"]');
        
        if (selectAllCheckbox) {
            if (checkedCheckboxes.length === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (checkedCheckboxes.length === allCheckboxes.length) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
                selectAllCheckbox.checked = false;
            }
        }
    }
    
    // Bulk action UI update
    function updateBulkActionUI() {
        const checkedCount = document.querySelectorAll('.lead-checkbox:checked').length;
        const bulkActions = document.querySelector('#bulk-actions');
        const selectedCounter = document.querySelector('#selected-count');
        
        if (bulkActions) {
            if (checkedCount > 0) {
                bulkActions.classList.remove('hidden');
                if (selectedCounter) {
                    selectedCounter.textContent = checkedCount;
                }
            } else {
                bulkActions.classList.add('hidden');
            }
        }
    }
    
    // Initialize
    setupRowCheckboxes();
    
    // Make functions globally available for Alpine.js
    window.updateBulkActionUI = updateBulkActionUI;
    window.updateSelectAllState = updateSelectAllState;
});

// Enhanced status update function with status name support
async function updateLeadStatus(leadId, statusId, statusName) {
    try {
        const response = await fetch(`/admin/leads/${leadId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status_id: statusId })
        });
        
        if (response.ok) {
            // Update button styling based on status name
            const button = document.querySelector(`[x-data*="leadId: ${leadId}"] .status-button`);
            if (button) {
                // Remove all status classes
                button.classList.remove(
                    'bg-green-100', 'text-green-800', 'border-green-200', 'hover:bg-green-200', 'focus:ring-green-500',
                    'bg-blue-100', 'text-blue-800', 'border-blue-200', 'hover:bg-blue-200', 'focus:ring-blue-500',
                    'bg-yellow-100', 'text-yellow-800', 'border-yellow-200', 'hover:bg-yellow-200', 'focus:ring-yellow-500',
                    'bg-emerald-100', 'text-emerald-800', 'border-emerald-200', 'hover:bg-emerald-200', 'focus:ring-emerald-500',
                    'bg-red-100', 'text-red-800', 'border-red-200', 'hover:bg-red-200', 'focus:ring-red-500',
                    'bg-gray-100', 'text-gray-800', 'border-gray-200', 'hover:bg-gray-200', 'focus:ring-gray-500'
                );
                
                // Add appropriate classes based on status name
                const statusLower = statusName.toLowerCase();
                if (statusLower === 'new' || statusLower === 'yeni') {
                    button.classList.add('bg-green-100', 'text-green-800', 'border', 'border-green-200', 'hover:bg-green-200', 'focus:ring-green-500');
                } else if (statusLower === 'contacted' || statusLower === 'iletişimde') {
                    button.classList.add('bg-blue-100', 'text-blue-800', 'border', 'border-blue-200', 'hover:bg-blue-200', 'focus:ring-blue-500');
                } else if (statusLower === 'qualified' || statusLower === 'nitelikli') {
                    button.classList.add('bg-yellow-100', 'text-yellow-800', 'border', 'border-yellow-200', 'hover:bg-yellow-200', 'focus:ring-yellow-500');
                } else if (statusLower === 'converted' || statusLower === 'dönüştürülmüş') {
                    button.classList.add('bg-emerald-100', 'text-emerald-800', 'border', 'border-emerald-200', 'hover:bg-emerald-200', 'focus:ring-emerald-500');
                } else if (statusLower === 'lost' || statusLower === 'kayıp') {
                    button.classList.add('bg-red-100', 'text-red-800', 'border', 'border-red-200', 'hover:bg-red-200', 'focus:ring-red-500');
                } else {
                    button.classList.add('bg-gray-100', 'text-gray-800', 'border', 'border-gray-200', 'hover:bg-gray-200', 'focus:ring-gray-500');
                }
                
                // Show success animation
                showStatusUpdateSuccess(button);
            }
            
            // Show notification
            showNotification('Status başarıyla güncellendi', 'success');
        } else {
            throw new Error('Status güncellenemedi');
        }
    } catch (error) {
        console.error('Status güncelleme hatası:', error);
        showNotification('Status güncellenirken hata oluştu', 'error');
    }
}

// Enhanced assignment update function  
async function updateLeadAssignment(leadId, agentId, agentName) {
    try {
        const response = await fetch(`/admin/leads/${leadId}/assign`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ agent_id: agentId })
        });
        
        if (response.ok) {
            // Update the UI
            const button = document.querySelector(`[x-data*="leadId: ${leadId}"] .assigned-button`);
            if (button) {
                showAssignmentUpdateSuccess(button);
            }
            
            // Show notification
            showNotification('Atama başarıyla güncellendi', 'success');
        } else {
            throw new Error('Atama güncellenemedi');
        }
    } catch (error) {
        console.error('Atama güncelleme hatası:', error);
        showNotification('Atama güncellenirken hata oluştu', 'error');
    }
}

// Status update success animation
function showStatusUpdateSuccess(button) {
    button.classList.add('status-updated');
    setTimeout(() => {
        button.classList.remove('status-updated');
    }, 1500);
}

// Assignment update success animation
function showAssignmentUpdateSuccess(button) {
    button.classList.add('status-updated');
    setTimeout(() => {
        button.classList.remove('status-updated');
    }, 1500);
}

// Notification system
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        type === 'warning' ? 'bg-yellow-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    
    notification.innerHTML = `
        <div class="flex items-center">
            <i data-lucide="${type === 'success' ? 'check-circle' : 
                             type === 'error' ? 'x-circle' :
                             type === 'warning' ? 'alert-triangle' : 'info'}" 
               class="w-5 h-5 mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Initialize Lucide icons for the notification
    if (window.lucide) {
        window.lucide.createIcons();
    }
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>
@endPushOnce