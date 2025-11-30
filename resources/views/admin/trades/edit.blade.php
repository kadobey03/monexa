@extends('layouts.admin')

@section('content')

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between bg-gradient-to-r from-blue-600 via-indigo-700 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                <x-heroicon name="pencil-square" class="w-8 h-8 text-white" />
            </div>
            <div>
                <h1 class="text-3xl font-bold mb-1">{{ __('admin.trading.edit_trade') }} #{{ $trade->id }}</h1>
                <p class="text-blue-100 text-lg">{{ __('admin.trading.update_trade_information') }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <div class="hidden md:flex items-center space-x-2 text-white/80">
                <x-heroicon name="home" class="w-4 h-4" />
                <span>{{ __('admin.navigation.dashboard') }}</span>
                <x-heroicon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.trades.index') }}" class="hover:text-white transition-colors">{{ __('admin.trading.trades') }}</a>
                <x-heroicon name="chevron-right" class="w-4 h-4" />
                <span class="text-white font-semibold">{{ __('common.edit') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<x-success-alert />
<x-danger-alert />

<!-- Validation Errors -->
@if ($errors->any())
    <div class="mb-8 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-2xl p-6 shadow-lg">
        <div class="flex items-start space-x-3">
            <x-heroicon name="exclamation-triangle" class="w-6 h-6 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" />
            <div>
                <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">{{ __('admin.trading.please_fix_errors') }}</h3>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-700 dark:text-red-300">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<!-- User Information Card -->
<div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 mb-8">
    <div class="p-6 border-b border-admin-200 dark:border-admin-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <x-heroicon name="user" class="w-5 h-5 text-white" />
            </div>
            <div>
                <h2 class="text-xl font-semibold text-admin-900 dark:text-admin-100">{{ __('admin.trading.trade_owner_info') }}</h2>
                <p class="text-admin-500 dark:text-admin-400 text-sm">{{ __('admin.trading.belongs_to_following_user') }}</p>
            </div>
        </div>
    </div>
    <div class="p-6 bg-blue-50 dark:bg-blue-900/30">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                    <x-heroicon name="identification" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                </div>
                <div>
                    <p class="text-sm text-admin-500 dark:text-admin-400">{{ __('admin.trading.full_name') }}</p>
                    <p class="font-semibold text-admin-900 dark:text-admin-100">
                        {{ $trade->user_name ?? __('admin.trading.user_not_found') }}
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                    <x-heroicon name="envelope" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                </div>
                <div>
                    <p class="text-sm text-admin-500 dark:text-admin-400">{{ __('admin.users.email') }}</p>
                    <p class="font-semibold text-admin-900 dark:text-admin-100">{{ $trade->user_email ?? __('admin.trading.not_specified') }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                    <x-heroicon name="calendar" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                </div>
                <div>
                    <p class="text-sm text-admin-500 dark:text-admin-400">{{ __('admin.trading.created_at') }}</p>
                    <p class="font-semibold text-admin-900 dark:text-admin-100">{{ $trade->created_at->format('d.m.Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Trade Form -->
<div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 mb-8">
    <div class="p-6 border-b border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-heroicon name="cog-6-tooth" class="w-5 h-5 text-white" />
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-admin-900 dark:text-admin-100">{{ __('admin.trading.edit_trade_information') }}</h2>
                    <p class="text-admin-500 dark:text-admin-400 text-sm">{{ __('admin.trading.you_can_update_fields_below') }}</p>
                </div>
            </div>
            <a href="{{ route('admin.trades.index') }}" 
               class="flex items-center px-4 py-2 bg-admin-500 hover:bg-admin-600 text-white rounded-xl transition-all duration-200 shadow-lg font-medium">
                <x-heroicon name="arrow-left" class="w-4 h-4 mr-2" />
                {{ __('common.back') }}
            </a>
        </div>
    </div>
    
    <form method="POST" action="{{ route('admin.trades.update', $trade->id) }}" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Asset Field -->
            <div>
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                    <x-heroicon name="squares-2x2" class="w-4 h-4 mr-1" />
                    {{ __('admin.trading.asset') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="assets" 
                       id="assets"
                       value="{{ old('assets', $trade->assets) }}" 
                       required
                       class="w-full px-4 py-3 bg-white dark:bg-admin-700 border {{ $errors->has('assets') ? 'border-red-500 dark:border-red-400' : 'border-admin-300 dark:border-admin-600' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors"
                       placeholder="{{ __('admin.trading.asset_example') }}">
                @error('assets')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Symbol Field -->
            <div>
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                    <x-heroicon name="hashtag" class="w-4 h-4 mr-1" />
                    {{ __('admin.trading.symbol') }}
                </label>
                <input type="text" 
                       name="symbol" 
                       id="symbol"
                       value="{{ old('symbol', $trade->symbol) }}" 
                       class="w-full px-4 py-3 bg-white dark:bg-admin-700 border {{ $errors->has('symbol') ? 'border-red-500 dark:border-red-400' : 'border-admin-300 dark:border-admin-600' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors"
                       placeholder="{{ __('admin.trading.symbol_example') }}">
                @error('symbol')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Trade Type -->
            <div>
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                    <x-heroicon name="arrows-up-down" class="w-4 h-4 mr-1" />
                    {{ __('admin.trading.trade_type') }} <span class="text-red-500">*</span>
                </label>
                <select name="type" 
                        id="type"
                        required
                        class="w-full px-4 py-3 bg-white dark:bg-admin-700 border {{ $errors->has('type') ? 'border-red-500 dark:border-red-400' : 'border-admin-300 dark:border-admin-600' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors">
                    <option value="">{{ __('admin.trading.select_type') }}</option>
                    <option value="Buy" {{ old('type', $trade->type) == 'Buy' ? 'selected' : '' }}>{{ __('admin.trading.buy') }}</option>
                    <option value="Sell" {{ old('type', $trade->type) == 'Sell' ? 'selected' : '' }}>{{ __('admin.trading.sell') }}</option>
                </select>
                @error('type')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount -->
            <div>
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                    <x-heroicon name="currency-dollar" class="w-4 h-4 mr-1" />
                    {{ __('admin.trading.amount') }} ($) <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="amount" 
                       id="amount"
                       value="{{ old('amount', $trade->amount) }}" 
                       step="0.01" 
                       min="0" 
                       required
                       class="w-full px-4 py-3 bg-white dark:bg-admin-700 border {{ $errors->has('amount') ? 'border-red-500 dark:border-red-400' : 'border-admin-300 dark:border-admin-600' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors"
                       placeholder="0.00">
                @error('amount')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Leverage -->
            <div>
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                    <x-heroicon name="scale" class="w-4 h-4 mr-1" />
                    {{ __('admin.trading.leverage') }}
                </label>
                <input type="number" 
                       name="leverage" 
                       id="leverage"
                       value="{{ old('leverage', $trade->leverage) }}" 
                       min="1" 
                       max="1000"
                       class="w-full px-4 py-3 bg-white dark:bg-admin-700 border {{ $errors->has('leverage') ? 'border-red-500 dark:border-red-400' : 'border-admin-300 dark:border-admin-600' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors"
                       placeholder="{{ __('admin.trading.leverage_example') }}">
                <p class="text-xs text-admin-500 dark:text-admin-400 mt-2">{{ __('admin.trading.leave_empty_if_no_leverage') }}</p>
                @error('leverage')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Profit/Loss -->
            <div>
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                    <x-heroicon name="chart-pie" class="w-4 h-4 mr-1" />
                    {{ __('admin.trading.profit_loss') }} ($)
                </label>
                <input type="number" 
                       name="profit_earned" 
                       id="profit_earned"
                       value="{{ old('profit_earned', $trade->profit_earned) }}" 
                       step="0.01"
                       class="w-full px-4 py-3 bg-white dark:bg-admin-700 border {{ $errors->has('profit_earned') ? 'border-red-500 dark:border-red-400' : 'border-admin-300 dark:border-admin-600' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors"
                       placeholder="0.00">
                <p class="text-xs text-admin-500 dark:text-admin-400 mt-2">{{ __('admin.trading.positive_for_profit_negative_for_loss') }}</p>
                @error('profit_earned')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                    <x-heroicon name="flag" class="w-4 h-4 mr-1" />
                    {{ __('admin.trading.status') }} <span class="text-red-500">*</span>
                </label>
                <select name="active" 
                        id="active"
                        required
                        class="w-full px-4 py-3 bg-white dark:bg-admin-700 border {{ $errors->has('active') ? 'border-red-500 dark:border-red-400' : 'border-admin-300 dark:border-admin-600' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors">
                    <option value="yes" {{ old('active', $trade->active) == 'yes' ? 'selected' : '' }}>{{ __('admin.trading.active') }}</option>
                    <option value="expired" {{ old('active', $trade->active) == 'expired' ? 'selected' : '' }}>{{ __('admin.trading.completed') }}</option>
                </select>
                @error('active')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Expiry Date -->
            <div>
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                    <x-heroicon name="clock" class="w-4 h-4 mr-1" />
                    {{ __('admin.trading.expiry_date') }}
                </label>
                <input type="datetime-local" 
                       name="expire_date" 
                       id="expire_date"
                       value="{{ old('expire_date', $trade->expire_date ? \Carbon\Carbon::parse($trade->expire_date)->format('Y-m-d\TH:i') : '') }}" 
                       class="w-full px-4 py-3 bg-white dark:bg-admin-700 border {{ $errors->has('expire_date') ? 'border-red-500 dark:border-red-400' : 'border-admin-300 dark:border-admin-600' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors">
                @error('expire_date')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-admin-200 dark:border-admin-700">
            <a href="{{ route('admin.trades.index') }}" 
               class="flex items-center px-6 py-3 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 rounded-xl transition-all duration-200 font-medium">
                <x-heroicon name="x-mark" class="w-4 h-4 mr-2" />
                {{ __('common.cancel') }}
            </a>
            <button type="submit" 
                    class="flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl transition-all duration-200 shadow-lg font-medium">
                <x-heroicon name="check" class="w-4 h-4 mr-2" />
                {{ __('common.update') }}
            </button>
        </div>
    </form>
</div>

<!-- Quick Actions Card -->
<div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700">
    <div class="p-6 border-b border-admin-200 dark:border-admin-700">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                <x-heroicon name="bolt" class="w-5 h-5 text-white" />
            </div>
            <div>
                <h2 class="text-xl font-semibold text-admin-900 dark:text-admin-100">{{ __('admin.trading.quick_actions') }}</h2>
                <p class="text-admin-500 dark:text-admin-400 text-sm">{{ __('admin.trading.perform_additional_actions') }}</p>
            </div>
        </div>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <button type="button" 
                    onclick="showAddProfitForm({{ $trade->id }})"
                    class="flex items-center justify-center px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl transition-all duration-200 shadow-lg font-medium">
                <x-heroicon name="plus-circle" class="w-5 h-5 mr-2" />
                {{ __('admin.trading.add_profit_loss_to_user_roi') }}
            </button>
            <button type="button" 
                    onclick="deleteTrade({{ $trade->id }})"
                    class="flex items-center justify-center px-6 py-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl transition-all duration-200 shadow-lg font-medium">
                <x-heroicon name="trash" class="w-5 h-5 mr-2" />
                {{ __('admin.trading.delete_this_trade') }}
            </button>
        </div>
    </div>
</div>

<!-- Add Profit Modal -->
<div id="addProfitModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-admin-800 rounded-2xl max-w-md w-full shadow-2xl border border-admin-200 dark:border-admin-700">
            <div class="p-6 border-b border-admin-200 dark:border-admin-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                            <x-heroicon name="plus-circle" class="w-5 h-5 text-white" />
                        </div>
                        <h3 class="text-xl font-semibold text-admin-900 dark:text-admin-100">
                            {{ __('admin.trading.add_profit_loss') }}
                        </h3>
                    </div>
                    <button onclick="closeModal('addProfitModal')" 
                            class="p-2 text-admin-400 hover:text-admin-600 dark:text-admin-500 dark:hover:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 rounded-lg transition-colors">
                        <x-heroicon name="x-mark" class="w-5 h-5" />
                    </button>
                </div>
            </div>
            
            <form id="addProfitForm" method="POST" action="" class="space-y-6">
                @csrf
                <div class="p-6">
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start space-x-3">
                            <x-heroicon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                            <div class="text-sm text-blue-800 dark:text-blue-200">
                                <p class="font-medium mb-1">Bilgilendirme:</p>
                                <p>{{ __('admin.trading.profit_loss_info') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                                <x-heroicon name="currency-dollar" class="w-4 h-4 mr-1" />
                                {{ __('admin.trading.profit_loss_amount') }}
                            </label>
                            <input type="number" 
                                   id="profit_amount" 
                                   name="profit_amount" 
                                   step="0.01" 
                                   required
                                   class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors"
                                   placeholder="{{ __('admin.trading.enter_amount_to_add') }}">
                            <p class="text-xs text-admin-500 dark:text-admin-400 mt-2">
                                {{ __('admin.trading.positive_for_profit_negative_for_loss') }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                                <x-heroicon name="document-text" class="w-4 h-4 mr-1" />
                                {{ __('admin.trading.note_optional') }}
                            </label>
                            <textarea id="profit_note" 
                                      name="note" 
                                      rows="3"
                                      class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-admin-900 dark:text-admin-100 transition-colors resize-none"
                                      placeholder="{{ __('admin.trading.add_note_about_adjustment') }}"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-admin-200 dark:border-admin-700 bg-admin-50 dark:bg-admin-900/50 rounded-b-2xl">
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="closeModal('addProfitModal')" 
                                class="px-4 py-2 text-admin-700 dark:text-admin-300 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 rounded-xl transition-colors font-medium">
                            {{ __('common.cancel') }}
                        </button>
                        <button type="submit" 
                                class="flex items-center px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl transition-all duration-200 shadow-lg font-medium">
                            <x-heroicon name="plus-circle" class="w-4 h-4 mr-2" />
                            {{ __('admin.trading.add_profit_loss') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal Management
    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    };

    // Close modal on backdrop click
    const addProfitModal = document.getElementById('addProfitModal');
    if (addProfitModal) {
        addProfitModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal('addProfitModal');
            }
        });
    }

    // Add Profit Form Handler
    window.showAddProfitForm = function(tradeId) {
        console.log('Opening add profit form for trade ID:', tradeId);
        
        const form = document.getElementById('addProfitForm');
        const profitUrl = '{{ url("/admin/trades") }}/' + tradeId + '/add-profit';
        form.setAttribute('action', profitUrl);
        
        // Clear form fields
        document.getElementById('profit_amount').value = '';
        document.getElementById('profit_note').value = '';
        
        // Show modal with animation
        const modal = document.getElementById('addProfitModal');
        modal.classList.remove('hidden');
        
        // Focus on amount input
        setTimeout(() => {
            document.getElementById('profit_amount').focus();
        }, 100);
    };

    // Delete Trade Handler
    window.deleteTrade = function(tradeId) {
        const deleteUrl = '{{ url("/admin/trades") }}/' + tradeId;
        
        // Create custom confirmation modal
        const confirmModal = document.createElement('div');
        confirmModal.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4';
        confirmModal.innerHTML = `
            <div class="bg-white dark:bg-admin-800 rounded-2xl max-w-md w-full shadow-2xl border border-admin-200 dark:border-admin-700">
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-admin-900 dark:text-admin-100">{{ __('admin.trading.delete_trade') }}</h3>
                            <p class="text-admin-500 dark:text-admin-400 text-sm">{{ __('admin.trading.this_action_irreversible') }}</p>
                        </div>
                    </div>
                    <p class="text-admin-600 dark:text-admin-300 mb-6">
                        {{ __('admin.trading.confirm_delete_trade_message') }}
                    </p>
                    <div class="flex justify-end space-x-3">
                        <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 text-admin-700 dark:text-admin-300 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 rounded-xl transition-colors font-medium">
                            {{ __('common.cancel') }}
                        </button>
                        <button onclick="confirmDelete('${deleteUrl}', this)" class="flex items-center px-6 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl transition-all duration-200 shadow-lg font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            {{ __('admin.trading.yes_delete') }}
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(confirmModal);
    };

    // Confirm Delete Function
    window.confirmDelete = function(deleteUrl, button) {
        // Show loading state
        button.disabled = true;
        button.innerHTML = `
            <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            {{ __('admin.trading.deleting') }}...
        `;
        
        // Create and submit form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    };

    // Auto-dismiss alerts
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            if (alert) {
                alert.style.display = 'none';
            }
        });
    }, 5000);

    console.log('🚀 Admin Trade Edit sayfası başarıyla yüklendi!');
});
</script>
@endpush