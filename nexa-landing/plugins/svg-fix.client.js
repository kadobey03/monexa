export default defineNuxtPlugin(() => {
  // SVG fix for null attributes
  const fixSVGAttributes = (container = document) => {
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

  // Override createElement for SVG elements to add validation
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

  // Fix existing SVG elements
  const runFix = () => {
    fixSVGAttributes()
  }

  // Run fix on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', runFix)
  } else {
    runFix()
  }

  // Run fix periodically for dynamic content
  setInterval(runFix, 5000)

  // Fix SVGs on route changes
  if (process.client) {
    const router = useRouter()
    router.afterEach(() => {
      nextTick(() => {
        runFix()
      })
    })
  }

  console.log('✅ SVG attribute validation plugin loaded')
})