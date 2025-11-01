/**
 * AccessibilityTester - Otomatik Erişilebilirlik Test Sistemi
 * 
 * Axe-core entegrasyonu ile kapsamlı erişilebilirlik testi
 * Otomatik test çalıştırma, raporlama ve iyileştirme önerileri
 * CI/CD entegrasyonu için JSON raporları
 */

class AccessibilityTester {
    constructor(options = {}) {
        this.config = {
            runAxeCore: true,
            wcagVersion: 'WCAG2A', // WCAG2A, WCAG2AA, WCAG2AAA
            showInBrowser: true,
            saveReports: true,
            reportFormat: 'json', // json, html, csv
            testTimeout: 30000,
            excludeElements: ['.skip-link', '.sr-only'],
            includeElements: ['main', 'nav', 'section', 'article', 'form', 'button'],
            ...options
        };
        
        this.testResults = new Map();
        this.violations = [];
        this.incomplete = [];
        this.inapplicable = [];
        this.runningTests = new Set();
        this.lastRun = null;
        
        this.init();
    }

    /**
     * Accessibility tester'ı başlat
     */
    async init() {
        try {
            await this.loadAxeCore();
            this.setupTestingInfrastructure();
            this.createTestInterface();
            this.bindEvents();
            
            console.log('AccessibilityTester initialized with Axe-core');
        } catch (error) {
            console.warn('Axe-core failed to load, running with basic tests:', error);
            await this.initBasicTests();
        }
    }

    /**
     * Axe-core'u yükle
     */
    async loadAxeCore() {
        if (typeof axe !== 'undefined') {
            return; // Zaten yüklenmiş
        }
        
        // Script element oluştur
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/axe-core@4.8.2/axe.min.js';
        script.async = true;
        
        return new Promise((resolve, reject) => {
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }

    /**
     * Temel testleri başlat (axe-core yoksa)
     */
    async initBasicTests() {
        this.basicTests = {
            images: this.testImagesAlt(),
            forms: this.testFormAccessibility(),
            links: this.testLinksAccessibility(),
            headings: this.testHeadingStructure(),
            keyboard: this.testKeyboardNavigation(),
            color: this.testColorContrast(),
            focus: this.testFocusManagement()
        };
        
        console.log('Basic accessibility tests initialized');
    }

    /**
     * Test altyapısını kur
     */
    setupTestingInfrastructure() {
        // Test report container
        this.createReportContainer();
        
        // Test control panel
        this.createControlPanel();
        
        // Real-time monitoring setup
        this.setupRealTimeMonitoring();
        
        // Test scheduling
        this.setupTestScheduling();
    }

    /**
     * Rapor container'ı oluştur
     */
    createReportContainer() {
        const container = document.createElement('div');
        container.id = 'accessibility-test-results';
        container.className = 'accessibility-results-panel fixed top-4 right-4 z-50 bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md max-h-96 overflow-hidden border border-gray-200 dark:border-gray-700';
        container.style.display = 'none';
        
        container.innerHTML = `
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Erişilebilirlik Testi</h3>
                    <div class="flex items-center space-x-2">
                        <button id="run-full-test" class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                            Tam Test
                        </button>
                        <button id="close-results" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="overflow-y-auto max-h-80">
                <div id="test-progress" class="p-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Test hazır...</div>
                </div>
                <div id="test-results" class="p-4 space-y-3"></div>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex space-x-2">
                    <button id="export-report" class="flex-1 px-3 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                        Rapor İndir
                    </button>
                    <button id="fix-issues" class="flex-1 px-3 py-2 bg-yellow-600 text-white text-sm rounded hover:bg-yellow-700">
                        Sorunları Düzelt
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(container);
    }

    /**
     * Test kontrol paneli oluştur
     */
    createControlPanel() {
        const panel = document.createElement('div');
        panel.id = 'accessibility-control-panel';
        panel.className = 'accessibility-control-panel fixed bottom-20 right-4 z-40 bg-gray-900 text-white p-3 rounded-lg shadow-lg';
        
        panel.innerHTML = `
            <div class="flex items-center space-x-3">
                <button id="toggle-test-panel" class="p-2 bg-blue-600 rounded hover:bg-blue-700" title="Erişilebilirlik Testi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </button>
                <div class="text-sm">
                    <div id="test-status" class="font-medium">Test Hazır</div>
                    <div id="last-test-time" class="text-gray-400 text-xs">Henüz test yapılmadı</div>
                </div>
            </div>
        `;
        
        document.body.appendChild(panel);
    }

    /**
     * Real-time monitoring kur
     */
    setupRealTimeMonitoring() {
        // DOM değişikliklerini izle
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList') {
                    // Yeni elementler eklendiğinde test et
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === Node.ELEMENT_NODE) {
                            this.scheduleRealtimeTest(node);
                        }
                    });
                }
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
        
        // Form submission'ları izle
        document.addEventListener('submit', (event) => {
            setTimeout(() => {
                this.runTargetedTest('form', event.target);
            }, 1000);
        });
        
        // Modal açma/kapama'ları izle
        document.addEventListener('modal:opened', (event) => {
            setTimeout(() => {
                this.runTargetedTest('modal', event.detail.modal);
            }, 500);
        });
        
        // Navigation değişikliklerini izle
        let currentUrl = window.location.href;
        setInterval(() => {
            if (window.location.href !== currentUrl) {
                currentUrl = window.location.href;
                this.runFullPageTest();
            }
        }, 1000);
    }

    /**
     * Test scheduling kur
     */
    setupTestScheduling() {
        // Otomatik test zamanlayıcısı
        this.testScheduler = setInterval(() => {
            if (!this.runningTests.size) {
                this.runScheduledTest();
            }
        }, 60000); // Her dakika
    }

    /**
     * Full page test çalıştır
     */
    async runFullPageTest() {
        const testId = this.generateTestId();
        this.runningTests.add(testId);
        
        this.updateTestStatus('Tam sayfa testi çalışıyor...');
        this.showProgress();
        
        try {
            let results;
            
            if (typeof axe !== 'undefined') {
                results = await this.runAxeCoreTest();
            } else if (this.basicTests) {
                results = await this.runBasicTests();
            } else {
                throw new Error('No test framework available');
            }
            
            this.processTestResults(results);
            this.lastRun = new Date();
            this.updateLastTestTime();
            
            // Accessibility announcement
            if (window.LiveAnnouncer) {
                const violationCount = results.violations?.length || 0;
                window.LiveAnnouncer.announce(
                    `Erişilebilirlik testi tamamlandı. ${violationCount} sorun bulundu.`,
                    'status_update'
                );
            }
            
        } catch (error) {
            console.error('Test execution failed:', error);
            this.updateTestStatus('Test başarısız: ' + error.message);
        } finally {
            this.runningTests.delete(testId);
            this.hideProgress();
        }
    }

    /**
     * Axe-core test çalıştır
     */
    async runAxeCoreTest() {
        const results = await axe.run(document, {
            runOnly: {
                type: 'tag',
                values: [this.config.wcagVersion]
            },
            resultTypes: ['violations', 'incomplete', 'inapplicable'],
            selectors: false,
            excludeElements: this.config.excludeElements.join(', '),
            iframes: true,
            elementRef: true,
            xpath: false,
            detail: true,
            toolName: 'Monexa Accessibility Tester',
            reporter: 'v2'
        });
        
        return {
            violations: results.violations || [],
            incomplete: results.incomplete || [],
            inapplicable: results.inapplicable || [],
            timestamp: new Date().toISOString(),
            url: window.location.href,
            userAgent: navigator.userAgent
        };
    }

    /**
     * Temel testler çalıştır
     */
    async runBasicTests() {
        const results = {
            violations: [],
            incomplete: [],
            inapplicable: [],
            timestamp: new Date().toISOString(),
            url: window.location.href
        };
        
        // Her temel testi çalıştır
        for (const [testName, testFunction] of Object.entries(this.basicTests)) {
            try {
                const testResult = await testFunction();
                if (testResult.violations) {
                    results.violations.push(...testResult.violations);
                }
            } catch (error) {
                console.warn(`Basic test ${testName} failed:`, error);
            }
        }
        
        return results;
    }

    /**
     * Img alt text testi
     */
    async testImagesAlt() {
        const images = document.querySelectorAll('img');
        const violations = [];
        
        images.forEach((img, index) => {
            const alt = img.getAttribute('alt');
            const ariaLabel = img.getAttribute('aria-label');
            const role = img.getAttribute('role');
            const ariaHidden = img.getAttribute('aria-hidden');
            
            // Decorative image değilse alt text gerekli
            if (!ariaHidden && role !== 'presentation' && role !== 'none') {
                if (!alt && !ariaLabel) {
                    violations.push({
                        id: `img-alt-${index}`,
                        impact: 'critical',
                        tags: ['cat.text-alternatives', 'wcag2a', 'wcag2aa', 'wcag111'],
                        description: 'Image missing alt text',
                        help: 'All images must have appropriate alternative text',
                        helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/image-alt',
                        nodes: [{
                            html: img.outerHTML.substring(0, 100),
                            target: [img.tagName.toLowerCase()],
                            failureSummary: 'Fix any of the following:\n  Element does not have an alt attribute'
                        }]
                    });
                }
            }
        });
        
        return { violations };
    }

    /**
     * Form accessibility testi
     */
    async testFormAccessibility() {
        const forms = document.querySelectorAll('form');
        const violations = [];
        
        forms.forEach((form, formIndex) => {
            const inputs = form.querySelectorAll('input, select, textarea');
            
            inputs.forEach((input, inputIndex) => {
                const id = input.id;
                const label = id ? document.querySelector(`label[for="${id}"]`) : input.closest('label');
                const ariaLabel = input.getAttribute('aria-label');
                const ariaLabelledBy = input.getAttribute('aria-labelledby');
                
                // Label veya aria-label gerekli
                if (!label && !ariaLabel && !ariaLabelledBy) {
                    violations.push({
                        id: `form-label-${formIndex}-${inputIndex}`,
                        impact: 'critical',
                        tags: ['cat.forms', 'wcag2a', 'wcag2aa', 'wcag332'],
                        description: 'Form input missing associated label',
                        help: 'Form inputs must have labels',
                        helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/label',
                        nodes: [{
                            html: input.outerHTML.substring(0, 100),
                            target: [input.tagName.toLowerCase()],
                            failureSummary: 'Fix any of the following:\n  Form element does not have an implicit (wrapped) <label>\n  Form element does not have an explicit <label>'
                        }]
                    });
                }
                
                // Required field'lar için
                if (input.hasAttribute('required') && !input.getAttribute('aria-required')) {
                    violations.push({
                        id: `form-required-${formIndex}-${inputIndex}`,
                        impact: 'moderate',
                        tags: ['cat.forms', 'wcag2a', 'wcag2aa', 'wcag332'],
                        description: 'Required form input missing aria-required',
                        help: 'Required form inputs must have aria-required attribute',
                        helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/aria-required-attr',
                        nodes: [{
                            html: input.outerHTML.substring(0, 100),
                            target: [input.tagName.toLowerCase()]
                        }]
                    });
                }
            });
        });
        
        return { violations };
    }

    /**
     * Link accessibility testi
     */
    async testLinksAccessibility() {
        const links = document.querySelectorAll('a[href]');
        const violations = [];
        
        links.forEach((link, index) => {
            const text = link.textContent.trim();
            const ariaLabel = link.getAttribute('aria-label');
            const ariaLabelledBy = link.getAttribute('aria-labelledby');
            
            // Link text veya aria-label gerekli
            if (!text && !ariaLabel && !ariaLabelledBy) {
                violations.push({
                    id: `link-text-${index}`,
                    impact: 'serious',
                    tags: ['cat.name-role-value', 'wcag2a', 'wcag2aa', 'wcag244'],
                    description: 'Link has no text content',
                    help: 'Links must have discernible text',
                    helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/link-name',
                    nodes: [{
                        html: link.outerHTML.substring(0, 100),
                        target: ['a'],
                        failureSummary: 'Fix any of the following:\n  Element does not have an accessible name'
                    }]
                });
            }
            
            // "Click here" gibi generic text'ler
            const genericTexts = ['click here', 'read more', 'learn more', 'here', 'more'];
            if (genericTexts.includes(text.toLowerCase())) {
                violations.push({
                    id: `link-generic-${index}`,
                    impact: 'moderate',
                    tags: ['cat.name-role-value', 'wcag2a', 'wcag2aa', 'wcag244'],
                    description: 'Link has generic text content',
                    help: 'Links should have descriptive text that conveys purpose',
                    helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/link-name',
                    nodes: [{
                        html: link.outerHTML.substring(0, 100),
                        target: ['a']
                    }]
                });
            }
        });
        
        return { violations };
    }

    /**
     * Heading structure testi
     */
    async testHeadingStructure() {
        const headings = Array.from(document.querySelectorAll('h1, h2, h3, h4, h5, h6'));
        const violations = [];
        
        if (headings.length === 0) {
            violations.push({
                id: 'heading-structure',
                impact: 'serious',
                tags: ['cat.structure', 'wcag2a', 'wcag2aa', 'wcag131'],
                description: 'No heading structure found',
                help: 'Page should contain a level 1 heading',
                helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/page-has-heading-one',
                nodes: [{
                    html: document.body.outerHTML.substring(0, 200),
                    target: ['html > body']
                }]
            });
        } else {
            // H1 kontrolü
            const h1Count = headings.filter(h => h.tagName === 'H1').length;
            if (h1Count === 0) {
                violations.push({
                    id: 'no-h1',
                    impact: 'serious',
                    tags: ['cat.structure', 'wcag2a', 'wcag2aa', 'wcag131'],
                    description: 'Page missing level 1 heading',
                    help: 'Pages should contain at least one level 1 heading',
                    helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/page-has-heading-one',
                    nodes: [{
                        html: document.body.outerHTML.substring(0, 200),
                        target: ['html > body']
                    }]
                });
            }
            
            // Heading sırası kontrolü
            let previousLevel = 0;
            headings.forEach((heading, index) => {
                const level = parseInt(heading.tagName.charAt(1));
                
                // H1'den başlamalı
                if (index === 0 && level !== 1) {
                    violations.push({
                        id: `heading-start-${index}`,
                        impact: 'moderate',
                        tags: ['cat.structure', 'wcag2a', 'wcag2aa', 'wcag131'],
                        description: 'First heading is not level 1',
                        help: 'First heading should be level 1',
                        helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/page-has-heading-one',
                        nodes: [{
                            html: heading.outerHTML.substring(0, 100),
                            target: [heading.tagName.toLowerCase()]
                        }]
                    });
                }
                
                // Seviye atlama kontrolü
                if (level > previousLevel + 1 && previousLevel > 0) {
                    violations.push({
                        id: `heading-skip-${index}`,
                        impact: 'moderate',
                        tags: ['cat.structure', 'wcag2a', 'wcag2aa', 'wcag131'],
                        description: 'Heading level skipped',
                        help: 'Headings should not skip levels',
                        helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/heading-order',
                        nodes: [{
                            html: heading.outerHTML.substring(0, 100),
                            target: [heading.tagName.toLowerCase()]
                        }]
                    });
                }
                
                previousLevel = level;
            });
        }
        
        return { violations };
    }

    /**
     * Keyboard navigation testi
     */
    async testKeyboardNavigation() {
        const interactiveElements = document.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        
        const violations = [];
        
        interactiveElements.forEach((element, index) => {
            // Tabindex kontrolü
            const tabindex = element.getAttribute('tabindex');
            if (tabindex && parseInt(tabindex) > 0) {
                violations.push({
                    id: `tabindex-positive-${index}`,
                    impact: 'serious',
                    tags: ['cat.keyboard', 'wcag2a', 'wcag2aa', 'wcag2.1.1'],
                    description: 'Positive tabindex value',
                    help: 'Avoid using positive tabindex values',
                    helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/tabindex',
                    nodes: [{
                        html: element.outerHTML.substring(0, 100),
                        target: [element.tagName.toLowerCase()]
                    }]
                });
            }
            
            // Button without type
            if (element.tagName === 'BUTTON' && !element.getAttribute('type')) {
                violations.push({
                    id: `button-type-${index}`,
                    impact: 'minor',
                    tags: ['cat.forms', 'wcag2a', 'wcag2aa'],
                    description: 'Button has no type attribute',
                    help: 'Buttons should have a type attribute',
                    helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/button-type',
                    nodes: [{
                        html: element.outerHTML.substring(0, 100),
                        target: ['button']
                    }]
                });
            }
        });
        
        return { violations };
    }

    /**
     * Color contrast testi
     */
    async testColorContrast() {
        if (window.ColorContrastChecker) {
            const results = window.ColorContrastChecker.analyzePageContrast();
            
            const violations = results.issues.map((issue, index) => ({
                id: `color-contrast-${index}`,
                impact: issue.result === 'fail' ? 'serious' : 'minor',
                tags: ['cat.color', 'wcag2a', 'wcag2aa', 'wcag143'],
                description: 'Insufficient color contrast',
                help: 'Elements must have sufficient color contrast',
                helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/color-contrast',
                nodes: [{
                    html: issue.element.outerHTML.substring(0, 100),
                    target: [issue.tagName.toLowerCase()],
                    failureSummary: `Fix any of the following:\n  Element has insufficient color contrast of ${issue.contrastRatio}:1 (foreground color: ${issue.color}, background color: ${issue.backgroundColor})`
                }]
            }));
            
            return { violations };
        }
        
        return { violations: [] };
    }

    /**
     * Focus management testi
     */
    async testFocusManagement() {
        const violations = [];
        
        // Focus indicators kontrolü
        const focusableElements = document.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        
        focusableElements.forEach((element, index) => {
            const styles = getComputedStyle(element);
            const outline = styles.outline;
            const boxShadow = styles.boxShadow;
            
            // Focus indicator yoksa
            if (outline === 'none' && !boxShadow.includes('focus')) {
                // CSS ile focus state'i kontrol et
                const hasFocusStyle = this.hasFocusStyles(element);
                if (!hasFocusStyle) {
                    violations.push({
                        id: `focus-visible-${index}`,
                        impact: 'serious',
                        tags: ['cat.keyboard', 'wcag2a', 'wcag2aa', 'wcag2.4.7'],
                        description: 'Focus indicator missing',
                        help: 'Interactive elements must have visible focus indicators',
                        helpUrl: 'https://dequeuniversity.com/rules/axe/4.8/focus-visible',
                        nodes: [{
                            html: element.outerHTML.substring(0, 100),
                            target: [element.tagName.toLowerCase()]
                        }]
                    });
                }
            }
        });
        
        return { violations };
    }

    /**
     * Focus style kontrolü
     */
    hasFocusStyles(element) {
        try {
            const tempElement = element.cloneNode(true);
            document.body.appendChild(tempElement);
            
            // Focus style'i simulate et
            tempElement.focus();
            
            const styles = getComputedStyle(tempElement);
            const hasOutline = styles.outline !== 'none' && styles.outline !== '0px';
            const hasBoxShadow = styles.boxShadow !== 'none' && !styles.boxShadow.includes('rgba(0, 0, 0, 0)');
            
            document.body.removeChild(tempElement);
            
            return hasOutline || hasBoxShadow;
        } catch (error) {
            return false;
        }
    }

    /**
     * Hedeflenmiş test çalıştır
     */
    async runTargetedTest(type, element) {
        if (this.runningTests.size > 3) return; // Çok fazla test aynı anda çalışmasın
        
        const testId = this.generateTestId();
        this.runningTests.add(testId);
        
        try {
            let results;
            
            if (typeof axe !== 'undefined') {
                results = await axe.run(element, {
                    runOnly: {
                        type: 'tag',
                        values: [this.config.wcagVersion]
                    }
                });
                
                if (results.violations.length > 0) {
                    this.handleRealtimeViolation(type, results.violations[0]);
                }
            }
            
        } catch (error) {
            console.warn(`Targeted test for ${type} failed:`, error);
        } finally {
            this.runningTests.delete(testId);
        }
    }

    /**
     * Real-time violation handling
     */
    handleRealtimeViolation(type, violation) {
        // Inconspicuous notification göster
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 z-50 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded shadow-lg text-sm max-w-sm';
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span>Erişilebilirlik sorunu: ${violation.description}</span>
                <button class="ml-3 text-yellow-600 hover:text-yellow-800" onclick="this.parentElement.parentElement.remove()">
                    ×
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // 5 saniye sonra kaldır
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    /**
     * Test sonuçlarını işle
     */
    processTestResults(results) {
        this.violations = results.violations || [];
        this.incomplete = results.incomplete || [];
        this.inapplicable = results.inapplicable || [];
        
        // Sonuçları kaydet
        this.testResults.set(this.lastRun.getTime(), {
            results,
            summary: this.generateSummary(results)
        });
        
        // UI'yı güncelle
        this.updateResultsUI(results);
        
        // Report kaydet
        if (this.config.saveReports) {
            this.saveReport(results);
        }
    }

    /**
     * Test özeti oluştur
     */
    generateSummary(results) {
        const violations = results.violations || [];
        
        return {
            totalViolations: violations.length,
            criticalCount: violations.filter(v => v.impact === 'critical').length,
            seriousCount: violations.filter(v => v.impact === 'serious').length,
            moderateCount: violations.filter(v => v.impact === 'moderate').length,
            minorCount: violations.filter(v => v.impact === 'minor').length,
            wcagCompliance: this.calculateWCAGCompliance(violations)
        };
    }

    /**
     * WCAG uyumluluğu hesapla
     */
    calculateWCAGCompliance(violations) {
        const totalTests = violations.length;
        const passedTests = totalTests - violations.filter(v => 
            v.tags.includes('wcag2a') || v.tags.includes('wcag2aa')
        ).length;
        
        const compliance = totalTests > 0 ? (passedTests / totalTests) * 100 : 100;
        
        return {
            percentage: Math.round(compliance),
            level: compliance >= 95 ? 'AAA' : (compliance >= 80 ? 'AA' : (compliance >= 60 ? 'A' : 'F'))
        };
    }

    /**
     * Results UI güncelle
     */
    updateResultsUI(results) {
        const resultsContainer = document.getElementById('test-results');
        const summary = this.generateSummary(results);
        
        // Özet kartı
        const summaryCard = this.createSummaryCard(summary);
        resultsContainer.innerHTML = '';
        resultsContainer.appendChild(summaryCard);
        
        // Violations listesi
        if (this.violations.length > 0) {
            const violationsList = this.createViolationsList(this.violations);
            resultsContainer.appendChild(violationsList);
        } else {
            const successMessage = document.createElement('div');
            successMessage.className = 'text-center py-8 text-green-600';
            successMessage.innerHTML = `
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg font-semibold">Tebrikler!</p>
                <p class="text-sm">Hiç erişilebilirlik sorunu bulunamadı.</p>
            `;
            resultsContainer.appendChild(successMessage);
        }
    }

    /**
     * Özet kartı oluştur
     */
    createSummaryCard(summary) {
        const card = document.createElement('div');
        card.className = 'bg-gray-50 dark:bg-gray-700 rounded-lg p-4';
        
        card.innerHTML = `
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Test Özeti</h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Toplam Sorun:</span>
                        <span class="font-semibold">${summary.totalViolations}</span>
                    </div>
                    <div class="flex justify-between text-red-600">
                        <span>Kritik:</span>
                        <span class="font-semibold">${summary.criticalCount}</span>
                    </div>
                    <div class="flex justify-between text-orange-600">
                        <span>Ciddi:</span>
                        <span class="font-semibold">${summary.seriousCount}</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-yellow-600">
                        <span>Orta:</span>
                        <span class="font-semibold">${summary.moderateCount}</span>
                    </div>
                    <div class="flex justify-between text-blue-600">
                        <span>Az:</span>
                        <span class="font-semibold">${summary.minorCount}</span>
                    </div>
                    <div class="flex justify-between text-green-600">
                        <span>WCAG Uyumluluk:</span>
                        <span class="font-semibold">${summary.wcagCompliance.level} (${summary.wcagCompliance.percentage}%)</span>
                    </div>
                </div>
            </div>
        `;
        
        return card;
    }

    /**
     * Violations listesi oluştur
     */
    createViolationsList(violations) {
        const container = document.createElement('div');
        container.className = 'space-y-3';
        
        const title = document.createElement('h4');
        title.className = 'text-lg font-semibold text-gray-900 dark:text-white';
        title.textContent = 'Tespit Edilen Sorunlar';
        container.appendChild(title);
        
        violations.forEach((violation, index) => {
            const violationCard = this.createViolationCard(violation, index);
            container.appendChild(violationCard);
        });
        
        return container;
    }

    /**
     * Violation kartı oluştur
     */
    createViolationCard(violation, index) {
        const card = document.createElement('div');
        card.className = 'border border-gray-200 dark:border-gray-600 rounded-lg p-4 bg-white dark:bg-gray-800';
        
        const impactColor = {
            'critical': 'text-red-600 bg-red-50 dark:bg-red-900/20',
            'serious': 'text-orange-600 bg-orange-50 dark:bg-orange-900/20',
            'moderate': 'text-yellow-600 bg-yellow-50 dark:bg-yellow-900/20',
            'minor': 'text-blue-600 bg-blue-50 dark:bg-blue-900/20'
        }[violation.impact] || 'text-gray-600 bg-gray-50 dark:bg-gray-700';
        
        card.innerHTML = `
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 text-xs font-medium rounded ${impactColor}">
                        ${violation.impact}
                    </span>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                        ${violation.id}
                    </span>
                </div>
                <button class="text-gray-400 hover:text-gray-600" onclick="this.closest('.violation-card').classList.toggle('collapsed')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
            <h5 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                ${violation.description}
            </h5>
            <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">
                ${violation.help}
            </p>
            <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                <strong>Etkilenen Elementler:</strong> ${violation.nodes.length}
            </div>
            <div class="text-xs">
                <strong>WCAG Kuralları:</strong> ${violation.tags.filter(tag => tag.startsWith('wcag')).join(', ')}
            </div>
            <div class="mt-3 flex space-x-2">
                <a href="${violation.helpUrl}" target="_blank" class="text-xs text-blue-600 hover:underline">
                    Daha Fazla Bilgi
                </a>
                <button class="text-xs text-green-600 hover:underline" onclick="window.AccessibilityTester.autoFixViolation('${violation.id}')">
                    Otomatik Düzelt
                </button>
            </div>
        `;
        
        card.classList.add('violation-card');
        return card;
    }

    /**
     * Otomatik violation düzeltme
     */
    async autoFixViolation(violationId) {
        const violation = this.violations.find(v => v.id === violationId);
        if (!violation) return;
        
        let fixedCount = 0;
        
        violation.nodes.forEach(node => {
            try {
                const element = document.querySelector(node.target[0]);
                if (element) {
                    const fixed = this.applyViolationFix(violation, element);
                    if (fixed) fixedCount++;
                }
            } catch (error) {
                console.warn('Auto-fix failed for node:', node, error);
            }
        });
        
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announce(
                `${fixedCount} erişilebilirlik sorunu otomatik olarak düzeltildi`,
                'status_update'
            );
        }
        
        // Düzeltme sonrası test tekrar çalıştır
        setTimeout(() => {
            this.runTargetedTest('auto-fix', null);
        }, 1000);
    }

    /**
     * Violation düzeltmesi uygula
     */
    applyViolationFix(violation, element) {
        try {
            switch (violation.id) {
                case v => v.includes('img-alt-'):
                    if (!element.getAttribute('alt') && !element.getAttribute('aria-label')) {
                        const src = element.getAttribute('src') || '';
                        const filename = src.split('/').pop() || 'image';
                        element.setAttribute('alt', filename.replace(/\.[^/.]+$/, ''));
                    }
                    return true;
                    
                case v => v.includes('form-label-'):
                    const placeholder = element.getAttribute('placeholder');
                    if (placeholder) {
                        element.setAttribute('aria-label', placeholder);
                    }
                    return true;
                    
                case v => v.includes('button-type-'):
                    if (!element.getAttribute('type')) {
                        element.setAttribute('type', 'submit');
                    }
                    return true;
                    
                case v => v.includes('tabindex-positive-'):
                    element.removeAttribute('tabindex');
                    return true;
                    
                default:
                    // Genel focus indicator ekleme
                    if (violation.tags.includes('focus-visible')) {
                        element.style.outline = '2px solid #3b82f6';
                        element.style.outlineOffset = '2px';
                    }
                    return true;
            }
        } catch (error) {
            console.error('Auto-fix error:', error);
            return false;
        }
    }

    /**
     * Progress göster
     */
    showProgress() {
        const container = document.getElementById('accessibility-test-results');
        const progress = document.getElementById('test-progress');
        const results = document.getElementById('test-results');
        
        container.style.display = 'block';
        results.style.display = 'none';
        progress.style.display = 'block';
        
        // Loading animation
        progress.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Test çalışıyor...</span>
            </div>
        `;
    }

    /**
     * Progress gizle
     */
    hideProgress() {
        const progress = document.getElementById('test-progress');
        const results = document.getElementById('test-results');
        
        progress.style.display = 'none';
        results.style.display = 'block';
    }

    /**
     * Test durumu güncelle
     */
    updateTestStatus(status) {
        const statusElement = document.getElementById('test-status');
        if (statusElement) {
            statusElement.textContent = status;
        }
    }

    /**
     * Son test zamanını güncelle
     */
    updateLastTestTime() {
        const timeElement = document.getElementById('last-test-time');
        if (timeElement && this.lastRun) {
            timeElement.textContent = this.lastRun.toLocaleString('tr-TR');
        }
    }

    /**
     * Rapor kaydet
     */
    saveReport(results) {
        const report = {
            timestamp: new Date().toISOString(),
            url: window.location.href,
            userAgent: navigator.userAgent,
            viewport: {
                width: window.innerWidth,
                height: window.innerHeight
            },
            results: results,
            summary: this.generateSummary(results)
        };
        
        // LocalStorage'a kaydet
        const reports = JSON.parse(localStorage.getItem('accessibility_reports') || '[]');
        reports.push(report);
        
        // Son 50 raporu sakla
        if (reports.length > 50) {
            reports.splice(0, reports.length - 50);
        }
        
        localStorage.setItem('accessibility_reports', JSON.stringify(reports));
        
        console.log('Accessibility report saved:', report);
    }

    /**
     * Rapor export et
     */
    exportReport() {
        const reports = JSON.parse(localStorage.getItem('accessibility_reports') || '[]');
        if (reports.length === 0) {
            alert('Export edilecek rapor bulunamadı.');
            return;
        }
        
        const latestReport = reports[reports.length - 1];
        
        let content, filename, mimeType;
        
        switch (this.config.reportFormat) {
            case 'json':
                content = JSON.stringify(latestReport, null, 2);
                filename = `accessibility-report-${new Date().toISOString().split('T')[0]}.json`;
                mimeType = 'application/json';
                break;
                
            case 'html':
                content = this.generateHTMLReport(latestReport);
                filename = `accessibility-report-${new Date().toISOString().split('T')[0]}.html`;
                mimeType = 'text/html';
                break;
                
            case 'csv':
                content = this.generateCSVReport(latestReport);
                filename = `accessibility-report-${new Date().toISOString().split('T')[0]}.csv`;
                mimeType = 'text/csv';
                break;
        }
        
        // Download
        const blob = new Blob([content], { type: mimeType });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    /**
     * HTML rapor oluştur
     */
    generateHTMLReport(report) {
        return `
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erişilebilirlik Test Raporu</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background: #f3f4f6; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin: 20px 0; }
        .summary-card { background: #fff; padding: 15px; border-radius: 6px; border-left: 4px solid #3b82f6; }
        .violation { background: #fff; border: 1px solid #e5e7eb; border-radius: 6px; margin: 10px 0; padding: 15px; }
        .violation.critical { border-left-color: #dc2626; }
        .violation.serious { border-left-color: #ea580c; }
        .violation.moderate { border-left-color: #d97706; }
        .violation.minor { border-left-color: #2563eb; }
        .tag { background: #e5e7eb; padding: 2px 6px; border-radius: 4px; font-size: 12px; margin: 2px; display: inline-block; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Erişilebilirlik Test Raporu</h1>
        <p><strong>Tarih:</strong> ${new Date(report.timestamp).toLocaleString('tr-TR')}</p>
        <p><strong>URL:</strong> ${report.url}</p>
        <p><strong>Tarayıcı:</strong> ${report.userAgent}</p>
    </div>
    
    <div class="summary">
        <div class="summary-card">
            <h3>Toplam Sorun</h3>
            <p style="font-size: 24px; font-weight: bold; color: #dc2626;">${report.summary.totalViolations}</p>
        </div>
        <div class="summary-card">
            <h3>Kritik</h3>
            <p style="font-size: 24px; font-weight: bold; color: #dc2626;">${report.summary.criticalCount}</p>
        </div>
        <div class="summary-card">
            <h3>Ciddi</h3>
            <p style="font-size: 24px; font-weight: bold; color: #ea580c;">${report.summary.seriousCount}</p>
        </div>
        <div class="summary-card">
            <h3>WCAG Uyumluluk</h3>
            <p style="font-size: 24px; font-weight: bold; color: #059669;">${report.summary.wcagCompliance.level}</p>
        </div>
    </div>
    
    ${report.results.violations.map(violation => `
        <div class="violation ${violation.impact}">
            <h3>${violation.description}</h3>
            <p><strong>Etki Seviyesi:</strong> ${violation.impact}</p>
            <p><strong>Açıklama:</strong> ${violation.help}</p>
            <p><strong>Etkilenen Elementler:</strong> ${violation.nodes.length}</p>
            <p><strong>WCAG Kuralları:</strong></p>
            ${violation.tags.filter(tag => tag.startsWith('wcag')).map(tag => `<span class="tag">${tag}</span>`).join('')}
            <p><a href="${violation.helpUrl}" target="_blank">Daha Fazla Bilgi</a></p>
        </div>
    `).join('')}
</body>
</html>`;
    }

    /**
     * CSV rapor oluştur
     */
    generateCSVReport(report) {
        const headers = ['ID', 'Açıklama', 'Etki Seviyesi', 'WCAG Kuralları', 'Etkilenen Elementler', 'Yardım URL'];
        const rows = report.results.violations.map(violation => [
            violation.id,
            `"${violation.description.replace(/"/g, '""')}"`,
            violation.impact,
            `"${violation.tags.filter(tag => tag.startsWith('wcag')).join('; ')}"`,
            violation.nodes.length,
            violation.helpUrl
        ]);
        
        return [headers, ...rows].map(row => row.join(',')).join('\n');
    }

    /**
     * Event binding
     */
    bindEvents() {
        // Control panel events
        const toggleBtn = document.getElementById('toggle-test-panel');
        const resultsPanel = document.getElementById('accessibility-test-results');
        
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                if (resultsPanel.style.display === 'none' || resultsPanel.style.display === '') {
                    this.showTestPanel();
                } else {
                    this.hideTestPanel();
                }
            });
        }
        
        // Results panel events
        const runFullTestBtn = document.getElementById('run-full-test');
        const closeResultsBtn = document.getElementById('close-results');
        const exportReportBtn = document.getElementById('export-report');
        const fixIssuesBtn = document.getElementById('fix-issues');
        
        if (runFullTestBtn) {
            runFullTestBtn.addEventListener('click', () => this.runFullPageTest());
        }
        
        if (closeResultsBtn) {
            closeResultsBtn.addEventListener('click', () => this.hideTestPanel());
        }
        
        if (exportReportBtn) {
            exportReportBtn.addEventListener('click', () => this.exportReport());
        }
        
        if (fixIssuesBtn) {
            fixIssuesBtn.addEventListener('click', () => this.autoFixAllIssues());
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', (event) => {
            if (event.ctrlKey && event.shiftKey && event.key === 'A') {
                event.preventDefault();
                this.showTestPanel();
                this.runFullPageTest();
            }
        });
    }

    /**
     * Test paneli göster
     */
    showTestPanel() {
        const panel = document.getElementById('accessibility-test-results');
        panel.style.display = 'block';
        
        if (this.lastRun) {
            this.updateResultsUI(this.testResults.get(this.lastRun.getTime()).results);
        }
    }

    /**
     * Test paneli gizle
     */
    hideTestPanel() {
        const panel = document.getElementById('accessibility-test-results');
        panel.style.display = 'none';
    }

    /**
     * Tüm sorunları otomatik düzelt
     */
    async autoFixAllIssues() {
        let fixedCount = 0;
        
        for (const violation of this.violations) {
            for (const node of violation.nodes) {
                try {
                    const element = document.querySelector(node.target[0]);
                    if (element) {
                        const fixed = this.applyViolationFix(violation, element);
                        if (fixed) fixedCount++;
                    }
                } catch (error) {
                    console.warn('Auto-fix failed for node:', node, error);
                }
            }
        }
        
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announce(
                `${fixedCount} erişilebilirlik sorunu otomatik olarak düzeltildi`,
                'status_update'
            );
        }
        
        // Test tekrar çalıştır
        setTimeout(() => {
            this.runFullPageTest();
        }, 1000);
    }

    /**
     * Scheduled test çalıştır
     */
    runScheduledTest() {
        // Sadece idle zamanlarda çalıştır
        if (window.requestIdleCallback) {
            requestIdleCallback(() => {
                this.runFullPageTest();
            }, { timeout: 10000 });
        } else {
            setTimeout(() => {
                this.runFullPageTest();
            }, 1000);
        }
    }

    /**
     * Real-time test planla
     */
    scheduleRealtimeTest(element) {
        if (this.runningTests.size > 5) return;
        
        setTimeout(() => {
            const elementType = this.getElementType(element);
            this.runTargetedTest(elementType, element);
        }, Math.random() * 2000 + 500); // 0.5-2.5 saniye random delay
    }

    /**
     * Element tipini belirle
     */
    getElementType(element) {
        if (element.tagName === 'FORM') return 'form';
        if (element.classList.contains('modal') || element.getAttribute('role') === 'dialog') return 'modal';
        if (element.tagName === 'IMG') return 'image';
        if (element.tagName === 'NAV') return 'navigation';
        if (element.matches('button, [role="button"]')) return 'button';
        return 'element';
    }

    /**
     * Test ID oluştur
     */
    generateTestId() {
        return 'test_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    /**
     * Reset method
     */
    reset() {
        this.testResults.clear();
        this.violations = [];
        this.incomplete = [];
        this.inapplicable = [];
        this.runningTests.clear();
        this.lastRun = null;
        
        // Cleanup UI
        this.hideTestPanel();
    }

    /**
     * Status get
     */
    getStatus() {
        return {
            isRunning: this.runningTests.size > 0,
            lastRun: this.lastRun,
            totalTests: this.testResults.size,
            latestViolations: this.violations.length,
            wcagLevel: this.config.wcagVersion
        };
    }
}

// Global instance
window.AccessibilityTester = new AccessibilityTester();

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AccessibilityTester;
}