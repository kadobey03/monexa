@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('kyc') }}"
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Geri Dön
                    </a>
                </div>

                <!-- Header Section -->
                <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-2xl p-8 mb-8">
                    <div class="absolute inset-0 bg-black opacity-20"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-purple-600/10"></div>
                    <div class="relative">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div>
                                <div class="flex items-center mb-3">
                                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mr-4">
                                        <span class="text-2xl font-bold text-white">
                                            {{ strtoupper(substr($kyc->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h1 class="text-3xl font-bold text-white">{{ $kyc->user->name }}</h1>
                                        <p class="text-indigo-100">KYC Kimlik Doğrulama Başvurusu</p>
                                    </div>
                                </div>
                                @if ($kyc->status == 'Verified')
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Doğrulandı
                                    </span>
                                @elseif ($kyc->status == 'Pending')
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <i class="fas fa-clock mr-2"></i>
                                        Beklemede
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800 border border-red-200">
                                        <i class="fas fa-times-circle mr-2"></i>
                                        {{ $kyc->status }}
                                    </span>
                                @endif
                            </div>
                            <div class="mt-4 md:mt-0">
                                <button onclick="openActionModal()"
                                        class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-xl hover:bg-white/30 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <i class="fas fa-cog mr-2"></i>
                                    KYC İşlemi Yap
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -right-16 -bottom-16 w-32 h-32 bg-gradient-to-br from-white/10 to-pink-300/20 rounded-full blur-2xl"></div>
                    <div class="absolute -left-16 -top-16 w-24 h-24 bg-gradient-to-br from-purple-400/20 to-indigo-400/20 rounded-full blur-xl"></div>
                </div>

                <x-danger-alert />
                <x-success-alert />

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    <!-- Personal Information -->
                    <div class="xl:col-span-2">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                    <i class="fas fa-user mr-3 text-blue-600"></i>
                                    Kişisel Bilgiler
                                </h3>
                                <p class="text-gray-600 mt-1">Kullanıcının kimlik ve iletişim bilgileri</p>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="group">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-id-card text-gray-400 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-500">Ad</span>
                                        </div>
                                        <div class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3 group-hover:bg-gray-100 transition-colors duration-200">
                                            {{ $kyc->first_name }}
                                        </div>
                                    </div>

                                    <div class="group">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-id-card text-gray-400 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-500">Soyad</span>
                                        </div>
                                        <div class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3 group-hover:bg-gray-100 transition-colors duration-200">
                                            {{ $kyc->last_name }}
                                        </div>
                                    </div>

                                    <div class="group">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-500">E-posta</span>
                                        </div>
                                        <div class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3 group-hover:bg-gray-100 transition-colors duration-200">
                                            {{ $kyc->email }}
                                        </div>
                                    </div>

                                    <div class="group">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-phone text-gray-400 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-500">Telefon Numarası</span>
                                        </div>
                                        <div class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3 group-hover:bg-gray-100 transition-colors duration-200">
                                            {{ $kyc->phone_number }}
                                        </div>
                                    </div>

                                    <div class="group">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-500">Doğum Tarihi</span>
                                        </div>
                                        <div class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3 group-hover:bg-gray-100 transition-colors duration-200">
                                            {{ \Carbon\Carbon::parse($kyc->dob)->format('d.m.Y') }}
                                        </div>
                                    </div>

                                    <div class="group">
                                        <div class="flex items-center mb-2">
                                            <i class="fab fa-twitter text-gray-400 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-500">Sosyal Medya</span>
                                        </div>
                                        <div class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3 group-hover:bg-gray-100 transition-colors duration-200">
                                            {{ $kyc->social_media ?: 'Belirtilmemiş' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mt-6">
                            <div class="p-6 bg-gradient-to-r from-green-50 to-teal-50 border-b border-gray-200">
                                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                    <i class="fas fa-map-marker-alt mr-3 text-green-600"></i>
                                    Adres Bilgileri
                                </h3>
                                <p class="text-gray-600 mt-1">Kullanıcının kayıtlı adres bilgileri</p>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2 group">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-home text-gray-400 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-500">Adres</span>
                                        </div>
                                        <div class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3 group-hover:bg-gray-100 transition-colors duration-200">
                                            {{ $kyc->address }}
                                        </div>
                                    </div>

                                    <div class="group">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-city text-gray-400 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-500">Şehir</span>
                                        </div>
                                        <div class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3 group-hover:bg-gray-100 transition-colors duration-200">
                                            {{ $kyc->city }}
                                        </div>
                                    </div>

                                    <div class="group">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-map text-gray-400 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-500">Eyalet/İl</span>
                                        </div>
                                        <div class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3 group-hover:bg-gray-100 transition-colors duration-200">
                                            {{ $kyc->state }}
                                        </div>
                                    </div>

                                    <div class="group md:col-span-2">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-flag text-gray-400 mr-2"></i>
                                            <span class="text-sm font-medium text-gray-500">Ülke</span>
                                        </div>
                                        <div class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3 group-hover:bg-gray-100 transition-colors duration-200">
                                            {{ $kyc->country }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Document Information -->
                    <div class="xl:col-span-1">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="p-6 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                    <i class="fas fa-file-alt mr-3 text-purple-600"></i>
                                    Kimlik Belgeleri
                                </h3>
                                <p class="text-gray-600 mt-1">Yüklenen kimlik doğrulama belgeleri</p>
                            </div>
                            <div class="p-6">
                                <!-- Document Type -->
                                <div class="mb-6">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-certificate text-gray-400 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-500">Belge Türü</span>
                                    </div>
                                    <div class="text-lg font-semibold text-gray-900 bg-purple-50 rounded-lg p-3">
                                        {{ $kyc->document_type }}
                                    </div>
                                </div>

                                <!-- Document Images -->
                                <div class="space-y-6">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <span class="text-sm font-medium text-gray-500 flex items-center justify-center">
                                                <i class="fas fa-id-card mr-2"></i>
                                                Belgenin Ön Yüzü
                                            </span>
                                        </div>
                                        <div class="relative group">
                                            <img src="{{ asset('storage/app/public/' . $kyc->frontimg) }}"
                                                 alt="Kimlik Ön Yüz"
                                                 class="w-full h-auto rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-200 cursor-pointer"
                                                 onclick="openImageModal('{{ asset('storage/app/public/' . $kyc->frontimg) }}', 'Belgenin Ön Yüzü')">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all duration-200 flex items-center justify-center">
                                                <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <div class="mb-3">
                                            <span class="text-sm font-medium text-gray-500 flex items-center justify-center">
                                                <i class="fas fa-id-card mr-2"></i>
                                                Belgenin Arka Yüzü
                                            </span>
                                        </div>
                                        <div class="relative group">
                                            <img src="{{ asset('storage/app/public/' . $kyc->backimg) }}"
                                                 alt="Kimlik Arka Yüz"
                                                 class="w-full h-auto rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-200 cursor-pointer"
                                                 onclick="openImageModal('{{ asset('storage/app/public/' . $kyc->backimg) }}', 'Belgenin Arka Yüzü')">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all duration-200 flex items-center justify-center">
                                                <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Modal -->
                <div id="actionModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                            <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 rounded-t-2xl">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <i class="fas fa-cog mr-3 text-blue-600"></i>
                                        KYC İşlemi
                                    </h3>
                                    <button onclick="closeActionModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>
                                <p class="text-gray-600 mt-1">Başvuruyu onaylayın veya reddedin</p>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('processkyc') }}" method="post" id="kycForm">
                                    @csrf
                                    <div class="space-y-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-clipboard-check mr-2"></i>
                                                İşlem Türü
                                            </label>
                                            <select name="action" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" required>
                                                <option value="Accept">Kullanıcıyı kabul et ve doğrula</option>
                                                <option value="Reject">Reddet ve doğrulanmamış bırak</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-envelope mr-2"></i>
                                                E-posta Konusu
                                            </label>
                                            <input type="text" name="subject"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                                   placeholder="Hesap başarıyla doğrulandı" required>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-comment mr-2"></i>
                                                Kullanıcıya Gönderilecek Mesaj
                                            </label>
                                            <textarea name="message" rows="4"
                                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                                                      placeholder="Mesaj Girin" required>Belgeleri inceledikten sonra hesabınız doğrulandı. Artık tüm hizmetlerimizden kısıtlama olmadan yararlanabilirsiniz. Teşekkürler!!</textarea>
                                        </div>

                                        <input type="hidden" name="kyc_id" value="{{ $kyc->id }}">

                                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                            <button type="button" onclick="closeActionModal()"
                                                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-all duration-200">
                                                İptal
                                            </button>
                                            <button type="submit"
                                                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-purple-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-lg hover:shadow-xl">
                                                <i class="fas fa-check mr-2"></i>
                                                İşlemi Onayla
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Modal -->
                <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 z-60 hidden">
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div class="relative max-w-4xl w-full">
                            <button onclick="closeImageModal()"
                                    class="absolute top-4 right-4 bg-white/20 backdrop-blur-sm text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-white/30 transition-all duration-200 z-10">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="bg-white rounded-2xl overflow-hidden">
                                <div class="p-4 bg-gray-50 border-b">
                                    <h3 id="imageModalTitle" class="text-lg font-semibold text-gray-900"></h3>
                                </div>
                                <div class="p-4">
                                    <img id="imageModalImg" src="" alt="" class="w-full h-auto rounded-lg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openActionModal() {
            document.getElementById('actionModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeActionModal() {
            document.getElementById('actionModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function openImageModal(imageSrc, title) {
            document.getElementById('imageModalImg').src = imageSrc;
            document.getElementById('imageModalTitle').textContent = title;
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.id === 'actionModal') {
                closeActionModal();
            }
            if (e.target.id === 'imageModal') {
                closeImageModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeActionModal();
                closeImageModal();
            }
        });

        // Form submission with loading state
        document.getElementById('kycForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>İşlem Yapılıyor...';
            submitBtn.disabled = true;
            
            // Re-enable button after 10 seconds as fallback
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 10000);
        });
    </script>

    <style>
        @media (max-width: 768px) {
            .grid-cols-1.md\\:grid-cols-2 {
                grid-template-columns: 1fr;
            }
            
            .xl\\:col-span-2, .xl\\:col-span-1 {
                grid-column: span 1;
            }
        }
    </style>
@endsection
