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
    <div class="main-panel">
        <div class="content bg-{{ $bg }}">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 text-{{ $text }}">{{ __('admin.copy.active_trade_copying') }}</h1>
                </div>
                <x-danger-alert />
                <x-success-alert />
                <div class="col-12 card shadow p-4 bg-{{ Auth('admin')->User()->dashboard_style }}">
                    <div class="table-responsive" data-example-id="hoverable-table">
                        <table id="ShipTable" class="table table-hover text-{{ $text }}">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.copy.expert_name') }}</th>
                                    <th>{{ __('admin.copy.expert_tag') }}</th>
                                    <th>{{ __('admin.copy.amount') }}</th>
                                    <th>{{ __('admin.copy.user') }}</th>
                                    <th>{{ __('admin.copy.date_created') }}</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($copytrades as $copytrade)
                                    <tr>
                                        <td>{{ $copytrade->name ?? __('admin.copy.na') }}</td>
                                        <td>{{ $copytrade->tag ?? __('admin.copy.na') }}</td>
                                        <td>{{ $settings->currency }}{{ number_format($copytrade->price) }}</td>
                                        <td>{{ $copytrade->cuser->name ?? __('admin.copy.na') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($copytrade->created_at)->toDayDateTimeString() }}</td>
                                        {{-- <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-danger" href="{{route('deleteplan', $copytrade->id)}}">Delete</a>
                                                    <a class="dropdown-item" href="{{ route('user.plans', $copytrade->cuser->id) }}">More actions</a>
                                                </div>
                                            </div>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
