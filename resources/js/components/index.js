/**
 * Component Exports - Centralized component registration
 * Vite-optimized component barrel exports
 */

// Table Components
export { default as DataTable } from './tables/DataTable.vue'

// Form Components  
export { default as FormInput } from './forms/FormInput.vue'

// Legacy component mapping (for backward compatibility)
export { default as SmartDataTable } from './common/SmartDataTable.vue'

/**
 * Component registration helper for Vue applications
 * @param {object} app - Vue application instance
 */
export function registerComponents(app) {
  // Import all components dynamically
  const components = import.meta.glob('./**/*.vue', { eager: true })
  
  Object.entries(components).forEach(([path, module]) => {
    // Extract component name from file path
    const componentName = path
      .split('/')
      .pop()
      .replace('.vue', '')
    
    // Register component globally if it has a name
    if (module.default && module.default.name) {
      app.component(module.default.name, module.default)
    } else {
      // Fallback to filename-based registration
      app.component(componentName, module.default)
    }
  })
}

/**
 * Lazy load components for code splitting
 * @param {string} componentPath - Path to component file
 * @returns {Promise} - Component promise
 */
export function lazyLoadComponent(componentPath) {
  return () => import(componentPath)
}

/**
 * Component groups for organized imports
 */
export const TableComponents = {
  DataTable: () => import('./tables/DataTable.vue')
}

export const FormComponents = {
  FormInput: () => import('./forms/FormInput.vue')
}

export const CommonComponents = {
  SmartDataTable: () => import('./common/SmartDataTable.vue')
}

/**
 * All components for bulk imports
 */
export const AllComponents = {
  ...TableComponents,
  ...FormComponents,
  ...CommonComponents
}

/**
 * Async component loader with error handling
 * @param {function} loader - Component loader function
 * @param {object} options - Loading options
 * @returns {object} - Async component definition
 */
export function createAsyncComponent(loader, options = {}) {
  return {
    loader,
    loading: options.loading || (() => import('./common/LoadingSpinner.vue')),
    error: options.error || (() => import('./common/ErrorComponent.vue')),
    delay: options.delay || 200,
    timeout: options.timeout || 3000
  }
}

/**
 * Component factory for dynamic component creation
 * @param {string} type - Component type
 * @param {object} props - Component props
 * @returns {object} - Component definition
 */
export function createComponent(type, props = {}) {
  const componentMap = {
    'data-table': DataTable,
    'form-input': FormInput,
    'smart-table': SmartDataTable
  }
  
  const Component = componentMap[type]
  if (!Component) {
    console.warn(`Component type "${type}" not found`)
    return null
  }
  
  return {
    component: Component,
    props
  }
}

/**
 * Component validation helper
 * @param {object} component - Vue component
 * @returns {boolean} - Whether component is valid
 */
export function validateComponent(component) {
  if (!component) return false
  if (typeof component !== 'object') return false
  if (!component.render && !component.template && !component.setup) return false
  
  return true
}

/**
 * Component metadata extraction
 * @param {object} component - Vue component
 * @returns {object} - Component metadata
 */
export function getComponentMeta(component) {
  return {
    name: component.name || 'Anonymous',
    props: component.props || {},
    emits: component.emits || [],
    slots: component.slots || {},
    setup: !!component.setup,
    functional: !!component.functional
  }
}