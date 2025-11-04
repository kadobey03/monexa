#!/usr/bin/env node

/**
 * Final Lucide Cleanup Script
 * Handles remaining edge cases and malformed references
 */

const fs = require('fs');
const path = require('path');

function getAllFiles(dir, fileList = []) {
    const files = fs.readdirSync(dir);
    
    files.forEach(file => {
        const filePath = path.join(dir, file);
        const stat = fs.statSync(filePath);
        
        if (stat.isDirectory()) {
            if (!['node_modules', '.git', 'vendor', 'storage/framework/views'].includes(file)) {
                getAllFiles(filePath, fileList);
            }
        } else if (file.endsWith('.php') || file.endsWith('.blade.php')) {
            fileList.push(filePath);
        }
    });
    
    return fileList;
}

function cleanupLucideReferences(content) {
    let newContent = content;
    let changesMade = false;
    
    // 1. Fix malformed heroicon components with lucide attributes
    const malformedHeroiconRegex = /<x-heroicon\s+name="[^"]*"\s+class="[^"]*"\s+lucide="[^"]*"\s*\/>/g;
    newContent = newContent.replace(malformedHeroiconRegex, (match) => {
        const nameMatch = match.match(/name="([^"]*)"/);
        const classMatch = match.match(/class="([^"]*)"/);
        const name = nameMatch ? nameMatch[1] : 'question-mark-circle';
        const classes = classMatch ? classMatch[1] : 'w-5 h-5';
        changesMade = true;
        return `<x-heroicon name="${name}" class="${classes}" />`;
    });
    
    // 2. Remove remaining data-lucide attributes
    const dataLucideRegex = /<i\s+[^>]*data-lucide=["']([^"']+)["'][^>]*><\/i>/g;
    newContent = newContent.replace(dataLucideRegex, (match, iconName) => {
        const classMatch = match.match(/class=["']([^"']+)["']/);
        const classes = classMatch ? classMatch[1] : 'w-5 h-5';
        
        // Map common icons
        const iconMap = {
            'chevron-up': 'chevron-up',
            'chevron-down': 'chevron-down',
            'chevron-right': 'chevron-right',
            'chevron-left': 'chevron-left',
            'arrow-up': 'arrow-up',
            'check-circle-2': 'check-circle',
            'circle': 'minus',
            'check-circle': 'check-circle',
            'trending-up': 'arrow-trending-up',
            'trending-down': 'arrow-trending-down',
            'dollar-sign': 'currency-dollar',
            'home': 'home',
            'plus-circle': 'plus-circle',
            'zap': 'bolt',
            'user': 'user'
        };
        
        const heroIconName = iconMap[iconName] || iconName;
        changesMade = true;
        return `<x-heroicon name="${heroIconName}" class="${classes}" />`;
    });
    
    // 3. Remove JavaScript lucide checks and initialization
    const jsLucidePatterns = [
        /if\s*\(\s*typeof\s+lucide\s*!==\s*['"`]undefined['"`]\s*\)\s*{[^}]*}/gs,
        /if\s*\(\s*!document\.hidden\s*&&\s*typeof\s+lucide\s*!==\s*['"`]undefined['"`]\s*\)\s*{[^}]*}/gs,
        /lucide\.createIcons\s*\([^)]*\)\s*;?/g,
        /\.setAttribute\s*\(\s*['"`]data-lucide['"`]\s*,\s*[^)]+\)/g
    ];
    
    jsLucidePatterns.forEach(pattern => {
        if (pattern.test(newContent)) {
            newContent = newContent.replace(pattern, '// Removed lucide reference');
            changesMade = true;
        }
    });
    
    // 4. Fix dynamic lucide icon assignments in JavaScript
    newContent = newContent.replace(/methodIcon\.setAttribute\s*\(\s*['"`]data-lucide['"`]\s*,\s*([^)]+)\)\s*;/g, 
        '// Dynamic icon: Use heroicon component instead of data-lucide');
    
    // 5. Fix Alpine.js expressions with conditional icons
    const alpineIconRegex = /<x-heroicon\s+name="([^"]+)\s*\?\s*[^"]*"\s+class="[^"]*"\s+lucide="[^"]*"\s*\/>/g;
    newContent = newContent.replace(alpineIconRegex, (match) => {
        const classMatch = match.match(/class="([^"]*)"/);
        const classes = classMatch ? classMatch[1] : 'w-5 h-5';
        changesMade = true;
        return `<x-heroicon name="question-mark-circle" class="${classes}" />`;
    });
    
    // 6. Clean up broken Alpine.js expressions in heroicon components
    const brokenAlpineRegex = /<x-heroicon\s+name="[^"]*\?\s*[^"]*"\s+class="[^"]*"[^>]*>/g;
    newContent = newContent.replace(brokenAlpineRegex, (match) => {
        const classMatch = match.match(/class="([^"]*)"/);
        const classes = classMatch ? classMatch[1] : 'w-5 h-5';
        changesMade = true;
        return `<x-heroicon name="question-mark-circle" class="${classes}" />`;
    });
    
    // 7. Remove lucide references from comments
    newContent = newContent.replace(/\/\*.*?lucide.*?\*\//gi, '/* Heroicon reference */');
    newContent = newContent.replace(/\/\/.*lucide.*/gi, '// Heroicon reference');
    
    // 8. Clean up loader references in button innerHTML
    newContent = newContent.replace(/innerHTML\s*=\s*'[^']*lucide="loader"[^']*'/g, 
        'innerHTML = \'<x-heroicon name="arrow-path" class="animate-spin w-4 h-4 mr-2" />İşleniyor...\'');
    
    return { content: newContent, changed: changesMade };
}

function processFile(filePath) {
    try {
        const content = fs.readFileSync(filePath, 'utf8');
        const result = cleanupLucideReferences(content);
        
        if (result.changed) {
            fs.writeFileSync(filePath, result.content);
            console.log(`✅ Cleaned: ${filePath}`);
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
    console.log('🧹 Starting Final Lucide Cleanup...\n');
    
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
    
    // Target specific problematic files first
    const problematicFiles = [
        'resources/views/components/admin/leads/table/table-header.blade.php',
        'resources/views/layouts/components/mobile-nav.blade.php',
        'resources/views/admin/roles/partials/tree-node.blade.php',
        'resources/views/admin/managers/edit.blade.php',
        'resources/views/admin/managers/index.blade.php',
        'resources/views/admin/managers/create.blade.php',
        'resources/views/admin/managers/show.blade.php',
        'resources/views/admin/permissions/role-permissions.blade.php',
        'resources/views/admin/permissions/index.blade.php',
        'resources/views/user/connect-wallet.blade.php',
        'resources/views/user/copy/dashboard.blade.php',
        'resources/views/user/demo/dashboard.blade.php',
        'resources/views/user/demo/history.blade.php',
        'resources/views/user/withdraw.blade.php',
        'resources/views/user/notifications/index.blade.php',
        'resources/views/user/notifications/show.blade.php',
        'resources/views/user/bot/dashboard.blade.php',
        'resources/views/user/withdrawals.blade.php'
    ];
    
    problematicFiles.forEach(file => {
        const fullPath = path.join(process.cwd(), file);
        if (fs.existsSync(fullPath)) {
            const result = processFile(fullPath);
            processedFiles++;
            changedFiles += result;
        }
    });
    
    // Process remaining files
    files.forEach(file => {
        if (!problematicFiles.some(pf => file.endsWith(pf.replace('resources/views/', '')))) {
            const result = processFile(file);
            processedFiles++;
            changedFiles += result;
        }
    });
    
    const duration = ((Date.now() - startTime) / 1000).toFixed(2);
    
    console.log('\n🎉 Final Cleanup Complete!');
    console.log(`📊 Stats:`);
    console.log(`   - Files processed: ${processedFiles}`);
    console.log(`   - Files changed: ${changedFiles}`);
    console.log(`   - Duration: ${duration}s`);
    console.log(`\n✨ All remaining Lucide references have been cleaned up!`);
}

if (require.main === module) {
    main();
}

module.exports = { cleanupLucideReferences };