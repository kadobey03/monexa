@extends('layouts.base')
@inject('content', 'App\Http\Controllers\FrontController')
@section('title', 'cTrader Automate - Algoritmik Ticaret')

@section('content')

<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800">
    <!-- Abstract Background Elements -->
    <div class="absolute inset-0 z-20 md:z-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-full h-full opacity-60 md:opacity-20">
            <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="a" x1="50%" x2="50%" y1="0%" y2="100%">
                        <stop stop-color="#3B82F6" stop-opacity=".25" offset="0%"/>
                        <stop stop-color="#10B981" stop-opacity=".2" offset="100%"/>
                    </linearGradient>
                </defs>
                <path fill="url(#a)" d="M400,115 C515.46,115 615,214.54 615,330 C615,445.46 515.46,545 400,545 C284.54,545 185,445.46 185,330 C185,214.54 284.54,115 400,115 Z" transform="translate(0 -50)" />
                <path fill="url(#a)" d="M400,115 C515.46,115 615,214.54 615,330 C615,445.46 515.46,545 400,545 C284.54,545 185,445.46 185,330 C185,214.54 284.54,115 400,115 Z" transform="translate(350 150)" />
            </svg>
        </div>
        <div class="absolute bottom-0 right-0 w-full h-full opacity-50 md:opacity-10">
            <svg width="100%" height="100%" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" stroke="#6366F1" stroke-width="2">
                    <path d="M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764"/>
                    <path d="M-4 44L190 190 731 737 520 660 309 538 40 599 295 764"/>
                    <path d="M-4 44L190 190 731 737M490 85L309 538 40 599 295 764"/>
                    <path d="M733 738L520 660M603 493L731 737M520 660L309 538"/>
                </g>
            </svg>
        </div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col-reverse items-center gap-8 md:flex-row">
            <!-- Left Column - Text Content -->
            <div class="w-full md:w-1/2" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 200)">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="space-y-6"
                >
                    <div class="inline-block px-3 py-1 mb-2 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                        Otomatik Ticaret
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">
                        <span class="block">cTrader Automate</span>
                        <span class="block mt-2 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">Alım Satım Algoritmalarını Basitleştirin</span>
                    </h1>
                    <p class="mt-3 text-lg text-gray-300">
                        Kolayca algoritmik alım satım stratejileri oluşturun, özelleştirin ve dağıtın. Akıllı otomasyon ile piyasa fırsatlarından 24/7 yararlanın.
                    </p>
                    <div class="flex flex-wrap gap-4 mt-6">
                        <a href="#features" class="px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
                            Özellikleri Keşfedin
                        </a>
                        <a href="#faq" class="px-6 py-3 text-base font-medium text-gray-300 bg-gray-800 border border-gray-700 rounded-lg shadow-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
                            Daha Fazla Bilgi Edinin
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column - Chart Animation -->
            <div class="w-full md:w-1/2">
                <div class="relative h-64 md:h-96 overflow-hidden rounded-2xl shadow-2xl bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-full h-full p-6">
                            <div class="relative w-full h-full">
                                <!-- Trading Chart Visualization -->
                                <div class="absolute inset-0 flex flex-col">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                            <span class="text-xs font-medium text-gray-300">BTC/USD</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-green-400">$38,245.75</span>
                                            <span class="text-xs text-green-400">+2.4%</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <!-- SVG Trading Chart Animation -->
                                        <svg class="w-full h-full" viewBox="0 0 400 200" preserveAspectRatio="none">
                                            <!-- Chart Grid Lines -->
                                            <line x1="0" y1="40" x2="400" y2="40" stroke="#374151" stroke-width="0.5" />
                                            <line x1="0" y1="80" x2="400" y2="80" stroke="#374151" stroke-width="0.5" />
                                            <line x1="0" y1="120" x2="400" y2="120" stroke="#374151" stroke-width="0.5" />
                                            <line x1="0" y1="160" x2="400" y2="160" stroke="#374151" stroke-width="0.5" />

                                            <!-- Animated Chart Path -->
                                            <path d="M0,150 C20,140 40,100 60,110 C80,120 100,80 120,70 C140,60 160,90 180,80 C200,70 220,30 240,40 C260,50 280,70 300,60 C320,50 340,30 360,40 C380,50 400,30 400,20"
                                                  stroke="url(#chartGradient)" stroke-width="2" fill="none" stroke-linecap="round">
                                                <animate attributeName="d"
                                                    values="
                                                        M0,150 C20,140 40,100 60,110 C80,120 100,80 120,70 C140,60 160,90 180,80 C200,70 220,30 240,40 C260,50 280,70 300,60 C320,50 340,30 360,40 C380,50 400,30 400,20;
                                                        M0,140 C20,130 40,110 60,100 C80,90 100,70 120,80 C140,90 160,100 180,90 C200,80 220,40 240,50 C260,60 280,80 300,70 C320,60 340,40 360,50 C380,60 400,40 400,30;
                                                        M0,130 C20,140 40,120 60,130 C80,140 100,100 120,90 C140,80 160,70 180,60 C200,50 220,60 240,70 C260,80 280,90 300,80 C320,70 340,50 360,60 C380,70 400,50 400,40;
                                                        M0,150 C20,140 40,100 60,110 C80,120 100,80 120,70 C140,60 160,90 180,80 C200,70 220,30 240,40 C260,50 280,70 300,60 C320,50 340,30 360,40 C380,50 400,30 400,20"
                                                    dur="20s" repeatCount="indefinite" />
                                            </path>

                                            <!-- Gradient Definition -->
                                            <defs>
                                                <linearGradient id="chartGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                                    <stop offset="0%" stop-color="#3B82F6" />
                                                    <stop offset="100%" stop-color="#10B981" />
                                                </linearGradient>
                                            </defs>
                                        </svg>

                                        <!-- Algorithm Markers -->
                                        <div class="absolute top-1/4 right-1/3 w-4 h-4 bg-blue-500 bg-opacity-30 rounded-full animate-ping">
                                            <div class="absolute inset-0 w-2 h-2 m-1 bg-blue-400 rounded-full"></div>
                                        </div>
                                        <div class="absolute top-2/3 left-1/4 w-4 h-4 bg-green-500 bg-opacity-30 rounded-full animate-ping" style="animation-delay: 1s">
                                            <div class="absolute inset-0 w-2 h-2 m-1 bg-green-400 rounded-full"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Algo Bot Elements -->
                    <div class="absolute bottom-4 right-4 flex items-center gap-2 px-3 py-1 bg-blue-600 bg-opacity-30 rounded-full">
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                        <span class="text-xs font-medium text-blue-300">Algo Bot Running</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-900" id="features">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Gelişmiş Alım Satım Otomasyonu
            </div>
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Algoritmik Ticareti Gücünü Açığa Çıkarın</span>
            </h2>
            <p class="mt-4 text-xl text-gray-300 max-w-3xl mx-auto">
                Otomasyon platformumuz, tüm deneyim seviyelerindeki traderların kapsamlı programlama bilgisi olmadan karmaşık alım satım stratejilerini uygulamalarını sağlar.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Şimşek Hızlı Yürütme</h3>
                <p class="text-gray-300">Algoritmik alım satım sistemimiz, işlemleri milisaniyeler içinde yürütür ve insan gecikmesi olmadan piyasa fırsatlarından yararlanır.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Geri Test ve Optimizasyon</h3>
                <p class="text-gray-300">Gerçek sermayeyi riske atmadan önce parametreleri ince ayar yapmak ve performansı optimize etmek için stratejilerinizi geçmiş verilere karşı test edin.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Gelişmiş Risk Yönetimi</h3>
                <p class="text-gray-300">Sermayenizi korumak için stop-loss, take-profit ve pozisyon boyutlandırma dahil olmak üzere karmaşık risk yönetimi kuralları uygulayın.</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="py-20 bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Bilgi Bankası
            </div>
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">Sık Sorulan Sorular</h2>
            <p class="mt-4 text-xl text-gray-300">Otomatik alım satım çözümlerimiz hakkında bilmeniz gereken her şey</p>
        </div>

        <div class="space-y-6" x-data="{selected:null}">
            <!-- FAQ Item 1 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 1 ? selected = 1 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">cBot nasıl çalışır?</span>
                    <svg :class="{'rotate-180': selected == 1}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 1" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p class="mb-3">Bir cBot, programlandığı göstergeleri veya diğer parametreleri analiz eder ve önceden tanımlanmış kurallar karşılandığında, bir işlem girme, çıkma veya değiştirme gibi belirli bir eylem gerçekleştirir.</p>
                        <p>Örneğin, breakout'lar üzerine alım satım yapan bir cBot kullanıyorsanız, fiyat bir direnç seviyesinin üzerine çıkıldığında veya bir destek seviyesinin altına düştüğünde işleminiz girilir. Alım satım fırsatlarını belirleme kurallarının yanı sıra, bir cBot genellikle Stop Loss/Take Profit seviyeleri, trailing stop'lar veya diğer risk yönetimi özellikleri gibi açık pozisyonları yönetmek için parametreler içerir.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 2 ? selected = 2 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">MT4'te kullandığım bir Expert Advisor'ı cBot'a dönüştürebilir miyim?</span>
                    <svg :class="{'rotate-180': selected == 2}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 2" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p>Evet, MQL4 göstergeleriniz ve Expert Advisor'larınız C#'ye dönüştürülebilir ve {{$settings->name}} cTrader'da kullanılabilir. Lütfen bunu sizin için yapabilecek olan <a class="text-blue-400 hover:text-blue-300" target='_blank' href='https://ctdn.com/consultants/'>cTDN topluluğu</a>ndan bir danışmana başvurun.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 3 ? selected = 3 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">cBot'u hangi kriterlere göre seçmeliyim?</span>
                    <svg :class="{'rotate-180': selected == 3}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 3" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p class="mb-3">cBot seçmenin en iyi yolu yoktur, ancak önce araştırmanızı yapmanız tavsiye edilir. cTDN'den bir cBot indirirken, geliştiricinin açıklamasını görüntüleyerek nasıl çalıştığı hakkında iyi bir fikir edinebilirsiniz; bu açıklama özellikler ve kullanım ipuçlarını içerir.</p>
                        <p class="mb-3">Trader'lar genellikle alım satım tarzlarına uygun bir bot seçer, bu yüzden eğer Fibonacci oranlarıyla alım satım yapmayı tercih ediyorsanız, bir Fibonacci cBot'u seçebilirsiniz ve eğer haber ticareti ile ilgileniyorsanız, önemli bir ekonomik yayın olduğunda alım satım yapan bir cBot seçebilirsiniz.</p>
                        <p>cTDN'de, cBot'ları popülerlik ve kullanıcı puanına göre sıralayabilirsiniz, bu yüzden bu özellikle acemiyseniz başka bir karar faktörü olabilir.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 4 ? selected = 4 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">cBot'umun doğru şekilde çalışacak şekilde ayarlandığını nasıl anlarım?</span>
                    <svg :class="{'rotate-180': selected == 4}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 4" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p>cBot dosyasını indirdikten sonra, onu bilgisayarınızda çalıştırmalı ve yüklemelisiniz. Daha sonra {{$settings->name}} cTrader'da, grafiğinizin sol tarafındaki cBots sütununda görebilmelisiniz. Hangi enstrüman için çalıştırmak istediğinizi tanımladıktan sonra, "Play" düğmesine tıklayın. cBot, doğru koşullar karşılandığında çalışmaya başlayacaktır. İstediğiniz zaman "Stop" düğmesine tıklayarak durdurabileceğinizi lütfen unutmayın.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 5 ? selected = 5 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">Birden fazla cBot'u aynı anda çalıştırabilir miyim?</span>
                    <svg :class="{'rotate-180': selected == 5}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 5" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p>Evet, aynı anda birden fazla cBot çalıştırabilir ve aynı enstrüman için de kullanabilirsiniz.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 6 ? selected = 6 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">Kendi cBot'umu oluşturabilir miyim?</span>
                    <svg :class="{'rotate-180': selected == 6}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 6" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p class="mb-3">Takip ettiğiniz ve etkili olduğu kanıtlanmış belirli bir alım satım stratejiniz varsa, onu otomatikleştirmek iyi bir fikir olabilir. Stratejinizin yeterince basit olması ve bot'unun üzerinde inşa edileceği kurallar seti hakkında net olmanız önemlidir.</p>
                        <p>Kendi kodlama deneyiminiz yoksa, <a class="text-blue-400 hover:text-blue-300" target='_blank' href='https://ctdn.com/consultants/'>cTDN topluluğu</a>ndan bir geliştirici kiralamayı seçebilirsiniz. Lütfen isteğinizi forumda yayınlayın veya uzman danışmanlardan birine başvurun.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 7 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 7 ? selected = 7 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">Hangi tür özel göstergeler mevcuttur?</span>
                    <svg :class="{'rotate-180': selected == 7}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 7" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p class="mb-3">MACD, RSI, Heiken Ashi, Ichimoku ve daha fazlası gibi standart sürümün yumuşatılmış veya birleştirilmiş sürümleri olan trend göstergeleri.</p>
                        <p class="mb-3">Bollinger Bands, Donchian kanalları, Keltner kanalları, Average True Range vb. gibi standart Volatilite göstergelerinin ayarlanmış formülleri.</p>
                        <p>Destek & Direnç, Pivot Noktaları, Harmonikler, Polinom Regresyon, Fibonacci vb. üzerine dayalı birden fazla diğer özel gösterge.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Item 8 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden">
                <button @click="selected !== 8 ? selected = 8 : selected = null" class="flex items-center justify-between w-full px-6 py-4 text-left focus:outline-none">
                    <span class="text-lg font-medium text-white">Gerçek hesapla alım satıma nasıl başlayabilirim?</span>
                    <svg :class="{'rotate-180': selected == 8}" class="w-5 h-5 text-gray-300 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="selected == 8" x-collapse>
                    <div class="px-6 pb-4 text-gray-300">
                        <p class="mb-3">Gerçek alım satım hesabınız 2 dakikadan daha kısa sürede çalışır durumda olabilir. Lütfen aşağıdaki adımları takip edin:</p>
                        <ul class="list-disc pl-5 mb-3 space-y-2">
                            <li>Adım 1. Hesap Oluşturun.</li>
                            <li>Adım 2. E-posta, şifre ve telefon numaranızı doldurun.</li>
                            <li>Adım 3. Platformu başlatın ve alım satıma başlamak için hesabınızı fonlayın!</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Expert Support Section -->
<section class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center gap-10">
            <div class="w-full md:w-1/2">
                <img src="temp/custom/img/commission-scheme-crypt1t.png" alt="Trading Support" class="w-full max-w-md mx-auto rounded-xl shadow-2xl">
            </div>
            <div class="w-full md:w-1/2 space-y-8">
                <div>
                    <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                        Uzman Desteği
                    </div>
                    <h2 class="text-3xl font-extrabold text-white mb-4">UZMANLARIMIZLA <br>GÜNCEL KALIN!</h2>
                    <p class="text-gray-300">
                        Yerel ve uluslararası ekiplerimiz, 20'den fazla dilde 24/5 bazında sizi desteklemek için burada, geniş ödeme yöntemleri yelpazemiz ise para yatırma ve çekme konusunda size daha fazla esneklik sağlar.
                    </p>
                </div>

                <div>
                    <h2 class="text-3xl font-extrabold text-white mb-4">Alım Satımdan Daha Fazlasını Yaşayın</h2>
                    <p class="text-gray-300">
                        Başarımız bir dizi temel değer etrafında toplanır. Bunlar arasında sıkı spreadler aracılığıyla rekabetçi komisyon ücretleri sağlamak, şimşek hızında yürütme sağlamak, geniş ürün yelpazesiyle gelişmiş alım satım platformlarına erişim ve üstün müşteri hizmetleri bulunur.
                    </p>
                </div>

                <a href="/about" class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
                    {{$settings->name}} Komisyonları Hakkında Bilgi Edinin
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
