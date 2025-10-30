/**
 * Dashboard Module - Modern Interactive Dashboard
 * Real-time data updates, charts, and analytics
 */

import { CSRFManager } from '../utils/csrf-manager.js';
import { NotificationManager } from '../utils/notification-manager.js';

/**
 * Dashboard Module Main Class
 */
class DashboardModule {
    constructor() {
        this.initialized = false;
        this.container = null;
        this.eventListeners = [];
        this.updateInterval = null;
        this.charts = new Map();
        
        // State management
        this.state = {
            loading: false,
            data: {
                stats: {},
                charts: {},
                recentActivities: [],
                notifications: []
            },
            config: {
                autoRefresh: true,
                refreshInterval: 30000, // 30 seconds
                theme: 'light'
            }
        };
    }

    /**
     * Initialize the dashboard module
     */
    async init() {
        if (this.initialized) return;

        this.container = document.querySelector('[data-dashboard]');
        if (!this.container) {
            console.log('Dashboard container not found, skipping initialization');
            return;
        }

        console.log('📊 Dashboard Module initializing...');

        try {
            await this.loadInitialData();
            this.setupEventListeners();
            this.setupCharts();
            this.setupRealTimeUpdates();
            this.setupWidgets();
            
            this.initialized = true;
            console.log('✅ Dashboard Module initialized successfully');
            
        } catch (error) {
            console.error('❌ Dashboard Module initialization failed:', error);
            NotificationManager.error('Dashboard başlatılamadı');
        }
    }

    /**
     * Load initial dashboard data
     */
    async loadInitialData() {
        this.setState({ loading: true });

        try {
            const response = await CSRFManager.get('/admin/dashboard/data');
            const data = await response.json();

            if (data.success) {
                this.setState({
                    data: data.data,
                    loading: false
                });
                this.renderStats();
                this.renderActivities();
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error loading dashboard data:', error);
            this.setState({ loading: false });
            NotificationManager.error('Dashboard verileri yüklenemedi');
        }
    }

    /**
     * Setup event listeners
     */
    setupEventListeners() {
        // Refresh button
        const refreshBtn = this.container.querySelector('[data-refresh-dashboard]');
        if (refreshBtn) {
            const handler = () => this.refreshData();
            refreshBtn.addEventListener('click', handler);
            this.addEventListenerTracker(refreshBtn, 'click', handler);
        }

        // Theme toggle
        const themeToggle = this.container.querySelector('[data-theme-toggle]');
        if (themeToggle) {
            const handler = () => this.toggleTheme();
            themeToggle.addEventListener('click', handler);
            this.addEventListenerTracker(themeToggle, 'click', handler);
        }

        // Auto-refresh toggle
        const autoRefreshToggle = this.container.querySelector('[data-auto-refresh-toggle]');
        if (autoRefreshToggle) {
            const handler = () => this.toggleAutoRefresh();
            autoRefreshToggle.addEventListener('click', handler);
            this.addEventListenerTracker(autoRefreshToggle, 'click', handler);
        }

        // Quick action buttons
        const quickActions = this.container.querySelectorAll('[data-quick-action]');
        quickActions.forEach(btn => {
            const handler = () => this.handleQuickAction(btn.dataset.quickAction);
            btn.addEventListener('click', handler);
            this.addEventListenerTracker(btn, 'click', handler);
        });

        // Date range selector
        const dateRangeSelectors = this.container.querySelectorAll('[data-date-range]');
        dateRangeSelectors.forEach(selector => {
            const handler = (e) => this.changeDateRange(e.target.value);
            selector.addEventListener('change', handler);
            this.addEventListenerTracker(selector, 'change', handler);
        });
    }

    /**
     * Setup charts using Chart.js or similar
     */
    setupCharts() {
        const chartContainers = this.container.querySelectorAll('[data-chart]');
        
        chartContainers.forEach(container => {
            const chartType = container.dataset.chart;
            const chartData = this.state.data.charts[chartType];
            
            if (chartData) {
                this.createChart(container, chartType, chartData);
            }
        });
    }

    /**
     * Create individual chart
     */
    createChart(container, type, data) {
        if (!window.Chart) {
            console.warn('Chart.js not available');
            return;
        }

        const canvas = container.querySelector('canvas') || this.createCanvas(container);
        const ctx = canvas.getContext('2d');

        const chartConfig = this.getChartConfig(type, data);
        const chart = new window.Chart(ctx, chartConfig);
        
        this.charts.set(type, chart);
    }

    /**
     * Get chart configuration based on type
     */
    getChartConfig(type, data) {
        const baseConfig = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            }
        };

        switch (type) {
            case 'revenue':
                return {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Gelir',
                            data: data.values,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        ...baseConfig,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('tr-TR', {
                                            style: 'currency',
                                            currency: 'TRY'
                                        }).format(value);
                                    }
                                }
                            }
                        }
                    }
                };

            case 'users':
                return {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.values,
                            backgroundColor: [
                                '#3b82f6',
                                '#10b981',
                                '#f59e0b',
                                '#ef4444',
                                '#8b5cf6'
                            ]
                        }]
                    },
                    options: baseConfig
                };

            case 'activity':
                return {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Aktivite',
                            data: data.values,
                            backgroundColor: 'rgba(16, 185, 129, 0.8)',
                            borderColor: 'rgb(16, 185, 129)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        ...baseConfig,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

            default:
                return {
                    type: 'line',
                    data: data,
                    options: baseConfig
                };
        }
    }

    /**
     * Setup real-time updates
     */
    setupRealTimeUpdates() {
        if (this.state.config.autoRefresh) {
            this.startAutoRefresh();
        }

        // Setup WebSocket connection if available
        if (window.WebSocket && window.Echo) {
            this.setupWebSocketUpdates();
        }
    }

    /**
     * Start auto-refresh timer
     */
    startAutoRefresh() {
        this.stopAutoRefresh();
        
        this.updateInterval = setInterval(() => {
            this.refreshData();
        }, this.state.config.refreshInterval);
    }

    /**
     * Stop auto-refresh timer
     */
    stopAutoRefresh() {
        if (this.updateInterval) {
            clearInterval(this.updateInterval);
            this.updateInterval = null;
        }
    }

    /**
     * Setup WebSocket updates
     */
    setupWebSocketUpdates() {
        if (window.Echo) {
            // Listen for dashboard updates
            window.Echo.channel('dashboard')
                .listen('DashboardUpdated', (e) => {
                    this.handleRealTimeUpdate(e);
                });

            // Listen for user activities
            window.Echo.channel('activities')
                .listen('ActivityCreated', (e) => {
                    this.handleActivityUpdate(e);
                });
        }
    }

    /**
     * Handle real-time updates
     */
    handleRealTimeUpdate(data) {
        if (data.type === 'stats') {
            this.updateStats(data.data);
        } else if (data.type === 'chart') {
            this.updateChart(data.chartType, data.data);
        }
    }

    /**
     * Handle activity updates
     */
    handleActivityUpdate(activity) {
        this.state.data.recentActivities.unshift(activity);
        
        // Keep only last 10 activities
        if (this.state.data.recentActivities.length > 10) {
            this.state.data.recentActivities.pop();
        }
        
        this.renderActivities();
        
        // Show toast notification for important activities
        if (activity.importance === 'high') {
            NotificationManager.info(activity.message);
        }
    }

    /**
     * Setup interactive widgets
     */
    setupWidgets() {
        // Setup draggable widgets if library is available
        if (window.Sortable) {
            const widgetContainer = this.container.querySelector('[data-widgets]');
            if (widgetContainer) {
                new window.Sortable(widgetContainer, {
                    animation: 150,
                    ghostClass: 'widget-ghost',
                    onEnd: (evt) => {
                        this.saveWidgetOrder();
                    }
                });
            }
        }

        // Setup collapsible widgets
        const collapsibleWidgets = this.container.querySelectorAll('[data-widget-collapse]');
        collapsibleWidgets.forEach(widget => {
            const header = widget.querySelector('[data-widget-header]');
            const body = widget.querySelector('[data-widget-body]');
            
            if (header && body) {
                const handler = () => {
                    const isCollapsed = body.style.display === 'none';
                    body.style.display = isCollapsed ? 'block' : 'none';
                    widget.classList.toggle('collapsed', !isCollapsed);
                    
                    // Save state
                    this.saveWidgetState(widget.id, { collapsed: !isCollapsed });
                };
                
                header.addEventListener('click', handler);
                this.addEventListenerTracker(header, 'click', handler);
            }
        });
    }

    /**
     * Data operations
     */
    async refreshData() {
        await this.loadInitialData();
        this.updateCharts();
        NotificationManager.success('Dashboard verileri güncellendi');
    }

    async changeDateRange(range) {
        try {
            const response = await CSRFManager.get(`/admin/dashboard/data?range=${range}`);
            const data = await response.json();

            if (data.success) {
                this.setState({ data: data.data });
                this.renderStats();
                this.updateCharts();
            }
        } catch (error) {
            console.error('Error changing date range:', error);
            NotificationManager.error('Tarih aralığı değiştirilemedi');
        }
    }

    /**
     * UI operations
     */
    toggleTheme() {
        const newTheme = this.state.config.theme === 'light' ? 'dark' : 'light';
        this.setState({ 
            config: { ...this.state.config, theme: newTheme }
        });
        
        document.documentElement.classList.toggle('dark', newTheme === 'dark');
        this.saveSettings();
    }

    toggleAutoRefresh() {
        const newAutoRefresh = !this.state.config.autoRefresh;
        this.setState({
            config: { ...this.state.config, autoRefresh: newAutoRefresh }
        });

        if (newAutoRefresh) {
            this.startAutoRefresh();
        } else {
            this.stopAutoRefresh();
        }

        this.saveSettings();
        NotificationManager.info(`Otomatik yenileme ${newAutoRefresh ? 'açıldı' : 'kapatıldı'}`);
    }

    handleQuickAction(action) {
        switch (action) {
            case 'export-report':
                this.exportReport();
                break;
            case 'add-user':
                window.location.href = '/admin/users/create';
                break;
            case 'view-analytics':
                window.location.href = '/admin/analytics';
                break;
            default:
                console.warn('Unknown quick action:', action);
        }
    }

    /**
     * Render methods
     */
    renderStats() {
        const statsContainers = this.container.querySelectorAll('[data-stat]');
        
        statsContainers.forEach(container => {
            const statKey = container.dataset.stat;
            const statValue = this.state.data.stats[statKey];
            
            if (statValue !== undefined) {
                const valueElement = container.querySelector('[data-stat-value]');
                const changeElement = container.querySelector('[data-stat-change]');
                
                if (valueElement) {
                    valueElement.textContent = this.formatStatValue(statKey, statValue.value);
                }
                
                if (changeElement && statValue.change !== undefined) {
                    const changePercent = statValue.change;
                    changeElement.textContent = `${changePercent > 0 ? '+' : ''}${changePercent.toFixed(1)}%`;
                    changeElement.className = `text-sm ${changePercent > 0 ? 'text-green-600' : 'text-red-600'}`;
                }
            }
        });
    }

    renderActivities() {
        const activitiesContainer = this.container.querySelector('[data-activities]');
        if (!activitiesContainer) return;

        const activities = this.state.data.recentActivities.slice(0, 5);
        
        activitiesContainer.innerHTML = activities.map(activity => `
            <div class="flex items-start space-x-3 py-3 border-b last:border-b-0">
                <div class="w-2 h-2 rounded-full bg-blue-500 mt-2 flex-shrink-0"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-900">${activity.message}</p>
                    <p class="text-xs text-gray-500">${this.formatRelativeTime(activity.created_at)}</p>
                </div>
            </div>
        `).join('');
    }

    updateStats(newStats) {
        this.setState({
            data: {
                ...this.state.data,
                stats: { ...this.state.data.stats, ...newStats }
            }
        });
        this.renderStats();
    }

    updateChart(chartType, newData) {
        const chart = this.charts.get(chartType);
        if (chart) {
            chart.data = newData;
            chart.update('none');
        }
    }

    updateCharts() {
        this.charts.forEach((chart, type) => {
            const newData = this.state.data.charts[type];
            if (newData) {
                this.updateChart(type, newData);
            }
        });
    }

    /**
     * Export functionality
     */
    async exportReport() {
        try {
            const response = await CSRFManager.get('/admin/dashboard/export', {
                responseType: 'blob'
            });

            if (response.ok) {
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                
                a.href = url;
                a.download = `dashboard_report_${new Date().toISOString().split('T')[0]}.pdf`;
                document.body.appendChild(a);
                a.click();
                
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
                
                NotificationManager.success('Rapor indiriliyor...');
            }
        } catch (error) {
            console.error('Export error:', error);
            NotificationManager.error('Rapor dışa aktarılamadı');
        }
    }

    /**
     * Settings persistence
     */
    saveSettings() {
        try {
            localStorage.setItem('dashboard_config', JSON.stringify(this.state.config));
        } catch (error) {
            console.warn('Failed to save dashboard settings:', error);
        }
    }

    loadSettings() {
        try {
            const saved = localStorage.getItem('dashboard_config');
            if (saved) {
                const config = JSON.parse(saved);
                this.setState({ config: { ...this.state.config, ...config } });
            }
        } catch (error) {
            console.warn('Failed to load dashboard settings:', error);
        }
    }

    saveWidgetOrder() {
        try {
            const widgets = Array.from(this.container.querySelectorAll('[data-widget]'));
            const order = widgets.map(w => w.id);
            localStorage.setItem('dashboard_widget_order', JSON.stringify(order));
        } catch (error) {
            console.warn('Failed to save widget order:', error);
        }
    }

    saveWidgetState(widgetId, state) {
        try {
            const key = `dashboard_widget_${widgetId}`;
            localStorage.setItem(key, JSON.stringify(state));
        } catch (error) {
            console.warn('Failed to save widget state:', error);
        }
    }

    /**
     * Helper methods
     */
    formatStatValue(key, value) {
        switch (key) {
            case 'revenue':
                return new Intl.NumberFormat('tr-TR', {
                    style: 'currency',
                    currency: 'TRY'
                }).format(value);
            case 'users':
            case 'leads':
                return new Intl.NumberFormat('tr-TR').format(value);
            default:
                return value.toString();
        }
    }

    formatRelativeTime(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInMinutes = Math.floor((now - date) / (1000 * 60));

        if (diffInMinutes < 1) return 'Az önce';
        if (diffInMinutes < 60) return `${diffInMinutes} dakika önce`;
        
        const diffInHours = Math.floor(diffInMinutes / 60);
        if (diffInHours < 24) return `${diffInHours} saat önce`;
        
        const diffInDays = Math.floor(diffInHours / 24);
        if (diffInDays < 7) return `${diffInDays} gün önce`;
        
        return date.toLocaleDateString('tr-TR');
    }

    createCanvas(container) {
        const canvas = document.createElement('canvas');
        container.appendChild(canvas);
        return canvas;
    }

    setState(newState) {
        this.state = { ...this.state, ...newState };
    }

    addEventListenerTracker(element, event, handler) {
        this.eventListeners.push({ element, event, handler });
    }

    /**
     * Cleanup resources
     */
    cleanup() {
        // Stop auto-refresh
        this.stopAutoRefresh();

        // Destroy charts
        this.charts.forEach(chart => {
            if (chart.destroy) {
                chart.destroy();
            }
        });
        this.charts.clear();

        // Remove event listeners
        this.eventListeners.forEach(({ element, event, handler }) => {
            element.removeEventListener(event, handler);
        });
        this.eventListeners = [];

        // Disconnect WebSocket if available
        if (window.Echo) {
            window.Echo.leaveChannel('dashboard');
            window.Echo.leaveChannel('activities');
        }

        this.initialized = false;
        console.log('🧹 Dashboard Module cleaned up');
    }
}

// Global functions for backward compatibility
window.DashboardModule = DashboardModule;

export { DashboardModule };
export default DashboardModule;