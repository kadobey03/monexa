{{-- Mobile Layout Component --}}
<div class="mobile-layout lg:hidden">
    {{-- Mobile Tabs Navigation --}}
    <div class="mobile-tabs border-b border-gray-200 mb-4">
        <nav class="flex">
            <button type="button"
                    class="mobile-tab-btn flex-1 py-3 px-1 text-center border-b-2 font-medium text-sm {{ $activeTab ?? 'overview' === 'overview' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                    data-tab="overview">
                Overview
            </button>
            <button type="button"
                    class="mobile-tab-btn flex-1 py-3 px-1 text-center border-b-2 font-medium text-sm {{ $activeTab ?? 'overview' === 'notes' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                    data-tab="notes">
                Notes
            </button>
            <button type="button"
                    class="mobile-tab-btn flex-1 py-3 px-1 text-center border-b-2 font-medium text-sm {{ $activeTab ?? 'overview' === 'communication' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                    data-tab="communication">
                Comm.
            </button>
            <button type="button"
                    class="mobile-tab-btn flex-1 py-3 px-1 text-center border-b-2 font-medium text-sm {{ $activeTab ?? 'overview' === 'analytics' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                    data-tab="analytics">
                Analytics
            </button>
        </nav>
    </div>

    {{-- Mobile Tab Content --}}
    <div class="mobile-tab-content">
        {{-- Overview Tab --}}
        <div class="mobile-tab-panel {{ $activeTab ?? 'overview' === 'overview' ? '' : 'hidden' }}" data-tab="overview">
            {{-- Mobile Lead Header --}}
            <div class="mobile-lead-header bg-white rounded-lg shadow-md p-4 mb-4">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-900">{{ $lead->name }}</h2>
                        <p class="text-sm text-gray-600">{{ $lead->email }}</p>
                        @if($lead->phone)
                        <p class="text-sm text-gray-600">{{ $lead->phone }}</p>
                        @endif
                    </div>
                    <div class="flex flex-col items-end space-y-2">
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if($lead->status === 'hot') bg-red-100 text-red-800
                            @elseif($lead->status === 'warm') bg-yellow-100 text-yellow-800
                            @elseif($lead->status === 'cold') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($lead->status ?? 'new') }}
                        </span>
                        @if(isset($scoreData))
                        <div class="text-center">
                            <div class="text-lg font-bold text-blue-600">{{ $scoreData['score'] ?? 0 }}</div>
                            <div class="text-xs text-gray-500">Score</div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="grid grid-cols-2 gap-3">
                    <button type="button"
                            class="mobile-quick-action-btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out"
                            data-action="call">
                        <i class="fas fa-phone mr-1"></i>
                        Call
                    </button>
                    <button type="button"
                            class="mobile-quick-action-btn bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out"
                            data-action="email">
                        <i class="fas fa-envelope mr-1"></i>
                        Email
                    </button>
                    <button type="button"
                            class="mobile-quick-action-btn bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out"
                            data-action="note">
                        <i class="fas fa-sticky-note mr-1"></i>
                        Note
                    </button>
                    <button type="button"
                            class="mobile-quick-action-btn bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out"
                            data-action="meeting">
                        <i class="fas fa-calendar mr-1"></i>
                        Meeting
                    </button>
                </div>
            </div>

            {{-- Mobile Dashboard Grid --}}
            <div class="mobile-dashboard-grid space-y-4">
                {{-- Key Metrics --}}
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Key Metrics</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $lead->score ?? 0 }}</div>
                            <div class="text-sm text-gray-600">Lead Score</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $performanceMetrics['engagement_rate'] ?? 0 }}%</div>
                            <div class="text-sm text-gray-600">Engagement</div>
                        </div>
                    </div>
                </div>

                {{-- Recent Activity --}}
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
                    <div class="space-y-3">
                        @if(isset($mobileData['recent_activities']) && count($mobileData['recent_activities']) > 0)
                            @foreach($mobileData['recent_activities'] as $activity)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas {{ $activity['icon'] ?? 'fa-circle' }} text-blue-600 text-xs"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $activity['timestamp'] ?? now()->diffForHumans() }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-500 text-center py-4">No recent activity</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Notes Tab --}}
        <div class="mobile-tab-panel {{ $activeTab ?? 'overview' === 'notes' ? '' : 'hidden' }}" data-tab="notes">
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Notes</h3>
                    <button type="button"
                            class="mobile-add-note-btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                        <i class="fas fa-plus mr-1"></i>
                        Add
                    </button>
                </div>

                <div class="space-y-3">
                    @if(isset($notes) && $notes->count() > 0)
                        @foreach($notes as $note)
                        <div class="note-item bg-gray-50 rounded-lg p-3">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-sm font-medium text-gray-900">{{ $note->title ?? 'Untitled' }}</span>
                                <span class="text-xs text-gray-500">{{ $note->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-sm text-gray-700">
                                {!! nl2br(e(Str::limit($note->content ?? '', 100))) !!}
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-sticky-note text-3xl mb-2"></i>
                            <p>No notes yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Communication Tab --}}
        <div class="mobile-tab-panel {{ $activeTab ?? 'overview' === 'communication' ? '' : 'hidden' }}" data-tab="communication">
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Communication</h3>
                    <button type="button"
                            class="mobile-send-comm-btn bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                        <i class="fas fa-paper-plane mr-1"></i>
                        Send
                    </button>
                </div>

                <div class="space-y-3">
                    @if(isset($communications) && $communications->count() > 0)
                        @foreach($communications as $communication)
                        <div class="communication-item bg-gray-50 rounded-lg p-3">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-sm font-medium text-gray-900">{{ $communication->subject ?? 'No Subject' }}</span>
                                <span class="px-2 py-1 {{ $communication->status === 'sent' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} text-xs rounded-full">
                                    {{ ucfirst($communication->status ?? 'pending') }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-700">
                                {!! nl2br(e(Str::limit($communication->content ?? '', 100))) !!}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">{{ $communication->created_at->diffForHumans() }}</div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-comments text-3xl mb-2"></i>
                            <p>No communications yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Analytics Tab --}}
        <div class="mobile-tab-panel {{ $activeTab ?? 'overview' === 'analytics' ? '' : 'hidden' }}" data-tab="analytics">
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Analytics</h3>

                {{-- Mobile Analytics Content --}}
                <div class="space-y-4">
                    {{-- Mini Chart Placeholder --}}
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <i class="fas fa-chart-line text-4xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600">Performance Chart</p>
                        <p class="text-xs text-gray-500">Interactive chart available on desktop</p>
                    </div>

                    {{-- Key Metrics for Mobile --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-lg text-center">
                            <div class="text-xl font-bold">{{ $lead->score ?? 0 }}</div>
                            <div class="text-sm opacity-90">Score</div>
                        </div>
                        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-lg text-center">
                            <div class="text-xl font-bold">{{ $performanceMetrics['conversion_rate'] ?? 0 }}%</div>
                            <div class="text-sm opacity-90">Conversion</div>
                        </div>
                    </div>

                    {{-- Insights --}}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-md font-medium text-gray-800 mb-3">Insights</h4>
                        <div class="space-y-2">
                            @if(isset($analyticsData['insights']) && count($analyticsData['insights']) > 0)
                                @foreach(array_slice($analyticsData['insights'], 0, 3) as $insight)
                                <div class="flex items-start space-x-2">
                                    <i class="fas {{ $insight['icon'] ?? 'fa-lightbulb' }} text-blue-500 mt-1"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $insight['title'] }}</p>
                                        <p class="text-xs text-gray-600">{{ Str::limit($insight['description'], 80) }}</p>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-lightbulb text-2xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-500">No insights available</p>
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
    const mobileLayout = {
        activeTab: '{{ $activeTab ?? 'overview' }}',

        init() {
            this.bindEvents();
        },

        bindEvents() {
            // Tab switching
            const tabButtons = document.querySelectorAll('.mobile-tab-btn');
            tabButtons.forEach(btn => {
                btn.addEventListener('click', (e) => this.switchTab(e));
            });

            // Quick actions
            const quickActionBtns = document.querySelectorAll('.mobile-quick-action-btn');
            quickActionBtns.forEach(btn => {
                btn.addEventListener('click', (e) => this.handleQuickAction(e));
            });

            // Mobile specific buttons
            const addNoteBtn = document.querySelector('.mobile-add-note-btn');
            if (addNoteBtn) {
                addNoteBtn.addEventListener('click', () => this.showNoteModal());
            }

            const sendCommBtn = document.querySelector('.mobile-send-comm-btn');
            if (sendCommBtn) {
                sendCommBtn.addEventListener('click', () => this.showCommunicationModal());
            }
        },

        switchTab(e) {
            const tabName = e.currentTarget.dataset.tab;
            const tabPanels = document.querySelectorAll('.mobile-tab-panel');
            const tabButtons = document.querySelectorAll('.mobile-tab-btn');

            // Hide all panels
            tabPanels.forEach(panel => panel.classList.add('hidden'));
            tabButtons.forEach(btn => {
                btn.classList.remove('border-blue-500', 'text-blue-600');
                btn.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected panel
            const selectedPanel = document.querySelector(`.mobile-tab-panel[data-tab="${tabName}"]`);
            const selectedButton = document.querySelector(`.mobile-tab-btn[data-tab="${tabName}"]`);

            if (selectedPanel) {
                selectedPanel.classList.remove('hidden');
            }
            if (selectedButton) {
                selectedButton.classList.remove('border-transparent', 'text-gray-500');
                selectedButton.classList.add('border-blue-500', 'text-blue-600');
            }

            this.activeTab = tabName;

            // Update URL hash for bookmarking
            if (window.history.replaceState) {
                window.history.replaceState(null, null, `#${tabName}`);
            }
        },

        handleQuickAction(e) {
            const action = e.currentTarget.dataset.action;

            switch(action) {
                case 'call':
                    if ({{ $lead->phone ? 'true' : 'false' }}) {
                        window.location.href = 'tel:{{ $lead->phone }}';
                    } else {
                        this.showMessage('No phone number available', 'warning');
                    }
                    break;
                case 'email':
                    window.location.href = 'mailto:{{ $lead->email }}';
                    break;
                case 'note':
                    this.showNoteModal();
                    break;
                case 'meeting':
                    this.showMessage('Meeting scheduling coming soon', 'info');
                    break;
            }
        },

        showNoteModal() {
            // Trigger the main notes system modal
            const addNoteBtn = document.querySelector('.add-note-btn');
            if (addNoteBtn) {
                addNoteBtn.click();
            } else {
                this.showMessage('Notes system not available', 'error');
            }
        },

        showCommunicationModal() {
            // Trigger the main communication modal
            const sendCommBtn = document.querySelector('.send-communication-btn');
            if (sendCommBtn) {
                sendCommBtn.click();
            } else {
                this.showMessage('Communication system not available', 'error');
            }
        },

        showMessage(message, type) {
            // Simple message display - you can enhance this with a proper notification system
            alert(message);
        }
    };

    // Initialize mobile layout
    mobileLayout.init();
});
</script>
@endpush