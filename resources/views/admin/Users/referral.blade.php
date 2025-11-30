@php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
} else {
    $text = 'light';
}
@endphp
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel ">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1  d-inline">{{ __('admin.referrals.add_to_list', ['name' => $user->name]) }}</h1>
                    <div class="d-inline">
                        <div class="float-right btn-group">
                            <a class="btn btn-primary btn-sm" href="{{ route('viewuser', $user->id) }}"> <i
                                    class="fa fa-arrow-left"></i> {{ __('admin.actions.back') }}</a>
                        </div>
                    </div>
                </div>
                <x-danger-alert />
                <x-success-alert />
                <div class="mb-5 row">
                    <div class="col-lg-8 offset-lg-2 card p-3  shadow">
                        <form method="POST" action="{{ route('addref') }}">
                            @csrf
                            <div class="form-group">
                                <h4 class="">{{ __('admin.forms.select_user') }}</h4>
                                <select class="form-control   select2" name="ref_id">
                                    @foreach ($ref as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <small class="">{{ __('admin.referrals.referred_by_description', ['name' => $user->name]) }}</small>
                            </div>
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="px-3 btn btn-primary">
                                        {{ __('admin.actions.save_referral') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('.select2').select2();
        </script>
    @endsection
