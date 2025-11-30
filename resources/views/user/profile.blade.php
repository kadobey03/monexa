@extends('layouts.master', ['layoutType' => 'dashboard'])
@section('title', $title)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-4 sm:py-6 md:py-8" id="profileContainer">
    <div class="w-full max-w-6xl mx-auto px-2 sm:px-3 md:px-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('user.profile.settings_title') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('user.profile.settings_description') }}</p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                <x-heroicon name="arrow-left" class="w-5 h-5" />
                {{ __('user.profile.back_to_dashboard') }}
            </a>
        </div>

        <!-- Alert Messages -->
        <x-danger-alert />
        <x-success-alert />
        <x-error-alert />

        <!-- Breadcrumbs -->
        <nav class="flex mb-6 mt-2" aria-label="Breadcrumb ">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                        <x-heroicon name="home" class="w-4 h-4 mr-2" />
                        {{ __('user.profile.breadcrumb_home') }}
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-heroicon name="chevron-right" class="w-4 h-4 text-gray-400 mx-1" />
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('user.profile.breadcrumb_profile') }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Main Content -->
        <div class="bg-gray-900 dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-700 dark:border-gray-600 overflow-hidden">
            <!-- Profile Header with Avatar -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-12 relative">
                <div class="absolute inset-0 bg-pattern opacity-10"></div>
                <div class="flex flex-col items-center relative z-10">
                    <div class="relative group">
                        <div class="w-24 h-24 rounded-full bg-white dark:bg-gray-700 p-1 shadow-lg">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="rounded-full w-full h-full object-cover">
                        </div>
                        <div class="absolute inset-0 rounded-full flex items-center justify-center bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                            <x-heroicon name="camera" class="w-6 h-6 text-white" />
                        </div>
                    </div>
                    <h2 class="text-xl font-bold text-white mt-4">{{ Auth::user()->name }}</h2>
                    <p class="text-blue-100">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="border-b border-gray-700 dark:border-gray-600">
                <div class="flex px-6">
                    <button onclick="setActiveTab('per')" id="perTab" class="py-4 px-4 font-medium text-sm focus:outline-none flex items-center gap-2 transition-colors border-b-2 border-blue-500 text-blue-600 dark:text-blue-400">
                        <x-heroicon name="user" class="w-5 h-5" />
                        <span>{{ __('user.profile.tab_personal_info') }}</span>
                    </button>
                    <button onclick="setActiveTab('pas')" id="pasTab" class="py-4 px-4 font-medium text-sm focus:outline-none flex items-center gap-2 transition-colors text-gray-300 dark:text-gray-400">
                        <x-heroicon name="lock-closed" class="w-5 h-5" />
                        <span>{{ __('user.profile.tab_security') }}</span>
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <div id="perContent" class="transition-opacity duration-200 opacity-100">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <x-heroicon name="information-circle" class="h-5 w-5 text-blue-500" aria-hidden="true" />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700 dark:text-blue-400">
                                    {{ __('user.profile.personal_info_help') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @include('profile.update-profile-information-form')
                </div>

                <div id="pasContent" class="transition-opacity duration-200 opacity-0" style="display: none;">
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 border-l-4 border-indigo-500 p-4 mb-6 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <x-heroicon name="shield-check" class="h-5 w-5 text-indigo-500" aria-hidden="true" />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-indigo-700 dark:text-indigo-400">
                                    {{ __('user.profile.security_help') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @include('profile.update-password-form')
                </div>
            </div>
        </div>

        <!-- Activity Card -->
        <div class="bg-gray-900 dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-700 dark:border-gray-600 mt-8 p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <x-heroicon name="activity" class="w-6 h-6 text-green-600 dark:text-green-400" />
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white dark:text-white">{{ __('user.profile.recent_activities') }}</h2>
                    <p class="text-sm text-gray-300 dark:text-gray-400">{{ __('user.profile.recent_activities_desc') }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-800 dark:bg-gray-700/50 border border-gray-700 dark:border-gray-600">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <x-heroicon name="arrow-right-on-rectangle" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white dark:text-white">{{ __('user.profile.activity_login') }}</p>
                        <p class="text-xs text-gray-300 dark:text-gray-400">{{ __('user.profile.activity_last_login') }} {{ request()->ip() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-gray-300 dark:text-gray-400">{{ \Carbon\Carbon::now()->subMinutes(rand(5, 120))->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-800 dark:bg-gray-700/50 border border-gray-700 dark:border-gray-600">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-full">
                        <x-heroicon name="cog-6-tooth" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white dark:text-white">{{ __('user.profile.activity_profile_updated') }}</p>
                        <p class="text-xs text-gray-300 dark:text-gray-400">{{ __('user.profile.activity_profile_updated_desc') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-gray-300 dark:text-gray-400">
                            {{Auth::user()->updated_at->toDayDateTimeString()}}
                            </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @parent
    <script>
        // Profile Tab Management
        const ProfileManager = {
            activeTab: 'per',

            init() {
                this.initializeLucideIcons();
                this.addBackgroundPattern();
                this.updateTabDisplay();
            },

            setActiveTab(tab) {
                this.activeTab = tab;
                this.updateTabDisplay();
            },

            updateTabDisplay() {
                // Update tab buttons
                const perTab = document.getElementById('perTab');
                const pasTab = document.getElementById('pasTab');
                const perContent = document.getElementById('perContent');
                const pasContent = document.getElementById('pasContent');

                if (this.activeTab === 'per') {
                    // Activate personal tab
                    if (perTab) {
                        perTab.className = perTab.className.replace(/text-gray-300.*dark:text-gray-400/, 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400');
                        if (!perTab.className.includes('border-b-2')) {
                            perTab.className += ' border-b-2 border-blue-500 text-blue-600 dark:text-blue-400';
                        }
                    }
                    // Deactivate password tab
                    if (pasTab) {
                        pasTab.className = pasTab.className.replace(/border-b-2.*dark:text-blue-400/, 'text-gray-300 dark:text-gray-400');
                        if (!pasTab.className.includes('text-gray-300')) {
                            pasTab.className += ' text-gray-300 dark:text-gray-400';
                        }
                    }
                    // Show/hide content
                    if (perContent) {
                        perContent.style.display = 'block';
                        perContent.className = perContent.className.replace(/opacity-0/, 'opacity-100');
                    }
                    if (pasContent) {
                        pasContent.style.display = 'none';
                        pasContent.className = pasContent.className.replace(/opacity-100/, 'opacity-0');
                    }
                } else {
                    // Activate password tab
                    if (pasTab) {
                        pasTab.className = pasTab.className.replace(/text-gray-300.*dark:text-gray-400/, 'border-b-2 border-blue-500 text-blue-600 dark:text-blue-400');
                        if (!pasTab.className.includes('border-b-2')) {
                            pasTab.className += ' border-b-2 border-blue-500 text-blue-600 dark:text-blue-400';
                        }
                    }
                    // Deactivate personal tab
                    if (perTab) {
                        perTab.className = perTab.className.replace(/border-b-2.*dark:text-blue-400/, 'text-gray-300 dark:text-gray-400');
                        if (!perTab.className.includes('text-gray-300')) {
                            perTab.className += ' text-gray-300 dark:text-gray-400';
                        }
                    }
                    // Show/hide content
                    if (pasContent) {
                        pasContent.style.display = 'block';
                        pasContent.className = pasContent.className.replace(/opacity-0/, 'opacity-100');
                    }
                    if (perContent) {
                        perContent.style.display = 'none';
                        perContent.className = perContent.className.replace(/opacity-100/, 'opacity-0');
                    }
                }
            },


            addBackgroundPattern() {
                const style = document.createElement('style');
                style.textContent = `
                    .bg-pattern {
                        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
                    }
                `;
                document.head.appendChild(style);
            }
        };

        // Global function for onclick handlers
        function setActiveTab(tab) {
            ProfileManager.setActiveTab(tab);
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            ProfileManager.init();
        });
    </script>
@endsection
