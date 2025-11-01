/**
 * AccessibleFinancialData Component - Finansal Veriler için Erişilebilir Bileşen
 * 
 * Kripto para fiyatları, forex oranları ve finansal verilerin
 * screen reader ve klavye kullanıcıları için erişilebilir sunumu
 * Gerçek zamanlı güncellemeler ve anlık bildirimler
 */

class AccessibleFinancialData {
    constructor(options = {}) {
        this.config = {
            locale: 'tr',
            currency: 'USD',
            updateInterval: 30000,
            priceFormat: 'standard',
            showPercentageChange: true,
            announceChanges: true,
            ...options
        };
        
        this.data = new Map();
        this.updateQueue = [];
        this.isProcessing = false;
        this.lastAnnouncement = null;
        this.changeThresholds = {
            significant: 5, // %5 üzerindeki değişimler önemli
            major: 10       // %10 üzerindeki değişimler çok önemli
        };
        
        this.init();
    }

    /**
     * Bileşeni başlat
     */
    init() {
        this.setupUpdateInterval();
        this.bindEvents();
        this.createAriaUpdates();
        
        console.log('AccessibleFinancialData initialized');
    }

    /**
     * Finansal veri güncelle
     */
    updateData(dataArray, type = 'crypto') {
        dataArray.forEach(data => {
            const oldData = this.data.get(data.symbol);
            const updatedData = {
                ...data,
                lastUpdated: new Date(),
                type: type
            };
            
            this.data.set(data.symbol, updatedData);
            
            // Değişiklik kontrolü ve announcement
            if (oldData && this.config.announceChanges) {
                this.checkAndAnnounceChange(oldData, updatedData);
            }
            
            // Güncellenmiş veriyi DOM'a yansıt
            this.updateDOM(data.symbol, updatedData);
        });
        
        this.queueUpdate();
    }

    /**
     * Değişiklik kontrolü ve announcement
     */
    checkAndAnnounceChange(oldData, newData) {
        const priceChange = ((newData.price - oldData.price) / oldData.price) * 100;
        
        // %1'den fazla değişim varsa announcement yap
        if (Math.abs(priceChange) > 1) {
            const isIncrease = priceChange > 0;
            const changeType = Math.abs(priceChange) > this.changeThresholds.major ? 'major' : 
                             (Math.abs(priceChange) > this.changeThresholds.significant ? 'significant' : 'minor');
            
            const announcement = this.createChangeAnnouncement(
                newData.symbol, 
                oldData.price, 
                newData.price, 
                priceChange, 
                isIncrease, 
                changeType
            );
            
            this.announceDataChange(announcement);
        }
    }

    /**
     * Değişiklik announcement'ı oluştur
     */
    createChangeAnnouncement(symbol, oldPrice, newPrice, percentageChange, isIncrease, changeType) {
        const locale = this.config.locale;
        const direction = isIncrease ? 'arttı' : 'azaldı';
        const changeWord = changeType === 'major' ? 'önemli' : (changeType === 'significant' ? 'belirgin' : 'küçük');
        
        if (locale === 'tr') {
            return `${symbol} fiyatı önemli bir değişiklik gösterdi. ${oldPrice} değerinden ${newPrice} değerine ${direction} (%${Math.abs(percentageChange).toFixed(2)}) - ${changeWord} piyasa hareketi`;
        } else {
            const directionEn = isIncrease ? 'increased to' : 'decreased to';
            return `${symbol} showed significant price movement. ${directionEn} ${newPrice} from ${oldPrice} (${Math.abs(percentageChange).toFixed(2)}%) - ${changeType} market movement`;
        }
    }

    /**
     * Veri değişikliğini duyur
     */
    announceDataChange(announcement) {
        // Spam önleme
        if (this.lastAnnouncement === announcement) return;
        this.lastAnnouncement = announcement;
        
        // LiveAnnouncer kullan
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announce(announcement, 'price_update', 'financial-announcements');
        }
        
        // Custom event emit et
        document.dispatchEvent(new CustomEvent('financial-data-change', {
            detail: { announcement, timestamp: Date.now() }
        }));
    }

    /**
     * Live price ticker oluştur
     */
    createLiveTicker(containerId, data, options = {}) {
        const container = document.getElementById(containerId);
        if (!container) return null;
        
        const tickerOptions = {
            showPercentage: true,
            showVolume: false,
            colorCoding: true,
            animationDuration: 500,
            ...options
        };
        
        container.innerHTML = '';
        
        data.forEach(item => {
            const tickerItem = this.createTickerItem(item, tickerOptions);
            container.appendChild(tickerItem);
        });
        
        // Auto-scroll animasyonu ekle
        this.addTickerAnimation(container);
        
        return container;
    }

    /**
     * Ticker item oluştur
     */
    createTickerItem(data, options) {
        const item = document.createElement('div');
        item.className = 'ticker-item flex items-center space-x-2';
        item.setAttribute('data-symbol', data.symbol);
        item.setAttribute('role', 'article');
        item.setAttribute('aria-label', `${data.symbol} fiyat bilgisi`);
        
        // Fiyat değişimine göre renk kodlama
        const priceChangeClass = data.changePercent >= 0 ? 'text-green-600' : 'text-red-600';
        const trendIcon = data.changePercent >= 0 ? '↗' : '↘';
        
        item.innerHTML = `
            <div class="flex items-center space-x-2">
                <span class="font-semibold text-gray-900 dark:text-white">${data.symbol}</span>
                <span class="font-mono text-gray-800 dark:text-gray-200">$${this.formatPrice(data.price)}</span>
                ${options.showPercentage ? `
                    <span class="${priceChangeClass} font-mono text-sm">
                        ${trendIcon} ${Math.abs(data.changePercent).toFixed(2)}%
                    </span>
                ` : ''}
                ${options.showVolume && data.volume ? `
                    <span class="text-gray-500 text-xs">Vol: ${this.formatVolume(data.volume)}</span>
                ` : ''}
            </div>
        `;
        
        // Click event ekle
        item.addEventListener('click', () => {
            this.handleTickerItemClick(data);
        });
        
        // Klavye erişimi
        item.setAttribute('tabindex', '0');
        item.setAttribute('role', 'button');
        item.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                this.handleTickerItemClick(data);
            }
        });
        
        return item;
    }

    /**
     * Erişilebilir finansal tablo oluştur
     */
    createAccessibleTable(containerId, data, options = {}) {
        const container = document.getElementById(containerId);
        if (!container) return null;
        
        const tableOptions = {
            sortable: true,
            filterable: true,
            pagination: true,
            rowsPerPage: 10,
            showRowNumbers: true,
            announceSort: true,
            ...options
        };
        
        const table = document.createElement('table');
        table.className = 'w-full accessible-financial-table';
        table.setAttribute('role', 'table');
        table.setAttribute('aria-label', 'Finansal veriler tablosu');
        
        // Tablo başlığı
        const thead = this.createTableHeader(data, tableOptions);
        table.appendChild(thead);
        
        // Tablo gövdesi
        const tbody = this.createTableBody(data, tableOptions);
        table.appendChild(tbody);
        
        // Sayfalama ekle
        if (tableOptions.pagination) {
            const pagination = this.createPagination(data, tableOptions);
            container.appendChild(table);
            container.appendChild(pagination);
        } else {
            container.appendChild(table);
        }
        
        // Filtreleme ekle
        if (tableOptions.filterable) {
            const filter = this.createTableFilter(containerId);
            container.insertBefore(filter, table);
        }
        
        // Sıralama event listeners
        if (tableOptions.sortable) {
            this.bindTableSorting(table, data);
        }
        
        return table;
    }

    /**
     * Tablo başlığı oluştur
     */
    createTableHeader(data, options) {
        const thead = document.createElement('thead');
        const headers = Object.keys(data[0]).filter(key => key !== 'lastUpdated');
        
        const headerRow = document.createElement('tr');
        headerRow.setAttribute('role', 'row');
        
        // Satır numarası kolonu
        if (options.showRowNumbers) {
            const th = document.createElement('th');
            th.textContent = '#';
            th.setAttribute('role', 'columnheader');
            th.setAttribute('aria-sort', 'none');
            headerRow.appendChild(th);
        }
        
        headers.forEach(header => {
            const th = document.createElement('th');
            th.textContent = this.getColumnName(header);
            th.setAttribute('role', 'columnheader');
            th.setAttribute('data-column', header);
            th.setAttribute('aria-sort', 'none');
            
            if (options.sortable) {
                th.style.cursor = 'pointer';
                th.setAttribute('tabindex', '0');
                th.setAttribute('role', 'button');
                th.setAttribute('aria-label', `${this.getColumnName(header)} kolonuna göre sırala`);
            }
            
            headerRow.appendChild(th);
        });
        
        thead.appendChild(headerRow);
        return thead;
    }

    /**
     * Tablo gövdesi oluştur
     */
    createTableBody(data, options) {
        const tbody = document.createElement('tbody');
        const currentPageData = this.getCurrentPageData(data, options);
        
        currentPageData.forEach((row, index) => {
            const tr = document.createElement('tr');
            tr.setAttribute('role', 'row');
            tr.setAttribute('aria-rowindex', (index + 1).toString());
            
            // Satır numarası
            if (options.showRowNumbers) {
                const td = document.createElement('td');
                td.textContent = (index + 1).toString();
                td.setAttribute('role', 'cell');
                td.className = 'text-gray-500';
                tr.appendChild(td);
            }
            
            Object.entries(row).forEach(([key, value]) => {
                if (key === 'lastUpdated') return;
                
                const td = document.createElement('td');
                td.setAttribute('role', 'cell');
                td.setAttribute('data-column', key);
                
                // Özel format uygula
                td.textContent = this.formatCellValue(key, value, row);
                
                tr.appendChild(td);
            });
            
            tbody.appendChild(tr);
        });
        
        return tbody;
    }

    /**
     * Tablo filtresi oluştur
     */
    createTableFilter(tableContainerId) {
        const filter = document.createElement('div');
        filter.className = 'table-filter mb-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg';
        filter.setAttribute('role', 'search');
        
        filter.innerHTML = `
            <label for="table-filter-${tableContainerId}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Tabloyu filtrele:
            </label>
            <input 
                type="text" 
                id="table-filter-${tableContainerId}"
                class="form-input w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                placeholder="Sembol, fiyat veya değişim miktarı girin..."
                aria-describedby="filter-help-${tableContainerId}"
            >
            <div id="filter-help-${tableContainerId}" class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Enter ile filtreleme yapılır. Tüm satırlar eşleştirilir.
            </div>
        `;
        
        // Filtreleme event listener
        const input = filter.querySelector('input');
        input.addEventListener('input', (event) => {
            this.filterTable(tableContainerId, event.target.value);
        });
        
        input.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                this.filterTable(tableContainerId, event.target.value);
            }
        });
        
        return filter;
    }

    /**
     * Tablo filtreleme
     */
    filterTable(tableContainerId, filterText) {
        const table = document.getElementById(tableContainerId).querySelector('table');
        const rows = table.querySelectorAll('tbody tr');
        const searchTerm = filterText.toLowerCase();
        
        let visibleCount = 0;
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const isVisible = text.includes(searchTerm);
            
            row.style.display = isVisible ? '' : 'none';
            if (isVisible) visibleCount++;
        });
        
        // Filtreleme sonucunu duyur
        const announcement = visibleCount > 0 
            ? `${visibleCount} sonuç bulundu`
            : 'Filtreleme sonuçları bulunamadı';
            
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announce(announcement, 'status_update');
        }
        
        // Mevcut sayfa bilgisini güncelle
        this.updatePaginationInfo(tableContainerId, visibleCount);
    }

    /**
     * Erişilebilir grafik container'ı oluştur
     */
    createAccessibleChart(containerId, chartData, chartType = 'line') {
        const container = document.getElementById(containerId);
        if (!container) return null;
        
        const chartWrapper = document.createElement('div');
        chartWrapper.className = 'accessible-chart-wrapper';
        chartWrapper.setAttribute('role', 'img');
        chartWrapper.setAttribute('aria-labelledby', `${containerId}-title`);
        chartWrapper.setAttribute('aria-describedby', `${containerId}-description`);
        
        // Grafik başlığı ve açıklama
        const title = document.createElement('h3');
        title.id = `${containerId}-title`;
        title.className = 'sr-only';
        title.textContent = 'Fiyat Grafiği';
        
        const description = document.createElement('div');
        description.id = `${containerId}-description`;
        description.className = 'sr-only';
        description.innerHTML = this.generateChartDescription(chartData);
        
        // Canvas container
        const canvasContainer = document.createElement('div');
        canvasContainer.id = `${containerId}-canvas`;
        canvasContainer.className = 'chart-container';
        
        // Data table (screen reader'lar için)
        const dataTable = this.createChartDataTable(chartData);
        
        chartWrapper.appendChild(title);
        chartWrapper.appendChild(description);
        chartWrapper.appendChild(canvasContainer);
        chartWrapper.appendChild(dataTable);
        
        container.appendChild(chartWrapper);
        
        return chartWrapper;
    }

    /**
     * Grafik açıklaması oluştur
     */
    generateChartDescription(data) {
        if (!data || data.length === 0) {
            return 'Grafik verisi bulunamadı.';
        }
        
        const first = data[0];
        const last = data[data.length - 1];
        const change = ((last.value - first.value) / first.value * 100).toFixed(2);
        const trend = change > 0 ? 'artış' : (change < 0 ? 'azalış' : 'stabil');
        
        return `Grafik ${data.length} veri noktası gösteriyor. İlk değer: ${first.value}, Son değer: ${last.value}. Genel trend: ${trend} (%${Math.abs(change)}).`;
    }

    /**
     * Grafik veri tablosu oluştur
     */
    createChartDataTable(data) {
        const table = document.createElement('table');
        table.className = 'sr-only';
        table.setAttribute('aria-label', 'Grafik veri tablosu');
        
        const thead = document.createElement('thead');
        const tr = document.createElement('tr');
        
        ['Tarih', 'Değer'].forEach(header => {
            const th = document.createElement('th');
            th.textContent = header;
            tr.appendChild(th);
        });
        
        thead.appendChild(tr);
        table.appendChild(thead);
        
        const tbody = document.createElement('tbody');
        data.slice(-10).forEach(item => { // Son 10 veri noktası
            const tr = document.createElement('tr');
            const td1 = document.createElement('td');
            const td2 = document.createElement('td');
            
            td1.textContent = item.date || '';
            td2.textContent = item.value;
            
            tr.appendChild(td1);
            tr.appendChild(td2);
            tbody.appendChild(tr);
        });
        
        table.appendChild(tbody);
        return table;
    }

    /**
     * Ticker item click handler
     */
    handleTickerItemClick(data) {
        // Custom event emit et
        document.dispatchEvent(new CustomEvent('financial-item-selected', {
            detail: { data, timestamp: Date.now() }
        }));
        
        // Accessibility announcement
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announce(
                `${data.symbol} seçildi. Fiyat: $${this.formatPrice(data.price)}`,
                'status_update'
            );
        }
    }

    /**
     * DOM güncelleme
     */
    updateDOM(symbol, data) {
        // Ticker item'ı güncelle
        const tickerItems = document.querySelectorAll(`[data-symbol="${symbol}"]`);
        tickerItems.forEach(item => {
            const priceEl = item.querySelector('.font-mono');
            if (priceEl) {
                priceEl.textContent = `$${this.formatPrice(data.price)}`;
            }
            
            // Fiyat değişim rengi
            const changeEl = item.querySelector('.text-green-600, .text-red-600');
            if (changeEl) {
                changeEl.className = data.changePercent >= 0 ? 
                    'text-green-600 font-mono text-sm' : 'text-red-600 font-mono text-sm';
            }
        });
        
        // Tablo satırlarını güncelle
        this.updateTableRows(symbol, data);
    }

    /**
     * Tablo satırlarını güncelle
     */
    updateTableRows(symbol, data) {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            if (row.getAttribute('data-symbol') === symbol) {
                Object.entries(data).forEach(([key, value]) => {
                    if (key === 'lastUpdated' || key === 'symbol') return;
                    
                    const cell = row.querySelector(`[data-column="${key}"]`);
                    if (cell) {
                        cell.textContent = this.formatCellValue(key, value, data);
                    }
                });
            }
        });
    }

    /**
     * Cell değerini formatla
     */
    formatCellValue(key, value, row) {
        switch (key) {
            case 'price':
                return `$${this.formatPrice(value)}`;
            case 'changePercent':
                const sign = value >= 0 ? '+' : '';
                return `${sign}${value.toFixed(2)}%`;
            case 'volume':
                return this.formatVolume(value);
            case 'marketCap':
                return this.formatMarketCap(value);
            default:
                return value;
        }
    }

    /**
     * Fiyat formatı
     */
    formatPrice(price) {
        if (price < 1) {
            return price.toFixed(6);
        } else if (price < 100) {
            return price.toFixed(4);
        } else {
            return price.toFixed(2);
        }
    }

    /**
     * Volume formatı
     */
    formatVolume(volume) {
        if (volume >= 1e9) {
            return `${(volume / 1e9).toFixed(2)}B`;
        } else if (volume >= 1e6) {
            return `${(volume / 1e6).toFixed(2)}M`;
        } else if (volume >= 1e3) {
            return `${(volume / 1e3).toFixed(2)}K`;
        } else {
            return volume.toFixed(0);
        }
    }

    /**
     * Market cap formatı
     */
    formatMarketCap(marketCap) {
        return this.formatVolume(marketCap);
    }

    /**
     * Kolon adı al
     */
    getColumnName(key) {
        const names = {
            symbol: 'Sembol',
            price: 'Fiyat',
            change: 'Değişim',
            changePercent: 'Değişim %',
            volume: 'Hacim',
            marketCap: 'Piyasa Değeri',
            high24h: '24s Yüksek',
            low24h: '24s Düşük'
        };
        
        return names[key] || key;
    }

    /**
     * Tablo sıralama
     */
    bindTableSorting(table, data) {
        const headers = table.querySelectorAll('[role="columnheader"]');
        headers.forEach(header => {
            header.addEventListener('click', () => {
                this.sortTable(table, header.dataset.column);
            });
            
            header.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    this.sortTable(table, header.dataset.column);
                }
            });
        });
    }

    /**
     * Tablo sıralama
     */
    sortTable(table, column) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        // Mevcut sıralama yönünü kontrol et
        const currentSort = table.querySelector('[aria-sort="ascending"]');
        const isAscending = !currentSort || currentSort.dataset.column !== column;
        
        // Tüm headers'ların sort durumunu sıfırla
        table.querySelectorAll('[role="columnheader"]').forEach(th => {
            th.setAttribute('aria-sort', 'none');
        });
        
        // Seçilen header'ı güncelle
        const currentHeader = table.querySelector(`[data-column="${column}"]`);
        currentHeader.setAttribute('aria-sort', isAscending ? 'ascending' : 'descending');
        
        // Sıralama
        rows.sort((a, b) => {
            const aVal = a.querySelector(`[data-column="${column}"]`).textContent;
            const bVal = b.querySelector(`[data-column="${column}"]`).textContent;
            
            let comparison = 0;
            if (!isNaN(aVal) && !isNaN(bVal)) {
                comparison = parseFloat(aVal) - parseFloat(bVal);
            } else {
                comparison = aVal.localeCompare(bVal);
            }
            
            return isAscending ? comparison : -comparison;
        });
        
        // DOM'u güncelle
        rows.forEach(row => tbody.appendChild(row));
        
        // Sıralama announcement'ı
        const announcement = isAscending ? 
            `${this.getColumnName(column)} kolonuna göre artan sırada sıralandı` :
            `${this.getColumnName(column)} kolonuna göre azalan sırada sıralandı`;
            
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announce(announcement, 'status_update');
        }
    }

    /**
     * Sayfalama bilgisi güncelleme
     */
    updatePaginationInfo(tableContainerId, visibleRows) {
        const pagination = document.getElementById(tableContainerId).querySelector('.pagination-info');
        if (pagination) {
            pagination.textContent = `${visibleRows} sonuç gösteriliyor`;
        }
    }

    /**
     * Güncelleme kuyruğu
     */
    queueUpdate() {
        if (!this.isProcessing) {
            this.processUpdateQueue();
        }
    }

    /**
     * Update kuyruğunu işle
     */
    async processUpdateQueue() {
        this.isProcessing = true;
        
        while (this.updateQueue.length > 0) {
            const update = this.updateQueue.shift();
            await this.processUpdate(update);
        }
        
        this.isProcessing = false;
    }

    /**
     * Tek bir güncellemeyi işle
     */
    async processUpdate(update) {
        // DOM güncellemeleri
        this.updateDOM(update.symbol, update.data);
        
        // Wait for smooth animation
        await new Promise(resolve => setTimeout(resolve, 50));
    }

    /**
     * Event binding
     */
    bindEvents() {
        // Livewire events
        if (window.Livewire) {
            Livewire.on('financial-data-update', (data) => {
                this.updateData(data.data, data.type);
            });
            
            Livewire.on('price-alert', (data) => {
                this.handlePriceAlert(data);
            });
        }
        
        // Custom events
        document.addEventListener('request-financial-data', (event) => {
            this.handleDataRequest(event.detail);
        });
    }

    /**
     * Price alert handler
     */
    handlePriceAlert(alertData) {
        const announcement = this.config.locale === 'tr' ?
            `${alertData.symbol} için fiyat uyarısı: ${alertData.message}` :
            `Price alert for ${alertData.symbol}: ${alertData.message}`;
            
        if (window.LiveAnnouncer) {
            window.LiveAnnouncer.announce(announcement, 'status_update', 'financial-announcements');
        }
    }

    /**
     * Data request handler
     */
    handleDataRequest(request) {
        const data = this.getDataForSymbol(request.symbol);
        if (data) {
            document.dispatchEvent(new CustomEvent('financial-data-response', {
                detail: { symbol: request.symbol, data }
            }));
        }
    }

    /**
     * Sembol için veri al
     */
    getDataForSymbol(symbol) {
        return this.data.get(symbol);
    }

    /**
     * Tüm verileri al
     */
    getAllData() {
        return Object.fromEntries(this.data);
    }

    /**
     * Setup update interval
     */
    setupUpdateInterval() {
        setInterval(() => {
            this.checkDataFreshness();
        }, this.config.updateInterval);
    }

    /**
     * Veri tazeliğini kontrol et
     */
    checkDataFreshness() {
        const now = new Date();
        this.data.forEach((data, symbol) => {
            const age = (now - data.lastUpdated) / 1000;
            if (age > 300) { // 5 dakikadan eski
                console.warn(`Stale data for ${symbol}: ${age} seconds old`);
                this.markDataAsStale(symbol);
            }
        });
    }

    /**
     * Veriyi eski olarak işaretle
     */
    markDataAsStale(symbol) {
        const element = document.querySelector(`[data-symbol="${symbol}"]`);
        if (element) {
            element.classList.add('stale-data');
            element.setAttribute('aria-label', `${symbol} veriler güncel değil`);
        }
    }

    /**
     * Aria updates container oluştur
     */
    createAriaUpdates() {
        const container = document.createElement('div');
        container.id = 'financial-aria-updates';
        container.className = 'sr-only';
        container.setAttribute('aria-live', 'polite');
        container.setAttribute('aria-label', 'Finansal veri güncellemeleri');
        
        document.body.appendChild(container);
    }

    /**
     * Ticker animasyonu ekle
     */
    addTickerAnimation(container) {
        container.classList.add('ticker-scroll');
        const style = document.createElement('style');
        style.textContent = `
            .ticker-scroll {
                animation: ticker-scroll 30s linear infinite;
            }
            @keyframes ticker-scroll {
                0% { transform: translateX(100%); }
                100% { transform: translateX(-100%); }
            }
            .stale-data {
                opacity: 0.6;
                filter: grayscale(50%);
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Mevcut sayfa verisini al
     */
    getCurrentPageData(data, options) {
        return data.slice(0, options.rowsPerPage);
    }

    /**
     * Sayfalama oluştur
     */
    createPagination(data, options) {
        // Pagination implementation would go here
        return document.createElement('div');
    }

    /**
     * Component'i sıfırla
     */
    reset() {
        this.data.clear();
        this.updateQueue = [];
        this.lastAnnouncement = null;
        
        // DOM'u temizle
        document.querySelectorAll('[data-symbol]').forEach(el => {
            el.remove();
        });
    }

    /**
     * Durum bilgilerini al
     */
    getStatus() {
        return {
            dataCount: this.data.size,
            updateQueueLength: this.updateQueue.length,
            isProcessing: this.isProcessing,
            lastAnnouncement: this.lastAnnouncement
        };
    }
}

// Global instance
window.AccessibleFinancialData = AccessibleFinancialData;

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AccessibleFinancialData;
}