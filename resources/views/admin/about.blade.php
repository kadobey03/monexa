@extends('layouts.admin', ['title' => 'Hakkında Remedy Technology'])

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-blue-900 dark:to-indigo-900 min-h-screen p-6">
    
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Hakkında Remedy Technology</h1>
        <p class="text-gray-600 dark:text-gray-400">Profesyonel PHP Script Geliştirme ve Destek Hizmetleri</p>
    </div>

    <!-- Hero Section -->
    <div class="mb-8">
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 rounded-2xl shadow-2xl">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 100 100&quot;><defs><pattern id=&quot;grain&quot; width=&quot;100&quot; height=&quot;100&quot; patternUnits=&quot;userSpaceOnUse&quot;><circle cx=&quot;50&quot; cy=&quot;50&quot; r=&quot;1&quot; fill=&quot;%23ffffff&quot; opacity=&quot;0.02&quot;/></pattern></defs><rect width=&quot;100&quot; height=&quot;100&quot; fill=&quot;url(%23grain)&quot;/></svg>');"></div>
            </div>
            
            <div class="relative z-10 text-center text-white py-16 px-8">
                <div class="mb-8">
                    <i data-lucide="code" class="w-20 h-20 mx-auto mb-6 opacity-75"></i>
                </div>
                <h1 class="text-5xl font-bold mb-6">Remedy Teknoloji</h1>
                <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">Uzman Laravel PHP Script Geliştirme ve Profesyonel Destek Hizmetleri</p>
                <div class="max-w-4xl mx-auto">
                    <p class="text-lg text-white/90 mb-8">Özel Laravel PHP uygulamaları oluşturma, profesyonel kurulum hizmetleri sağlama ve dünya çapındaki işletmeler için sürekli destek sunma konusunda uzmanız.</p>
                </div>
                <div class="flex justify-center gap-4 flex-wrap">
                    <a href="https://t.me/+heFFLpE7w5RjZjQ0" target="_blank"
                       class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-bold rounded-xl hover:bg-white/30 transition-all duration-300 transform hover:scale-105">
                        <i data-lucide="send" class="w-5 h-5 mr-2"></i>Destek Al
                    </a>
                    <a href="https://codesremedy.com/" target="_blank"
                       class="inline-flex items-center px-6 py-3 border-2 border-white/30 text-white font-bold rounded-xl hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                        <i data-lucide="globe" class="w-5 h-5 mr-2"></i>Web Sitesini Ziyaret Et
                    </a>
                </div>
            </div>
            
            <!-- Decorative elements -->
            <div class="absolute -right-16 -bottom-16 w-32 h-32 bg-gradient-to-br from-white/10 to-blue-300/20 rounded-full blur-2xl"></div>
            <div class="absolute -left-16 -top-16 w-24 h-24 bg-gradient-to-br from-purple-400/20 to-indigo-400/20 rounded-full blur-xl"></div>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Custom Development -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
            <div class="p-6 text-center">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 dark:bg-blue-900 rounded-full">
                        <i data-lucide="code" class="w-10 h-10 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Özel Geliştirme</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">İşletmenizin ihtiyaçlarına göre uyarlanmış Laravel PHP Script Geliştirme</p>
                <div class="mt-auto">
                    <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-medium rounded-full">Özel Çözümler</span>
                </div>
            </div>
        </div>

        <!-- Installation Service -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
            <div class="p-6 text-center">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full">
                        <i data-lucide="settings" class="w-10 h-10 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Kurulum ve Ayarlar</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Profesyonel script kurulumu ve sunucu yapılandırması</p>
                <div class="mt-auto">
                    <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-medium rounded-full">Hızlı Kurulum</span>
                </div>
            </div>
        </div>

        <!-- Support & Updates -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
            <div class="p-6 text-center">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                        <i data-lucide="life-buoy" class="w-10 h-10 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Ömür Boyu Destek</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Devam eden destek, güncellemeler ve güvenlik iyileştirmeleri</p>
                <div class="mt-auto">
                    <span class="inline-block px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 text-xs font-medium rounded-full">7/24 Destek</span>
                </div>
            </div>
        </div>

        <!-- Customization -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
            <div class="p-6 text-center">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-purple-100 dark:bg-purple-900 rounded-full">
                        <i data-lucide="palette" class="w-10 h-10 text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Web Sitesi Özelleştirme</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Özel markalama ve UI/UX tasarım iyileştirmeleri</p>
                <div class="mt-auto">
                    <span class="inline-block px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 text-xs font-medium rounded-full">Özel Tasarım</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Services -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Custom Laravel Development -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 overflow-hidden">
            <div class="bg-blue-600 text-white p-6">
                <h3 class="text-xl font-bold flex items-center">
                    <i data-lucide="laptop-minimal" class="w-6 h-6 mr-3"></i>
                    Özel Laravel PHP Script Geliştirme
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 dark:text-gray-400 mb-6">Benzersiz bir özellik veya özel yapım bir Laravel PHP script'e mi ihtiyacınız var? Uzman geliştiricilerimiz mevcut script'leri değiştirebilir veya işletmenizin ihtiyaçlarına uygun tamamen yeni çözümler oluşturabilir.</p>

                <div class="mb-6">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-4">Uzmanlıklar:</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <i data-lucide="bitcoin" class="w-5 h-5 text-yellow-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Bitcoin Yatırım Platformları</span>
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="building-2" class="w-5 h-5 text-blue-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Çevrimiçi Bankacılık Sistemleri</span>
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="arrow-left-right" class="w-5 h-5 text-green-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Kripto Borsası Platformları</span>
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="truck" class="w-5 h-5 text-purple-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Kurye Takip Yazılımı</span>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-medium rounded-full">✅ Özel Özellik Entegrasyonu</span>
                    <span class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-medium rounded-full">✅ Tamamen Duyarlı ve Güvenli</span>
                    <span class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-medium rounded-full">✅ Hızlı Teslimat</span>
                </div>
            </div>
        </div>

        <!-- Installation Service -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 overflow-hidden">
            <div class="bg-green-600 text-white p-6">
                <h3 class="text-xl font-bold flex items-center">
                    <i data-lucide="server" class="w-6 h-6 mr-3"></i>
                    Script Kurulum ve Ayarlar Hizmeti
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 dark:text-gray-400 mb-6">Sunucu kurulumları veya script yüklemeleri konusunda deneyimli değil misiniz? Her şeyi ekibimize bırakın! Profesyonel script kurulum hizmetleri sunuyoruz.</p>

                <div class="mb-6">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-4">Nelerin Dahil Olduğu:</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Hızlı ve Güvenli Kurulum</span>
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Veritabanı Yapılandırması</span>
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Hata Düzeltmeleri ve Optimizasyon</span>
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">SSL Sertifikası Kurulumu</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/50 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <i data-lucide="info" class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2"></i>
                        <div>
                            <strong class="text-blue-900 dark:text-blue-100">Sorunsuz:</strong>
                            <span class="text-blue-800 dark:text-blue-200"> Herhangi bir teknik baş ağrısı olmadan script'inizi kullanmaya başlayın!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Services -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Lifetime Support -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 overflow-hidden">
            <div class="bg-yellow-500 text-white p-6">
                <h3 class="text-xl font-bold flex items-center">
                    <i data-lucide="shield" class="w-6 h-6 mr-3"></i>
                    Ömür Boyu Destek ve Güncellemeler
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 dark:text-gray-400 mb-6">PHP script'lerimiz için ömür boyu destek ve periyodik güncellemeler sağlıyoruz, böylece güvenli, hızlı kalır ve en son teknolojilerle uyumlu kalır.</p>

                <div class="mb-6">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-4">Destek Kapsamına Dahil:</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <i data-lucide="wrench" class="w-5 h-5 text-blue-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Küçük Sorunlar için Teknik Destek</span>
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="bug" class="w-5 h-5 text-red-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Hata Düzeltmeleri ve Performans İyileştirmeleri</span>
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="shield-check" class="w-5 h-5 text-green-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Güvenlik ve Özellik Güncellemeleri</span>
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="message-circle" class="w-5 h-5 text-purple-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Uzman Rehberlik ve Danışmanlık</span>
                        </li>
                    </ul>
                </div>

                <div class="text-center">
                    <span class="inline-block px-4 py-2 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 text-sm font-medium rounded-full">Her Zaman Güncel ve Güvenli</span>
                </div>
            </div>
        </div>

        <!-- Website Customization -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 overflow-hidden">
            <div class="bg-purple-600 text-white p-6">
                <h3 class="text-xl font-bold flex items-center">
                    <i data-lucide="paintbrush" class="w-6 h-6 mr-3"></i>
                    Web Sitesi Özelleştirme ve Markalama
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 dark:text-gray-400 mb-6">Web sitenize profesyonel ve benzersiz bir görünüm vermek mi istiyorsunuz? İşletmenizin kimliğine uygun özel markalama ve UI/UX iyileştirmeleri sunuyoruz.</p>

                <div class="mb-6">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-4">Tasarım Hizmetleri:</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <i data-lucide="palette" class="w-5 h-5 text-blue-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Özel Logo ve Markalama</span>
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="smartphone" class="w-5 h-5 text-green-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">UI/UX İyileştirmeleri</span>
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="search" class="w-5 h-5 text-yellow-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Mobil ve SEO Optimizasyonu</span>
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="eye" class="w-5 h-5 text-purple-500 mr-3"></i>
                            <span class="text-gray-700 dark:text-gray-300">Modern Duyarlı Tasarım</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <i data-lucide="target" class="w-5 h-5 text-green-600 dark:text-green-400 mr-2"></i>
                        <div>
                            <strong class="text-green-900 dark:text-green-100">Hedef:</strong>
                            <span class="text-green-800 dark:text-green-200"> Markanızı gerçekten temsil eden bir web sitesi oluşturun!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-gray-800 via-blue-800 to-indigo-900 rounded-2xl shadow-2xl">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 100 100&quot;><defs><pattern id=&quot;contact-grain&quot; width=&quot;100&quot; height=&quot;100&quot; patternUnits=&quot;userSpaceOnUse&quot;><circle cx=&quot;50&quot; cy=&quot;50&quot; r=&quot;1&quot; fill=&quot;%23ffffff&quot; opacity=&quot;0.02&quot;/></pattern></defs><rect width=&quot;100&quot; height=&quot;100&quot; fill=&quot;url(%23contact-grain)&quot;/></svg>');"></div>
        </div>
        
        <div class="relative z-10 text-center text-white py-16 px-8">
            <h2 class="text-3xl font-bold mb-6">Başlamaya Hazır mısınız?</h2>
            <p class="text-xl text-gray-200 mb-12">Kişiselleştirilmiş bir teklif ve danışmanlık için bugün bizimle iletişime geçin</p>

            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                        <i data-lucide="send" class="w-12 h-12 text-white mx-auto mb-4"></i>
                        <h3 class="text-lg font-bold text-white mb-2">Telegram Destek</h3>
                        <a href="https://t.me/+heFFLpE7w5RjZjQ0" target="_blank"
                           class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-300">
                            Kanala Katıl
                        </a>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                        <i data-lucide="globe" class="w-12 h-12 text-white mx-auto mb-4"></i>
                        <h3 class="text-lg font-bold text-white mb-2">Web Sitesini Ziyaret Et</h3>
                        <a href="https://codesremedy.com/" target="_blank"
                           class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-300">
                            codesremedy.com
                        </a>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                        <i data-lucide="phone" class="w-12 h-12 text-white mx-auto mb-4"></i>
                        <h3 class="text-lg font-bold text-white mb-2">Telefon Desteği</h3>
                        <a href="https://t.me/+heFFLpE7w5RjZjQ0" target="_blank"
                           class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-300">
                            İletişime Geç
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Decorative elements -->
        <div class="absolute -right-16 -bottom-16 w-32 h-32 bg-gradient-to-br from-white/10 to-blue-300/20 rounded-full blur-2xl"></div>
        <div class="absolute -left-16 -top-16 w-24 h-24 bg-gradient-to-br from-purple-400/20 to-indigo-400/20 rounded-full blur-xl"></div>
    </div>
</div>
@endsection
