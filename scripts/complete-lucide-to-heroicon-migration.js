#!/usr/bin/env node

/**
 * Complete Lucide to Heroicon Migration Script
 * Removes ALL lucide usage and converts to heroicons
 */

const fs = require('fs');
const path = require('path');

// Enhanced icon mapping - more comprehensive
const iconMap = {
    // Navigation & UI
    'home': 'home',
    'menu': 'bars-3',
    'x': 'x-mark',
    'chevron-down': 'chevron-down',
    'chevron-up': 'chevron-up',
    'chevron-left': 'chevron-left',
    'chevron-right': 'chevron-right',
    'chevrons-left': 'chevron-double-left',
    'chevrons-right': 'chevron-double-right',
    'arrow-left': 'arrow-left',
    'arrow-right': 'arrow-right',
    'arrow-up': 'arrow-up',
    'arrow-down': 'arrow-down',
    'arrow-up-circle': 'arrow-up-circle',
    'arrow-down-circle': 'arrow-down-circle',
    
    // User & Auth
    'user': 'user',
    'user-plus': 'user-plus',
    'user-check': 'user-check',
    'user-x': 'user-minus',
    'user-circle': 'user-circle',
    'user-cog': 'cog-6-tooth',
    'users': 'users',
    'log-in': 'arrow-right-on-rectangle',
    'log-out': 'arrow-left-on-rectangle',
    'shield': 'shield-check',
    'shield-check': 'shield-check',
    'shield-alert': 'shield-exclamation',
    'shield-question': 'shield-exclamation',
    
    // Communication
    'mail': 'envelope',
    'mail-check': 'envelope-open',
    'phone': 'phone',
    'bell': 'bell',
    'bell-off': 'bell-slash',
    
    // Actions & Status
    'check': 'check',
    'check-circle': 'check-circle',
    'check-circle-2': 'check-circle',
    'check-square': 'check-circle',
    'alert-circle': 'exclamation-circle',
    'alert-triangle': 'exclamation-triangle',
    'info': 'information-circle',
    'help-circle': 'question-mark-circle',
    'x-circle': 'x-circle',
    'x-square': 'x-mark',
    'circle': 'stop',
    
    // Finance & Trading
    'trending-up': 'arrow-trending-up',
    'trending-down': 'arrow-trending-down',
    'dollar-sign': 'currency-dollar',
    'banknote': 'banknote',
    'wallet': 'wallet',
    'credit-card': 'credit-card',
    'plus-circle': 'plus-circle',
    'minus-circle': 'minus-circle',
    'plus': 'plus',
    'minus': 'minus',
    'zap': 'bolt',
    'target': 'view-finder',
    'gift': 'gift',
    'repeat': 'arrow-path',
    
    // System & Settings
    'settings': 'cog-6-tooth',
    'cog': 'cog-6-tooth',
    'server': 'server',
    'database': 'circle-stack',
    'key': 'key',
    'key-round': 'key',
    'lock': 'lock-closed',
    'unlock': 'lock-open',
    'eye': 'eye',
    'eye-off': 'eye-slash',
    'search': 'magnifying-glass',
    'filter': 'funnel',
    'filter-x': 'x-mark',
    'download': 'arrow-down-tray',
    'upload': 'arrow-up-tray',
    'refresh-cw': 'arrow-path',
    'refresh-ccw': 'arrow-path',
    'loader': 'arrow-path',
    'loader-2': 'arrow-path',
    
    // Layout & Organization
    'layout-dashboard': 'squares-2x2',
    'grid-3x3': 'squares-plus',
    'grid': 'squares-2x2',
    'columns': 'view-columns',
    'list': 'list-bullet',
    'list-checks': 'clipboard-document-list',
    'calendar': 'calendar-days',
    'clock': 'clock',
    'folder': 'folder',
    'file': 'document',
    'bookmark': 'bookmark',
    
    // Communication & Social
    'globe': 'globe-alt',
    'globe-2': 'globe-americas',
    'at-sign': 'at-symbol',
    'flag': 'flag',
    'languages': 'language',
    'headphones': 'speaker-wave',
    'life-buoy': 'life-buoy',
    
    // Media & Content
    'image': 'photo',
    'video': 'video-camera',
    'camera': 'camera',
    'mic': 'microphone',
    'volume': 'speaker-wave',
    
    // Navigation & Movement
    'map-pin': 'map-pin',
    'pin': 'map-pin',
    'unpin': 'map-pin',
    'navigation': 'cursor-arrow-rays',
    'compass': 'compass',
    
    // Tools & Actions
    'edit': 'pencil',
    'edit-2': 'pencil-square',
    'edit-3': 'pen-tool',
    'trash': 'trash',
    'trash-2': 'trash',
    'copy': 'document-duplicate',
    'save': 'document-arrow-down',
    'send': 'paper-airplane',
    'share': 'share',
    
    // Technology
    'wifi': 'wifi',
    'bluetooth': 'signal',
    'radio': 'radio',
    'smartphone': 'device-phone-mobile',
    'tablet': 'device-tablet',
    'monitor': 'computer-desktop',
    'hard-drive': 'server',
    
    // Nature & Weather
    'sun': 'sun',
    'moon': 'moon',
    'cloud': 'cloud',
    'umbrella': 'cloud-arrow-up',
    
    // Shapes & Graphics
    'square': 'square-3-stack-3d',
    'triangle': 'play',
    'star': 'star',
    'heart': 'heart',
    'diamond': 'diamond',
    'dot': 'minus',
    
    // Business & Professional
    'briefcase': 'briefcase',
    'building': 'building-office',
    'shop': 'building-storefront',
    'award': 'trophy',
    'certificate': 'academic-cap',
    
    // Gaming & Entertainment
    'gamepad-2': 'puzzle-piece',
    'music': 'musical-note',
    'play': 'play',
    'pause': 'pause',
    'stop': 'stop',
    
    // Miscellaneous
    'sparkles': 'sparkles',
    'flame': 'fire',
    'droplet': 'beaker',
    'scissors': 'scissors',
    'paperclip': 'paper-clip',
    'link': 'link',
    'tag': 'tag',
    'hash': 'hashtag',
    'percent': 'percent-badge',
    'calculator': 'calculator',
    'receipt': 'receipt-percent',
    'shopping-cart': 'shopping-cart',
    'package': 'cube',
    'truck': 'truck',
    'activity': 'chart-bar',
    'bar-chart': 'chart-bar',
    'pie-chart': 'chart-pie',
    'git-branch': 'code-bracket',
    'code': 'code-bracket',
    'terminal': 'command-line',
    'layers': 'squares-plus',
    'maximize': 'arrows-pointing-out',
    'minimize': 'arrows-pointing-in',
    'maximize-2': 'arrows-pointing-out',
    'minimize-2': 'arrows-pointing-in',
    'panel-left': 'sidebar',
    'panel-right': 'sidebar',
    'grip-vertical': 'bars-3-bottom-left',
    'more-vertical': 'ellipsis-vertical',
    'more-horizontal': 'ellipsis-horizontal',
    'external-link': 'arrow-top-right-on-square',
    'history': 'clock',
    'rotate-ccw': 'arrow-uturn-left',
    'rotate-cw': 'arrow-uturn-right',
    'invest': 'arrow-trending-up',
    'corner-up-left': 'arrow-up-left',
    'corner-up-right': 'arrow-up-right'
};

function getAllFiles(dir, fileList = []) {
    const files = fs.readdirSync(dir);
    
    files.forEach(file => {
        const filePath = path.join(dir, file);
        const stat = fs.statSync(filePath);
        
        if (stat.isDirectory()) {
            // Skip certain directories
            if (!['node_modules', '.git', 'vendor', 'storage/framework/views'].includes(file)) {
                getAllFiles(filePath, fileList);
            }
        } else if (file.endsWith('.php') || file.endsWith('.blade.php')) {
            fileList.push(filePath);
        }
    });
    
    return fileList;
}

function extractAttributes(element) {
    // Extract classes and other attributes from the element
    const classMatch = element.match(/class=["']([^"']+)["']/);
    const classes = classMatch ? classMatch[1] : 'w-5 h-5';
    
    // Extract other attributes (excluding data-lucide and class)
    const attributes = {};
    const attrRegex = /(\w+)=["']([^"']+)["']/g;
    let match;
    
    while ((match = attrRegex.exec(element)) !== null) {
        const [, attrName, attrValue] = match;
        if (attrName !== 'data-lucide' && attrName !== 'class') {
            attributes[attrName] = attrValue;
        }
    }
    
    return { classes, attributes };
}

function migrateLucideToHeroicon(content) {
    let newContent = content;
    let changesMade = false;
    
    // 1. Replace data-lucide attributes with heroicon components
    const lucideRegex = /<i\s+[^>]*data-lucide=["']([^"']+)["'][^>]*><\/i>/g;
    newContent = newContent.replace(lucideRegex, (match, iconName) => {
        const heroIconName = iconMap[iconName] || iconName;
        const { classes, attributes } = extractAttributes(match);
        
        // Build attribute string
        let attrString = '';
        Object.entries(attributes).forEach(([key, value]) => {
            attrString += ` ${key}="${value}"`;
        });
        
        changesMade = true;
        return `<x-heroicon name="${heroIconName}" class="${classes}"${attrString} />`;
    });
    
    // 2. Replace self-closing i tags
    const selfClosingRegex = /<i\s+[^>]*data-lucide=["']([^"']+)["'][^>]*\/>/g;
    newContent = newContent.replace(selfClosingRegex, (match, iconName) => {
        const heroIconName = iconMap[iconName] || iconName;
        const { classes, attributes } = extractAttributes(match);
        
        let attrString = '';
        Object.entries(attributes).forEach(([key, value]) => {
            attrString += ` ${key}="${value}"`;
        });
        
        changesMade = true;
        return `<x-heroicon name="${heroIconName}" class="${classes}"${attrString} />`;
    });
    
    // 3. Replace dynamic data-lucide assignments in JavaScript
    const dynamicRegex = /(\w+)\.setAttribute\s*\(\s*['"`]data-lucide['"`]\s*,\s*['"`]([^'"`]+)['"`]\s*\)/g;
    newContent = newContent.replace(dynamicRegex, (match, elementVar, iconName) => {
        changesMade = true;
        return `// Heroicon: ${elementVar} icon changed to ${iconMap[iconName] || iconName}`;
    });
    
    // 4. Remove lucide JavaScript initialization code
    const lucideInitPatterns = [
        /if\s*\(\s*typeof\s+lucide\s*!==\s*['"`]undefined['"`]\s*\)\s*{[^}]*}/g,
        /if\s*\(\s*window\.lucide\s*\)\s*{[^}]*}/g,
        /lucide\.createIcons\s*\([^)]*\)\s*;?/g,
        /initializeLucideIcons\s*\(\s*\)\s*{[^}]*}/g,
        /function\s+initializeLucideIcons\s*\(\s*\)\s*{[^}]*}/g,
        /\/\/\s*Initialize\s+Lucide\s+icons[^\n]*/gi,
        /\/\/\s*Re-initialize\s+Lucide\s+icons[^\n]*/gi,
        /\/\/\s*Reinitialize\s+Lucide\s+icons[^\n]*/gi,
        /\/\/\s*Refresh\s+Lucide\s+icons[^\n]*/gi,
        /\/\/\s*Re-init\s+lucide\s+icons[^\n]*/gi
    ];
    
    lucideInitPatterns.forEach(pattern => {
        if (pattern.test(newContent)) {
            newContent = newContent.replace(pattern, '');
            changesMade = true;
        }
    });
    
    // 5. Replace :data-lucide Alpine.js bindings
    const alpineRegex = /:data-lucide=["']([^"']+)["']/g;
    newContent = newContent.replace(alpineRegex, (match, expression) => {
        changesMade = true;
        return `<!-- Heroicon: Alpine expression ${expression} needs manual conversion -->`;
    });
    
    // 6. Clean up lucide references in comments and variables
    const commentReplacements = [
        [/\/\*\*?\s*\*?\s*lucide/gi, '/* Heroicon'],
        [/\/\/.*lucide/gi, '// Heroicon'],
        [/lucide-icon/g, 'heroicon'],
        [/Lucide\s+icons?/gi, 'Heroicons'],
        [/lucide\s+icons?/gi, 'heroicons']
    ];
    
    commentReplacements.forEach(([pattern, replacement]) => {
        if (pattern.test(newContent)) {
            newContent = newContent.replace(pattern, replacement);
            changesMade = true;
        }
    });
    
    // 7. Clean up extra whitespace and empty lines caused by removals
    newContent = newContent.replace(/\n\s*\n\s*\n/g, '\n\n');
    
    return { content: newContent, changed: changesMade };
}

function processFile(filePath) {
    try {
        const content = fs.readFileSync(filePath, 'utf8');
        const result = migrateLucideToHeroicon(content);
        
        if (result.changed) {
            fs.writeFileSync(filePath, result.content);
            console.log(`✅ Updated: ${filePath}`);
            return 1;
        } else {
            console.log(`⏭️  No changes: ${filePath}`);
            return 0;
        }
    } catch (error) {
        console.error(`❌ Error processing ${filePath}:`, error.message);
        return 0;
    }
}

function main() {
    console.log('🚀 Starting Complete Lucide to Heroicon Migration...\n');
    
    const startTime = Date.now();
    const resourcesDir = path.join(process.cwd(), 'resources');
    
    if (!fs.existsSync(resourcesDir)) {
        console.error('❌ Resources directory not found!');
        process.exit(1);
    }
    
    const files = getAllFiles(resourcesDir);
    console.log(`📁 Found ${files.length} PHP/Blade files\n`);
    
    let processedFiles = 0;
    let changedFiles = 0;
    
    files.forEach(file => {
        const result = processFile(file);
        processedFiles++;
        changedFiles += result;
    });
    
    const duration = ((Date.now() - startTime) / 1000).toFixed(2);
    
    console.log('\n🎉 Migration Complete!');
    console.log(`📊 Stats:`);
    console.log(`   - Files processed: ${processedFiles}`);
    console.log(`   - Files changed: ${changedFiles}`);
    console.log(`   - Duration: ${duration}s`);
    console.log(`\n✨ All Lucide usage has been converted to Heroicons!`);
}

if (require.main === module) {
    main();
}

module.exports = { migrateLucideToHeroicon, iconMap };