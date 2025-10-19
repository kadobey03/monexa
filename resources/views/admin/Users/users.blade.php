@php
if (Auth('admin')->User()->dashboard_style == "light") {
    $text = "dark";
    $bg = "light";
} else {
    $bg = 'dark';
    $text = "light";
}
@endphp
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    
    <!-- Main Content -->
    <div class="flex-1 ml-0 md:ml-64 transition-all duration-300">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
            <!-- Header Section -->
            <div class="bg-white border-b border-gray-200 shadow-sm">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Kullanıcı Yönetimi</h1>
                            <p class="text-gray-600 mt-1">Sisteminizde kayıtlı tüm kullanıcıları görüntüleyin ve yönetin</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Users Management Content -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <livewire:admin.manage-users/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection