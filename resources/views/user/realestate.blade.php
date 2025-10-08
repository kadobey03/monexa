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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Real Estate</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Title with Real Estate Theme -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-2 flex items-center">
                    <span class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">🏠</span>
                    <span class="ml-3">Real Estate Investment Plans</span>
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-4">Build wealth through strategic real estate investments with proven returns</p>
                <div class="flex flex-wrap gap-3">
                    <span class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Stable Returns
                    </span>
                    <span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                        Diversified Portfolio
                    </span>
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded-full text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Secure Investments
                    </span>
                </div>
            </div>
            <div class="mt-6 lg:mt-0">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">4-20%</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Annual Returns</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-danger-alert />
    <x-success-alert />

    <!-- Market Overview Section -->
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-700 rounded-xl p-6 mb-8 border border-green-100 dark:border-gray-600">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
            <svg class="w-7 h-7 mr-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            Real Estate Market Insights
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">$2.4T</div>
                <div class="text-sm text-gray-600 dark:text-gray-300">Global Market Size</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">8.2%</div>
                <div class="text-sm text-gray-600 dark:text-gray-300">Avg. Annual Growth</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">15+</div>
                <div class="text-sm text-gray-600 dark:text-gray-300">Property Types</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">50+</div>
                <div class="text-sm text-gray-600 dark:text-gray-300">Global Markets</div>
            </div>
        </div>
    </div>

    <!-- Real Estate Plans Grid -->
    <div x-data="{ selectedPlan: null }" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
        @php
            $realEstatePlans = $plans->where('investment_type', 'real_estate');
        @endphp

        @forelse ($realEstatePlans as $index => $plan)
            <!-- Real Estate Plan Card -->
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700 group"
                 :class="{'ring-4 ring-green-500 dark:ring-green-600': selectedPlan === {{ $index }}}">

                <!-- Property Type Badge -->
                <div class="absolute top-4 right-4 z-10">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        {{$plan->tag}}
                    </span>
                </div>

                <!-- Property Image Overlay -->
                <div class="relative h-48 bg-gradient-to-br from-green-400 via-emerald-500 to-teal-600 overflow-hidden">
                    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <svg class="w-16 h-16 mx-auto mb-2 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            <div class="text-sm font-medium opacity-90">Real Estate Investment</div>
                        </div>
                    </div>
                    <!-- Floating ROI -->
                    <div class="absolute bottom-4 left-4">
                        <div class="bg-white bg-opacity-90 dark:bg-gray-800 dark:bg-opacity-90 rounded-lg px-3 py-1">
                            <div class="text-lg font-bold text-green-600 dark:text-green-400">{{$plan->increment_amount}}%</div>
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
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                {{Auth::user()->currency}}{{number_format($plan->min_price)}}
                                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">minimum</span>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500 dark:text-gray-400">Duration</div>
                                <div class="font-semibold text-gray-800 dark:text-white">{{$plan->expiration}} days</div>
                            </div>
                        </div>
                        <div class="h-1 w-full bg-gradient-to-r from-green-500 to-emerald-600 rounded-full"></div>
                    </div>

                    <!-- Investment Features -->
                    <div class="space-y-3 mb-6">
                        <!-- Investment Range -->
                        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Investment Range</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                {{Auth::user()->currency}}{{number_format($plan->min_price)}} - {{Auth::user()->currency}}{{number_format($plan->max_price)}}
                            </span>
                        </div>

                        <!-- Return Rate -->
                        <div class="flex items-center justify-between py-2 px-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Return Rate</span>
                            </div>
                            <span class="text-sm font-bold text-green-600 dark:text-green-400">
                                {{$plan->increment_amount}}% {{$plan->increment_interval}}
                            </span>
                        </div>

                        <!-- Expected Return -->
                        <div class="flex items-center justify-between py-2 px-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Expected Return</span>
                            </div>
                            <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{$plan->expected_return}}%</span>
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
                                        class="pl-8 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-4 text-gray-900 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:focus:ring-green-600 transition-colors duration-200"
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
                                        class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-green-600 dark:accent-green-500"
                                    >
                                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <span>{{Auth::user()->currency}}{{number_format($plan->min_price)}}</span>
                                        <span>{{Auth::user()->currency}}{{number_format($plan->max_price)}}</span>
                                    </div>
                                </div>

                                <!-- Profit Calculator -->
                                <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">{{$plan->increment_interval}} Return:</span>
                                        <span class="font-medium text-green-600 dark:text-green-400">
                                            {{Auth::user()->currency}}<span x-text="(amount * {{$plan->increment_amount}} / 100).toFixed(2)"></span>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm mt-1">
                                        <span class="text-gray-600 dark:text-gray-400">Total Return ({{$plan->expiration}} days):</span>
                                        <span class="font-bold text-green-600 dark:text-green-400">
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
                                class="w-full relative py-3 px-6 rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-900 group"
                                @mouseenter="selectedPlan = {{$index}}"
                            >
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                    </svg>
                                    Invest in Real Estate
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <!-- Empty State for Real Estate -->
            <div class="col-span-full flex flex-col items-center justify-center p-12 bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700">
                <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">No Real Estate Plans Available</h3>
                <p class="text-gray-600 dark:text-gray-400 text-center max-w-md mb-6">
                    Real estate investment plans are currently being updated. Please check back later for new property investment opportunities.
                </p>
                <a href="{{ route('mplans') }}" class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    View All Plans
                </a>
            </div>
        @endforelse
    </div>

    <!-- Real Estate Investment Guide -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 mb-8 border border-gray-100 dark:border-gray-700">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            <svg class="w-7 h-7 mr-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            Why Choose Real Estate Investment?
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Stable Returns -->
            <div class="flex space-x-4 p-4 bg-green-50 dark:bg-green-900/20 rounded-xl">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Stable Returns</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Real estate typically provides consistent, predictable returns with lower volatility than other investments.</p>
                </div>
            </div>

            <!-- Inflation Hedge -->
            <div class="flex space-x-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Inflation Protection</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Property values and rental income typically increase with inflation, protecting your purchasing power over time.</p>
                </div>
            </div>

            <!-- Passive Income -->
            <div class="flex space-x-4 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Passive Income</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Generate regular rental income without active management, creating a reliable passive income stream.</p>
                </div>
            </div>
        </div>

        <!-- Investment Process -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4">How Real Estate Investment Works</h4>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-green-600 dark:text-green-400">1</span>
                    </div>
                    <h5 class="font-semibold text-gray-900 dark:text-white mb-2">Select Plan</h5>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Choose a real estate investment plan that matches your budget and investment goals.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">2</span>
                    </div>
                    <h5 class="font-semibold text-gray-900 dark:text-white mb-2">Invest Funds</h5>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Securely invest your funds in a diversified portfolio of carefully selected properties.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">3</span>
                    </div>
                    <h5 class="font-semibold text-gray-900 dark:text-white mb-2">Professional Management</h5>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Our expert team manages the properties, handles tenants, and maximizes returns.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-orange-600 dark:text-orange-400">4</span>
                    </div>
                    <h5 class="font-semibold text-gray-900 dark:text-white mb-2">Earn Returns</h5>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Receive regular returns from rental income and property appreciation directly to your account.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Property Types Section -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-8 mb-8 border border-gray-200 dark:border-gray-600">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Our Real Estate Portfolio</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Residential</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10v11M20 10v11"></path>
                    </svg>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Commercial</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Industrial</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                    </svg>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Retail</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Mixed-Use</div>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4M15 5v2a2 2 0 002 2h2"></path>
                    </svg>
                </div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">REITs</div>
            </div>
        </div>
    </div>

    <!-- Risk & Returns Information -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Important Investment Information
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600 dark:text-gray-400">
            <div>
                <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Risk Factors:</h4>
                <ul class="list-disc list-inside space-y-1">
                    <li>Property values may fluctuate with market conditions</li>
                    <li>Real estate investments are generally less liquid than stocks</li>
                    <li>Returns may vary based on property performance and market trends</li>
                    <li>All investments carry inherent risks</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800 dark:text-white mb-2">Investment Benefits:</h4>
                <ul class="list-disc list-inside space-y-1">
                    <li>Professional property management included</li>
                    <li>Diversified portfolio across multiple property types</li>
                    <li>Regular income distributions</li>
                    <li>Long-term wealth building potential</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js Initialization -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('realEstatePlans', () => ({
            selectedPlan: null,
            init() {
                // Real estate specific initialization
            }
        }))
    })
</script>
@endsection
