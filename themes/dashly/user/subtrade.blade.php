@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <h1 class="h2">
        Yönetilen Hesaplar
    </h1>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-lg-8">
            <!-- Card -->
            <div class="card border-0">
                <div class="card-header border-0">
                    <!-- Title -->
                    <h2 class="h3 mb-0">
                        Gelişmiş {{ $settings->site_name }} Hesap yöneticisi
                    </h2>
                </div>

                <div class="card-body">
                    <h4 class="mb-3">Açıklama</h4>

                    <p class="mb-3">
                        Ticaret yapmak veya ticaret öğrenmek için zamanınız yok mu?</p>
                    <p>
                        Hesap Yönetim Hizmetimiz sizin için En İyi Kârlı Ticaret Seçeneğidir,
                        mali piyasada hesabınızı basit bir abonelik modeli ile yönetmenize yardımcı olabiliriz.
                    </p>
                    <small>
                        Şartlar ve Koşullar geçerlidir</small><br>{{ $settings->contact_email }} adresinden bize ulaşın
                    daha fazla bilgi için.

                    <h4 class="my-3">Kontrol Listesi</h4>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist1" checked
                                    disabled>
                                <label class="form-check-label" for="checklist1">
                                    Sizin adınıza ticaret yapın
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist2" checked
                                    disabled>
                                <label class="form-check-label" for="checklist2">
                                    Hesabınızı yönetin
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" disabled
                                    checked>
                                <label class="form-check-label" for="checklist3">
                                    Karınızı kendiniz çekin
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" disabled
                                    checked>
                                <label class="form-check-label" for="checklist3">
                                    7/24 Destek
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" disabled
                                    checked>
                                <label class="form-check-label" for="checklist3">
                                    100% Şeffaflık
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" disabled
                                    checked>
                                <label class="form-check-label" for="checklist3">
                                    100% Kontrol Sizde
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checklist3" disabled
                                    checked>
                                <label class="form-check-label" for="checklist3">
                                    100% Güvenli ve Güvenli
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="mb-5">Yönetim altındaki hesaplar.</h4>
                    @if ($subscriptions->count() === 0)
                        <div class="text-center">
                            <i class="bi bi-database-fill-exclamation" style="font-size: 50px"></i>
                            <h2 class="h3">Yönetilen hesabınız yok</h2>
                            <a class="btn btn-primary" data-toggle="modal" data-target="#submitmt4modal">
                                Hesap Ekle
                            </a>
                        </div>
                    @else
                        <div class=" table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th>Hesap</th>
                                    <th>Para Birimi</th>
                                    <th>Kaldıraç</th>
                                    <th>Sunucu</th>
                                    <th>Süre</th>
                                    <th>Hesap Şifresi</th>
                                    <th>Durum</th>
                                    <th>Gönderildi</th>
                                    <th>Başlangıç/Bitiş tarihi</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $sub)
                                        <tr>
                                            <td>
                                                {{ $sub->mt4_id }} <br> {{ $sub->account_type }}
                                            </td>
                                            <td>
                                                {{ $sub->currency }}
                                            </td>
                                            <td>
                                                {{ $sub->leverage }}
                                            </td>
                                            <td>
                                                {{ $sub->server }}
                                            </td>
                                            <td>
                                                {{ $sub->duration }}
                                            </td>
                                            <td>
                                                **********
                                            </td>
                                            <td>
                                                <span class="badge bg-info"> {{ $sub->status }}</span>
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($sub->created_at)->format('M d Y') }}
                                            </td>
                                            <td>
                                                @if (!empty($sub->start_date))
                                                    {{ \Carbon\Carbon::parse($sub->start_date)->format('M d Y') }}
                                                @else
                                                    -
                                                @endif
                                                /
                                                @if (!empty($sub->end_date))
                                                    {{ \Carbon\Carbon::parse($sub->end_date)->format('M d Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $endAt = \Carbon\Carbon::parse($sub->end_date);
                                                    $remindAt = \Carbon\Carbon::parse($sub->reminded_at);
                                                @endphp
                                                <a href="#" data-bs-toggle="modal" class="btn btn-danger btn-sm"
                                                    onclick="deletemt4()">İptal</a>
                                                @if (($sub->status != 'Pending' && now()->isSameDay($remindAt)) || $sub->status == 'Expired')
                                                    <a href="{{ route('renewsub', $sub->id) }}"
                                                        class="btn btn-primary btn-sm">Yenile</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <livewire:user.add-new-account />
        </div>
    </div> <!-- / .row -->
@endsection
@push('scripts')
    <script type="text/javascript">
        function deletemt4() {
            Swal.fire({
                title: 'Hata!',
                text: 'Hesabınızın iptal edilmesi için {{ $settings->contact_email }} adresine bir E-posta gönderin.',
                icon: 'error',
                confirmButtonText: 'Tamam'
            });
        }
    </script>
@endpush
