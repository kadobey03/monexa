@extends('layouts.master', ['layoutType' => 'dashboard'])
@section('title', $title)

@section('content')
<!-- Simple Header -->
<div class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800" x-cloak>
    <div class="w-full max-w-6xl mx-auto px-2 sm:px-3 md:px-4 py-2 sm:py-3 md:py-4">
        <div class="text-center">
            <h1 class="text-2xl font-medium text-gray-900 dark:text-white">
                {{ __('user.deposits.title') }}
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ __('user.deposits.description') }}
            </p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="w-full max-w-6xl mx-auto px-2 sm:px-3 md:px-4 py-2 sm:py-3 md:py-4">
    <!-- Alerts -->
    <div class="space-y-4 mb-6">
        <x-danger-alert />
        <x-success-alert />
    </div>

    <!-- Quick Amount Selector -->
    <div class="mb-8 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('user.deposits.quick_amounts') }}:</p>
        <div class="flex flex-wrap justify-center gap-3">
            @php
                $quickAmounts = [100, 500, 1000, 5000];
            @endphp
            @foreach($quickAmounts as $amount)
                <button onclick="setAmount({{$amount}})"
                        class="px-4 py-2 text-sm bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700
                               text-gray-700 dark:text-gray-300 rounded-lg border border-gray-200 dark:border-gray-700
                               transition-colors">
                    {{ Auth::user()->currency }}{{number_format($amount)}}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Deposit Form Card -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('user.deposits.make_deposit') }}
                    </h2>
                    <div class="flex items-center gap-2 px-3 py-1 bg-green-50 dark:bg-green-900/20 rounded-full">
                        <x-heroicon name="shield-check" class="w-4 h-4 text-green-600 dark:text-green-400" />
                        <span class="text-sm text-green-600 dark:text-green-400">{{ __('user.deposits.secure') }}</span>
                    </div>
                </div>

                <form method="POST" action="{{route('newdeposit')}}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="asset" value=" ">

                    <!-- Payment Method Selection -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('user.deposits.payment_method') }} <span class="text-red-500">*</span>
                        </label>
                        <select name="payment_method" required
                                class="block w-full px-3 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                                       rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @forelse ($dmethods as $method)
                                <option value="{{$method->name}}">{{$method->name}}</option>
                            @empty
                                <option>{{ __('user.deposits.no_payment_methods') }}</option>
                            @endforelse
                        </select>
                    </div>

                    <!-- Amount Input -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('user.deposits.amount') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 dark:text-gray-400">{{ Auth::user()->currency }}</span>
                            </div>
                            <input type="number"
                                   id="amount"
                                   name="amount"
                                   required
                                   min="1"
                                   step="0.01"
                                   placeholder="{{ __('user.deposits.amount_placeholder') }}"
                                   class="block w-full pl-8 pr-3 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                                          rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('user.deposits.amount_help') }}
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                            {{ __('user.deposits.proceed_button') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="space-y-6">
            <!-- Payment Methods Card -->
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    {{ __('user.deposits.payment_methods_title') }}
                </h3>
                <div class="space-y-3">
                    @foreach ($dmethods as $method)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <x-heroicon name="credit-card" class="w-4 h-4 text-gray-500 dark:text-gray-400" />
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{$method->name}}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Deposit Guide Card -->
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    {{ __('user.deposits.guide_title') }}
                </h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 flex-shrink-0">
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">1</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('user.deposits.guide_step1') }}
                        </p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 flex-shrink-0">
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">2</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('user.deposits.guide_step2') }}
                        </p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 flex-shrink-0">
                            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">3</span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('user.deposits.guide_step3') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
    });

    function setAmount(amount) {
        document.getElementById('amount').value = amount;
        document.getElementById('amount').focus();
    }
</script>
@endsection
