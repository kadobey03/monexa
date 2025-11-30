@extends('layouts.admin', ['title' => __('admin.agents.title')])

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-admin-900 dark:via-admin-800 dark:to-admin-900">
            <!-- Header Section -->
        <div class="bg-white dark:bg-admin-800 border-b border-gray-200 dark:border-admin-700 shadow-sm">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl shadow-lg">
                            <x-heroicon name="users" class="w-8 h-8 text-white" />
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('admin.agents.title') }}</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('admin.agents.description') }}</p>
                        </div>
                        </div>
                        
                        <!-- Add Agent Button -->
                        <button onclick="openAddModal()"
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <x-heroicon name="plus" class="w-5 h-5 mr-2" />
                            {{ __('admin.agents.add_agent') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                <x-danger-alert />
                <x-success-alert />
            </div>
            
            <!-- Statistics Cards -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Agents -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-orange-500 to-red-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-orange-100 text-sm font-medium">{{ __('admin.agents.total_agents') }}</p>
                                        <p class="text-2xl font-bold mt-1">{{ $agents->count() }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Referrals -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-blue-100 text-sm font-medium">{{ __('admin.agents.total_referrals') }}</p>
                                        <p class="text-2xl font-bold mt-1">{{ $agents->sum('total_refered') }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Average Performance -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-green-100 text-sm font-medium">{{ __('admin.agents.average_performance') }}</p>
                                        <p class="text-2xl font-bold mt-1">{{ $agents->count() > 0 ? number_format($agents->sum('total_refered') / $agents->count(), 1) : 0 }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Top Performer -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-purple-100 text-sm font-medium">{{ __('admin.agents.top_performance') }}</p>
                                        <p class="text-2xl font-bold mt-1">{{ $agents->max('total_refered') ?? 0 }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Table -->
            <div class="bg-white dark:bg-admin-800 rounded-xl shadow-lg border border-gray-200 dark:border-admin-700 overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-gray-50 to-orange-50 dark:from-admin-700 dark:to-admin-600 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 lg:mb-0">{{ __('admin.agents.agent_list') }}</h2>
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                <div class="relative">
                                <input type="text" id="searchInput" placeholder="{{ __('admin.agents.search_placeholder') }}"
                                       class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <x-heroicon name="magnifying-glass" class="absolute left-3 top-2.5 h-4 w-4 text-gray-400" />
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table Content -->
                    <div class="overflow-x-auto">
                        <table id="agentTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.agents.agent') }}</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.agents.referred_customers') }}</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.agents.performance') }}</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.agents.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($agents as $agent)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <!-- Agent Info -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-12 w-12 flex-shrink-0">
                                                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center">
                                                        <span class="text-lg font-bold text-white">{{ substr($agent->duser->name, 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-lg font-semibold text-gray-900">{{ $agent->duser->name }}</div>
                                                    <div class="text-sm text-gray-500 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                                        </svg>
                                                        {{ $agent->duser->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Referred Customers -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold bg-blue-100 text-blue-800">
                                                {{ $agent->total_refered }}
                                            </div>
                                        </td>
                                        
                                        <!-- Performance -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $maxReferrals = $agents->max('total_refered') ?: 1;
                                                $performance = ($agent->total_refered / $maxReferrals) * 100;
                                            @endphp
                                            
                                            <div class="flex items-center justify-center">
                                                <div class="w-20 bg-gray-200 rounded-full h-2 mr-3">
                                                    <div class="bg-gradient-to-r from-green-400 to-emerald-500 h-2 rounded-full transition-all duration-500" style="width: {{ $performance }}%"></div>
                                                </div>
                                                <span class="text-sm font-semibold text-gray-600">{{ number_format($performance, 0) }}%</span>
                                            </div>
                                            
                                            @if ($performance >= 80)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ __('admin.agents.performance_excellent') }}
                                                </span>
                                            @elseif ($performance >= 50)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ __('admin.agents.performance_good') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ __('admin.agents.performance_low') }}
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <button onclick="confirmDelete({{ $agent->id }}, '{{ $agent->duser->name }}')" 
                                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-600 bg-red-100 hover:bg-red-200 rounded-lg transition-colors duration-200"
                                                        title="{{ __('admin.agents.remove_title') }}">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ __('admin.agents.remove') }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('admin.agents.no_agents_yet') }}</h3>
                                                <p class="text-gray-500 mb-6">{{ __('admin.agents.add_first_agent') }}</p>
                                                <button onclick="openAddModal()" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ __('admin.agents.add_agent') }}
                                                </button>
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
    
    <!-- Add Agent Modal -->
    <div id="addAgentModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all scale-95">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 rounded-t-2xl text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold">{{ __('admin.agents.add_new_agent') }}</h3>
                    </div>
                    <button onclick="closeAddModal()"
                            class="text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/10">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6">
                <form method="post" action="{{ action('App\Http\Controllers\Admin\LogicController@addagent') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('admin.agents.select_user') }}
                        </label>
                        <select name="user" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200">
                            <option value="" disabled selected>{{ __('admin.agents.select_user_placeholder') }}</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('admin.agents.initial_referrals') }}
                        </label>
                        <input type="number"
                               name="referred_users"
                               min="0"
                               value="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                               placeholder="{{ __('admin.agents.referrals_placeholder') }}">
                        <p class="text-xs text-gray-500 mt-1">{{ __('admin.agents.initial_referrals_note') }}</p>
                    </div>
                    
                    <!-- Footer -->
                    <div class="flex space-x-3 pt-4">
                        <button type="submit"
                                class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                            <svg class="w-4 h-4 mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('admin.agents.add_agent') }}
                        </button>
                        <button type="button" onclick="closeAddModal()"
                                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                            {{ __('admin.agents.cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all scale-95">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-500 to-pink-600 p-6 rounded-t-2xl text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold">{{ __('admin.agents.remove_agent_title') }}</h3>
                    </div>
                    <button onclick="closeDeleteModal()"
                            class="text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/10">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6 text-center">
                <div class="mb-4">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2">{{ __('admin.agents.are_you_sure') }}</h4>
                    <p class="text-gray-600 mb-4">
                        <span id="agentNameToDelete" class="font-semibold"></span> {{ __('admin.agents.confirm_remove_message') }}
                    </p>
                    <p class="text-sm text-red-600">{{ __('admin.agents.action_irreversible') }}</p>
                </div>
                
                <!-- Footer -->
                <div class="flex space-x-3 pt-4">
                    <a id="deleteConfirmLink" href="#"
                       class="flex-1 bg-gradient-to-r from-red-500 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-red-600 hover:to-pink-700 transform hover:scale-105 transition-all duration-300 shadow-lg text-center">
                        <svg class="w-4 h-4 mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('admin.agents.yes_remove') }}
                    </a>
                    <button type="button" onclick="closeDeleteModal()"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        {{ __('admin.agents.cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#agentTable tbody tr');
            
            rows.forEach(row => {
                if (row.cells.length > 1) {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
        
        // Modal functions
        function openAddModal() {
            document.getElementById('addAgentModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => {
                const modal = document.querySelector('#addAgentModal .bg-white');
                if (modal) {
                    modal.classList.remove('scale-95');
                    modal.classList.add('scale-100');
                }
            }, 10);
        }
        
        function closeAddModal() {
            const modal = document.getElementById('addAgentModal');
            const modalContent = modal.querySelector('.bg-white');
            
            if (modalContent) {
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');
            }
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 200);
        }
        
        function confirmDelete(agentId, agentName) {
            document.getElementById('agentNameToDelete').textContent = agentName;
            document.getElementById('deleteConfirmLink').href = '{{ url("admin/dashboard/delagent") }}/' + agentId;
            
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => {
                const modal = document.querySelector('#deleteModal .bg-white');
                if (modal) {
                    modal.classList.remove('scale-95');
                    modal.classList.add('scale-100');
                }
            }, 10);
        }
        
        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = modal.querySelector('.bg-white');
            
            if (modalContent) {
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');
            }
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 200);
        }
        
        // Close modals on backdrop click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('backdrop-blur-sm')) {
                const modalId = e.target.id;
                if (modalId === 'addAgentModal') {
                    closeAddModal();
                } else if (modalId === 'deleteModal') {
                    closeDeleteModal();
                }
            }
        });
        
        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddModal();
                closeDeleteModal();
            }
        });
        
        console.log('Agent management page loaded successfully with Tailwind CSS');
    </script>
@endsection