@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <!-- Header Section -->
                <div class="relative overflow-hidden bg-gradient-to-br from-teal-600 via-green-600 to-blue-700 rounded-2xl p-8 mb-8">
                    <div class="absolute inset-0 bg-black opacity-20"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-teal-600/10 to-blue-600/10"></div>
                    <div class="relative">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div>
                                <h1 class="text-4xl font-bold text-white mb-2">
                                    <i class="fas fa-plus-circle mr-3 text-teal-200"></i>
                                    Yeni Sinyal Ekle
                                </h1>
                                <p class="text-teal-100 text-lg">
                                    Yeni bir trading sinyali oluşturun ve kullanıcılarınıza sunun
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="{{ route('signals') }}"
                                   class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-xl hover:bg-white/30 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Sinyallere Dön
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -right-16 -bottom-16 w-32 h-32 bg-gradient-to-br from-white/10 to-blue-300/20 rounded-full blur-2xl"></div>
                    <div class="absolute -left-16 -top-16 w-24 h-24 bg-gradient-to-br from-teal-400/20 to-green-400/20 rounded-full blur-xl"></div>
                </div>

                <x-danger-alert />
                <x-success-alert />

                <!-- Form Section -->
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-chart-line mr-3 text-green-600"></i>
                                Sinyal Bilgileri
                            </h3>
                            <p class="text-gray-600 mt-1">Trading sinyalinizin detaylarını girin</p>
                        </div>

                        <div class="p-8">
                            <form role="form" method="post" action="{{ route('addsignal') }}" id="signalForm">
                                @csrf
                                <div class="space-y-8">
                                    <!-- Basic Information -->
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                        <div class="space-y-2">
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                                <i class="fas fa-tag mr-2 text-gray-400"></i>
                                                Sinyal Adı
                                            </label>
                                            <input type="text" name="name"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                                   placeholder="Örn: Premium Forex Sinyali" required>
                                            <p class="text-sm text-gray-500">Sinyaliniz için açık ve anlaşılır bir isim girin</p>
                                        </div>

                                        <div class="space-y-2">
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                                <i class="fas fa-dollar-sign mr-2 text-gray-400"></i>
                                                Sinyal Fiyatı ({{ $settings->currency }})
                                            </label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 font-medium">{{ $settings->currency }}</span>
                                                </div>
                                                <input type="number" name="price"
                                                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                                       placeholder="0" min="0" step="0.01" required>
                                            </div>
                                            <p class="text-sm text-gray-500">Kullanıcıların bu sinyal için ödeyeceği tutar</p>
                                        </div>
                                    </div>

                                    <!-- Performance Settings -->
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                        <div class="space-y-2">
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                                <i class="fas fa-percentage mr-2 text-gray-400"></i>
                                                Getiri Oranı (%)
                                            </label>
                                            <div class="relative">
                                                <input type="number" name="increment_amount"
                                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                                       placeholder="0.00" min="0" step="0.01" required>
                                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 font-medium">%</span>
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-500">Bu sinyalden beklenen ortalama getiri yüzdesi</p>
                                        </div>

                                        <div class="space-y-2">
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                                <i class="fas fa-info-circle mr-2 text-gray-400"></i>
                                                Sinyal Etiketi (İsteğe Bağlı)
                                            </label>
                                            <select name="tag" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                                <option value="">Etiket seçin...</option>
                                                <option value="HOT">🔥 HOT</option>
                                                <option value="NEW">🆕 YENİ</option>
                                                <option value="PREMIUM">⭐ PREMİUM</option>
                                                <option value="POPULAR">📈 POPÜLER</option>
                                                <option value="LIMITED">⏰ SINIRLI</option>
                                            </select>
                                            <p class="text-sm text-gray-500">Sinyalinizi öne çıkaracak bir etiket seçin</p>
                                        </div>
                                    </div>

                                    <!-- Signal Preview -->
                                    <div id="signalPreview" class="border-2 border-dashed border-gray-200 rounded-2xl p-6 bg-gray-50 hidden">
                                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                            <i class="fas fa-eye mr-2 text-blue-500"></i>
                                            Sinyal Önizleme
                                        </h4>
                                        <div class="bg-white rounded-xl p-4 shadow-sm">
                                            <div class="flex items-center justify-between mb-4">
                                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-chart-line text-white text-xl"></i>
                                                </div>
                                                <span id="previewTag" class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium hidden"></span>
                                            </div>
                                            <h5 id="previewName" class="text-xl font-bold text-gray-900 mb-2">Sinyal Adı</h5>
                                            <div class="text-3xl font-bold text-gray-900 mb-4">
                                                <span class="text-lg text-gray-500">{{ $settings->currency }}</span>
                                                <span id="previewPrice">0</span>
                                            </div>
                                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                <span class="font-medium text-gray-700">Getiri Oranı</span>
                                                <span id="previewPercentage" class="font-bold text-green-600">0%</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex justify-between pt-8 border-t border-gray-200">
                                        <button type="button" onclick="togglePreview()"
                                                class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200">
                                            <i class="fas fa-eye mr-2"></i>
                                            Önizle
                                        </button>
                                        <div class="flex space-x-4">
                                            <button type="button" onclick="resetForm()"
                                                    class="px-6 py-3 bg-red-100 text-red-700 font-semibold rounded-xl hover:bg-red-200 transition-all duration-200">
                                                <i class="fas fa-redo mr-2"></i>
                                                Sıfırla
                                            </button>
                                            <button type="submit"
                                                    class="px-8 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-teal-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-lg hover:shadow-xl">
                                                <i class="fas fa-plus mr-2"></i>
                                                Sinyal Oluştur
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tips Section -->
                    <div class="mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <i class="fas fa-lightbulb mr-3 text-yellow-600"></i>
                                Başarılı Sinyal İpuçları
                            </h3>
                            <p class="text-gray-600 mt-1">Daha etkili sinyaller oluşturmak için önerilerimiz</p>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-check text-green-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Net ve Açık İsim</h4>
                                        <p class="text-sm text-gray-600 mt-1">Sinyalinizin ne hakkında olduğunu açıkça belirten bir isim seçin.</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-chart-line text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Gerçekçi Getiri</h4>
                                        <p class="text-sm text-gray-600 mt-1">Abartılmayan, sürdürülebilir getiri oranları belirleyin.</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-users text-purple-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Hedef Kitle</h4>
                                        <p class="text-sm text-gray-600 mt-1">Hangi yatırımcı profiline hitap edeceğinizi düşünün.</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-tag text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Doğru Etiket</h4>
                                        <p class="text-sm text-gray-600 mt-1">Sinyalinizi öne çıkaracak uygun etiket kullanın.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePreview() {
            const preview = document.getElementById('signalPreview');
            if (preview.classList.contains('hidden')) {
                updatePreview();
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }

        function updatePreview() {
            const name = document.querySelector('input[name="name"]').value;
            const price = document.querySelector('input[name="price"]').value;
            const percentage = document.querySelector('input[name="increment_amount"]').value;
            const tag = document.querySelector('select[name="tag"]').value;
            
            document.getElementById('previewName').textContent = name || 'Sinyal Adı';
            document.getElementById('previewPrice').textContent = price || '0';
            document.getElementById('previewPercentage').textContent = percentage ? percentage + '%' : '0%';
            
            const tagElement = document.getElementById('previewTag');
            if (tag) {
                tagElement.textContent = tag;
                tagElement.classList.remove('hidden');
            } else {
                tagElement.classList.add('hidden');
            }
        }

        function resetForm() {
            if (confirm('Formu sıfırlamak istediğinizden emin misiniz? Tüm girilen veriler silinecektir.')) {
                document.getElementById('signalForm').reset();
                document.getElementById('signalPreview').classList.add('hidden');
            }
        }

        // Real-time preview updates
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('input[name="name"]').addEventListener('input', updatePreview);
            document.querySelector('input[name="price"]').addEventListener('input', updatePreview);
            document.querySelector('input[name="increment_amount"]').addEventListener('input', updatePreview);
            document.querySelector('select[name="tag"]').addEventListener('change', updatePreview);
        });

        // Form submission with loading state
        document.getElementById('signalForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Oluşturuluyor...';
            submitBtn.disabled = true;
            
            // Re-enable button after 10 seconds as fallback
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 10000);
        });

        // Input validation and formatting
        document.querySelector('input[name="price"]').addEventListener('input', function(e) {
            const value = parseFloat(e.target.value);
            if (value < 0) e.target.value = 0;
        });

        document.querySelector('input[name="increment_amount"]').addEventListener('input', function(e) {
            const value = parseFloat(e.target.value);
            if (value < 0) e.target.value = 0;
            if (value > 100) e.target.value = 100;
        });
    </script>

    <style>
        @media (max-width: 768px) {
            .grid-cols-1.lg\\:grid-cols-2 {
                grid-template-columns: 1fr;
            }
            
            .grid-cols-1.md\\:grid-cols-2 {
                grid-template-columns: 1fr;
            }
        }

        /* Custom animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #signalPreview:not(.hidden) {
            animation: slideIn 0.3s ease-out;
        }
    </style>
@endsection
