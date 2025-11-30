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
            <h4 class="page-title">{{ __('admin.bots.create_trading_bot') }}</h4>
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
                    <a href="{{ route('admin.bots.index') }}">{{ __('admin.bots.bot_trading') }}</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ __('admin.bots.create_bot') }}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ __('admin.bots.create_new_trading_bot') }}</div>
                    </div>
                    <form action="{{ route('admin.bots.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('admin.bots.bot_name') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}"
                                               placeholder="{{ __('admin.bots.enter_bot_name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bot_type">{{ __('admin.bots.trading_market') }} <span class="text-danger">*</span></label>
                                        <select class="form-control @error('bot_type') is-invalid @enderror"
                                                id="bot_type" name="bot_type" required>
                                            <option value="">{{ __('admin.bots.select_market') }}</option>
                                            @foreach($botTypes as $key => $value)
                                                <option value="{{ $key }}" {{ old('bot_type') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bot_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">{{ __('admin.bots.description') }} <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description" name="description" rows="4"
                                                  placeholder="{{ __('admin.bots.enter_bot_description') }}" required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Investment Settings -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="min_investment">{{ __('admin.bots.minimum_investment_usd') }} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('min_investment') is-invalid @enderror"
                                               id="min_investment" name="min_investment" value="{{ old('min_investment', 100) }}"
                                               step="0.01" min="1" required>
                                        @error('min_investment')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_investment">{{ __('admin.bots.maximum_investment_usd') }} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('max_investment') is-invalid @enderror"
                                               id="max_investment" name="max_investment" value="{{ old('max_investment', 10000) }}"
                                               step="0.01" min="1" required>
                                        @error('max_investment')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Profit Settings -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="daily_profit_min">{{ __('admin.bots.daily_profit_min_percent') }} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('daily_profit_min') is-invalid @enderror"
                                               id="daily_profit_min" name="daily_profit_min" value="{{ old('daily_profit_min', 0.5) }}"
                                               step="0.01" min="0" max="100" required>
                                        @error('daily_profit_min')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="daily_profit_max">{{ __('admin.bots.daily_profit_max_percent') }} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('daily_profit_max') is-invalid @enderror"
                                               id="daily_profit_max" name="daily_profit_max" value="{{ old('daily_profit_max', 3.0) }}"
                                               step="0.01" min="0" max="100" required>
                                        @error('daily_profit_max')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Bot Performance -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="success_rate">{{ __('admin.bots.success_rate_percent') }} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('success_rate') is-invalid @enderror"
                                               id="success_rate" name="success_rate" value="{{ old('success_rate', 85) }}"
                                               min="50" max="99" required>
                                        @error('success_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="duration_days">{{ __('admin.bots.duration_days') }} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('duration_days') is-invalid @enderror"
                                               id="duration_days" name="duration_days" value="{{ old('duration_days', 30) }}"
                                               min="1" max="365" required>
                                        @error('duration_days')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{ __('admin.bots.status') }} <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror"
                                                id="status" name="status" required>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('admin.bots.active') }}</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('admin.bots.inactive') }}</option>
                                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>{{ __('admin.bots.maintenance') }}</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Bot Image -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">{{ __('admin.bots.bot_avatar_optional') }}</label>
                                        <input type="file" class="form-control-file @error('image') is-invalid @enderror"
                                               id="image" name="image" accept="image/*">
                                        <small class="form-text text-muted">{{ __('admin.bots.upload_image_max_2mb') }}</small>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Trading Pairs -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="trading_pairs">{{ __('admin.bots.trading_pairs') }}</label>
                                        <div id="trading-pairs-container">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="trading_pairs[]"
                                                           placeholder="{{ __('admin.bots.trading_pairs_example') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-primary btn-sm" id="add-pair">
                                                        <i class="fa fa-plus"></i> {{ __('admin.bots.add_pair') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">{{ __('admin.bots.add_trading_pairs_description') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> {{ __('admin.bots.create_bot') }}
                            </button>
                            <a href="{{ route('admin.bots.index') }}" class="btn btn-danger">
                                <i class="fa fa-times"></i> {{ __('common.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@parent
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add trading pair functionality
    let pairCount = 1;
    document.getElementById('add-pair').addEventListener('click', function() {
        if (pairCount < 10) { // Limit to 10 pairs
            const container = document.getElementById('trading-pairs-container');
            const newRow = document.createElement('div');
            newRow.className = 'row mt-2';
            newRow.innerHTML = `
                <div class="col-md-8">
                    <input type="text" class="form-control" name="trading_pairs[]" placeholder="{{ __('admin.bots.trading_pairs_example') }}">
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-danger btn-sm remove-pair">
                        <i class="fa fa-trash"></i> {{ __('admin.bots.remove') }}
                    </button>
                </div>
            `;
            container.appendChild(newRow);
            pairCount++;
        }
    });

    // Remove trading pair functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-pair') || e.target.parentElement.classList.contains('remove-pair')) {
            const row = e.target.closest('.row');
            row.remove();
            pairCount--;
        }
    });

    // Validate profit ranges
    document.getElementById('daily_profit_min').addEventListener('change', function() {
        const minVal = parseFloat(this.value);
        const maxInput = document.getElementById('daily_profit_max');
        if (parseFloat(maxInput.value) <= minVal) {
            maxInput.value = (minVal + 0.5).toFixed(2);
        }
    });

    document.getElementById('daily_profit_max').addEventListener('change', function() {
        const maxVal = parseFloat(this.value);
        const minInput = document.getElementById('daily_profit_min');
        if (parseFloat(minInput.value) >= maxVal) {
            minInput.value = (maxVal - 0.5).toFixed(2);
        }
    });

    // Validate investment ranges
    document.getElementById('min_investment').addEventListener('change', function() {
        const minVal = parseFloat(this.value);
        const maxInput = document.getElementById('max_investment');
        if (parseFloat(maxInput.value) <= minVal) {
            maxInput.value = (minVal * 10).toFixed(2);
        }
    });

    document.getElementById('max_investment').addEventListener('change', function() {
        const maxVal = parseFloat(this.value);
        const minInput = document.getElementById('min_investment');
        if (parseFloat(minInput.value) >= maxVal) {
            minInput.value = (maxVal / 10).toFixed(2);
        }
    });
});
</script>
        </div>
    </div>
</div>
@endsection
