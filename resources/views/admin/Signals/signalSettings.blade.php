@extends('layouts.admin', ['title' => __('admin.signals.settings_title')])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                <x-heroicon name="cog-6-tooth" class="h-6 w-6 text-blue-600 dark:text-blue-400" />
            </div>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('admin.signals.settings_title') }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('admin.signals.settings_subtitle') }}</p>
        </div>
    </div>

    <x-danger-alert />
    <x-success-alert />
    <!-- Settings Form -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="p-6">
            <form action="{{ route('save.settings') }}" method="post" class="max-w-2xl mx-auto space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Monthly Fee -->
                <div class="space-y-2">
                    <label for="monthly" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('admin.signals.monthly_fee') }} ({{ $settings->currency }})
                    </label>
                    <input type="number"
                           id="monthly"
                           name="monthly"
                           value="{{ $signalSettings->signal_monthly_fee }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
                </div>

                <!-- Quarterly Fee -->
                <div class="space-y-2">
                    <label for="quaterly" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('admin.signals.quarterly_fee') }} ({{ $settings->currency }})
                    </label>
                    <input type="number"
                           step="any"
                           id="quaterly"
                           name="quaterly"
                           value="{{ $signalSettings->signal_quartly_fee }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
                </div>

                <!-- Yearly Fee -->
                <div class="space-y-2">
                    <label for="yearly" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('admin.signals.yearly_fee') }} ({{ $settings->currency }})
                    </label>
                    <input type="number"
                           step="any"
                           id="yearly"
                           name="yearly"
                           value="{{ $signalSettings->signal_yearly_fee }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
                </div>
                <!-- Chat ID -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label for="chat_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('admin.signals.chat_id') }}
                        </label>
                        @if ($signalSettings->chat_id == '')
                            <a href="{{ route('chat.id') }}"
                               class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                {{ __('admin.signals.get_id') }}
                            </a>
                        @else
                            <a href="{{ route('delete.id') }}"
                               class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                {{ __('admin.signals.delete_id') }}
                            </a>
                        @endif
                    </div>
                    <input type="text"
                           id="chat_id"
                           name="chat_id"
                           value="{{ $signalSettings->chat_id }}"
                           readonly
                           class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm bg-gray-50 dark:bg-admin-600 text-gray-500 dark:text-gray-400">
                    @if ($signalSettings->chat_id == '')
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('admin.signals.telegram_bot_instructions') }}
                        </p>
                    @endif
                </div>

                <!-- Telegram Bot API -->
                <div class="space-y-2">
                    <label for="telegram_bot_api" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('admin.signals.telegram_bot_api') }}
                    </label>
                    <input type="text"
                           id="telegram_bot_api"
                           name="telegram_bot_api"
                           value="{{ $signalSettings->telegram_bot_api }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <a href="https://learn.microsoft.com/en-us/azure/bot-service/bot-service-channel-connect-telegram?view=azure-bot-service-4.0#create-a-new-telegram-bot-with-botfather"
                           target="_blank"
                           class="text-red-600 hover:text-red-500 font-medium flex items-center">
                            {{ __('admin.signals.see_how') }} <i class="fa fa-link ml-1"></i>
                        </a>
                    </p>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-6">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        {{ __('admin.signals.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
