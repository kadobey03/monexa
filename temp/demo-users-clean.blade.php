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
                    <h1 class="title1 d-inline text-{{ $text }}">Demo Users Management</h1>
                    <div class="d-inline">
                        <div class="float-right btn-group">
                            <form action="{{ route('admin.demo.bulk-reset') }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to reset ALL demo accounts? This will affect all users.')">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <i class="fa fa-sync-alt"></i> Bulk Reset All
                                </button>
                            </form>
                            <a class="btn btn-primary btn-sm ml-2" href="{{ route('admin.demo.trades') }}">
                                <i class="fa fa-chart-line"></i> Demo Trades
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
                                            Total Demo Users</div>
                                        <div class="h5 mb-0 font-weight-bold text-{{ $text }}">{{ $users->total() }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                            Active Demo Mode</div>
                                        <div class="h5 mb-0 font-weight-bold text-{{ $text }}">
                                            {{ $users->where('demo_mode', true)->count() }}
                                        </div>
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
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Avg Demo Balance</div>
                                        <div class="h5 mb-0 font-weight-bold text-{{ $text }}">
                                            ${{ number_format($users->avg('demo_balance'), 2) }}
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
                                            Total Demo Volume</div>
                                        <div class="h5 mb-0 font-weight-bold text-{{ $text }}">
                                            ${{ number_format($users->sum('demo_balance'), 2) }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-coins fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search Filter -->
                <div class="mb-4 row">
                    <div class="col-12 card shadow p-4">
                        <h6 class="m-0 font-weight-bold text-primary mb-3">Search Demo Users</h6>
                        <form method="GET" class="row">
                            <div class="col-md-9 mb-3">
                                <input type="text" class="form-control" name="search"
                                       value="{{ request('search') }}" placeholder="Search by name, email, or username">
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="submit" class="btn btn-primary me-2">Search</button>
                                <a href="{{ route('admin.demo.users') }}" class="btn btn-secondary ml-2">Clear</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Demo Users Table -->
                <div class="mb-5 row">
                    <div class="col-12 card shadow p-4">
                        <div class="table-responsive" data-example-id="hoverable-table">
                            <table id="ShipTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Demo Balance</th>
                                        <th>Demo Mode</th>
                                        <th>Account Balance</th>
                                        <th>Registration Date</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name ?? 'N/A' }}</td>
                                        <td>{{ $user->email ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge {{ $user->demo_balance > 0 ? 'badge-success' : 'badge-secondary' }}">
                                                ${{ number_format($user->demo_balance, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->demo_mode)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>${{ number_format($user->account_bal, 2) }}</td>
                                        <td>{{ $user->created_at->toDayDateTimeString() }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm m-1"
                                                    data-toggle="modal" data-target="#updateBalanceModal"
                                                    data-user-id="{{ $user->id }}"
                                                    data-user-name="{{ $user->name }}"
                                                    data-demo-balance="{{ $user->demo_balance }}"
                                                    title="Edit Demo Balance">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>

                                            <form action="{{ route('admin.demo.reset-user', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm m-1"
                                                        onclick="return confirm('Are you sure you want to reset this user demo account?')"
                                                        title="Reset Demo Account">
                                                    <i class="fa fa-sync-alt"></i> Reset
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                                                <h5 class="text-gray-500">No users found</h5>
                                                <p class="text-muted">No users match your current search criteria.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($users->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $users->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Balance Modal -->
    <div class="modal fade" id="updateBalanceModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Demo Balance</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="updateBalanceForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label><strong>User Name:</strong></label>
                            <input type="text" id="user-name-display" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label><strong>Current Demo Balance:</strong></label>
                            <input type="text" id="current-balance-display" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label for="action"><strong>Action</strong></label>
                            <select name="action" id="action" class="form-control" required>
                                <option value="set">Set Balance To</option>
                                <option value="add">Add Amount</option>
                                <option value="subtract">Subtract Amount</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="demo_balance"><strong>Amount</strong></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" step="0.01" class="form-control"
                                       name="demo_balance" id="demo_balance"
                                       value="100000" min="0" max="10000000" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Balance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#updateBalanceModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var userId = button.data('user-id');
                var userName = button.data('user-name');
                var demoBalance = button.data('demo-balance');

                var modal = $(this);
                modal.find('#user-name-display').val(userName);
                modal.find('#current-balance-display').val('$' + parseFloat(demoBalance).toFixed(2));
                modal.find('#updateBalanceForm').attr('action', '/admin/demo/users/' + userId + '/balance');
            });
        });
    </script>
@endsection
