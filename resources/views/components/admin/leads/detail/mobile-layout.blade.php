@props([
    'lead',
    'mobileData' => []
])

{{-- Mobile Layout - Hidden on Desktop --}}
<div class="mobile-layout-container block lg:hidden">
    <div class="mobile-lead-detail bg-white">
        {{-- Mobile Header --}}
        <div class="mobile-header bg-gradient-to-r from-blue-600 to-indigo-700 text-white p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="mobile-avatar w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <span class="text-lg font-bold">{{ strtoupper(substr($lead->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold truncate">{{ $lead->name }}</h1>
                        <p class="text-sm opacity-90">ID: #{{ $lead->id }}</p>
                    </div>
                </div>
                <div class="mobile-score text-center">
                    <div class="text-2xl font-bold">{{ $lead->lead_score ?? 0 }}</div>
                    <div class="text-xs opacity-75">Score</div>
                </div>
            </div>
        </div>

        {{-- Mobile Quick Stats --}}
        <div class="mobile-quick-stats bg-gray-50 p-4">
            <div class="grid grid-cols-3 gap-4">
                <div class="stat-item text-center">
                    <div class="stat-value text-lg font-semibold text-blue-600">${{ number_format($lead->estimated_value ?? 0) }}</div>
                    <div class="stat-label text-xs text-gray-600">Tahmini Değer</div>
                </div>
                <div class="stat-item text-center">
                    <div class="stat-value text-lg font-semibold text-green-600">{{ $lead->created_at->diffInDays() }}</div>
                    <div class="stat-label text-xs text-gray-600">Pipeline Gün</div>
                </div>
                <div class="stat-item text-center">
                    <div class="stat-value text-lg font-semibold text-purple-600">{{ count($lead->contact_history ?? []) }}</div>
                    <div class="stat-label text-xs text-gray-600">İletişim</div>
                </div>
            </div>
        </div>

        {{-- Mobile Tab Navigation --}}
        <div class="mobile-tabs border-b border-gray-200">
            <div class="flex overflow-x-auto">
                <button class="mobile-tab-btn flex-shrink-0 px-4 py-3 text-sm font-medium border-b-2 border-blue-500 text-blue-600 bg-blue-50" 
                        data-tab="info">
                    <i class="fas fa-info-circle mr-1"></i>
                    Bilgiler
                </button>
                <button class="mobile-tab-btn flex-shrink-0 px-4 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500" 
                        data-tab="activity">
                    <i class="fas fa-chart-line mr-1"></i>
                    Aktivite
                </button>
                <button class="mobile-tab-btn flex-shrink-0 px-4 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500" 
                        data-tab="communication">
                    <i class="fas fa-comments mr-1"></i>
                    İletişim
                </button>
                <button class="mobile-tab-btn flex-shrink-0 px-4 py-3 text-sm font-medium border-b-2 border-transparent text-gray-500" 
                        data-tab="notes">
                    <i class="fas fa-sticky-note mr-1"></i>
                    Notlar
                </button>
            </div>
        </div>

        {{-- Mobile Tab Content --}}
        <div class="mobile-tab-content">
            {{-- Info Tab --}}
            <div class="mobile-tab-pane active" data-tab-content="info">
                <div class="p-4 space-y-4">
                    {{-- Contact Information --}}
                    <div class="info-section">
                        <h3 class="section-title text-sm font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-address-card mr-2 text-blue-500"></i>
                            İletişim Bilgileri
                        </h3>
                        <div class="info-grid space-y-2">
                            <div class="info-row flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="label text-sm text-gray-600">E-posta:</span>
                                <a href="mailto:{{ $lead->email }}" class="value text-sm text-blue-600 font-medium">{{ $lead->email }}</a>
                            </div>
                            <div class="info-row flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="label text-sm text-gray-600">Telefon:</span>
                                <a href="tel:{{ $lead->phone }}" class="value text-sm text-green-600 font-medium">{{ $lead->phone }}</a>
                            </div>
                            <div class="info-row flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="label text-sm text-gray-600">Ülke:</span>
                                <span class="value text-sm text-gray-900 font-medium">{{ $lead->country }}</span>
                            </div>
                            <div class="info-row flex justify-between items-center py-2">
                                <span class="label text-sm text-gray-600">Kaynak:</span>
                                <span class="value text-sm text-gray-900 font-medium">{{ $lead->lead_source ?: 'Bilinmiyor' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Lead Status --}}
                    <div class="status-section">
                        <h3 class="section-title text-sm font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-flag mr-2 text-green-500"></i>
                            Lead Durumu
                        </h3>
                        <div class="status-info bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">Mevcut Durum:</span>
                                <span class="status-badge px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $lead->leadStatus->display_name ?? 'Belirsiz' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Son Güncelleme:</span>
                                <span class="text-sm text-gray-900">{{ $lead->updated_at->format('d.m.Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activity Tab --}}
            <div class="mobile-tab-pane hidden" data-tab-content="activity">
                <div class="p-4">
                    <div class="activity-timeline space-y-3">
                        {{-- Lead Score Progress --}}
                        <div class="activity-item bg-blue-50 rounded-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-blue-800">Lead Score</span>
                                <span class="text-lg font-bold text-blue-600">{{ $lead->lead_score ?? 0 }}/100</span>
                            </div>
                            <div class="progress-bar bg-blue-200 rounded-full h-2">
                                <div class="progress-fill bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                     style="width: {{ $lead->lead_score ?? 0 }}%"></div>
                            </div>
                        </div>

                        {{-- Recent Activities --}}
                        <div class="recent-activities">
                            <h4 class="text-sm font-semibold text-gray-800 mb-2">Son Aktiviteler</h4>
                            @if(!empty($mobileData['recent_activities']))
                                @foreach($mobileData['recent_activities'] as $activity)
                                <div class="activity-entry flex items-start space-x-3 py-2">
                                    <div class="activity-icon w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center">
                                        <i class="fas fa-{{ $activity['icon'] ?? 'circle' }} text-xs text-gray-600"></i>
                                    </div>
                                    <div class="activity-content flex-1">
                                        <p class="text-sm text-gray-900">{{ $activity['description'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            @else
                            <div class="empty-activities text-center py-6">
                                <i class="fas fa-chart-line text-2xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">Henüz aktivite bulunmuyor</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Communication Tab --}}
            <div class="mobile-tab-pane hidden" data-tab-content="communication">
                <div class="p-4">
                    <div class="communication-section">
                        <div class="quick-actions grid grid-cols-2 gap-3 mb-4">
                            <button class="action-btn bg-green-500 text-white rounded-lg p-3 text-center">
                                <i class="fas fa-phone text-lg mb-1"></i>
                                <div class="text-sm font-medium">Ara</div>
                            </button>
                            <button class="action-btn bg-blue-500 text-white rounded-lg p-3 text-center">
                                <i class="fas fa-envelope text-lg mb-1"></i>
                                <div class="text-sm font-medium">E-posta</div>
                            </button>
                        </div>

                        <div class="communication-history">
                            <h4 class="text-sm font-semibold text-gray-800 mb-2">İletişim Geçmişi</h4>
                            @if(!empty($mobileData['communications']))
                                @foreach($mobileData['communications'] as $comm)
                                <div class="comm-entry bg-gray-50 rounded-lg p-3 mb-2">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="comm-type text-xs font-medium text-gray-600">{{ $comm['type'] }}</span>
                                        <span class="comm-date text-xs text-gray-500">{{ $comm['date'] }}</span>
                                    </div>
                                    <p class="comm-content text-sm text-gray-900">{{ $comm['content'] }}</p>
                                </div>
                                @endforeach
                            @else
                            <div class="empty-communications text-center py-6">
                                <i class="fas fa-comments text-2xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">İletişim geçmişi bulunmuyor</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes Tab --}}
            <div class="mobile-tab-pane hidden" data-tab-content="notes">
                <div class="p-4">
                    <div class="notes-section">
                        <div class="add-note-btn mb-4">
                            <button class="w-full bg-blue-500 text-white rounded-lg p-3 text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>
                                Yeni Not Ekle
                            </button>
                        </div>

                        <div class="notes-list">
                            @if(!empty($mobileData['notes']))
                                @foreach($mobileData['notes'] as $note)
                                <div class="note-entry bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg p-3 mb-3">
                                    <div class="note-header flex items-center justify-between mb-2">
                                        <span class="note-author text-xs font-medium text-gray-700">{{ $note['author'] }}</span>
                                        <span class="note-date text-xs text-gray-500">{{ $note['date'] }}</span>
                                    </div>
                                    <p class="note-content text-sm text-gray-900">{{ $note['content'] }}</p>
                                </div>
                                @endforeach
                            @else
                            <div class="empty-notes text-center py-6">
                                <i class="fas fa-sticky-note text-2xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">Henüz not bulunmuyor</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeMobileTabs();
});

function initializeMobileTabs() {
    const tabButtons = document.querySelectorAll('.mobile-tab-btn');
    const tabPanes = document.querySelectorAll('.mobile-tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;

            // Remove active class from all buttons and panes
            tabButtons.forEach(btn => {
                btn.classList.remove('border-blue-500', 'text-blue-600', 'bg-blue-50');
                btn.classList.add('border-transparent', 'text-gray-500');
            });
            
            tabPanes.forEach(pane => {
                pane.classList.add('hidden');
                pane.classList.remove('active');
            });

            // Add active class to clicked button
            this.classList.add('border-blue-500', 'text-blue-600', 'bg-blue-50');
            this.classList.remove('border-transparent', 'text-gray-500');

            // Show target pane
            const targetPane = document.querySelector(`[data-tab-content="${targetTab}"]`);
            if (targetPane) {
                targetPane.classList.remove('hidden');
                targetPane.classList.add('active');
            }
        });
    });
}
</script>
@endpush