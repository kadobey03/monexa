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
                    <h1 class="title1 d-inline text-{{ $text }}">Demo Trades Management</h1>
                    <div class="d-inline">
                        <div class="float-right btn-group">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.demo.users') }}">
                                <i class="fa fa-users"></i> Manage Demo Users
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
                                            Total Demo Trades</div>
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
                                            Active Trades</div>
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
                                            Total Volume</div>
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
                                            Profitable Trades</div>
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
                        <h6 class="m-0 font-weight-bold text-primary mb-3">Filter Demo Trades</h6>
                        <form method="GET" class="row">
                            <div class="col-md-3 mb-3">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" class="form-control" id="search" name="search"
                                       value="{{ request('search') }}" placeholder="User name, email, or asset">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">All Status</option>
                                    <option value="yes" {{ request('status') == 'yes' ? 'selected' : '' }}>Active</option>
                                    <option value="no" {{ request('status') == 'no' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="">All Types</option>
                                    <option value="buy" {{ request('type') == 'buy' ? 'selected' : '' }}>Buy</option>
                                    <option value="sell" {{ request('type') == 'sell' ? 'selected' : '' }}>Sell</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="asset" class="form-label">Asset</label>
                                <input type="text" class="form-control" id="asset" name="asset"
                                       value="{{ request('asset') }}" placeholder="BTC, ETH, etc.">
                            </div>
                            <div class="col-md-3 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">Filter</button>
                                <a href="{{ route('admin.demo.trades') }}" class="btn btn-secondary ml-2">Clear</a>
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
                                        <th>Trade ID</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Asset</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Leverage</th>
                                        <th>Entry Price</th>
                                        <th>Current P&L</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($demoTrades as $trade)
                                    <tr>
                                        <td>{{ $trade->id }}</td>
                                        <td>{{ $trade->user->name ?? 'N/A' }}</td>
                                        <td>{{ $trade->user->email ?? 'N/A' }}</td>
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
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Closed</span>
                                            @endif
                                        </td>
                                        <td>{{ $trade->created_at->toDayDateTimeString() }}</td>
                                        <td>
                                            @if($trade->active == 'yes')
                                                <form action="{{ route('admin.demo.close-trade', $trade->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm m-1"
                                                            onclick="return confirm('Are you sure you want to close this demo trade?')"
                                                            title="Close Trade">
                                                        <i class="fa fa-stop-circle"></i> Close
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.demo.users') }}?search={{ $trade->user->email ?? '' }}"
                                               class="btn btn-info btn-sm m-1" title="View User">
                                                <i class="fa fa-user"></i> View User
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-chart-line fa-3x text-gray-300 mb-3"></i>
                                                <h5 class="text-gray-500">No demo trades found</h5>
                                                <p class="text-muted">No demo trading activity matches your current filters.</p>
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
