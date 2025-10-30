/**
 * Utility Functions - Centralized utility exports
 * Modern ES6+ utilities for common operations
 */

// Core utilities
export { CSRFManager } from './csrf-manager.js'
export { NotificationManager } from './notification-manager.js'
export { StorageManager } from './storage-manager.js'
export { ValidationHelpers } from './validation-helpers.js'
export { DateHelpers } from './date-helpers.js'
export { StringHelpers } from './string-helpers.js'
export { NumberHelpers } from './number-helpers.js'
export { ArrayHelpers } from './array-helpers.js'
export { ObjectHelpers } from './object-helpers.js'
export { URLHelpers } from './url-helpers.js'
export { FileHelpers } from './file-helpers.js'
export { ColorHelpers } from './color-helpers.js'
export { DeviceHelpers } from './device-helpers.js'

/**
 * Utility groups for organized imports
 */
export const CoreUtils = {
  CSRFManager: () => import('./csrf-manager.js'),
  NotificationManager: () => import('./notification-manager.js'),
  StorageManager: () => import('./storage-manager.js')
}

export const ValidationUtils = {
  ValidationHelpers: () => import('./validation-helpers.js')
}

export const FormatUtils = {
  DateHelpers: () => import('./date-helpers.js'),
  StringHelpers: () => import('./string-helpers.js'),
  NumberHelpers: () => import('./number-helpers.js')
}

export const DataUtils = {
  ArrayHelpers: () => import('./array-helpers.js'),
  ObjectHelpers: () => import('./object-helpers.js')
}

export const BrowserUtils = {
  URLHelpers: () => import('./url-helpers.js'),
  FileHelpers: () => import('./file-helpers.js'),
  DeviceHelpers: () => import('./device-helpers.js')
}

/**
 * All utilities for bulk imports
 */
export const AllUtils = {
  ...CoreUtils,
  ...ValidationUtils,
  ...FormatUtils,
  ...DataUtils,
  ...BrowserUtils
}

/**
 * Debounce function for limiting function calls
 * @param {Function} func - Function to debounce
 * @param {number} wait - Wait time in milliseconds
 * @param {boolean} immediate - Execute immediately on first call
 * @returns {Function} - Debounced function
 */
export function debounce(func, wait, immediate = false) {
  let timeout
  return function executedFunction(...args) {
    const later = () => {
      timeout = null
      if (!immediate) func(...args)
    }
    const callNow = immediate && !timeout
    clearTimeout(timeout)
    timeout = setTimeout(later, wait)
    if (callNow) func(...args)
  }
}

/**
 * Throttle function for limiting function calls
 * @param {Function} func - Function to throttle
 * @param {number} limit - Limit time in milliseconds
 * @returns {Function} - Throttled function
 */
export function throttle(func, limit) {
  let inThrottle
  return function executedFunction(...args) {
    if (!inThrottle) {
      func.apply(this, args)
      inThrottle = true
      setTimeout(() => inThrottle = false, limit)
    }
  }
}

/**
 * Deep clone an object
 * @param {any} obj - Object to clone
 * @returns {any} - Cloned object
 */
export function deepClone(obj) {
  if (obj === null || typeof obj !== 'object') return obj
  if (obj instanceof Date) return new Date(obj.getTime())
  if (obj instanceof Array) return obj.map(item => deepClone(item))
  if (typeof obj === 'object') {
    const clonedObj = {}
    for (const key in obj) {
      if (obj.hasOwnProperty(key)) {
        clonedObj[key] = deepClone(obj[key])
      }
    }
    return clonedObj
  }
}

/**
 * Check if value is empty
 * @param {any} value - Value to check
 * @returns {boolean} - Whether value is empty
 */
export function isEmpty(value) {
  if (value === null || value === undefined) return true
  if (typeof value === 'string' && value.trim() === '') return true
  if (Array.isArray(value) && value.length === 0) return true
  if (typeof value === 'object' && Object.keys(value).length === 0) return true
  return false
}

/**
 * Generate unique ID
 * @param {string} prefix - Optional prefix
 * @returns {string} - Unique ID
 */
export function generateId(prefix = '') {
  const timestamp = Date.now().toString(36)
  const random = Math.random().toString(36).substr(2, 5)
  return prefix ? `${prefix}-${timestamp}-${random}` : `${timestamp}-${random}`
}

/**
 * Sleep function for async delays
 * @param {number} ms - Milliseconds to sleep
 * @returns {Promise} - Promise that resolves after delay
 */
export function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms))
}

/**
 * Retry function with exponential backoff
 * @param {Function} fn - Function to retry
 * @param {number} retries - Number of retries
 * @param {number} delay - Initial delay
 * @returns {Promise} - Promise that resolves when function succeeds
 */
export async function retry(fn, retries = 3, delay = 1000) {
  try {
    return await fn()
  } catch (error) {
    if (retries > 0) {
      await sleep(delay)
      return retry(fn, retries - 1, delay * 2)
    }
    throw error
  }
}

/**
 * Format bytes to human readable format
 * @param {number} bytes - Number of bytes
 * @param {number} decimals - Number of decimal places
 * @returns {string} - Formatted string
 */
export function formatBytes(bytes, decimals = 2) {
  if (bytes === 0) return '0 Bytes'
  
  const k = 1024
  const dm = decimals < 0 ? 0 : decimals
  const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
  
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  
  return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i]
}

/**
 * Escape HTML characters
 * @param {string} text - Text to escape
 * @returns {string} - Escaped text
 */
export function escapeHtml(text) {
  const map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  }
  
  return text.replace(/[&<>"']/g, m => map[m])
}

/**
 * Parse query string to object
 * @param {string} queryString - Query string to parse
 * @returns {object} - Parsed object
 */
export function parseQuery(queryString = window.location.search) {
  const params = new URLSearchParams(queryString)
  const result = {}
  
  for (const [key, value] of params.entries()) {
    result[key] = value
  }
  
  return result
}

/**
 * Convert object to query string
 * @param {object} obj - Object to convert
 * @returns {string} - Query string
 */
export function objectToQuery(obj) {
  const params = new URLSearchParams()
  
  for (const [key, value] of Object.entries(obj)) {
    if (value !== null && value !== undefined) {
      params.append(key, value)
    }
  }
  
  return params.toString()
}

/**
 * Get nested object property safely
 * @param {object} obj - Object to traverse
 * @param {string} path - Dot notation path
 * @param {any} defaultValue - Default value if not found
 * @returns {any} - Property value or default
 */
export function getNestedProperty(obj, path, defaultValue = null) {
  const keys = path.split('.')
  let result = obj
  
  for (const key of keys) {
    if (result === null || result === undefined || !(key in result)) {
      return defaultValue
    }
    result = result[key]
  }
  
  return result
}

/**
 * Set nested object property
 * @param {object} obj - Object to modify
 * @param {string} path - Dot notation path
 * @param {any} value - Value to set
 * @returns {object} - Modified object
 */
export function setNestedProperty(obj, path, value) {
  const keys = path.split('.')
  let current = obj
  
  for (let i = 0; i < keys.length - 1; i++) {
    const key = keys[i]
    if (!(key in current) || typeof current[key] !== 'object') {
      current[key] = {}
    }
    current = current[key]
  }
  
  current[keys[keys.length - 1]] = value
  return obj
}

/**
 * Check if code is running in development mode
 * @returns {boolean} - Whether in development mode
 */
export function isDev() {
  return import.meta.env.DEV
}

/**
 * Check if code is running in production mode
 * @returns {boolean} - Whether in production mode
 */
export function isProd() {
  return import.meta.env.PROD
}

/**
 * Log function that only works in development
 * @param {...any} args - Arguments to log
 */
export function devLog(...args) {
  if (isDev()) {
    console.log(...args)
  }
}

/**
 * Error log function that only works in development
 * @param {...any} args - Arguments to log
 */
export function devError(...args) {
  if (isDev()) {
    console.error(...args)
  }
}

/**
 * Warning log function that only works in development
 * @param {...any} args - Arguments to log
 */
export function devWarn(...args) {
  if (isDev()) {
    console.warn(...args)
  }
}