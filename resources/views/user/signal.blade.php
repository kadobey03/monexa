@extends('layouts.dasht')
@section('title', $title)
@section('content')
<!-- Signal Subscriptions Component -->
<div id="signalsApp" class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="mb-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-6" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    <x-heroicon name="home" class="w-4 h-4 inline mr-1" />
                    Dashboard
                </a>
                <x-heroicon name="chevron-right" class="w-4 h-4 mx-2" />
                <span class="text-gray-900 dark:text-gray-100 font-medium">Trading Signals</span>
            </nav>

            <!-- Page Title & Description -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        <x-heroicon name="signal" class="w-8 h-8 inline mr-3 text-blue-600 dark:text-blue-400" />
                        Premium Trading Signals
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">
                        Subscribe to professional trading signals and enhance your trading success
                    </p>
                </div>

                <!-- Stats Cards -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-4 shadow-sm ring-1 ring-gray-200 dark:ring-gray-800">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <x-heroicon name="arrow-trending-up" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ count($signals) }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Available Signals</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signals Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @forelse($signals as $signal)
            <!-- Signal Card -->
            <div class="group relative bg-white dark:bg-gray-900 rounded-2xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-800 hover:shadow-lg hover:ring-blue-300 dark:hover:ring-blue-700 transition-all duration-300 overflow-hidden">

                <!-- Signal Header -->
                <div class="relative p-6 pb-4">
                    <!-- Premium Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                            <x-heroicon name="star" class="w-3 h-3 mr-1" />
                            Premium
                        </span>
                    </div>

                    <!-- Signal Icon & Name -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl group-hover:scale-110 transition-transform duration-300">
                            <x-heroicon name="radio" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $signal->name }}</h3>
                    </div>

                    <!-- Pricing -->
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->currency }} {{ number_format($signal->price, 2) }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">/month</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Professional trading signals subscription</p>
                    </div>

                    <!-- Features -->
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-5 h-5 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <x-heroicon name="check" class="w-3 h-3 text-green-600 dark:text-green-400" />
                            </div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Success Rate: {{ $signal->increment_amount }}%</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-5 h-5 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <x-heroicon name="check" class="w-3 h-3 text-green-600 dark:text-green-400" />
                            </div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Real-time notifications</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-5 h-5 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <x-heroicon name="check" class="w-3 h-3 text-green-600 dark:text-green-400" />
                            </div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Expert analysis</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-5 h-5 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <x-heroicon name="check" class="w-3 h-3 text-green-600 dark:text-green-400" />
                            </div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">24/7 support</span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="p-6 pt-0">
                    <button onclick="signalManager.openSubscriptionModal('{{ $signal->id }}', '{{ $signal->name }}', '{{ $signal->price }}')"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                        <x-heroicon name="plus-circle" class="w-5 h-5 inline mr-2" />
                        Subscribe Now
                    </button>
                </div>

                <!-- Hover Effect Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-blue-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="col-span-full text-center py-16">
            <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6">
                <x-heroicon name="signal" class="w-12 h-12 text-gray-400" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Signals Available</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                There are currently no trading signals available. Please check back later for premium signal subscriptions.
            </p>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors">
                <x-heroicon name="arrow-left" class="w-5 h-5" />
                Back to Dashboard
            </a>
        </div>
            @endforelse
        </div>

        <!-- Subscription Modal -->
        <div id="subscriptionModal" class="fixed inset-0 z-50 overflow-y-auto transition-all duration-300 opacity-0" style="display: none;">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity"
                 onclick="signalManager.closeModal()"></div>

            <!-- Modal Content -->
            <div class="flex min-h-full items-end sm:items-center justify-center p-4 text-center sm:p-0">
                <div id="modalContent" class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-900 px-6 pt-6 pb-6 text-left shadow-2xl transition-all duration-300 opacity-0 scale-95 sm:my-8 sm:w-full sm:max-w-lg sm:p-8">

                    <!-- Modal Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <x-heroicon name="signal" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Subscribe to Signal</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400" id="selectedSignalName"></p>
                            </div>
                        </div>
                        <button onclick="signalManager.closeModal()"
                                class="rounded-lg p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <x-heroicon name="x-mark" class="w-6 h-6" />
                        </button>
                    </div>

                    <!-- Subscription Form -->
                    <form method="POST" action="{{ route('newdeposit') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="asset" id="hiddenAssetName">

                        <!-- Payment Method Selection -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">
                                <x-heroicon name="credit-card" class="w-4 h-4 inline mr-2" />
                                Payment Method
                            </label>
                            <select name="payment_method"
                                    required
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all">
                                <option value="" selected disabled>Choose Payment Method</option>
                                @forelse($dmethods as $method)
                                <option value="{{ $method->name }}">{{ $method->name }}</option>
                                @empty
                                <option disabled>No Payment Method available at the moment</option>
                                @endforelse
                            </select>
                        </div>

                        <!-- Amount Display -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">
                                <x-heroicon name="currency-dollar" class="w-4 h-4 inline mr-2" />
                                Subscription Amount ({{ Auth::user()->currency }})
                            </label>
                            <div class="relative">
                                <input type="number"
                                       name="amount"
                                       id="amountInput"
                                       readonly
                                       class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white font-semibold text-lg">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">/month</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                <x-heroicon name="information-circle" class="w-4 h-4 inline mr-1" />
                                Recurring monthly subscription
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button type="button"
                                    onclick="signalManager.closeModal()"
                                    class="flex-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold py-3 px-6 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-xl transition-all transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                                <x-heroicon name="check-circle" class="w-5 h-5 inline mr-2" />
                                Complete Subscription
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Signal Manager - Vanilla JavaScript
class SignalManager {
    constructor() {
        this.showModal = false;
        this.selectedSignal = {
            id: '',
            name: '',
            price: ''
        };
        this.init();
    }

    init() {

    }

    openSubscriptionModal(id, name, price) {
        this.selectedSignal = { id, name, price };
        this.showModal = true;
        
        // Update modal content
        const modal = document.getElementById('subscriptionModal');
        const modalContent = document.getElementById('modalContent');
        const signalNameEl = document.getElementById('selectedSignalName');
        const assetNameInput = document.getElementById('hiddenAssetName');
        const amountInput = document.getElementById('amountInput');
        
        if (modal) modal.style.display = 'flex';
        if (modalContent) {
            modalContent.style.opacity = '1';
            modalContent.style.transform = 'scale(1)';
        }
        if (signalNameEl) signalNameEl.textContent = name;
        if (assetNameInput) assetNameInput.value = name;
        if (amountInput) amountInput.value = price;
        
        document.body.style.overflow = 'hidden';
    }

    closeModal() {
        this.showModal = false;
        
        const modal = document.getElementById('subscriptionModal');
        const modalContent = document.getElementById('modalContent');
        
        if (modalContent) {
            modalContent.style.opacity = '0';
            modalContent.style.transform = 'scale(0.95)';
        }
        
        setTimeout(() => {
            if (modal) modal.style.display = 'none';
        }, 300);
        
        document.body.style.overflow = 'auto';
    }
}

// Global instance
let signalManager = null;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    signalManager = new SignalManager();
});
</script>

@endsection
