@extends('layouts.base')

@section('title', 'Sık Sorulan Sorular')

@inject('content', 'App\Http\Controllers\FrontController')
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
        <div class="text-center mb-12">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Bilgi Bankası
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">
                <span class="block">Sık Sorulan Sorular</span>
                <span class="block mt-1 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">Bilmeniz Gereken Her Şey</span>
            </h1>
            <p class="max-w-2xl mt-5 mx-auto text-xl text-gray-300">
                Alım satım platformumuz ve hizmetlerimiz hakkında yaygın soruların cevaplarını alın
            </p>
        </div>
    </div>
</section>

<!-- FAQ Content -->
<section class="py-12 bg-gray-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div x-data="{ activeCategory: 'about' }" class="space-y-10">

            <!-- FAQ Category Tabs -->
            <div class="flex flex-wrap justify-center gap-2 md:gap-4">
                <button @click="activeCategory = 'about'" :class="{'bg-blue-600 text-white': activeCategory === 'about', 'bg-gray-800 text-gray-300 hover:bg-gray-700': activeCategory !== 'about'}" class="px-4 py-2 rounded-lg transition-all duration-200 text-sm md:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    <i class="fas fa-building mr-2"></i>Hakkımızda
                </button>
                <button @click="activeCategory = 'account'" :class="{'bg-blue-600 text-white': activeCategory === 'account', 'bg-gray-800 text-gray-300 hover:bg-gray-700': activeCategory !== 'account'}" class="px-4 py-2 rounded-lg transition-all duration-200 text-sm md:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    <i class="fas fa-user-circle mr-2"></i>Hesabım
                </button>
                <button @click="activeCategory = 'deposit'" :class="{'bg-blue-600 text-white': activeCategory === 'deposit', 'bg-gray-800 text-gray-300 hover:bg-gray-700': activeCategory !== 'deposit'}" class="px-4 py-2 rounded-lg transition-all duration-200 text-sm md:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    <i class="fas fa-wallet mr-2"></i>Para Yatırma
                </button>
                <button @click="activeCategory = 'withdrawal'" :class="{'bg-blue-600 text-white': activeCategory === 'withdrawal', 'bg-gray-800 text-gray-300 hover:bg-gray-700': activeCategory !== 'withdrawal'}" class="px-4 py-2 rounded-lg transition-all duration-200 text-sm md:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    <i class="fas fa-money-bill-wave mr-2"></i>Para Çekme
                </button>
                <button @click="activeCategory = 'referral'" :class="{'bg-blue-600 text-white': activeCategory === 'referral', 'bg-gray-800 text-gray-300 hover:bg-gray-700': activeCategory !== 'referral'}" class="px-4 py-2 rounded-lg transition-all duration-200 text-sm md:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    <i class="fas fa-users mr-2"></i>Referans
                </button>
                <button @click="activeCategory = 'other'" :class="{'bg-blue-600 text-white': activeCategory === 'other', 'bg-gray-800 text-gray-300 hover:bg-gray-700': activeCategory !== 'other'}" class="px-4 py-2 rounded-lg transition-all duration-200 text-sm md:text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    <i class="fas fa-question-circle mr-2"></i>Diğer
                </button>
            </div>

            <!-- About Us Category -->
            <div x-show="activeCategory === 'about'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-4"
                class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="divide-y divide-gray-700" x-data="{active: null}">
                        <!-- About Us Questions -->
                        <div class="py-4">
                            <button @click="active !== 0 ? active = 0 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">{{$settings->site_name}} nedir?</h4>
                                <svg :class="{'rotate-180': active === 0}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 0" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>{{$settings->site_name}} - Kripto para endüstrisi geliştiricilerinin profesyonel ekibi. Şirketin ana avantajı, büyüme ve piyasa düşüş aşamasında kar sağlayan benzersiz bir alım satım botu.</p>
                            </div>
                        </div>

                        <div class="py-4">
                            <button @click="active !== 1 ? active = 1 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">{{$settings->site_name}} resmi olarak kayıtlı bir şirket mi?</h4>
                                <svg :class="{'rotate-180': active === 1}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 1" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Evet, hukuken bağlayıcıyız ve İngiltere'de şirket kayıt numarası #08683932 altında resmi olarak kayıtlıyız</p>
                            </div>
                        </div>

                        <div class="py-4">
                            <button @click="active !== 2 ? active = 2 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Ülke kısıtlamalarınız var mı?</h4>
                                <svg :class="{'rotate-180': active === 2}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 2" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Şirketimiz ABD sakinleriyle çalışmaz ve onlardan para yatırma kabul etmez. Kayıt süreci sırasında ABD vatandaşı olmadığınızı belirten kutuyu işaretlemeniz gerekir.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Account Category -->
            <div x-show="activeCategory === 'account'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-4"
                class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="divide-y divide-gray-700" x-data="{active: null}">
                        <!-- Account Questions -->
                        <div class="py-4">
                            <button @click="active !== 0 ? active = 0 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Kaç hesap açabilirim?</h4>
                                <svg :class="{'rotate-180': active === 0}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 0" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Her kullanıcı sadece bir hesap açabilir ve yönetebilir. Lütfen bu kurala uyun. Kural ihlali durumunda şirket tüm hesaplarınızı iade olmadan bloke etme hakkına sahiptir.</p>
                            </div>
                        </div>

                        <div class="py-4">
                            <button @click="active !== 1 ? active = 1 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Kişisel verilerimi nasıl yüklerim?</h4>
                                <svg :class="{'rotate-180': active === 1}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 1" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Kişisel bilgilerinizi talep etmediğimizi lütfen unutmayın. Platformumuzda çalışmak için kullanıcı adınızı, e-posta adresinizi, şifre oluşturmanız ve para çekme işlemleri için cüzdan numarasını belirtmeniz yeterlidir.</p>
                            </div>
                        </div>

                        <div class="py-4">
                            <button @click="active !== 2 ? active = 2 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Hesap açmak ne kadar tutar?</h4>
                                <svg :class="{'rotate-180': active === 2}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 2" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Hesap açmak tamamen ücretsizdir. Size herhangi bir gizli ücret veya hizmet bedeli uygulamayız. İşlem komisyonları ve ek maliyetler kripto para robotlarının geliştirilmesinden elde edilen şirket karlarından karşılanır.</p>
                            </div>
                        </div>

                        <div class="py-4">
                            <button @click="active !== 3 ? active = 3 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Çocuğumu kayıt ettirebilir miyim?</h4>
                                <svg :class="{'rotate-180': active === 3}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 3" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>İkamet ettikleri ülkede reşit olma yaşına ulaşmış herhangi bir kişi {{$settings->site_name}}'da kayıt olabilir</p>
                            </div>
                        </div>

                        <div class="py-4">
                            <button @click="active !== 4 ? active = 4 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Nasıl yatırımcı olabilirim?</h4>
                                <svg :class="{'rotate-180': active === 4}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 4" x-collapse x-cloak class="mt-3 text-gray-300">
                                <div class="space-y-4">
                                    <p class="font-medium">Şirketimizle başlamak için 3 adım:</p>
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center mr-3">
                                            <span class="text-white font-bold">1</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-white">KAYIT</p>
                                            <p>Kayıt Ol butonuna tıklayın. ÜCRETSİZ {{$settings->site_name}} hesabınızı hızlıca oluşturmak için bilgilerinizi girin.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center mr-3">
                                            <span class="text-white font-bold">2</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-white">DEPOZİTO AÇIN</p>
                                            <p>Farklı yatırım planları sunuyoruz. Finansal hedeflerinize uygun bir plan seçin. Okuduktan sonra depozito yatırın.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center mr-3">
                                            <span class="text-white font-bold">3</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-white">KAZANMAYA BAŞLAYIN</p>
                                            <p>Depozito yatırdıktan sonra sermayenizin gerçek zamanlı olarak günlük kar biriktirerek büyümesini izleyin.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ana sayfadaki SSS sorularını ekleme - Devlet destekli mi? -->
                        <div class="py-4">
                            <button @click="active !== 5 ? active = 5 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Devlet destekli mi?</h4>
                                <svg :class="{'rotate-180': active === 5}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 5" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Evet, platformumuz devlet destekli bir finansal hizmet sağlayıcısıdır. Türkiye Cumhuriyeti Sermaye Piyasası Kurulu (SPK) ve ilgili devlet kurumları tarafından denetlenmekte ve desteklenmektedir. Bu sayede kullanıcılarımıza güvenli ve regüle edilmiş bir yatırım ortamı sunuyoruz.</p>
                            </div>
                        </div>

                        <!-- Ana sayfadaki SSS sorularını ekleme - Kayıp yaşayabilir miyim? -->
                        <div class="py-4">
                            <button @click="active !== 6 ? active = 6 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Kayıp yaşayabilir miyim?</h4>
                                <svg :class="{'rotate-180': active === 6}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 6" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Tüm finansal işlemlerde olduğu gibi, piyasa koşulları nedeniyle kayıp riski her zaman vardır. Ancak platformumuz gelişmiş risk yönetimi araçları ve uzman desteği ile bu riskleri minimize etmeye yardımcı olur. Başarı oranımız %85'in üzerindedir ve kullanıcılarımıza kayıp durumunda destek hizmetleri sunuyoruz.</p>
                            </div>
                        </div>

                        <!-- Ana sayfadaki SSS sorularını ekleme - Uzmanlar kimler? -->
                        <div class="py-4">
                            <button @click="active !== 7 ? active = 7 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Uzmanlar kimler?</h4>
                                <svg :class="{'rotate-180': active === 7}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 7" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Ekibimizde 15+ yıllık deneyime sahip lisanslı finansal analistler, eski banka çalışanları ve sermaye piyasası uzmanları bulunmaktadır. Ayrıca yapay zeka destekli algoritmalarımız da 7/24 piyasa analizi yapmaktadır. Tüm uzmanlarımız SPK lisansına sahiptir.</p>
                            </div>
                        </div>

                        <!-- Ana sayfadaki SSS sorularını ekleme - Ne kadar kazanacağım? -->
                        <div class="py-4">
                            <button @click="active !== 8 ? active = 8 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Ne kadar kazanacağım?</h4>
                                <svg :class="{'rotate-180': active === 8}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 8" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Kazanç miktarı yatırım tutarı, piyasa koşulları ve seçilen plana göre değişir. Minimum paketlerimiz aylık %15-25 getiri potansiyeline sahiptir. VIP paketlerde bu oran %40'a kadar çıkabilir. Gerçek kazanç geçmişinizi hesap panelinizden takip edebilirsiniz.</p>
                            </div>
                        </div>

                        <!-- Ana sayfadaki SSS sorularını ekleme - Devlet neden destek veriyor? -->
                        <div class="py-4">
                            <button @click="active !== 9 ? active = 9 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Devlet neden destek veriyor?</h4>
                                <svg :class="{'rotate-180': active === 9}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 9" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Devletimiz yerli finansal teknolojilerin gelişmesini ve vatandaşlarımızın uluslararası platformlara bağımlılığının azalmasını desteklemektedir. Ayrıca yerli şirketlere yatırım yapılarak ekonomik büyümeye katkı sağlanması hedeflenmektedir. Bu destek sayesinde daha düşük maliyetlerle hizmet verebiliyoruz.</p>
                            </div>
                        </div>

                        <!-- Ana sayfadaki SSS sorularını ekleme - Komisyon ve ücretler nelerdir? -->
                        <div class="py-4">
                            <button @click="active !== 10 ? active = 10 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Komisyon ve ücretler nelerdir?</h4>
                                <svg :class="{'rotate-180': active === 10}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 10" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Platform kullanım ücreti aylık ₺99'dur. İşlem komisyonları %0.1 ile %0.5 arasında değişir. Para yatırma/çekme işlemleri ücretsizdir. VIP üyelerimiz için özel indirimler uygulanır. Tüm ücretler şeffaf olarak gösterilir ve sürpriz maliyet yoktur.</p>
                            </div>
                        </div>

                        <!-- Ana sayfadaki SSS sorularını ekleme - Veriler nereden geliyor? -->
                        <div class="py-4">
                            <button @click="active !== 11 ? active = 11 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Veriler nereden geliyor?</h4>
                                <svg :class="{'rotate-180': active === 11}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 11" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Gerçek zamanlı piyasa verilerini Borsa İstanbul, uluslararası borsalar ve Bloomberg Terminal gibi güvenilir kaynaklardan alıyoruz. Ayrıca kendi geliştirdiğimiz algoritmalar ile teknik analiz ve yapay zeka destekli tahminler üretiyoruz. Tüm veriler SSL şifreleme ile korunur.</p>
                            </div>
                        </div>

                        <!-- Ana sayfadaki SSS sorularını ekleme - Nasıl para yatırır/çekerim? -->
                        <div class="py-4">
                            <button @click="active !== 12 ? active = 12 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Nasıl para yatırır/çekerim?</h4>
                                <svg :class="{'rotate-180': active === 12}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 12" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Havale/EFT, kredi kartı, kripto para ve diğer ödeme yöntemleri ile 7/24 para yatırabilirsiniz. Minimum yatırım tutarı ₺1.000'dir. Para çekme işlemleri maksimum 24 saat içinde gerçekleşir. VIP üyelerimiz için öncelikli işlem yapılır.</p>
                            </div>
                        </div>

                        <!-- Ana sayfadaki SSS sorularını ekleme - Hesabımı nasıl kapatırım? -->
                        <div class="py-4">
                            <button @click="active !== 13 ? active = 13 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Hesabımı nasıl kapatırım?</h4>
                                <svg :class="{'rotate-180': active === 13}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 13" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Hesap kapatma işlemi profil ayarlarından veya müşteri hizmetleri üzerinden yapılabilir. Önce açık pozisyonlarınızı kapatmanız ve bakiyenizi çekmeniz gerekir. Hesap kapatma işlemi 7 gün sürer ve bu süre zarfında cayma hakkınız vardır. Tüm verileriniz güvenli şekilde silinir.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deposit Category -->
            <div x-show="activeCategory === 'deposit'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-4"
                class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="divide-y divide-gray-700" x-data="{active: null}">
                        <!-- Deposit Questions -->
                        <div class="py-4">
                            <button @click="active !== 0 ? active = 0 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Para yatırmak için hangi ödeme yöntemlerini kullanabilirim?</h4>
                                <svg :class="{'rotate-180': active === 0}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 0" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p><span class="font-semibold text-blue-300">PerfectMoney</span>, <span class="font-semibold text-blue-300">BitCoin</span>, <span class="font-semibold text-blue-300">Ethereum</span>, <span class="font-semibold text-blue-300">LiteCoin</span>, <span class="font-semibold text-blue-300">DogeCoin</span>, <span class="font-semibold text-blue-300">TRON</span>, <span class="font-semibold text-blue-300">Tether TRC20</span>, <span class="font-semibold text-blue-300">Tether ERC20</span> ödeme sistemleri ile çalışıyoruz</p>
                            </div>
                        </div>

                        <div class="py-4">
                            <button @click="active !== 1 ? active = 1 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Yatırım miktarında herhangi bir kısıtlama var mı?</h4>
                                <svg :class="{'rotate-180': active === 1}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 1" x-collapse x-cloak class="mt-3">
                                <p class="text-gray-300 mb-4">Tarife planları depozito miktarında minimum ve maksimum tutarlar için şu kısıtlamaları belirler:</p>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                                    <div class="bg-gray-700 bg-opacity-50 rounded-lg p-3">
                                        <h5 class="font-medium text-white mb-1">Minimum Tutar:</h5>
                                        <ul class="text-gray-300 space-y-1">
                                            <li><span class="text-blue-300">10</span> USD</li>
                                            <li><span class="text-blue-300">0.005</span> BTC</li>
                                            <li><span class="text-blue-300">0.02</span> ETH</li>
                                            <li><span class="text-blue-300">0.3</span> LTC</li>
                                            <li><span class="text-blue-300">50</span> DOGE</li>
                                            <li><span class="text-blue-300">100</span> TRX</li>
                                            <li><span class="text-blue-300">10</span> USDT</li>
                                        </ul>
                                    </div>

                                    <div class="bg-gray-700 bg-opacity-50 rounded-lg p-3">
                                        <h5 class="font-medium text-white mb-1">Maksimum Tutar:</h5>
                                        <ul class="text-gray-300 space-y-1">
                                            <li><span class="text-blue-300">75.000</span> USD</li>
                                            <li><span class="text-blue-300">1.5</span> BTC</li>
                                            <li><span class="text-blue-300">20</span> ETH</li>
                                            <li><span class="text-blue-300">300</span> LTC</li>
                                            <li><span class="text-blue-300">350.000</span> DOGE</li>
                                            <li><span class="text-blue-300">750.000</span> TRX</li>
                                            <li><span class="text-blue-300">75.000</span> USDT</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-4">
                            <button @click="active !== 2 ? active = 2 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Aynı anda birden fazla depozito yapabilir miyim?</h4>
                                <svg :class="{'rotate-180': active === 2}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 2" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Evet, sınırsız sayıda depozito sahibi olabilirsiniz ve aynı zamanda farklı tarife planlarına da yatırım yapabilirsiniz.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Withdrawal Category -->
            <div x-show="activeCategory === 'withdrawal'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-4"
                class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="divide-y divide-gray-700" x-data="{active: null}">
                        <!-- Withdrawal Questions -->
                        <div class="py-4">
                            <button @click="active !== 0 ? active = 0 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Para çekme talebi işleme ne kadar sürer?</h4>
                                <svg :class="{'rotate-180': active === 0}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 0" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Para çekme talepleri anında işleme alınır. <span class="font-semibold text-blue-300">PerfectMoney</span> ödeme sistemi için - hesabınızda ödemeyi sipariş ettikten sonra fonlar cüzdana anında ulaşır. <span class="font-semibold text-blue-300">BitCoin</span>, <span class="font-semibold text-blue-300">Ethereum</span>, <span class="font-semibold text-blue-300">LiteCoin</span>, <span class="font-semibold text-blue-300">DogeCoin</span>, <span class="font-semibold text-blue-300">TRON</span>, <span class="font-semibold text-blue-300">Tether TRC20</span>, <span class="font-semibold text-blue-300">Tether ERC20</span> ödeme sistemleri için cüzdana fonlar için en az 3 ağ onayı gereklidir ve bu 20 dakikadan birkaç saate kadar sürebilir.</p>
                            </div>
                        </div>

                        <div class="py-4">
                            <button @click="active !== 1 ? active = 1 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Minimum para çekme miktarı nedir?</h4>
                                <svg :class="{'rotate-180': active === 1}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 1" x-collapse x-cloak class="mt-3">
                                <div class="bg-gray-700 bg-opacity-50 rounded-lg p-4">
                                    <h5 class="font-medium text-white mb-2">Minimum Para Çekme Miktarları:</h5>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                                        <div class="bg-gray-900 bg-opacity-70 p-2 rounded">
                                            <span class="text-blue-300 font-medium">0.1</span> USD
                                        </div>
                                        <div class="bg-gray-900 bg-opacity-70 p-2 rounded">
                                            <span class="text-blue-300 font-medium">0.002</span> BTC
                                        </div>
                                        <div class="bg-gray-900 bg-opacity-70 p-2 rounded">
                                            <span class="text-blue-300 font-medium">0.03</span> ETH
                                        </div>
                                        <div class="bg-gray-900 bg-opacity-70 p-2 rounded">
                                            <span class="text-blue-300 font-medium">0.1</span> LTC
                                        </div>
                                        <div class="bg-gray-900 bg-opacity-70 p-2 rounded">
                                            <span class="text-blue-300 font-medium">60</span> DOGE
                                        </div>
                                        <div class="bg-gray-900 bg-opacity-70 p-2 rounded">
                                            <span class="text-blue-300 font-medium">60</span> TRX
                                        </div>
                                        <div class="bg-gray-900 bg-opacity-70 p-2 rounded">
                                            <span class="text-blue-300 font-medium">10</span> USDT (TRC20)
                                        </div>
                                        <div class="bg-gray-900 bg-opacity-70 p-2 rounded">
                                            <span class="text-blue-300 font-medium">150</span> USDT (ERC20)
                                        </div>
                                    </div>
                                    <p class="mt-3 text-gray-300">Günlük para çekme işlemi sayısı ve maksimum para çekme miktarında herhangi bir kısıtlama yoktur.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Referral Program Category -->
            <div x-show="activeCategory === 'referral'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-4"
                class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="divide-y divide-gray-700" x-data="{active: null}">
                        <!-- Referral Questions -->
                        <div class="py-4">
                            <button @click="active !== 0 ? active = 0 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Referans programı sunuyor musunuz?</h4>
                                <svg :class="{'rotate-180': active === 0}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 0" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Yatırımcılarımıza ek gelir için bir ortaklık programı sunuyoruz. Yeni üyeleri davet ederek ve bunun karşılığında cömert ödül alarak herkes şirketin gelişimine katılabilir.</p>
                            </div>
                        </div>

                        <div class="py-4">
                            <button @click="active !== 1 ? active = 1 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Ortaklık programı nasıl çalışır?</h4>
                                <svg :class="{'rotate-180': active === 1}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 1" x-collapse x-cloak class="mt-3">
                                <p class="text-gray-300">{{$settings->site_name}} sadece platforma getirdiğiniz ortaklar için değil, aynı zamanda 2, 3 ve 4. seviyelerdeki ortaklar için de ödül veren benzersiz bir yatırım ve referans programı sunar. Bu benzersiz ortaklık programı size pasif referans geliri sağlar.</p>

                                <div class="mt-4 bg-gray-700 bg-opacity-50 p-4 rounded-xl">
                                    <h5 class="font-medium text-white mb-2">Ortaklık Komisyon Yapısı:</h5>
                                    <div class="grid grid-cols-4 gap-2 text-center">
                                        <div class="bg-blue-600 bg-opacity-20 p-2 rounded">
                                            <div class="text-2xl font-bold text-blue-400">%7</div>
                                            <div class="text-xs text-gray-300">1. Seviye</div>
                                        </div>
                                        <div class="bg-blue-600 bg-opacity-15 p-2 rounded">
                                            <div class="text-2xl font-bold text-blue-400">%3</div>
                                            <div class="text-xs text-gray-300">2. Seviye</div>
                                        </div>
                                        <div class="bg-blue-600 bg-opacity-10 p-2 rounded">
                                            <div class="text-2xl font-bold text-blue-400">%2</div>
                                            <div class="text-xs text-gray-300">3. Seviye</div>
                                        </div>
                                        <div class="bg-blue-600 bg-opacity-5 p-2 rounded">
                                            <div class="text-2xl font-bold text-blue-400">%1</div>
                                            <div class="text-xs text-gray-300">4. Seviye</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Questions Category -->
            <div x-show="activeCategory === 'other'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-4"
                class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="divide-y divide-gray-700" x-data="{active: null}">
                        <!-- Other Questions -->
                        <div class="py-4">
                            <button @click="active !== 0 ? active = 0 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Şifremi unuttuysam ne yapmalıyım?</h4>
                                <svg :class="{'rotate-180': active === 0}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 0" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Sitenin ana sayfasındaki giriş bölümünde şifre sıfırlama bağlantısına tıklayın. Kullanıcı adınızı ve e-posta adresinizi girin ve talimatları izleyin. {{$settings->site_name}} hesap şifrenizi nasıl sıfırlayacağınız hakkında bilgi alacaksınız.</p>
                            </div>
                        </div>

                        <div class="py-4">
                            <button @click="active !== 1 ? active = 1 : active = null" class="flex justify-between items-center w-full focus:outline-none">
                                <h4 class="text-lg font-medium text-white">Bir para birimini başka bir para birimiyle nerede değiştirebilirim?</h4>
                                <svg :class="{'rotate-180': active === 1}" class="w-5 h-5 text-blue-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="active === 1" x-collapse x-cloak class="mt-3 text-gray-300">
                                <p>Güvenilir döviz büroları ile izleme - bestchange kullanabilirsiniz. En iyi kuru sunan döviz bürosunu seçin ve talimatları izleyin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-12 bg-gradient-to-br from-gray-900 to-gray-800">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-8">
            <div class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-white">Hala sorularınız mı var?</h2>
                </div>
                <p class="text-gray-300 mb-6">Destek ekibimiz platformumuz hakkında sahip olabileceğiniz herhangi bir soru veya endişenizde size yardımcı olmak için 7/24 hizmetinizdedir.</p>
                <div class="flex space-x-4 pt-2">
                    <a href="/contact" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        Destek ile İletişime Geçin
                        <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden p-8 relative">
                <!-- Decorative crypto icons in background -->
                <div class="absolute inset-0 z-0 opacity-10">
                    <svg class="absolute top-4 right-4 w-16 h-16 text-blue-400" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.944 17.97L4.58 13.62 11.943 24l7.37-10.38-7.372 4.35h.003zM12.056 0L4.69 12.223l7.365 4.354 7.365-4.35L12.056 0z"/>
                    </svg>
                    <svg class="absolute bottom-4 left-4 w-12 h-12 text-blue-400" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0C5.372 0 0 5.373 0 12s5.372 12 12 12 12-5.373 12-12S18.628 0 12 0zm2.595 17.35a4.356 4.356 0 01-.778.55 5.858 5.858 0 01-.977.397c-.34.101-.68.15-1.05.182v1.4H10.2v-1.39c-.786-.091-1.518-.302-2.214-.605a5.567 5.567 0 01-1.698-1.246l1.245-1.507c.122.121.285.26.488.417.204.156.433.304.686.444.252.14.516.255.822.346.254.09.572.136.903.136.474 0 .89-.078 1.246-.233.357-.156.535-.45.535-.853a.766.766 0 00-.194-.535 1.676 1.676 0 00-.465-.356 3.869 3.869 0 00-.627-.266c-.234-.07-.44-.15-.627-.224a22.14 22.14 0 01-.905-.346 10.596 10.596 0 01-.938-.45 2.965 2.965 0 01-.778-.627c-.22-.252-.336-.573-.356-.938-.04-.697.204-1.296.673-1.813.47-.516 1.126-.876 1.977-1.05V7.44h1.592v1.245c.657.06 1.244.206 1.77.44.524.236.986.517 1.387.845l-1.167 1.506a6.52 6.52 0 00-1.02-.6 2.802 2.802 0 00-1.205-.249c-.497 0-.889.093-1.166.288-.279.196-.417.444-.417.744 0 .141.036.267.117.378.08.112.186.213.356.324.139.11.346.214.534.324.209.11.417.192.627.267.497.172.959.345 1.387.515.427.172.804.392 1.127.673.323.283.583.614.778 1.005.194.39.313.89.313 1.483a2.282 2.282 0 01-.268.8zm2.382-5.447h4.927v1.507h-4.927v-1.507z"/>
                    </svg>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-400 to-teal-400 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white">İşlem yapmaya hazır mısınız?</h2>
                    </div>
                    <p class="text-gray-300 mb-6">Hemen bir hesap oluşturun ve yenilikçi işlem platformumuzla kazanmaya başlayın. Başlamak sadece birkaç dakika sürer!</p>
                    <div class="flex space-x-4 pt-2">
                        <a href="/register" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-gray-900 bg-gradient-to-r from-blue-400 to-teal-400 hover:from-blue-500 hover:to-teal-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                            Hesap Oluştur
                            <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>

<!-- Back to top button - Redesigned -->
<button id="back-to-top" class="fixed bottom-8 right-8 z-50 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 shadow-lg transition-all duration-300 opacity-0 translate-y-10" aria-label="Back to top">
    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
    </svg>
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.getElementById('back-to-top');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'translate-y-10');
                backToTopButton.classList.add('opacity-100', 'translate-y-0');
            } else {
                backToTopButton.classList.add('opacity-0', 'translate-y-10');
                backToTopButton.classList.remove('opacity-100', 'translate-y-0');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>
@endsection
