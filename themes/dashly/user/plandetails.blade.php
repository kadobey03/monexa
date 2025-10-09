@extends('layouts.dashly')
@section('title', $title)
@section('content')
    <!-- Title -->
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h2">
            {{ $plan->dplan->name }} Planı
        </h1>
        <div>
            <a href="{{ route('myplans', 'All') }}" class="fs-1">
                <i class="bi bi-arrow-left-circle-fill"></i>
            </a>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2>
                        {{ $plan->dplan->increment_type == 'Fixed' ? $settings->currency : '' }}{{ $plan->dplan->increment_amount }}{{ $plan->dplan->increment_type == 'Percentage' ? '%' : '' }}
                        {{ $plan->dplan->increment_interval }}
                        süreyle {{ $plan->dplan->expiration }}
                    </h2>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if ($plan->active == 'yes')
                                <span class="badge bg-success">Aktif</span>
                            @elseif($plan->active == 'expired')
                                <span class="badge bg-danger">Süresi Doldu</span>
                            @else
                                <span class="badge bg-danger">Aktif Değil</span>
                            @endif
                        </div>
                        @if ($settings->should_cancel_plan)
                            @if ($plan->active == 'yes')
                                <a href="#" class="px-3 btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"> <i class=" fas fa-times"></i> Bu Planı İptal Et</a>

                                <!-- cancel plan modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true" x-data="{ disabled: false }">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header pb-0">
                                                <h3 class="modal-title">Planı iptal et</h3>
                                                <!-- Button -->
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $plan->dplan->name }} planınızı iptal etmek istediğinizden emin misiniz?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Kapat</button>

                                                <a href="{{ route('cancelplan', $plan->id) }}" type="button"
                                                    class="btn btn-danger" :class="{ 'd-none': disabled }"
                                                    x-on:click="disabled = true">İptal</a>

                                                <button class="btn btn-danger" :class="disabled ? 'd-block' : 'd-none'"
                                                    disabled>
                                                    İptal
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                    <hr>
                    <div class="mt-5">
                        <h4 class="mb-3">Plan bilgileri</h4>
                        <div class="mb-5 row">
                            <div class="col-12">
                                <div class="d-flex justify-content-around">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h2 class="m-0">
                                                {{ $settings->currency }}{{ number_format($plan->amount, 2, '.', ',') }} +
                                                &nbsp;
                                            </h2>
                                            <small>Yatırılan</small>
                                        </div>
                                        <div>
                                            <h2 class="m-0 text-success">
                                                {{ $settings->currency }}{{ number_format($plan->profit_earned, 2, '.', ',') }}
                                            </h2>
                                            <small>Kazanılan</small>
                                        </div>
                                    </div>
                                    <div>
                                        <h2 class="m-0 text-success">
                                            @if ($settings->return_capital)
                                                {{ $settings->currency }}{{ number_format($plan->amount + $plan->profit_earned, 2, '.', ',') }}
                                            @else
                                                {{ $settings->currency }}{{ number_format($plan->profit_earned, 2, '.', ',') }}
                                            @endif
                                        </h2>
                                        <small>Toplam Getiri</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-md-3">
                                <p>Süre: <br><strong>{{ $plan->dplan->expiration }}</strong> </p>
                            </div>
                            <div class="col-md-3">
                                <p>Başlangıç Tarihi: <br>
                                    <strong>{{ $plan->created_at->addHour()->toDayDateTimeString() }}</strong>
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p>Bitiş Tarihi:
                                    <br><strong>{{ \Carbon\Carbon::parse($plan->expire_date)->addHour()->toDayDateTimeString() }}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 row border-bottom">
                            <div class="col-md-3">
                                <p>Minimum Getiri: <br><strong>{{ $plan->dplan->minr }}%</strong> </p>
                            </div>
                            <div class="col-md-3">
                                <p>Maksimum Getiri: <br> <strong>{{ $plan->dplan->maxr }}%</strong> </p>
                            </div>
                            <div class="col-md-3">
                                <p>ROI Aralığı:
                                    <br><strong>{{ $plan->dplan->increment_interval }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 ">
                        <h4>
                            İşlemler
                        </h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Tür</th>
                                        <th>Tarih</th>
                                        <th>Miktar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $history)
                                        <tr>
                                            <td>Kar</td>
                                            <td>{{ $history->created_at->addHour()->toDayDateTimeString() }}</td>
                                            <td>{{ $settings->currency }}{{ number_format($history->amount, 2, '.', ',') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <i class="bi bi-database-fill-exclamation" style="font-size: 50px"></i>
                                                <h2 class="h3">Henüz işlem kaydı yok</h2>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
