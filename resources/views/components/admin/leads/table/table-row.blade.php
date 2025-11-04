@props(['lead', 'statuses', 'agents'])

<tr class="hover:bg-gray-50 dark:hover:bg-admin-800 transition-colors duration-200 border-b border-gray-200 dark:border-admin-700" data-lead-id="{{ $lead->id }}">
    
    <!-- Select Checkbox -->
    <td class="px-6 py-4 whitespace-nowrap">
        <input
            type="checkbox"
            value="{{ $lead->id }}"
            class="lead-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
            onchange="handleCheckboxChange(this)"
        >
    </td>
    
    <!-- ÜLKE Column -->
    <td class="px-6 py-4">
        @if($lead->country)
            <div class="flex items-center">
                <x-heroicon name="map-pin" class="w-4 h-4 mr-2 text-gray-500" />
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
                <x-heroicon name="phone" class="w-4 h-4 mr-2 text-gray-500" />
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
                <x-heroicon name="envelope" class="w-4 h-4 mr-2 text-gray-500" />
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
        <div class="relative assigned-dropdown-container" data-lead-id="{{ $lead->id }}" data-current-assigned="{{ $lead->assign_to ?? '' }}">
            <!-- Assigned Display/Button -->
            <button
                onclick="handleAssignedDropdownToggle(event, {{ $lead->id }})"
                class="assigned-button inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium border transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 {{ $lead->assignedAgent ? 'bg-blue-50 border-blue-200 text-blue-700 hover:bg-blue-100' : 'bg-gray-50 border-gray-200 text-gray-600 hover:bg-gray-100' }}"
            >
                @if($lead->assignedAgent)
                    <div class="w-6 h-6 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mr-2">
                        <span class="text-white text-xs font-semibold">
                            {{ substr($lead->assignedAgent->name, 0, 1) }}
                        </span>
                    </div>
                    <span>{{ $lead->assignedAgent->name }}</span>
                @else
                    <x-heroicon name="user-plus" class="w-4 h-4 mr-2" />
                    <span>Atanmadı</span>
                @endif
                <x-heroicon name="chevron-down" class="assigned-chevron ml-2 w-4 h-4 transition-transform duration-200" />
            </button>
            
            <!-- Dropdown Menu -->
            <div class="assigned-dropdown absolute z-50 mt-1 w-56 bg-white dark:bg-admin-800 rounded-lg shadow-lg border border-gray-200 dark:border-admin-600 py-1 hidden">
                
                <!-- Unassign Option -->
                <button onclick="handleAssignmentUpdate(event, {{ $lead->id }}, null, 'Atanmadı')"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-admin-200 hover:bg-gray-100 dark:hover:bg-admin-700 transition-colors {{ $lead->assign_to === null ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600' : '' }}">
                    <x-heroicon name="user-minus" class="w-4 h-4 mr-3 text-red-500" />
                    Atamayı Kaldır
                </button>
                
                <hr class="my-1 border-gray-200 dark:border-admin-600">
                
                @foreach($agents as $agent)
                <button onclick="handleAssignmentUpdate(event, {{ $lead->id }}, {{ $agent->id }}, '{{ $agent->name }}')"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-admin-200 hover:bg-gray-100 dark:hover:bg-admin-700 transition-colors {{ $lead->assign_to === $agent->id ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600' : '' }}">
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
        <div class="relative status-dropdown-container" data-lead-id="{{ $lead->id }}" data-current-status="{{ $lead->leadStatus->id ?? '' }}" data-current-status-name="{{ $lead->leadStatusName }}">
            <!-- Status Display/Button -->
            <button
                onclick="handleStatusDropdownToggle(event, {{ $lead->id }})"
                class="status-button inline-flex items-center px-3 py-2 rounded-full text-sm font-medium transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2
                @if($lead->leadStatus)
                    @switch(strtolower($lead->leadStatus->name))
                        @case('new')
                            bg-green-100 text-green-800 border border-green-200 hover:bg-green-200 focus:ring-green-500
                            @break
                        @case('contacted')
                            bg-blue-100 text-blue-800 border border-blue-200 hover:bg-blue-200 focus:ring-blue-500
                            @break
                        @case('qualified')
                            bg-yellow-100 text-yellow-800 border border-yellow-200 hover:bg-yellow-200 focus:ring-yellow-500
                            @break
                        @case('converted')
                            bg-emerald-100 text-emerald-800 border border-emerald-200 hover:bg-emerald-200 focus:ring-emerald-500
                            @break
                        @case('lost')
                            bg-red-100 text-red-800 border border-red-200 hover:bg-red-200 focus:ring-red-500
                            @break
                        @case('interested')
                            bg-purple-100 text-purple-800 border border-purple-200 hover:bg-purple-200 focus:ring-purple-500
                            @break
                        @case('negotiation')
                            bg-indigo-100 text-indigo-800 border border-indigo-200 hover:bg-indigo-200 focus:ring-indigo-500
                            @break
                        @default
                            bg-gray-100 text-gray-800 border border-gray-200 hover:bg-gray-200 focus:ring-gray-500
                    @endswitch
                @else
                    bg-gray-100 text-gray-800 border border-gray-200 hover:bg-gray-200 focus:ring-gray-500
                @endif"
            >
                <span class="status-name">{{ $lead->leadStatusName }}</span>
                <x-heroicon name="chevron-down" class="status-chevron ml-2 w-4 h-4 transition-transform duration-200" />
            </button>
            
            <!-- Dropdown Menu -->
            <div class="status-dropdown absolute z-50 mt-1 w-48 bg-white dark:bg-admin-800 rounded-lg shadow-lg border border-gray-200 dark:border-admin-600 py-1 hidden">
                @foreach($statuses as $status)
                <button onclick="handleStatusUpdate(event, {{ $lead->id }}, {{ $status->id }}, '{{ $status->name }}')"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-admin-200 hover:bg-gray-100 dark:hover:bg-admin-700 transition-colors {{ ($lead->leadStatus && $lead->leadStatus->id === $status->id) ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600' : '' }}">
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
                <x-heroicon name="{{ $lead->leadSource->name === 'Website' ? 'globe' : 
                                 ($lead->leadSource->name === 'Social Media' ? 'users' :
                                 ($lead->leadSource->name === 'Email Campaign' ? 'mail' :
                                 ($lead->leadSource->name === 'Cold Call' ? 'phone' : 'user-plus'))) }}" class="w-4 h-4 mr-2" />
                {{ $lead->leadSource->name }}
            @else
                <x-heroicon name="question-mark-circle" class="w-4 h-4 mr-2" />
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
// Checkbox handling functions
function handleCheckboxChange(checkbox) {
    const row = checkbox.closest('tr');
    const leadId = checkbox.value;
    
    if (checkbox.checked) {
        row.classList.add('selected', 'bg-blue-50', 'border-l-4', 'border-blue-500');
    } else {
        row.classList.remove('selected', 'bg-blue-50', 'border-l-4', 'border-blue-500');
    }
    
    if (window.updateBulkActionUI) {
        window.updateBulkActionUI();
    }
    if (window.updateSelectAllState) {
        window.updateSelectAllState();
    }
}

// Enhanced dropdown functions with proper event handling
function handleAssignedDropdownToggle(event, leadId) {
    event.stopPropagation();
    event.preventDefault();
    
    const container = document.querySelector(`[data-lead-id="${leadId}"] .assigned-dropdown-container`);
    if (!container) return;
    
    const dropdown = container.querySelector('.assigned-dropdown');
    const chevron = container.querySelector('.assigned-chevron');
    if (!dropdown || !chevron) return;
    
    // Hide other dropdowns first
    document.querySelectorAll('.assigned-dropdown').forEach(d => {
        if (d !== dropdown && !d.classList.contains('hidden')) {
            d.classList.add('hidden');
            const otherChevron = d.closest('.assigned-dropdown-container')?.querySelector('.assigned-chevron');
            if (otherChevron) otherChevron.style.transform = '';
        }
    });
    
    // Also hide status dropdowns
    document.querySelectorAll('.status-dropdown').forEach(d => {
        if (!d.classList.contains('hidden')) {
            d.classList.add('hidden');
            const otherChevron = d.closest('.status-dropdown-container')?.querySelector('.status-chevron');
            if (otherChevron) otherChevron.style.transform = '';
        }
    });
    
    // Toggle current dropdown
    const isHidden = dropdown.classList.contains('hidden');
    dropdown.classList.toggle('hidden');
    chevron.style.transform = isHidden ? 'rotate(180deg)' : '';
}

function handleStatusDropdownToggle(event, leadId) {
    event.stopPropagation();
    event.preventDefault();
    
    const container = document.querySelector(`[data-lead-id="${leadId}"] .status-dropdown-container`);
    if (!container) return;
    
    const dropdown = container.querySelector('.status-dropdown');
    const chevron = container.querySelector('.status-chevron');
    if (!dropdown || !chevron) return;
    
    // Hide other dropdowns first
    document.querySelectorAll('.status-dropdown').forEach(d => {
        if (d !== dropdown && !d.classList.contains('hidden')) {
            d.classList.add('hidden');
            const otherChevron = d.closest('.status-dropdown-container')?.querySelector('.status-chevron');
            if (otherChevron) otherChevron.style.transform = '';
        }
    });
    
    // Also hide assignment dropdowns
    document.querySelectorAll('.assigned-dropdown').forEach(d => {
        if (!d.classList.contains('hidden')) {
            d.classList.add('hidden');
            const otherChevron = d.closest('.assigned-dropdown-container')?.querySelector('.assigned-chevron');
            if (otherChevron) otherChevron.style.transform = '';
        }
    });
    
    // Toggle current dropdown
    const isHidden = dropdown.classList.contains('hidden');
    dropdown.classList.toggle('hidden');
    chevron.style.transform = isHidden ? 'rotate(180deg)' : '';
}

function hideAssignedDropdown(leadId) {
    const container = document.querySelector(`[data-lead-id="${leadId}"] .assigned-dropdown-container`);
    if (!container) return;
    
    const dropdown = container.querySelector('.assigned-dropdown');
    const chevron = container.querySelector('.assigned-chevron');
    
    if (dropdown) dropdown.classList.add('hidden');
    if (chevron) chevron.style.transform = '';
}

function hideStatusDropdown(leadId) {
    const container = document.querySelector(`[data-lead-id="${leadId}"] .status-dropdown-container`);
    if (!container) return;
    
    const dropdown = container.querySelector('.status-dropdown');
    const chevron = container.querySelector('.status-chevron');
    
    if (dropdown) dropdown.classList.add('hidden');
    if (chevron) chevron.style.transform = '';
}

// Backward compatibility
function toggleAssignedDropdown(leadId) {
    handleAssignedDropdownToggle({stopPropagation: () => {}, preventDefault: () => {}}, leadId);
}

function toggleStatusDropdown(leadId) {
    handleStatusDropdownToggle({stopPropagation: () => {}, preventDefault: () => {}}, leadId);
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.assigned-dropdown-container')) {
        document.querySelectorAll('.assigned-dropdown').forEach(dropdown => {
            dropdown.classList.add('hidden');
            dropdown.closest('.assigned-dropdown-container').querySelector('.assigned-chevron').style.transform = '';
        });
    }
    
    if (!e.target.closest('.status-dropdown-container')) {
        document.querySelectorAll('.status-dropdown').forEach(dropdown => {
            dropdown.classList.add('hidden');
            dropdown.closest('.status-dropdown-container').querySelector('.status-chevron').style.transform = '';
        });
    }
});

// Enhanced handler functions with anti-duplication
function handleStatusUpdate(event, leadId, statusId, statusName) {
    event.stopPropagation();
    event.preventDefault();
    hideStatusDropdown(leadId);
    updateLeadStatus(leadId, statusId, statusName);
}

function handleAssignmentUpdate(event, leadId, agentId, agentName) {
    event.stopPropagation();
    event.preventDefault();
    hideAssignedDropdown(leadId);
    updateLeadAssignment(leadId, agentId, agentName);
}

// Anti-duplicate notification system
const notificationQueue = new Set();

async function updateLeadStatus(leadId, statusId, statusName) {
    const updateKey = `status-${leadId}-${statusId}`;
    
    // Prevent duplicate requests
    if (notificationQueue.has(updateKey)) {
        console.log('Status update already in progress for lead:', leadId);
        return;
    }
    
    notificationQueue.add(updateKey);
    
    try {
        const response = await fetch(`/admin/dashboard/leads/${leadId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status_id: statusId })
        });
        
        if (response.ok) {
            const responseData = await response.json();
            
            // Update button styling and text
            const container = document.querySelector(`[data-lead-id="${leadId}"] .status-dropdown-container`);
            const button = container.querySelector('.status-button');
            const statusNameSpan = button.querySelector('.status-name');
            if (button && statusNameSpan) {
                // Remove all status classes
                button.classList.remove(
                    'bg-green-100', 'text-green-800', 'border-green-200', 'hover:bg-green-200', 'focus:ring-green-500',
                    'bg-blue-100', 'text-blue-800', 'border-blue-200', 'hover:bg-blue-200', 'focus:ring-blue-500',
                    'bg-yellow-100', 'text-yellow-800', 'border-yellow-200', 'hover:bg-yellow-200', 'focus:ring-yellow-500',
                    'bg-emerald-100', 'text-emerald-800', 'border-emerald-200', 'hover:bg-emerald-200', 'focus:ring-emerald-500',
                    'bg-red-100', 'text-red-800', 'border-red-200', 'hover:bg-red-200', 'focus:ring-red-500',
                    'bg-gray-100', 'text-gray-800', 'border-gray-200', 'hover:bg-gray-200', 'focus:ring-gray-500'
                );
                
                // Update status name text
                statusNameSpan.textContent = statusName;
                
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
            
            // Show notification ONLY ONCE
            showNotification('Status başarıyla güncellendi', 'success');
        } else {
            throw new Error('Status güncellenemedi');
        }
    } catch (error) {
        console.error('Status güncelleme hatası:', error);
        showNotification('Status güncellenirken hata oluştu', 'error');
    } finally {
        // Remove from queue after 1 second to prevent future duplicates
        setTimeout(() => {
            notificationQueue.delete(updateKey);
        }, 1000);
    }
}

// Enhanced assignment update function with anti-duplication
async function updateLeadAssignment(leadId, agentId, agentName) {
    const updateKey = `assignment-${leadId}-${agentId}`;
    
    // Prevent duplicate requests
    if (notificationQueue.has(updateKey)) {
        console.log('Assignment update already in progress for lead:', leadId);
        return;
    }
    
    notificationQueue.add(updateKey);
    
    try {
        console.log('🪲 NEW ENDPOINT:', `/admin/dashboard/leads/api/${leadId}/assignment`);
        console.log('🪲 CACHE BUSTED:', new Date().getTime());
        const response = await fetch(`/admin/dashboard/leads/api/${leadId}/assignment?cb=${Date.now()}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ assign_to: agentId })
        });
        
        if (response.ok) {
            // Update the UI
            const button = document.querySelector(`[data-lead-id="${leadId}"] .assigned-button`);
            if (button) {
                showAssignmentUpdateSuccess(button);
            }
            
            // Show notification ONLY ONCE
            showNotification('Atama başarıyla güncellendi', 'success');
        } else {
            throw new Error('Atama güncellenemedi');
        }
    } catch (error) {
        console.error('Atama güncelleme hatası:', error);
        showNotification('Atama güncellenirken hata oluştu', 'error');
    } finally {
        // Remove from queue after 1 second to prevent future duplicates
        setTimeout(() => {
            notificationQueue.delete(updateKey);
        }, 1000);
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

// Enhanced notification system with deduplication
const activeNotifications = new Map();

function showNotification(message, type = 'info', duration = 3000) {
    // Create unique key for this notification
    const notificationKey = `${type}-${message}`;
    
    // If this exact notification is already showing, don't show another
    if (activeNotifications.has(notificationKey)) {
        console.log('Duplicate notification prevented:', message);
        return;
    }
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        type === 'warning' ? 'bg-yellow-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    
    notification.innerHTML = `
        <div class="flex items-center">
            <x-heroicon name="${type === 'success' ? 'check-circle' :
                             type === 'error' ? 'x-circle' :
                             type === 'warning' ? 'alert-triangle' : 'info'}" class="w-5 h-5 mr-2" />
            <span>${message}</span>
            <button onclick="removeNotification('${notificationKey}')" class="ml-4 text-white hover:text-gray-200">
                <x-heroicon name="x-mark" class="w-4 h-4" />
            </button>
        </div>
    `;
    
    // Track this notification
    activeNotifications.set(notificationKey, notification);
    
    document.body.appendChild(notification);
    
    // Initialize Lucide icons for the notification
    if (window.lucide) {
        window.
    }
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after duration
    setTimeout(() => {
        removeNotification(notificationKey);
    }, duration);
}

function removeNotification(notificationKey) {
    const notification = activeNotifications.get(notificationKey);
    if (notification && document.body.contains(notification)) {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
            activeNotifications.delete(notificationKey);
        }, 300);
    }
}

// Global function for removing notifications
window.removeNotification = removeNotification;
</script>
@endPushOnce