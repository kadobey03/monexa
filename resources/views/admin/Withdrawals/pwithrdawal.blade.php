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
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gradient-to-r from-red-500 to-rose-600 rounded-xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Çekim Talebini İşle</h1>
                                <p class="text-gray-600 mt-1">Müşteri çekim talebini görüntüleyin ve işleme alın</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('mwithdrawals') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Geri Dön
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                <x-danger-alert />
                <x-success-alert />
            </div>
            
            <!-- Main Content -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <!-- Edit Section -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
                        <!-- Edit Header -->
                        <div class="bg-gradient-to-r from-red-50 to-rose-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-red-100 rounded-lg">
                                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-xl font-bold text-gray-900">Çekim Detaylarını Düzenle</h2>
                                </div>
                                <button type="button" id="toggleEditForm" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Düzenle Formunu Aç/Kapat
                                </button>
                            </div>
                        </div>
                        
                        <!-- Current Values Display -->
                        <div id="currentValues" class="px-6 py-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-red-600">Mevcut Tutar</p>
                                                <p class="text-lg font-bold text-red-800">${{ number_format($withdrawal->amount, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-blue-600">Mevcut Durum</p>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-medium {{ $withdrawal->status == 'Processed' ? 'bg-green-100 text-green-800' : ($withdrawal->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ $withdrawal->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="p-4 bg-purple-50 rounded-lg border-l-4 border-purple-500">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-purple-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-purple-600">Mevcut Ödeme Yöntemi</p>
                                                <p class="text-lg font-semibold text-purple-800">{{ $withdrawal->payment_mode }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-gray-500">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-600">Oluşturulma Tarihi</p>
                                                <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zM3 15a1 1 0 011-1h1a1 1 0 110 2H4a1 1 0 01-1-1zm6-11a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zm6 2a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zm0 3a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zm0 3a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-green-600">Ödeme Detayları</p>
                                                <p class="text-sm text-green-800">{{ $withdrawal->paydetails ?: 'Belirtilmemiş' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Edit Form Container -->
                        <div id="editFormContainer" class="px-6 py-6 bg-gray-50 border-t border-gray-200" style="display: none;">
                            <form action="{{ route('edit.withdrawal') }}" method="POST" id="editWithdrawalForm" class="space-y-6">
                                @csrf
                                <input type="hidden" name="withdrawal_id" value="{{ $withdrawal->id }}">
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Amount -->
                                    <div>
                                        <label for="edit_amount" class="block text-sm font-medium text-gray-700 mb-2">Tutar</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" step="0.01" name="amount" id="edit_amount" value="{{ $withdrawal->amount }}" required
                                                   class="pl-8 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                        </div>
                                    </div>
                                    
                                    <!-- Status -->
                                    <div>
                                        <label for="edit_status" class="block text-sm font-medium text-gray-700 mb-2">Durum</label>
                                        <select name="status" id="edit_status" required
                                                class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                            <option value="Pending" {{ $withdrawal->status == 'Pending' ? 'selected' : '' }}>Beklemede</option>
                                            <option value="Processed" {{ $withdrawal->status == 'Processed' ? 'selected' : '' }}>İşlenmiş</option>
                                            <option value="Rejected" {{ $withdrawal->status == 'Rejected' ? 'selected' : '' }}>Reddedildi</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Payment Mode -->
                                    <div>
                                        <label for="edit_payment_mode" class="block text-sm font-medium text-gray-700 mb-2">Ödeme Yöntemi</label>
                                        <input type="text" name="payment_mode" id="edit_payment_mode" value="{{ $withdrawal->payment_mode }}" required
                                               class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    </div>
                                    
                                    <!-- Created Date -->
                                    <div>
                                        <label for="edit_created_at" class="block text-sm font-medium text-gray-700 mb-2">Oluşturulma Tarihi</label>
                                        <input type="datetime-local" name="created_at" id="edit_created_at" 
                                               value="{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('Y-m-d\TH:i') }}" required
                                               class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    </div>
                                </div>
                                
                                <!-- Payment Details -->
                                <div>
                                    <label for="edit_paydetails" class="block text-sm font-medium text-gray-700 mb-2">Ödeme Detayları</label>
                                    <textarea name="paydetails" id="edit_paydetails" rows="3" placeholder="Ödeme detaylarını girin..."
                                              class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent">{{ $withdrawal->paydetails }}</textarea>
                                </div>
                                
                                <!-- Form Actions -->
                                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                                    <button type="button" id="cancelEdit" 
                                            class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        İptal
                                    </button>
                                    <button type="submit" 
                                            class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"></path>
                                        </svg>
                                        Çekim Detaylarını Güncelle
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Payment Details Section -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
                        <!-- Payment Header -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-bold text-gray-900">
                                @if ($withdrawal->status != 'Processed')
                                    {{ $user->name ?? "N/A" }} için Ödeme Detayları
                                @else
                                    <span class="text-green-600">✓ Ödeme Tamamlandı</span>
                                @endif
                            </h2>
                        </div>
                        
                        <!-- Payment Content -->
                        <div class="p-6">
                            <div class="bg-gray-50 rounded-lg p-6">
                                @if ($method->defaultpay == 'yes')
                                    @if ($withdrawal->payment_mode == 'Bitcoin')
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">BTC Adresi</label>
                                            <div class="flex">
                                                <input type="text" value="{{ $withdrawal->duser->btc_address }}" readonly
                                                       class="flex-1 block border-gray-300 rounded-l-lg bg-gray-100 text-gray-800 focus:ring-0 focus:border-gray-300">
                                                <button onclick="copyToClipboard('{{ $withdrawal->duser->btc_address }}')" 
                                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r-lg border border-blue-600 hover:border-blue-700">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                                                        <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @elseif($withdrawal->payment_mode == 'Ethereum')
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">ETH Adresi</label>
                                            <div class="flex">
                                                <input type="text" value="{{ $withdrawal->duser->eth_address }}" readonly
                                                       class="flex-1 block border-gray-300 rounded-l-lg bg-gray-100 text-gray-800 focus:ring-0 focus:border-gray-300">
                                                <button onclick="copyToClipboard('{{ $withdrawal->duser->eth_address }}')" 
                                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r-lg border border-blue-600 hover:border-blue-700">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                                                        <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @elseif($withdrawal->payment_mode == 'Litecoin')
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">LTC Adresi</label>
                                            <div class="flex">
                                                <input type="text" value="{{ $withdrawal->duser->ltc_address }}" readonly
                                                       class="flex-1 block border-gray-300 rounded-l-lg bg-gray-100 text-gray-800 focus:ring-0 focus:border-gray-300">
                                                <button onclick="copyToClipboard('{{ $withdrawal->duser->ltc_address }}')" 
                                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r-lg border border-blue-600 hover:border-blue-700">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                                                        <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @elseif ($withdrawal->payment_mode == 'USDT')
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">USDT Adresi</label>
                                            <div class="flex">
                                                <input type="text" value="{{ $withdrawal->duser->usdt_address }}" readonly
                                                       class="flex-1 block border-gray-300 rounded-l-lg bg-gray-100 text-gray-800 focus:ring-0 focus:border-gray-300">
                                                <button onclick="copyToClipboard('{{ $withdrawal->duser->usdt_address }}')" 
                                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r-lg border border-blue-600 hover:border-blue-700">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                                                        <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @elseif ($withdrawal->payment_mode == 'BUSD')
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">BUSD Adresi</label>
                                            <div class="flex">
                                                <input type="text" value="{{ $withdrawal->paydetails }}" readonly
                                                       class="flex-1 block border-gray-300 rounded-l-lg bg-gray-100 text-gray-800 focus:ring-0 focus:border-gray-300">
                                                <button onclick="copyToClipboard('{{ $withdrawal->paydetails }}')" 
                                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r-lg border border-blue-600 hover:border-blue-700">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                                                        <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @elseif($withdrawal->payment_mode == 'Bank Transfer')
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Banka Adı</label>
                                                <input type="text" value="{{ $withdrawal->duser->bank_name }}" readonly
                                                       class="block w-full border-gray-300 rounded-lg bg-gray-100 text-gray-800 focus:ring-0 focus:border-gray-300">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Hesap Adı</label>
                                                <input type="text" value="{{ $withdrawal->duser->account_name }}" readonly
                                                       class="block w-full border-gray-300 rounded-lg bg-gray-100 text-gray-800 focus:ring-0 focus:border-gray-300">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Hesap Numarası</label>
                                                <input type="text" value="{{ $withdrawal->duser->account_number }}" readonly
                                                       class="block w-full border-gray-300 rounded-lg bg-gray-100 text-gray-800 focus:ring-0 focus:border-gray-300">
                                            </div>
                                            @if (!empty($withdrawal->duser->swift_code))
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Swift Kodu</label>
                                                    <input type="text" value="{{ $withdrawal->duser->swift_code }}" readonly
                                                           class="block w-full border-gray-300 rounded-lg bg-gray-100 text-gray-800 focus:ring-0 focus:border-gray-300">
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    @if ($method->methodtype == 'crypto')
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ $withdrawal->payment_mode }} Adresi</label>
                                            <div class="flex">
                                                <input type="text" value="{{ $withdrawal->paydetails }}" readonly
                                                       class="flex-1 block border-gray-300 rounded-l-lg bg-gray-100 text-gray-800 focus:ring-0 focus:border-gray-300">
                                                <button onclick="copyToClipboard('{{ $withdrawal->paydetails }}')" 
                                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r-lg border border-blue-600 hover:border-blue-700">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                                                        <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ $withdrawal->payment_mode }} Ödeme Detayları</label>
                                            <input type="text" value="{{ $withdrawal->paydetails }}" readonly
                                                   class="block w-full border-gray-300 rounded-lg bg-gray-100 text-gray-800 focus:ring-0 focus:border-gray-300">
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Section -->
                    @if ($withdrawal->status != 'Processed')
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                            <!-- Action Header -->
                            <div class="bg-gradient-to-r from-orange-50 to-yellow-50 px-6 py-4 border-b border-gray-200">
                                <h2 class="text-xl font-bold text-gray-900">İşlem Yapın</h2>
                            </div>
                            
                            <!-- Action Form -->
                            <div class="p-6">
                                <form action="{{ route('pwithdrawal') }}" method="POST" class="space-y-6">
                                    @csrf
                                    
                                    <!-- Action Selection -->
                                    <div>
                                        <label for="action" class="block text-sm font-medium text-gray-700 mb-2">İşlem</label>
                                        <select name="action" id="action" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                            <option value="Paid">Ödendi</option>
                                            <option value="Reject">Reddet</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Email Options (Initially Hidden) -->
                                    <div id="emailcheck" class="hidden">
                                        <label class="block text-sm font-medium text-gray-700 mb-3">E-posta Gönder</label>
                                        <div class="flex space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="emailsend" id="dontsend" value="false" class="form-radio text-orange-500 focus:ring-orange-500" checked>
                                                <span class="ml-2">E-posta Gönderme</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="emailsend" id="sendemail" value="true" class="form-radio text-orange-500 focus:ring-orange-500">
                                                <span class="ml-2">E-posta Gönder</span>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <!-- Email Content (Initially Hidden) -->
                                    <div id="emailtext" class="hidden space-y-4">
                                        <div>
                                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Konu</label>
                                            <input type="text" name="subject" id="subject" 
                                                   class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                        </div>
                                        <div>
                                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Reddetme Nedeni</label>
                                            <textarea name="reason" id="message" rows="3" placeholder="Reddetme nedenini buraya yazın..."
                                                      class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-transparent"></textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- Submit Button -->
                                    <div class="pt-4 border-t border-gray-200">
                                        <input type="hidden" name="id" value="{{ $withdrawal->id }}">
                                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            İşlemi Tamamla
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script>
        // Toggle edit form visibility
        document.getElementById('toggleEditForm').addEventListener('click', function() {
            const editContainer = document.getElementById('editFormContainer');
            const currentValues = document.getElementById('currentValues');
            const button = this;
            
            if (editContainer.style.display === 'none') {
                editContainer.style.display = 'block';
                currentValues.style.display = 'none';
                button.innerHTML = '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l6 6a1 1 0 001.414 0l6-6a1 1 0 00-1.414-1.414L10 6.586 4.293 2.293z" clip-rule="evenodd"></path></svg>Formu Gizle';
            } else {
                editContainer.style.display = 'none';
                currentValues.style.display = 'block';
                button.innerHTML = '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>Düzenle Formunu Aç/Kapat';
            }
        });
        
        // Cancel edit functionality
        document.getElementById('cancelEdit').addEventListener('click', function() {
            document.getElementById('editFormContainer').style.display = 'none';
            document.getElementById('currentValues').style.display = 'block';
            document.getElementById('toggleEditForm').innerHTML = '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>Düzenle Formunu Aç/Kapat';
        });
        
        // Form validation
        document.getElementById('editWithdrawalForm').addEventListener('submit', function(e) {
            const amount = parseFloat(document.getElementById('edit_amount').value);
            if (amount < 0) {
                e.preventDefault();
                alert('Tutar negatif olamaz');
                return false;
            }
            
            if (confirm('Bu çekim talebini güncellemek istediğinizden emin misiniz?')) {
                return true;
            } else {
                e.preventDefault();
                return false;
            }
        });
        
        // Action form logic
        document.getElementById('action').addEventListener('change', function() {
            const emailcheck = document.getElementById('emailcheck');
            const emailtext = document.getElementById('emailtext');
            const dontsend = document.getElementById('dontsend');
            const subject = document.getElementById('subject');
            const message = document.getElementById('message');
            
            if (this.value === "Reject") {
                emailcheck.classList.remove('hidden');
            } else {
                emailcheck.classList.add('hidden');
                emailtext.classList.add('hidden');
                dontsend.checked = true;
                subject.removeAttribute('required');
                message.removeAttribute('required');
            }
        });
        
        document.getElementById('sendemail').addEventListener('click', function() {
            const emailtext = document.getElementById('emailtext');
            const subject = document.getElementById('subject');
            const message = document.getElementById('message');
            
            emailtext.classList.remove('hidden');
            subject.setAttribute('required', '');
            message.setAttribute('required', '');
        });
        
        document.getElementById('dontsend').addEventListener('click', function() {
            const emailtext = document.getElementById('emailtext');
            const subject = document.getElementById('subject');
            const message = document.getElementById('message');
            
            emailtext.classList.add('hidden');
            subject.removeAttribute('required');
            message.removeAttribute('required');
        });
        
        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Adres panoya kopyalandı!');
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
@endsection