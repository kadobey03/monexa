# Images Directory

This directory contains all image assets for the application, organized by category for better maintainability.

## Directory Structure

```
images/
├── logos/          # Company and application logos
├── icons/          # Application icons and iconography
├── backgrounds/    # Background images and patterns
├── avatars/        # Default avatar images
├── placeholders/   # Placeholder images
├── banners/        # Banner and hero images
├── illustrations/  # Custom illustrations
└── uploads/        # User uploaded images (symlinked from storage)
```

## File Naming Conventions

- Use lowercase letters and hyphens for file names
- Include size descriptors when applicable: `logo-sm.png`, `logo-lg.png`
- Use descriptive names: `user-avatar-default.png` not `avatar1.png`
- Include variant suffixes: `button-primary.svg`, `button-secondary.svg`

## Supported Formats

### Raster Images
- **PNG**: For images with transparency or complex graphics
- **JPG/JPEG**: For photographs and images without transparency
- **WebP**: Modern format for better compression (preferred when supported)

### Vector Images
- **SVG**: For icons, logos, and scalable graphics (preferred)

## Image Optimization

All images should be optimized before adding to the repository:

1. **Compress** images using appropriate tools
2. **Remove** unnecessary metadata
3. **Use** appropriate dimensions for intended use
4. **Consider** WebP format for modern browsers

## Usage in Components

### Vue Components
```javascript
import logoImage from '@/assets/images/logos/logo.png'

// In template
<img :src="logoImage" alt="Logo" />
```

### CSS/SCSS
```scss
.logo {
  background-image: url('@/assets/images/logos/logo.svg');
}
```

### Vite Asset Handling
Vite automatically processes images imported in JavaScript modules and referenced in CSS.

## Best Practices

1. **Optimize** all images before committing
2. **Use** SVG for icons and simple graphics
3. **Provide** multiple sizes when needed
4. **Include** alt text descriptions
5. **Consider** lazy loading for large images
6. **Test** images on different screen densities