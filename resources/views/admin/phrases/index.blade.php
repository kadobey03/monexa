@extends('layouts.admin', ['title' => 'Dil/Cümle Yönetimi'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dil/Cümle Yönetimi</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Sistem dillerini ve çevirilerini yönetin</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
                Yeni Çeviri Ekle
            </button>
        </div>
    </div>

    <!-- Language Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-xl flex items-center justify-center">
                        <i data-lucide="globe" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Desteklenen Diller</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">3</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/50 rounded-xl flex items-center justify-center">
                        <i data-lucide="type" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Toplam Cümle</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">156</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/50 rounded-xl flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Bekleyen Çeviriler</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">12</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-xl flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Tamamlanan Çeviriler</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">144</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Language Tabs -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-admin-200 dark:border-admin-700 bg-admin-50 dark:bg-admin-900/50">
            <div class="flex items-center justify-between">
                <div class="flex space-x-1" x-data="{ activeTab: 'tr' }">
                    <button @click="activeTab = 'tr'" 
                            :class="{ 'bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300': activeTab === 'tr' }"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors hover:bg-admin-100 dark:hover:bg-admin-700">
                        🇹🇷 Türkçe
                    </button>
                    <button @click="activeTab = 'en'" 
                            :class="{ 'bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300': activeTab === 'en' }"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors hover:bg-admin-100 dark:hover:bg-admin-700">
                        🇺🇸 English
                    </button>
                    <button @click="activeTab = 'ar'" 
                            :class="{ 'bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300': activeTab === 'ar' }"
                            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors hover:bg-admin-100 dark:hover:bg-admin-700">
                        🇸🇦 العربية
                    </button>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" placeholder="Cümle ara..." 
                               class="admin-input w-64 pl-10 pr-4 py-2 text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-admin-200 dark:divide-admin-700">
                <thead class="bg-admin-50 dark:bg-admin-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">Anahtar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">Çeviri</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">Son Güncelleme</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">Durum</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-admin-800 divide-y divide-admin-200 dark:divide-admin-700">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">auth.login</td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">Giriş Yap</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                Kimlik Doğrulama
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">2 saat önce</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 p-1 rounded-md hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-1 rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">common.welcome</td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">Hoş Geldiniz</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300">
                                Genel
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">1 gün önce</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 p-1 rounded-md hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-1 rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-admin-200 dark:border-admin-700 bg-admin-50 dark:bg-admin-900/50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-admin-500 dark:text-admin-400">
                    <span>Toplam <span class="font-medium">156</span> sonuçtan <span class="font-medium">1-20</span> arası gösteriliyor</span>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-2 text-sm font-medium text-admin-500 bg-white border border-admin-300 rounded-lg hover:bg-admin-50 dark:bg-admin-700 dark:border-admin-600 dark:text-admin-300 dark:hover:bg-admin-600 transition-colors">
                        Önceki
                    </button>
                    <button class="px-3 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-lg hover:bg-primary-700 transition-colors">
                        1
                    </button>
                    <button class="px-3 py-2 text-sm font-medium text-admin-500 bg-white border border-admin-300 rounded-lg hover:bg-admin-50 dark:bg-admin-700 dark:border-admin-600 dark:text-admin-300 dark:hover:bg-admin-600 transition-colors">
                        2
                    </button>
                    <button class="px-3 py-2 text-sm font-medium text-admin-500 bg-white border border-admin-300 rounded-lg hover:bg-admin-50 dark:bg-admin-700 dark:border-admin-600 dark:text-admin-300 dark:hover:bg-admin-600 transition-colors">
                        Sonraki
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Phrase management specific JavaScript
        console.log('Phrases Management page loaded');
    });
</script>
@endpush
@endsection