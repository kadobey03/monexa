@extends('layouts.admin', ['title' => 'Kredi Başvuruları'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kredi Başvuruları</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kullanıcı kredi başvurularını inceleyin ve onaylayın</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                <i data-lucide="file-text" class="h-4 w-4 mr-2"></i>
                Rapor Oluştur
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-xl flex items-center justify-center">
                        <i data-lucide="file-plus" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Yeni Başvurular</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">8</div>
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
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">İnceleme Bekleyen</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">12</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/50 rounded-xl flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Onaylanan</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">45</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/50 rounded-xl flex items-center justify-center">
                        <i data-lucide="x-circle" class="w-6 h-6 text-red-600 dark:text-red-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Reddedilen</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">7</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Durum</label>
                <select class="admin-select">
                    <option>Tümü</option>
                    <option>Yeni</option>
                    <option>İnceleme Bekleyen</option>
                    <option>Onaylandı</option>
                    <option>Reddedildi</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kredi Tutarı</label>
                <select class="admin-select">
                    <option>Tümü</option>
                    <option>$0 - $5,000</option>
                    <option>$5,000 - $10,000</option>
                    <option>$10,000+</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Başvuru Tarihi</label>
                <input type="date" class="admin-input">
            </div>
            <div class="flex items-end">
                <button class="w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <i data-lucide="filter" class="h-4 w-4 mr-2 inline"></i>
                    Filtrele
                </button>
            </div>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-admin-200 dark:border-admin-700 bg-admin-50 dark:bg-admin-900/50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kredi Başvuruları</h3>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" placeholder="Başvuru ara..." 
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">Başvuru No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">Kullanıcı</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">Kredi Tutarı</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">Vade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">Başvuru Tarihi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">Durum</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-admin-800 divide-y divide-admin-200 dark:divide-admin-700">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">#CR001</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold">
                                        JD
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">John Doe</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">john@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">$15,000</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">24 ay</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">15 Eki 2024</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">
                                İnceleme Bekleyen
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 p-1 rounded-md hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 p-1 rounded-md hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-1 rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">#CR002</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                                        AS
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Anna Smith</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">anna@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">$8,500</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">12 ay</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">14 Eki 2024</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                Onaylandı
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 p-1 rounded-md hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300 p-1 rounded-md hover:bg-gray-50 dark:hover:bg-gray-900/20 transition-colors">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
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
                    <span>Toplam <span class="font-medium">72</span> sonuçtan <span class="font-medium">1-20</span> arası gösteriliyor</span>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-2 text-sm font-medium text-admin-500 bg-white border border-admin-300 rounded-lg hover:bg-admin-50 dark:bg-admin-700 dark:border-admin-600 dark:text-admin-300 dark:hover:bg-admin-600 transition-colors">
                        Önceki
                    </button>
                    <button class="px-3 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-lg hover:bg-primary-700 transition-colors">
                        1
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
        // Credit applications specific JavaScript
        console.log('Credit Applications page loaded');
    });
</script>
@endpush
@endsection