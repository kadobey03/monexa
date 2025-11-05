<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Ödeme Yöntemleri</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Ödeme yöntemlerini ekle, düzenle ve yönet</p>
        </div>
        <button onclick="openAddModal()" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Yeni Ekle
        </button>
    </div>

    <!-- Payment Methods Table -->
    <div class="bg-white dark:bg-admin-800 rounded-xl shadow-lg border border-gray-200 dark:border-admin-700 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border-b border-gray-200 dark:border-admin-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mevcut Ödeme Yöntemleri</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-admin-600">
                <thead class="bg-gray-50 dark:bg-admin-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Yöntem Adı
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Tip
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Kullanım Alanı
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Durum
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-600">
                    @foreach ($methods as $method)
                        <tr class="hover:bg-gray-50 dark:hover:bg-admin-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($method->url)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $method->url }}" alt="{{ $method->name }}" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiByeD0iMjAiIGZpbGw9IiNGM0Y0RjYiLz4KPHN2ZyB4PSIxMCIgeT0iMTAiIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIj4KPHBhdGggZD0iTTEyIDEyQzEzLjEwNDYgMTIgMTQgMTEuMTA0NiAxNCA5LjVDMTQgNy44OTU0MyAxMy4xMDQ2IDcgMTIgN0MxMC44OTU0IDcgMTAgNy44OTU0MyAxMCA5LjVDMTAgMTEuMTA0NiAxMC44OTU0IDEyIDEyIDEyWiIgZmlsbD0iIzZCNzI4MCIvPgo8L3N2Zz4KPC9zdmc+'">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $method->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $method->methodtype == 'crypto' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                                    {{ ucfirst($method->methodtype) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ ucfirst($method->type) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($method->status == 'enabled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ ucfirst($method->status) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ ucfirst($method->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('editpaymethod', $method->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 text-sm font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Görüntüle
                                </a>
                                
                                @if ($method->defaultpay == 'yes')
                                    <button disabled class="inline-flex items-center px-3 py-1.5 bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 text-sm font-medium rounded-lg cursor-not-allowed">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Sil
                                    </button>
                                @else
                                    <a href="{{ route('deletepaymethod', $method->id) }}" onclick="return confirm('Bu ödeme yöntemini silmek istediğinizden emin misiniz?')" class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:hover:bg-red-800 text-red-700 dark:text-red-300 text-sm font-medium rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Sil
                                    </a>
                                @endif
                                
                                @if ($method->status == 'enabled')
                                    <a href="{{ route('togglestatus', $method->id) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900 dark:hover:bg-yellow-800 text-yellow-700 dark:text-yellow-300 text-sm font-medium rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                        </svg>
                                        Devre Dışı
                                    </a>
                                @else
                                    <a href="{{ route('togglestatus', $method->id) }}" class="inline-flex items-center px-3 py-1.5 bg-green-100 hover:bg-green-200 dark:bg-green-900 dark:hover:bg-green-800 text-green-700 dark:text-green-300 text-sm font-medium rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Etkinleştir
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add New Payment Method Modal -->
<div id="addPaymentModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeAddModal()"></div>
        
        <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white dark:bg-admin-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-admin-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Yeni Ödeme Yöntemi Ekle
                    </h3>
                    <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="mt-6">
                    <form method="POST" action="{{ route('addpaymethod') }}" enctype="multipart/form-data" id="addPaymentForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="md:col-span-2">
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    Temel Bilgiler
                                </h4>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ödeme Yöntemi Adı</label>
                                <input type="text" name="name" required class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200" placeholder="Örn: PayPal, Banka Havalesi">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimum Tutar</label>
                                <input type="number" name="minimum" required class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200" placeholder="0">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sadece çekim işlemlerinde geçerli</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Maksimum Tutar</label>
                                <input type="number" name="maximum" required class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200" placeholder="1000">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sadece çekim işlemlerinde geçerli</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Komisyon</label>
                                <input type="number" name="charges" required class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200" placeholder="0">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sadece çekim işlemlerinde geçerli</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Komisyon Tipi</label>
                                <select name="chargetype" class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200">
                                    <option value="percentage">Yüzde (%)</option>
                                    <option value="fixed">Sabit ({{ $settings->currency }})</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tip</label>
                                <select name="methodtype" id="methodtype" required class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200">
                                    <option value="currency">Para Birimi</option>
                                    <option value="crypto">Kripto</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Logo URL</label>
                                <input type="text" name="url" class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200" placeholder="https://example.com/logo.png">
                            </div>
                            
                            <!-- Currency Fields -->
                            <div class="md:col-span-2 currency-fields">
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    Banka Bilgileri
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Banka Adı</label>
                                        <input type="text" name="bank" class="currency-input w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200" placeholder="Örn: Ziraat Bankası">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Hesap Sahibi</label>
                                        <input type="text" name="account_name" class="currency-input w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200" placeholder="Hesap sahibinin adı">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Hesap Numarası</label>
                                        <input type="number" name="account_number" class="currency-input w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200" placeholder="1234567890">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Swift/Diğer Kod</label>
                                        <input type="text" name="swift" class="currency-input w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200" placeholder="SWIFT kodu">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Crypto Fields -->
                            <div class="md:col-span-2 crypto-fields hidden">
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    Kripto Para Bilgileri
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cüzdan Adresi</label>
                                        <input type="text" name="walletaddress" class="crypto-input w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200" placeholder="Cüzdan adresi">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Network Tipi</label>
                                        <input type="text" name="wallettype" class="crypto-input w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200" placeholder="Örn: ERC20, BEP20">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">QR Kod Görseli (Opsiyonel)</label>
                                        <input type="file" name="barcode" accept="image/*" class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Önerilen boyut: 575px x 575px</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Settings -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Durum</label>
                                <select name="status" required class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200">
                                    <option value="enabled">Etkin</option>
                                    <option value="disabled">Devre Dışı</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kullanım Alanı</label>
                                <select name="typefor" required class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200">
                                    <option value="withdrawal">Çekim</option>
                                    <option value="deposit">Yatırım</option>
                                    <option value="both">Her İkisi</option>
                                </select>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Opsiyonel Not</label>
                                <input type="text" name="note" class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200" placeholder="Örn: Ödeme 24 saat içinde tamamlanır">
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200 dark:border-admin-600">
                            <button type="button" onclick="closeAddModal()" class="px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-admin-600 dark:hover:bg-admin-500 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors duration-200">
                                İptal
                            </button>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                                Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Modern Vanilla JavaScript - No Alpine, No Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        const methodTypeSelect = document.getElementById('methodtype');
        const currencyFields = document.querySelector('.currency-fields');
        const cryptoFields = document.querySelector('.crypto-fields');
        const currencyInputs = document.querySelectorAll('.currency-input');
        const cryptoInputs = document.querySelectorAll('.crypto-input');
        
        // Set initial required attributes
        currencyInputs.forEach((input, index) => {
            if (index < 3) input.setAttribute('required', '');
        });
        
        // Method type change handler
        methodTypeSelect.addEventListener('change', function() {
            if (this.value === 'currency') {
                // Show currency fields
                currencyFields.classList.remove('hidden');
                cryptoFields.classList.add('hidden');
                
                // Set currency inputs as required
                currencyInputs.forEach((input, index) => {
                    if (index < 3) input.setAttribute('required', '');
                });
                
                // Remove required from crypto inputs
                cryptoInputs.forEach((input, index) => {
                    if (index < 2) input.removeAttribute('required');
                });
            } else {
                // Show crypto fields
                cryptoFields.classList.remove('hidden');
                currencyFields.classList.add('hidden');
                
                // Set crypto inputs as required
                cryptoInputs.forEach((input, index) => {
                    if (index < 2) input.setAttribute('required', '');
                });
                
                // Remove required from currency inputs
                currencyInputs.forEach(input => {
                    input.removeAttribute('required');
                });
            }
        });
        
        // Form submission handler
        document.getElementById('addPaymentForm').addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <span class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Kaydediliyor...
                </span>
            `;
            
            // Form will submit normally, reset handled on page reload
        });
    });
    
    // Modal functions
    function openAddModal() {
        document.getElementById('addPaymentModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeAddModal() {
        document.getElementById('addPaymentModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddModal();
        }
    });
</script>