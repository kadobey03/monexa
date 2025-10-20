@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')

    <!-- Main Content -->
    <div class="admin-main-content flex-1 lg:ml-64 transition-all duration-300">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
            <!-- Header Section -->
            <div class="bg-white border-b border-gray-200 shadow-sm">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Lead Yönetimi</h1>
                            <p class="text-gray-600 mt-1">Sistem güncellemesi - Yeni arayüz kullanılabilir</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="px-4 py-8 sm:px-6 lg:px-8">
                <!-- Upgrade Card -->
                <div class="max-w-6xl mx-auto">
                    <div class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-blue-600 to-indigo-700 rounded-2xl shadow-2xl">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 100 100&quot;><defs><pattern id=&quot;grain&quot; width=&quot;100&quot; height=&quot;100&quot; patternUnits=&quot;userSpaceOnUse&quot;><circle cx=&quot;50&quot; cy=&quot;50&quot; r=&quot;1&quot; fill=&quot;%23ffffff&quot; opacity=&quot;0.02&quot;/></pattern></defs><rect width=&quot;100&quot; height=&quot;100&quot; fill=&quot;url(%23grain)&quot;/></svg>');"></div>
                        </div>
                        
                        <!-- Content -->
                        <div class="relative z-10 p-8">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                                <!-- Left Content -->
                                <div class="lg:col-span-2 text-white">
                                    <div class="mb-6">
                                        <div class="inline-flex items-center px-4 py-2 mb-4 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium">
                                            🚀 Sistem Güncellemesi
                                        </div>
                                        <h2 class="text-3xl lg:text-4xl font-bold mb-4">Yeni Lead Yönetim Sistemi</h2>
                                        <p class="text-xl text-white/90 mb-6">Daha güçlü özellikler, modern tasarım ve gelişmiş kullanıcı deneyimi ile lead'lerinizi yönetin.</p>
                                    </div>

                                    <!-- Features Grid -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold mb-2">Dinamik Status Sistemi</h4>
                                                <p class="text-white/75">Renk kodlu statuslar, özel durumlar, otomatik takip</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold mb-2">Akıllı Atama Sistemi</h4>
                                                <p class="text-white/75">Hiyerarşik admin yönetimi, toplu işlemler</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold mb-2">Excel Import/Export</h4>
                                                <p class="text-white/75">Toplu veri transferi, otomatik üye oluşturma</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-semibold mb-2">Lead Scoring & Analytics</h4>
                                                <p class="text-white/75">Otomatik puanlama, detaylı raporlama</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Content - CTA -->
                                <div class="text-center">
                                    <div class="mb-6">
                                        <div class="w-32 h-32 mx-auto mb-6 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-white opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('admin.leads.index') }}" 
                                       class="inline-flex items-center px-8 py-4 bg-white/20 backdrop-blur-sm text-white font-bold rounded-2xl hover:bg-white/30 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl group">
                                        <svg class="w-5 h-5 mr-3 group-hover:animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Yeni Sisteme Geç
                                    </a>
                                    
                                    <div class="mt-4 text-white/70 text-sm">
                                        Modern, hızlı ve güvenli
                                    </div>
                                    
                                    <!-- Auto-redirect timer -->
                                    <div class="mt-4 p-3 bg-white/10 backdrop-blur-sm rounded-lg">
                                        <p class="text-white/80 text-sm mb-2">Otomatik yönlendirme:</p>
                                        <div class="text-2xl font-bold text-white" id="countdown">10</div>
                                        <div class="text-xs text-white/60">saniye sonra</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Decorative elements -->
                        <div class="absolute -right-16 -bottom-16 w-32 h-32 bg-gradient-to-br from-white/10 to-blue-300/20 rounded-full blur-2xl"></div>
                        <div class="absolute -left-16 -top-16 w-24 h-24 bg-gradient-to-br from-purple-400/20 to-indigo-400/20 rounded-full blur-xl"></div>
                    </div>
                </div>

                <!-- Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12 max-w-6xl mx-auto">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-white/50">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Güvenli</h3>
                            <p class="text-gray-600">Tüm verileriniz güvende, modern güvenlik standartları ile korunmaktadır.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-white/50">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Hızlı</h3>
                            <p class="text-gray-600">Optimize edilmiş performans ile anlık yükleme ve tepki süreleri.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-white/50">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Responsive</h3>
                            <p class="text-gray-600">Her cihazda mükemmel görünüm ve kullanıcı deneyimi sağlar.</p>
                        </div>
                    </div>
                </div>

                <!-- Additional Benefits -->
                <div class="mt-12 max-w-4xl mx-auto text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-8">Neden Yeni Sisteme Geçmelisiniz?</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex items-start space-x-4 p-6 bg-white/60 backdrop-blur-sm rounded-xl">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="text-left">
                                <h4 class="font-semibold text-gray-900 mb-2">Gelişmiş Özellikler</h4>
                                <p class="text-gray-600 text-sm">Yeni sistem ile daha fazla özellik ve kontrol imkanı.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-6 bg-white/60 backdrop-blur-sm rounded-xl">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="text-left">
                                <h4 class="font-semibold text-gray-900 mb-2">Kolay Kullanım</h4>
                                <p class="text-gray-600 text-sm">Sezgisel arayüz ile daha kolay ve verimli çalışma.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Auto-redirect countdown and functionality
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');
        
        function updateCountdown() {
            countdownElement.textContent = countdown;
            countdown--;
            
            if (countdown < 0) {
                if (confirm('Yeni Lead Yönetim sistemine otomatik olarak yönlendirilmek ister misiniz?')) {
                    window.location.href = "{{ route('admin.leads.index') }}";
                } else {
                    // Reset countdown if user cancels
                    countdown = 10;
                }
            }
        }
        
        // Start countdown
        const countdownInterval = setInterval(updateCountdown, 1000);
        
        // Clear countdown if user manually clicks the button
        document.querySelector('a[href*="admin.leads.index"]').addEventListener('click', function() {
            clearInterval(countdownInterval);
        });
        
        // Add entrance animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.transform');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.6s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                }, index * 100);
            });
        });
    </script>

    <!-- Enhanced Styles -->
    <style>
        /* Custom animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .animation-delay-200 { animation-delay: 200ms; }
        .animation-delay-400 { animation-delay: 400ms; }
        
        /* Backdrop blur support */
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }
        
        /* Hover effects */
        .group:hover .group-hover\:animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .text-4xl { font-size: 2rem; }
            .text-3xl { font-size: 1.875rem; }
        }
    </style>
@endsection