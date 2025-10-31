@php
    $sub_link = 'https://trade.mql5.com/trade';
@endphp

\@extends('layouts.dashly1')
@section('title', $title)
@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Trading Accounts</h1>
            <p class="text-gray-300">Manage your automated trading subscriptions</p>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <!-- Introduction Card -->
            <div class="bg-gradient-to-br from-blue-900/50 to-purple-900/50 backdrop-blur-sm rounded-2xl p-8 border border-blue-500/20 mb-8">
                <div class="flex items-start gap-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-robot text-2xl text-white"></i>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-white mb-4">{{ $settings->site_name }} Account Manager</h2>
                        <p class="text-gray-300 leading-relaxed mb-4">
                            Don't have time to trade or learn how to trade? Our Account Management Service is The Best Profitable Trading Option for you.
                            We can help you manage your account in the financial market with a simple subscription model.
                        </p>
                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            <div class="flex items-center gap-2 text-sm text-gray-400">
                                <i class="fas fa-info-circle text-blue-400"></i>
                                <span>Terms and Conditions apply</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-400">
                                <i class="fas fa-envelope text-green-400"></i>
                                <span>{{ $settings->contact_email }}</span>
                            </div>
                        </div>
                        <button data-toggle="modal" data-target="#submitmt4modal"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-plus-circle"></i>
                            Subscribe Now
                        </button>
                    </div>
                </div>
            </div>
            <!-- Subscriptions Section -->
            <div class="bg-gray-900/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white">My Trading Accounts</h3>
                </div>
                
                @forelse ($subscriptions as $sub)
                <!-- Trading Account Card -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-700/50 p-6 mb-6 hover:border-blue-500/30 transition-all duration-300">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h4 class="text-lg font-semibold text-white mb-2">Account {{ $sub->mt4_id }} • {{ $sub->account_type }}</h4>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $sub->status === 'Active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' :
                                       ($sub->status === 'Expired' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' :
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400') }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-2
                                        {{ $sub->status === 'Active' ? 'bg-green-400' :
                                           ($sub->status === 'Expired' ? 'bg-red-400' : 'bg-yellow-400') }}"></span>
                                    {{ $sub->status }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-400">Currency</div>
                            <div class="text-white font-medium">{{ $sub->currency }}</div>
                        </div>
                    </div>

                    <!-- Account Details Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-gray-700/30 rounded-lg p-3">
                            <div class="text-xs text-gray-400 mb-1">Leverage</div>
                            <div class="text-white font-medium">{{ $sub->leverage }}</div>
                        </div>
                        <div class="bg-gray-700/30 rounded-lg p-3">
                            <div class="text-xs text-gray-400 mb-1">Server</div>
                            <div class="text-white font-medium">{{ $sub->server }}</div>
                        </div>
                        <div class="bg-gray-700/30 rounded-lg p-3">
                            <div class="text-xs text-gray-400 mb-1">Duration</div>
                            <div class="text-white font-medium">{{ $sub->duration }}</div>
                        </div>
                        <div class="bg-gray-700/30 rounded-lg p-3">
                            <div class="text-xs text-gray-400 mb-1">Password</div>
                            <div class="text-white font-medium">•••••••</div>
                        </div>
                        <div class="bg-gray-700/30 rounded-lg p-3">
                            <div class="text-xs text-gray-400 mb-1">Submitted</div>
                            <div class="text-white font-medium">{{ \Carbon\Carbon::parse($sub->created_at)->format('M j, Y') }}</div>
                        </div>
                        <div class="bg-gray-700/30 rounded-lg p-3">
                            <div class="text-xs text-gray-400 mb-1">Expires</div>
                            <div class="text-white font-medium">
                                @if (!empty($sub->end_date))
                                    {{ \Carbon\Carbon::parse($sub->end_date)->format('M j, Y') }}
                                @else
                                    Not started
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-3">
                        @php
                            $endAt = \Carbon\Carbon::parse($sub->end_date);
                            $remindAt = \Carbon\Carbon::parse($sub->reminded_at);
                        @endphp
                        <button onclick="deletemt4()"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 hover:text-red-300 rounded-lg border border-red-500/30 hover:border-red-500/50 transition-all duration-200">
                            <i class="fas fa-times text-sm"></i>
                            Cancel
                        </button>
                        @if (($sub->status != 'Pending' && now()->isSameDay($remindAt)) || $sub->status == 'Expired')
                        <a href="{{ route('renewsub', $sub->id) }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-green-600/20 hover:bg-green-600/30 text-green-400 hover:text-green-300 rounded-lg border border-green-500/30 hover:border-green-500/50 transition-all duration-200">
                            <i class="fas fa-refresh text-sm"></i>
                            Renew
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-line text-4xl text-gray-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">No Trading Accounts</h3>
                    <p class="text-gray-400 mb-6">You don't have any trading accounts at the moment.</p>
                    <button data-toggle="modal" data-target="#submitmt4modal"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200">
                        <i class="fas fa-plus"></i>
                        Add Your First Account
                    </button>
                </div>
                @endforelse
            </div>
        </div>
        <!-- Trading Platform Integration -->
        <div class="bg-gray-900/50 backdrop-blur-sm rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-desktop text-white"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">Trading Platform</h3>
                    <p class="text-gray-400 text-sm">Monitor your trading activities in real-time</p>
                </div>
            </div>
            
            <div class="bg-gray-800/50 rounded-xl p-4 mb-4">
                <div class="flex items-center gap-2 text-sm text-gray-300 mb-2">
                    <i class="fas fa-info-circle text-blue-400"></i>
                    <span>Connect to your trading account to monitor activities on your trading account(s).</span>
                </div>
            </div>
            
            <!-- Trading Platform Frame -->
            <div class="relative bg-gray-800 rounded-xl overflow-hidden border border-gray-700">
                <div class="absolute top-0 left-0 right-0 h-10 bg-gray-900 flex items-center gap-2 px-4 border-b border-gray-700">
                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <div class="flex-1 text-center">
                        <span class="text-gray-400 text-sm font-medium">MQL5 WebTrader</span>
                    </div>
                </div>
                <iframe src="{{ $sub_link }}" name="WebTrader" title="{{ $title }}" frameborder="0"
                        class="w-full" style="display: block; height: 70vh; margin-top: 40px;"></iframe>
            </div>
        </div>
    </div>
    
    @include('user.modals')
    <script type="text/javascript">
        function deletemt4() {
            swal({
                title: "Error!",
                text: "Send an Email to {{ $settings->contact_email }} to have your MT4 Details cancelled.",
                icon: "error",
                buttons: {
                    confirm: {
                        text: "Okay",
                        value: true,
                        visible: true,
                        className: "btn btn-danger",
                        closeModal: true
                    }
                }
            });
        }
    </script>
@endsection
