@extends('layouts.master', ['layoutType' => 'admin', 'title' => 'Kullanıcı Yönetimi'])

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white dark:bg-admin-800 border-b border-admin-200 dark:border-admin-700 shadow-sm">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg">
                    <x-heroicon name="users" class="w-8 h-8 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Kullanıcı Yönetimi</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Sisteminizde kayıtlı tüm kullanıcıları görüntüleyin ve yönetin</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Users Management Content -->
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-xl border border-admin-200 dark:border-admin-700 overflow-hidden">
            <div class="p-6">
                <livewire:admin.manage-users/>
            </div>
        </div>
    </div>
</div>
@endsection