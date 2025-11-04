/**
 * Migration Script: Lucide.js to Heroicons
 * Converts existing lucide icon usage to Heroicon component calls
 * 
 * Usage: node scripts/migrate-to-heroicons.js
 */

const fs = require('fs');
const path = require('path');
const glob = require('glob');

// Icon mapping from lucide to heroicons names
const iconMapping = {
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
    
    // User & Auth
    'user': 'user',
    'user-plus': 'user-plus',
    'user-check': 'user-check',
    'user-x': 'user-minus',
    'user-circle': 'user-circle',
    'user-cog': 'user-cog',
    'users': 'users',
    'log-in': 'arrow-right-on-rectangle',
    'log-out': 'arrow-left-on-rectangle',
    'shield': 'shield-check',
    'shield-check': 'shield-check',
    'shield-alert': 'shield-exclamation',
    
    // Communication
    'mail': 'envelope',
    'phone': 'phone',
    'bell': 'bell',
    'bell-off': 'bell-slash',
    
    // Actions & Status
    'check': 'check',
    'check-circle': 'check-circle',
    'alert-circle': 'exclamation-circle',
    'alert-triangle': 'exclamation-triangle',
    'info': 'information-circle',
    'help-circle': 'question-mark-circle',
    'x-circle': 'x-circle',
    
    // Finance & Trading
    'trending-up': 'arrow-trending-up',
    'trending-down': 'arrow-trending-down',
    'dollar-sign': 'currency-dollar',
    'banknote': 'banknote',
    'wallet': 'wallet',
    'credit-card': 'credit-card',
    'plus-circle': 'plus-circle',
    'minus-circle': 'minus-circle',
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
    'lock': 'lock-closed',
    'unlock': 'lock-open',
    'eye': 'eye',
    'eye-off': 'eye-slash',
    'search': 'magnifying-glass',
    'filter': 'funnel',
    'download': 'arrow-down-tray',
    'upload': 'arrow-up-tray',
    'refresh-cw': 'arrow-path',
    'refresh-ccw': 'arrow-path',
    
    // Layout & Organization
    'layout-dashboard': 'squares-2x2',
    'grid-3x3': 'squares-plus',
    'columns': 'view-columns',
    'list': 'list-bullet',
    'list-checks': 'check-list',
    'calendar': 'calendar-days',
    'clock': 'clock',
    'folder': 'folder',
    'file': 'document',
    'bookmark': 'bookmark'
};

function findBladeFiles() {
    return glob.sync('resources/views/**/*.blade.php', {
        cwd: process.cwd()
    });
}

function convertLucideToHeroicon(content) {
    let convertedContent = content;
    let conversions = 0;

    // Pattern to match lucide data-lucide attributes
    // Match: <i data-lucide="icon-name" class="..."></i>
    const lucidePattern = /<i\s+data-lucide="([^"]+)"([^>]*?)><\/i>/g;
    
    convertedContent = convertedContent.replace(lucidePattern, (match, iconName, attributes) => {
        conversions++;
        
        // Extract classes from attributes
        const classMatch = attributes.match(/class="([^"]*)"/);
        const classes = classMatch ? classMatch[1] : '';
        
        // Extract other attributes
        const otherAttributes = attributes.replace(/class="[^"]*"/, '').trim();
        
        // Map lucide icon to heroicon
        const heroiconName = iconMapping[iconName] || iconName;
        
        // Build the heroicon component
        let heroiconComponent = `<x-heroicon name="${heroiconName}"`;
        
        if (classes) {
            heroiconComponent += ` class="${classes}"`;
        }
        
        if (otherAttributes) {
            heroiconComponent += ` ${otherAttributes}`;
        }
        
        heroiconComponent += ' />';
        
        console.log(`  Converting: ${iconName} → ${heroiconName}`);
        return heroiconComponent;
    });

    return { content: convertedContent, conversions };
}

function removeLucideScripts(content) {
    let cleanedContent = content;
    
    // Remove lucide.js script tags
    cleanedContent = cleanedContent.replace(
        /<script[^>]*src="[^"]*lucide[^"]*"[^>]*><\/script>/g, 
        ''
    );
    
    // Remove lucide CDN links
    cleanedContent = cleanedContent.replace(
        /<script[^>]*unpkg\.com\/lucide[^>]*><\/script>/g,
        ''
    );
    
    // Remove lucide initialization calls
    cleanedContent = cleanedContent.replace(
        /lucide\.createIcons\(\);?/g,
        ''
    );
    
    // Remove references to safeLucideInit
    cleanedContent = cleanedContent.replace(
        /window\.safeLucideInit\(\);?/g,
        ''
    );
    
    // Remove safeLucideInit script includes
    cleanedContent = cleanedContent.replace(
        /<script[^>]*lucide-safe-init\.js[^>]*><\/script>/g,
        ''
    );
    
    // Remove empty script blocks
    cleanedContent = cleanedContent.replace(
        /<script[^>]*>\s*<\/script>/g,
        ''
    );
    
    return cleanedContent;
}

function processFile(filePath) {
    const content = fs.readFileSync(filePath, 'utf8');
    
    // Convert lucide icons to heroicons
    const { content: convertedContent, conversions } = convertLucideToHeroicon(content);
    
    // Remove lucide scripts
    const finalContent = removeLucideScripts(convertedContent);
    
    if (conversions > 0 || finalContent !== content) {
        fs.writeFileSync(filePath, finalContent);
        console.log(`✓ ${filePath}: ${conversions} icons converted`);
        return conversions;
    }
    
    return 0;
}

function main() {
    console.log('🚀 Starting Lucide.js to Heroicons migration...\n');
    
    const bladeFiles = findBladeFiles();
    let totalConversions = 0;
    let processedFiles = 0;
    
    console.log(`Found ${bladeFiles.length} Blade template files\n`);
    
    bladeFiles.forEach(filePath => {
        const conversions = processFile(filePath);
        if (conversions > 0) {
            processedFiles++;
            totalConversions += conversions;
        }
    });
    
    console.log('\n📊 Migration Summary:');
    console.log(`   Files processed: ${processedFiles}`);
    console.log(`   Icons converted: ${totalConversions}`);
    console.log(`   Total files scanned: ${bladeFiles.length}`);
    
    if (totalConversions > 0) {
        console.log('\n✅ Migration completed successfully!');
        console.log('\n📝 Next steps:');
        console.log('   1. Remove lucide.js from package.json if installed');
        console.log('   2. Remove any remaining lucide script tags from layouts');
        console.log('   3. Test your application to ensure icons display correctly');
        console.log('   4. Remove the old lucide-safe-init.js file');
    } else {
        console.log('\nℹ️ No lucide icons found to convert.');
    }
}

// Run the migration
main();