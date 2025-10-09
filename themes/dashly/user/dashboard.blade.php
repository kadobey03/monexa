@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        Hoş geldiniz, {{ Auth::user()->name }}!
    </h1>
    <x-danger-alert />
    <x-success-alert />
    @if (!empty($settings->welcome_message) and Auth::user()->created_at->diffInDays() <= 3)
        <div class="row">
            <div class="col-12">
                <div class="py-4 alert alert-primary alert-dismissible fade show" role="alert">
                    {{ $settings->welcome_message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    @if ($settings->enable_annoc == 'on' and !empty($settings->newupdate))
        <div class="row">
            <div class="col-12">
                <div class="py-4 alert alert-info alert-dismissible fade show" role="alert">
                    {{ $settings->newupdate }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-3">
            <!-- Card -->
            <div class="card border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <div>
                                <!-- Title -->
                                <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                    <span class="legend-circle-sm bg-primary"></span>
                                    Hesap Bakiyesi
                                </h5>

                                <!-- Subtitle -->
                                <h2 class="mb-0">
                                    {{ $settings->currency }}{{ number_format(Auth::user()->account_bal, 2, '.', ',') }}
                                </h2>

                                <a href="{{ route('deposits') }}" class="fs-6 btn-link mb-0 mt-2 mr-3">
                                    Yatırım
                                </a>
                                <span class="">-</span>
                                @if ($moresettings->use_transfer)
                                    <!-- Comment -->
                                    <a href="{{ route('transferview') }}" class="fs-6 btn-link mb-0 mt-2 ml-3">
                                        Aktarım
                                    </a>
                                @endif
                            </div>

                            <span class="text-primary">
                                <i class="bi bi-wallet-fill fs-1"></i>
                            </span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>
        @if ($mod['investment'])
            <div class="col-lg-3">
                <!-- Card -->
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <!-- Title -->
                                    <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                        <span class="legend-circle-sm bg-success"></span>
                                        Toplam Kar
                                    </h5>
                                    <!-- Subtitle -->
                                    <h2 class="mb-0">
                                        {{ $settings->currency }}{{ number_format(Auth::user()->roi, 2, '.', ',') }}
                                    </h2>
                                    <!-- Comment -->
                                    <a href="{{ route('profithistory') }}">
                                        <p class="fs-6 btn-link mb-0 mt-2">
                                            Kar geçmişini görüntüle
                                        </p>
                                    </a>
                                </div>

                                <span class="text-success">
                                    <i class="bi bi-coin fs-1"></i>
                                </span>
                            </div>
                        </div> <!-- / .row -->
                    </div>
                </div>
            </div>
        @endif
        <div class="col-lg-3">
            <!-- Card -->
            <div class="card border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <div>
                                <!-- Title -->
                                <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                    <span class="legend-circle-sm bg-info"></span>
                                    Toplam Bonus
                                </h5>
                                <!-- Subtitle -->
                                <h2 class="mb-0">
                                    {{ $settings->currency }}{{ number_format(Auth::user()->bonus, 2, '.', ',') }}
                                </h2>
                                <!-- Comment -->
                                <a href="{{ route('otherhistory') }}">
                                    <p class="fs-6 btn-link mb-0 mt-2">
                                        Bonus geçmişini görüntüle
                                    </p>
                                </a>
                            </div>

                            <span class="text-info">
                                <i class="bi bi-gift-fill fs-1"></i>
                            </span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <!-- Card -->
            <div class="card border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <div>
                                <!-- Title -->
                                <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                    <span class="legend-circle-sm bg-info"></span>
                                    Referans Bonusu
                                </h5>
                                <!-- Subtitle -->
                                <h2 class="mb-0">
                                    {{ $settings->currency }}{{ number_format(Auth::user()->ref_bonus, 2, '.', ',') }}
                                </h2>
                                <!-- Comment -->
                                <a href="{{ route('referuser') }}">
                                    <p class="fs-6 btn-link mb-0 mt-2">
                                        Referansları görüntüle
                                    </p>
                                </a>
                            </div>

                            <span class="text-info">
                                <i class="bi bi-piggy-bank fs-1"></i>
                            </span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <!-- Card -->
            <div class="card border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <div>
                                <!-- Title -->
                                <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                    <span class="legend-circle-sm bg-success"></span>
                                    Toplam Yatırılan
                                </h5>
                                <!-- Subtitle -->
                                <h2 class="mb-0">
                                    {{ $settings->currency }}{{ number_format($deposited, 2, '.', ',') }}
                                </h2>
                                <!-- Comment -->
                                <a href="{{ route('accounthistory') }}">
                                    <p class="fs-6 btn-link mb-0 mt-2">
                                        Yatırımları görüntüle
                                    </p>
                                </a>
                            </div>

                            <span class="text-success">
                                <i class="bi bi-box-arrow-in-down fs-1"></i>
                            </span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <!-- Card -->
            <div class="card border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <div>
                                <!-- Title -->
                                <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                    <span class="legend-circle-sm bg-danger"></span>
                                    Toplam Çekim
                                </h5>
                                <!-- Subtitle -->
                                <h2 class="mb-0">
                                    {{ $settings->currency }}{{ number_format($total_withdrawal, 2, '.', ',') }}
                                </h2>
                                <!-- Comment -->
                                <a href="{{ route('withdrawlhistory') }}">
                                    <p class="fs-6 btn-link mb-0 mt-2">
                                        Çekimleri görüntüle
                                    </p>
                                </a>
                            </div>

                            <span class="text-danger">
                                <i class="bi bi-box-arrow-in-up fs-1"></i>
                            </span>
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card border-0">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex justify-content-between">
                            <div>
                                <!-- Title -->
                                <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                    <span class="legend-circle-sm bg-secondary"></span>
                                    Referanslar
                                </h5>
                                <!-- Subtitle -->
                                <h2 class="mb-0">
                                    {{ $referrals }}
                                </h2>
                                <!-- Comment -->
                                <a href="{{ route('referuser') }}">
                                    <p class="fs-6 btn-link mb-0 mt-2">
                                        Referansları görüntüle
                                    </p>
                                </a>
                            </div>
                            <span class="text-secondary">
                                <i class="bi bi-link fs-1"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($mod['subscription'])
            <div class="col-lg-3">
                <div class="card border-0">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col d-flex justify-content-between">
                                <div>
                                    <!-- Title -->
                                    <h5 class="d-flex align-items-center text-uppercase text-muted fw-semibold mb-2">
                                        <span class="legend-circle-sm bg-info"></span>
                                        Yönetilen Hesaplar
                                    </h5>
                                    <!-- Subtitle -->
                                    <h2 class="mb-0">
                                        {{ $trading_accounts }}
                                    </h2>
                                    <!-- Comment -->
                                    <a href="{{ route('subtrade') }}">
                                        <p class="fs-6 btn-link mb-0 mt-2">
                                            Hesapları görüntüle
                                        </p>
                                    </a>
                                </div>

                                <span class="text-info">
                                    <i class="bi bi-bar-chart-steps fs-1"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if ($mod['investment'])
        {{-- Active Investment plans section --}}
        <div class="mt-4 row">
            <div class="col-12">
                <div>
                    <h5 class="text-primary h5">Aktif Plan(lar)
                        <span class="text-base count">({{ $plans ? count($plans) : '0' }})</span>
                    </h5>
                </div>
            </div>
            <div class="col-12">
                @forelse ($plans as $plan)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="py-4 card">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="h5">{{ $plan->dplan->name }}</h6>
                                        <p class="h3">
                                            {{ $settings->currency }}{{ number_format($plan->amount) }}
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <div class="d-flex justify-content-around">
                                            <div class="mr-3">
                                                <h6 class="text-black bold">
                                                    {{ $plan->created_at->toDayDateTimeString() }}
                                                </h6>
                                                <span class="nk-iv-scheme-value date">Başlangıç Tarihi</span>
                                            </div>
                                            <span class="m-3">

                                            </span>
                                            <div class="ml-3">
                                                <h6 class="text-black bold">
                                                    {{ \Carbon\Carbon::parse($plan->expire_date)->toDayDateTimeString() }}
                                                </h6>
                                                <span class="nk-iv-scheme-value date">Bitiş Tarihi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="text-black">
                                            @if ($plan->active == 'yes')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($plan->active == 'expired')
                                                <span class="badge bg-danger">Süresi Doldu</span>
                                            @else
                                                <span class="badge bg-danger">Aktif Değil</span>
                                            @endif
                                        </h6>
                                        <span class="nk-iv-scheme-value amount">Durum</span>
                                    </div>

                                    <a href="{{ route('plandetails', $plan->id) }}">
                                        <i class="bi bi-arrow-right fs-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="mt-4 row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="text-center card-body py-4">
                                    <i class="bi bi-database-fill-exclamation" style="font-size: 50px"></i>
                                    <p>Şu anda aktif bir yatırımınız yok.</p>
                                    <a href="{{ route('mplans') }}" class="btn btn-primary">
                                        Şimdi Yatırım Yap
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        {{-- end of active investmet and purchase of investment plan --}}
    @endif
    {{-- 10 Recent transaction begin --}}
    <div class="mt-4 row">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h6 class="text-primary h5">
                    Son işlemler
                </h6>
                <div class="">
                    <a href="{{ route('accounthistory') }}" class="btn btn-primary btn-sm">
                        Tüm işlemleri görüntüle
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tarih</th>
                                    <th>Tür</th>
                                    <th>Miktar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($t_history as $item)
                                    <tr>
                                        <td>
                                            {{ $item->created_at->toDayDateTimeString() }}
                                        </td>
                                        <td>
                                            {{ $item->type }}
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $settings->currency }}{{ number_format($item->amount) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="3">
                                        Henüz kayıt yok
                                    </td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 d-flex">
            <!-- Card -->
            <div class="card border-0 flex-fill w-100">
                <div class="card-header border-0 card-header-space-between">
                    <!-- Title -->
                    <h2 class="card-header-title h4 text-uppercase">
                        Gerçek zamanlı piyasa verileri
                    </h2>
                </div>
                <div class="card-body d-flex flex-column">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/"
                                rel="noopener nofollow" target="_blank"><span class="blue-text">Tüm piyasaları TradingView'de takip edin</span></a></div>
                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-forex-cross-rates.js"
                            async>
                            {
                                "width": "100%",
                                "height": "550",
                                "currencies": [
                                    "EUR",
                                    "USD",
                                    "JPY",
                                    "GBP",
                                    "CHF",
                                    "AUD",
                                    "CAD",
                                    "NZD",
                                    "CNY",
                                    "TRY",
                                    "SEK",
                                    "NOK"
                                ],
                                "isTransparent": true,
                                "colorTheme": "light",
                                "locale": "en",
                                "showChart": true,
                                "backgroundColor": "#ffffff",
                                "gridColor": "#E1E5E9",
                                "textColor": "#191919",
                                "upColor": "#26a69a",
                                "downColor": "#ef5350",
                                "borderColor": "#E1E5E9",
                                "bidAskColor": "#191919",
                                "prevCloseColor": "#808080",
                                "priceColor": "#191919",
                                "dateFormat": "DD MMM YYYY"
                            }
                            }
                    </div>
                    <!-- TradingView Widget END -->
                </div>
            </div>
        </div>
    </div>
    {{-- end of recent transactions --}}
@endsection
