@extends('layouts.admin', ['title' => 'KYC Başvuru Yönetimi'])

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900 min-h-screen p-4">
    <!-- Header Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 rounded-2xl p-8 mb-8">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-purple-600/10"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">
                        <x-heroicon name="user-check" class="inline w-10 h-10 mr-3 text-blue-200" />
                        KYC Başvuru Yönetimi
                    </h1>
                    <p class="text-blue-100 text-lg">
                        {{ $settings->site_name }} - Kullanıcı kimlik doğrulama başvurularını yönetin
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4">
                            <div class="text-2xl font-bold text-white">{{ $kycs->count() }}</div>
                            <div class="text-blue-100 text-sm">Toplam Başvuru</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute -right-16 -bottom-16 w-32 h-32 bg-gradient-to-br from-white/10 to-blue-300/20 rounded-full blur-2xl"></div>
        <div class="absolute -left-16 -top-16 w-24 h-24 bg-gradient-to-br from-purple-400/20 to-pink-400/20 rounded-full blur-xl"></div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-lg border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center mr-4">
                    <x-heroicon name="check-circle" class="w-6 h-6 text-green-600 dark:text-green-400" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $kycs->where('status', 'Verified')->count() }}
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Onaylanmış</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-lg border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-xl flex items-center justify-center mr-4">
                    <x-heroicon name="clock" class="w-6 h-6 text-yellow-600 dark:text-yellow-400" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $kycs->where('status', 'Pending')->count() }}
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Beklemede</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-lg border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-xl flex items-center justify-center mr-4">
                    <x-heroicon name="x-circle" class="w-6 h-6 text-red-600 dark:text-red-400" />
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $kycs->whereNotIn('status', ['Verified', 'Pending'])->count() }}
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Reddedilmiş</div>
                </div>
            </div>
        </div>
    </div>

    <!-- KYC Applications Table -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 overflow-hidden">
        <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-admin-900 dark:to-admin-800 border-b border-admin-200 dark:border-admin-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                <x-heroicon name="list-bullet" class="w-6 h-6 mr-3 text-blue-600 dark:text-blue-400" />
                KYC Başvuru Listesi
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Kullanıcı kimlik doğrulama başvurularını inceleyin ve yönetin</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full" id="ShipTable">
                <thead class="bg-gray-50 dark:bg-admin-900">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">
                            <x-heroicon name="user" class="inline w-4 h-4 mr-2 text-gray-400" />
                            Kullanıcı
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">
                            <x-heroicon name="shield-check" class="inline w-4 h-4 mr-2 text-gray-400" />
                            KYC Durumu
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white">
                            <x-heroicon name="cog-6-tooth" class="inline w-4 h-4 mr-2 text-gray-400" />
                            İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-200 dark:divide-admin-700">
                    @forelse ($kycs as $list)
                        <tr class="hover:bg-gray-50 dark:hover:bg-admin-700 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-semibold text-sm">
                                            {{ strtoupper(substr($list->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $list->user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $list->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($list->status == 'Verified')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <x-heroicon name="check-circle" class="w-3 h-3 mr-1" />
                                        Doğrulandı
                                    </span>
                                @elseif ($list->status == 'Pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <x-heroicon name="clock" class="w-3 h-3 mr-1" />
                                        Beklemede
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        <x-heroicon name="x-circle" class="w-3 h-3 mr-1" />
                                        {{ $list->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('viewkyc', $list->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-sm font-semibold rounded-lg hover:from-blue-600 hover:to-purple-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                                    <x-heroicon name="eye" class="w-4 h-4 mr-2" />
                                    Başvuruyu Görüntüle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <x-heroicon name="inbox" class="w-16 h-16 text-gray-300 mb-4" />
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Henüz başvuru yok</h3>
                                    <p class="text-gray-500 dark:text-gray-400">KYC başvurusu yapılmamış.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

    <style>
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table-responsive table {
                min-width: 600px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DataTable initialization for better mobile experience
            if (typeof $ !== 'undefined' && $.fn.DataTable) {
                $('#ShipTable').DataTable({
                    responsive: true,
                    pageLength: 25,
                    order: [[0, 'asc']],
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
                    }
                });
            }

            // Add loading states for buttons
            document.querySelectorAll('a[href*="viewkyc"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Yükleniyor...';
                    this.classList.add('opacity-75', 'cursor-not-allowed');
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('opacity-75', 'cursor-not-allowed');
                    }, 2000);
                });
            });
        });
    </script>
@endsection
