@extends('layouts.admin', ['title' => __('admin.signals.update_signal')])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <x-heroicon name="pencil-square" class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('admin.signals.update_signal') }}</h1>
            </div>
        </div>
        <div>
            <a href="{{ route('signals') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-admin-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fa fa-arrow-left mr-2"></i>
                {{ __('admin.signals.back') }}
            </a>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    
    <!-- Edit Signal Form -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="p-6">
            <form role="form" method="post" action="{{ route('updatesignal') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Signal Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('admin.signals.signal_name') }}
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ $signal->name }}"
                               placeholder="{{ __('admin.signals.enter_signal_name') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
                    </div>

                    <!-- Signal Price -->
                    <div class="space-y-2">
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('admin.signals.signal_price') }} ({{ $settings->currency }})
                        </label>
                        <input type="number"
                               id="price"
                               name="price"
                               value="{{ $signal->price }}"
                               placeholder="{{ __('admin.signals.enter_signal_price') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('admin.signals.price_description') }}
                        </p>
                    </div>
                                    
                                   
                                   
                                    
                                    

                    <!-- Increment Rate -->
                    <div class="space-y-2 md:col-span-2">
                        <label for="increment_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('admin.signals.increment_rate') }}
                        </label>
                        <input type="number"
                               id="increment_amount"
                               name="increment_amount"
                               step="any"
                               value="{{ $signal->increment_amount }}"
                               placeholder="{{ __('admin.signals.increment_placeholder') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
                    </div>
                </div>

                <!-- Hidden Fields and Submit -->
                <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-admin-700">
                    <input type="hidden" name="id" value="{{ $signal->id }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        {{ __('admin.signals.update_signal') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
