@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <div>
                <h1 class="text-2xl font-bold text-admin-900 dark:text-admin-100 mb-2">{{ __('admin.translations.title') }}</h1>
                <p class="text-admin-600 dark:text-admin-400">{{ __('admin.translations.description') }}</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Language Selector -->
                <div class="relative">
                    <select id="languageSelect" 
                            class="appearance-none bg-white dark:bg-admin-700 border border-admin-200 dark:border-admin-600 rounded-xl px-4 py-2.5 pr-10 text-admin-900 dark:text-admin-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                        @foreach($availableLanguages as $code => $name)
                            <option value="{{ $code }}" {{ $code === $currentLanguage ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    <x-heroicon name="chevron-down" class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-admin-400 pointer-events-none" />
                </div>
                
                @can('manage-translations')
                <!-- Add New Translation Button -->
                <button onclick="openAddModal()" 
                        class="flex items-center px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl transition-all duration-200 hover:shadow-md group">
                    <x-heroicon name="plus-circle" class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" />
                    {{ __('admin.translations.new_translation') }}
                </button>
                
                <!-- Import/Export Dropdown -->
                <div class="relative" id="importExportDropdown">
                    <button onclick="toggleDropdown('importExportDropdown')" 
                            class="flex items-center px-4 py-2.5 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 rounded-xl transition-all duration-200">
                        <x-heroicon name="arrows-up-down" class="w-4 h-4 mr-2" />
                        {{ __('admin.translations.import_export') }}
                        <x-heroicon name="chevron-down" class="w-3 h-3 ml-2" />
                    </button>
                    
                    <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-admin-800 rounded-xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 z-50 opacity-0 invisible transition-all" id="importExportDropdownContent">
                        <div class="p-2">
                            <button onclick="exportTranslations()" class="w-full flex items-center px-3 py-2 text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 rounded-lg transition-colors">
                                <x-heroicon name="arrow-down-tray" class="w-4 h-4 mr-3" />
                                {{ __('admin.translations.export') }}
                            </button>
                            <button onclick="openImportModal()" class="w-full flex items-center px-3 py-2 text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 rounded-lg transition-colors">
                                <x-heroicon name="arrow-up-tray" class="w-4 h-4 mr-3" />
                                {{ __('admin.translations.import') }}
                            </button>
                            <div class="border-t border-admin-200 dark:border-admin-700 my-2"></div>
                            <button onclick="clearCache()" class="w-full flex items-center px-3 py-2 text-orange-600 dark:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20 rounded-lg transition-colors">
                                <x-heroicon name="archive-box-x-mark" class="w-4 h-4 mr-3" />
                                {{ __('admin.translations.clear_cache') }}
                            </button>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
    
    <!-- Translation Statistics -->
    @if(isset($stats) && !empty($stats))
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                    <x-heroicon name="language" class="w-5 h-5" />
                </div>
                <span class="text-2xl font-bold">{{ $stats['total_phrases'] ?? 0 }}</span>
            </div>
            <p class="text-blue-100 text-sm font-medium">{{ __('admin.translations.stats.total_phrases') }}</p>
        </div>
        
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                    <x-heroicon name="check-circle" class="w-5 h-5" />
                </div>
                <span class="text-2xl font-bold">{{ $stats['translated_phrases'] ?? 0 }}</span>
            </div>
            <p class="text-emerald-100 text-sm font-medium">{{ __('admin.translations.stats.translated') }}</p>
        </div>
        
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                    <x-heroicon name="exclamation-triangle" class="w-5 h-5" />
                </div>
                <span class="text-2xl font-bold">{{ $stats['untranslated_phrases'] ?? 0 }}</span>
            </div>
            <p class="text-amber-100 text-sm font-medium">{{ __('admin.translations.stats.untranslated') }}</p>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                    <x-heroicon name="eye" class="w-5 h-5" />
                </div>
                <span class="text-2xl font-bold">{{ $stats['needs_review'] ?? 0 }}</span>
            </div>
            <p class="text-purple-100 text-sm font-medium">{{ __('admin.translations.stats.needs_review') }}</p>
        </div>
    </div>
    
    <!-- Progress Bar -->
    @if(isset($stats['completion_percentage']))
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 p-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-admin-700 dark:text-admin-300">{{ __('admin.translations.completion_rate') }}</span>
            <span class="text-sm font-bold text-admin-900 dark:text-admin-100">{{ $stats['completion_percentage'] }}%</span>
        </div>
        <div class="w-full bg-admin-200 dark:bg-admin-700 rounded-full h-3">
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-3 rounded-full transition-all duration-300" 
                 style="width: {{ $stats['completion_percentage'] }}%"></div>
        </div>
    </div>
    @endif
    @endif
    
    <!-- Search and Filters -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 p-6">
        <form method="GET" action="{{ route('admin.phrases') }}" id="filterForm" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            <!-- Search -->
            <div class="lg:col-span-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon name="magnifying-glass" class="w-4 h-4 text-admin-400" />
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}"
                           placeholder="{{ __('admin.translations.search_placeholder') }}"
                           class="w-full pl-10 pr-4 py-2.5 bg-admin-50 dark:bg-admin-700/50 border border-admin-200 dark:border-admin-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-admin-900 dark:text-admin-100 transition-all">
                </div>
            </div>
            
            <!-- Group Filter -->
            <div>
                <select name="group" class="w-full px-4 py-2.5 bg-admin-50 dark:bg-admin-700/50 border border-admin-200 dark:border-admin-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-admin-900 dark:text-admin-100 transition-all">
                    <option value="">{{ __('admin.translations.filters.all_groups') }}</option>
                    @foreach($groups as $group)
                        <option value="{{ $group }}" {{ $selectedGroup === $group ? 'selected' : '' }}>
                            {{ ucfirst($group) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Status Filter -->
            <div>
                <select name="status" class="w-full px-4 py-2.5 bg-admin-50 dark:bg-admin-700/50 border border-admin-200 dark:border-admin-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-admin-900 dark:text-admin-100 transition-all">
                    <option value="">{{ __('admin.translations.filters.all_statuses') }}</option>
                    <option value="translated" {{ $selectedStatus === 'translated' ? 'selected' : '' }}>{{ __('admin.translations.filters.translated') }}</option>
                    <option value="untranslated" {{ $selectedStatus === 'untranslated' ? 'selected' : '' }}>{{ __('admin.translations.filters.untranslated') }}</option>
                    <option value="needs_review" {{ $selectedStatus === 'needs_review' ? 'selected' : '' }}>{{ __('admin.translations.filters.needs_review') }}</option>
                </select>
            </div>
            
            <!-- Per Page -->
            <div>
                <select name="per_page" class="w-full px-4 py-2.5 bg-admin-50 dark:bg-admin-700/50 border border-admin-200 dark:border-admin-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-admin-900 dark:text-admin-100 transition-all">
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15 {{ __('admin.translations.per_page') }}</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 {{ __('admin.translations.per_page') }}</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 {{ __('admin.translations.per_page') }}</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 {{ __('admin.translations.per_page') }}</option>
                </select>
            </div>
            
            <!-- Filter Actions -->
            <div class="flex items-center space-x-2">
                <button type="submit" 
                        class="flex items-center px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl transition-all duration-200">
                    <x-heroicon name="funnel" class="w-4 h-4 mr-2" />
                    {{ __('admin.translations.filter_button') }}
                </button>
                <a href="{{ route('admin.phrases') }}" 
                   class="flex items-center px-4 py-2.5 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 rounded-xl transition-all duration-200">
                    <x-heroicon name="x-mark" class="w-4 h-4" />
                </a>
            </div>
            
            <input type="hidden" name="language" value="{{ $currentLanguage }}">
        </form>
    </div>
    
    <!-- Translations Table -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-admin-200 dark:border-admin-700 bg-admin-50 dark:bg-admin-900/30">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @can('manage-translations')
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="selectAll" 
                               onchange="toggleSelectAll()"
                               class="w-4 h-4 text-primary-600 bg-admin-100 border-admin-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-admin-800 focus:ring-2 dark:bg-admin-700 dark:border-admin-600">
                        <label for="selectAll" class="ml-2 text-sm font-medium text-admin-700 dark:text-admin-300">{{ __('admin.translations.select_all') }}</label>
                    </div>
                    @endcan
                    
                    <span class="text-sm text-admin-600 dark:text-admin-400">
                        {{ $phrases->total() }} {{ __('admin.translations.translations_found') }}
                    </span>
                </div>
                
                @can('manage-translations')
                <div id="bulkActions" class="hidden flex items-center space-x-2">
                    <span class="text-sm text-admin-600 dark:text-admin-400">{{ __('admin.translations.selected_items') }}</span>
                    <button onclick="bulkDelete()" 
                            class="flex items-center px-3 py-1.5 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors text-sm">
                        <x-heroicon name="trash" class="w-3 h-3 mr-1" />
                        {{ __('admin.translations.bulk.delete') }}
                    </button>
                    <button onclick="bulkExport()" 
                            class="flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors text-sm">
                        <x-heroicon name="arrow-down-tray" class="w-3 h-3 mr-1" />
                        {{ __('admin.translations.bulk.export') }}
                    </button>
                </div>
                @endcan
            </div>
        </div>
        
        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-admin-50 dark:bg-admin-900/20 border-b border-admin-200 dark:border-admin-700">
                    <tr>
                        @can('manage-translations')
                        <th class="w-12 px-6 py-3"></th>
                        @endcan
                        <th class="text-left px-6 py-3 text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.translations.table.key') }}</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.translations.table.translation') }}</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.translations.table.group') }}</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.translations.table.status') }}</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.translations.table.last_update') }}</th>
                        @can('manage-translations')
                        <th class="text-right px-6 py-3 text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.translations.table.actions') }}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-200 dark:divide-admin-700">
                    @forelse($phrases as $phrase)
                        @php
                            $translation = $phrase->translations->first();
                            $hasTranslation = !is_null($translation);
                            $needsReview = $hasTranslation && $translation->needs_update;
                        @endphp
                        <tr class="hover:bg-admin-50 dark:hover:bg-admin-700/30 transition-colors group" data-phrase-id="{{ $phrase->id }}">
                            @can('manage-translations')
                            <td class="px-6 py-4">
                                <input type="checkbox" 
                                       name="selected_phrases[]" 
                                       value="{{ $phrase->id }}"
                                       class="phrase-checkbox w-4 h-4 text-primary-600 bg-admin-100 border-admin-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-admin-800 focus:ring-2 dark:bg-admin-700 dark:border-admin-600">
                            </td>
                            @endcan
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <code class="text-sm font-mono bg-admin-100 dark:bg-admin-700 px-2 py-1 rounded text-admin-800 dark:text-admin-200">
                                        {{ $phrase->key }}
                                    </code>
                                    @if($phrase->description)
                                        <div class="ml-2 group/tooltip relative">
                                            <x-heroicon name="information-circle" class="w-4 h-4 text-admin-400 hover:text-admin-600 dark:hover:text-admin-300" />
                                            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 px-3 py-2 bg-admin-900 text-white text-xs rounded-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all whitespace-nowrap z-10">
                                                {{ $phrase->description }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="px-6 py-4">
                                @if($hasTranslation)
                                    @can('manage-translations')
                                    <div class="editable-field" 
                                         data-key="{{ $phrase->key }}" 
                                         data-language="{{ $currentLanguage }}"
                                         data-original="{{ $translation->translation }}">
                                        <div class="view-mode">
                                            <span class="text-admin-900 dark:text-admin-100">{{ $translation->translation }}</span>
                                            <button class="ml-2 opacity-0 group-hover:opacity-100 transition-opacity" onclick="editTranslation(this)">
                                                <x-heroicon name="pencil-square" class="w-4 h-4 text-admin-400 hover:text-primary-600" />
                                            </button>
                                        </div>
                                        <div class="edit-mode hidden">
                                            <div class="flex items-center space-x-2">
                                                <input type="text"
                                                       value="{{ $translation->translation }}"
                                                       class="flex-1 px-3 py-2 bg-admin-50 dark:bg-admin-700 border border-admin-200 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-admin-900 dark:text-admin-100">
                                                <button onclick="saveTranslation(this)" class="px-3 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                                    <x-heroicon name="check" class="w-4 h-4" />
                                                </button>
                                                <button onclick="cancelEdit(this)" class="px-3 py-2 bg-admin-400 text-white rounded-lg hover:bg-admin-500 transition-colors">
                                                    <x-heroicon name="x-mark" class="w-4 h-4" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <span class="text-admin-900 dark:text-admin-100">{{ $translation->translation }}</span>
                                    @endcan
                                @else
                                    <span class="text-admin-500 dark:text-admin-400 italic">{{ __('admin.translations.no_translation') }}</span>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-admin-100 dark:bg-admin-700 text-admin-800 dark:text-admin-200">
                                    {{ ucfirst($phrase->group) }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                @if($hasTranslation)
                                    @if($needsReview)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300">
                                            <x-heroicon name="clock" class="w-3 h-3 mr-1" />
                                            {{ __('admin.translations.status.needs_review') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300">
                                            <x-heroicon name="check-circle" class="w-3 h-3 mr-1" />
                                            {{ __('admin.translations.status.translated') }}
                                        </span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">
                                        <x-heroicon name="exclamation-circle" class="w-3 h-3 mr-1" />
                                        {{ __('admin.translations.status.untranslated') }}
                                    </span>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4">
                                @if($hasTranslation && $translation->updated_at)
                                    <div class="text-sm text-admin-500 dark:text-admin-400">
                                        {{ $translation->updated_at->diffForHumans() }}
                                        @if($translation->approved_by)
                                            <div class="text-xs text-admin-400 dark:text-admin-500 mt-1">
                                                {{ __('admin.translations.admin_prefix') }} {{ $translation->approver->firstName ?? __('admin.translations.system') }}
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-admin-400 dark:text-admin-500">-</span>
                                @endif
                            </td>
                            
                            @can('manage-translations')
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    @if(!$hasTranslation)
                                        <button onclick="quickTranslate('{{ $phrase->key }}', '{{ $currentLanguage }}')" 
                                                class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300" 
                                                title="Hızlı Çeviri">
                                            <x-heroicon name="plus-circle" class="w-4 h-4" />
                                        </button>
                                    @endif
                                    
                                    <button onclick="deleteTranslation('{{ $currentLanguage }}', '{{ $phrase->key }}')" 
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" 
                                            title="Sil">
                                        <x-heroicon name="trash" class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ can('manage-translations') ? '7' : '5' }}" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <x-heroicon name="language" class="w-12 h-12 text-admin-400 mb-4" />
                                    <h3 class="text-lg font-medium text-admin-900 dark:text-admin-100 mb-2">{{ __('admin.translations.empty.title') }}</h3>
                                    <p class="text-admin-500 dark:text-admin-400 mb-4">{{ __('admin.translations.empty.description') }}</p>
                                    @can('manage-translations')
                                    <button onclick="openAddModal()" 
                                            class="flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl transition-all duration-200">
                                        <x-heroicon name="plus-circle" class="w-4 h-4 mr-2" />
                                        {{ __('admin.translations.empty.add_first') }}
                                    </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($phrases->hasPages())
        <div class="px-6 py-4 border-t border-admin-200 dark:border-admin-700 bg-admin-50 dark:bg-admin-900/30">
            {{ $phrases->appends(request()->query())->links('pagination.custom-admin') }}
        </div>
        @endif
    </div>
</div>

@can('manage-translations')
<!-- Add Translation Modal -->
<div id="addModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-admin-500 opacity-75"></div>
        </div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-2xl text-left overflow-hidden shadow-elegant dark:shadow-glass-dark transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form id="addTranslationForm">
                <div class="px-6 py-4 border-b border-admin-200 dark:border-admin-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-admin-900 dark:text-admin-100">{{ __('admin.translations.new_translation') }}</h3>
                        <button type="button" onclick="closeAddModal()" class="text-admin-400 hover:text-admin-600 dark:hover:text-admin-300">
                            <x-heroicon name="x-mark" class="w-6 h-6" />
                        </button>
                    </div>
                </div>
                
                <div class="px-6 py-6 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.translations.form.key') }}</label>
                        <input type="text" 
                               name="key" 
                               required
                               placeholder="{{ __('admin.translations.form.key_placeholder') }}"
                               class="w-full px-4 py-2.5 bg-admin-50 dark:bg-admin-700/50 border border-admin-200 dark:border-admin-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-admin-900 dark:text-admin-100">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.translations.form.group') }}</label>
                            <select name="group" class="w-full px-4 py-2.5 bg-admin-50 dark:bg-admin-700/50 border border-admin-200 dark:border-admin-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-admin-900 dark:text-admin-100">
                                <option value="general">{{ __('admin.translations.groups.general') }}</option>
                                <option value="auth">{{ __('admin.translations.groups.auth') }}</option>
                                <option value="validation">{{ __('admin.translations.groups.validation') }}</option>
                                <option value="emails">{{ __('admin.translations.groups.emails') }}</option>
                                <option value="notifications">{{ __('admin.translations.groups.notifications') }}</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group }}">{{ ucfirst($group) }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.translations.form.language') }}</label>
                            <select name="language" class="w-full px-4 py-2.5 bg-admin-50 dark:bg-admin-700/50 border border-admin-200 dark:border-admin-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-admin-900 dark:text-admin-100">
                                @foreach($availableLanguages as $code => $name)
                                    <option value="{{ $code }}" {{ $code === $currentLanguage ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.translations.form.description') }}</label>
                        <input type="text" 
                               name="description" 
                               placeholder="{{ __('admin.translations.form.description_placeholder') }}"
                               class="w-full px-4 py-2.5 bg-admin-50 dark:bg-admin-700/50 border border-admin-200 dark:border-admin-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-admin-900 dark:text-admin-100">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.translations.form.translation') }}</label>
                        <textarea name="value" 
                                  rows="3" 
                                  required
                                  placeholder="{{ __('admin.translations.form.translation_placeholder') }}"
                                  class="w-full px-4 py-2.5 bg-admin-50 dark:bg-admin-700/50 border border-admin-200 dark:border-admin-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-admin-900 dark:text-admin-100 resize-none"></textarea>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-admin-50 dark:bg-admin-900/30 border-t border-admin-200 dark:border-admin-700 flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeAddModal()" 
                            class="px-4 py-2 bg-admin-200 dark:bg-admin-700 text-admin-700 dark:text-admin-300 rounded-xl hover:bg-admin-300 dark:hover:bg-admin-600 transition-colors">
                        {{ __('admin.translations.form.cancel') }}
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl transition-colors">
                        {{ __('admin.translations.form.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Translation Modal -->
<div id="quickTranslateModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-admin-500 opacity-75"></div>
        </div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-2xl text-left overflow-hidden shadow-elegant dark:shadow-glass-dark transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="quickTranslateForm">
                <div class="px-6 py-4 border-b border-admin-200 dark:border-admin-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-admin-900 dark:text-admin-100">{{ __('admin.translations.modal.quick.title') }}</h3>
                        <button type="button" onclick="closeQuickTranslateModal()" class="text-admin-400 hover:text-admin-600 dark:hover:text-admin-300">
                            <x-heroicon name="x-mark" class="w-6 h-6" />
                        </button>
                    </div>
                </div>
                
                <div class="px-6 py-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.translations.form.key') }}</label>
                        <code id="quickKey" class="block w-full px-4 py-2.5 bg-admin-100 dark:bg-admin-700 border border-admin-200 dark:border-admin-600 rounded-xl text-admin-900 dark:text-admin-100 font-mono text-sm"></code>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.translations.form.translation') }}</label>
                        <textarea name="value" 
                                  rows="3" 
                                  required
                                  placeholder="{{ __('admin.translations.form.translation_placeholder') }}"
                                  class="w-full px-4 py-2.5 bg-admin-50 dark:bg-admin-700/50 border border-admin-200 dark:border-admin-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-admin-900 dark:text-admin-100 resize-none"></textarea>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-admin-50 dark:bg-admin-900/30 border-t border-admin-200 dark:border-admin-700 flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeQuickTranslateModal()" 
                            class="px-4 py-2 bg-admin-200 dark:bg-admin-700 text-admin-700 dark:text-admin-300 rounded-xl hover:bg-admin-300 dark:hover:bg-admin-600 transition-colors">
                        {{ __('admin.translations.form.cancel') }}
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-colors">
                        {{ __('admin.translations.form.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Language selector change
    document.getElementById('languageSelect').addEventListener('change', function() {
        const url = new URL(window.location);
        url.searchParams.set('language', this.value);
        url.searchParams.delete('page'); // Reset pagination
        window.location.href = url.toString();
    });
    
    // Auto-submit filters
    const filterForm = document.getElementById('filterForm');
    const filterInputs = filterForm.querySelectorAll('select[name="group"], select[name="status"], select[name="per_page"]');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', () => {
            filterForm.submit();
        });
    });
});

// Modal functions
function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    document.getElementById('addTranslationForm').reset();
}

function openQuickTranslateModal() {
    document.getElementById('quickTranslateModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeQuickTranslateModal() {
    document.getElementById('quickTranslateModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    document.getElementById('quickTranslateForm').reset();
}

// Quick translate function
function quickTranslate(key, language) {
    document.getElementById('quickKey').textContent = key;
    document.getElementById('quickTranslateForm').onsubmit = function(e) {
        e.preventDefault();
        submitQuickTranslation(key, language, this.value.value);
    };
    openQuickTranslateModal();
}

// Dropdown functions
function toggleDropdown(dropdownId) {
    const content = document.getElementById(dropdownId + 'Content');
    const isVisible = !content.classList.contains('invisible');
    
    if (isVisible) {
        content.classList.add('opacity-0', 'invisible');
    } else {
        content.classList.remove('opacity-0', 'invisible');
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    const dropdowns = document.querySelectorAll('[id$="DropdownContent"]');
    dropdowns.forEach(dropdown => {
        const button = dropdown.parentElement.querySelector('button');
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('opacity-0', 'invisible');
        }
    });
});

// Selection functions
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.phrase-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBulkActions();
}

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.phrase-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    
    if (checkedBoxes.length > 0) {
        bulkActions.classList.remove('hidden');
    } else {
        bulkActions.classList.add('hidden');
        document.getElementById('selectAll').checked = false;
    }
}

// Add event listeners to checkboxes
document.querySelectorAll('.phrase-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActions);
});

// Inline editing functions
function editTranslation(button) {
    const field = button.closest('.editable-field');
    const viewMode = field.querySelector('.view-mode');
    const editMode = field.querySelector('.edit-mode');
    
    viewMode.classList.add('hidden');
    editMode.classList.remove('hidden');
    editMode.querySelector('input').focus();
}

function cancelEdit(button) {
    const field = button.closest('.editable-field');
    const viewMode = field.querySelector('.view-mode');
    const editMode = field.querySelector('.edit-mode');
    const input = editMode.querySelector('input');
    
    input.value = field.dataset.original;
    editMode.classList.add('hidden');
    viewMode.classList.remove('hidden');
}

function saveTranslation(button) {
    const field = button.closest('.editable-field');
    const input = field.querySelector('input');
    const key = field.dataset.key;
    const language = field.dataset.language;
    const value = input.value;
    
    if (value.trim() === '') {
        alert('{{ __('admin.translations.notifications.empty_translation') }}');
        return;
    }
    
    // Show loading
    button.innerHTML = '<div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>';
    button.disabled = true;
    
    fetch(`/admin/dashboard/phrases/${key}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            translation: value,
            language_code: language
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update display
            field.querySelector('.view-mode span').textContent = value;
            field.dataset.original = value;
            
            // Hide edit mode
            cancelEdit(button);
            
            // Show success message
            showNotification('{{ __('admin.translations.notifications.updated') }}', 'success');
        } else {
            throw new Error(data.message || 'Bir hata oluştu');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || '{{ __('admin.translations.notifications.error') }}', 'error');
        cancelEdit(button);
    })
    .finally(() => {
        button.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
        button.disabled = false;
    });
}

// AJAX functions
function submitQuickTranslation(key, language, value) {
    if (value.trim() === '') {
        alert('{{ __('admin.translations.notifications.empty_translation') }}');
        return;
    }
    
    fetch(`/admin/dashboard/phrases/${key}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            translation: value,
            language_code: language
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeQuickTranslateModal();
            showNotification('{{ __('admin.translations.notifications.added') }}', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Bir hata oluştu');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || '{{ __('admin.translations.notifications.error') }}', 'error');
    });
}

function deleteTranslation(language, key) {
    if (!confirm('{{ __('admin.translations.notifications.confirm_delete') }}')) {
        return;
    }
    
    fetch(`/admin/dashboard/phrases/${language}/${encodeURIComponent(key)}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('{{ __('admin.translations.notifications.deleted') }}', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Bir hata oluştu');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || '{{ __('admin.translations.notifications.error') }}', 'error');
    });
}

// Add translation form submission
document.getElementById('addTranslationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    // Prepare translations array
    data.translations = [{
        language_id: data.language,
        translation: data.value
    }];
    delete data.language;
    delete data.value;
    
    fetch('{{ route('admin.phrases.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeAddModal();
            showNotification('{{ __('admin.translations.notifications.added') }}', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Bir hata oluştu');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || '{{ __('admin.translations.notifications.error') }}', 'error');
    });
});

// Utility functions
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-elegant transform transition-all duration-300 translate-x-full ${
        type === 'success' ? 'bg-emerald-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Animate out and remove
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Bulk operations
function bulkDelete() {
    const checkedBoxes = document.querySelectorAll('.phrase-checkbox:checked');
    if (checkedBoxes.length === 0) return;
    
    if (!confirm(`${checkedBoxes.length} {{ __('admin.translations.notifications.confirm_bulk_delete') }}`)) {
        return;
    }
    
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    
    // Implementation for bulk delete
    console.log('Bulk delete:', ids);
    showNotification('{{ __('admin.translations.notifications.bulk_delete_not_implemented') }}', 'info');
}

function bulkExport() {
    const checkedBoxes = document.querySelectorAll('.phrase-checkbox:checked');
    if (checkedBoxes.length === 0) return;
    
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    
    // Implementation for bulk export
    console.log('Bulk export:', ids);
    showNotification('{{ __('admin.translations.notifications.bulk_export_not_implemented') }}', 'info');
}

function exportTranslations() {
    // Implementation for export
    showNotification('{{ __('admin.translations.notifications.export_not_implemented') }}', 'info');
}

function clearCache() {
    if (!confirm('{{ __('admin.translations.notifications.confirm_cache_clear') }}')) {
        return;
    }
    
    // Implementation for cache clear
    showNotification('{{ __('admin.translations.notifications.cache_clear_not_implemented') }}', 'info');
}
</script>
@endpush