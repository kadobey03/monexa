// SVG Utility Functions to prevent null attribute errors

/**
 * Safely creates an SVG element with proper attribute validation
 * @param {string} tagName - The SVG element tag name (e.g., 'svg', 'path', 'rect')
 * @param {Object} attributes - Object containing attributes to set
 * @returns {SVGElement} - The created SVG element
 */
export function createSVGElement(tagName, attributes = {}) {
  const element = document.createElementNS('http://www.w3.org/2000/svg', tagName)
  
  // Set attributes with validation
  Object.entries(attributes).forEach(([key, value]) => {
    setSVGAttribute(element, key, value)
  })
  
  return element
}

/**
 * Safely sets an attribute on an SVG element, validating the value
 * @param {SVGElement} element - The SVG element
 * @param {string} attribute - The attribute name
 * @param {*} value - The attribute value
 */
export function setSVGAttribute(element, attribute, value) {
  // Handle null, undefined, or empty values
  if (value === null || value === undefined || value === '') {
    // For dimension attributes, provide default values
    if (['width', 'height'].includes(attribute)) {
      value = '100%'
    } else if (['viewBox'].includes(attribute)) {
      value = '0 0 24 24'
    } else {
      // Skip setting the attribute if it's null/undefined and not critical
      return
    }
  }
  
  // Ensure numeric values for dimension attributes are valid
  if (['width', 'height', 'x', 'y', 'cx', 'cy', 'r', 'rx', 'ry'].includes(attribute)) {
    if (typeof value === 'number' && (isNaN(value) || !isFinite(value))) {
      console.warn(`Invalid ${attribute} value: ${value}, using default`)
      value = attribute === 'width' || attribute === 'height' ? '100%' : '0'
    }
  }
  
  element.setAttribute(attribute, String(value))
}

/**
 * Validates and fixes existing SVG elements with null attributes
 * @param {Element} container - Container to search for SVG elements (defaults to document)
 */
export function fixSVGAttributes(container = document) {
  const svgElements = container.querySelectorAll('svg, svg *')
  
  svgElements.forEach(element => {
    // Check for null width/height attributes
    const width = element.getAttribute('width')
    const height = element.getAttribute('height')
    
    if (width === 'null' || width === null) {
      element.removeAttribute('width')
      if (!element.style.width && !element.classList.length) {
        element.style.width = '100%'
      }
    }
    
    if (height === 'null' || height === null) {
      element.removeAttribute('height')
      if (!element.style.height && !element.classList.length) {
        element.style.height = '100%'
      }
    }
    
    // Ensure viewBox is set for SVG elements without width/height
    if (element.tagName === 'svg' && !element.getAttribute('viewBox')) {
      element.setAttribute('viewBox', '0 0 24 24')
    }
  })
}

/**
 * Global error handler for SVG-related errors
 */
export function handleSVGErrors() {
  // Override createElement for SVG elements to add validation
  const originalCreateElement = document.createElement
  const originalCreateElementNS = document.createElementNS
  
  document.createElementNS = function(namespace, tagName) {
    const element = originalCreateElementNS.call(this, namespace, tagName)
    
    // If it's an SVG element, add safety measures
    if (namespace === 'http://www.w3.org/2000/svg') {
      const originalSetAttribute = element.setAttribute
      element.setAttribute = function(name, value) {
        // Validate SVG attributes before setting
        if (['width', 'height'].includes(name) && (value === null || value === 'null')) {
          console.warn(`Prevented setting ${name}="${value}" on SVG element. Using default.`)
          value = '100%'
        }
        return originalSetAttribute.call(this, name, value)
      }
    }
    
    return element
  }
}

// Auto-initialize when imported
if (typeof window !== 'undefined') {
  handleSVGErrors()
  
  // Fix existing SVG elements when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => fixSVGAttributes())
  } else {
    fixSVGAttributes()
  }
  
  // Periodically check and fix SVG attributes (for dynamic content)
  setInterval(() => fixSVGAttributes(), 5000)
}