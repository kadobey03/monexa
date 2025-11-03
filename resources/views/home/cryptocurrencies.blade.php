@extends('layouts.base')
@inject('content', 'App\Http\Controllers\FrontController')
@section('title', $title)

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800">
    <!-- Abstract Background Elements -->
    <div class="absolute inset-0 z-0 pointer-events-none opacity-20">
        <!-- Abstract Crypto Shapes -->
        <div class="absolute top-0 right-0 w-full h-full">
            <svg class="absolute top-0 right-0 w-full h-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="cryptoGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop stop-color="#F7931A" stop-opacity=".25" offset="0%"/>
                        <stop stop-color="#627EEA" stop-opacity=".2" offset="50%"/>
                        <stop stop-color="#11A97D" stop-opacity=".15" offset="100%"/>
                    </linearGradient>
                </defs>
                <!-- BTC-inspired shape -->
                <path fill="url(#cryptoGrad1)" d="M400,115 C515.46,115 615,214.54 615,330 C615,445.46 515.46,545 400,545 C284.54,545 185,445.46 185,330 C185,214.54 284.54,115 400,115 Z" />
            </svg>
        </div>
        <!-- Blockchain Network Effect -->
        <div class="absolute inset-0">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" stroke="#6366F1" stroke-width="2" opacity="0.15">
                    <path d="M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764"/>
                    <path d="M-4 44L190 190 731 737 520 660 309 538 40 599 295 764"/>
                    <path d="M-4 44L190 190 731 737M490 85L309 538 40 599 295 764"/>
                </g>
            </svg>
        </div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 px-4 py-20 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center">
            <div class="w-full lg:w-2/3 mb-8 lg:mb-0" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 200)">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="space-y-6"
                >
                    <div class="inline-block px-3 py-1 mb-2 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                        Dijital Varlıklar
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">
                        <span class="block">Kripto Para</span>
                        <span class="block mt-2 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-400 to-orange-400">Bitcoin, Ethereum, Ripple ve daha fazlasında CFD'ler</span>
                    </h1>
                    <p class="mt-3 text-lg text-gray-300 max-w-2xl">
                        Kripto para, elektronik olarak oluşturulan ve tutulan dijital bir para birimidir. Finansal işlemler yürütmek için kriptografik işlevleri kullanan internet tabanlı bir değişim aracıdır. Diğer para birimleri gibi basılmazlar – matematiksel problemleri çözen yazılımlar kullanarak dünya çapında bilgisayarları çalıştıran insanlar ve giderek artan şekilde işletmeler tarafından üretilirler.
                    </p>
                    <div class="flex flex-wrap gap-4 mt-6">
                        <a href="#crypto-table" class="px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
                            Pazarları Görüntüle
                        </a>
                        <a href="register" class="px-6 py-3 text-base font-medium text-gray-300 bg-gray-800 border border-gray-700 rounded-lg shadow-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
                            Alım Satıma Başla
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/3" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 500)">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-500 delay-300"
                    x-transition:enter-start="opacity-0 transform translate-y-12"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="relative"
                >
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Bitcoin -->
                        <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-4 rounded-xl border border-gray-700 transform hover:translate-y-[-5px] transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-2">
                                <img src="dash/bitcoin-btc-logo.png" alt="Bitcoin" class="w-10 h-10">
                                <div>
                                    <h3 class="text-lg font-bold text-white">BTC/USD</h3>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400">Fiyat</span>
                                <span class="text-green-400 font-medium">$48,795.20</span>
                            </div>
                        </div>
                        <!-- Ethereum -->
                        <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-4 rounded-xl border border-gray-700 transform hover:translate-y-[-5px] transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-2">
                                <img src="dash/ethereum-eth-logo.png" alt="Ethereum" class="w-10 h-10">
                                <div>
                                    <h3 class="text-lg font-bold text-white">ETH/USD</h3>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400">Fiyat</span>
                                <span class="text-green-400 font-medium">$2,873.50</span>
                            </div>
                        </div>
                        <!-- Tether -->
                        <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-4 rounded-xl border border-gray-700 transform hover:translate-y-[-5px] transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-2">
                                <img src="dash/tether-usdt-logo.png" alt="Tether" class="w-10 h-10">
                                <div>
                                    <h3 class="text-lg font-bold text-white">USDT/USD</h3>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400">Fiyat</span>
                                <span class="text-gray-300 font-medium">$1.00</span>
                            </div>
                        </div>
                        <!-- XRP -->
                        <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-4 rounded-xl border border-gray-700 transform hover:translate-y-[-5px] transition-all duration-300">
                            <div class="flex items-center space-x-3 mb-2">
                                <div class="w-10 h-10 bg-blue-600 bg-opacity-20 rounded-full flex items-center justify-center text-blue-400">
                                    XRP
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">XRP/USD</h3>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400">Fiyat</span>
                                <span class="text-red-400 font-medium">$0.72</span>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-blue-500 bg-opacity-20 rounded-full filter blur-xl"></div>
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-purple-500 bg-opacity-20 rounded-full filter blur-xl"></div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Crypto Markets Table Section -->
<section id="crypto-table" class="py-16 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Canlı Piyasalar
            </div>
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Kripto Para Piyasaları</span>
            </h2>
            <p class="mt-4 text-xl text-gray-300 max-w-3xl mx-auto">
                Dünyanın en popüler kripto para birimlerinde rekabetçi spread'ler ve gelişmiş araçlarla CFD ticareti yapın
            </p>
        </div>

        <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm rounded-xl border border-gray-700 overflow-hidden shadow-lg">
            <!-- Search and Filter Controls -->
            <div class="p-4 border-b border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="relative w-full md:w-64">
                    <input type="text" class="search-box w-full bg-gray-900 border border-gray-700 rounded-lg py-2 px-4 pl-10 text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Kripto paraları ara...">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <div class="flex flex-wrap gap-2">
                    <select class="selfi bg-gray-900 border border-gray-700 rounded-lg py-2 px-4 text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="All">Tüm Kripto Paralar</option>
                        <option value="Major">Ana Kripto Paralar</option>
                        <option value="Altcoins">Altcoin'ler</option>
                        <option value="DeFi">DeFi Token'ları</option>
                    </select>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                        Filtrele
                    </button>
                </div>
            </div>

            <!-- Data Table -->
            <div class="relative overflow-x-auto pat loading" style="min-height: 400px;">
                <div class="loader absolute inset-0 flex items-center justify-center">
                    <div class="w-12 h-12 rounded-full animate-spin border-4 border-solid border-blue-500 border-t-transparent"></div>
                </div>
                <div class="w-full">
                    <table id="tt-spreads-6023e3178f8b3" class="w-full text-sm text-left text-gray-300">
                        <thead class="text-xs uppercase bg-gray-800 text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Sembol</th>
                                <th class="px-6 py-3">İsim</th>
                                <th class="px-6 py-3">Fiyat</th>
                                <th class="px-6 py-3">24s Değişim</th>
                                <th class="px-6 py-3">Pazar Değeri</th>
                                <th class="px-6 py-3">Spread</th>
                                <th class="px-6 py-3">Eylem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table will be populated by DataTable script -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script type=text/javascript>
    $(function() {
        var $dttble = $('#tt-spreads-6023e3178f8b3').DataTable({
            "scrollY": "50vh",
            "scrollCollapse": true,
            "responsive": true,
            "paging": false,
            "ordering": false,
            "searching": true,
            "language": {
                "zeroRecords": "Eşleşen kayıt bulunamadı"
            },
            "columnDefs": [{
                targets: ['category', 'sub_category'],
                visible: false
            }],
            "drawCallback": function(settings) {
                $('.dataTables_scrollHead').css('width', '100%');
                $('.dataTables_scrollHeadInner').css('width', '100%');
                $('.dataTables_scrollHeadInner').find('.dataTable').css('width', '100%');
            },
            initComplete: function() {
                $('.loader').hide();
                $('.pat').removeClass('loading');
                $('.search-box').keyup(function() {
                    $dttble.search(this.value).draw();
                });
                let index = parseInt('1');
                $('.selfi').change(function() {
                    if (this.value === "All") {
                        $dttble.column(index).search('').draw();
                        $('.subselfi option').show();
                    } else {
                        $dttble.column(index).search(this.value).draw();
                        if ('undefined' !== typeof subindex) {
                            let id = $(this).find(':selected').attr('data-id');
                            $('.subselfi option').hide();
                            $('.subselfi option[data-parent="' + id + '"]').show();
                        }
                    }
                    if ('undefined' !== typeof subindex) {
                        $dttble.column(subindex).search('').draw();
                        $('.subselfi option[data-parent="all"]').show();
                        $('.subselfi option[data-parent="all"]').prop('selected', true);
                    }
                });
                // CoinGecko API'den veri çek
                fetchCryptoData();
            }
        });

        var tabs = $('.tabs .tab').on('click', function($event) {
            $event.preventDefault();
            tabs.removeClass('current');
            $(this).addClass('current');
            var target = $(this).data('target');
            $('.tabs-content .tab-content').css({
                'height': 0,
                'display': 'none'
            }).parent().find('.' + target).css({
                'height': '100%',
                'display': 'block',
            });
            $dttble.columns.adjust().draw();
            return false;
        });

        $(window).on('load', function() {
            AOS.refresh();
            $dttble.columns.adjust().draw();
        });

        $(window).on('resize', function() {
            setTimeout(function() {
                AOS.refresh();
                $dttble.columns.adjust().draw();
            }, 250);
        });

        // CoinGecko API'den kripto para verilerini çek
        function fetchCryptoData() {
            fetch('https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=100&page=1')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('API çağrısı başarısız');
                    }
                    return response.json();
                })
                .then(data => {
                    // Veriyi işle ve tabloya ekle
                    var rows = [];
                    data.forEach(coin => {
                        var changeClass = coin.price_change_percentage_24h >= 0 ? 'text-green-400' : 'text-red-400';
                        var changeSymbol = coin.price_change_percentage_24h >= 0 ? '+' : '';
                        var actionButton = '<button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-3 rounded text-xs">Al</button>';
                        var spread = '0.1%'; // Sabit spread değeri

                        rows.push([
                            coin.symbol.toUpperCase(),
                            coin.name,
                            '$' + coin.current_price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
                            '<span class="' + changeClass + '">' + changeSymbol + coin.price_change_percentage_24h.toFixed(2) + '%</span>',
                            '$' + (coin.market_cap / 1000000000).toFixed(2) + 'B',
                            spread,
                            actionButton
                        ]);
                    });
                    $dttble.rows.add(rows).draw();
                })
                .catch(error => {
                    console.error('Kripto para verisi çekme hatası:', error);
                    // Hata durumunda tabloya hata mesajı ekle
                    var errorRow = [
                        '',
                        'Veri yüklenirken hata oluştu',
                        '',
                        '',
                        '',
                        '',
                        ''
                    ];
                    $dttble.rows.add([errorRow]).draw();
                });
        }
    });
</script>









<!-- Features Section -->
<section class="py-20 bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Alım Satım Esnekliği
            </div>
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Ne İstediğinizi Ticaret Edin,</span>
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">Ne Zaman İstediğinizde</span>
            </h2>
            <p class="mt-4 text-xl text-gray-300 max-w-3xl mx-auto">
                Platformumuz başarılı ticaret için ihtiyacınız olan araçları ve erişimi sağlar
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Image Column -->
            <div class="relative order-2 lg:order-1" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 300)" data-aos="fade-right" data-aos-duration="1200" data-aos-anchor=".tr-cost">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 transform translate-x-8"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    class="relative z-10"
                >
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="temp/custom/img/commission-scheme-crypt1t1.png" alt="Trading Platform" class="w-full">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-teal-400 opacity-20"></div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -bottom-8 -right-8 w-40 h-40 bg-blue-500 bg-opacity-20 rounded-full filter blur-xl"></div>
                    <div class="absolute -top-8 -left-8 w-32 h-32 bg-teal-500 bg-opacity-20 rounded-full filter blur-xl"></div>
                </div>
            </div>

            <!-- Content Column -->
            <div class="space-y-8 order-1 lg:order-2" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 500)">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-700 delay-300"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                >
                    <h3 class="text-2xl font-bold text-white mb-6">
                        {{$settings->site_name}}'ın birincil hedeflerinden biri piyasada en iyi ürünü sağlamaktır. Önde gelen birinci kademe finans kurumlarıyla olan ilişkilerimiz, Forex trader'ları için derin likidite ve daha sıkı spread'ler anlamına gelir.
                    </h3>

                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="ml-3 text-lg text-gray-300">
                                Forex, Endeksler, Hisseler ve Emtialar Ticareti Yapın
                            </p>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="ml-3 text-lg text-gray-300">
                                Dünya çapındaki piyasalara 24 saat / 7 gün erişin
                            </p>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="ml-3 text-lg text-gray-300">
                                Çok dilli müşteri desteği
                            </p>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="ml-3 text-lg text-gray-300">
                                Mobil uygulamalarımızda hareket halinde ticaret yapın
                            </p>
                        </li>
                    </ul>

                    <div class="mt-8">
                        <a href="about" title="Learn {{$settings->site_name}}" class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-blue-500 transition-all duration-200">
                            Daha Fazla Bilgi Edinin
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-16 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-blue-900 to-blue-800 rounded-2xl overflow-hidden shadow-xl">
            <div class="relative px-8 py-12 md:p-12 lg:px-16 lg:py-16">
                <!-- Background Pattern -->
                <div class="absolute inset-0 overflow-hidden opacity-10">
                    <svg class="absolute right-0 top-0 h-full" viewBox="0 0 800 800">
                        <path fill="none" stroke="white" stroke-width="2" d="M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764">
                        </path>
                        <path fill="none" stroke="white" stroke-width="2" d="M-4 44L190 190 731 737 520 660 309 538 40 599 295 764">
                        </path>
                        <path fill="none" stroke="white" stroke-width="2" d="M-4 44L190 190 731 737M490 85L309 538 40 599 295 764">
                        </path>
                    </svg>
                </div>

                <!-- Content -->
                <div class="relative z-10 text-center max-w-2xl mx-auto">
                    <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        Kripto Para Ticareti Yapmaya Hazır mısınız?
                    </h2>
                    <p class="mt-4 text-xl text-blue-100">
                        Kripto para ve diğer varlıkları ticaret yapmak için platformumuzu kullanan binlerce trader'a katılın.
                    </p>
                    <div class="mt-8 flex flex-wrap justify-center gap-4">
                        <a href="/register" class="px-8 py-4 text-base font-medium text-blue-900 bg-white border border-transparent rounded-lg shadow-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-800 transition-all duration-200">
                            Ücretsiz Hesap Oluşturun
                        </a>
                        <a href="login" class="px-8 py-4 text-base font-medium text-white bg-transparent border border-white rounded-lg shadow-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-800 transition-all duration-200">
                            Giriş
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




@endsection
