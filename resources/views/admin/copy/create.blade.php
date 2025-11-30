@extends('layouts.app')
@section('content')

<div class="container-fluid px-6 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <nav class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-2">
                <a href="{{ route('admin.copy.index') }}" class="hover:text-gray-900 dark:hover:text-white">{{ __('admin.copy.copy_trading') }}</a>
                <x-heroicon name="chevron-right" class="w-4 h-4 mx-2" />
                <span class="text-gray-900 dark:text-white">{{ __('admin.copy.add_expert') }}</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('admin.copy.create_expert_trader_description') }}</p>
        </div>
        <a href="{{ route('admin.copy.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
            <x-heroicon name="arrow-left" class="w-4 h-4" />
            {{ __('admin.copy.back_to_list') }}
        </a>
    </div>

    <!-- Form -->
    <div class="max-w-4xl">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('admin.copy.expert_trader_information') }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('admin.copy.fill_expert_details') }}</p>
            </div>

            <form action="{{ route('admin.copy.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            {{ __('admin.copy.basic_information') }}
                        </h3>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.copy.expert_name') }} *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="{{ __('admin.copy.expert_name_placeholder') }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tag/Title -->
                        <div>
                            <label for="tag" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.copy.professional_tag') }}
                            </label>
                            <input type="text" 
                                   id="tag" 
                                   name="tag" 
                                   value="{{ old('tag') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="{{ __('admin.copy.professional_tag_placeholder') }}">
                            @error('tag')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Photo Upload -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.copy.profile_photo') }}
                            </label>
                            <div class="flex items-center space-x-4">
                                <div id="photo-preview" class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                    <x-heroicon name="camera" class="w-8 h-8 text-gray-400" />
                                </div>
                                <div class="flex-1">
                                    <input type="file" 
                                           id="photo" 
                                           name="photo" 
                                           accept="image/*"
                                           onchange="previewPhoto(this)"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <p class="text-xs text-gray-500 mt-1">{{ __('admin.copy.photo_requirements') }}</p>
                                </div>
                            </div>
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.copy.description') }}
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                      placeholder="{{ __('admin.copy.description_placeholder') }}">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Performance & Pricing -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            {{ __('admin.copy.performance_pricing') }}
                        </h3>

                        <!-- Rating -->
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.copy.rating_1_5') }} *
                            </label>
                            <select id="rating" 
                                    name="rating" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">{{ __('admin.copy.select_rating') }}</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                        {{ $i }} {{ __('admin.copy.star' . ($i > 1 ? 's' : '')) }}
                                    </option>
                                @endfor
                            </select>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Win Rate -->
                        <div>
                            <label for="win_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.copy.win_rate_percent') }} *
                            </label>
                            <input type="number" 
                                   id="win_rate" 
                                   name="win_rate" 
                                   value="{{ old('win_rate') }}"
                                   min="0" 
                                   max="100" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="{{ __('admin.copy.win_rate_placeholder') }}">
                            @error('win_rate')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Profit -->
                        <div>
                            <label for="total_profit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.copy.total_profit_percent') }} *
                            </label>
                            <input type="number" 
                                   id="total_profit" 
                                   name="total_profit" 
                                   value="{{ old('total_profit') }}"
                                   step="0.01" 
                                   min="0" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="{{ __('admin.copy.total_profit_placeholder') }}">
                            @error('total_profit')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Equity -->
                        <div>
                            <label for="equity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.copy.current_equity_usd') }} *
                            </label>
                            <input type="number" 
                                   id="equity" 
                                   name="equity" 
                                   value="{{ old('equity') }}"
                                   step="0.01" 
                                   min="0" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="{{ __('admin.copy.equity_placeholder') }}">
                            @error('equity')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Trades -->
                        <div>
                            <label for="total_trades" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.copy.total_trades') }} *
                            </label>
                            <input type="number" 
                                   id="total_trades" 
                                   name="total_trades" 
                                   value="{{ old('total_trades') }}"
                                   min="0" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="{{ __('admin.copy.total_trades_placeholder') }}">
                            @error('total_trades')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Minimum Investment Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.copy.minimum_investment_usd') }} *
                            </label>
                            <input type="number" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price') }}"
                                   step="0.01" 
                                   min="0" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="{{ __('admin.copy.min_investment_placeholder') }}">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Followers -->
                        <div>
                            <label for="followers" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.copy.initial_followers') }} *
                            </label>
                            <input type="number" 
                                   id="followers" 
                                   name="followers" 
                                   value="{{ old('followers', 0) }}"
                                   min="0" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="{{ __('admin.copy.followers_placeholder') }}">
                            @error('followers')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.copy.status') }} *
                            </label>
                            <select id="status" 
                                    name="status" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">{{ __('admin.copy.select_status') }}</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('admin.copy.active') }}</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('admin.copy.inactive') }}</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center gap-4 pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-lg hover:shadow-xl">
                        <x-heroicon name="save" class="w-4 h-4" />
                        {{ __('admin.copy.create_expert_trader') }}
                    </button>
                    <a href="{{ route('admin.copy.index') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <x-heroicon name="x-mark" class="w-4 h-4" />
                        {{ __('admin.copy.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @parent
    <script>
        function previewPhoto(input) {
            const preview = document.getElementById('photo-preview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-full" alt="Preview">`;
                };
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = '<x-heroicon name="camera" class="w-8 h-8 text-gray-400" />';
                
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            
        });
    </script>
@endsection
