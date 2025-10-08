@extends('layouts.dasht')
@section('title', $title)
@section('content')
<!-- Main Content Container -->
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{route('dashboard')}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{route('mplans')}}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Investment Plans</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Cryptocurrency</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Title with Crypto Theme -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-2 flex items-center">
                    <span class="text-4xl mr-3">₿</span>
                    <span class="bg-gradient-to-r from-orange-500 to-yellow-500 bg-clip-text text-transparent">Cryptocurrency Investment Plans</span>
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-4">Capitalize on the digital currency revolution with high-yield crypto investments</p>
                <div class="flex flex-wrap gap-3">
                    <span class="inline-flex items-center px-3 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300 rounded-full text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        High Returns
                    </span>
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded-full text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Quick Profits
                    </span>
                    <span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Secure Trading
                    </span>
                </div>
            </div>
            <div class="mt-6 lg:mt-0">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-orange-600 dark:text-orange-400">8-35%</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Daily Returns</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-danger-alert />
    <x-success-alert />

    <!-- Crypto Market Overview -->
    <div class="bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-gray-800 dark:to-gray-700 rounded-xl p-6 mb-8 border border-orange-100 dark:border-gray-600">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
            <svg class="w-7 h-7 mr-3 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            Cryptocurrency Market Insights
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">$1.2T</div>
                <div class="text-sm text-gray-600 dark:text-gray-300">Total Market Cap</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">24/7</div>
                <div class="text-sm text-gray-600 dark:text-gray-300">Trading Hours</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">10K+</div>
                <div class="text-sm text-gray-600 dark:text-gray-300">Active Coins</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">100M+</div>
                <div class="text-sm text-gray-600 dark:text-gray-300">Global Users</div>
            </div>
        </div>
    </div>

    <!-- Crypto Plans Grid -->
    <div x-data="{ selectedPlan: null }" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
        @php
            $cryptoPlans = $plans->where('investment_type', 'crypto');
        @endphp

        @forelse ($cryptoPlans as $index => $plan)
            <!-- Crypto Plan Card -->
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700 group"
                 :class="{'ring-4 ring-orange-500 dark:ring-orange-600': selectedPlan === {{ $index }}}">

                <!-- Crypto Badge -->
                <div class="absolute top-4 right-4 z-10">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                        </svg>
                        {{$plan->tag}}
                    </span>
                </div>

                <!-- Crypto Visual Header -->
                <div class="relative h-48 bg-gradient-to-br from-orange-400 via-yellow-500 to-red-500 overflow-hidden">
                    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <div class="text-6xl mb-2">₿</div>
                            <div class="text-sm font-medium opacity-90">Cryptocurrency Investment</div>
                        </div>
                    </div>
                    <!-- Floating ROI -->
                    <div class="absolute bottom-4 left-4">
                        <div class="bg-white bg-opacity-90 dark:bg-gray-800 dark:bg-opacity-90 rounded-lg px-3 py-1">
                            <div class="text-lg font-bold text-orange-600 dark:text-orange-400">{{$plan->increment_amount}}%</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">{{$plan->increment_interval}} ROI</div>
                        </div>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-6">
                    <!-- Plan Header -->
                    <div class="mb-4">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">{{$plan->name}}</h3>
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                                {{Auth::user()->currency}}{{number_format($plan->min_price)}}
                                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">minimum</span>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500 dark:text-gray-400">Duration</div>
                                <div class="font-semibold text-gray-800 dark:text-white">{{$plan->expiration}} days</div>
                            </div>
                        </div>
                        <div class="h-1 w-full bg-gradient-to-r from-orange-500 to-yellow-500 rounded-full"></div>
                    </div>

                    <!-- Investment Features -->
                    <div class="space-y-3 mb-6">
                        <!-- Investment Range -->
                        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-orange-600 dark:text-orange-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Investment Range</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                {{Auth::user()->currency}}{{number_format($plan->min_price)}} - {{Auth::user()->currency}}{{number_format($plan->max_price)}}
                            </span>
                        </div>

                        <!-- Return Rate -->
                        <div class="flex items-center justify-between py-2 px-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-orange-600 dark:text-orange-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Return Rate</span>
                            </div>
                            <span class="text-sm font-bold text-orange-600 dark:text-orange-400">
                                {{$plan->increment_amount}}% {{$plan->increment_interval}}
                            </span>
                        </div>

                        <!-- Expected Return -->
                        <div class="flex items-center justify-between py-2 px-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Expected Return</span>
                            </div>
                            <span class="text-sm font-bold text-yellow-600 dark:text-yellow-400">{{$plan->expected_return}}%</span>
                        </div>

                        @if($plan->gift > 0)
                        <!-- Bonus Gift -->
                        <div class="flex items-center justify-between py-2 px-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 0v1.5m0 5v.5a2 2 0 01-2 2h-.5M12 8h.5a2 2 0 012 2v.5"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Welcome Bonus</span>
                            </div>
                            <span class="text-sm font-bold text-purple-600 dark:text-purple-400">
                                {{Auth::user()->currency}}{{number_format($plan->gift)}}
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Investment Form -->
                    <form method="post" action="{{route('joininvestmentplan')}}" class="space-y-4">
                        @csrf
                        <div x-data="{ amount: '{{$plan->min_price}}' }">
                            <!-- Amount Input -->
                            <div>
                                <label for="amount-{{$index}}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Investment Amount ({{Auth::user()->currency}})
                                </label>

                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400">{{Auth::user()->currency}}</span>
                                    </span>
                                    <input
                                        type="number"
                                        id="amount-{{$index}}"
                                        name="iamount"
                                        min="{{$plan->min_price}}"
                                        max="{{$plan->max_price}}"
                                        x-model="amount"
                                        placeholder="Enter amount"
                                        class="pl-8 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-4 text-gray-900 dark:text-white shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500 dark:focus:ring-orange-600 transition-colors duration-200"
                                        @click="selectedPlan = {{$index}}"
                                    >
                                </div>

                                <!-- Range Input -->
                                <div class="mt-3 px-1">
                                    <input
                                        type="range"
                                        min="{{$plan->min_price}}"
                                        max="{{$plan->max_price}}"
                                        x-model="amount"
                                        class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-orange-600 dark:accent-orange-500"
                                    >
                                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <span>{{Auth::user()->currency}}{{number_format($plan->min_price)}}</span>
                                        <span>{{Auth::user()->currency}}{{number_format($plan->max_price)}}</span>
                                    </div>
                                </div>

                                <!-- Profit Calculator -->
                                <div class="mt-3 p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg border border-orange-200 dark:border-orange-800">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">{{$plan->increment_interval}} Return:</span>
                                        <span class="font-medium text-orange-600 dark:text-orange-400">
                                            {{Auth::user()->currency}}<span x-text="(amount * {{$plan->increment_amount}} / 100).toFixed(2)"></span>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm mt-1">
                                        <span class="text-gray-600 dark:text-gray-400">Total Return ({{$plan->expiration}} days):</span>
                                        <span class="font-bold text-orange-600 dark:text-orange-400">
                                            {{Auth::user()->currency}}<span x-text="(amount * {{$plan->expected_return}} / 100).toFixed(2)"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="duration" value="{{$plan->expiration}}">
                            <input type="hidden" name="id" value="{{ $plan->id }}">

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="w-full relative py-3 px-6 rounded-lg bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 text-white font-medium shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 dark:focus:ring-offset-gray-900 group"
                                @mouseenter="selectedPlan = {{$index}}"
                            >
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                    </svg>
                                    Invest in Crypto
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <!-- Empty State for Crypto -->
            <div class="col-span-full flex flex-col items-center justify-center p-12 bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700">
                <div class="w-24 h-24 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center mb-6">
                    <div class="text-4xl">₿</div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">No Crypto Plans Available</h3>
                <p class="text-gray-600 dark:text-gray-400 text-center max-w-md mb-6">
                    Cryptocurrency investment plans are currently being updated. Please check back later for new crypto investment opportunities.
                </p>
                <a href="{{ route('mplans') }}" class="inline-flex items-center px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    View All Plans
                </a>
            </div>
        @endforelse
    </div>

    <!-- Crypto Education Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 mb-8 border border-gray-100 dark:border-gray-700">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            <svg class="w-7 h-7 mr-3 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Why Choose Cryptocurrency Investment?
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- High Growth Potential -->
            <div class="flex space-x-4 p-4 bg-orange-50 dark:bg-orange-900/20 rounded-xl">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">High Growth Potential</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Cryptocurrency offers exceptional growth opportunities with potential for significant returns.</p>
                </div>
            </div>

            <!-- 24/7 Trading -->
            <div class="flex space-x-4 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">24/7 Trading</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Unlike traditional markets, crypto markets never close, providing continuous trading opportunities.</p>
                </div>
            </div>

            <!-- Global Access -->
            <div class="flex space-x-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Global Access</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Access global cryptocurrency markets without geographical restrictions or traditional banking limitations.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Cryptocurrencies -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-8 mb-8 border border-gray-200 dark:border-gray-600">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Our Cryptocurrency Portfolio</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                    <div class="text-2xl">₿</div>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Bitcoin</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                    <div class="text-2xl">Ξ</div>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Ethereum</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                    <div class="text-lg font-bold">₮</div>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Tether</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                    <div class="text-lg font-bold">B</div>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">BNB</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                    <div class="text-lg font-bold">S</div>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Solana</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                    <div class="text-lg font-bold">A</div>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Cardano</div>
            </div>
        </div>
    </div>

    <!-- Risk Warning -->
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Important Risk Notice</h3>
                <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                    <p>Cryptocurrency investments are highly volatile and carry significant risk. Prices can fluctuate dramatically in short periods. Only invest what you can afford to lose. Past performance does not guarantee future results.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js Initialization -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cryptoPlans', () => ({
            selectedPlan: null,
            init() {
                // Crypto specific initialization
            }
        }))
    })
</script>
@endsection
