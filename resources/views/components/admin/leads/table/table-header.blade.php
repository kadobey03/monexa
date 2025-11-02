<thead class="bg-gray-50 dark:bg-admin-900">
    <tr>
        <!-- Select All Checkbox -->
        <th class="px-6 py-4 text-left w-12">
            <input
                type="checkbox"
                id="select-all-checkbox"
                name="select_all"
                onchange="toggleAllLeads(this.checked)"
                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
            >
        </th>
        
        <!-- ÜLKE Column -->
        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
            onclick="toggleSort('country')">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span>ÜLKE</span>
                    <div class="flex flex-col">
                        <i
                            data-lucide="chevron-up"
                            class="w-3 h-3 text-gray-400"
                            id="sort-up-country"
                        ></i>
                        <i
                            data-lucide="chevron-down"
                            class="w-3 h-3 -mt-1 text-gray-400"
                            id="sort-down-country"
                        ></i>
                    </div>
                </div>
            </div>
        </th>
        
        <!-- AD SOYAD Column -->
        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
            onclick="toggleSort('name')">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span>AD SOYAD</span>
                    <div class="flex flex-col">
                        <i
                            data-lucide="chevron-up"
                            class="w-3 h-3 text-gray-400"
                            id="sort-up-name"
                        ></i>
                        <i
                            data-lucide="chevron-down"
                            class="w-3 h-3 -mt-1 text-gray-400"
                            id="sort-down-name"
                        ></i>
                    </div>
                </div>
            </div>
        </th>
        
        <!-- TELEFON NUMARASI Column -->
        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
            onclick="toggleSort('phone')">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span>TELEFON NUMARASI</span>
                    <div class="flex flex-col">
                        <i
                            data-lucide="chevron-up"
                            class="w-3 h-3 text-gray-400"
                            id="sort-up-phone"
                        ></i>
                        <i
                            data-lucide="chevron-down"
                            class="w-3 h-3 -mt-1 text-gray-400"
                            id="sort-down-phone"
                        ></i>
                    </div>
                </div>
            </div>
        </th>
        
        <!-- EMAİL Column -->
        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
            onclick="toggleSort('email')">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span>EMAİL</span>
                    <div class="flex flex-col">
                        <i
                            data-lucide="chevron-up"
                            class="w-3 h-3 text-gray-400"
                            id="sort-up-email"
                        ></i>
                        <i
                            data-lucide="chevron-down"
                            class="w-3 h-3 -mt-1 text-gray-400"
                            id="sort-down-email"
                        ></i>
                    </div>
                </div>
            </div>
        </th>
        
        <!-- ASSIGNED Column -->
        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
            onclick="toggleSort('assign_to')">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span>ASSIGNED</span>
                    <div class="flex flex-col">
                        <i
                            data-lucide="chevron-up"
                            class="w-3 h-3 text-gray-400"
                            id="sort-up-assign_to"
                        ></i>
                        <i
                            data-lucide="chevron-down"
                            class="w-3 h-3 -mt-1 text-gray-400"
                            id="sort-down-assign_to"
                        ></i>
                    </div>
                </div>
            </div>
        </th>
        
        <!-- STATUS Column -->
        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
            onclick="toggleSort('lead_status_id')">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span>STATUS</span>
                    <div class="flex flex-col">
                        <i
                            data-lucide="chevron-up"
                            class="w-3 h-3 text-gray-400"
                            id="sort-up-lead_status_id"
                        ></i>
                        <i
                            data-lucide="chevron-down"
                            class="w-3 h-3 -mt-1 text-gray-400"
                            id="sort-down-lead_status_id"
                        ></i>
                    </div>
                </div>
            </div>
        </th>
        
        <!-- VARONKA Column -->
        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
            onclick="toggleSort('organization')">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span>VARONKA</span>
                    <div class="flex flex-col">
                        <i
                            data-lucide="chevron-up"
                            class="w-3 h-3 text-gray-400"
                            id="sort-up-organization"
                        ></i>
                        <i
                            data-lucide="chevron-down"
                            class="w-3 h-3 -mt-1 text-gray-400"
                            id="sort-down-organization"
                        ></i>
                    </div>
                </div>
            </div>
        </th>
        
        <!-- KAYNAK Column -->
        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
            onclick="toggleSort('lead_source_id')">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span>KAYNAK</span>
                    <div class="flex flex-col">
                        <i
                            data-lucide="chevron-up"
                            class="w-3 h-3 text-gray-400"
                            id="sort-up-lead_source_id"
                        ></i>
                        <i
                            data-lucide="chevron-down"
                            class="w-3 h-3 -mt-1 text-gray-400"
                            id="sort-down-lead_source_id"
                        ></i>
                    </div>
                </div>
            </div>
        </th>
        
        <!-- ŞİRKET Column -->
        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
            onclick="toggleSort('company_name')">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span>ŞİRKET</span>
                    <div class="flex flex-col">
                        <i
                            data-lucide="chevron-up"
                            class="w-3 h-3 text-gray-400"
                            id="sort-up-company_name"
                        ></i>
                        <i
                            data-lucide="chevron-down"
                            class="w-3 h-3 -mt-1 text-gray-400"
                            id="sort-down-company_name"
                        ></i>
                    </div>
                </div>
            </div>
        </th>
    </tr>
</thead>

@pushOnce('styles')
<style>
/* Modern Table Header Styling */
.table-header-modern {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 2px solid #e2e8f0;
}

.table-header-modern th {
    font-weight: 600;
    font-size: 0.875rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    padding: 1rem 1.5rem;
    position: relative;
    transition: all 0.2s ease;
}

.table-header-modern th:hover {
    background-color: rgba(59, 130, 246, 0.05);
    transform: translateY(-1px);
}

.table-header-modern th.sortable {
    cursor: pointer;
    user-select: none;
}

.table-header-modern th.sorted-asc,
.table-header-modern th.sorted-desc {
    background-color: rgba(59, 130, 246, 0.1);
    color: #1d4ed8;
}

/* Sort indicators */
.sort-indicator {
    display: inline-flex;
    flex-direction: column;
    margin-left: 0.5rem;
}

.sort-indicator i {
    transition: color 0.2s ease;
}

/* Hover effects */
.table-header-modern th:hover .sort-indicator i {
    color: #64748b;
}

/* Active sort styling */
.table-header-modern th[data-sorted="asc"] .sort-up,
.table-header-modern th[data-sorted="desc"] .sort-down {
    color: #2563eb;
}

/* Column specific styling with adjusted widths */
.table-header-modern .checkbox-column {
    width: 60px;
    min-width: 60px;
}

.table-header-modern .country-column {
    width: 120px;
    min-width: 120px;
}

.table-header-modern .name-column {
    width: 200px;
    min-width: 200px;
}

.table-header-modern .phone-column {
    width: 180px;
    min-width: 180px;
}

.table-header-modern .email-column {
    width: 220px;
    min-width: 220px;
}

.table-header-modern .assigned-column {
    width: 160px;
    min-width: 160px;
}

.table-header-modern .status-column {
    width: 140px;
    min-width: 140px;
}

.table-header-modern .varonka-column {
    width: 180px;
    min-width: 180px;
}

.table-header-modern .source-column {
    width: 120px;
    min-width: 120px;
}

.table-header-modern .company-column {
    width: 180px;
    min-width: 180px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table-header-modern th {
        padding: 0.75rem 1rem;
        font-size: 0.75rem;
    }
}

/* Dark mode enhancements */
.dark .table-header-modern {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    border-bottom-color: #475569;
}

.dark .table-header-modern th:hover {
    background-color: rgba(59, 130, 246, 0.1);
}

/* Focus states */
.table-header-modern input[type="checkbox"]:focus {
    outline: none;
    ring: 2px;
    ring-color: #3b82f6;
    ring-offset: 2px;
}
</style>
@endPushOnce

@pushOnce('scripts')
<script>
// Modern table header functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add mobile labels for responsive design
    const headers = document.querySelectorAll('.table-header-modern th');
    const mobileLabels = ['', 'Ülke', 'Ad Soyad', 'Telefon', 'Email', 'Assigned', 'Status', 'Varonka', 'Kaynak', 'Şirket'];
    
    headers.forEach((header, index) => {
        if (mobileLabels[index]) {
            header.setAttribute('data-mobile-label', mobileLabels[index]);
        }
    });
    
    // Enhanced sort functionality
    function updateSortIndicators(sortColumn, sortDirection) {
        // Reset all headers
        headers.forEach(header => {
            header.removeAttribute('data-sorted');
            const icons = header.querySelectorAll('i');
            icons.forEach(icon => {
                icon.classList.remove('text-blue-600');
                icon.classList.add('text-gray-400');
            });
        });
        
        // Update active header
        const activeHeader = document.querySelector(`th[data-column="${sortColumn}"]`);
        if (activeHeader) {
            activeHeader.setAttribute('data-sorted', sortDirection);
            
            const icon = activeHeader.querySelector(sortDirection === 'asc' ? 
                'i[data-lucide="chevron-up"]' : 
                'i[data-lucide="chevron-down"]'
            );
            
            if (icon) {
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-blue-600');
            }
        }
    }
    
    // Listen for sort changes
    window.addEventListener('sort-changed', function(event) {
        const { column, direction } = event.detail;
        updateSortIndicators(column, direction);
    });
});

// Select all functionality enhancement
function toggleAllLeads(checked) {
    const checkboxes = document.querySelectorAll('.lead-checkbox');
    const tbody = document.querySelector('#leads-table-body');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = checked;
        
        // Add visual feedback
        const row = checkbox.closest('tr');
        if (row) {
            if (checked) {
                row.classList.add('bg-blue-50', 'border-l-4', 'border-blue-500');
            } else {
                row.classList.remove('bg-blue-50', 'border-l-4', 'border-blue-500');
            }
        }
    });
    
    // Update bulk action UI
    const selectedCount = checked ? checkboxes.length : 0;
    updateBulkActionUI(selectedCount);
}

function updateBulkActionUI(count) {
    const bulkActions = document.querySelector('#bulk-actions');
    const selectedCounter = document.querySelector('#selected-count');
    
    if (bulkActions) {
        if (count > 0) {
            bulkActions.classList.remove('hidden');
            if (selectedCounter) {
                selectedCounter.textContent = count;
            }
        } else {
            bulkActions.classList.add('hidden');
        }
    }
}

// Enhanced sorting with animation
function toggleSort(column) {
    const event = new CustomEvent('sort-requested', {
        detail: { column: column },
        bubbles: true
    });
    
    document.dispatchEvent(event);
}
</script>
@endPushOnce