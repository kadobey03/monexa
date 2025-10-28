@extends('layouts.dasht')
@section('title', $title)
@section('content')
    <!-- Title -->
    <div class="mb-5">
        <h1 class="h2 m-0">
            Hesabınızdan çekin.
        </h1>
        <p class="m-0">Aşağıdaki ödeme yöntemlerinden herhangi birini kullanarak çekim talebi yerleştirin.</p>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row mb-6">
        @forelse ($wmethods as $method)
            <div class="col-xl-4">
                <!-- Card -->
                <div class="card border-0 py-6 px-4 mb-6 mb-xl-3">
                    <div class="card-body">
                        <h2 class="card-title h4 text-uppercase text-secondary text-center mb-3">{{ $method->name }}</h2>
                        <h3 class="card-text display-3 text-center">
                            {{ $settings->currency }}{{ number_format($method->maximum) }} <span
                                class="fs-3 fw-normal text-secondary">Maks</span>
                        </h3>

                        <!-- Divider -->
                        <hr>

                        <ul class="list-unstyled mb-7">
                            <li class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="12" width="12"
                                    class="me-2 text-primary">
                                    <path
                                        d="M23.37.29a1.49,1.49,0,0,0-2.09.34L7.25,20.2,2.56,15.51A1.5,1.5,0,0,0,.44,17.63l5.93,5.94a1.53,1.53,0,0,0,2.28-.19l15.07-21A1.49,1.49,0,0,0,23.37.29Z"
                                        style="fill: currentColor" />
                                </svg>
                                Minimum miktar: {{ $settings->currency }}{{ number_format($method->minimum) }}
                            </li>
                            <li class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="12" width="12"
                                    class="me-2 text-primary">
                                    <path
                                        d="M23.37.29a1.49,1.49,0,0,0-2.09.34L7.25,20.2,2.56,15.51A1.5,1.5,0,0,0,.44,17.63l5.93,5.94a1.53,1.53,0,0,0,2.28-.19l15.07-21A1.49,1.49,0,0,0,23.37.29Z"
                                        style="fill: currentColor" />
                                </svg>
                                Ücret Türü: {{ $method->charges_type }}
                            </li>
                            <li class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="12" width="12"
                                    class="me-2 text-primary">
                                    <path
                                        d="M23.37.29a1.49,1.49,0,0,0-2.09.34L7.25,20.2,2.56,15.51A1.5,1.5,0,0,0,.44,17.63l5.93,5.94a1.53,1.53,0,0,0,2.28-.19l15.07-21A1.49,1.49,0,0,0,23.37.29Z"
                                        style="fill: currentColor" />
                                </svg>
                                Ücret Miktarı:
                                @if ($method->charges_type == 'percentage')
                                    {{ $method->charges_amount }}%
                                @else
                                    {{ $settings->currency }}{{ $method->charges_amount }}
                                @endif
                            </li>
                            <li class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="12" width="12"
                                    class="me-2 text-primary">
                                    <path
                                        d="M23.37.29a1.49,1.49,0,0,0-2.09.34L7.25,20.2,2.56,15.51A1.5,1.5,0,0,0,.44,17.63l5.93,5.94a1.53,1.53,0,0,0,2.28-.19l15.07-21A1.49,1.49,0,0,0,23.37.29Z"
                                        style="fill: currentColor" />
                                </svg>
                                Süre: {{ $method->duration }}
                            </li>
                        </ul>
                        @if ($settings->enable_with == 'false')
                            <button class="btn btn-lg btn-primary w-100" data-bs-toggle="modal"
                                data-bs-target="#withdrawdisabled" type="button">Bu yöntemi seç</button>
                        @else
                            <form action='{{ route('withdrawamount') }}' method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" value="{{ $method->name }}" name="method">
                                    <button class="btn btn-lg btn-primary w-100" type='submit'>
                                        Bu yöntemi seç
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <h3>Çekim yöntemi etkinleştirilmemiş.</h3>
            </div>
        @endforelse

        <div id="withdrawdisabled" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalCenterTitle">Çekim devre dışı</h3>
                    </div>
                    <div class="modal-footer m-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
