<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel ">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 ">{{ __('admin.settings.crypto.assets_exchange_settings') }}</h1>
                </div>
                <x-danger-alert />
                <x-success-alert />
                <div class="mb-5 row">
                    <div class="col-md-12">
                        <div class="card p-3 p-md-5 shadow-lg ">
                            <div class="row">
                                <div class="form-group col-12 d-inline">
                                    <h5 class="">{{ __('admin.settings.crypto.use_feature') }}</h5>
                                    <div class="selectgroup">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="crypto" id="cryptoyes" value="true"
                                                class="selectgroup-input" checked="">
                                            <span class="selectgroup-button">{{ __('admin.settings.common.on') }}</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="crypto" id="cryptono" value="false"
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">{{ __('admin.settings.common.off') }}</span>
                                        </label>
                                    </div>
                                    <div>
                                        <small class="">{{ __('admin.settings.crypto.service_disabled_notice') }}</small>
                                    </div>
                                    @if ($moresettings->use_crypto_feature == 'true')
                                        <script>
                                            document.getElementById("cryptoyes").checked = true;
                                        </script>
                                    @else
                                        <script>
                                            document.getElementById("cryptono").checked = true;
                                        </script>
                                    @endif
                                </div>
                                <div class="col-md-6 offset-md-3">

                                    <form action="{{ route('exchangefee') }}" method="post">
                                        @csrf
                                        <div class=" form-group">
                                            <h5 class="">{{ __('admin.settings.crypto.exchange_fee') }}</h5>
                                            <input type="text" name="fee" value="{{ $moresettings->fee }}"
                                                class=" form-control " id="">
                                        </div>
                                        @if ($settings->currency != '$')
                                            <div class=" form-group">
                                                <h5 class="">{{ $settings->s_currency }}/{{ __('admin.settings.crypto.usd_rate') }}</h5>
                                                <input type="number" name="rate"
                                                    value="{{ $moresettings->currency_rate }}" step=".0"
                                                    class=" form-control " placeholder="450">
                                                <small class="">{{ __('admin.settings.crypto.rate_description') }}</small>
                                            </div>
                                        @endif

                                        <div class=" form-group">
                                            <button type="submit" class="btn btn-primary">{{ __('admin.settings.common.save_button') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="mt-3 col-12">
                                    <div class=" table-responsive">
                                        <table class="table table-hover ">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ __('admin.settings.crypto.asset_name') }}</th>
                                                    <th scope="col">{{ __('admin.settings.crypto.asset_symbol') }}</th>
                                                    <th scope="col">{{ __('admin.settings.common.status') }}</th>
                                                    <th scope="col">{{ __('admin.settings.common.option') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @include('admin.Settings.Crypto.assets')
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <small class="">{{ __('admin.settings.crypto.disable_warning') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#cryptoyes').on('click', function() {
                // let truevalue = $('#cryptoyes').val()
                let uurl = "{{ url('admin/dashboard/useexchange') }}" + '/' + 'true';
                $.ajax({
                    url: uurl,
                    type: 'GET',

                    success: function(response) {
                        if (response.status === 200) {
                            $.notify({
                                // options
                                icon: 'flaticon-alarm-1',
                                title: '{{ __('admin.settings.common.success') }}',
                                message: response.success,
                            }, {
                                // settings
                                type: 'success',
                                allow_dismiss: true,
                                newest_on_top: false,
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                offset: 20,
                                spacing: 10,
                                z_index: 1031,
                                delay: 5000,
                                timer: 1000,
                                animate: {
                                    enter: 'animated fadeInDown',
                                    exit: 'animated fadeOutUp'
                                },

                            });
                        } else {

                        }
                    },
                    error: function(error) {
                        console.log(error);
                    },
                });
            });

            $('#cryptono').on('click', function() {
                // let truevalue = $('#cryptoyes').val()
                let uurl = "{{ url('admin/dashboard/useexchange') }}" + '/' + 'false';
                $.ajax({
                    url: uurl,
                    type: 'GET',

                    success: function(response) {
                        if (response.status === 200) {
                            $.notify({
                                // options
                                icon: 'flaticon-alarm-1',
                                title: '{{ __('admin.settings.common.success') }}',
                                message: response.success,
                            }, {
                                // settings
                                type: 'success',
                                allow_dismiss: true,
                                newest_on_top: false,
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                offset: 20,
                                spacing: 10,
                                z_index: 1031,
                                delay: 5000,
                                timer: 1000,
                                animate: {
                                    enter: 'animated fadeInDown',
                                    exit: 'animated fadeOutUp'
                                },

                            });
                        } else {

                        }
                    },
                    error: function(error) {
                        console.log(error);
                    },
                });
            });
        </script>
    @endsection
