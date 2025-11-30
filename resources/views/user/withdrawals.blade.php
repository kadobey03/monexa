@extends('layouts.master', ['layoutType' => 'dashboard'])
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-2 sm:py-3 md:py-4" id="withdrawalsContainer">
    <div class="w-full max-w-6xl mx-auto px-2 sm:px-3 md:px-4">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 sm:mb-8 gap-4">
            <div class="text-center sm:text-left">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-600 bg-clip-text text-transparent">{{ __('user.withdrawals.page_title') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm sm:text-base">{{ __('user.withdrawals.page_subtitle') }}</p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-white/80 hover:bg-white dark:bg-gray-800/80 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm text-sm sm:text-base">
                <x-heroicon name="arrow-left" class="w-4 h-4 sm:w-5 sm:h-5" />
                <span class="hidden sm:inline">{{ __('user.withdrawals.back_to_dashboard') }}</span>
                <span class="sm:hidden">Back</span>
            </a>
        </div>

        <!-- Alert Messages -->
        <x-danger-alert />
        <x-success-alert />

        <!-- Breadcrumbs -->
        <nav class="flex mb-4 sm:mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs sm:text-sm text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                        <x-heroicon name="home" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" />
                        {{ __('user.withdrawals.home') }}
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-heroicon name="chevron-right" class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 mx-1" />
                        <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ __('user.withdrawals.withdrawals') }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        @if(Auth::user()->withdrawal_code === 'on')
            <!-- Withdrawal Code Required Section -->
            <div class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-700/50 max-w-4xl mx-auto backdrop-blur-sm">
                <div class="p-4 sm:p-6 lg:p-8 border-b border-gray-700/50">
                    <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                        <div class="p-3 sm:p-4 bg-gradient-to-br from-amber-500/20 to-orange-500/20 rounded-xl backdrop-blur-sm">
                            <x-heroicon name="shield-check" class="w-6 h-6 sm:w-8 sm:h-8 text-amber-400" />
                        </div>
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-white">{{ __('user.withdrawals.security_verification_required') }}</h2>
                            <p class="text-gray-300 mt-1 text-sm sm:text-base">{{ __('user.withdrawals.additional_verification_needed') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-6 lg:p-8">
                    <!-- Enhanced Warning Message -->
                    <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 border-l-4 border-amber-500 p-4 sm:p-6 mb-6 sm:mb-8 rounded-lg backdrop-blur-sm">
                        <div class="flex flex-col sm:flex-row">
                            <div class="flex-shrink-0 mb-3 sm:mb-0">
                                <x-heroicon name="information-circle" class="h-5 w-5 sm:h-6 sm:w-6 text-amber-400" aria-hidden="true" />
                            </div>
                            <div class="sm:ml-4 flex-1">
                                <div class="text-sm sm:text-base font-medium text-amber-300 mb-2">
                                    {{ __('user.withdrawals.withdrawal_code_required') }}
                                </div>
                                <p class="text-xs sm:text-sm text-amber-200 leading-relaxed">
                                    {{ __('user.withdrawals.security_code_description') }}
                                    <a href="mailto:{{$settings->contact_email}}" class="font-semibold underline hover:text-amber-100 transition-colors">{{$settings->contact_email}}</a>
                                    {{ __('user.withdrawals.get_verification_code') }}
                                </p>
                                <button onclick="toggleCodeInfo()" class="mt-3 flex items-center text-xs sm:text-sm font-medium text-amber-300 hover:text-amber-200 transition-colors">
                                    <span id="codeInfoToggleText">{{ __('user.withdrawals.learn_about_security') }}</span>
                                    <x-heroicon name="chevron-down" class="ml-1 w-3 h-3 sm:w-4 sm:h-4" id="codeInfoToggleIcon" />
                                </button>
                                <div id="codeInfoContent" class="mt-3 p-3 sm:p-4 bg-amber-500/10 rounded-lg text-xs sm:text-sm text-amber-200 transition ease-out duration-200 opacity-0 transform -translate-y-2" style="display: none;">
                                    <p class="font-medium mb-2">{{ __('user.withdrawals.why_codes_required') }}</p>
                                    <ul class="space-y-1 text-xs">
                                        <li>• {{ __('user.withdrawals.advanced_security') }}</li>
                                        <li>• {{ __('user.withdrawals.verify_legitimate_requests') }}</li>
                                        <li>• {{ __('user.withdrawals.additional_protection') }}</li>
                                        <li>• {{ __('user.withdrawals.compliance_regulations') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Withdrawal Code Form -->
                    <div class="bg-gray-800/50 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                        <form action="{{ route('userwithdrawal') }}" method="post" class="space-y-4 sm:space-y-6">
                            @csrf
                            <div>
                                <label for="withdrawal_code" class="block text-sm font-semibold text-gray-200 mb-3">
                                    {{ __('user.withdrawals.enter_verification_code') }}
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <x-heroicon name="shield-check" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" />
                                    </div>
                                    <input type="text"
                                           name="withdrawal_code"
                                           id="withdrawal_code"
                                           required
                                           placeholder="{{ __('user.withdrawals.code_placeholder') }}"
                                           class="pl-10 sm:pl-12 block w-full rounded-xl border-gray-600/50 bg-gray-800/50 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-white text-sm sm:text-base py-3 sm:py-4 transition-all duration-200 backdrop-blur-sm"
                                    />
                                </div>
                                <p class="mt-2 text-xs text-gray-400">{{ __('user.withdrawals.code_provided_by_support') }}</p>
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center items-center gap-2 py-3 sm:py-4 px-4 sm:px-6 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] text-sm sm:text-base">
                                <x-heroicon name="check-circle" class="h-4 w-4 sm:h-5 sm:w-5" />
                                <span>{{ __('user.withdrawals.verify_and_continue') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

@else
        <!-- Withdrawal Method Selection -->
        <div class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-700/50 w-full mb-4 sm:mb-6 backdrop-blur-sm">
            <div class="p-4 sm:p-6 lg:p-8 border-b border-gray-700/50">
                <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                    <div class="p-3 sm:p-4 bg-gradient-to-br from-blue-500/20 to-indigo-500/20 rounded-xl backdrop-blur-sm">
                        <x-heroicon name="credit-card" class="w-6 h-6 sm:w-8 sm:h-8 text-blue-400" />
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-white">{{ __('user.withdrawals.select_withdrawal_method') }}</h2>
                        <p class="text-gray-300 mt-1 text-sm sm:text-base">{{ __('user.withdrawals.choose_payment_method') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 lg:p-8">
                <form method="POST" action="{{ route('withdrawamount') }}" class="space-y-6 sm:space-y-8">
                    @csrf

                    <!-- Enhanced Withdrawal Method Selector -->
                    <div>
                        <label for="method" class="block text-sm font-semibold text-gray-200 mb-3 sm:mb-4">
                            {{ __('user.withdrawals.payment_method') }}
                        </label>
                        <div class="relative">
                            <select
                                name="method"
                                id="method"
                                required
                                onchange="handleMethodSelection(this.value)"
                                class="appearance-none block w-full pl-4 pr-12 py-3 sm:py-4 border border-gray-600/50 bg-gray-800/50 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white text-sm sm:text-base transition-all duration-200 backdrop-blur-sm"
                            >
                                <option value="" disabled selected>{{ __('user.withdrawals.select_method_placeholder') }}</option>
                                @forelse ($wmethods as $method)
                                    <option value="{{$method->name}}">{{$method->name}}</option>
                                @empty
                                    <option value="" disabled>{{ __('user.withdrawals.no_methods_available') }}</option>
                                @endforelse
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <x-heroicon name="chevron-down" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" />
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Method Details Card -->
                    <div id="methodDetailsCard" class="bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-xl p-4 sm:p-6 border border-blue-500/30 backdrop-blur-sm transition ease-out duration-300 opacity-0 transform scale-95" style="display: none;">
                        <div class="flex flex-col sm:flex-row items-start gap-4">
                            <!-- Enhanced Dynamic icon based on method -->
                            <div class="p-3 rounded-xl shadow-sm mx-auto sm:mx-0 bg-gray-500/20" id="methodIconContainer">
                                <x-heroicon name="credit-card" class="w-5 h-5 sm:w-6 sm:h-6 text-gray-400" id="methodIcon" />
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <h3 class="font-semibold text-white text-base sm:text-lg" id="methodTitle">{{ __('user.withdrawals.withdrawal') }}</h3>
                                <p class="text-xs sm:text-sm text-gray-300 mt-1" id="methodDescription">{{ __('user.withdrawals.method_selected_as_preferred') }}</p>
                                <div class="mt-3 flex items-center justify-center sm:justify-start gap-2 text-xs text-blue-400">
                                    <x-heroicon name="shield-check" class="w-3 h-3 sm:w-4 sm:h-4" />
                                    <span>{{ __('user.withdrawals.secure_encrypted_transaction') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 sm:gap-3 py-3 sm:py-4 px-4 sm:px-6 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] text-sm sm:text-base">
                        <x-heroicon name="arrow-right" class="h-4 w-4 sm:h-5 sm:w-5" />
                        <span>{{ __('user.withdrawals.proceed_to_withdrawal') }}</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Enhanced Withdrawal History -->
        <div class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-700/50 w-full backdrop-blur-sm">
            <div class="p-4 sm:p-6 lg:p-8 border-b border-gray-700/50">
                <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                    <div class="p-3 sm:p-4 bg-gradient-to-br from-indigo-500/20 to-blue-500/20 rounded-xl backdrop-blur-sm">
                        <x-heroicon name="history" class="w-6 h-6 sm:w-8 sm:h-8 text-indigo-400" />
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl sm:text-2xl font-bold text-white">{{ __('user.withdrawals.withdrawal_history') }}</h2>
                        <p class="text-gray-300 mt-1 text-sm sm:text-base">{{ __('user.withdrawals.track_withdrawal_requests') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 lg:p-8">
                <div class="overflow-hidden rounded-xl border border-gray-700/50 shadow-sm backdrop-blur-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-gray-800/50 to-gray-700/50">
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">{{ __('user.withdrawals.amount') }}</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">{{ __('user.withdrawals.date') }}</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider hidden sm:table-cell">{{ __('user.withdrawals.method') }}</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-300 uppercase tracking-wider">{{ __('user.withdrawals.status') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-900/50 divide-y divide-gray-700/50">
                                @forelse ($withdrawals as $withdrawal)
                                    <tr class="hover:bg-gray-800/30 transition-all duration-200">
                                        <td class="px-3 sm:px-6 py-4 sm:py-5 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="p-1.5 sm:p-2 bg-gray-800/50 rounded-lg mr-2 sm:mr-3 hidden sm:block">
                                                    <x-heroicon name="banknote" class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400" />
                                                </div>
                                                <div>
                                                    <div class="text-sm sm:text-base font-semibold text-white">{{Auth::user()->currency}}{{ number_format($withdrawal->amount, 2, '.', ',') }}</div>
                                                    <div class="text-xs text-gray-400 hidden sm:block">{{ __('user.withdrawals.withdrawal_amount') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 sm:py-5 whitespace-nowrap">
                                            <div class="text-xs sm:text-sm text-white font-medium">{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('H:i A') }}</div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 sm:py-5 whitespace-nowrap hidden sm:table-cell">
                                            <div class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                                <x-heroicon name="question-mark-circle" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" />
                                                {{ $withdrawal->payment_mode }}
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 sm:py-5 whitespace-nowrap">
                                            @if($withdrawal->status=='Pending')
                                                <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium bg-yellow-500/20 text-yellow-300 border border-yellow-500/30">
                                                    <x-heroicon name="clock" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" />
                                                    <span class="hidden sm:inline">{{ __('user.withdrawals.pending') }}</span>
                                                    <span class="sm:hidden">{{ __('user.withdrawals.pending') }}</span>
                                                </span>
                                            @elseif($withdrawal->status=='Rejected')
                                                <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium bg-red-500/20 text-red-300 border border-red-500/30">
                                                    <x-heroicon name="x-circle" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" />
                                                    <span class="hidden sm:inline">{{ __('user.withdrawals.rejected') }}</span>
                                                    <span class="sm:hidden">{{ __('user.withdrawals.rejected') }}</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-medium bg-green-500/20 text-green-300 border border-green-500/30">
                                                    <x-heroicon name="check-circle" class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" />
                                                    <span class="hidden sm:inline">{{ __('user.withdrawals.completed') }}</span>
                                                    <span class="sm:hidden">{{ __('user.withdrawals.completed') }}</span>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-3 sm:px-6 py-8 sm:py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="p-3 sm:p-4 bg-gray-800/50 rounded-full mb-3 sm:mb-4">
                                                    <x-heroicon name="inbox" class="w-6 h-6 sm:w-8 sm:h-8 text-gray-500" />
                                                </div>
                                                <h3 class="text-base sm:text-lg font-medium text-white mb-1">{{ __('user.withdrawals.no_withdrawals_yet') }}</h3>
                                                <p class="text-sm text-gray-400">{{ __('user.withdrawals.history_will_appear') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
    @parent
    <script>
        // Withdrawals page state
        let withdrawalsState = {
            showCodeInfo: false,
            selectedMethod: ''
        };

        document.addEventListener('DOMContentLoaded', function() {

            console.log('Withdrawals page initialized');
        });

        // Toggle code info section
        function toggleCodeInfo() {
            withdrawalsState.showCodeInfo = !withdrawalsState.showCodeInfo;
            
            const content = document.getElementById('codeInfoContent');
            const toggleText = document.getElementById('codeInfoToggleText');
            const toggleIcon = document.getElementById('codeInfoToggleIcon');
            
            if (withdrawalsState.showCodeInfo) {
                // Show content
                content.style.display = 'block';
                setTimeout(() => {
                    content.classList.remove('opacity-0', '-translate-y-2');
                    content.classList.add('opacity-100', 'translate-y-0');
                }, 10);
                
                // Update text and icon
                toggleText.textContent = '{{ __("user.withdrawals.hide_security_details") }}';
                // Heroicon: toggleIcon icon changed to chevron-up;
            } else {
                // Hide content
                content.classList.remove('opacity-100', 'translate-y-0');
                content.classList.add('opacity-0', '-translate-y-2');
                setTimeout(() => {
                    content.style.display = 'none';
                }, 200);
                
                // Update text and icon
                toggleText.textContent = '{{ __("user.withdrawals.learn_about_security") }}';
                // Heroicon: toggleIcon icon changed to chevron-down;
            }

        }

        // Handle payment method selection
        function handleMethodSelection(method) {
            withdrawalsState.selectedMethod = method;
            
            const detailsCard = document.getElementById('methodDetailsCard');
            const iconContainer = document.getElementById('methodIconContainer');
            const methodIcon = document.getElementById('methodIcon');
            const methodTitle = document.getElementById('methodTitle');
            const methodDescription = document.getElementById('methodDescription');
            
            if (method && method !== '') {
                // Update method details
                methodTitle.textContent = method + ' {{ __("user.withdrawals.withdrawal") }}';
                methodDescription.textContent = method + ' {{ __("user.withdrawals.method_selected_as_preferred") }}';
                
                // Update icon and colors based on method
                let iconName = 'credit-card';
                let iconColor = 'text-gray-400';
                let bgColor = 'bg-gray-500/20';
                
                switch(method) {
                    case 'Bitcoin':
                        iconName = 'bitcoin';
                        iconColor = 'text-orange-400';
                        bgColor = 'bg-orange-500/20';
                        break;
                    case 'Ethereum':
                        iconName = 'zap';
                        iconColor = 'text-blue-400';
                        bgColor = 'bg-blue-500/20';
                        break;
                    case 'Bank Transfer':
                        iconName = 'building-bank';
                        iconColor = 'text-green-400';
                        bgColor = 'bg-green-500/20';
                        break;
                    case 'USDT':
                        iconName = 'circle-dollar-sign';
                        iconColor = 'text-blue-400';
                        bgColor = 'bg-blue-500/20';
                        break;
                }
                
                // Update icon
                methodIcon.className = `w-5 h-5 sm:w-6 sm:h-6 ${iconColor}`;
                
                // Update container background
                iconContainer.className = `p-3 rounded-xl shadow-sm mx-auto sm:mx-0 ${bgColor}`;
                
                // Show details card with animation
                detailsCard.style.display = 'block';
                setTimeout(() => {
                    detailsCard.classList.remove('opacity-0', 'scale-95');
                    detailsCard.classList.add('opacity-100', 'scale-100');
                }, 10);

            } else {
                // Hide details card
                detailsCard.classList.remove('opacity-100', 'scale-100');
                detailsCard.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    detailsCard.style.display = 'none';
                }, 300);
            }
        }
    </script>
@endsection
