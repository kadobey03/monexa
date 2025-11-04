@extends('layouts.dasht')
@section('title', $title)
@section('content')

<!-- Trade Signal Subscription Page -->
<div class="space-y-6" id="signalsSubscriptionApp">

    <!-- Page Header -->
    <div class="bg-gray-900 rounded-2xl p-6 border border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                    <x-heroicon name="radio" class="w-6 h-6 text-blue-400" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Trade Signals</h1>
                    <p class="text-gray-400">Premium trading signals and market insights</p>
                </div>
            </div>

            <!-- Signal Status Badge -->
            @if ($subscription)
                <div class="flex items-center gap-2 bg-green-500/10 border border-green-500/20 rounded-full px-4 py-2">
                    <x-heroicon name="check-circle" class="w-4 h-4 text-green-400" />
                    <span class="text-green-300 text-sm font-bold">Active Subscription</span>
                </div>
            @else
                <div class="flex items-center gap-2 bg-yellow-500/10 border border-yellow-500/20 rounded-full px-4 py-2">
                    <x-heroicon name="clock" class="w-4 h-4 text-yellow-400" />
                    <span class="text-yellow-300 text-sm font-bold">No Active Subscription</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Alert Messages -->
    <x-danger-alert />
    <x-success-alert />

    @if (!$subscription)
        <!-- No Subscription State -->
        <div class="bg-gray-900 rounded-2xl border border-gray-700 overflow-hidden">
            <div class="p-8 text-center">
                <!-- Illustration -->
                <div class="mx-auto w-24 h-24 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-full flex items-center justify-center mb-6">
                    <x-heroicon name="arrow-trending-up" class="w-12 h-12 text-blue-400" />
                </div>

                <h3 class="text-2xl font-bold text-white mb-4">Unlock Premium Trading Signals</h3>
                <p class="text-gray-400 mb-8 max-w-md mx-auto">
                    Get access to expert trading signals, market analysis, and real-time notifications to enhance your trading strategy.
                </p>

                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700">
                        <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <x-heroicon name="bolt" class="w-5 h-5 text-blue-400" />
                        </div>
                        <h4 class="text-white font-bold text-sm mb-2">Real-time Signals</h4>
                        <p class="text-gray-400 text-xs">Instant notifications for trading opportunities</p>
                    </div>

                    <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700">
                        <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <x-heroicon name="bar-chart-3" class="w-5 h-5 text-green-400" />
                        </div>
                        <h4 class="text-white font-bold text-sm mb-2">Market Analysis</h4>
                        <p class="text-gray-400 text-xs">Expert insights and market trends</p>
                    </div>

                    <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700">
                        <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <x-heroicon name="shield-check" class="w-5 h-5 text-purple-400" />
                        </div>
                        <h4 class="text-white font-bold text-sm mb-2">Risk Management</h4>
                        <p class="text-gray-400 text-xs">Strategic risk assessment and guidance</p>
                    </div>
                </div>

                <!-- Subscribe Button -->
                <button
                    onclick="signalApp.showSubscribeModal()"
                    class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-8 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-blue-500/25 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                >
                    <span class="flex items-center gap-2">
                        <x-heroicon name="star" class="w-5 h-5" />
                        Subscribe to Premium Signals
                    </span>
                </button>
            </div>
        </div>
    @else
        <!-- Active Subscription State -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Subscription Details Card -->
            <div class="lg:col-span-2 bg-gray-900 rounded-2xl p-6 border border-gray-700">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-xl font-bold text-white">{{ $subscription->subscription }} Subscription</h3>
                            <div class="bg-green-500/10 border border-green-500/20 rounded-full px-3 py-1">
                                <span class="text-green-300 text-xs font-bold">ACTIVE</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-2xl font-bold text-blue-400">
                            <span>{{ $settings->currency }}{{ number_format($subscription->amount_paid, 2) }}</span>
                        </div>
                        <p class="text-gray-400 text-sm">Amount paid for current subscription</p>
                    </div>

                    <div class="text-right">
                        <div class="bg-orange-500/10 border border-orange-500/20 rounded-lg px-3 py-2 mb-2">
                            <span class="text-orange-300 text-xs font-bold">EXPIRES</span>
                        </div>
                        <p class="text-white font-semibold text-sm">
                            {{ \Carbon\Carbon::parse($subscription->expired_at)->format('M d, Y') }}
                        </p>
                        <p class="text-gray-400 text-xs">
                            {{ \Carbon\Carbon::parse($subscription->expired_at)->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <!-- Subscription Benefits -->
                <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700 mb-6">
                    <h4 class="text-white font-bold text-sm mb-3 flex items-center gap-2">
                        <x-heroicon name="star" class="w-4 h-4 text-yellow-400" />
                        Your Benefits
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center gap-3">
                            <x-heroicon name="check-circle" class="w-4 h-4 text-green-400" />
                            <span class="text-gray-300 text-sm">Real-time trading signals</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-heroicon name="check-circle" class="w-4 h-4 text-green-400" />
                            <span class="text-gray-300 text-sm">Market analysis reports</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-heroicon name="check-circle" class="w-4 h-4 text-green-400" />
                            <span class="text-gray-300 text-sm">Risk management alerts</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-heroicon name="check-circle" class="w-4 h-4 text-green-400" />
                            <span class="text-gray-300 text-sm">24/7 signal access</span>
                        </div>
                    </div>
                </div>

                @if (now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($subscription->reminded_at)) or now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($subscription->expired_at)))
                    <!-- Renewal Section -->
                    <div class="bg-gradient-to-r from-yellow-500/10 to-orange-500/10 border border-yellow-500/20 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <x-heroicon name="exclamation-circle" class="w-5 h-5 text-yellow-400 mt-0.5" />
                            <div class="flex-1">
                                <h4 class="text-yellow-300 font-bold text-sm mb-1">Subscription Renewal Required</h4>
                                <p class="text-gray-300 text-sm mb-3">
                                    Your subscription is expiring soon. Renew now to continue receiving premium signals.
                                </p>
                                <button
                                    onclick="signalApp.showRenewalModal()"
                                    class="bg-gradient-to-r from-yellow-600 to-orange-600 hover:from-yellow-700 hover:to-orange-700 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 text-sm"
                                >
                                    <span class="flex items-center gap-2">
                                        <x-heroicon name="arrow-path" class="w-4 h-4" />
                                        Renew for
                                        @if ($subscription->subscription == 'Monthly')
                                            {{ $settings->currency }}{{ number_format($set->signal_monthly_fee, 2) }}
                                        @elseif ($subscription->subscription == 'Quarterly')
                                            {{ $settings->currency }}{{ number_format($set->signal_quarterly_fee, 2) }}
                                        @else
                                            {{ $settings->currency }}{{ number_format($set->signal_yearly_fee, 2) }}
                                        @endif
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Subscription Stats Card -->
            <div class="space-y-6">
                <!-- Usage Stats -->
                <div class="bg-gray-900 rounded-2xl p-6 border border-gray-700">
                    <h4 class="text-white font-bold text-lg mb-4 flex items-center gap-2">
                        <x-heroicon name="activity" class="w-5 h-5 text-blue-400" />
                        Usage Statistics
                    </h4>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Signals Received</span>
                            <span class="text-white font-bold">847</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Success Rate</span>
                            <span class="text-green-400 font-bold">78.5%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">This Month</span>
                            <span class="text-white font-bold">127</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gray-900 rounded-2xl p-6 border border-gray-700">
                    <h4 class="text-white font-bold text-lg mb-4 flex items-center gap-2">
                        <x-heroicon name="cog-6-tooth" class="w-5 h-5 text-purple-400" />
                        Quick Actions
                    </h4>

                    <div class="space-y-3">
                        <button class="w-full bg-gray-800 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 text-sm flex items-center gap-2">
                            <x-heroicon name="bell" class="w-4 h-4" />
                            Notification Settings
                        </button>
                        <button class="w-full bg-gray-800 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 text-sm flex items-center gap-2">
                            <x-heroicon name="arrow-down-tray" class="w-4 h-4" />
                            Download History
                        </button>
                        <button class="w-full bg-gray-800 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 text-sm flex items-center gap-2">
                            <x-heroicon name="question-mark-circle" class="w-4 h-4" />
                            Get Support
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Subscribe Modal -->
    <div id="subscribeModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-all duration-300 opacity-0" style="display: none;">

        <div id="subscribeModalContent" class="bg-gray-900 rounded-2xl border border-gray-700 w-full max-w-md max-h-[80vh] overflow-y-auto transition-all duration-300 opacity-0 scale-95">

            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-700">
                <h3 class="text-xl font-bold text-white">Subscribe to Premium Signals</h3>
                <button onclick="signalApp.closeSubscribeModal()"
                        class="text-gray-400 hover:text-white transition-colors duration-200">
                    <x-heroicon name="x-mark" class="w-6 h-6" />
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <livewire:user.subscribe-to-signal />
            </div>
        </div>
    </div>

    @if ($subscription && (now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($subscription->reminded_at)) or now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($subscription->expired_at))))
        <!-- Renewal Modal -->
        <div id="renewalModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-all duration-300 opacity-0" style="display: none;">

            <div id="renewalModalContent" class="bg-gray-900 rounded-2xl border border-gray-700 w-full max-w-md transition-all duration-300 opacity-0 scale-95">

                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-700">
                    <h3 class="text-xl font-bold text-white">Renew Subscription</h3>
                    <button onclick="signalApp.closeRenewalModal()"
                            class="text-gray-400 hover:text-white transition-colors duration-200">
                        <x-heroicon name="x-mark" class="w-6 h-6" />
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-yellow-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-heroicon name="arrow-path" class="w-8 h-8 text-yellow-400" />
                        </div>
                        <h4 class="text-lg font-bold text-white mb-2">Renew Your Subscription</h4>
                        <p class="text-gray-400 text-sm">
                            @if ($subscription->subscription == 'Monthly')
                                {{ $settings->currency }}{{ number_format($set->signal_monthly_fee, 2) }}
                            @elseif ($subscription->subscription == 'Quarterly')
                                {{ $settings->currency }}{{ number_format($set->signal_quarterly_fee, 2) }}
                            @else
                                {{ $settings->currency }}{{ number_format($set->signal_yearly_fee, 2) }}
                            @endif
                            will be deducted from your account balance to renew your {{ $subscription->subscription }} subscription.
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button onclick="signalApp.closeRenewalModal()"
                                class="flex-1 bg-gray-800 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-xl transition-all duration-200">
                            Cancel
                        </button>
                        <a href="{{ route('renewsignals') }}"
                           class="flex-1 bg-gradient-to-r from-yellow-600 to-orange-600 hover:from-yellow-700 hover:to-orange-700 text-white font-bold py-3 px-4 rounded-xl transition-all duration-200 text-center">
                            Confirm Renewal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Add Lucide Icons Script -->

<script>
// Signals Subscription Manager - Vanilla JavaScript
class SignalSubscriptionManager {
    constructor() {
        this.subscribeModal = null;
        this.renewalModal = null;
        this.init();
    }

    init() {
        this.subscribeModal = document.getElementById('subscribeModal');
        this.renewalModal = document.getElementById('renewalModal');
        this.bindEvents();
        this.initializeLucideIcons();
    }

    bindEvents() {
        // Click outside to close modals
        document.addEventListener('click', (e) => {
            if (e.target === this.subscribeModal) {
                this.closeSubscribeModal();
            }
            if (e.target === this.renewalModal) {
                this.closeRenewalModal();
            }
        });

        // Escape key to close modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeSubscribeModal();
                this.closeRenewalModal();
            }
        });
    }

    showSubscribeModal() {
        if (this.subscribeModal) {
            this.subscribeModal.style.display = 'flex';
            // Use requestAnimationFrame for smooth animation
            requestAnimationFrame(() => {
                this.subscribeModal.style.opacity = '1';
                const content = document.getElementById('subscribeModalContent');
                if (content) {
                    content.style.opacity = '1';
                    content.style.transform = 'scale(1)';
                }
            });
        }
    }

    closeSubscribeModal() {
        if (this.subscribeModal) {
            const content = document.getElementById('subscribeModalContent');
            if (content) {
                content.style.opacity = '0';
                content.style.transform = 'scale(0.95)';
            }
            this.subscribeModal.style.opacity = '0';
            
            setTimeout(() => {
                this.subscribeModal.style.display = 'none';
            }, 300);
        }
    }

    showRenewalModal() {
        if (this.renewalModal) {
            this.renewalModal.style.display = 'flex';
            requestAnimationFrame(() => {
                this.renewalModal.style.opacity = '1';
                const content = document.getElementById('renewalModalContent');
                if (content) {
                    content.style.opacity = '1';
                    content.style.transform = 'scale(1)';
                }
            });
        }
    }

    closeRenewalModal() {
        if (this.renewalModal) {
            const content = document.getElementById('renewalModalContent');
            if (content) {
                content.style.opacity = '0';
                content.style.transform = 'scale(0.95)';
            }
            this.renewalModal.style.opacity = '0';
            
            setTimeout(() => {
                this.renewalModal.style.display = 'none';
            }, 300);
        }
    }

    initializeLucideIcons() {
        if (typeof lucide !== 'undefined') {
            
        }
    }
}

// Global functions for onclick handlers
window.signalApp = null;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.signalApp = new SignalSubscriptionManager();
    
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        
    }
});
</script>

@endsection
