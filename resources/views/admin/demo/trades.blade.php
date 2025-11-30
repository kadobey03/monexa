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
        <div class="content">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 d-inline text-{{ $text }}">{{ __('admin.demo.trades_management') }}</h1>
                    <div class="d-inline">
                        <div class="float-right btn-group">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.demo.users') }}">
                                <i class="fa fa-users"></i> {{ __('admin.demo.manage_users') }}
                            </a>
                        </div>
                    </div>
                </div>
                <x-danger-alert />
                <x-success-alert />

                <!-- Statistics Cards -->
                <div class="mb-4 row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            {{ __('admin.demo.total_demo_trades') }}</div>
                                        <div class="h5 mb-0 font-weight-bold text-{{ $text }}">{{ $stats['total_trades'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            {{ __('admin.demo.active_trades') }}</div>
                                        <div class="h5 mb-0 font-weight-bold text-{{ $text }}">{{ $stats['active_trades'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-play-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            {{ __('admin.demo.total_volume') }}</div>
                                        <div class="h5 mb-0 font-weight-bold text-{{ $text }}">
                                            ${{ number_format($stats['total_volume'], 2) }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            {{ __('admin.demo.profitable_trades') }}</div>
                                        <div class="h5 mb-0 font-weight-bold text-{{ $text }}">{{ $stats['profitable_trades'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-trophy fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="mb-4 row">
                    <div class="col-12 card shadow p-4">
                        <h6 class="m-0 font-weight-bold text-primary mb-3">{{ __('admin.demo.filter_trades') }}</h6>
                        <form method="GET" class="row">
                            <div class="col-md-3 mb-3">
                                <label for="search" class="form-label">{{ __('admin.demo.search') }}</label>
                                <input type="text" class="form-control" id="search" name="search"
                                       value="{{ request('search') }}" placeholder="{{ __('admin.demo.search_placeholder') }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="status" class="form-label">{{ __('admin.demo.status') }}</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">{{ __('admin.demo.all_status') }}</option>
                                    <option value="yes" {{ request('status') == 'yes' ? 'selected' : '' }}>{{ __('admin.demo.active') }}</option>
                                    <option value="no" {{ request('status') == 'no' ? 'selected' : '' }}>{{ __('admin.demo.closed') }}</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="type" class="form-label">{{ __('admin.demo.type') }}</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="">{{ __('admin.demo.all_types') }}</option>
                                    <option value="buy" {{ request('type') == 'buy' ? 'selected' : '' }}>{{ __('admin.demo.buy') }}</option>
                                    <option value="sell" {{ request('type') == 'sell' ? 'selected' : '' }}>{{ __('admin.demo.sell') }}</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="asset" class="form-label">{{ __('admin.demo.asset') }}</label>
                                <input type="text" class="form-control" id="asset" name="asset"
                                       value="{{ request('asset') }}" placeholder="BTC, ETH, etc.">
                            </div>
                            <div class="col-md-3 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">{{ __('admin.demo.filter') }}</button>
                                <a href="{{ route('admin.demo.trades') }}" class="btn btn-secondary ml-2">{{ __('admin.demo.clear') }}</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Demo Trades Table -->
                <div class="mb-5 row">
                    <div class="col-12 card shadow p-4">
                        <div class="table-responsive" data-example-id="hoverable-table">
                            <table id="ShipTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.demo.trade_id') }}</th>
                                        <th>{{ __('admin.demo.user_name') }}</th>
                                        <th>{{ __('admin.demo.user_email') }}</th>
                                        <th>{{ __('admin.demo.asset') }}</th>
                                        <th>{{ __('admin.demo.type') }}</th>
                                        <th>{{ __('admin.demo.amount') }}</th>
                                        <th>{{ __('admin.demo.leverage') }}</th>
                                        <th>{{ __('admin.demo.entry_price') }}</th>
                                        <th>{{ __('admin.demo.current_pnl') }}</th>
                                        <th>{{ __('admin.demo.status') }}</th>
                                        <th>{{ __('admin.demo.date_created') }}</th>
                                        <th>{{ __('admin.demo.option') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($demoTrades as $trade)
                                    <tr>
                                        <td>{{ $trade->id }}</td>
                                        <td>{{ $trade->user ? $trade->user->name : __('admin.demo.user_not_found') }}</td>
                                        <td>{{ $trade->user ? $trade->user->email : __('admin.demo.not_specified') }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $trade->assets }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $trade->type == 'buy' ? 'badge-success' : 'badge-danger' }}">
                                                {{ strtoupper($trade->type) }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($trade->amount, 2) }}</td>
                                        <td>{{ $trade->leverage }}x</td>
                                        <td>${{ number_format($trade->entry_price, 2) }}</td>
                                        <td>
                                            @php
                                                $pnl = $trade->calculatePnL();
                                            @endphp
                                            <span class="badge {{ $pnl >= 0 ? 'badge-success' : 'badge-danger' }}">
                                                ${{ number_format($pnl, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($trade->active == 'yes')
                                                <span class="badge badge-success">{{ __('admin.demo.active') }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ __('admin.demo.closed') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $trade->created_at->toDayDateTimeString() }}</td>
                                        <td>
                                            @if($trade->active == 'yes')
                                                <form action="{{ route('admin.demo.close-trade', $trade->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm m-1"
                                                            onclick="return confirm('{{ __('admin.demo.confirm_close_trade') }}')"
                                                            title="{{ __('admin.demo.close_trade_tooltip') }}">
                                                        <i class="fa fa-stop-circle"></i> {{ __('admin.demo.close') }}
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.demo.users') }}?search={{ $trade->user ? $trade->user->email : '' }}"
                                               class="btn btn-info btn-sm m-1" title="{{ __('admin.demo.view_user_tooltip') }}">
                                                <i class="fa fa-user"></i> {{ __('admin.demo.view_user') }}
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-chart-line fa-3x text-gray-300 mb-3"></i>
                                                <h5 class="text-gray-500">{{ __('admin.demo.no_trades_found') }}</h5>
                                                <p class="text-muted">{{ __('admin.demo.no_trading_activity') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-refresh page every 30 seconds for real-time data
            setInterval(function() {
                if (!document.querySelector('.dropdown.show')) {
                    window.location.reload();
                }
            }, 30000);
        });
    </script>
@endsection
