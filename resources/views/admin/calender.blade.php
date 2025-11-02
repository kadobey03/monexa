@extends('layouts.admin', ['title' => 'Takvim & Yapılacaklar'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Takvim & Yapılacaklar</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Yapılacaklar listenizi oluşturun ve takip edin</p>
        </div>
        <div class="flex items-center space-x-2">
            <i data-lucide="calendar" class="h-5 w-5 text-gray-500 dark:text-gray-400"></i>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::now()->locale('tr')->isoFormat('dddd, D MMMM YYYY') }}</span>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (Session::has('message'))
        <div class="rounded-md bg-blue-50 dark:bg-blue-900/50 p-4 border border-blue-200 dark:border-blue-700">
            <div class="flex">
                <i data-lucide="info" class="h-5 w-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3"></i>
                <div class="text-sm text-blue-700 dark:text-blue-300">{{ Session::get('message') }}</div>
            </div>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="rounded-md bg-red-50 dark:bg-red-900/50 p-4 border border-red-200 dark:border-red-700">
            <div class="flex">
                <i data-lucide="alert-triangle" class="h-5 w-5 text-red-600 dark:text-red-400 mt-0.5 mr-3"></i>
                <div class="text-sm text-red-700 dark:text-red-300">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Calendar Container -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="p-6">
            <div class="mb-4 flex items-center">
                <i data-lucide="calendar-days" class="h-5 w-5 text-gray-500 dark:text-gray-400 mr-2"></i>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Takvim Görünümü</h2>
            </div>
            
            <!-- Calendar Integration -->
            <div class="min-h-[500px] bg-gray-50 dark:bg-admin-900 rounded-lg p-4 border border-gray-200 dark:border-admin-600">
                <SCRIPT src="//localendar.com/public/Victory33404?current_only=Y&include=Y&dynamic=Y"></SCRIPT>
            </div>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-lg p-6 border border-blue-200 dark:border-blue-700">
        <div class="flex items-start">
            <i data-lucide="lightbulb" class="h-5 w-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3"></i>
            <div>
                <h3 class="font-medium text-blue-900 dark:text-blue-100">İpucu</h3>
                <p class="mt-1 text-sm text-blue-700 dark:text-blue-300">
                    Bu takvimi kullanarak önemli tarihlerinizi ve yapılacaklar listenizi organize edebilirsiniz.
                    Takvim entegrasyonu sayesinde tüm önemli etkinliklerinizi tek yerden takip edebilirsiniz.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
