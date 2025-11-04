@extends('layouts.master')

@section('title', 'Sayfa Bulunamadı')
@section('layoutType', 'base')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center">
        <!-- 404 Icon -->
        <div class="mb-8">
            <div class="w-24 h-24 mx-auto bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                <x-heroicon name="magnifying-glass" class="w-12 h-12 text-gray-400" />
            </div>
        </div>

        <!-- Error Message -->
        <div class="mb-8">
            <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-4">404</h1>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">Sayfa Bulunamadı</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                Aradığınız sayfa mevcut değil veya taşınmış olabilir.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            <a href="{{ url('/') }}" 
               class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <x-heroicon name="home" class="w-5 h-5 mr-2" />
                Ana Sayfaya Dön
            </a>
            <button onclick="history.back()" 
                    class="w-full inline-flex justify-center items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <x-heroicon name="arrow-left" class="w-5 h-5 mr-2" />
                Geri Dön
            </button>
        </div>

        <!-- Help Text -->
        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Sorun devam ederse 
                <a href="{{ route('support') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    destek ekibimizle
                </a> iletişime geçebilirsiniz.
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
});
</script>
@endsection