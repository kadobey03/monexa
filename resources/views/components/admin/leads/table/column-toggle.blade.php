<div
    id="column-settings-modal"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
    onclick="closeColumnSettingsModal(event)"
>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button
                    onclick="closeColumnSettingsModal()"
                    class="bg-white dark:bg-admin-800 rounded-md text-gray-400 hover:text-gray-600 focus:outline-none"
                >
                    <x-heroicon name="x-mark" class="h-6 w-6" />
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
                                onclick="resetToDefaults()"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-admin-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600"
                            >
                                <x-heroicon name="arrow-path" class="w-4 h-4 mr-2" />
                                Sıfırla
                            </button>
                            
                            <button
                                onclick="saveColumnSettings()"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700"
                            >
                                <x-heroicon name="save" class="w-4 h-4 mr-2" />
                                Kaydet
                            </button>
                        </div>
                    </div>
                    
                    <!-- Column List -->
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        <div
                            id="column-list"
                            class="space-y-2"
                        >
                            @if(isset($availableColumns))
                                @foreach($availableColumns as $index => $column)
                                <div
                                    id="column-item-{{ $column['key'] ?? $index }}"
                                    class="flex items-center justify-between p-4 bg-gray-50 dark:bg-admin-900 rounded-lg border-2 border-transparent hover:border-blue-200 dark:hover:border-blue-800 transition-all duration-200 column-item"
                                    draggable="true"
                                    ondragstart="dragStart(event, {{ $index }})"
                                    ondragover="event.preventDefault()"
                                    ondrop="drop(event, {{ $index }})"
                                >
                                    <div class="flex items-center space-x-4">
                                        <!-- Drag Handle -->
                                        <div
                                            id="drag-handle-{{ $column['key'] ?? $index }}"
                                            class="cursor-move text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                        >
                                            <x-heroicon name="grip-vertical" class="w-5 h-5" />
                                        </div>
                                        
                                        <!-- Column Info -->
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <!-- Visibility Toggle -->
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input
                                                        type="checkbox"
                                                        class="sr-only peer"
                                                        id="toggle-{{ $column['key'] ?? $index }}"
                                                        name="column_visibility[]"
                                                        value="{{ $column['key'] ?? $index }}"
                                                        onchange="toggleColumnVisibility('{{ $column['key'] ?? $index }}')"
                                                    >
                                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                </label>
                                                
                                                <!-- Column Label -->
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $column['label'] ?? 'Sütun' }}</h4>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $column['description'] ?? $column['key'] ?? 'Açıklama' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Column Controls -->
                                        <div class="flex items-center space-x-4">
                                            <!-- Width Control -->
                                            @if(isset($column['resizable']) && $column['resizable'])
                                            <div
                                                class="flex items-center space-x-2"
                                                id="width-control-{{ $column['key'] ?? $index }}"
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
                                                    id="width-slider-{{ $column['key'] ?? $index }}"
                                                    value="{{ $column['width'] ?? 150 }}"
                                                    oninput="updateColumnWidth('{{ $column['key'] ?? $index }}', this.value)"
                                                >
                                                <span
                                                    class="text-xs text-gray-500 dark:text-gray-400 w-10 text-right"
                                                    id="width-display-{{ $column['key'] ?? $index }}"
                                                >{{ $column['width'] ?? 150 }}px</span>
                                            </div>
                                            @endif
                                            
                                            <!-- Pin Control -->
                                            @if(isset($column['pinnable']) && $column['pinnable'])
                                            <button
                                                onclick="toggleColumnPin('{{ $column['key'] ?? $index }}')"
                                                id="pin-btn-{{ $column['key'] ?? $index }}"
                                                class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg transition-colors"
                                                title="Sabitle"
                                            >
                                                <x-heroicon name="pin" class="w-4 h-4" />
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    Sütun bilgileri yüklenmedi
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Summary -->
                    <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <x-heroicon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" />
                            <div class="text-sm text-blue-800 dark:text-blue-200">
                                <p class="font-medium mb-1">Özet</p>
                                <p>
                                    <span id="visible-columns-count">{{ isset($availableColumns) ? count($availableColumns) : 0 }}</span> sütun gösteriliyor,
                                    <span id="pinned-columns-count">0</span> sütun sabitlenmiş
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
// Column settings management functions
let draggedIndex = null;

function closeColumnSettingsModal(event) {
    if (event && event.target !== event.currentTarget) return;
    document.getElementById('column-settings-modal').style.display = 'none';
}

function resetToDefaults() {
    console.log('Resetting to default columns...');
    // Will be implemented in JavaScript task
}

function saveColumnSettings() {
    console.log('Saving column settings...');
    // Will be implemented in JavaScript task
}

function toggleColumnVisibility(columnKey) {
    console.log('Toggling visibility for column:', columnKey);
    // Will be implemented in JavaScript task
}

function updateColumnWidth(columnKey, width) {
    const display = document.getElementById(`width-display-${columnKey}`);
    if (display) {
        display.textContent = width + 'px';
    }
    console.log('Updating width for column:', columnKey, 'to', width);
    // Will be implemented in JavaScript task
}

function toggleColumnPin(columnKey) {
    console.log('Toggling pin for column:', columnKey);
    // Will be implemented in JavaScript task
}

// Drag and drop functions
function dragStart(event, index) {
    draggedIndex = index;
    event.dataTransfer.effectAllowed = 'move';
    event.target.classList.add('opacity-50');
}

function drop(event, dropIndex) {
    event.preventDefault();
    
    if (draggedIndex === null || draggedIndex === dropIndex) {
        return;
    }
    
    console.log('Dropping item from', draggedIndex, 'to', dropIndex);
    // Will be implemented in JavaScript task
    
    draggedIndex = null;
    
    // Remove drag styling
    document.querySelectorAll('.opacity-50').forEach(el => {
        el.classList.remove('opacity-50');
    });
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