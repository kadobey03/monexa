@extends('layouts.admin', ['title' => 'Trade Sinyalleri'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                    <i data-lucide="trending-up" class="h-6 w-6 text-green-600 dark:text-green-400"></i>
                </div>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Trade Sinyalleri</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Trading sinyallerini yönetin ve takip edin</p>
            </div>
        </div>
        
        <div class="mt-4 sm:mt-0">
            <button type="button"
                    x-data
                    @click="$dispatch('open-modal', { name: 'add-signal' })"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
                Sinyal Ekle
            </button>
        </div>
    </div>

    <x-danger-alert />
    <x-success-alert />

    <!-- Add Signal Modal -->
    <div x-data="{ show: false }"
         @open-modal.window="show = ($event.detail.name === 'add-signal')"
         @close-modal.window="show = false"
         @keydown.escape.window="show = false"
         x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="show = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('postsignals') }}" method="post">
                    @csrf
                    <div class="bg-white dark:bg-admin-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                                    Yeni Sinyal Ekle
                                </h3>
                                
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">İşlem Yönü</label>
                                            <select name="direction"
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    required>
                                                <option value="Sell">Sell</option>
                                                <option value="Buy">Buy</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Döviz Çifti</label>
                                            <input type="text"
                                                   name="pair"
                                                   placeholder="ör. EUR/USD"
                                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                   required>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fiyat</label>
                                            <input type="text"
                                                   name="price"
                                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                   required>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Take Profit 1</label>
                                            <input type="text"
                                                   name="tp1"
                                                   step="any"
                                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                   required>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Take Profit 2</label>
                                            <input type="text"
                                                   name="tp2"
                                                   step="any"
                                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stop Loss</label>
                                            <input type="text"
                                                   name="sl1"
                                                   step="any"
                                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-admin-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Sinyal Ekle
                        </button>
                        <button type="button"
                                @click="show = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-admin-600 shadow-sm px-4 py-2 bg-white dark:bg-admin-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-admin-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            İptal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Signals Table -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sinyaller</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-admin-700">
                <thead class="bg-gray-50 dark:bg-admin-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Referans
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            İşlem Yönü
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Döviz Çifti
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Fiyat
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Take Profit 1
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Take Profit 2
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Stop Loss
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Sonuç
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Durum
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Eklenme Tarihi
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
                                #{{ $signal->reference }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                <div class="flex items-center">
                                    @if ($signal->trade_direction == 'Buy')
                                        <i data-lucide="arrow-up" class="w-4 h-4 text-green-500 mr-2"></i>
                                        <span class="text-green-600 dark:text-green-400 font-medium">{{ $signal->trade_direction }}</span>
                                    @else
                                        <i data-lucide="arrow-down" class="w-4 h-4 text-red-500 mr-2"></i>
                                        <span class="text-red-600 dark:text-red-400 font-medium">{{ $signal->trade_direction }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $signal->currency_pair }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $signal->price }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $signal->take_profit1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $signal->take_profit2 ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $signal->stop_loss1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $signal->result ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($signal->status == 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        {{ $signal->status }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                        {{ $signal->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($signal->created_at)->addHour()->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    @if ($signal->status == 'unpublished')
                                        <a href="{{ route('pubsignals', ['signal' => $signal->id]) }}"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                                            Yayınla
                                        </a>
                                    @else
                                        <button type="button"
                                                x-data
                                                @click="$dispatch('open-modal', { name: 'result-modal-{{ $signal->id }}' })"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-admin-600 text-xs font-medium rounded text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                                            Sonuç Ekle
                                        </button>
                                    @endif
                                    
                                    <a href="{{ route('delete.signal', ['signal' => $signal->id]) }}"
                                       onclick="return confirm('Bu sinyali silmek istediğinizden emin misiniz?')"
                                       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-admin-800">
                                        Sil
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Result Modal for each signal -->
                        <div x-data="{ show: false }"
                             @open-modal.window="show = ($event.detail.name === 'result-modal-{{ $signal->id }}')"
                             @close-modal.window="show = false"
                             @keydown.escape.window="show = false"
                             x-show="show"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 z-50 overflow-y-auto"
                             style="display: none;">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="show = false"></div>

                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                                <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <form action="{{ route('updt.result') }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="signalId" value="{{ $signal->id }}">
                                        
                                        <div class="bg-white dark:bg-admin-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                                                        Sinyal Sonucunu Güncelle
                                                    </h3>
                                                    
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sonuç</label>
                                                        <input type="text"
                                                               name="result"
                                                               value="{{ $signal->result }}"
                                                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 dark:bg-admin-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                Sonucu Yayınla
                                            </button>
                                            <button type="button"
                                                    @click="show = false"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-admin-600 shadow-sm px-4 py-2 bg-white dark:bg-admin-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-admin-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                İptal
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="trending-up" class="h-12 w-12 text-gray-400 dark:text-gray-500 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Veri Bulunamadı</h3>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Henüz hiç sinyal eklenmemiş.</p>
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
