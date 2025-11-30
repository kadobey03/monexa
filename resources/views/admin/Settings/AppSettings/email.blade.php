<div class="space-y-8">
    <!-- Email Configuration Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
        <div class="flex items-center space-x-3 mb-6">
            <div class="p-2 bg-blue-500 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('admin.settings.app.email.configuration') }}</h2>
        </div>
        
        <form action="javascript:void(0)" method="POST" id="emailform" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Mail Server Selection -->
            <div class="space-y-4">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.server_selection') }}</label>
                <div class="flex flex-wrap gap-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="server" id="sendmailserver" value="sendmail" class="w-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:ring-2" checked="">
                        <span class="ml-3 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">Sendmail</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="server" id="smtpserver" value="smtp" class="w-4 h-4 text-blue-600 bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:ring-2">
                        <span class="ml-3 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">SMTP</span>
                    </label>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.settings.app.email.sendmail_smtp_description') }}</p>
            </div>
            
            <!-- Basic Email Settings -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.sender_address') }}</label>
                    <input type="email" name="emailfrom" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->emailfrom }}" placeholder="noreply@example.com" required>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.sender_name') }}</label>
                    <input type="text" name="emailfromname" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->emailfromname }}" placeholder="Monexa Finans" required>
                </div>
            </div>
            
            <!-- SMTP Settings -->
            <div class="smtp hidden space-y-6">
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="ml-2 text-sm text-amber-800 dark:text-amber-200 font-medium">{{ __('admin.settings.app.email.smtp_server_settings') }}</p>
                    </div>
                    <p class="mt-2 text-xs text-amber-700 dark:text-amber-300">{{ __('admin.settings.app.email.smtp_providers_help') }}</p>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.smtp_host') }}</label>
                        <input type="text" name="smtp_host" class="smtp-input w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->smtp_host }}" placeholder="smtp.gmail.com">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.smtp_port') }}</label>
                        <input type="number" name="smtp_port" class="smtp-input w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->smtp_port }}" placeholder="587">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.encryption_type') }}</label>
                        <select name="smtp_encrypt" class="smtp-input w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="tls" {{ $settings->smtp_encrypt == 'tls' ? 'selected' : '' }}>{{ __('admin.settings.app.email.tls') }}</option>
                            <option value="ssl" {{ $settings->smtp_encrypt == 'ssl' ? 'selected' : '' }}>{{ __('admin.settings.app.email.ssl') }}</option>
                            <option value="" {{ $settings->smtp_encrypt == '' ? 'selected' : '' }}>{{ __('admin.settings.app.email.none') }}</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.smtp_username') }}</label>
                        <input type="text" name="smtp_user" class="smtp-input w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->smtp_user }}" placeholder="your-email@gmail.com">
                    </div>
                    <div class="lg:col-span-2 space-y-2">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.smtp_password') }}</label>
                        <input type="password" name="smtp_password" class="smtp-input w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->smtp_password }}" placeholder="Uygulama şifrenizi girin">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.settings.app.email.gmail_app_password_help') }}</p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Google Login Credentials Section -->
    <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-6 border border-red-200">
        <div class="flex items-center space-x-3 mb-4">
            <div class="p-2 bg-red-500 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900">{{ __('admin.settings.app.email.google_credentials') }}</h2>
        </div>
        <hr class="border-red-200 mb-6">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.google_client_id') }}</label>
                <input type="text" name="google_id" form="emailform" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->google_id }}" placeholder="123456789-abc.apps.googleusercontent.com">
                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
                    </svg>
                    {{ __('admin.settings.app.email.get_from_google_console') }}
                </p>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.google_client_secret') }}</label>
                <input type="password" name="google_secret" form="emailform" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->google_secret }}" placeholder="GOCSPX-abcdef...">
                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
                    </svg>
                    {{ __('admin.settings.app.email.get_from_google_console') }}
                </p>
            </div>
            <div class="lg:col-span-2 space-y-2">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.oauth_redirect_url') }}</label>
                <input type="url" name="google_redirect" form="emailform" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->google_redirect }}" placeholder="https://yourdomain.com/auth/google/callback">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                    <p class="text-xs text-blue-800 dark:text-blue-200 flex items-start">
                        <svg class="w-4 h-4 mr-1 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('admin.settings.app.email.oauth_redirect_help') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Captcha Credentials Section -->
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
        <div class="flex items-center space-x-3 mb-4">
            <div class="p-2 bg-green-500 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900">{{ __('admin.settings.app.email.google_captcha_credentials') }}</h2>
        </div>
        <hr class="border-green-200 mb-6">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.recaptcha_secret_key') }}</label>
                <input type="password" name="capt_secret" form="emailform" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->capt_secret }}" placeholder="6Ld...">
                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
                    </svg>
                    {{ __('admin.settings.app.email.get_from_recaptcha_panel') }}
                </p>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('admin.settings.app.email.recaptcha_site_key') }}</label>
                <input type="text" name="capt_sitekey" form="emailform" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 placeholder-gray-400" value="{{ $settings->capt_sitekey }}" placeholder="6Le...">
                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
                    </svg>
                    {{ __('admin.settings.app.email.get_from_recaptcha_panel') }}
                </p>
            </div>
        </div>
        
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 mb-6">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ __('admin.settings.app.email.recaptcha_setup_info') }}</h4>
                    <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">
                        <a href="https://www.google.com/recaptcha/admin/create" target="_blank" class="underline hover:text-blue-900 dark:hover:text-blue-100">
                            {{ __('admin.settings.app.email.google_recaptcha_admin_panel') }}
                        </a> {{ __('admin.settings.app.email.recaptcha_setup_instructions') }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" form="emailform" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                {{ __('admin.settings.app.email.save_settings') }}
            </button>
        </div>
    </div>
</div>

@if ($settings->mail_server == 'sendmail')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sendmailRadio = document.getElementById("sendmailserver");
            if (sendmailRadio) sendmailRadio.checked = true;
        });
    </script>
@else
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const smtpRadio = document.getElementById("smtpserver");
            if (smtpRadio) smtpRadio.checked = true;
        });
    </script>
@endif