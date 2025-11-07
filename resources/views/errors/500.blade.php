@extends('layouts.master', ['layoutType' => 'guest'])

@section('title', 'Sunucu Hatası')

@section('content')
<div class="w-full max-w-md">
    <!-- Error Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl ring-1 ring-gray-200 dark:ring-gray-700 p-8 text-center">
        <!-- Error Icon -->
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/20 mb-6">
            <svg class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
        </div>

        <!-- Error Content -->
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            Sunucu Hatası
        </h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">
            {{ $message ?? 'Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.' }}
        </p>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="{{ url()->previous() }}" 
               class="w-full inline-flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Geri Dön
            </a>
            
            <a href="{{ route('login') }}" 
               class="w-full inline-flex justify-center items-center gap-2 py-3 px-4 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Ana Sayfa
            </a>
        </div>

        <!-- Support Info -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Sorun devam ederse lütfen destek ekibi ile iletişime geçin.
            </p>
        </div>
    </div>
</div>
@endsection