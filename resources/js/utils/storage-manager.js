/**
 * Storage Manager - Modern browser storage utilities
 * Handles localStorage, sessionStorage, and IndexedDB with fallbacks
 */

/**
 * Storage Manager class for handling browser storage
 */
export class StorageManager {
  /**
   * Check if storage is available
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {boolean} - Whether storage is available
   */
  static isAvailable(type = 'local') {
    try {
      const storage = type === 'local' ? localStorage : sessionStorage
      const test = '__storage_test__'
      storage.setItem(test, test)
      storage.removeItem(test)
      return true
    } catch (e) {
      return false
    }
  }

  /**
   * Get item from storage with JSON parsing
   * @param {string} key - Storage key
   * @param {any} defaultValue - Default value if not found
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {any} - Retrieved value or default
   */
  static get(key, defaultValue = null, type = 'local') {
    if (!this.isAvailable(type)) {
      console.warn(`${type} storage is not available`)
      return defaultValue
    }

    try {
      const storage = type === 'local' ? localStorage : sessionStorage
      const item = storage.getItem(key)
      
      if (item === null) {
        return defaultValue
      }

      // Try to parse JSON, fall back to string
      try {
        return JSON.parse(item)
      } catch {
        return item
      }
    } catch (error) {
      console.error(`Error getting ${key} from ${type} storage:`, error)
      return defaultValue
    }
  }

  /**
   * Set item in storage with JSON serialization
   * @param {string} key - Storage key
   * @param {any} value - Value to store
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {boolean} - Whether operation succeeded
   */
  static set(key, value, type = 'local') {
    if (!this.isAvailable(type)) {
      console.warn(`${type} storage is not available`)
      return false
    }

    try {
      const storage = type === 'local' ? localStorage : sessionStorage
      const serializedValue = typeof value === 'string' ? value : JSON.stringify(value)
      storage.setItem(key, serializedValue)
      return true
    } catch (error) {
      console.error(`Error setting ${key} in ${type} storage:`, error)
      return false
    }
  }

  /**
   * Remove item from storage
   * @param {string} key - Storage key
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {boolean} - Whether operation succeeded
   */
  static remove(key, type = 'local') {
    if (!this.isAvailable(type)) {
      return false
    }

    try {
      const storage = type === 'local' ? localStorage : sessionStorage
      storage.removeItem(key)
      return true
    } catch (error) {
      console.error(`Error removing ${key} from ${type} storage:`, error)
      return false
    }
  }

  /**
   * Clear all items from storage
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {boolean} - Whether operation succeeded
   */
  static clear(type = 'local') {
    if (!this.isAvailable(type)) {
      return false
    }

    try {
      const storage = type === 'local' ? localStorage : sessionStorage
      storage.clear()
      return true
    } catch (error) {
      console.error(`Error clearing ${type} storage:`, error)
      return false
    }
  }

  /**
   * Get all keys from storage
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {string[]} - Array of keys
   */
  static keys(type = 'local') {
    if (!this.isAvailable(type)) {
      return []
    }

    try {
      const storage = type === 'local' ? localStorage : sessionStorage
      return Object.keys(storage)
    } catch (error) {
      console.error(`Error getting keys from ${type} storage:`, error)
      return []
    }
  }

  /**
   * Get storage size in bytes
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {number} - Storage size in bytes
   */
  static getSize(type = 'local') {
    if (!this.isAvailable(type)) {
      return 0
    }

    try {
      const storage = type === 'local' ? localStorage : sessionStorage
      let total = 0
      
      for (const key in storage) {
        if (storage.hasOwnProperty(key)) {
          total += storage[key].length + key.length
        }
      }
      
      return total
    } catch (error) {
      console.error(`Error calculating ${type} storage size:`, error)
      return 0
    }
  }

  /**
   * Set item with expiration
   * @param {string} key - Storage key
   * @param {any} value - Value to store
   * @param {number} minutes - Expiration in minutes
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {boolean} - Whether operation succeeded
   */
  static setWithExpiry(key, value, minutes, type = 'local') {
    const now = new Date()
    const item = {
      value,
      expiry: now.getTime() + minutes * 60 * 1000
    }
    
    return this.set(key, item, type)
  }

  /**
   * Get item with expiration check
   * @param {string} key - Storage key
   * @param {any} defaultValue - Default value if not found or expired
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {any} - Retrieved value or default
   */
  static getWithExpiry(key, defaultValue = null, type = 'local') {
    const item = this.get(key, null, type)
    
    if (!item) {
      return defaultValue
    }

    // Check if item has expiry structure
    if (typeof item === 'object' && item.expiry && item.value !== undefined) {
      const now = new Date()
      
      if (now.getTime() > item.expiry) {
        this.remove(key, type)
        return defaultValue
      }
      
      return item.value
    }

    // Item doesn't have expiry structure, return as is
    return item
  }

  /**
   * Store data with namespace
   * @param {string} namespace - Namespace for grouping
   * @param {string} key - Storage key
   * @param {any} value - Value to store
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {boolean} - Whether operation succeeded
   */
  static setNamespaced(namespace, key, value, type = 'local') {
    const namespacedKey = `${namespace}:${key}`
    return this.set(namespacedKey, value, type)
  }

  /**
   * Get data from namespace
   * @param {string} namespace - Namespace for grouping
   * @param {string} key - Storage key
   * @param {any} defaultValue - Default value if not found
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {any} - Retrieved value or default
   */
  static getNamespaced(namespace, key, defaultValue = null, type = 'local') {
    const namespacedKey = `${namespace}:${key}`
    return this.get(namespacedKey, defaultValue, type)
  }

  /**
   * Remove data from namespace
   * @param {string} namespace - Namespace for grouping
   * @param {string} key - Storage key
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {boolean} - Whether operation succeeded
   */
  static removeNamespaced(namespace, key, type = 'local') {
    const namespacedKey = `${namespace}:${key}`
    return this.remove(namespacedKey, type)
  }

  /**
   * Clear all data from namespace
   * @param {string} namespace - Namespace to clear
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {boolean} - Whether operation succeeded
   */
  static clearNamespace(namespace, type = 'local') {
    if (!this.isAvailable(type)) {
      return false
    }

    try {
      const storage = type === 'local' ? localStorage : sessionStorage
      const keys = Object.keys(storage)
      const prefix = `${namespace}:`
      
      keys.forEach(key => {
        if (key.startsWith(prefix)) {
          storage.removeItem(key)
        }
      })
      
      return true
    } catch (error) {
      console.error(`Error clearing namespace ${namespace} from ${type} storage:`, error)
      return false
    }
  }

  /**
   * Get all data from namespace
   * @param {string} namespace - Namespace to get data from
   * @param {string} type - Storage type ('local' or 'session')
   * @returns {object} - Object with all namespace data
   */
  static getNamespaceData(namespace, type = 'local') {
    if (!this.isAvailable(type)) {
      return {}
    }

    try {
      const storage = type === 'local' ? localStorage : sessionStorage
      const keys = Object.keys(storage)
      const prefix = `${namespace}:`
      const data = {}
      
      keys.forEach(key => {
        if (key.startsWith(prefix)) {
          const shortKey = key.substring(prefix.length)
          data[shortKey] = this.get(key, null, type)
        }
      })
      
      return data
    } catch (error) {
      console.error(`Error getting namespace ${namespace} data from ${type} storage:`, error)
      return {}
    }
  }
}

/**
 * Cookie manager for server-side accessible storage
 */
export class CookieManager {
  /**
   * Set cookie
   * @param {string} name - Cookie name
   * @param {string} value - Cookie value
   * @param {object} options - Cookie options
   */
  static set(name, value, options = {}) {
    let cookie = `${encodeURIComponent(name)}=${encodeURIComponent(value)}`
    
    if (options.expires) {
      if (typeof options.expires === 'number') {
        const date = new Date()
        date.setTime(date.getTime() + options.expires * 24 * 60 * 60 * 1000)
        cookie += `; expires=${date.toUTCString()}`
      } else if (options.expires instanceof Date) {
        cookie += `; expires=${options.expires.toUTCString()}`
      }
    }
    
    if (options.maxAge) {
      cookie += `; max-age=${options.maxAge}`
    }
    
    if (options.path) {
      cookie += `; path=${options.path}`
    }
    
    if (options.domain) {
      cookie += `; domain=${options.domain}`
    }
    
    if (options.secure) {
      cookie += '; secure'
    }
    
    if (options.httpOnly) {
      cookie += '; httponly'
    }
    
    if (options.sameSite) {
      cookie += `; samesite=${options.sameSite}`
    }
    
    document.cookie = cookie
  }

  /**
   * Get cookie value
   * @param {string} name - Cookie name
   * @returns {string|null} - Cookie value or null
   */
  static get(name) {
    const nameEQ = encodeURIComponent(name) + '='
    const cookies = document.cookie.split(';')
    
    for (let cookie of cookies) {
      cookie = cookie.trim()
      if (cookie.indexOf(nameEQ) === 0) {
        return decodeURIComponent(cookie.substring(nameEQ.length))
      }
    }
    
    return null
  }

  /**
   * Remove cookie
   * @param {string} name - Cookie name
   * @param {object} options - Cookie options (path, domain)
   */
  static remove(name, options = {}) {
    this.set(name, '', {
      ...options,
      expires: new Date(0)
    })
  }

  /**
   * Check if cookies are enabled
   * @returns {boolean} - Whether cookies are enabled
   */
  static isEnabled() {
    try {
      const test = '__cookie_test__'
      this.set(test, 'test')
      const enabled = this.get(test) === 'test'
      this.remove(test)
      return enabled
    } catch (error) {
      return false
    }
  }
}

/**
 * Memory storage fallback for environments without web storage
 */
export class MemoryStorage {
  constructor() {
    this.storage = new Map()
  }

  getItem(key) {
    return this.storage.get(key) || null
  }

  setItem(key, value) {
    this.storage.set(key, value)
  }

  removeItem(key) {
    this.storage.delete(key)
  }

  clear() {
    this.storage.clear()
  }

  key(index) {
    const keys = Array.from(this.storage.keys())
    return keys[index] || null
  }

  get length() {
    return this.storage.size
  }
}

// Create fallback storage instances
const memoryStorage = new MemoryStorage()

/**
 * Get storage instance with fallback
 * @param {string} type - Storage type ('local' or 'session')
 * @returns {Storage|MemoryStorage} - Storage instance
 */
export function getStorage(type = 'local') {
  if (StorageManager.isAvailable(type)) {
    return type === 'local' ? localStorage : sessionStorage
  }
  
  console.warn(`${type} storage not available, using memory storage fallback`)
  return memoryStorage
}

// Default export
export default StorageManager