@extends('layouts.base')
@inject('content', 'App\Http\Controllers\FrontController')
@section('title', '{{$title}}')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gray-900 overflow-hidden">
    <!-- Background with overlay -->
    <div class="absolute inset-0">
        <!-- Dynamic grid pattern background -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            <div class="absolute inset-0 opacity-20">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="shares-grid" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M0 40V0h40" fill="none" stroke="currentColor" stroke-width="0.5" />
                            <circle cx="20" cy="20" r="1" fill="currentColor" opacity="0.5" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#shares-grid)" />
                </svg>
            </div>
        </div>
        <!-- Glowing accent elements -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-blue-500 rounded-full filter blur-3xl opacity-10"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-emerald-400 rounded-full filter blur-3xl opacity-10"></div>
    </div>

    <div class="container mx-auto px-4 py-16 relative z-10">
        <div class="max-w-4xl">
            <!-- Title and Breadcrumb -->
            <div class="mb-8">
                <div class="inline-block px-3 py-1 text-xs font-semibold tracking-wider text-emerald-400 uppercase bg-emerald-900 bg-opacity-30 rounded-full mb-4">
                    Yatırım Ürünleri
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Hisse Senedi İşlemleri</h1>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{$settings->site_address}}" class="text-gray-400 hover:text-white">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                {{$settings->site_name}}
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="#" class="text-gray-400 hover:text-white ml-1 md:ml-2">İşlem</a>
                            </div>
                        </li>
                    </ol>
                </nav>

                <script type="application/ld+json">
                    {
                        "@context": "http://schema.org",
                        "@type": "BreadcrumbList",
                        "itemListElement": [
                            {
                                "@type": "ListItem",
                                "position": 1,
                                "item": {
                                    "@id": "{{$settings->site_address}}",
                                    "name": "{{$settings->site_name}}"
                                }
                            },
                            {
                                "@type": "ListItem",
                                "position": 2,
                                "item": {
                                    "@id": "{{$settings->site_address}}trading",
                                    "name": "İşlem"
                                }
                            }
                        ]
                    }
                </script>
            </div>

            <!-- Main Content -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-filter backdrop-blur-sm rounded-xl p-8 border border-gray-700">
                <div class="prose prose-lg prose-invert max-w-none">
                    <p class="text-gray-300 leading-relaxed">
                        Hisse senetleri, bir şirketteki öz sermaye mülkiyet hissesinin birimleridir ve kar payları şeklinde kalan karların eşit dağılımını sağlayan bir finansal varlık olarak var olur. Hisse senedi sahipleri ayrıca şirketin değeri yükseldiğinde sermaye kazançlarından da yararlanabilir.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Share Trading Table Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <!-- Trading Table Card -->
        <div class="bg-gray-800 rounded-xl shadow-xl overflow-hidden border border-gray-700">
            <!-- Table Header -->
            <div class="p-6 bg-gray-800 border-b border-gray-700">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h2 class="text-2xl font-bold text-white">Mevcut Hisse Senetleri</h2>
                    <div class="flex items-center space-x-4">
                        <!-- Search Box -->
                        <div class="relative">
                            <input type="text" class="search-box w-64 px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:border-blue-500 placeholder-gray-400"
                                placeholder="Hisse senetlerini ara...">
                            <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table id="tt-spreads-6023e31008b95" class="w-full">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Sembol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Şirket</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Fiyat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Değişim</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Hacim</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
$(function() {
    var $dttble = $('#tt-spreads-6023e31008b95').DataTable({
        "scrollY": "50vh",
        "scrollCollapse": true,
        "responsive": true,
        "paging": false,
        "ordering": true,
        "searching": true,
        "language": {
            "zeroRecords": "Eşleşen kayıt bulunamadı",
            "search": ""
        },
        "dom": '<"top"f>rt<"bottom"ilp><"clear">',
        "columnDefs": [
            { targets: [ 'category', 'sub_category' ], visible: false }
        ],
        "drawCallback": function(settings) {
            // Apply Tailwind classes to DataTables elements
            $('.dataTables_wrapper').addClass('bg-gray-800');
            $('.dataTables_info').addClass('text-gray-400 p-4');
            $('.dataTables_filter input').addClass('bg-gray-700 border border-gray-600 rounded-lg text-gray-200 px-4 py-2');
        },
        initComplete: function() {
            $('.loader').hide();
            $('.pat').removeClass('loading');

            // Connect search box
            $('.search-box').keyup(function() {
                $dttble.search(this.value).draw();
            });

            // Fetch stock data
            fetchStockData();
        }
    });

    // Responsive handling
    $(window).on('resize', function() {
        setTimeout(function() {
            AOS.refresh();
            $dttble.columns.adjust().draw();
        }, 250);
    });

    function fetchStockData() {
        // List of Turkish stocks
        const symbols = ['ASELS.IS', 'THYAO.IS', 'GARAN.IS', 'AKBNK.IS', 'KOZAL.IS'];

        // Alpha Vantage API key (replace with your own)
        const apiKey = 'YOUR_ALPHA_VANTAGE_API_KEY';

        symbols.forEach(symbol => {
            // Fetch company name from OVERVIEW
            fetch(`https://www.alphavantage.co/query?function=OVERVIEW&symbol=${symbol}&apikey=${apiKey}`)
                .then(response => response.json())
                .then(overview => {
                    const companyName = overview.Name || symbol;
                    // Fetch quote data
                    return fetch(`https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=${symbol}&apikey=${apiKey}`)
                        .then(response => response.json())
                        .then(quote => {
                            const quoteData = quote['Global Quote'];
                            if (quoteData) {
                                const rowData = [
                                    quoteData['01. symbol'] || symbol,
                                    companyName,
                                    parseFloat(quoteData['05. price'] || 0).toFixed(2),
                                    parseFloat(quoteData['10. change percent'] || 0).toFixed(2) + '%',
                                    parseInt(quoteData['06. volume'] || 0).toLocaleString()
                                ];
                                $dttble.row.add(rowData).draw();
                            }
                        });
                })
                .catch(error => {
                    console.error(`Error fetching data for ${symbol}:`, error);
                    // Optional: Add error row or alert
                    // alert(`Hata: ${symbol} için veri alınamadı.`);
                });
        });
    }
});
</script>

<!-- Features Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">İstediğiniz Şeyi, İstediğiniz Zaman İşleyin</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-emerald-400 mx-auto"></div>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Column - Image -->
            <div class="relative" data-aos="fade-right" data-aos-duration="1200">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-emerald-400/20 rounded-xl filter blur-xl"></div>
                    <img src="temp/custom/img/commission-scheme-crypt1t1.png" alt="commission-scheme" class="relative z-10 w-full rounded-xl shadow-2xl">
                </div>
            </div>

            <!-- Right Column - Content -->
            <div class="space-y-8">
                <div class="bg-gray-800 bg-opacity-50 backdrop-filter backdrop-blur-sm rounded-xl p-8 border border-gray-700">
                    <p class="text-xl text-gray-200 leading-relaxed mb-6">
                        {{$settings->site_name}}'ın birincil hedeflerinden biri, piyasadaki en iyi ürünü sağlamaktır. Önde gelen birinci sınıf finans kurumlarıyla olan ilişkilerimiz, Forex traderları için derin likidite ve daha sık spreadler anlamına gelir.
                    </p>

                    <ul class="space-y-4">
                        <li class="flex items-center space-x-3">
                            <svg class="flex-shrink-0 h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-300">Forex, Endeksler, Hisse Senetleri ve Emtialar İşleyin</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="flex-shrink-0 h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-300">Küresel pazarlara 24 saat / 7 gün erişin</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="flex-shrink-0 h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-300">Çok dilli müşteri desteği</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="flex-shrink-0 h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-300">Mobil uygulamalarımızda hareket halindeyken işlem yapın</span>
                        </li>
                    </ul>

                    <div class="mt-8">
                        <a href="trading-conditions" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-emerald-500 hover:from-blue-700 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-lg hover:shadow-xl" title="{{$settings->site_name}} Komisyonları Hakkında Bilgi Edinin">
                            Komisyonlarımız Hakkında Daha Fazla Bilgi Edinin
                            <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl overflow-hidden shadow-2xl">
            <div class="relative px-8 py-12 md:p-12">
                <!-- Decorative elements -->
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-blue-500/30 to-emerald-400/30 blur-3xl"></div>
                </div>

                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <!-- Contact Section -->
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">Bize Ulaşın</h3>
                        <p class="text-gray-300 mb-6">Kişiselleştirilmiş destek için uzman ekibimizle iletişime geçin</p>
                        <div class="flex items-center justify-center md:justify-start space-x-4">
                            <a href="mailto:{{$settings->contact_email}}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-700 hover:bg-gray-600 transition-colors duration-300">
                                <i class="fa fa-envelope text-gray-200"></i>
                            </a>
                            <!-- Add more social icons as needed -->
                        </div>
                    </div>

                    <!-- Live Chat Section -->
                    <div class="text-center md:text-right">
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">Yardıma İhtiyacınız Var mı?</h3>
                        <a onclick="openLiveChat(event)" href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-emerald-500 hover:from-blue-700 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fa fa-commenting mr-2"></i>
                            Canlı Sohbeti Başlat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection