/**
 * Pinia/Vue Store Configuration
 * Centralized state management for Vue.js applications
 */

import { createPinia } from 'pinia'
import { createPersistedState } from 'pinia-plugin-persistedstate'

// Store modules
export { useAuthStore } from './auth.js'
export { useNotificationStore } from './notification.js'
export { useThemeStore } from './theme.js'
export { useUserStore } from './user.js'
export { useTradeStore } from './trade.js'

/**
 * Create and configure Pinia store
 * @returns {object} Configured Pinia instance
 */
export function createStore() {
  const pinia = createPinia()
  
  // Add persistence plugin
  pinia.use(createPersistedState({
    storage: localStorage,
    key: id => `store-${id}`,
    auto: true // Auto-persist all stores
  }))
  
  return pinia
}

/**
 * Global store registry for non-Vue contexts
 */
class GlobalStoreRegistry {
  constructor() {
    this.stores = new Map()
    this.pinia = null
  }
  
  /**
   * Initialize Pinia instance
   * @param {object} pinia - Pinia instance
   */
  init(pinia) {
    this.pinia = pinia
  }
  
  /**
   * Register a store
   * @param {string} name - Store name
   * @param {Function} store - Store factory function
   */
  register(name, store) {
    this.stores.set(name, store)
  }
  
  /**
   * Get a store instance
   * @param {string} name - Store name
   * @returns {object} Store instance
   */
  get(name) {
    if (!this.stores.has(name)) {
      throw new Error(`Store "${name}" not registered`)
    }
    
    return this.stores.get(name)()
  }
  
  /**
   * Check if store exists
   * @param {string} name - Store name
   * @returns {boolean} Whether store exists
   */
  has(name) {
    return this.stores.has(name)
  }
}

// Global store registry instance
export const storeRegistry = new GlobalStoreRegistry()

/**
 * Store utilities for Vanilla JS usage
 */
export const StoreUtils = {
  /**
   * Create a reactive store for Vanilla JS
   * @param {object} initialState - Initial state
   * @returns {object} Reactive store
   */
  createReactiveStore(initialState = {}) {
    const subscribers = new Map()
    
    const store = new Proxy(initialState, {
      set(target, property, value) {
        const oldValue = target[property]
        target[property] = value
        
        // Notify subscribers
        if (subscribers.has(property)) {
          subscribers.get(property).forEach(callback => {
            callback(value, oldValue, property)
          })
        }
        
        // Notify global subscribers
        if (subscribers.has('*')) {
          subscribers.get('*').forEach(callback => {
            callback(value, oldValue, property)
          })
        }
        
        return true
      },
      
      get(target, property) {
        // Special methods
        if (property === '$subscribe') {
          return (key, callback) => {
            if (!subscribers.has(key)) {
              subscribers.set(key, [])
            }
            subscribers.get(key).push(callback)
            
            // Return unsubscribe function
            return () => {
              const callbacks = subscribers.get(key)
              const index = callbacks.indexOf(callback)
              if (index > -1) {
                callbacks.splice(index, 1)
              }
            }
          }
        }
        
        if (property === '$state') {
          return { ...target }
        }
        
        if (property === '$reset') {
          return () => {
            Object.keys(target).forEach(key => {
              delete target[key]
            })
            Object.assign(target, initialState)
          }
        }
        
        return target[property]
      }
    })
    
    return store
  },
  
  /**
   * Create a persisted store
   * @param {string} key - Storage key
   * @param {object} initialState - Initial state
   * @param {Storage} storage - Storage implementation (localStorage/sessionStorage)
   * @returns {object} Persisted store
   */
  createPersistedStore(key, initialState = {}, storage = localStorage) {
    // Load from storage
    let savedState = {}
    try {
      const saved = storage.getItem(key)
      if (saved) {
        savedState = JSON.parse(saved)
      }
    } catch (error) {
      console.warn('Failed to load persisted state:', error)
    }
    
    const state = { ...initialState, ...savedState }
    const store = this.createReactiveStore(state)
    
    // Save to storage on changes
    store.$subscribe('*', () => {
      try {
        storage.setItem(key, JSON.stringify(store.$state))
      } catch (error) {
        console.warn('Failed to persist state:', error)
      }
    })
    
    return store
  },
  
  /**
   * Create a computed property
   * @param {Function} getter - Getter function
   * @param {Array} dependencies - Dependency stores/properties
   * @returns {object} Computed property
   */
  createComputed(getter, dependencies = []) {
    let cached = null
    let dirty = true
    
    // Subscribe to dependencies
    const unsubscribers = dependencies.map(dep => {
      if (dep && typeof dep.$subscribe === 'function') {
        return dep.$subscribe('*', () => {
          dirty = true
          cached = null
        })
      }
      return null
    }).filter(Boolean)
    
    return {
      get value() {
        if (dirty) {
          cached = getter()
          dirty = false
        }
        return cached
      },
      
      destroy() {
        unsubscribers.forEach(unsub => unsub())
      }
    }
  }
}

/**
 * Initialize stores for the application
 * @param {object} app - Vue app instance (optional)
 */
export function initializeStores(app = null) {
  const pinia = createStore()
  
  if (app) {
    app.use(pinia)
  }
  
  // Initialize global registry
  storeRegistry.init(pinia)
  
  // Register stores
  storeRegistry.register('auth', useAuthStore)
  storeRegistry.register('notification', useNotificationStore)
  storeRegistry.register('theme', useThemeStore)
  storeRegistry.register('user', useUserStore)
  storeRegistry.register('trade', useTradeStore)
  
  return pinia
}

export default {
  createStore,
  initializeStores,
  storeRegistry,
  StoreUtils
}