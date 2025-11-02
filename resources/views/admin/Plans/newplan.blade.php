@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-gray-50">
        @include('admin.topmenu')
        @include('admin.sidebar')
        
        <!-- Modern Main Content -->
        <div class="admin-main-content flex-1 lg:ml-64 transition-all duration-300 pt-16 lg:pt-20">
            <!-- Page Header -->
            <div class="bg-white shadow-sm border-b border-gray-200 px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                            <div class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                </svg>
                            </div>
                            Yatırım Planı Ekle
                        </h1>
                        <p class="text-gray-600 mt-1">Yeni yatırım planı oluşturun ve yapılandırın</p>
                    </div>
                    <div>
                        <a href="{{ route('plans') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Geri Dön
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="px-4 sm:px-6 lg:px-8 py-8">
                <x-danger-alert />
                <x-success-alert />
                
                <div class="max-w-4xl">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Plan Detayları</h2>
                            <p class="text-sm text-gray-600 mt-1">Yatırım planının temel bilgilerini girin</p>
                        </div>
                        
                        <div class="p-6">
                            <form role="form" method="post" action="{{ route('addplan') }}" class="space-y-6">
                                @csrf
                                
                                <!-- Plan Basic Information -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Plan Adı</label>
                                        <input type="text" name="name" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Plan adını girin">
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Plan Fiyatı ({{ $settings->currency }})</label>
                                        <input type="number" name="price" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Plan fiyatını girin">
                                        <p class="text-xs text-gray-500">Bu planda kullanıcıların yatırım yapabileceği maksimum tutar</p>
                                    </div>
                                </div>

                                <!-- Price Range -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Minimum Fiyat ({{ $settings->currency }})</label>
                                        <input type="number" name="min_price" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Minimum tutarı girin">
                                        <p class="text-xs text-gray-500">Bu planda yatırım yapılabilecek minimum tutar</p>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Maksimum Fiyat ({{ $settings->currency }})</label>
                                        <input type="number" name="max_price" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Maksimum tutarı girin">
                                        <p class="text-xs text-gray-500">Plan fiyatı ile aynı, virgüllü rakam kullanmayın</p>
                                    </div>
                                </div>

                                <!-- Return Configuration -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Minimum Getiri (%)</label>
                                        <input type="number" step="any" name="minr" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Minimum getiri oranını girin">
                                        <p class="text-xs text-gray-500">Bu plan için minimum getiri oranı (ROI)</p>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Maksimum Getiri (%)</label>
                                        <input type="number" step="any" name="maxr" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Maksimum getiri oranını girin">
                                        <p class="text-xs text-gray-500">Bu plan için maksimum getiri oranı (ROI)</p>
                                    </div>
                                </div>

                                <!-- Bonus and Tags -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Hediye Bonus ({{ $settings->currency }})</label>
                                        <input type="number" step="any" name="gift" value="0" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Ek bonus tutarını girin">
                                        <p class="text-xs text-gray-500">Bu planı satın alan kullanıcıya verilecek isteğe bağlı bonus</p>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Plan Etiketi</label>
                                        <input type="text" name="tag" value='{{ $plan->tag ?? '' }}'
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Örn: Popüler, VIP, Önerilen">
                                        <p class="text-xs text-gray-500">İsteğe bağlı plan etiketi (Popüler, VIP vb.)</p>
                                    </div>
                                </div>

                                <!-- Investment Type and Intervals -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Yatırım Türü</label>
                                        <select name="investment_type" required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                            <option value="">Yatırım türünü seçin</option>
                                            <option value="stock">Hisse Senedi</option>
                                            <option value="crypto">Kripto Para</option>
                                            <option value="real_estate">Emlak</option>
                                        </select>
                                        <p class="text-xs text-gray-500">Bu planın temsil ettiği yatırım türü</p>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Ödeme Aralığı</label>
                                        <select name="t_interval"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                            <option>Monthly</option>
                                            <option>Weekly</option>
                                            <option>Daily</option>
                                            <option>Hourly</option>
                                            <option>Every 30 Minutes</option>
                                            <option>Every 10 Minutes</option>
                                        </select>
                                        <p class="text-xs text-gray-500">Sistemin ne sıklıkla kar ekleyeceğini belirtir</p>
                                    </div>
                                </div>

                                <!-- Top-up Configuration -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Ödeme Türü</label>
                                        <select name="t_type"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                            <option>Percentage</option>
                                            <option>Fixed</option>
                                        </select>
                                        <p class="text-xs text-gray-500">Karın yüzde (%) mi sabit tutar mı olacağını belirtir</p>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Ödeme Tutarı (% veya {{ $settings->currency }})</label>
                                        <input type="number" step="any" name="t_amount" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                               placeholder="Ödeme tutarını girin">
                                        <p class="text-xs text-gray-500">Yukarıda seçilen türe göre kar olarak eklenecek tutar</p>
                                    </div>
                                </div>

                                <!-- Duration -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Yatırım Süresi</label>
                                    <input type="text" name="expiration" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all duration-200"
                                           placeholder="Örn: 1 Days, 2 Weeks, 1 Months">
                                    <p class="text-xs text-gray-500">
                                        Yatırım planının ne kadar süreceği.
                                        <button type="button" onclick="document.getElementById('durationModal').style.display='flex'"
                                                class="text-blue-600 hover:text-blue-800 underline">
                                            Süre ayarlama kılavuzu
                                        </button>
                                    </p>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-6 border-t border-gray-200">
                                    <button type="submit"
                                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Planı Ekle
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Modern Duration Guide Modal -->
        <div id="durationModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full mx-4 transform transition-all duration-300">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <div class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Süre Belirleme Kılavuzu
                    </h3>
                    <button onclick="document.getElementById('durationModal').classList.add('hidden')"
                            class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6 space-y-6">
                    <div class="bg-blue-50 rounded-2xl p-4 border border-blue-200">
                        <h4 class="font-bold text-blue-900 mb-3">📋 Önemli Kurallar:</h4>
                        <div class="space-y-2 text-blue-800">
                            <p><strong>1.</strong> Zaman diliminden önce mutlaka bir rakam yazın (harfle değil)</p>
                            <p><strong>2.</strong> Rakamdan sonra mutlaka boşluk bırakın</p>
                            <p><strong>3.</strong> Zaman diliminin ilk harfi büyük olmalı ve sonuna 's' ekleyin</p>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 rounded-2xl p-4 border border-green-200">
                        <h4 class="font-bold text-green-900 mb-3">✅ Doğru Örnekler:</h4>
                        <div class="grid grid-cols-2 gap-3 text-green-800">
                            <div class="bg-white rounded-lg p-3 border border-green-300">
                                <code class="font-mono font-bold">1 Days</code>
                            </div>
                            <div class="bg-white rounded-lg p-3 border border-green-300">
                                <code class="font-mono font-bold">3 Weeks</code>
                            </div>
                            <div class="bg-white rounded-lg p-3 border border-green-300">
                                <code class="font-mono font-bold">1 Hours</code>
                            </div>
                            <div class="bg-white rounded-lg p-3 border border-green-300">
                                <code class="font-mono font-bold">48 Hours</code>
                            </div>
                            <div class="bg-white rounded-lg p-3 border border-green-300">
                                <code class="font-mono font-bold">4 Months</code>
                            </div>
                            <div class="bg-white rounded-lg p-3 border border-green-300">
                                <code class="font-mono font-bold">1 Years</code>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-red-50 rounded-2xl p-4 border border-red-200">
                        <h4 class="font-bold text-red-900 mb-3">❌ Yanlış Örnekler:</h4>
                        <div class="space-y-2 text-red-800">
                            <p><code class="bg-red-100 px-2 py-1 rounded">one day</code> - Rakam harfle yazılmış</p>
                            <p><code class="bg-red-100 px-2 py-1 rounded">1day</code> - Boşluk yok</p>
                            <p><code class="bg-red-100 px-2 py-1 rounded">1 day</code> - Sonunda 's' yok</p>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-end p-6 border-t border-gray-200">
                    <button onclick="document.getElementById('durationModal').classList.add('hidden')"
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors duration-200">
                        Anladım
                    </button>
                </div>
            </div>
        </div>
    
        <script>
            // Modern modal functionality
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('durationModal');
                
                // Update modal trigger button
                const triggerButton = document.querySelector('button[onclick*="durationModal"]');
                if (triggerButton) {
                    triggerButton.onclick = function() {
                        modal.classList.remove('hidden');
                    };
                }
                
                // Close modal when clicking outside
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                    }
                });
                
                // ESC key to close modal
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                        modal.classList.add('hidden');
                    }
                });
            });
        </script>
    @endsection
