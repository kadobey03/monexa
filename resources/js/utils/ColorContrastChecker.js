/**
 * ColorContrastChecker - Renk Kontrastı Analiz ve Uyumluluk Kontrolü
 * 
 * WCAG 2.1 AA/AAA standartlarına uygun renk kontrastı kontrolü
 * Otomatik renk optimizasyonu ve high contrast mode desteği
 * Real-time kontrast analizi ve uyarı sistemi
 */

class ColorContrastChecker {
    constructor() {
        this.wcagLevels = {
            AA: { normal: 4.5, large: 3.0 },
            AAA: { normal: 7.0, large: 4.5 }
        };
        
        this.contrastResults = new Map();
        this.colorPalette = new Map();
        this.highContrastMode = false;
        this.autoFixEnabled = true;
        this.monitorInterval = null;
        
        this.init();
    }

    /**
     * Contrats checker'ı başlat
     */
    init() {
        this.setupColorPalette();
        this.setupHighContrastMode();
        this.startMonitoring();
        this.createControlPanel();
        this.bindEvents();
        
        console.log('ColorContrastChecker initialized');
    }

    /**
     * Renk paletini kur
     */
    setupColorPalette() {
        // Varsayılan renk paletini analiz et
        const rootStyles = getComputedStyle(document.documentElement);
        const colors = {
            primary: rootStyles.getPropertyValue('--primary-color').trim() || '#3b82f6',
            secondary: rootStyles.getPropertyValue('--secondary-color').trim() || '#6b7280',
            success: rootStyles.getPropertyValue('--success-color').trim() || '#10b981',
            warning: rootStyles.getPropertyValue('--warning-color').trim() || '#f59e0b',
            danger: rootStyles.getPropertyValue('--danger-color').trim() || '#ef4444',
            info: rootStyles.getPropertyValue('--info-color').trim() || '#06b6d4'
        };
        
        Object.entries(colors).forEach(([name, color]) => {
            this.colorPalette.set(name, this.normalizeColor(color));
        });
        
        // Tailwind CSS renklerini de analiz et
        this.analyzeTailwindColors();
    }

    /**
     * Tailwind CSS renklerini analiz et
     */
    analyzeTailwindColors() {
        const tailwindColors = {
            blue: { 50: '#eff6ff', 500: '#3b82f6', 600: '#2563eb', 900: '#1e3a8a' },
            green: { 50: '#ecfdf5', 500: '#10b981', 600: '#059669', 900: '#064e3b' },
            yellow: { 50: '#fffbeb', 500: '#f59e0b', 600: '#d97706', 900: '#78350f' },
            red: { 50: '#fef2f2', 500: '#ef4444', 600: '#dc2626', 900: '#7f1d1d' },
            gray: { 50: '#f9fafb', 500: '#6b7280', 600: '#4b5563', 900: '#111827' }
        };
        
        Object.entries(tailwindColors).forEach(([colorName, shades]) => {
            Object.entries(shades).forEach(([shade, hex]) => {
                const colorKey = `${colorName}-${shade}`;
                this.colorPalette.set(colorKey, this.normalizeColor(hex));
            });
        });
    }

    /**
     * Renk kontrastı hesapla
     */
    calculateContrast(foregroundColor, backgroundColor) {
        const fg = this.normalizeColor(foregroundColor);
        const bg = this.normalizeColor(backgroundColor);
        
        const fgLuminance = this.calculateRelativeLuminance(fg);
        const bgLuminance = this.calculateRelativeLuminance(bg);
        
        const lighter = Math.max(fgLuminance, bgLuminance);
        const darker = Math.min(fgLuminance, bgLuminance);
        
        const contrast = (lighter + 0.05) / (darker + 0.05);
        
        return {
            ratio: Math.round(contrast * 100) / 100,
            passesAA: {
                normal: contrast >= this.wcagLevels.AA.normal,
                large: contrast >= this.wcagLevels.AA.large
            },
            passesAAA: {
                normal: contrast >= this.wcagLevels.AAA.normal,
                large: contrast >= this.wcagLevels.AAA.large
            },
            foreground: fg,
            background: bg
        };
    }

    /**
     * Relative luminance hesapla
     */
    calculateRelativeLuminance(color) {
        const { r, g, b } = this.hexToRgb(color);
        
        const rgb = [r, g, b].map(value => {
            value = value / 255;
            return value <= 0.03928 ? value / 12.92 : Math.pow((value + 0.055) / 1.055, 2.4);
        });
        
        return 0.2126 * rgb[0] + 0.7152 * rgb[1] + 0.0722 * rgb[2];
    }

    /**
     * Hex renk değerini normalize et
     */
    normalizeColor(color) {
        if (!color) return '#000000';
        
        color = color.trim();
        
        // RGB/RGBA değerlerini hex'e çevir
        if (color.startsWith('rgb') || color.startsWith('rgba')) {
            return this.rgbToHex(color);
        }
        
        // HSL/HSLA değerlerini hex'e çevir
        if (color.startsWith('hsl') || color.startsWith('hsla')) {
            return this.hslToHex(color);
        }
        
        // CSS variable değerini çöz
        if (color.startsWith('var(')) {
            const varName = color.slice(4, -1);
            const computedValue = getComputedStyle(document.documentElement).getPropertyValue(varName);
            return this.normalizeColor(computedValue);
        }
        
        // Hex formatı
        if (color.startsWith('#')) {
            return this.expandHex(color);
        }
        
        // Named color
        const namedColors = {
            white: '#ffffff',
            black: '#000000',
            red: '#ff0000',
            green: '#008000',
            blue: '#0000ff',
            yellow: '#ffff00',
            cyan: '#00ffff',
            magenta: '#ff00ff',
            gray: '#808080',
            grey: '#808080'
        };
        
        return namedColors[color.toLowerCase()] || '#000000';
    }

    /**
     * RGB değerini hex'e çevir
     */
    rgbToHex(rgbString) {
        const match = rgbString.match(/rgba?\s*\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)/i);
        if (!match) return '#000000';
        
        const r = parseInt(match[1], 10);
        const g = parseInt(match[2], 10);
        const b = parseInt(match[3], 10);
        
        return this.rgbToHexValues(r, g, b);
    }

    /**
     * RGB değerlerini hex'e çevir
     */
    rgbToHexValues(r, g, b) {
        return '#' + [r, g, b].map(x => {
            const hex = x.toString(16);
            return hex.length === 1 ? '0' + hex : hex;
        }).join('');
    }

    /**
     * HSL değerini hex'e çevir
     */
    hslToHex(hslString) {
        const match = hslString.match(/hsla?\s*\(\s*(\d+)\s*,\s*(\d+)%\s*,\s*(\d+)%/i);
        if (!match) return '#000000';
        
        const h = parseInt(match[1], 10);
        const s = parseInt(match[2], 10) / 100;
        const l = parseInt(match[3], 10) / 100;
        
        const { r, g, b } = this.hslToRgb(h, s, l);
        return this.rgbToHexValues(r, g, b);
    }

    /**
     * HSL değerlerini RGB'ye çevir
     */
    hslToRgb(h, s, l) {
        h /= 360;
        
        const hue2rgb = (p, q, t) => {
            if (t < 0) t += 1;
            if (t > 1) t -= 1;
            if (t < 1/6) return p + (q - p) * 6 * t;
            if (t < 1/2) return q;
            if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
            return p;
        };
        
        let r, g, b;
        
        if (s === 0) {
            r = g = b = l;
        } else {
            const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
            const p = 2 * l - q;
            r = hue2rgb(p, q, h + 1/3);
            g = hue2rgb(p, q, h);
            b = hue2rgb(p, q, h - 1/3);
        }
        
        return {
            r: Math.round(r * 255),
            g: Math.round(g * 255),
            b: Math.round(b * 255)
        };
    }

    /**
     * Hex değerini RGB'ye çevir
     */
    hexToRgb(hex) {
        hex = this.expandHex(hex);
        const match = hex.match(/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i);
        
        if (!match) {
            return { r: 0, g: 0, b: 0 };
        }
        
        return {
            r: parseInt(match[1], 16),
            g: parseInt(match[2], 16),
            b: parseInt(match[3], 16)
        };
    }

    /**
     * Kısaltılmış hex'i genişlet
     */
    expandHex(hex) {
        if (hex.length === 4) {
            return '#' + hex[1] + hex[1] + hex[2] + hex[2] + hex[3] + hex[3];
        }
        return hex;
    }

    /**
     * Sayfa kontrastını analiz et
     */
    analyzePageContrast() {
        const results = {
            total: 0,
            passAA: 0,
            passAAA: 0,
            fail: 0,
            issues: []
        };
        
        // Tüm elementleri analiz et
        const elements = document.querySelectorAll('*');
        
        elements.forEach(element => {
            const elementContrast = this.analyzeElementContrast(element);
            if (elementContrast) {
                results.total++;
                results[elementContrast.result]++;
                
                if (elementContrast.result === 'fail') {
                    results.issues.push(elementContrast);
                }
            }
        });
        
        this.contrastResults.set('page-analysis', results);
        return results;
    }

    /**
     * Tek element kontrastını analiz et
     */
    analyzeElementContrast(element) {
        const styles = getComputedStyle(element);
        const color = styles.color;
        const backgroundColor = styles.backgroundColor;
        
        // Transparent background kontrolü
        if (this.isTransparent(backgroundColor)) {
            // Parent elementlerin background'unu kontrol et
            const parentBg = this.getEffectiveBackgroundColor(element);
            if (this.isTransparent(parentBg)) {
                return null; // Tam transparent, analiz etme
            }
        }
        
        // Font size ve weight kontrolü
        const fontSize = parseFloat(styles.fontSize);
        const fontWeight = parseInt(styles.fontWeight);
        const isLargeText = fontSize >= 24 || (fontSize >= 18.67 && fontWeight >= 700);
        
        const contrast = this.calculateContrast(color, backgroundColor);
        
        let result;
        if (isLargeText) {
            result = contrast.passesAA.large ? 'passAA' : (contrast.passesAAA.large ? 'passAAA' : 'fail');
        } else {
            result = contrast.passesAA.normal ? 'passAA' : (contrast.passesAAA.normal ? 'passAAA' : 'fail');
        }
        
        const elementInfo = {
            element,
            tagName: element.tagName,
            className: element.className,
            textContent: element.textContent.substring(0, 50),
            color,
            backgroundColor: backgroundColor === 'rgba(0, 0, 0, 0)' ? parentBg : backgroundColor,
            contrastRatio: contrast.ratio,
            isLargeText,
            result,
            suggestion: result === 'fail' ? this.generateSuggestion(color, backgroundColor, isLargeText) : null
        };
        
        return elementInfo;
    }

    /**
     * Background color'un transparent olup olmadığını kontrol et
     */
    isTransparent(color) {
        return color === 'transparent' || color === 'rgba(0, 0, 0, 0)' || !color;
    }

    /**
     * Effective background color'u al
     */
    getEffectiveBackgroundColor(element) {
        let current = element.parentElement;
        while (current && current !== document.body) {
            const bg = getComputedStyle(current).backgroundColor;
            if (!this.isTransparent(bg)) {
                return bg;
            }
            current = current.parentElement;
        }
        return '#ffffff'; // Default white background
    }

    /**
     * Renk önerisi oluştur
     */
    generateSuggestion(foregroundColor, backgroundColor, isLargeText) {
        const minRatio = isLargeText ? this.wcagLevels.AA.large : this.wcagLevels.AA.normal;
        const suggestions = [];
        
        // Koyu renk önerileri
        suggestions.push({
            type: 'darken-foreground',
            color: this.darkenColor(foregroundColor, 0.2),
            description: 'Foreground rengini koyulaştır'
        });
        
        // Açık renk önerileri
        suggestions.push({
            type: 'lighten-background',
            color: this.lightenColor(backgroundColor, 0.2),
            description: 'Background rengini aydınlat'
        });
        
        // Kontrast hesapla
        const currentContrast = this.calculateContrast(foregroundColor, backgroundColor);
        const bestSuggestion = suggestions.find(s => 
            this.calculateContrast(s.color, backgroundColor).ratio >= minRatio
        );
        
        return bestSuggestion || suggestions[0];
    }

    /**
     * Rengi koyulaştır
     */
    darkenColor(color, amount) {
        const { r, g, b } = this.hexToRgb(this.normalizeColor(color));
        
        const newR = Math.max(0, r - (255 * amount));
        const newG = Math.max(0, g - (255 * amount));
        const newB = Math.max(0, b - (255 * amount));
        
        return this.rgbToHexValues(Math.round(newR), Math.round(newG), Math.round(newB));
    }

    /**
     * Rengi aydınlat
     */
    lightenColor(color, amount) {
        const { r, g, b } = this.hexToRgb(this.normalizeColor(color));
        
        const newR = Math.min(255, r + (255 * amount));
        const newG = Math.min(255, g + (255 * amount));
        const newB = Math.min(255, b + (255 * amount));
        
        return this.rgbToHexValues(Math.round(newR), Math.round(newG), Math.round(newB));
    }

    /**
     * High contrast mode kur
     */
    setupHighContrastMode() {
        // High contrast media query dinle
        const mediaQuery = window.matchMedia('(prefers-contrast: high)');
        
        const handleContrastChange = (e) => {
            if (e.matches) {
                this.enableHighContrast();
            }
        };
        
        mediaQuery.addListener(handleContrastChange);
        
        // İlk durumu kontrol et
        if (mediaQuery.matches) {
            this.enableHighContrast();
        }
        
        // Manual toggle butonu ekle
        this.createHighContrastToggle();
    }

    /**
     * High contrast mode'u etkinleştir
     */
    enableHighContrast() {
        this.highContrastMode = true;
        
        // CSS değişkenlerini güncelle
        document.documentElement.style.setProperty('--high-contrast-mode', '1');
        
        // High contrast styles ekle
        this.addHighContrastStyles();
        
        // Event emit et
        document.dispatchEvent(new CustomEvent('high-contrast-enabled'));
        
        console.log('High contrast mode enabled');
    }

    /**
     * High contrast mode'u devre dışı bırak
     */
    disableHighContrast() {
        this.highContrastMode = false;
        
        document.documentElement.style.removeProperty('--high-contrast-mode');
        
        // High contrast styles'ı kaldır
        this.removeHighContrastStyles();
        
        // Event emit et
        document.dispatchEvent(new CustomEvent('high-contrast-disabled'));
        
        console.log('High contrast mode disabled');
    }

    /**
     * High contrast styles ekle
     */
    addHighContrastStyles() {
        const style = document.createElement('style');
        style.id = 'high-contrast-styles';
        style.textContent = `
            [data-high-contrast="true"] {
                --color-primary: #000000 !important;
                --color-secondary: #000000 !important;
                --color-success: #008000 !important;
                --color-warning: #ff8c00 !important;
                --color-danger: #dc143c !important;
                --color-info: #0066cc !important;
            }
            
            [data-high-contrast="true"] * {
                color: #000000 !important;
                background-color: #ffffff !important;
                border-color: #000000 !important;
            }
            
            [data-high-contrast="true"] .bg-primary,
            [data-high-contrast="true"] .bg-success,
            [data-high-contrast="true"] .bg-warning,
            [data-high-contrast="true"] .bg-danger,
            [data-high-contrast="true"] .bg-info {
                background-color: #000000 !important;
                color: #ffffff !important;
            }
            
            [data-high-contrast="true"] a {
                color: #0000ff !important;
                text-decoration: underline !important;
            }
            
            [data-high-contrast="true"] button,
            [data-high-contrast="true"] .btn {
                background-color: #000000 !important;
                color: #ffffff !important;
                border: 2px solid #000000 !important;
            }
            
            [data-high-contrast="true"] input,
            [data-high-contrast="true"] select,
            [data-high-contrast="true"] textarea {
                background-color: #ffffff !important;
                color: #000000 !important;
                border: 2px solid #000000 !important;
            }
        `;
        
        document.head.appendChild(style);
        document.documentElement.setAttribute('data-high-contrast', 'true');
    }

    /**
     * High contrast styles'ı kaldır
     */
    removeHighContrastStyles() {
        const style = document.getElementById('high-contrast-styles');
        if (style) {
            style.remove();
        }
        document.documentElement.removeAttribute('data-high-contrast');
    }

    /**
     * High contrast toggle butonu oluştur
     */
    createHighContrastToggle() {
        const toggle = document.createElement('button');
        toggle.id = 'high-contrast-toggle';
        toggle.className = 'fixed bottom-4 right-4 z-50 px-4 py-2 bg-gray-800 text-white rounded-lg shadow-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500';
        toggle.setAttribute('aria-label', 'Yüksek kontrast modunu aç/kapat');
        toggle.innerHTML = `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span class="ml-2 text-sm">Yüksek Kontrast</span>
        `;
        
        toggle.addEventListener('click', () => {
            if (this.highContrastMode) {
                this.disableHighContrast();
            } else {
                this.enableHighContrast();
            }
        });
        
        document.body.appendChild(toggle);
    }

    /**
     * Kontrast kontrol paneli oluştur
     */
    createControlPanel() {
        const panel = document.createElement('div');
        panel.id = 'contrast-control-panel';
        panel.className = 'fixed bottom-4 left-4 z-50 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 max-w-sm';
        panel.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Renk Kontrastı Kontrolü</h3>
                <button id="close-contrast-panel" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="space-y-2 text-xs">
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Toplam Element:</span>
                    <span id="total-elements">0</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-green-600">AA Uyumlu:</span>
                    <span id="aa-pass">0</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-yellow-600">AAA Uyumlu:</span>
                    <span id="aaa-pass">0</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-red-600">Uyumsuz:</span>
                    <span id="contrast-fail">0</span>
                </div>
            </div>
            <div class="mt-3 flex space-x-2">
                <button id="analyze-contrast" class="flex-1 px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                    Analiz Et
                </button>
                <button id="fix-contrast" class="flex-1 px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">
                    Otomatik Düzelt
                </button>
            </div>
        `;
        
        // Event listeners
        panel.querySelector('#close-contrast-panel').addEventListener('click', () => {
            panel.style.display = 'none';
        });
        
        panel.querySelector('#analyze-contrast').addEventListener('click', () => {
            this.runAnalysis();
        });
        
        panel.querySelector('#fix-contrast').addEventListener('click', () => {
            this.autoFixIssues();
        });
        
        document.body.appendChild(panel);
        
        // Başlangıçta gizli
        panel.style.display = 'none';
    }

    /**
     * Otomatik kontrast analizi çalıştır
     */
    runAnalysis() {
        const results = this.analyzePageContrast();
        
        // Panel'de sonuçları güncelle
        document.getElementById('total-elements').textContent = results.total;
        document.getElementById('aa-pass').textContent = results.passAA;
        document.getElementById('aaa-pass').textContent = results.passAAA;
        document.getElementById('contrast-fail').textContent = results.fail;
        
        // Sonuçları console'a yazdır
        console.log('Kontrast Analizi Sonuçları:', results);
        
        // Alert göster
        if (results.fail > 0) {
            this.showContrastAlert(results);
        }
    }

    /**
     * Kontrast uyarısı göster
     */
    showContrastAlert(results) {
        const alert = document.createElement('div');
        alert.className = 'fixed top-4 right-4 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg';
        alert.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span>${results.fail} element WCAG kontrast standartlarını karşılamıyor!</span>
                <button class="ml-4 text-red-500 hover:text-red-700" onclick="this.parentElement.parentElement.remove()">
                    ×
                </button>
            </div>
        `;
        
        document.body.appendChild(alert);
        
        // 5 saniye sonra otomatik kaldır
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    /**
     * Otomatik kontrast sorunlarını düzelt
     */
    autoFixIssues() {
        if (!this.autoFixEnabled) return;
        
        const results = this.analyzePageContrast();
        let fixedCount = 0;
        
        results.issues.forEach(issue => {
            if (issue.suggestion) {
                const fixed = this.applyFix(issue, issue.suggestion);
                if (fixed) fixedCount++;
            }
        });
        
        // Sonucu duyur
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announce(
                `${fixedCount} renk kontrastı sorunu otomatik olarak düzeltildi`,
                'status_update'
            );
        }
        
        console.log(`Otomatik düzeltme tamamlandı: ${fixedCount} sorun çözüldü`);
    }

    /**
     * Kontrast düzeltmesini uygula
     */
    applyFix(issue, suggestion) {
        try {
            switch (suggestion.type) {
                case 'darken-foreground':
                    issue.element.style.color = suggestion.color;
                    break;
                case 'lighten-background':
                    issue.element.style.backgroundColor = suggestion.color;
                    break;
                default:
                    return false;
            }
            return true;
        } catch (error) {
            console.error('Kontrast düzeltme hatası:', error);
            return false;
        }
    }

    /**
     * Monitoring başlat
     */
    startMonitoring() {
        this.monitorInterval = setInterval(() => {
            if (!this.highContrastMode) {
                this.checkPageContrastChanges();
            }
        }, 5000); // 5 saniyede bir kontrol et
    }

    /**
     * Sayfa kontrastı değişikliklerini kontrol et
     */
    checkPageContrastChanges() {
        // Yeni eklenen elementleri kontrol et
        const elements = document.querySelectorAll('[data-contrast-check="false"]:not([data-contrast-checked="true"])');
        
        elements.forEach(element => {
            const contrast = this.analyzeElementContrast(element);
            if (contrast && contrast.result === 'fail') {
                element.setAttribute('data-contrast-issue', 'true');
            }
            element.setAttribute('data-contrast-checked', 'true');
        });
    }

    /**
     * Real-time kontrast analizi
     */
    analyzeElementInRealTime(element) {
        const result = this.analyzeElementContrast(element);
        if (result && result.result === 'fail') {
            // Element'i vurgula
            this.highlightContrastIssue(element, result);
        }
    }

    /**
     * Kontrast sorununu vurgula
     */
    highlightContrastIssue(element, result) {
        // Mevcut outline'ı kaydet
        const originalOutline = element.style.outline;
        const originalBoxShadow = element.style.boxShadow;
        
        // Kontrast sorununu vurgula
        element.style.outline = '3px solid #ef4444';
        element.style.boxShadow = '0 0 0 6px rgba(239, 68, 68, 0.3)';
        
        // Tooltip göster
        this.showContrastTooltip(element, result);
        
        // 3 saniye sonra vurguyu kaldır
        setTimeout(() => {
            element.style.outline = originalOutline;
            element.style.boxShadow = originalBoxShadow;
            const tooltip = element.querySelector('.contrast-tooltip');
            if (tooltip) {
                tooltip.remove();
            }
        }, 3000);
    }

    /**
     * Kontrast tooltip'i göster
     */
    showContrastTooltip(element, result) {
        const tooltip = document.createElement('div');
        tooltip.className = 'contrast-tooltip fixed z-50 bg-red-600 text-white px-3 py-2 rounded shadow-lg text-sm pointer-events-none';
        tooltip.style.left = (element.getBoundingClientRect().left + window.scrollX) + 'px';
        tooltip.style.top = (element.getBoundingClientRect().top + window.scrollY - 40) + 'px';
        
        tooltip.innerHTML = `
            Kontrast Oranı: ${result.contrastRatio}:1 (Gerekli: ${result.isLargeText ? '3.0:1' : '4.5:1'})
            <br>Önerilen çözümler için kontrol panelini açın
        `;
        
        document.body.appendChild(tooltip);
    }

    /**
     * Event binding
     */
    bindEvents() {
        // Livewire events
        if (window.Livewire) {
            Livewire.on('element-added', (data) => {
                const element = document.querySelector(data.selector);
                if (element) {
                    this.analyzeElementInRealTime(element);
                }
            });
        }
        
        // Mouse over events - element hover'da analiz et
        document.addEventListener('mouseover', (event) => {
            const target = event.target;
            if (target.matches('p, span, h1, h2, h3, h4, h5, h6, a, button, .text-*')) {
                // Sadece development modda çalış
                if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                    this.analyzeElementInRealTime(target);
                }
            }
        });
        
        // Mutation observer - DOM değişikliklerini izle
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        if (node.matches && node.matches('p, span, h1, h2, h3, h4, h5, h6, a, button')) {
                            node.setAttribute('data-contrast-check', 'false');
                        }
                        
                        // Alt node'ları da kontrol et
                        const childElements = node.querySelectorAll?.('p, span, h1, h2, h3, h4, h5, h6, a, button');
                        childElements?.forEach(el => {
                            el.setAttribute('data-contrast-check', 'false');
                        });
                    }
                });
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    /**
     * Renk kontrastını doğrula
     */
    validateColorCombination(foregroundColor, backgroundColor, wcagLevel = 'AA') {
        const result = this.calculateContrast(foregroundColor, backgroundColor);
        const level = this.wcagLevels[wcagLevel.toUpperCase()];
        
        return {
            valid: result.ratio >= level.normal,
            ratio: result.ratio,
            required: level.normal,
            message: result.ratio >= level.normal ? 
                'Renk kombinasyonu uygun' : 
                `Renk kontrastı yetersiz (Gerekli: ${level.normal}:1, Mevcut: ${result.ratio}:1)`
        };
    }

    /**
     * Önerilen renk paleti oluştur
     */
    generateAccessiblePalette(baseColor) {
        const base = this.normalizeColor(baseColor);
        const palette = {
            primary: base,
            secondary: this.generateSecondaryColor(base),
            success: '#10b981',
            warning: '#f59e0b',
            danger: '#ef4444',
            info: '#06b6d4',
            background: this.getAccessibleBackground(base),
            text: this.getAccessibleTextColor(base)
        };
        
        return palette;
    }

    /**
     * İkincil renk oluştur
     */
    generateSecondaryColor(primaryColor) {
        // HSL'e çevir ve hue değerini 30 derece kaydır
        const rgb = this.hexToRgb(primaryColor);
        const hsl = this.rgbToHsl(rgb.r, rgb.g, rgb.b);
        
        hsl.h = (hsl.h + 30) % 360;
        const secondary = this.hslToRgb(hsl.h, hsl.s, hsl.l);
        
        return this.rgbToHexValues(secondary.r, secondary.g, secondary.b);
    }

    /**
     * Erişilebilir background rengi oluştur
     */
    getAccessibleBackground(foregroundColor) {
        const fg = this.normalizeColor(foregroundColor);
        const fgLuminance = this.calculateRelativeLuminance(fg);
        
        // Yeterli kontrast sağlayacak background rengi seç
        if (fgLuminance > 0.5) {
            return '#ffffff'; // Koyu foreground için açık background
        } else {
            return '#000000'; // Açık foreground için koyu background
        }
    }

    /**
     * Erişilebilir text rengi oluştur
     */
    getAccessibleTextColor(backgroundColor) {
        const bg = this.normalizeColor(backgroundColor);
        const bgLuminance = this.calculateRelativeLuminance(bg);
        
        // Background'a göre uygun text rengi seç
        if (bgLuminance > 0.5) {
            return '#000000'; // Açık background için koyu text
        } else {
            return '#ffffff'; // Koyu background için açık text
        }
    }

    /**
     * RGB'yi HSL'ye çevir
     */
    rgbToHsl(r, g, b) {
        r /= 255;
        g /= 255;
        b /= 255;
        
        const max = Math.max(r, g, b);
        const min = Math.min(r, g, b);
        let h, s, l = (max + min) / 2;
        
        if (max === min) {
            h = s = 0; // achromatic
        } else {
            const d = max - min;
            s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
            
            switch (max) {
                case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                case g: h = (b - r) / d + 2; break;
                case b: h = (r - g) / d + 4; break;
            }
            
            h /= 6;
        }
        
        return { h: Math.round(h * 360), s: Math.round(s * 100), l: Math.round(l * 100) };
    }

    /**
     * Control panel'ı göster
     */
    showControlPanel() {
        const panel = document.getElementById('contrast-control-panel');
        if (panel) {
            panel.style.display = 'block';
            this.runAnalysis();
        }
    }

    /**
     * Reset method
     */
    reset() {
        this.contrastResults.clear();
        this.disableHighContrast();
        
        if (this.monitorInterval) {
            clearInterval(this.monitorInterval);
            this.monitorInterval = null;
        }
    }

    /**
     * Status get
     */
    getStatus() {
        return {
            highContrastMode: this.highContrastMode,
            autoFixEnabled: this.autoFixEnabled,
            totalAnalyses: this.contrastResults.size,
            paletteSize: this.colorPalette.size
        };
    }
}

// Global instance
window.ColorContrastChecker = new ColorContrastChecker();

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ColorContrastChecker;
}