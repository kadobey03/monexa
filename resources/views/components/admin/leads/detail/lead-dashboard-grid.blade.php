@props([
    'lead',
    'analyticsData' => [],
    'performanceMetrics' => []
])

<div class="lead-dashboard-grid grid grid-cols-12 gap-6 p-6">
    {{-- Demografik Bilgiler Kartı --}}
    <div class="col-span-4">
        <div class="card demographic-info-card bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="card-header bg-blue-600 text-white px-6 py-4">
                <h3 class="card-title text-lg font-semibold flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Demografik Bilgiler
                </h3>
            </div>
            <div class="card-body p-6 space-y-4">
                <div class="info-row flex justify-between">
                    <span class="label text-gray-600 font-medium">Ad Soyad:</span>
                    <span class="value text-gray-900">{{ $lead->name }}</span>
                </div>
                <div class="info-row flex justify-between">
                    <span class="label text-gray-600 font-medium">E-posta:</span>
                    <span class="value text-gray-900">{{ $lead->email }}</span>
                </div>
                <div class="info-row flex justify-between">
                    <span class="label text-gray-600 font-medium">Telefon:</span>
                    <span class="value clickable-phone text-blue-600 hover:underline cursor-pointer" data-phone="{{ $lead->phone }}">{{ $lead->phone }}</span>
                </div>
                <div class="info-row flex justify-between">
                    <span class="label text-gray-600 font-medium">Ülke:</span>
                    <span class="value text-gray-900">{{ $lead->country }}</span>
                </div>
                <div class="info-row flex justify-between">
                    <span class="label text-gray-600 font-medium">Kaynak:</span>
                    <span class="value text-gray-900">{{ $lead->lead_source ?: 'Bilinmiyor' }}</span>
                </div>
                <div class="info-row flex justify-between">
                    <span class="label text-gray-600 font-medium">Tercih Edilen İletişim:</span>
                    <span class="value text-gray-900">{{ $lead->preferred_contact_method ?: 'Belirlenmemiş' }}</span>
                </div>
                <div class="info-row flex justify-between">
                    <span class="label text-gray-600 font-medium">Saat Dilimi:</span>
                    <span class="value text-gray-900">{{ $lead->timezone ?? 'UTC' }}</span>
                </div>
                <div class="info-row flex justify-between">
                    <span class="label text-gray-600 font-medium">Kayıt Tarihi:</span>
                    <span class="value text-gray-900">{{ $lead->created_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Lead Scoring & Analytics --}}
    <div class="col-span-4">
        <div class="card lead-scoring-card bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="card-header bg-amber-600 text-white px-6 py-4">
                <h3 class="card-title text-lg font-semibold flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    Lead Scoring & Analytics
                </h3>
            </div>
            <div class="card-body p-6">
                {{-- Lead Score Gauge --}}
                <div class="score-gauge-container mb-6">
                    <div class="circular-progress relative w-32 h-32 mx-auto" data-score="{{ $lead->lead_score ?? 0 }}">
                        <svg class="score-svg w-full h-full" viewBox="0 0 36 36">
                            <path class="score-bg fill-none stroke-gray-200 stroke-2" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                            <path class="score-fill fill-none stroke-current stroke-2 stroke-linecap-round transform -rotate-90 origin-center"
                                  stroke-dasharray="{{ $lead->lead_score ?? 0 }}, 100"
                                  d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                        </svg>
                        <div class="score-text absolute inset-0 flex items-center justify-center">
                            <span class="text-2xl font-bold {{ $lead->lead_score >= 70 ? 'text-green-600' : ($lead->lead_score >= 40 ? 'text-yellow-600' : 'text-red-600') }}">{{ $lead->lead_score ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                {{-- Scoring Breakdown --}}
                <div class="scoring-breakdown space-y-3">
                    {{-- Demografik Uyum --}}
                    <div class="score-item">
                        <span class="score-label text-sm text-gray-700">Demografik Uyum</span>
                        <div class="score-bar bg-gray-200 rounded-full h-2 mt-1">
                            <div class="score-fill h-2 rounded-full bg-blue-600 transition-all duration-300"
                                 style="width: {{ $analyticsData['demographic_score'] ?? 0 }}%"></div>
                        </div>
                        <span class="score-value text-xs text-gray-500 mt-1 block">{{ $analyticsData['demographic_score'] ?? 0 }}/20</span>
                    </div>

                    {{-- Etkileşim Seviyesi --}}
                    <div class="score-item">
                        <span class="score-label text-sm text-gray-700">Etkileşim Seviyesi</span>
                        <div class="score-bar bg-gray-200 rounded-full h-2 mt-1">
                            <div class="score-fill h-2 rounded-full bg-green-600 transition-all duration-300"
                                 style="width: {{ $analyticsData['engagement_score'] ?? 0 }}%"></div>
                        </div>
                        <span class="score-value text-xs text-gray-500 mt-1 block">{{ $analyticsData['engagement_score'] ?? 0 }}/25</span>
                    </div>

                    {{-- Potansiyel Değer --}}
                    <div class="score-item">
                        <span class="score-label text-sm text-gray-700">Potansiyel Değer</span>
                        <div class="score-bar bg-gray-200 rounded-full h-2 mt-1">
                            <div class="score-fill h-2 rounded-full bg-purple-600 transition-all duration-300"
                                 style="width: {{ $analyticsData['value_score'] ?? 0 }}%"></div>
                        </div>
                        <span class="score-value text-xs text-gray-500 mt-1 block">{{ $analyticsData['value_score'] ?? 0 }}/30</span>
                    </div>

                    {{-- İletişim Geçmişi --}}
                    <div class="score-item">
                        <span class="score-label text-sm text-gray-700">İletişim Geçmişi</span>
                        <div class="score-bar bg-gray-200 rounded-full h-2 mt-1">
                            <div class="score-fill h-2 rounded-full bg-orange-600 transition-all duration-300"
                                 style="width: {{ $analyticsData['contact_score'] ?? 0 }}%"></div>
                        </div>
                        <span class="score-value text-xs text-gray-500 mt-1 block">{{ $analyticsData['contact_score'] ?? 0 }}/25</span>
                    </div>
                </div>

                {{-- Lead Level Badge --}}
                <div class="lead-level-badge mt-4 text-center">
                    @php
                        $score = $lead->lead_score ?? 0;
                        $levelClass = $score >= 80 ? 'bg-red-100 text-red-800' : ($score >= 60 ? 'bg-orange-100 text-orange-800' : ($score >= 40 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'));
                        $levelText = $score >= 80 ? 'Sıcak Lead' : ($score >= 60 ? 'Ilık Lead' : ($score >= 40 ? 'Soğuk Lead' : 'Çok Soğuk Lead'));
                    @endphp
                    <span class="badge inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $levelClass }}">
                        {{ $levelText }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Conversion Tracking --}}
    <div class="col-span-4">
        <div class="card conversion-tracking-card bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="card-header bg-green-600 text-white px-6 py-4">
                <h3 class="card-title text-lg font-semibold flex items-center">
                    <i class="fas fa-trophy mr-2"></i>
                    Conversion Tracking
                </h3>
            </div>
            <div class="card-body p-6">
                {{-- Progress Pipeline --}}
                <div class="conversion-pipeline mb-4">
                    <div class="pipeline-stage flex items-center mb-2 {{ $lead->cstatus === null ? 'active' : ($lead->cstatus === 'Customer' ? 'completed' : '') }}">
                        <div class="stage-icon w-8 h-8 rounded-full flex items-center justify-center mr-3
                                    {{ $lead->cstatus === null ? 'bg-blue-500 text-white' : ($lead->cstatus === 'Customer' ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600') }}">
                            <i class="fas fa-user-plus text-xs"></i>
                        </div>
                        <div class="stage-content">
                            <div class="stage-label text-sm font-medium text-gray-900">Lead</div>
                            <div class="stage-date text-xs text-gray-500">{{ $lead->created_at->format('d.m.Y') }}</div>
                        </div>
                    </div>
                    <div class="pipeline-stage flex items-center mb-2 {{ $lead->cstatus === 'Qualified' ? 'active' : ($lead->cstatus === 'Customer' ? 'completed' : '') }}">
                        <div class="stage-icon w-8 h-8 rounded-full flex items-center justify-center mr-3
                                    {{ $lead->cstatus === 'Qualified' ? 'bg-blue-500 text-white' : ($lead->cstatus === 'Customer' ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600') }}">
                            <i class="fas fa-check-circle text-xs"></i>
                        </div>
                        <div class="stage-content">
                            <div class="stage-label text-sm font-medium text-gray-900">Qualified</div>
                            <div class="stage-date text-xs text-gray-500">{{ $lead->lead_status_id ? 'N/A' : 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="pipeline-stage flex items-center {{ $lead->cstatus === 'Customer' ? 'active' : '' }}">
                        <div class="stage-icon w-8 h-8 rounded-full flex items-center justify-center mr-3
                                    {{ $lead->cstatus === 'Customer' ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                            <i class="fas fa-trophy text-xs"></i>
                        </div>
                        <div class="stage-content">
                            <div class="stage-label text-sm font-medium text-gray-900">Customer</div>
                            <div class="stage-date text-xs text-gray-500">{{ $lead->cstatus === 'Customer' ? now()->format('d.m.Y') : 'Pending' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Key Metrics --}}
                <div class="conversion-metrics grid grid-cols-2 gap-4">
                    <div class="metric-item text-center p-3 bg-gray-50 rounded-lg">
                        <div class="metric-value text-xl font-bold text-green-600">${{ number_format($lead->estimated_value ?? 0) }}</div>
                        <div class="metric-label text-xs text-gray-600 uppercase tracking-wide">Tahmini Değer</div>
                    </div>
                    <div class="metric-item text-center p-3 bg-gray-50 rounded-lg">
                        <div class="metric-value text-xl font-bold text-blue-600">{{ $lead->created_at->diffInDays() }}</div>
                        <div class="metric-label text-xs text-gray-600 uppercase tracking-wide">Pipeline'da Gün</div>
                    </div>
                    <div class="metric-item text-center p-3 bg-gray-50 rounded-lg">
                        <div class="metric-value text-xl font-bold text-purple-600">{{ count($lead->contact_history ?? []) }}</div>
                        <div class="metric-label text-xs text-gray-600 uppercase tracking-wide">Toplam İletişim</div>
                    </div>
                    <div class="metric-item text-center p-3 bg-gray-50 rounded-lg">
                        <div class="metric-value text-xl font-bold text-orange-600">{{ intval(($lead->lead_score ?? 0) * 0.8) }}%</div>
                        <div class="metric-label text-xs text-gray-600 uppercase tracking-wide">Dönüşüm Olasılığı</div>
                    </div>
                </div>

                {{-- Next Action Alert --}}
                @if($lead->next_follow_up_date)
                <div class="next-action-alert mt-4 p-3 {{ $lead->next_follow_up_date->isPast() ? 'bg-red-50 border-red-200' : 'bg-blue-50 border-blue-200' }} border rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-clock {{ $lead->next_follow_up_date->isPast() ? 'text-red-500' : 'text-blue-500' }} mr-2"></i>
                        <div>
                            <div class="font-medium {{ $lead->next_follow_up_date->isPast() ? 'text-red-700' : 'text-blue-700' }}">
                                {{ $lead->next_follow_up_date->isPast() ? 'Takip Gecikmiş!' : 'Sonraki Takip' }}
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $lead->next_follow_up_date->format('d.m.Y H:i') }}
                                ({{ $lead->next_follow_up_date->diffForHumans() }})
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>