@extends('layouts.admin', ['title' => 'Aktif Sinyaller'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                <i data-lucide="activity" class="h-6 w-6 text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Aktif Sinyaller</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kullanıcı sinyal yatırımlarını görüntüleyin ve yönetin</p>
        </div>
    </div>

    <x-danger-alert />
    <x-success-alert />

    <!-- Signals Table -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tüm Sinyaller</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-admin-700">
                <thead class="bg-gray-50 dark:bg-admin-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Müşteri Adı
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Varlık
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Sinyal Durumu
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            İşlem Tipi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Sinyal Adı
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Yatırım Tutarı
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Son Kullanım
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Başlangıç Tarihi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                    @forelse ($signals as $signal)
                        <tr class="hover:bg-gray-50 dark:hover:bg-admin-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                @if (isset($signal->suser->name) && $signal->suser->name != null)
                                    {{ $signal->suser->name }}
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $signal->asset }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($signal->status == 'ongoing')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        <i data-lucide="play-circle" class="w-3 h-3 mr-1"></i>
                                        {{ ucfirst($signal->status) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                        <i data-lucide="pause-circle" class="w-3 h-3 mr-1"></i>
                                        {{ ucfirst($signal->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                @if($signal->order_type == 'Buy')
                                    <div class="flex items-center text-green-600 dark:text-green-400 font-medium">
                                        <i data-lucide="arrow-up" class="w-4 h-4 mr-1"></i>
                                        {{ $signal->order_type }}
                                    </div>
                                @else
                                    <div class="flex items-center text-red-600 dark:text-red-400 font-medium">
                                        <i data-lucide="arrow-down" class="w-4 h-4 mr-1"></i>
                                        {{ $signal->order_type }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $signal->dsignal->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                @if(isset($signal->suser->currency))
                                    <span class="font-medium">{{ $signal->suser->currency }}{{ number_format($signal->amount) }}</span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $signal->expiration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($signal->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <div>
                                        <button type="button"
                                                @click="open = !open"
                                                @click.away="open = false"
                                                class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-admin-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                                            İşlemler
                                            <i data-lucide="chevron-down" class="ml-2 h-4 w-4"></i>
                                        </button>
                                    </div>

                                    <div x-show="open"
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-admin-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                                         style="display: none;">
                                        <div class="py-1">
                                            <a href="{{ route('deletesignal', $signal->id) }}"
                                               onclick="return confirm('Bu sinyali silmek istediğinizden emin misiniz?')"
                                               class="flex items-center px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                                <i data-lucide="trash-2" class="mr-3 h-4 w-4"></i>
                                                Sinyali Sil
                                            </a>
                                            
                                            @if ($signal->status == 'ongoing')
                                                <a href="{{ route('signalmarkas', ['id' => $signal->id, 'status' => 'expired']) }}"
                                                   class="flex items-center px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                                    <i data-lucide="clock-x" class="mr-3 h-4 w-4"></i>
                                                    Süresi Dolmuş Olarak İşaretle
                                                </a>
                                            @else
                                                <a href="{{ route('signalmarkas', ['id' => $signal->id, 'status' => 'ongoing']) }}"
                                                   class="flex items-center px-4 py-2 text-sm text-green-700 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20">
                                                    <i data-lucide="play-circle" class="mr-3 h-4 w-4"></i>
                                                    Aktif Olarak İşaretle
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="activity" class="h-12 w-12 text-gray-400 dark:text-gray-500 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Aktif Sinyal Bulunamadı</h3>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Henüz hiç aktif sinyal yok.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
