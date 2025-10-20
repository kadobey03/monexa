@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <!-- Header Section -->
                <div class="relative overflow-hidden bg-gradient-to-br from-green-600 via-teal-600 to-blue-700 rounded-2xl p-8 mb-8">
                    <div class="absolute inset-0 bg-black opacity-20"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-600/10 to-blue-600/10"></div>
                    <div class="relative">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div>
                                <h1 class="text-4xl font-bold text-white mb-2">
                                    <i class="fas fa-chart-line mr-3 text-green-200"></i>
                                    Sinyal Yönetimi
                                </h1>
                                <p class="text-green-100 text-lg">
                                    Trading sinyallerini oluşturun ve yönetin
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="{{ route('newsignal') }}"
                                   class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-xl hover:bg-white/30 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <i class="fas fa-plus mr-2"></i>
                                    Yeni Sinyal Ekle
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -right-16 -bottom-16 w-32 h-32 bg-gradient-to-br from-white/10 to-blue-300/20 rounded-full blur-2xl"></div>
                    <div class="absolute -left-16 -top-16 w-24 h-24 bg-gradient-to-br from-green-400/20 to-teal-400/20 rounded-full blur-xl"></div>
                </div>

                <x-danger-alert />
                <x-success-alert />

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-signal text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $signals->count() }}</div>
                                <div class="text-gray-500 text-sm">Toplam Sinyal</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-chart-line text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $signals->where('increment_amount', '>', 0)->count() }}
                                </div>
                                <div class="text-gray-500 text-sm">Aktif Sinyal</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-percentage text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ number_format($signals->avg('increment_amount'), 1) }}%
                                </div>
                                <div class="text-gray-500 text-sm">Ortalama Getiri</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $settings->currency }}{{ number_format($signals->avg('price')) }}
                                </div>
                                <div class="text-gray-500 text-sm">Ortalama Fiyat</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signals Grid -->
                <div class="mb-8">
                    @forelse ($signals as $signal)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($signals as $signal)
                                <div class="group">
                                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                                        <!-- Header with gradient -->
                                        <div class="relative p-6 bg-gradient-to-br from-{{ $loop->iteration % 4 == 1 ? 'blue' : ($loop->iteration % 4 == 2 ? 'green' : ($loop->iteration % 4 == 3 ? 'purple' : 'indigo')) }}-500 to-{{ $loop->iteration % 4 == 1 ? 'purple' : ($loop->iteration % 4 == 2 ? 'teal' : ($loop->iteration % 4 == 3 ? 'pink' : 'blue')) }}-600 text-white">
                                            <div class="absolute inset-0 bg-black opacity-10"></div>
                                            <div class="relative">
                                                <div class="flex items-center justify-between mb-4">
                                                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                                        <i class="fas fa-chart-line text-xl"></i>
                                                    </div>
                                                    @if($signal->tag)
                                                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold">
                                                            {{ $signal->tag }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <h3 class="text-xl font-bold mb-2">{{ $signal->name }}</h3>
                                                <p class="text-white/80">Trading Sinyali</p>
                                            </div>
                                        </div>

                                        <!-- Content -->
                                        <div class="p-6">
                                            <!-- Price Display -->
                                            <div class="text-center mb-6">
                                                <div class="text-3xl font-bold text-gray-900 mb-2">
                                                    <span class="text-lg text-gray-500">{{ $settings->currency }}</span>
                                                    {{ number_format($signal->price) }}
                                                </div>
                                                <div class="text-sm text-gray-500">Sinyal Fiyatı</div>
                                            </div>

                                            <!-- Features -->
                                            <div class="space-y-4 mb-6">
                                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-dollar-sign text-green-500 mr-3"></i>
                                                        <span class="font-medium text-gray-700">Fiyat</span>
                                                    </div>
                                                    <span class="font-bold text-gray-900">
                                                        {{ $settings->currency }}{{ number_format($signal->price) }}
                                                    </span>
                                                </div>

                                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-percentage text-blue-500 mr-3"></i>
                                                        <span class="font-medium text-gray-700">Getiri Oranı</span>
                                                    </div>
                                                    <span class="font-bold text-green-600">
                                                        {{ $signal->increment_amount }}%
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="flex space-x-3">
                                                <a href="{{ route('editsignal', $signal->id) }}"
                                                   class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-100 text-blue-700 font-semibold rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                                    <i class="fas fa-edit mr-2"></i>
                                                    Düzenle
                                                </a>
                                                <button onclick="deleteSignal({{ $signal->id }})"
                                                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-red-100 text-red-700 font-semibold rounded-lg hover:bg-red-200 transition-colors duration-200">
                                                    <i class="fas fa-trash mr-2"></i>
                                                    Sil
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-8">
                                <i class="fas fa-chart-line text-6xl text-gray-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Henüz sinyal oluşturulmamış</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">
                                İlk trading sinyalinizi oluşturmak için aşağıdaki butona tıklayın ve kullanıcılarınıza değerli trading sinyalleri sunmaya başlayın.
                            </p>
                            <a href="{{ route('newsignal') }}"
                               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <i class="fas fa-plus mr-3"></i>
                                İlk Sinyali Oluştur
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteSignal(id) {
            if (confirm('Bu sinyali silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.')) {
                window.location.href = `{{ url('admin/dashboard/trashsignal') }}/${id}`;
            }
        }

        // Add animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in');
                    }
                });
            });

            document.querySelectorAll('.group').forEach((el) => {
                observer.observe(el);
            });
        });
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }

        @media (max-width: 768px) {
            .grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3 {
                grid-template-columns: 1fr;
            }
            
            .grid-cols-1.md\\:grid-cols-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endsection
