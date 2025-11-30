<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
} else {
    $text = 'light';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content  ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1  d-inline">{{ __('admin.activities.login_activities_for', ['name' => $user->name]) }}</h1>
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
                    @if (count($activities) > 0)
                        <div class="mb-4 col-md-12">
                            <a class="btn btn-danger btn-sm" href="{{ route('clearactivity', $user->id) }}"> <i
                                    class="fa fa-trash"></i> {{ __('admin.actions.clear_data') }}</a>
                        </div>
                    @endif
                    <div class="col-md-12 card shadow p-4 ">
                        <div class="table-responsive" data-example-id="hoverable-table">
                            <table id="ShipTable" class="table table-hover ">
                                <thead>
                                    <tr>
                                        {{-- <th>Client name</th> --}}
                                        <th>{{ __('admin.activities.ip_address') }}</th>
                                        <th>{{ __('admin.activities.device_os_browser') }}</th>
                                        <th>{{ __('admin.activities.login_datetime') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activities as $activity)
                                        <tr>
                                            {{-- <th>{{$deposit->id}}</th> --}}
                                            <td>{{ $activity->ip_address }}</td>
                                            <td>{{ $activity->device }}/{{ $activity->os }}/{{ $activity->browser }}</td>
                                            <td>{{ \Carbon\Carbon::parse($activity->created_at)->toDayDateTimeString() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
