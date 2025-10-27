<thead class="bg-gray-50 dark:bg-admin-900">
    <tr>
        <!-- Select All Checkbox -->
        <th class="px-6 py-3 text-left w-12">
            <input 
                type="checkbox" 
                x-model="selectAll"
                @change="toggleAllLeads($event.target.checked)"
                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
            >
        </th>
        
        <!-- Dynamic Columns -->
        <template x-for="column in visibleColumns" :key="column.key">
            <th 
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider relative group"
                :class="{
                    'cursor-pointer select-none': column.sortable,
                    'bg-blue-50 dark:bg-blue-900/20': sortColumn === column.key,
                    'sticky left-0 z-10': column.pinned
                }"
                :style="column.width ? `width: ${column.width}px; min-width: ${column.width}px;` : ''"
                @click="column.sortable && toggleSort(column.key)"
            >
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <!-- Column Label -->
                        <span x-text="column.label"></span>
                        
                        <!-- Sort Icons -->
                        <div x-show="column.sortable" class="flex flex-col">
                            <i 
                                data-lucide="chevron-up" 
                                class="w-3 h-3"
                                :class="{
                                    'text-blue-600': sortColumn === column.key && sortDirection === 'asc',
                                    'text-gray-400': sortColumn !== column.key || sortDirection !== 'asc'
                                }"
                            ></i>
                            <i 
                                data-lucide="chevron-down" 
                                class="w-3 h-3 -mt-1"
                                :class="{
                                    'text-blue-600': sortColumn === column.key && sortDirection === 'desc',
                                    'text-gray-400': sortColumn !== column.key || sortDirection !== 'desc'
                                }"
                            ></i>
                        </div>
                    </div>
                    
                    <!-- Column Actions -->
                    <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <!-- Pin/Unpin Button -->
                        <button 
                            x-show="column.pinnable"
                            @click.stop="toggleColumnPin(column.key)"
                            :title="column.pinned ? 'Sabitlemeyi Kaldır' : 'Sabitle'"
                            class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded"
                        >
                            <i 
                                data-lucide="pin" 
                                class="w-3 h-3"
                                :class="{
                                    'text-blue-600': column.pinned,
                                    'text-gray-400': !column.pinned
                                }"
                            ></i>
                        </button>
                        
                        <!-- Column Settings -->
                        <div class="relative" x-data="{ open: false }">
                            <button 
                                @click.stop="open = !open"
                                class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded"
                            >
                                <i data-lucide="more-vertical" class="w-3 h-3"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div 
                                x-show="open" 
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 top-8 w-48 bg-white dark:bg-admin-800 rounded-md shadow-lg border border-gray-200 dark:border-admin-700 py-1 z-20"
                                style="display: none;"
                            >
                                <button 
                                    @click="hideColumn(column.key); open = false"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700"
                                >
                                    <i data-lucide="eye-off" class="w-4 h-4 mr-2 inline"></i>
                                    Sütunu Gizle
                                </button>
                                
                                <template x-if="column.key !== 'actions'">
                                    <button 
                                        @click="resetColumnWidth(column.key); open = false"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700"
                                    >
                                        <i data-lucide="maximize" class="w-4 h-4 mr-2 inline"></i>
                                        Genişliği Sıfırla
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Resize Handle -->
                <div 
                    x-show="column.resizable && column.key !== 'actions'"
                    class="absolute right-0 top-0 w-1 h-full cursor-col-resize bg-transparent hover:bg-blue-500 resize-handle"
                    @mousedown="startResize($event, column.key)"
                ></div>
            </th>
        </template>
    </tr>
</thead>

@pushOnce('scripts')
<script>
// Column resize functionality
function startResize(event, columnKey) {
    event.preventDefault();
    
    const startX = event.clientX;
    const column = document.querySelector(`[data-column="${columnKey}"]`);
    const startWidth = column.offsetWidth;
    
    function doResize(e) {
        const newWidth = Math.max(80, startWidth + (e.clientX - startX));
        
        // Update column width
        column.style.width = newWidth + 'px';
        column.style.minWidth = newWidth + 'px';
        
        // Dispatch resize event
        window.dispatchEvent(new CustomEvent('column-resized', {
            detail: { columnKey, newWidth }
        }));
    }
    
    function stopResize() {
        document.removeEventListener('mousemove', doResize);
        document.removeEventListener('mouseup', stopResize);
    }
    
    document.addEventListener('mousemove', doResize);
    document.addEventListener('mouseup', stopResize);
}
</script>
@endPushOnce

@pushOnce('styles')
<style>
.resize-handle {
    transition: background-color 0.2s;
}

.resize-handle:hover {
    background-color: #3b82f6;
    width: 2px;
}

/* Pinned columns styling */
th.sticky {
    position: sticky;
    background-color: inherit;
    z-index: 10;
}

/* Sort transition */
th[data-sortable="true"]:hover {
    background-color: rgba(59, 130, 246, 0.05);
}

/* Column drag and drop */
.column-dragging {
    opacity: 0.5;
    transform: rotate(5deg);
}

.column-drop-target {
    background-color: rgba(59, 130, 246, 0.1);
    border-left: 2px solid #3b82f6;
}
</style>
@endPushOnce