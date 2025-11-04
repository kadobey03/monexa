@extends('layouts.admin', ['title' => 'Sistem Planları'])

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-admin-900 dark:via-admin-800 dark:to-admin-900">
            <!-- Header Section -->
        <div class="bg-white dark:bg-admin-800 border-b border-gray-200 dark:border-admin-700 shadow-sm">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                        <div class="p-3 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl shadow-lg">
                            <x-heroicon name="credit-card" class="w-8 h-8 text-white" />
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Sistem Planları</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Yatırım planlarını görüntüleyin ve yönetin</p>
                        </div>
                        </div>
                        
                    <a href="{{ route('newplan') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                        <x-heroicon name="plus" class="w-5 h-5 mr-2" />
                        Yeni Plan
                    </a>
                </div>
            </div>
        </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                <x-danger-alert />
                <x-success-alert />
            </div>
            
            <!-- Plans Grid -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                @forelse ($plans as $plan)
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-8">
                        @foreach ($plans->chunk(3) as $planChunk)
                            @foreach ($planChunk as $plan)
                            <div class="group relative bg-white dark:bg-admin-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 border border-gray-200 dark:border-admin-700 overflow-hidden">
                                    <!-- Gradient Header -->
                                    <div class="bg-gradient-to-br from-purple-600 to-blue-600 p-6 text-white relative overflow-hidden">
                                        <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                                        <div class="relative z-10">
                                            <div class="flex items-center justify-between mb-2">
                                                <h2 class="text-2xl font-bold">{{ $plan->name }}</h2>
                                                @if($plan->tag)
                                                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-semibold">{{ $plan->tag }}</span>
                                                @endif
                                            </div>
                                            
                                            <!-- Price Display -->
                                            <div class="mt-4">
                                                <div class="flex items-baseline">
                                                    <span class="text-4xl font-bold">{{ $settings->currency }}</span>
                                                    <span class="text-5xl font-bold ml-1">{{ number_format($plan->price) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Plan Details -->
                                    <div class="p-6">
                                        <div class="space-y-4">
                                            <!-- Minimum Deposit -->
                                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="font-semibold text-gray-700">Minimum Yatırım</span>
                                                </div>
                                                <span class="font-bold text-green-700">{{ $settings->currency }}{{ number_format($plan->min_price) }}</span>
                                            </div>
                                            
                                            <!-- Maximum Deposit -->
                                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 11-1.414 1.414L10 4.414 7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="font-semibold text-gray-700">Maksimum Yatırım</span>
                                                </div>
                                                <span class="font-bold text-blue-700">{{ $settings->currency }}{{ number_format($plan->max_price) }}</span>
                                            </div>
                                            
                                            <!-- ROI Range -->
                                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border-l-4 border-purple-500">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="font-semibold text-gray-700">Getiri Oranı</span>
                                                </div>
                                                <span class="font-bold text-purple-700">{{ number_format($plan->minr) }}% - {{ number_format($plan->maxr) }}%</span>
                                            </div>
                                            
                                            <!-- Gift Bonus -->
                                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border-l-4 border-yellow-500">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center mr-3">
                                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"></path>
                                                            <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="font-semibold text-gray-700">Hediye Bonus</span>
                                                </div>
                                                <span class="font-bold text-yellow-700">{{ $settings->currency }}{{ $plan->gift }}</span>
                                            </div>
                                            
                                            <!-- Duration -->
                                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="font-semibold text-gray-700">Süre</span>
                                                </div>
                                                <span class="font-bold text-teal-700">{{ $plan->expiration }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="flex space-x-3 mt-6">
                                            <a href="{{ route('editplan', $plan->id) }}" class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                                Düzenle
                                            </a>
                                            <a href="{{ url('admin/dashboard/trashplan') }}/{{ $plan->id }}" onclick="return confirm('Bu planı silmek istediğinizden emin misiniz?')" class="inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L9.586 12l-2.293 2.293a1 1 0 101.414 1.414L10 13.414l1.293 1.293a1 1 0 001.414-1.414L11.414 12l2.293-2.293z" clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Hover Effect Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-purple-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="flex items-center justify-center min-h-[400px]">
                        <div class="text-center">
                            <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Henüz Plan Yok</h3>
                            <p class="text-gray-500 text-lg mb-6">Şu anda sistemde hiç yatırım planı bulunmuyor.</p>
                            <a href="{{ route('newplan') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                İlk Planı Oluştur
                            </a>
                    </div>
                @endforelse
        </div>
    </div>
@endsection