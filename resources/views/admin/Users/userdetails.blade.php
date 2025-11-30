@extends('layouts.admin', ['title' => __('admin.users.user_details_title') . ' - ' . $user->name])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('admin.users.user_details_description') }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('manageusers') }}"
               class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-admin-700 dark:border-admin-600 dark:text-gray-300 dark:hover:bg-admin-600">
                <x-heroicon name="arrow-left" class="h-4 w-4 mr-2" />
                {{ __('admin.actions.back') }}
            </a>
            
            <!-- Actions Dropdown -->
            <div class="relative" id="actionsDropdown">
                <button onclick="toggleActionsDropdown()"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                    {{ __('admin.actions.actions') }}
                    <x-heroicon name="chevron-down" class="ml-2 h-4 w-4" />
                </button>
                
                <div id="actionsDropdownContent" style="display: none;"
                     class="absolute right-0 mt-2 w-64 bg-white dark:bg-admin-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-admin-600 opacity-0 transform scale-95 transition-all duration-100">
                    <div class="py-1">
                        <a href="{{ route('loginactivity', $user->id) }}"
                           class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="clock" class="w-4 h-4 mr-3" />
                            {{ __('admin.activities.login_activity') }}
                        </a>
                        
                        @if ($user->status == null || $user->status == 'blocked' || $user->status == 'banned' || $user->status == 'disabled')
                            <a href="{{ url('admin/dashboard/uunblock') }}/{{ $user->id }}"
                               class="flex items-center px-4 py-2 text-sm text-green-700 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20">
                                <x-heroicon name="lock-open" class="w-4 h-4 mr-3" />
                                {{ __('admin.actions.unblock_activate') }}
                            </a>
                        @else
                            <a href="{{ url('admin/dashboard/uublock') }}/{{ $user->id }}"
                               class="flex items-center px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <x-heroicon name="ban" class="w-4 h-4 mr-3" />
                                {{ __('admin.actions.block_disable') }}
                            </a>
                        @endif
                        
                        @if (!$user->email_verified_at)
                            <a href="{{ url('admin/dashboard/email-verify') }}/{{ $user->id }}"
                               class="flex items-center px-4 py-2 text-sm text-blue-700 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20">
                                <x-heroicon name="mail-check" class="w-4 h-4 mr-3" />
                                {{ __('admin.actions.verify_email') }}
                            </a>
                        @endif
                        
                        <div class="border-t border-gray-200 dark:border-admin-600 my-1"></div>
                        
                        <button onclick="openTopupModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="credit-card" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.credit_debit') }}
                        </button>
                        
                        <button onclick="openEditModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="user-pen" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.edit_user') }}
                        </button>
                        
                        <button onclick="openTradingModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="arrow-trending-up" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.manual_trade') }}
                        </button>
                        
                        <button onclick="openSignalModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="radio" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.create_signal') }}
                        </button>
                        
                        <div class="border-t border-gray-200 dark:border-admin-600 my-1"></div>
                        
                        <button onclick="openEmailModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="envelope" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.send_email') }}
                        </button>
                        
                        <button onclick="openNotifyModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="bell" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.send_notification') }}
                        </button>
                        
                        <button onclick="openTaxModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="calculator" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.user_tax') }}
                        </button>
                        
                        <button onclick="openWithdrawalCodeModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="key" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.withdrawal_code') }}
                        </button>
                        
                        <button onclick="openTradesModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="hash" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.set_trade_count') }}
                        </button>
                        
                        <div class="border-t border-gray-200 dark:border-admin-600 my-1"></div>
                        
                        <button onclick="openSwitchUserModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700">
                            <x-heroicon name="user-switch" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.switch_to_user') }}
                        </button>
                        
                        <button onclick="openResetPasswordModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-orange-700 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20">
                            <x-heroicon name="key-round" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.reset_password') }}
                        </button>
                        
                        <a href="{{ url('admin/dashboard/clearacct') }}/{{ $user->id }}"
                           onclick="return confirm('{{ __('admin.modals.confirm_clear_account', ['name' => $user->name]) }}')"
                           class="flex items-center px-4 py-2 text-sm text-yellow-700 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20">
                            <x-heroicon name="eraser" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.clear_account') }}
                        </a>
                        
                        <button onclick="openDeleteModal()"
                                class="flex items-center w-full px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <x-heroicon name="user-minus" class="w-4 h-4 mr-3" />
                            {{ __('admin.actions.delete_account') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <x-danger-alert />
    <x-success-alert />
            
    <!-- Financial Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Account Balance -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <x-heroicon name="wallet" class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.accounts.balance') }}</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $user->currency }}{{ number_format($user->account_bal, 2, '.', ',') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Profit -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <x-heroicon name="arrow-trending-up" class="h-6 w-6 text-green-600 dark:text-green-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.investments.profit') }}</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $user->currency }}{{ number_format($user->roi, 2, '.', ',') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Bonus -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                        <x-heroicon name="gift" class="h-6 w-6 text-purple-600 dark:text-purple-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.accounts.bonus') }}</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $user->currency }}{{ number_format($user->bonus, 2, '.', ',') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- User Transactions Section -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <x-heroicon name="activity" class="h-5 w-5 mr-2" />
                {{ __('admin.customers.transactions') }}
            </h2>
        </div>
        <div class="p-6">
            @if ($user->trade != null)
                <a href="{{ route('user.plans', $user->id) }}"
                   class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                    <x-heroicon name="eye" class="w-5 h-5 mr-2" />
                    {{ __('admin.actions.view_transactions') }}
                </a>
            @else
                <div class="text-center py-12">
                    <x-heroicon name="clipboard-x" class="mx-auto h-12 w-12 text-gray-400 mb-4" />
                    <h3 class="text-gray-500 dark:text-gray-400 text-lg font-medium">{{ __('admin.users.no_transactions_yet') }}</h3>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">{{ __('admin.users.no_transactions_description') }}</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Account Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- KYC Status -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6 text-center">
            <div class="mb-4">
                @if ($user->account_verify == 'Verified')
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="shield-check" class="h-8 w-8 text-green-600 dark:text-green-400" />
                    </div>
                @else
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="shield-x" class="h-8 w-8 text-red-600 dark:text-red-400" />
                    </div>
                @endif
            </div>
            <h3 class="text-gray-600 dark:text-gray-300 font-medium mb-2">{{ __('admin.customers.kyc_status') }}</h3>
            @if ($user->account_verify == 'Verified')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                    <x-heroicon name="check" class="w-3 h-3 mr-1" />
                    {{ __('admin.status.verified') }}
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                    <x-heroicon name="x-mark" class="w-3 h-3 mr-1" />
                    {{ __('admin.status.unverified') }}
                </span>
            @endif
        </div>
        
        <!-- Trade Mode -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6 text-center">
            <div class="mb-4">
                @if ($user->tradetype == 'Loss' || $user->tradetype == null)
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="arrow-trending-down" class="h-8 w-8 text-red-600 dark:text-red-400" />
                    </div>
                @else
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="arrow-trending-up" class="h-8 w-8 text-green-600 dark:text-green-400" />
                    </div>
                @endif
            </div>
            <h3 class="text-gray-600 dark:text-gray-300 font-medium mb-2">{{ __('admin.investments.trade_mode') }}</h3>
            @if ($user->tradetype == 'Loss' || $user->trade_mode == null)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                    <x-heroicon name="arrow-trending-down" class="w-3 h-3 mr-1" />
                    {{ __('admin.investments.loss') }}
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                    <x-heroicon name="arrow-trending-up" class="w-3 h-3 mr-1" />
                    {{ __('admin.investments.profit') }}
                </span>
            @endif
        </div>
        
        <!-- Account Status -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6 text-center">
            <div class="mb-4">
                @if (in_array($user->status, ['blocked', 'banned', 'disabled']))
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="user-minus" class="h-8 w-8 text-red-600 dark:text-red-400" />
                    </div>
                @elseif ($user->status == 'active')
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="user-check" class="h-8 w-8 text-green-600 dark:text-green-400" />
                    </div>
                @else
                    <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mx-auto">
                        <x-heroicon name="user-question" class="h-8 w-8 text-yellow-600 dark:text-yellow-400" />
                    </div>
                @endif
            </div>
            <h3 class="text-gray-600 dark:text-gray-300 font-medium mb-2">{{ __('admin.accounts.status') }}</h3>
            @if (in_array($user->status, ['blocked', 'banned', 'disabled']))
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                    <x-heroicon name="x-circle" class="w-3 h-3 mr-1" />
                    {{ ucfirst($user->status) }}
                </span>
            @elseif ($user->status == 'active')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                    <x-heroicon name="check-circle" class="w-3 h-3 mr-1" />
                    {{ __('admin.status.active') }}
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                    <x-heroicon name="question-mark-circle" class="w-3 h-3 mr-1" />
                    {{ __('admin.status.pending') }}
                </span>
            @endif
        </div>
    </div>
    
    <!-- User Information Section -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <x-heroicon name="user" class="h-5 w-5 mr-2" />
                {{ __('admin.users.user_information') }}
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <x-heroicon name="user" class="w-6 h-6 text-white" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ __('admin.forms.full_name') }}</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                <x-heroicon name="envelope" class="w-6 h-6 text-white" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ __('admin.forms.email') }}</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg border border-purple-200 dark:border-purple-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                <x-heroicon name="phone" class="w-6 h-6 text-white" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ __('admin.forms.phone') }}</p>
                            <div class="flex items-center justify-between">
                                <p class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $user->phone ?? __('admin.forms.not_specified') }}</p>
                                @if($user->phone)
                                    <div class="flex items-center space-x-2 ml-3">
                                        <!-- Arama Butonu -->
                                        <a href="tel:{{ $user->phone }}"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200"
                                           title="Telefon ile ara">
                                            <x-heroicon name="phone" class="w-4 h-4 mr-1" />
                                            {{ __('admin.actions.call') }}
                                        </a>
                                        
                                        <!-- WhatsApp Butonu -->
                                        <a href="javascript:void(0)"
                                           onclick="openWhatsApp('{{ $user->phone }}')"
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200"
                                           title="WhatsApp ile mesaj gönder">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                            </svg>
                                            WhatsApp
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg border border-orange-200 dark:border-orange-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                                <x-heroicon name="calendar-days" class="w-6 h-6 text-white" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ __('admin.forms.date_of_birth') }}</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $user->dob ?? __('admin.forms.not_specified') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-teal-50 dark:bg-teal-900/20 p-4 rounded-lg border border-teal-200 dark:border-teal-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center">
                                <x-heroicon name="flag" class="w-6 h-6 text-white" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ __('admin.forms.country') }}</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $user->country ?? __('admin.forms.not_specified') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg border border-indigo-200 dark:border-indigo-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                                <x-heroicon name="user-group" class="w-6 h-6 text-white" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ __('admin.users.assigned_admin') }}</p>
                            <div class="mt-1">
                                <select onchange="updateAssignedAdmin(this.value)"
                                        class="w-full text-sm font-semibold bg-transparent border-none text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 rounded-md">
                                    <option value="">{{ __('admin.forms.select_admin') }}</option>
                                    @if(isset($availableAdmins))
                                        @foreach($availableAdmins as $admin)
                                            <option value="{{ $admin['id'] }}" {{ ($user->assign_to == $admin['id']) ? 'selected' : '' }}>
                                                {{ $admin['name'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                                <x-heroicon name="flag" class="w-6 h-6 text-white" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ __('admin.customers.lead_status') }}</p>
                            <div class="mt-1">
                                <select onchange="updateLeadStatus(this.value)"
                                        class="w-full text-sm font-semibold bg-transparent border-none text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 rounded-md">
                                    <option value="">{{ __('admin.forms.select_status') }}</option>
                                    @if(isset($leadStatuses))
                                        @foreach($leadStatuses as $status)
                                            <option value="{{ $status['value'] }}" {{ ($user->lead_status == $status['value']) ? 'selected' : '' }}>
                                                {{ $status['label'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-900/20 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center">
                                <x-heroicon name="clock" class="w-6 h-6 text-white" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ __('admin.forms.registration_date') }}</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Admin Notları Section -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 mt-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <x-heroicon name="document-text" class="h-5 w-5 mr-2" />
                {{ __('admin.forms.admin_notes') }}
            </h2>
            <button onclick="openAddNoteModal()"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                <x-heroicon name="plus" class="w-4 h-4 mr-2" />
                {{ __('admin.actions.add_new_note') }}
            </button>
        </div>
        <div class="p-6">
            @if($leadNotes && $leadNotes->count() > 0)
                <div class="space-y-4" id="notesContainer">
                    @foreach($leadNotes as $note)
                        <div class="note-item bg-{{ $note->note_color ?? 'blue' }}-50 dark:bg-{{ $note->note_color ?? 'blue' }}-900/20 border border-{{ $note->note_color ?? 'blue' }}-200 dark:border-{{ $note->note_color ?? 'blue' }}-700 rounded-lg p-4" data-note-id="{{ $note->id }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        @if($note->is_pinned)
                                            <x-heroicon name="paper-clip" class="w-4 h-4 text-{{ $note->note_color ?? 'blue' }}-600 mr-2" />
                                        @endif
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $note->note_title }}</h4>
                                        @if($note->note_category)
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $note->note_color ?? 'blue' }}-100 text-{{ $note->note_color ?? 'blue' }}-800 dark:bg-{{ $note->note_color ?? 'blue' }}-900 dark:text-{{ $note->note_color ?? 'blue' }}-300">
                                                {{ $note->note_category }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-3">{{ $note->note_content }}</p>
                                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                        <x-heroicon name="user" class="w-3 h-3 mr-1" />
                                        <span class="mr-3">{{ $note->admin ? $note->admin->getFullName() : __('admin.forms.unknown_admin') }}</span>
                                        <x-heroicon name="clock" class="w-3 h-3 mr-1" />
                                        <span class="mr-3">{{ $note->created_at->format('d/m/Y H:i') }}</span>
                                        @if($note->reminder_date)
                                            <x-heroicon name="bell" class="w-3 h-3 mr-1" />
                                            <span>{{ \Carbon\Carbon::parse($note->reminder_date)->format('d/m/Y H:i') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    @if($note->admin_id == Auth::guard('admin')->id())
                                        <button onclick="openEditNoteModal({{ $note->id }})"
                                                class="text-{{ $note->note_color ?? 'blue' }}-600 hover:text-{{ $note->note_color ?? 'blue' }}-800 dark:text-{{ $note->note_color ?? 'blue' }}-400 dark:hover:text-{{ $note->note_color ?? 'blue' }}-300"
                                                title="{{ __('admin.actions.edit_note') }}">
                                            <x-heroicon name="pencil" class="w-4 h-4" />
                                        </button>
                                        <button onclick="deleteNote({{ $note->id }})"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                                title="{{ __('admin.actions.delete_note') }}">
                                            <x-heroicon name="trash" class="w-4 h-4" />
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <x-heroicon name="document-text" class="mx-auto h-12 w-12 text-gray-400 mb-4" />
                    <h3 class="text-gray-500 dark:text-gray-400 text-lg font-medium">{{ __('admin.forms.no_notes_yet') }}</h3>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">{{ __('admin.forms.no_notes_description') }}</p>
                    <button onclick="openAddNoteModal()"
                            class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                        <x-heroicon name="plus" class="w-4 h-4 mr-2" />
                        {{ __('admin.actions.add_first_note') }}
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Vanilla JavaScript Modal Sistemi
let currentOpenModal = null;
let actionsDropdownOpen = false;

// Modal açma fonksiyonu
function openModal(modalId) {
    console.log('🔍 MODAL DEBUG - Opening attempt:', modalId); // Enhanced debug log
    
    // DOM element kontrolü
    const modal = document.getElementById(modalId);
    console.log('🔍 MODAL DEBUG - Element search result:', {
        modalId: modalId,
        elementFound: modal ? 'YES' : 'NO',
        elementType: modal ? modal.tagName : 'N/A',
        elementClasses: modal ? modal.className : 'N/A'
    });
    
    closeAllModals(); // Önce tüm modalleri kapat
    
    if (modal) {
        console.log('🔍 MODAL DEBUG - Before opening:', {
            modalId: modalId,
            currentDisplay: modal.style.display,
            visibility: modal.style.visibility,
            zIndex: modal.style.zIndex
        });
        
        // Modal'ı görünür yap
        modal.style.display = 'block';
        modal.style.visibility = 'visible';
        modal.style.zIndex = '9999';
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
        
        // Body scroll'unu engelle
        document.body.style.overflow = 'hidden';
        currentOpenModal = modalId;
        
        // Modal içeriğine fade-in animasyonu
        const modalContent = modal.querySelector('.inline-block');
        if (modalContent) {
            modalContent.classList.add('animate-fadeIn');
            modalContent.style.transform = 'scale(1)';
        }
        
        // Forced reflow to ensure styles apply
        modal.offsetHeight;
        
        console.log('🔍 MODAL DEBUG - After opening:', {
            modalId: modalId,
            currentDisplay: modal.style.display,
            visibility: modal.style.visibility,
            zIndex: modal.style.zIndex,
            opacity: modal.classList.contains('opacity-100')
        });
    } else {
        console.error('🚨 MODAL DEBUG - Element NOT FOUND:', modalId);
        console.log('🔍 MODAL DEBUG - Available modals check:');
        
        // Tüm modal'ları kontrol et
        const allModals = [
            'topupModal', 'editModal', 'tradingModal', 'emailModal', 'deleteModal',
            'resetPasswordModal', 'taxModal', 'withdrawalCodeModal', 'notifyModal',
            'tradesModal', 'signalModal', 'switchUserModal'
        ];
        
        allModals.forEach(id => {
            const element = document.getElementById(id);
            console.log(`🔍 ${id}:`, element ? 'EXISTS' : 'MISSING');
        });
    }
}

// Modal kapatma fonksiyonu
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        
        const modalContent = modal.querySelector('.inline-block');
        if (modalContent) {
            modalContent.style.transform = 'scale(0.95)';
        }
        
        setTimeout(() => {
            modal.style.display = 'none';
            modal.style.visibility = 'hidden';
            document.body.style.overflow = 'auto'; // Scroll'u geri aç
            currentOpenModal = null;
        }, 300);
    }
}

// Tüm modalleri kapatma
function closeAllModals() {
    const modals = [
        'topupModal', 'editModal', 'tradingModal', 'emailModal', 'deleteModal',
        'resetPasswordModal', 'taxModal', 'withdrawalCodeModal', 'notifyModal',
        'tradesModal', 'signalModal', 'switchUserModal', 'addNoteModal', 'editNoteModal'
    ];
    
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal && modal.style.display !== 'none') {
            closeModal(modalId);
        }
    });
}

// Actions dropdown toggle
function toggleActionsDropdown() {
    const dropdown = document.getElementById('actionsDropdownContent');
    if (!dropdown) return;
    
    actionsDropdownOpen = !actionsDropdownOpen;
    
    if (actionsDropdownOpen) {
        dropdown.style.display = 'block';
        setTimeout(() => {
            dropdown.classList.remove('opacity-0', 'scale-95');
            dropdown.classList.add('opacity-100', 'scale-100');
        }, 10);
    } else {
        dropdown.classList.remove('opacity-100', 'scale-100');
        dropdown.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            dropdown.style.display = 'none';
        }, 100);
    }
}

// Dropdown'u kapat
function closeActionsDropdown() {
    if (actionsDropdownOpen) {
        const dropdown = document.getElementById('actionsDropdownContent');
        if (dropdown) {
            dropdown.classList.remove('opacity-100', 'scale-100');
            dropdown.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                dropdown.style.display = 'none';
                actionsDropdownOpen = false;
            }, 100);
        }
    }
}

// Modal açma fonksiyonları
window.openTopupModal = function() { openModal('topupModal'); };
window.openEditModal = function() { openModal('editModal'); };
window.openTradingModal = function() { openModal('tradingModal'); };
window.openSignalModal = function() { openModal('signalModal'); };
window.openEmailModal = function() { openModal('emailModal'); };
window.openNotifyModal = function() { openModal('notifyModal'); };
window.openTaxModal = function() { openModal('taxModal'); };
window.openWithdrawalCodeModal = function() {
    console.log('openWithdrawalCodeModal called'); // Debug log
    openModal('withdrawalCodeModal');
};
window.openTradesModal = function() { openModal('tradesModal'); };
window.openSwitchUserModal = function() { openModal('switchUserModal'); };
window.openResetPasswordModal = function() {
    console.log('openResetPasswordModal called'); // Debug log
    openModal('resetPasswordModal');
};
window.openDeleteModal = function() { openModal('deleteModal'); };

// Event listener'lar
document.addEventListener('DOMContentLoaded', function() {
    // ESC tuşu ile modal kapatma
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && currentOpenModal) {
            closeModal(currentOpenModal);
        }
    });
    
    // Dış tıklama ile dropdown kapatma
    document.addEventListener('click', function(e) {
        const actionsDropdown = document.getElementById('actionsDropdown');
        if (actionsDropdownOpen && actionsDropdown && !actionsDropdown.contains(e.target)) {
            closeActionsDropdown();
        }
    });
});

// Debug fonksiyonu
window.debugModals = function() {
    console.log('Modal System Debug:');
    console.log('Current open modal:', currentOpenModal);
    console.log('Actions dropdown open:', actionsDropdownOpen);
    
    const modals = [
        'topupModal', 'editModal', 'tradingModal', 'emailModal', 'deleteModal',
        'resetPasswordModal', 'taxModal', 'withdrawalCodeModal', 'notifyModal',
        'tradesModal', 'signalModal', 'switchUserModal'
    ];
    
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        console.log(`${modalId}:`, modal ? 'exists' : 'missing', modal?.style.display || 'none');
    });
};

// Problem olan modallar için özel debug fonksiyonu
window.debugProblemModals = function() {
    console.log('=== Problem Modal Debug ===');
    
    console.log('Button elements check:');
    const withdrawalBtn = document.querySelector('[onclick*="openWithdrawalCodeModal"]');
    const resetBtn = document.querySelector('[onclick*="openResetPasswordModal"]');
    console.log('Withdrawal button found:', withdrawalBtn ? 'YES' : 'NO');
    console.log('Reset password button found:', resetBtn ? 'YES' : 'NO');
    
    console.log('Modal elements check:');
    const withdrawalModal = document.getElementById('withdrawalCodeModal');
    const resetModal = document.getElementById('resetPasswordModal');
    console.log('withdrawalCodeModal element:', withdrawalModal ? 'EXISTS' : 'MISSING');
    console.log('resetPasswordModal element:', resetModal ? 'EXISTS' : 'MISSING');
    
    if (withdrawalModal) {
        console.log('withdrawalCodeModal display:', withdrawalModal.style.display);
        console.log('withdrawalCodeModal classes:', withdrawalModal.className);
    }
    
    if (resetModal) {
        console.log('resetPasswordModal display:', resetModal.style.display);
        console.log('resetPasswordModal classes:', resetModal.className);
    }
    
    console.log('Functions check:');
    console.log('openWithdrawalCodeModal exists:', typeof window.openWithdrawalCodeModal);
    console.log('openResetPasswordModal exists:', typeof window.openResetPasswordModal);
    console.log('openModal exists:', typeof window.openModal);
};

// Form validation fonksiyonları
function validateNoteForm(formId) {
    const form = document.getElementById(formId);
    const title = form.querySelector('[name="note_title"]').value.trim();
    const content = form.querySelector('[name="note_content"]').value.trim();
    
    let errors = [];
    
    // Başlık kontrolü
    if (!title) {
        errors.push('{{ __("admin.validation.note_title_required") }}');
    } else if (title.length < 3) {
        errors.push('{{ __("admin.validation.note_title_min_length") }}');
    } else if (title.length > 100) {
        errors.push('{{ __("admin.validation.note_title_max_length") }}');
    }
    
    // İçerik kontrolü
    if (!content) {
        errors.push('{{ __("admin.validation.note_content_required") }}');
    } else if (content.length < 10) {
        errors.push('{{ __("admin.validation.note_content_min_length") }}');
    } else if (content.length > 1000) {
        errors.push('{{ __("admin.validation.note_content_max_length") }}');
    }
    
    // Hatırlatıcı tarihi kontrolü
    const reminderDate = form.querySelector('[name="reminder_date"]').value;
    if (reminderDate) {
        const selectedDate = new Date(reminderDate);
        const now = new Date();
        if (selectedDate <= now) {
            errors.push('{{ __("admin.validation.reminder_date_future") }}');
        }
    }
    
    if (errors.length > 0) {
        alert('{{ __("admin.validation.please_fix_errors") }}:\n\n• ' + errors.join('\n• '));
        return false;
    }
    
    return true;
}

// Real-time karakter sayacı
function setupCharacterCounters() {
    // Başlık sayacı
    const titleInputs = document.querySelectorAll('[name="note_title"]');
    titleInputs.forEach(input => {
        const counter = document.createElement('div');
        counter.className = 'text-xs text-gray-500 dark:text-gray-400 mt-1';
        counter.textContent = '0/100 {{ __("admin.forms.characters") }}';
        input.parentNode.appendChild(counter);
        
        input.addEventListener('input', function() {
            const length = this.value.length;
            counter.textContent = `${length}/100 {{ __("admin.forms.characters") }}`;
            counter.className = length > 100 ? 'text-xs text-red-500 mt-1' : 'text-xs text-gray-500 dark:text-gray-400 mt-1';
        });
    });
    
    // İçerik sayacı
    const contentInputs = document.querySelectorAll('[name="note_content"]');
    contentInputs.forEach(input => {
        const counter = document.createElement('div');
        counter.className = 'text-xs text-gray-500 dark:text-gray-400 mt-1';
        counter.textContent = '0/1000 {{ __("admin.forms.characters") }}';
        input.parentNode.appendChild(counter);
        
        input.addEventListener('input', function() {
            const length = this.value.length;
            counter.textContent = `${length}/1000 {{ __("admin.forms.characters") }}`;
            counter.className = length > 1000 ? 'text-xs text-red-500 mt-1' : 'text-xs text-gray-500 dark:text-gray-400 mt-1';
        });
    });
}

// Admin Notları fonksiyonları
window.openAddNoteModal = function() {
    // Form'u temizle
    document.getElementById('addNoteForm').reset();
    
    // Karakter sayaçlarını kur
    setTimeout(() => {
        setupCharacterCounters();
    }, 100);
    
    openModal('addNoteModal');
};

window.openEditNoteModal = function(noteId) {
    // Note bilgilerini al ve form'u doldur
    fetch(`/admin/dashboard/users/{{ $user->id }}/notes/${noteId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const note = data.note;
                document.getElementById('edit_note_id').value = note.id;
                document.getElementById('edit_note_title').value = note.note_title;
                document.getElementById('edit_note_content').value = note.note_content;
                document.getElementById('edit_note_category').value = note.note_category || '';
                document.getElementById('edit_note_color').value = note.note_color || 'blue';
                document.getElementById('edit_is_pinned').checked = note.is_pinned == 1;
                document.getElementById('edit_reminder_date').value = note.reminder_date || '';
                
                // Karakter sayaçlarını kur
                setTimeout(() => {
                    setupCharacterCounters();
                }, 100);
                
                openModal('editNoteModal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ __("admin.notifications.error_loading_note") }}');
        });
};

// Note silme fonksiyonu
window.deleteNote = function(noteId) {
    if (confirm('{{ __("admin.modals.confirm_delete_note") }}')) {
        fetch(`/admin/dashboard/users/{{ $user->id }}/notes/${noteId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Not elementini DOM'dan kaldır
                const noteElement = document.querySelector(`[data-note-id="${noteId}"]`);
                if (noteElement) {
                    noteElement.remove();
                }
                
                // Eğer hiç not kalmadıysa empty state göster
                const notesContainer = document.getElementById('notesContainer');
                if (notesContainer && notesContainer.children.length === 0) {
                    location.reload(); // Sayfayı yenile empty state'i göstermek için
                }
                
                alert('{{ __("admin.notifications.note_deleted_successfully") }}');
            } else {
                alert(data.message || '{{ __("admin.notifications.error_deleting_note") }}');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ __("admin.notifications.error_deleting_note") }}');
        });
    }
};

// Note ekleme form submit
window.submitAddNote = function() {
    // Form validation kontrolü
    if (!validateNoteForm('addNoteForm')) {
        return; // Validation başarısızsa işlemi durdur
    }
    
    const form = document.getElementById('addNoteForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Button'u disable et ve loading state göster
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="h-4 w-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>{{ __("admin.actions.saving") }}...';
    
    const formData = new FormData(form);
    
    fetch(`/admin/dashboard/users/{{ $user->id }}/notes`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal('addNoteModal');
            
            // Success mesajı göster
            const successMsg = document.createElement('div');
            successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            successMsg.textContent = '{{ __("admin.notifications.note_added_successfully") }}';
            document.body.appendChild(successMsg);
            
            // 3 saniye sonra mesajı kaldır
            setTimeout(() => {
                successMsg.remove();
            }, 3000);
            
            location.reload(); // Sayfayı yenile yeni notu göstermek için
        } else {
            alert(data.message || '{{ __("admin.notifications.error_adding_note") }}');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ __("admin.notifications.error_adding_note") }}');
    })
    .finally(() => {
        // Button'u tekrar enable et
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>{{ __("admin.actions.save_note") }}';
    });
};

// Note düzenleme form submit
window.submitEditNote = function() {
    // Form validation kontrolü
    if (!validateNoteForm('editNoteForm')) {
        return; // Validation başarısızsa işlemi durdur
    }
    
    const form = document.getElementById('editNoteForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    const noteId = document.getElementById('edit_note_id').value;
    
    // Button'u disable et ve loading state göster
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="h-4 w-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>{{ __("admin.actions.updating") }}...';
    
    const formData = new FormData(form);
    
    fetch(`/admin/dashboard/users/{{ $user->id }}/notes/${noteId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal('editNoteModal');
            
            // Success mesajı göster
            const successMsg = document.createElement('div');
            successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            successMsg.textContent = '{{ __("admin.notifications.note_updated_successfully") }}';
            document.body.appendChild(successMsg);
            
            // 3 saniye sonra mesajı kaldır
            setTimeout(() => {
                successMsg.remove();
            }, 3000);
            
            location.reload(); // Sayfayı yenile güncellenen notu göstermek için
        } else {
            alert(data.message || '{{ __("admin.notifications.error_updating_note") }}');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ __("admin.notifications.error_updating_note") }}');
    })
    .finally(() => {
        // Button'u tekrar enable et
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path></svg>{{ __("admin.actions.save_changes") }}';
    });
};

// WhatsApp fonksiyonu
window.openWhatsApp = function(phoneNumber) {
    if (!phoneNumber) {
        alert('{{ __("admin.notifications.phone_number_not_found") }}');
        return;
    }
    
    // Telefon numarasını temizle (sadece rakamları bırak)
    let cleanPhone = phoneNumber.replace(/\D/g, '');
    
    // Türkiye için ülke kodu kontrolü
    if (cleanPhone.startsWith('0')) {
        cleanPhone = '90' + cleanPhone.substring(1); // 0'ı 90 ile değiştir
    } else if (!cleanPhone.startsWith('90')) {
        cleanPhone = '90' + cleanPhone; // Başında 90 yoksa ekle
    }
    
    // WhatsApp URL'ini oluştur
    const message = encodeURIComponent('{{ __("admin.messages.whatsapp_default_message") }}');
    const whatsappUrl = `https://wa.me/${cleanPhone}?text=${message}`;
    
    // Yeni pencerede aç
    window.open(whatsappUrl, '_blank');
};

// Dropdown güncelleme fonksiyonları
window.updateAssignedAdmin = function(adminId) {
    if (!adminId) {
        return; // Boş seçim yapıldıysa işlem yapma
    }
    
    if (!confirm('{{ __("admin.modals.confirm_assign_admin") }}')) {
        // Kullanıcı iptal ederse dropdown'ı eski değere döndür
        const dropdown = document.querySelector('[onchange="updateAssignedAdmin(this.value)"]');
        dropdown.value = '{{ $user->assign_to ?? "" }}';
        return;
    }
    
    // Loading state göster
    const dropdown = document.querySelector('[onchange="updateAssignedAdmin(this.value)"]');
    dropdown.disabled = true;
    dropdown.style.opacity = '0.6';
    
    fetch(`/admin/dashboard/users/{{ $user->id }}/assign-admin`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            admin_id: adminId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success mesajı göster
            const successMsg = document.createElement('div');
            successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            successMsg.textContent = '{{ __("admin.notifications.admin_assigned_successfully") }}';
            document.body.appendChild(successMsg);
            
            setTimeout(() => {
                successMsg.remove();
            }, 3000);
        } else {
            alert(data.message || '{{ __("admin.notifications.error_assigning_admin") }}');
            // Hata durumunda dropdown'ı eski değere döndür
            dropdown.value = '{{ $user->assign_to ?? "" }}';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ __("admin.notifications.error_assigning_admin") }}');
        // Hata durumunda dropdown'ı eski değere döndür
        dropdown.value = '{{ $user->assign_to ?? "" }}';
    })
    .finally(() => {
        // Loading state'i kaldır
        dropdown.disabled = false;
        dropdown.style.opacity = '1';
    });
};

window.updateLeadStatus = function(statusValue) {
    if (!statusValue) {
        return; // Boş seçim yapıldıysa işlem yapma
    }
    
    if (!confirm('{{ __("admin.modals.confirm_update_lead_status") }}')) {
        // Kullanıcı iptal ederse dropdown'ı eski değere döndür
        const dropdown = document.querySelector('[onchange="updateLeadStatus(this.value)"]');
        dropdown.value = '{{ $user->lead_status ?? "" }}';
        return;
    }
    
    // Loading state göster
    const dropdown = document.querySelector('[onchange="updateLeadStatus(this.value)"]');
    dropdown.disabled = true;
    dropdown.style.opacity = '0.6';
    
    fetch(`/admin/dashboard/users/{{ $user->id }}/update-lead-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            lead_status: statusValue
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success mesajı göster
            const successMsg = document.createElement('div');
            successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            successMsg.textContent = '{{ __("admin.notifications.lead_status_updated_successfully") }}';
            document.body.appendChild(successMsg);
            
            setTimeout(() => {
                successMsg.remove();
            }, 3000);
        } else {
            alert(data.message || '{{ __("admin.notifications.error_updating_lead_status") }}');
            // Hata durumunda dropdown'ı eski değere döndür
            dropdown.value = '{{ $user->lead_status ?? "" }}';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ __("admin.notifications.error_updating_lead_status") }}');
        // Hata durumunda dropdown'ı eski değere döndür
        dropdown.value = '{{ $user->lead_status ?? "" }}';
    })
    .finally(() => {
        // Loading state'i kaldır
        dropdown.disabled = false;
        dropdown.style.opacity = '1';
    });
};
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}
</style>

@include('admin.Users.users_actions')
@endsection