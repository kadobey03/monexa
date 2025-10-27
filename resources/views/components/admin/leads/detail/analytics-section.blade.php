<div class="analytics-section bg-white rounded-lg shadow-md p-6 mt-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-chart-line text-purple-500 mr-2"></i>
            Analytics & Insights
        </h3>
        <div class="flex space-x-2">
            <select class="analytics-timeframe px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="7">Last 7 days</option>
                <option value="30">Last 30 days</option>
                <option value="90">Last 90 days</option>
                <option value="365">Last year</option>
            </select>
            <button type="button"
                    class="refresh-analytics-btn bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                <i class="fas fa-sync-alt mr-1"></i>
                Refresh
            </button>
        </div>
    </div>

    {{-- Analytics Grid --}}
    <div class="analytics-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        {{-- Chart Container --}}
        <div class="chart-container md:col-span-2 bg-gray-50 rounded-lg p-4">
            <h4 class="text-md font-medium text-gray-800 mb-4">Performance Trends</h4>
            <div id="performance-chart" class="h-64">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>

        {{-- Key Metrics --}}
        <div class="key-metrics space-y-4">
            @if(isset($trends) && count($trends) > 0)
                @foreach($trends as $metric => $data)
                <div class="metric-card bg-gradient-to-r {{ $data['color'] ?? 'from-blue-500 to-blue-600' }} text-white p-4 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">{{ $data['label'] ?? ucfirst($metric) }}</p>
                            <p class="text-2xl font-bold">{{ $data['value'] ?? 0 }}</p>
                        </div>
                        <div class="text-right">
                            @if(isset($data['change']))
                            <p class="text-sm {{ $data['change'] >= 0 ? 'text-green-200' : 'text-red-200' }}">
                                <i class="fas fa-arrow-{{ $data['change'] >= 0 ? 'up' : 'down' }} mr-1"></i>
                                {{ abs($data['change']) }}%
                            </p>
                            @endif
                            <p class="text-xs opacity-75">vs last period</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="metric-card bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-lg">
                    <div class="text-center">
                        <p class="text-sm opacity-90">Lead Score</p>
                        <p class="text-2xl font-bold">{{ $lead->score ?? 0 }}</p>
                    </div>
                </div>
                <div class="metric-card bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-lg">
                    <div class="text-center">
                        <p class="text-sm opacity-90">Engagement Rate</p>
                        <p class="text-2xl font-bold">85%</p>
                    </div>
                </div>
                <div class="metric-card bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-4 rounded-lg">
                    <div class="text-center">
                        <p class="text-sm opacity-90">Conversion Potential</p>
                        <p class="text-2xl font-bold">High</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Detailed Analytics Tables --}}
    <div class="detailed-analytics grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Activity Timeline --}}
        <div class="activity-timeline bg-gray-50 rounded-lg p-4">
            <h4 class="text-md font-medium text-gray-800 mb-4">Recent Activity</h4>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @if(isset($chartData['activities']) && count($chartData['activities']) > 0)
                    @foreach(array_slice($chartData['activities'], 0, 10) as $activity)
                    <div class="activity-item flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas {{ $activity['icon'] ?? 'fa-circle' }} text-blue-600 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $activity['title'] ?? 'Activity' }}</p>
                            <p class="text-xs text-gray-500">{{ $activity['description'] ?? '' }}</p>
                            <p class="text-xs text-gray-400">{{ $activity['timestamp'] ?? now()->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4 text-gray-500">
                        <i class="fas fa-history text-2xl mb-2"></i>
                        <p class="text-sm">No recent activity</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Conversion Funnel --}}
        <div class="conversion-funnel bg-gray-50 rounded-lg p-4">
            <h4 class="text-md font-medium text-gray-800 mb-4">Conversion Funnel</h4>
            <div class="space-y-3">
                @php
                    $funnelSteps = [
                        ['label' => 'Initial Contact', 'count' => 100, 'percentage' => 100],
                        ['label' => 'Qualified Lead', 'count' => 75, 'percentage' => 75],
                        ['label' => 'Proposal Sent', 'count' => 45, 'percentage' => 45],
                        ['label' => 'Negotiation', 'count' => 25, 'percentage' => 25],
                        ['label' => 'Closed Won', 'count' => 15, 'percentage' => 15],
                    ];
                @endphp
                @foreach($funnelSteps as $step)
                <div class="funnel-step">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-700">{{ $step['label'] }}</span>
                        <span class="text-sm text-gray-500">{{ $step['count'] }} ({{ $step['percentage'] }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $step['percentage'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Insights & Recommendations --}}
    @if(isset($analyticsData['insights']) && count($analyticsData['insights']) > 0)
    <div class="insights-section mt-6">
        <h4 class="text-md font-medium text-gray-800 mb-4">AI Insights & Recommendations</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($analyticsData['insights'] as $insight)
            <div class="insight-card bg-gradient-to-r {{ $insight['type'] === 'positive' ? 'from-green-50 to-green-100' : ($insight['type'] === 'warning' ? 'from-yellow-50 to-yellow-100' : 'from-blue-50 to-blue-100') }} border-l-4 {{ $insight['type'] === 'positive' ? 'border-green-500' : ($insight['type'] === 'warning' ? 'border-yellow-500' : 'border-blue-500') }} p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas {{ $insight['icon'] ?? 'fa-lightbulb' }} {{ $insight['type'] === 'positive' ? 'text-green-600' : ($insight['type'] === 'warning' ? 'text-yellow-600' : 'text-blue-600') }}"></i>
                    </div>
                    <div class="ml-3">
                        <h5 class="text-sm font-medium text-gray-800">{{ $insight['title'] ?? 'Insight' }}</h5>
                        <p class="text-sm text-gray-600">{{ $insight['description'] ?? '' }}</p>
                        @if(isset($insight['action']))
                        <button class="mt-2 text-xs {{ $insight['type'] === 'positive' ? 'text-green-700 hover:text-green-800' : ($insight['type'] === 'warning' ? 'text-yellow-700 hover:text-yellow-800' : 'text-blue-700 hover:text-blue-800') }} font-medium underline">
                            {{ $insight['action'] }}
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const analyticsSection = {
        chart: null,

        init() {
            this.bindEvents();
            this.initializeCharts();
        },

        bindEvents() {
            // Timeframe selector
            const timeframeSelect = document.querySelector('.analytics-timeframe');
            if (timeframeSelect) {
                timeframeSelect.addEventListener('change', (e) => this.updateTimeframe(e.target.value));
            }

            // Refresh button
            const refreshBtn = document.querySelector('.refresh-analytics-btn');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', () => this.refreshAnalytics());
            }
        },

        initializeCharts() {
            const ctx = document.getElementById('performanceChart');
            if (!ctx) return;

            // Sample data - replace with actual data from backend
            const chartData = @json($chartData ?? [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'datasets' => [
                    [
                        'label' => 'Lead Score',
                        'data' => [65, 59, 80, 81, 56, 85],
                        'borderColor' => 'rgb(59, 130, 246)',
                        'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                        'tension' => 0.4
                    ],
                    [
                        'label' => 'Engagement',
                        'data' => [28, 48, 40, 19, 86, 27],
                        'borderColor' => 'rgb(16, 185, 129)',
                        'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                        'tension' => 0.4
                    ]
                ]
            ]);

            this.chart = new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        },

        updateTimeframe(days) {
            // Update chart data based on timeframe
            console.log('Updating timeframe to', days, 'days');

            // Make AJAX call to get new data
            fetch(`/admin/api/leads/${{{ $lead->id }}}/analytics?days=${days}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (this.chart && data.chartData) {
                    this.chart.data = data.chartData;
                    this.chart.update();
                }
            })
            .catch(error => {
                console.error('Error updating analytics:', error);
            });
        },

        refreshAnalytics() {
            const timeframe = document.querySelector('.analytics-timeframe').value;
            this.updateTimeframe(timeframe);
            this.showMessage('Analytics refreshed successfully', 'success');
        },

        showMessage(message, type) {
            // Simple message display - you can enhance this with a proper notification system
            alert(message);
        }
    };

    // Initialize analytics section
    analyticsSection.init();
});
</script>
@endpush