<div class="w-full space-y-8">
    <form method="post" action="{{ route('updatewebinfo') }}" id="appinfoform" enctype="multipart/form-data" class="space-y-8">
        @method('PUT')
        @csrf
        
        <!-- Website Basic Information -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 11-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('admin.settings.app.webinfo.basic_info') }}</h2>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.website_name') }}</label>
                    <input type="text" name="site_name" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->site_name }}" required>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.website_title') }}</label>
                    <input type="text" name="site_title" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->site_title }}" required>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.website_keywords') }}</label>
                    <input type="text" name="keywords" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->keywords }}" required>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.website_url') }}</label>
                    <input type="url" placeholder="https://yoursite.com" name="site_address" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->site_address }}" required>
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.website_description') }}</label>
                <textarea name="description" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" rows="4" placeholder="{{ __('admin.settings.app.webinfo.description_placeholder') }}">{{ $settings->description }}</textarea>
            </div>
        </div>

        <!-- İletişim ve Mesajlar -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-6 border border-green-200 dark:border-green-800">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-green-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('admin.settings.app.webinfo.contact_announcements') }}</h2>
            </div>
            
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.site_announcement') }}</label>
                    <textarea name="update" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" rows="3" placeholder="{{ __('admin.settings.app.webinfo.announcement_placeholder') }}">{{ $settings->newupdate }}</textarea>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.welcome_message') }}</label>
                        <textarea name="welcome_message" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" rows="3" placeholder="{{ __('admin.settings.app.webinfo.welcome_message_placeholder') }}">{{ $settings->welcome_message }}</textarea>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.settings.app.webinfo.welcome_message_help') }}</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.whatsapp_number') }}</label>
                        <input name="whatsapp" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" type="tel" value="{{ $settings->whatsapp }}" placeholder="+90 555 555 55 55">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.tido_livechat_id') }}</label>
                        <input name="tido" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" type="text" value="{{ $settings->tido }}" placeholder="Tido ID'nizi girin">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.establishment_year') }}</label>
                        <input name="twak" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" type="number" value="{{ $settings->twak }}" placeholder="2024" min="1900" max="2030">
                    </div>
                </div>
            </div>
        </div>

        <!-- Trading ve Sistem Konfigürasyonu -->
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-purple-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zM14 6a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h10zM4 8a1 1 0 011-1h1a1 1 0 010 2H5a1 1 0 01-1-1zm5 1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('admin.settings.app.webinfo.trading_system_settings') }}</h2>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.trading_winrate') }}</label>
                    <input type="number" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 placeholder-gray-400" name="trading_winrate" placeholder="75" value="{{ $settings->trading_winrate }}" min="1" max="100">
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.settings.app.webinfo.trading_winrate_help') }}</p>
                </div>
                
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.timezone') }}</label>
                        <select name="timezone" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 select2">
                            <option value="{{ $settings->timezone }}">{{ $settings->timezone }}</option>
                            @foreach ($timezones as $list)
                                <option value="{{ $list }}">{{ $list }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.install_type') }}</label>
                        <select name="install_type" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                            <option value="{{ $settings->install_type }}">{{ $settings->install_type }}</option>
                            <option value="Main-Domain">{{ __('admin.settings.app.webinfo.main_domain') }}</option>
                            <option value="Sub-Domain">{{ __('admin.settings.app.webinfo.sub_domain') }}</option>
                            <option value="Sub-Folder">{{ __('admin.settings.app.webinfo.sub_folder') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logo ve Favicon Yükleme -->
        <div class="bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 rounded-xl p-6 border border-orange-200 dark:border-orange-800">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-orange-500 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('admin.settings.app.webinfo.visual_settings') }}</h2>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.website_logo') }}</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.settings.app.webinfo.logo_size_recommendation') }}</p>
                        <input name="logo" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" type="file" accept="image/*">
                    </div>
                    <div class="text-center border-2 border-dashed border-orange-200 dark:border-orange-700 p-6 rounded-xl bg-orange-50/50 dark:bg-orange-900/10">
                        @if($settings->logo)
                            <img src="{{ asset('storage/'.$settings->logo) }}" alt="Logo" class="max-w-48 max-h-24 mx-auto object-contain" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkxvZ28gTm90IEZvdW5kPC90ZXh0Pjwvc3ZnPg=='">
                        @else
                            <div class="text-gray-400 dark:text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-sm">{{ __('admin.settings.app.webinfo.logo_not_uploaded') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.webinfo.website_favicon') }}</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.settings.app.webinfo.favicon_size_recommendation') }}</p>
                        <input name="favicon" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" type="file" accept="image/*">
                    </div>
                    <div class="text-center border-2 border-dashed border-orange-200 dark:border-orange-700 p-6 rounded-xl bg-orange-50/50 dark:bg-orange-900/10">
                        @if($settings->favicon)
                            <img src="{{ asset('storage/'.$settings->favicon) }}" alt="Favicon" class="w-8 h-8 mx-auto" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iI2RkZCIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiIGZvbnQtc2l6ZT0iMTAiIGZpbGw9IiM5OTkiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5GYXZpY29uPC90ZXh0Pjwvc3ZnPg=='">
                        @else
                            <div class="text-gray-400 dark:text-gray-500">
                                <svg class="w-8 h-8 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-sm">{{ __('admin.settings.app.webinfo.favicon_not_uploaded') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Kaydet Butonu -->
        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ __('admin.settings.app.webinfo.save') }}
            </button>
        </div>

    </form>
</div>
