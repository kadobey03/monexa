<div 
    x-show="showColumnSettings" 
    @click.away="showColumnSettings = false"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="transform opacity-0 translate-y-1"
    x-transition:enter-end="transform opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="transform opacity-100 translate-y-0"
    x-transition:leave-end="transform opacity-0 translate-y-1"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button 
                    @click="showColumnSettings = false"
                    class="bg-white dark:bg-admin-800 rounded-md text-gray-400 hover:text-gray-600 focus:outline-none"
                >
                    <i data-lucide="x" class="h-6 w-6"></i>
                </button>
            </div>
            
            <div class="sm:flex sm:items-start">
                <div class="w-full">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Sütun Ayarları
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Tabloda gösterilecek sütunları seçin ve düzenleyin
                            </p>
                        </div>
                        
                        <div class="flex space-x-2">
                            <button 
                                @click="resetToDefaults()"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-admin-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600"
                            >
                                <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                                Sıfırla
                            </button>
                            
                            <button 
                                @click="saveColumnSettings()"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700"
                            >
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                    
                    <!-- Column List -->
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        <div 
                            x-data="columnDragDrop()"
                            class="space-y-2"
                        >
                            <template x-for="(column, index) in availableColumns" :key="column.key">
                                <div 
                                    class="flex items-center justify-between p-4 bg-gray-50 dark:bg-admin-900 rounded-lg border-2 border-transparent hover:border-blue-200 dark:hover:border-blue-800 transition-all duration-200"
                                    :class="{
                                        'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800': visibleColumns.find(c => c.key === column.key),
                                        'opacity-50': !visibleColumns.find(c => c.key === column.key)
                                    }"
                                    :draggable="visibleColumns.find(c => c.key === column.key) ? true : false"
                                    @dragstart="dragStart($event, index)"
                                    @dragover.prevent
                                    @drop="drop($event, index)"
                                >
                                    <div class="flex items-center space-x-4">
                                        <!-- Drag Handle -->
                                        <div 
                                            class="cursor-move text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                            x-show="visibleColumns.find(c => c.key === column.key)"
                                        >
                                            <i data-lucide="grip-vertical" class="w-5 h-5"></i>
                                        </div>
                                        
                                        <!-- Column Info -->
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <!-- Visibility Toggle -->
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input 
                                                        type="checkbox" 
                                                        class="sr-only peer"
                                                        :checked="!!visibleColumns.find(c => c.key === column.key)"
                                                        @change="toggleColumnVisibility(column.key)"
                                                    >
                                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                </label>
                                                
                                                <!-- Column Label -->
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-white" x-text="column.label"></h4>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="column.description || column.key"></p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Column Controls -->
                                        <div class="flex items-center space-x-4">
                                            <!-- Width Control -->
                                            <div 
                                                class="flex items-center space-x-2"
                                                x-show="visibleColumns.find(c => c.key === column.key) && column.resizable"
                                            >
                                                <label class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                                    Genişlik:
                                                </label>
                                                <input 
                                                    type="range" 
                                                    min="80" 
                                                    max="400" 
                                                    step="10"
                                                    class="w-20 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                                                    :value="getColumnWidth(column.key)"
                                                    @input="updateColumnWidth(column.key, $event.target.value)"
                                                >
                                                <span 
                                                    class="text-xs text-gray-500 dark:text-gray-400 w-10 text-right"
                                                    x-text="getColumnWidth(column.key) + 'px'"
                                                ></span>
                                            </div>
                                            
                                            <!-- Pin Control -->
                                            <button 
                                                x-show="visibleColumns.find(c => c.key === column.key) && column.pinnable"
                                                @click="toggleColumnPin(column.key)"
                                                class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg transition-colors"
                                                :class="{
                                                    'text-blue-600 dark:text-blue-400': pinnedColumns.includes(column.key),
                                                    'text-gray-400': !pinnedColumns.includes(column.key)
                                                }"
                                                :title="pinnedColumns.includes(column.key) ? 'Sabitlemeyi Kaldır' : 'Sabitle'"
                                            >
                                                <i data-lucide="pin" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    
                    <!-- Summary -->
                    <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <i data-lucide="info" class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5"></i>
                            <div class="text-sm text-blue-800 dark:text-blue-200">
                                <p class="font-medium mb-1">Özet</p>
                                <p>
                                    <span x-text="visibleColumns.length"></span> sütun gösteriliyor, 
                                    <span x-text="pinnedColumns.length"></span> sütun sabitlenmiş
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@pushOnce('scripts')
<script>
function columnDragDrop() {
    return {
        draggedIndex: null,
        
        dragStart(event, index) {
            this.draggedIndex = index;
            event.dataTransfer.effectAllowed = 'move';
            event.target.classList.add('opacity-50');
        },
        
        drop(event, dropIndex) {
            event.preventDefault();
            
            if (this.draggedIndex === null || this.draggedIndex === dropIndex) {
                return;
            }
            
            // Reorder visible columns
            const draggedColumn = this.visibleColumns[this.draggedIndex];
            const newVisibleColumns = [...this.visibleColumns];
            
            // Remove dragged item
            newVisibleColumns.splice(this.draggedIndex, 1);
            
            // Insert at new position
            if (dropIndex > this.draggedIndex) {
                newVisibleColumns.splice(dropIndex - 1, 0, draggedColumn);
            } else {
                newVisibleColumns.splice(dropIndex, 0, draggedColumn);
            }
            
            this.visibleColumns = newVisibleColumns;
            this.draggedIndex = null;
            
            // Remove drag styling
            document.querySelectorAll('.opacity-50').forEach(el => {
                el.classList.remove('opacity-50');
            });
        }
    }
}
</script>
@endPushOnce

@pushOnce('styles')
<style>
/* Custom range slider styles */
input[type="range"]::-webkit-slider-thumb {
    appearance: none;
    height: 16px;
    width: 16px;
    border-radius: 50%;
    background: #3b82f6;
    cursor: pointer;
    border: 2px solid #ffffff;
    box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
}

input[type="range"]::-moz-range-thumb {
    height: 16px;
    width: 16px;
    border-radius: 50%;
    background: #3b82f6;
    cursor: pointer;
    border: 2px solid #ffffff;
    box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
}

/* Drag and drop styles */
.column-item.dragging {
    opacity: 0.5;
    transform: rotate(5deg);
}

.column-item.drag-over {
    background-color: rgba(59, 130, 246, 0.1);
    border-color: #3b82f6;
}
</style>
@endPushOnce