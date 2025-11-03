@extends('layouts.base')
@section('title', $title)

@section('content')
<h1>Hisse Senedi İşlemleri</h1>
<p>This is the shares trading page.</p>

<!-- Features Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Trading Features</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-emerald-400 mx-auto"></div>
        </div>

        <div class="bg-gray-800 bg-opacity-50 backdrop-filter backdrop-blur-sm rounded-xl p-8 border border-gray-700">
            <p class="text-xl text-gray-200 leading-relaxed mb-6">
                {{ $settings->site_name }} provides professional stock trading services with competitive spreads and 24/7 market access.
            </p>

            <ul class="space-y-4">
                <li class="flex items-center space-x-3">
                    <svg class="flex-shrink-0 h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-gray-300">Stock Trading Available</span>
                </li>
                <li class="flex items-center space-x-3">
                    <svg class="flex-shrink-0 h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-gray-300">24/7 Market Access</span>
                </li>
            </ul>
        </div>
    </div>
</section>

@endsection