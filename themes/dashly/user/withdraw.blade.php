@extends('layouts.dasht')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        Çekim talebini tamamla
    </h1>
    @if (session('status'))
        <script type="text/javascript">
            Swal.fire({
                title: 'Hata!',
                text: "{{ session('status') }}",
                icon: 'error',
                confirmButtonText: 'Tamam'
            })
        </script>
        {{ session()->forget('status') }}
    @endif
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-5 row">
                        <div class="col-lg-8 offset-md-2">
                            <div class="mb-3">
                                <h4 class="h2"> <i class="bi bi-cursor"></i> {{ $payment_mode }}</h4>
                            </div>
                            @if ($payment_mode == 'USDT' and $settings->auto_merchant_option == 'Binance' and $settings->withdrawal_option == 'auto')
                                <livewire:user.crypto-withdaw :payment_mode="$payment_mode" />
                            @else
                                <form action="{{ route('completewithdrawal') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="">Çekilecek miktarı
                                            girin({{ $settings->currency }})</label>
                                        <input class="form-control " placeholder="Miktarı Girin" type="number"
                                            name="amount" step="any" required>
                                    </div>
                                    <input value="{{ $payment_mode }}" type="hidden" name="method">

                                    @if (Auth::user()->sendotpemail == 'Yes')
                                        <div class="mb-3">
                                            <label class="m-1 d-inline">OTP Girin</label>
                                            <div class="float-right m-1 btn-group d-inline">
                                                <a class="btn btn-primary btn-sm" href="{{ route('getotp') }}"> <i
                                                        class="fa fa-envelope"></i> OTP Talep Et</a>
                                            </div>
                                            <input class="form-control " placeholder="OTP Girin" type="text"
                                                name="otpcode" required>
                                            <small class="">OTP, talep ettiğinizde
                                                e-postanıza gönderilecektir</small>
                                        </div>
                                    @endif
                                    @if (!$default or $payment_mode == 'BUSD')
                                        @if ($methodtype == 'crypto')
                                            <div class="mb-3">
                                                <h5 class="">{{ $payment_mode }} Adresini Girin </h5>
                                                <input class="form-control " placeholder="{{ $payment_mode }} Adresini Girin"
                                                    type="text" name="details" required>
                                                <small class="">{{ $payment_mode }} hesabınızda varsayılan
                                                    çekim seçeneği değildir, fonlarınızı almak için doğru
                                                    cüzdan adresini girin.</small>
                                            </div>
                                        @else
                                            <div class="mb-3">
                                                <label class="">{{ $payment_mode }} Detaylarını Girin </label>
                                                <textarea class="form-control " row="4" name="details"
                                                    placeholder="Banka Adı: Ad, Hesap Numarası: Numara, Hesap Adı: Ad, Swift Kodu: Kod" required>

                                            </textarea>
                                                <small class="">{{ $payment_mode }} hesabınızda varsayılan
                                                    çekim seçeneği değildir, fonlarınızı almak için virgülle ayrılmış doğru banka
                                                    detaylarını girin.</small> <br />
                                                <span class="text-danger">Banka Adı: Ad, Hesap Numarası: Numara,
                                                    Hesap Adı: Ad, Swift Kodu: Kod</span>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type='submit'>Talebi Tamamla</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
