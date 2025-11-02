<template>
  <div class="smart-data-table">
    <!-- Table Header with Column Controls -->
    <div class="table-header bg-gray-50 border-b border-gray-200 p-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
          <!-- Select All Checkbox -->
          <label class="flex items-center">
            <input
              type="checkbox"
              :checked="isAllSelected"
              :indeterminate="isPartiallySelected"
              @change="toggleSelectAll"
              class="form-checkbox"
            />
            <span class="ml-2 text-sm text-gray-600">Select All</span>
          </label>
          
          <!-- Column Visibility Toggle -->
          <div class="relative">
            <button
              @click="showColumnControls = !showColumnControls"
              class="btn btn-outline-secondary btn-sm"
            >
              <i class="fas fa-columns mr-2"></i>
              Columns
            </button>
            
            <!-- Column Controls Dropdown -->
            <div
              v-show="showColumnControls"
              class="absolute top-full left-0 mt-1 w-64 bg-white shadow-lg border rounded-lg p-4 z-10"
            >
              <div class="space-y-2 max-h-64 overflow-y-auto">
                <div
                  v-for="column in availableColumns"
                  :key="column.key"
                  class="flex items-center justify-between"
                >
                  <label class="flex items-center cursor-pointer">
                    <input
                      type="checkbox"
                      :checked="column.visible"
                      @change="toggleColumnVisibility(column.key)"
                      class="form-checkbox"
                    />
                    <span class="ml-2 text-sm">{{ column.label }}</span>
                  </label>
                  
                  <!-- Pin Button -->
                  <button
                    v-if="column.pinnable"
                    @click="toggleColumnPin(column.key)"
                    :class="[
                      'text-xs p-1 rounded',
                      column.pinned ? 'text-blue-600 bg-blue-100' : 'text-gray-400 hover:text-gray-600'
                    ]"
                    title="Pin Column"
                  >
                    <i class="fas fa-thumbtack"></i>
                  </button>
                </div>
              </div>
              
              <div class="mt-3 pt-3 border-t space-y-2">
                <button
                  @click="resetColumns"
                  class="w-full btn btn-outline-secondary btn-sm"
                >
                  Reset to Default
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Table Actions -->
        <div class="flex items-center space-x-2">
          <span class="text-sm text-gray-600">
            Showing {{ paginationInfo }}
          </span>
        </div>
      </div>
    </div>

    <!-- Table Container with Horizontal Scroll -->
    <div class="table-container overflow-x-auto">
      <table class="min-w-full bg-white">
        <!-- Table Header -->
        <thead class="bg-gray-50">
          <tr>
            <!-- Row Selection Column -->
            <th class="sticky left-0 bg-gray-50 px-4 py-3 w-12">
              <!-- Empty header for checkbox column -->
            </th>
            
            <!-- Dynamic Columns -->
            <th
              v-for="(column, index) in visibleColumns"
              :key="column.key"
              :class="[
                'px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200',
                column.pinned ? 'sticky bg-gray-50' : '',
                column.sortable ? 'cursor-pointer hover:bg-gray-100' : '',
                getColumnClasses(column)
              ]"
              :style="getColumnStyles(column, index)"
              @click="column.sortable && handleSort(column.key)"
            >
              <div class="flex items-center justify-between group">
                <!-- Column Label -->
                <span>{{ column.label }}</span>
                
                <!-- Sort Icon -->
                <div v-if="column.sortable" class="flex items-center space-x-1">
                  <i
                    v-if="sortColumn === column.key"
                    :class="[
                      'fas',
                      sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down',
                      'text-blue-600'
                    ]"
                  ></i>
                  <i
                    v-else
                    class="fas fa-sort text-gray-300 group-hover:text-gray-500"
                  ></i>
                </div>
                
                <!-- Resize Handle -->
                <div
                  v-if="column.resizable !== false"
                  class="resize-handle absolute top-0 right-0 w-2 h-full cursor-col-resize hover:bg-blue-200"
                  @mousedown="startResize(column.key, $event)"
                ></div>
              </div>
            </th>
          </tr>
        </thead>

        <!-- Table Body -->
        <tbody class="bg-white divide-y divide-gray-200">
          <!-- Loading Row -->
          <tr v-if="loading">
            <td :colspan="visibleColumns.length + 1" class="px-4 py-8 text-center">
              <div class="flex items-center justify-center space-x-3">
                <i class="fas fa-spinner fa-spin text-blue-600"></i>
                <span class="text-gray-600">Loading...</span>
              </div>
            </td>
          </tr>
          
          <!-- Empty State -->
          <tr v-else-if="!data || data.length === 0">
            <td :colspan="visibleColumns.length + 1" class="px-4 py-8 text-center">
              <div class="text-gray-500">
                <i class="fas fa-inbox text-4xl mb-4"></i>
                <p class="text-lg font-medium">No data found</p>
                <p class="text-sm">Try adjusting your search or filters</p>
              </div>
            </td>
          </tr>
          
          <!-- Data Rows -->
          <tr
            v-for="(row, rowIndex) in data"
            :key="row.id || rowIndex"
            :class="[
              'hover:bg-gray-50 transition-colors duration-150',
              isRowSelected(row) ? 'bg-blue-50' : '',
              'cursor-pointer'
            ]"
            @click="handleRowClick(row)"
          >
            <!-- Row Selection Checkbox -->
            <td class="sticky left-0 bg-white px-4 py-4 w-12">
              <input
                type="checkbox"
                :checked="isRowSelected(row)"
                @change="toggleRowSelection(row)"
                @click.stop
                class="form-checkbox"
              />
            </td>
            
            <!-- Dynamic Column Cells -->
            <td
              v-for="(column, index) in visibleColumns"
              :key="`${row.id || rowIndex}-${column.key}`"
              :class="[
                'px-4 py-4 text-sm',
                column.pinned ? 'sticky bg-white' : '',
                getCellClasses(column, row)
              ]"
              :style="getColumnStyles(column, index)"
            >
              <!-- Slot Content -->
              <slot
                v-if="$slots[column.key]"
                :name="column.key"
                :row="row"
                :column="column"
                :value="getColumnValue(row, column)"
              ></slot>
              
              <!-- Default Cell Content -->
              <div v-else :class="getCellContentClasses(column)">
                {{ formatCellValue(getColumnValue(row, column), column) }}
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Table Footer with Pagination -->
    <div class="table-footer bg-gray-50 border-t border-gray-200 px-4 py-3">
      <div class="flex items-center justify-between">
        <!-- Per Page Selector -->
        <div class="flex items-center space-x-2">
          <span class="text-sm text-gray-600">Show</span>
          <select
            :value="pagination.per_page"
            @change="$emit('per-page-change', parseInt($event.target.value))"
            class="form-select form-select-sm"
          >
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="200">200</option>
          </select>
          <span class="text-sm text-gray-600">per page</span>
        </div>

        <!-- Pagination Controls -->
        <nav v-if="pagination.last_page > 1" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
          <!-- Previous Button -->
          <button
            :disabled="pagination.current_page === 1"
            @click="$emit('page-change', pagination.current_page - 1)"
            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <i class="fas fa-chevron-left"></i>
          </button>

          <!-- Page Numbers -->
          <template v-for="page in paginationPages" :key="page">
            <button
              v-if="page !== '...'"
              :class="[
                'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                page === pagination.current_page
                  ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                  : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
              ]"
              @click="$emit('page-change', page)"
            >
              {{ page }}
            </button>
            <span
              v-else
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700"
            >
              ...
            </span>
          </template>

          <!-- Next Button -->
          <button
            :disabled="pagination.current_page === pagination.last_page"
            @click="$emit('page-change', pagination.current_page + 1)"
            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <i class="fas fa-chevron-right"></i>
          </button>
        </nav>
      </div>
    </div>

    <!-- Column Resize Overlay -->
    <div
      v-if="resizing.active"
      class="fixed inset-0 bg-transparent cursor-col-resize z-50"
      @mousemove="handleResize"
      @mouseup="stopResize"
    ></div>
  </div>
</template>

<script>
import { defineComponent, ref, computed, reactive, watch } from 'vue'

export default defineComponent({
  name: 'SmartDataTable',
  props: {
    data: {
      type: Array,
      default: () => []
    },
    columns: {
      type: Array,
      required: true
    },
    loading: {
      type: Boolean,
      default: false
    },
    pagination: {
      type: Object,
      default: () => ({})
    },
    sortColumn: {
      type: String,
      default: ''
    },
    sortDirection: {
      type: String,
      default: 'asc'
    },
    selected: {
      type: Array,
      default: () => []
    }
  },
  emits: [
    'sort',
    'page-change',
    'per-page-change',
    'row-click',
    'column-resize',
    'column-reorder',
    'column-visibility',
    'update:selected'
  ],
  setup(props, { emit }) {
    // State
    const showColumnControls = ref(false)
    const availableColumns = ref([])
    const visibleColumns = ref([])
    const resizing = reactive({
      active: false,
      column: '',
      startX: 0,
      startWidth: 0
    })

    // Initialize columns
    watch(() => props.columns, (newColumns) => {
      availableColumns.value = [...newColumns]
      visibleColumns.value = newColumns.filter(col => col.visible !== false)
    }, { immediate: true })

    // Computed
    const isAllSelected = computed(() => {
      return props.data.length > 0 && props.selected.length === props.data.length
    })

    const isPartiallySelected = computed(() => {
      return props.selected.length > 0 && props.selected.length < props.data.length
    })

    const paginationInfo = computed(() => {
      const { from, to, total } = props.pagination
      return `${from || 0} to ${to || 0} of ${total || 0} results`
    })

    const paginationPages = computed(() => {
      const current = props.pagination.current_page || 1
      const last = props.pagination.last_page || 1
      const pages = []
      
      if (last <= 7) {
        for (let i = 1; i <= last; i++) {
          pages.push(i)
        }
      } else {
        pages.push(1)
        
        if (current > 4) {
          pages.push('...')
        }
        
        const start = Math.max(2, current - 2)
        const end = Math.min(last - 1, current + 2)
        
        for (let i = start; i <= end; i++) {
          pages.push(i)
        }
        
        if (current < last - 3) {
          pages.push('...')
        }
        
        pages.push(last)
      }
      
      return pages
    })

    // Methods
    const isRowSelected = (row) => {
      return props.selected.some(selected => selected.id === row.id)
    }

    const toggleRowSelection = (row) => {
      const isSelected = isRowSelected(row)
      let newSelected = [...props.selected]
      
      if (isSelected) {
        newSelected = newSelected.filter(selected => selected.id !== row.id)
      } else {
        newSelected.push(row)
      }
      
      emit('update:selected', newSelected)
    }

    const toggleSelectAll = () => {
      if (isAllSelected.value) {
        emit('update:selected', [])
      } else {
        emit('update:selected', [...props.data])
      }
    }

    const handleSort = (column) => {
      const direction = props.sortColumn === column && props.sortDirection === 'asc' ? 'desc' : 'asc'
      emit('sort', { column, direction })
    }

    const handleRowClick = (row) => {
      emit('row-click', row)
    }

    const toggleColumnVisibility = (columnKey) => {
      const column = availableColumns.value.find(col => col.key === columnKey)
      if (column) {
        column.visible = !column.visible
        visibleColumns.value = availableColumns.value.filter(col => col.visible !== false)
        emit('column-visibility', { column: columnKey, visible: column.visible })
      }
    }

    const toggleColumnPin = (columnKey) => {
      const column = availableColumns.value.find(col => col.key === columnKey)
      if (column && column.pinnable) {
        column.pinned = !column.pinned
        emit('column-pin', { column: columnKey, pinned: column.pinned })
      }
    }

    const resetColumns = () => {
      availableColumns.value.forEach(column => {
        column.visible = column.default_visible !== false
        column.pinned = column.default_pinned || false
        column.width = column.default_width || column.width
      })
      visibleColumns.value = availableColumns.value.filter(col => col.visible !== false)
      emit('column-reset')
    }

    const startResize = (columnKey, event) => {
      event.preventDefault()
      event.stopPropagation()
      
      resizing.active = true
      resizing.column = columnKey
      resizing.startX = event.clientX
      
      const column = availableColumns.value.find(col => col.key === columnKey)
      resizing.startWidth = column.width || 150
    }

    const handleResize = (event) => {
      if (!resizing.active) return
      
      const diff = event.clientX - resizing.startX
      const newWidth = Math.max(50, resizing.startWidth + diff)
      
      const column = availableColumns.value.find(col => col.key === resizing.column)
      if (column) {
        column.width = newWidth
      }
    }

    const stopResize = () => {
      if (resizing.active) {
        const column = availableColumns.value.find(col => col.key === resizing.column)
        if (column) {
          emit('column-resize', { column: resizing.column, width: column.width })
        }
      }
      
      resizing.active = false
      resizing.column = ''
      resizing.startX = 0
      resizing.startWidth = 0
    }

    const getColumnValue = (row, column) => {
      const keys = column.key.split('.')
      let value = row
      
      for (const key of keys) {
        value = value?.[key]
      }
      
      return value
    }

    const formatCellValue = (value, column) => {
      if (value === null || value === undefined) {
        return ''
      }
      
      switch (column.type) {
        case 'date':
          return new Date(value).toLocaleDateString()
        case 'datetime':
          return new Date(value).toLocaleString()
        case 'number':
          return Number(value).toLocaleString()
        case 'currency':
          return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
          }).format(value)
        case 'percentage':
          return `${Number(value).toFixed(1)}%`
        case 'boolean':
          return value ? 'Yes' : 'No'
        default:
          return String(value)
      }
    }

    const getColumnClasses = (column) => {
      return {
        'text-left': column.align === 'left' || !column.align,
        'text-center': column.align === 'center',
        'text-right': column.align === 'right',
      }
    }

    const getCellClasses = (column, row) => {
      const classes = {
        'text-left': column.align === 'left' || !column.align,
        'text-center': column.align === 'center',
        'text-right': column.align === 'right',
      }
      
      if (column.cellClass) {
        if (typeof column.cellClass === 'function') {
          classes[column.cellClass(row)] = true
        } else {
          classes[column.cellClass] = true
        }
      }
      
      return classes
    }

    const getCellContentClasses = (column) => {
      const classes = []
      
      if (column.truncate) {
        classes.push('truncate')
        classes.push(`max-w-[${column.truncate}px]`)
      }
      
      return classes.join(' ')
    }

    const getColumnStyles = (column, index) => {
      const styles = {}
      
      if (column.width) {
        styles.width = `${column.width}px`
        styles.minWidth = `${column.width}px`
      }
      
      if (column.pinned) {
        let left = 48 // Account for checkbox column
        for (let i = 0; i < index; i++) {
          const prevColumn = visibleColumns.value[i]
          if (prevColumn.pinned) {
            left += prevColumn.width || 150
          }
        }
        styles.left = `${left}px`
        styles.zIndex = 10
      }
      
      return styles
    }

    return {
      // State
      showColumnControls,
      availableColumns,
      visibleColumns,
      resizing,
      
      // Computed
      isAllSelected,
      isPartiallySelected,
      paginationInfo,
      paginationPages,
      
      // Methods
      isRowSelected,
      toggleRowSelection,
      toggleSelectAll,
      handleSort,
      handleRowClick,
      toggleColumnVisibility,
      toggleColumnPin,
      resetColumns,
      startResize,
      handleResize,
      stopResize,
      getColumnValue,
      formatCellValue,
      getColumnClasses,
      getCellClasses,
      getCellContentClasses,
      getColumnStyles,
    }
  }
})
</script>

<style scoped>
.smart-data-table {
  @apply bg-white rounded-lg shadow overflow-hidden;
}

.table-container {
  position: relative;
}

.resize-handle {
  position: absolute;
  top: 0;
  right: 0;
  width: 4px;
  height: 100%;
  cursor: col-resize;
  opacity: 0;
  transition: opacity 0.2s;
}

.resize-handle:hover {
  opacity: 1;
  background-color: rgba(59, 130, 246, 0.3);
}

th:hover .resize-handle {
  opacity: 1;
}

.form-checkbox {
  @apply h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500;
}

.form-select-sm {
  @apply px-2 py-1 text-sm border-gray-300 rounded focus:border-blue-500 focus:ring-blue-500;
}

/* Sticky column shadows */
.sticky {
  position: sticky;
  z-index: 10;
}

.sticky::after {
  content: '';
  position: absolute;
  top: 0;
  right: -1px;
  bottom: 0;
  width: 1px;
  background: linear-gradient(to right, rgba(0,0,0,0.1), transparent);
}

/* Scrollbar styling */
.table-container::-webkit-scrollbar {
  height: 8px;
}

.table-container::-webkit-scrollbar-track {
  background: #f1f1f1;
}

.table-container::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}
</style>