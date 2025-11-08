@props([
    'lead',
    'chartData' => [],
    'trends' => []
])

<div class="analytics-section bg-white rounded-lg shadow-lg overflow-hidden mt-6">
    <div class="section-header bg-indigo-600 text-white px-6 py-4">
        <h3 class="section-title text-lg font-semibold flex items-center">
            <i class="fas fa-chart-bar mr-2"></i>
            Lead Analytics & Trends
        </h3>
    </div>

    <div class="section-body p-6">
        <div class="analytics-grid grid grid-cols-12 gap-6">
            {{-- Engagement Timeline Chart --}}
            <div class="col-span-8">
                <div class="chart-container">
                    <h4 class="chart-title text-md font-medium text-gray-900 mb-4">Etkileşim Zaman Çizelgesi</h4>
                    <div class="chart-wrapper bg-gray-50 rounded-lg p-4">
                        <canvas id="engagementChart-{{ $lead->id }}" 
                                class="w-full h-64"
                                data-chart-data="{{ json_encode($chartData['engagement'] ?? []) }}">
                        </canvas>
                        @if(empty($chartData['engagement']))
                        <div class="empty-chart-placeholder flex items-center justify-center h-64">
                            <div class="text-center">
                                <i class="fas fa-chart-line text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-500">Henüz etkileşim verisi bulunmuyor</p>
                                <p class="text-sm text-gray-400">Lead ile iletişim kuruldukça veriler burada görünecek</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Key Performance Indicators --}}
            <div class="col-span-4">
                <div class="kpi-container">
                    <h4 class="kpi-title text-md font-medium text-gray-900 mb-4">Anahtar Performans Göstergeleri</h4>
                    <div class="kpi-grid space-y-4">
                        {{-- Response Rate --}}
                        <div class="kpi-item bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-4">
                            <div class="kpi-header flex items-center justify-between mb-2">
                                <span class="kpi-label text-sm font-medium text-blue-800">Yanıt Oranı</span>
                                <i class="fas fa-reply text-blue-600"></i>
                            </div>
                            <div class="kpi-value text-2xl font-bold text-blue-900">
                                {{ $trends['response_rate'] ?? '0' }}%
                            </div>
                            <div class="kpi-trend text-xs text-blue-700 mt-1">
                                @if(isset($trends['response_rate_change']))
                                    <i class="fas fa-{{ $trends['response_rate_change'] > 0 ? 'arrow-up text-green-600' : 'arrow-down text-red-600' }}"></i>
                                    {{ abs($trends['response_rate_change']) }}% geçen haftaya göre
                                @else
                                    Trend verisi yok
                                @endif
                            </div>
                        </div>

                        {{-- Engagement Score --}}
                        <div class="kpi-item bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4">
                            <div class="kpi-header flex items-center justify-between mb-2">
                                <span class="kpi-label text-sm font-medium text-green-800">Etkileşim Skoru</span>
                                <i class="fas fa-heart text-green-600"></i>
                            </div>
                            <div class="kpi-value text-2xl font-bold text-green-900">
                                {{ $trends['engagement_score'] ?? '0' }}/100
                            </div>
                            <div class="kpi-progress bg-green-200 rounded-full h-2 mt-2">
                                <div class="kpi-progress-bar bg-green-600 h-2 rounded-full transition-all duration-300"
                                     style="width: {{ $trends['engagement_score'] ?? 0 }}%"></div>
                            </div>
                        </div>

                        {{-- Contact Frequency --}}
                        <div class="kpi-item bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-4">
                            <div class="kpi-header flex items-center justify-between mb-2">
                                <span class="kpi-label text-sm font-medium text-purple-800">İletişim Sıklığı</span>
                                <i class="fas fa-phone text-purple-600"></i>
                            </div>
                            <div class="kpi-value text-2xl font-bold text-purple-900">
                                {{ $trends['contact_frequency'] ?? '0' }}/hafta
                            </div>
                            <div class="kpi-description text-xs text-purple-700 mt-1">
                                Son 30 günde ortalama
                            </div>
                        </div>

                        {{-- Conversion Probability --}}
                        <div class="kpi-item bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-4">
                            <div class="kpi-header flex items-center justify-between mb-2">
                                <span class="kpi-label text-sm font-medium text-orange-800">Dönüşüm Olasılığı</span>
                                <i class="fas fa-bullseye text-orange-600"></i>
                            </div>
                            <div class="kpi-value text-2xl font-bold text-orange-900">
                                {{ $trends['conversion_probability'] ?? intval(($lead->lead_score ?? 0) * 0.8) }}%
                            </div>
                            <div class="kpi-status text-xs mt-1">
                                @php
                                    $probability = $trends['conversion_probability'] ?? intval(($lead->lead_score ?? 0) * 0.8);
                                @endphp
                                <span class="kpi-status-badge px-2 py-1 rounded-full text-xs font-medium
                                    {{ $probability >= 70 ? 'bg-green-200 text-green-800' : ($probability >= 40 ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">
                                    {{ $probability >= 70 ? 'Yüksek' : ($probability >= 40 ? 'Orta' : 'Düşük') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Communication Heatmap --}}
        <div class="communication-heatmap mt-8">
            <h4 class="heatmap-title text-md font-medium text-gray-900 mb-4">İletişim Isı Haritası</h4>
            <div class="heatmap-container bg-gray-50 rounded-lg p-4">
                <div class="heatmap-legend flex justify-between items-center mb-4">
                    <span class="legend-text text-sm text-gray-600">Son 7 günde saatlik iletişim yoğunluğu</span>
                    <div class="legend-scale flex items-center space-x-2">
                        <span class="legend-label text-xs text-gray-500">Az</span>
                        <div class="legend-gradient flex space-x-1">
                            <div class="w-3 h-3 bg-gray-200 rounded"></div>
                            <div class="w-3 h-3 bg-blue-200 rounded"></div>
                            <div class="w-3 h-3 bg-blue-400 rounded"></div>
                            <div class="w-3 h-3 bg-blue-600 rounded"></div>
                            <div class="w-3 h-3 bg-blue-800 rounded"></div>
                        </div>
                        <span class="legend-label text-xs text-gray-500">Çok</span>
                    </div>
                </div>
                
                @if(!empty($chartData['heatmap']))
                <div class="heatmap-grid grid grid-cols-24 gap-1">
                    @foreach($chartData['heatmap'] as $hour => $intensity)
                        <div class="heatmap-cell w-4 h-4 rounded-sm {{ 
                            $intensity == 0 ? 'bg-gray-200' : 
                            ($intensity <= 2 ? 'bg-blue-200' : 
                            ($intensity <= 4 ? 'bg-blue-400' : 
                            ($intensity <= 6 ? 'bg-blue-600' : 'bg-blue-800'))) 
                        }}"
                             title="Saat {{ $hour }}:00 - {{ $intensity }} iletişim"
                             data-hour="{{ $hour }}"
                             data-intensity="{{ $intensity }}">
                        </div>
                    @endforeach
                </div>
                @else
                <div class="empty-heatmap-placeholder flex items-center justify-center h-32">
                    <div class="text-center">
                        <i class="fas fa-fire text-3xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500">İletişim verisi yetersiz</p>
                        <p class="text-sm text-gray-400">Daha fazla iletişim sonrası ısı haritası oluşturulacak</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Behavioral Insights --}}
        <div class="behavioral-insights mt-8">
            <h4 class="insights-title text-md font-medium text-gray-900 mb-4">Davranışsal İçgörüler</h4>
            <div class="insights-grid grid grid-cols-3 gap-4">
                {{-- Best Contact Time --}}
                <div class="insight-card bg-gradient-to-br from-teal-50 to-teal-100 rounded-lg p-4">
                    <div class="insight-header flex items-center mb-3">
                        <div class="insight-icon w-10 h-10 bg-teal-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div>
                            <h5 class="insight-title text-sm font-semibold text-teal-800">En İyi İletişim Saati</h5>
                            <p class="insight-subtitle text-xs text-teal-600">Yanıt verme oranı en yüksek</p>
                        </div>
                    </div>
                    <div class="insight-value text-xl font-bold text-teal-900">
                        {{ $trends['best_contact_time'] ?? '14:00-16:00' }}
                    </div>
                </div>

                {{-- Preferred Channel --}}
                <div class="insight-card bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg p-4">
                    <div class="insight-header flex items-center mb-3">
                        <div class="insight-icon w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-comments text-white"></i>
                        </div>
                        <div>
                            <h5 class="insight-title text-sm font-semibold text-pink-800">Tercih Edilen Kanal</h5>
                            <p class="insight-subtitle text-xs text-pink-600">En çok kullanılan iletişim yöntemi</p>
                        </div>
                    </div>
                    <div class="insight-value text-xl font-bold text-pink-900">
                        {{ $trends['preferred_channel'] ?? 'Telefon' }}
                    </div>
                </div>

                {{-- Response Pattern --}}
                <div class="insight-card bg-gradient-to-br from-amber-50 to-amber-100 rounded-lg p-4">
                    <div class="insight-header flex items-center mb-3">
                        <div class="insight-icon w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-chart-pulse text-white"></i>
                        </div>
                        <div>
                            <h5 class="insight-title text-sm font-semibold text-amber-800">Yanıt Deseni</h5>
                            <p class="insight-subtitle text-xs text-amber-600">Ortalama yanıt süresi</p>
                        </div>
                    </div>
                    <div class="insight-value text-xl font-bold text-amber-900">
                        {{ $trends['avg_response_time'] ?? '2-4 saat' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize engagement chart if data exists
    const chartCanvas = document.getElementById('engagementChart-{{ $lead->id }}');
    if (chartCanvas && chartCanvas.dataset.chartData) {
        try {
            const chartData = JSON.parse(chartCanvas.dataset.chartData);
            if (chartData && chartData.length > 0) {
                initializeEngagementChart(chartCanvas, chartData);
            }
        } catch (e) {
            console.log('Chart data parsing error:', e);
        }
    }

    // Initialize heatmap interactions
    initializeHeatmapInteractions();
});

function initializeEngagementChart(canvas, data) {
    // Basic chart implementation - can be enhanced with Chart.js or similar
    const ctx = canvas.getContext('2d');
    
    // Simple line chart implementation
    ctx.strokeStyle = '#3B82F6';
    ctx.lineWidth = 2;
    ctx.beginPath();
    
    const width = canvas.width;
    const height = canvas.height;
    const padding = 40;
    
    // Draw chart based on data
    if (data.length > 0) {
        const stepX = (width - 2 * padding) / (data.length - 1);
        const maxValue = Math.max(...data.map(d => d.value));
        
        data.forEach((point, index) => {
            const x = padding + index * stepX;
            const y = height - padding - (point.value / maxValue) * (height - 2 * padding);
            
            if (index === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });
        
        ctx.stroke();
    }
}

function initializeHeatmapInteractions() {
    // Add hover effects to heatmap cells
    document.querySelectorAll('.heatmap-cell').forEach(cell => {
        cell.addEventListener('mouseenter', function() {
            this.classList.add('scale-110', 'z-10', 'shadow-lg');
        });
        
        cell.addEventListener('mouseleave', function() {
            this.classList.remove('scale-110', 'z-10', 'shadow-lg');
        });
    });
}
</script>
@endpush