@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="admin-main-content flex-1 lg:ml-64 transition-all duration-300">
        <div class="min-h-screen bg-gray-50 p-4">
                <!-- Header Section -->
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 rounded-2xl p-8 mb-8">
                    <div class="absolute inset-0 bg-black opacity-20"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-purple-600/10"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-4xl font-bold text-white mb-2">
                                    <i class="fas fa-user-check mr-3 text-blue-200"></i>
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

                <x-danger-alert />
                <x-success-alert />

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $kycs->where('status', 'Verified')->count() }}
                                </div>
                                <div class="text-gray-500 text-sm">Onaylanmış</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-clock text-yellow-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $kycs->where('status', 'Pending')->count() }}
                                </div>
                                <div class="text-gray-500 text-sm">Beklemede</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-times-circle text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $kycs->whereNotIn('status', ['Verified', 'Pending'])->count() }}
                                </div>
                                <div class="text-gray-500 text-sm">Reddedilmiş</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KYC Applications Table -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-list-ul mr-3 text-blue-600"></i>
                            KYC Başvuru Listesi
                        </h3>
                        <p class="text-gray-600 mt-1">Kullanıcı kimlik doğrulama başvurularını inceleyin ve yönetin</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full" id="ShipTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                                        <i class="fas fa-user mr-2 text-gray-400"></i>
                                        Kullanıcı
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                                        <i class="fas fa-shield-alt mr-2 text-gray-400"></i>
                                        KYC Durumu
                                    </th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                                        <i class="fas fa-cog mr-2 text-gray-400"></i>
                                        İşlemler
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($kycs as $list)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-white font-semibold text-sm">
                                                        {{ strtoupper(substr($list->user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">{{ $list->user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $list->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($list->status == 'Verified')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Doğrulandı
                                                </span>
                                            @elseif ($list->status == 'Pending')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Beklemede
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                    {{ $list->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('viewkyc', $list->id) }}"
                                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-sm font-semibold rounded-lg hover:from-blue-600 hover:to-purple-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                                                <i class="fas fa-eye mr-2"></i>
                                                Başvuruyu Görüntüle
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Henüz başvuru yok</h3>
                                                <p class="text-gray-500">KYC başvurusu yapılmamış.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
