@php
if (Auth('admin')->User()->dashboard_style == "light") {
    $text = "dark";
	$bg = "light";
} else {
	$bg = 'dark';
    $text = "light";
}
@endphp
@extends('layouts.app')

@section('content')
@include('admin.topmenu')
@include('admin.sidebar')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">{{ __('admin.bots.management') }}</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ __('admin.bots.bot_trading') }}</a>
                </li>
            </ul>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-robot"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">{{ __('admin.bots.total_bots') }}</p>
                                    <h4 class="card-title">{{ $stats['total_bots'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">{{ __('admin.bots.active_bots') }}</p>
                                    <h4 class="card-title">{{ $stats['active_bots'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">{{ __('admin.bots.total_investments') }}</p>
                                    <h4 class="card-title">${{ number_format($stats['total_investments'], 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">{{ __('admin.bots.total_profits') }}</p>
                                    <h4 class="card-title">${{ number_format($stats['total_profits'], 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bots Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">{{ __('admin.bots.trading_bots') }}</h4>
                            <div class="ml-auto">
                                <button id="bulkTradeBtn" class="btn btn-success btn-round mr-2" onclick="generateBulkTrades()">
                                    <i class="fa fa-chart-line"></i> {{ __('admin.bots.generate_20_trades_per_bot') }}
                                </button>
                                <a href="{{ route('admin.bots.create') }}" class="btn btn-primary btn-round">
                                    <i class="fa fa-plus"></i> {{ __('admin.bots.add_new_bot') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="botsTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.bots.bot') }}</th>
                                        <th>{{ __('admin.bots.market') }}</th>
                                        <th>{{ __('admin.bots.investment_range') }}</th>
                                        <th>{{ __('admin.bots.success_rate') }}</th>
                                        <th>{{ __('admin.bots.investors') }}</th>
                                        <th>{{ __('admin.bots.status') }}</th>
                                        <th style="width: 10%">{{ __('admin.bots.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bots as $bot)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm">
                                                    @if($bot->image)
                                                        <img src="{{ asset('storage/' . $bot->image) }}" alt="Bot" class="avatar-img rounded-circle">
                                                    @else
                                                        <div class="avatar-img rounded-circle bg-primary d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-robot text-white"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-3">
                                                    <h6 class="fw-bold mb-1">{{ $bot->name }}</h6>
                                                    <small class="text-muted">{{ Str::limit($bot->description, 50) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst($bot->bot_type) }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                ${{ number_format($bot->min_investment, 0) }} - ${{ number_format($bot->max_investment, 0) }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="progress-bar bg-success" role="progressbar"
                                                 style="width: {{ $bot->success_rate }}%"
                                                 aria-valuenow="{{ $bot->success_rate }}"
                                                 aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                            <small>{{ $bot->success_rate }}%</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $bot->user_investments_count ?? 0 }}</span>
                                        </td>
                                        <td>
                                            @if($bot->status == 'active')
                                                <span class="badge badge-success">{{ __('admin.bots.active') }}</span>
                                            @elseif($bot->status == 'inactive')
                                                <span class="badge badge-secondary">{{ __('admin.bots.inactive') }}</span>
                                            @else
                                                <span class="badge badge-warning">{{ __('admin.bots.maintenance') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('admin.bots.show', $bot) }}"
                                                   class="btn btn-link btn-primary btn-lg"
                                                   data-toggle="tooltip" data-original-title="{{ __('admin.bots.view_details') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.bots.edit', $bot) }}"
                                                   class="btn btn-link btn-primary btn-lg"
                                                   data-toggle="tooltip" data-original-title="{{ __('admin.bots.edit_bot') }}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-link btn-danger btn-lg"
                                                        data-toggle="tooltip" data-original-title="{{ __('admin.bots.delete_bot') }}"
                                                        onclick="confirmDelete({{ $bot->id }})">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                <form id="delete-form-{{ $bot->id }}"
                                                      action="{{ route('admin.bots.destroy', $bot) }}"
                                                      method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px;">
                                                <i class="fas fa-robot fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">{{ __('admin.bots.no_trading_bots_found') }}</h5>
                                                <p class="text-muted">{{ __('admin.bots.create_first_trading_bot') }}</p>
                                                <a href="{{ route('admin.bots.create') }}" class="btn btn-primary">
                                                    <i class="fa fa-plus"></i> {{ __('admin.bots.create_trading_bot') }}
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($bots->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $bots->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@parent


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    $('#botsTable').DataTable({
        "pageLength": 10,
        "searching": true,
        "paging": true,
        "info": true,
        "columnDefs": [
            { "orderable": false, "targets": [6] } // Disable sorting on Actions column
        ]
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});

function confirmDelete(botId) {
    swal({
        title: '{{ __("admin.bots.are_you_sure") }}',
        text: "{{ __('admin.bots.delete_bot_confirmation') }}",
        type: 'warning',
        buttons: {
            confirm: {
                text: '{{ __("admin.bots.yes_delete") }}',
                className: 'btn btn-success'
            },
            cancel: {
                visible: true,
                text: '{{ __("common.cancel") }}',
                className: 'btn btn-danger'
            }
        }
    }).then((Delete) => {
        if (Delete) {
            document.getElementById('delete-form-' + botId).submit();
        }
    });
}

function generateBulkTrades() {
    const btn = document.getElementById('bulkTradeBtn');
    const originalText = btn.innerHTML;

    swal({
        title: '{{ __("admin.bots.generate_bulk_trades") }}?',
        text: "{{ __('admin.bots.bulk_trades_confirmation') }}",
        type: 'info',
        buttons: {
            confirm: {
                text: '{{ __("admin.bots.yes_generate_trades") }}',
                className: 'btn btn-success'
            },
            cancel: {
                visible: true,
                text: '{{ __("common.cancel") }}',
                className: 'btn btn-danger'
            }
        }
    }).then((confirmed) => {
        if (confirmed) {
            // Show loading state
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> {{ __("admin.bots.generating_trades") }}...';
            btn.disabled = true;

            // Make the request
            fetch('/cron/bulk-bot-trades/20', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Reset button
                btn.innerHTML = originalText;
                btn.disabled = false;

                if (data.success) {
                    swal({
                        title: '{{ __("admin.bots.success") }}!',
                        text: `{{ __('admin.bots.generated_trades_success') }}`.replace(':trades', data.total_trades_created).replace(':investments', data.investments_processed),
                        type: 'success',
                        buttons: {
                            confirm: {
                                className: 'btn btn-success'
                            }
                        }
                    }).then(() => {
                        // Optionally reload the page to see updated statistics
                        location.reload();
                    });
                } else {
                    swal({
                        title: '{{ __("admin.bots.error") }}!',
                        text: data.message || '{{ __("admin.bots.failed_to_generate_trades") }}',
                        type: 'error',
                        buttons: {
                            confirm: {
                                className: 'btn btn-danger'
                            }
                        }
                    });
                }
            })
            .catch(error => {
                // Reset button
                btn.innerHTML = originalText;
                btn.disabled = false;

                swal({
                    title: '{{ __("admin.bots.error") }}!',
                    text: '{{ __("admin.bots.network_error") }}',
                    type: 'error',
                    buttons: {
                        confirm: {
                            className: 'btn btn-danger'
                        }
                    }
                });
                console.error('Error:', error);
            });
        }
    });
}
</script>
        </div>
    </div>
</div>
@endsection
