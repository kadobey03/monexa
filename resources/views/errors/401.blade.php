@extends('layouts.master')

@section('title', 'Yetkisiz Erişim')
@section('layoutType', 'base')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center">
        <!-- 401 Icon -->
        <div class="mb-8">
            <div class="w-24 h-24 mx-auto bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center">
                <x-heroicon name="lock-closed" class="w-12 h-12 text-orange-600 dark:text-orange-400" />
            </div>
        </div>

        <!-- Error Message -->
        <div class="mb-8">
            <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-4">401</h1>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">Yetkisiz Erişim</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                Bu sayfaya erişmek için giriş yapmanız gerekiyor.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            <a href="{{ route('login') }}"
               class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <x-heroicon name="arrow-right-on-rectangle" class="w-5 h-5 mr-2" />
                Giriş Yap
            </a>
            <a href="{{ route('register') }}"
               class="w-full inline-flex justify-center items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <x-heroicon name="user-plus" class="w-5 h-5 mr-2" />
                Hesap Oluştur
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        
    }
});
</script>
@endsection
