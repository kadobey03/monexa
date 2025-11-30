<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
} else {
    $text = 'light';
}
?>
@extends('layouts.admin', ['title' => __('admin.investments.user_investments')])
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1  d-inline">{{ __('admin.investments.user_plans_for', ['name' => $user->name]) }}</h1>
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
                    <div class="col card p-3 shadow ">
                        <div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table">
                            <span style="margin:3px;">
                                <table id="ShipTable" class="table table-hover ">
                                    <thead>
                                        <tr>
                                            {{-- <th>Client name</th> --}}
                                            <th>{{ __('admin.investments.plan') }}</th>
                                            <th>{{ __('admin.investments.amount') }}</th>
                                            <th>{{ __('admin.investments.active') }}</th>
                                            <th>{{ __('admin.investments.duration') }}</th>
                                            <th>{{ __('admin.investments.created_on') }}</th>
                                            <th>{{ __('admin.investments.expire_at') }}</th>
                                            <th>{{ __('admin.actions.option') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($plans as $plan)
                                            <tr>
                                                {{-- <td>{{$plan->duser->name}}</td> --}}
                                                <td>{{ $plan->uplan->name }}</td>
                                                <td>{{ $user->currency }}{{ number_format($plan->amount) }}</td>
                                                <td>
                                                    @if ($plan->active == 'yes')
                                                        <span class="badge badge-success">{{ __('admin.status.active') }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ __('admin.status.inactive') }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $plan->inv_duration }}</td>
                                                <td>{{ \Carbon\Carbon::parse($plan->created_at)->toDayDateTimeString() }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($plan->expire_date)->toDayDateTimeString() }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('deleteplan', $plan->id) }}"
                                                        class="m-1 btn btn-info btn-sm">{{ __('admin.actions.delete_plan') }}</a>
                                                    @if ($plan->active == 'yes')
                                                        <a href="{{ route('markas', ['id' => $plan->id, 'status' => 'expired']) }}"
                                                            class="m-1 btn btn-danger btn-sm">{{ __('admin.actions.mark_as_expired') }}</a>
                                                    @else
                                                        <a href="{{ route('markas', ['id' => $plan->id, 'status' => 'yes']) }}"
                                                            class="m-1 btn btn-success btn-sm">{{ __('admin.actions.mark_as_active') }}</a>
                                                    @endif
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
