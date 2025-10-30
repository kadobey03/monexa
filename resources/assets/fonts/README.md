# Fonts Directory

This directory contains all font files for the application, organized for optimal loading and performance.

## Directory Structure

```
fonts/
├── primary/        # Primary application fonts (Inter, Roboto, etc.)
├── display/        # Display/heading fonts
├── monospace/      # Code and monospace fonts
├── icons/          # Icon fonts (Font Awesome, custom icons)
└── fallbacks/      # System font fallbacks
```

## Font Formats

### Modern Formats (Preferred)
- **WOFF2**: Best compression, modern browser support
- **WOFF**: Fallback for older browsers
- **TTF/OTF**: Original formats, use for development only

### Loading Strategy
```css
@font-face {
  font-family: 'Primary';
  src: url('./primary/primary.woff2') format('woff2'),
       url('./primary/primary.woff') format('woff');
  font-display: swap;
}
```

## Font Loading Optimization

### Preload Critical Fonts
```html
<link rel="preload" href="/assets/fonts/primary/primary.woff2" as="font" type="font/woff2" crossorigin>
```

### CSS Font Loading
```css
/* Use font-display: swap for better performance */
@font-face {
  font-family: 'CustomFont';
  src: url('./custom-font.woff2') format('woff2');
  font-display: swap;
  font-weight: 400;
  font-style: normal;
}
```

## Font Stack Configuration

### CSS Variables
```css
:root {
  --font-family-sans: 'Primary', system-ui, -apple-system, sans-serif;
  --font-family-mono: 'JetBrains Mono', Monaco, 'Cascadia Code', monospace;
  --font-family-display: 'Display Font', Georgia, serif;
}
```

## Best Practices

1. **Subset fonts** to include only needed characters
2. **Use WOFF2** as primary format
3. **Implement font-display: swap** for better loading
4. **Preload** critical fonts in HTML head
5. **Provide fallbacks** for system fonts
6. **Test** font loading on slow connections
7. **Monitor** font loading performance

## Icon Fonts vs SVG Icons

### When to Use Icon Fonts
- Large icon sets with consistent styling
- Need for CSS pseudo-element usage
- Backward compatibility requirements

### When to Use SVG Icons  
- Better accessibility and performance
- Individual icon optimization
- Color and animation flexibility
- Modern applications (recommended)

## Font Licensing

Ensure all fonts have appropriate licenses for web use:
- **Open Source**: OFL, MIT, etc.
- **Commercial**: Proper licensing for web usage
- **System Fonts**: Safe to reference as fallbacks