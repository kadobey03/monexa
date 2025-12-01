@extends('layouts.master', ['layoutType' => 'guest'])
@section('title', __('auth.login.title'))
@section('content')

<div class="w-full max-w-md">
    <!-- Status Alert -->
    @if (Session::has('status'))
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-xl">
            <div class="flex items-center gap-3">
                <x-heroicon name="information-circle" class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                <div class="text-sm text-blue-800 dark:text-blue-200">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    <!-- Login Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl ring-1 ring-gray-200 dark:ring-gray-700 p-8">
        <div class="text-center mb-8">
            <!-- Logo -->
            @if($settings && $settings->logo)
                <img src="{{ asset('storage/'.$settings->logo)}}"
                     class="h-16 w-auto mx-auto mb-4"
                     alt="{{ $settings->site_name ?? 'Site Logo' }}" />
            @else
                <div class="h-16 w-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-white font-bold text-xl">{{ substr($settings->site_name ?? 'M', 0, 1) }}</span>
                </div>
            @endif

            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                {{ __('auth.login.welcome') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                {{ __('auth.login.login_to_platform', ['site_name' => $settings->site_name ?? 'Monexa']) }}
            </p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl">
                <div class="flex items-start gap-3">
                    <x-heroicon name="exclamation-circle" class="h-5 w-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" />
                    <div class="text-sm text-red-800 dark:text-red-200">
                        @if ($errors->count() === 1)
                            {!! $errors->first() !!}
                        @else
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{!! $error !!}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Session Error Messages (fallback for production issues) -->
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl">
                <div class="flex items-center gap-3">
                    <x-heroicon name="exclamation-circle" class="h-5 w-5 text-red-600 dark:text-red-400" />
                    <div class="text-sm text-red-800 dark:text-red-200">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        @endif

        <!-- Success Message (Hidden by default) -->
        <div id="success-message" class="hidden mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-xl">
            <div class="flex items-center gap-3">
                <x-heroicon name="check-circle" class="h-5 w-5 text-green-600 dark:text-green-400" />
                <div class="text-sm text-green-800 dark:text-green-200">
                    <div id="success-text"></div>
                    <div class="text-xs mt-1 opacity-75">{{ __('auth.login.redirecting_message') }}</div>
                </div>
            </div>
        </div>

        <!-- Ajax Error Message Container (Hidden by default) -->
        <div id="ajax-error-message" class="hidden mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl">
            <div class="flex items-start gap-3">
                <x-heroicon name="exclamation-circle" class="h-5 w-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" />
                <div class="text-sm text-red-800 dark:text-red-200">
                    <div id="ajax-error-text"></div>
                </div>
            </div>
        </div>

        <!-- Login Form -->
        <form id="login-form" action="{{ route('login') }}" method="post" class="space-y-6">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('auth.forms.email_address') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon name="envelope" class="h-5 w-5 text-gray-400" />
                    </div>
                    <input type="email" name="email" id="email" required
                           autocomplete="email"
                           class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="{{ __('auth.forms.email_placeholder') }}"
                           value="{{ old('email') }}">
                </div>
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('auth.forms.password') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon name="lock-closed" class="h-5 w-5 text-gray-400" />
                    </div>
                    <input type="password" name="password" id="password" required
                           autocomplete="current-password"
                           class="block w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="{{ __('auth.forms.password_placeholder') }}">
                    <button type="button" onclick="togglePasswordVisibility('password')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <x-heroicon name="eye" class="h-5 w-5" id="password-eye" />
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('auth.login.remember_me') }}
                    </label>
                </div>
                <a href="{{ route('password.request') }}"
                   class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                    {{ __('auth.login.forgot_password') }}
                </a>
            </div>

            <!-- Login Button -->
            <button type="submit" id="login-btn"
                    class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <x-heroicon name="arrow-right-on-rectangle" class="h-4 w-4" id="login-icon" />
                <span class="hidden animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full" id="loading-spinner"></span>
                <span id="login-text">{{ __('auth.login.login_button') }}</span>
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('auth.login.no_account') }}
                <a href="{{ route('register') }}"
                   class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                    {{ __('auth.login.register_link') }}
                </a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const eye = document.getElementById(fieldId + '-eye');
        
        if (field.type === 'password') {
            field.type = 'text';
            // Heroicon: eye icon changed to eye-slash;
        } else {
            field.type = 'password';
            // Heroicon: eye icon changed to eye;
        }
    }

    function showSuccessMessage(message) {
        const successDiv = document.getElementById('success-message');
        const successText = document.getElementById('success-text');
        const errorDivs = document.querySelectorAll('[class*="bg-red-50"]');
        
        // Hide any existing error messages
        errorDivs.forEach(div => div.classList.add('hidden'));
        
        // Show success message
        successText.innerHTML = message;
        successDiv.classList.remove('hidden');
        
        // Scroll to top to show message
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function clearErrorMessages() {
        // Hide all error containers
        const ajaxErrorDiv = document.getElementById('ajax-error-message');
        const serverErrorDivs = document.querySelectorAll('[class*="bg-red-50"]');
        
        ajaxErrorDiv.classList.add('hidden');
        serverErrorDivs.forEach(div => {
            if (div.id !== 'ajax-error-message') {
                div.classList.add('hidden');
            }
        });
    }

    function showErrorMessages(errors) {
        // Hide success message
        const successDiv = document.getElementById('success-message');
        const ajaxErrorDiv = document.getElementById('ajax-error-message');
        const ajaxErrorText = document.getElementById('ajax-error-text');
        
        successDiv.classList.add('hidden');
        
        // Build error messages HTML
        let errorHtml = '';
        
        if (typeof errors === 'object' && errors !== null) {
            const errorCount = Object.keys(errors).length;
            
            if (errorCount === 1) {
                // Single error
                const fieldErrors = Object.values(errors)[0];
                if (Array.isArray(fieldErrors) && fieldErrors.length > 0) {
                    errorHtml = fieldErrors[0];
                }
            } else {
                // Multiple errors
                errorHtml = '<ul class="list-disc list-inside space-y-1">';
                Object.values(errors).forEach(fieldErrors => {
                    if (Array.isArray(fieldErrors)) {
                        fieldErrors.forEach(error => {
                            errorHtml += `<li>${error}</li>`;
                        });
                    }
                });
                errorHtml += '</ul>';
            }
        } else if (typeof errors === 'string') {
            errorHtml = errors;
        }
        
        // Show error message
        ajaxErrorText.innerHTML = errorHtml;
        ajaxErrorDiv.classList.remove('hidden');
        
        // Scroll to top to show error
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function setLoadingState(isLoading) {
        const btn = document.getElementById('login-btn');
        const icon = document.getElementById('login-icon');
        const spinner = document.getElementById('loading-spinner');
        const text = document.getElementById('login-text');
        
        if (isLoading) {
            btn.disabled = true;
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');
            text.textContent = '{{ __("auth.login.loading_text") }}';
        } else {
            btn.disabled = false;
            icon.classList.remove('hidden');
            spinner.classList.add('hidden');
            text.textContent = '{{ __("auth.login.login_button") }}';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Auto focus email field
        const emailField = document.getElementById('email');
        if (emailField) {
            emailField.focus();
        }

        // Ajax form submission
        const form = document.getElementById('login-form');
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Clear previous error messages
            clearErrorMessages();
            setLoadingState(true);
            
            const formData = new FormData(form);
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    // Success - show message and redirect after 3 seconds
                    showSuccessMessage(data.message);
                    
                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 3000);
                } else {
                    // Handle errors
                    setLoadingState(false);
                    if (data && data.errors) {
                        showErrorMessages(data.errors);
                    } else if (data && data.message) {
                        showErrorMessages({ general: [data.message] });
                    } else {
                        showErrorMessages({ general: ['{{ __("auth.ajax.general_error") }}'] });
                    }
                }
            } catch (error) {
                console.error('Login error:', error);
                setLoadingState(false);
                showErrorMessages({ general: ['{{ __("auth.ajax.connection_error") }}'] });
            }
        });
    });
</script>

@endsection
