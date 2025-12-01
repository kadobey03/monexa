<?php
$adminUser = Auth::guard('admin')->user();
if ($adminUser && $adminUser->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
?>
@extends('layouts.admin', ['title' => __('admin.settings.app.show.title')])

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-admin-900 dark:via-admin-800 dark:to-admin-900">
            <!-- Header Section -->
        <div class="bg-white dark:bg-admin-800 border-b border-gray-200 dark:border-admin-700 shadow-sm">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg">
                            <x-heroicon name="cog-6-tooth" class="w-8 h-8 text-white" />
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('admin.settings.app.show.header') }}</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('admin.settings.app.show.description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                @if (count($errors) > 0)
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">{{ __('admin.settings.app.show.errors_occurred') }}</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Main Settings Content -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-xl border border-gray-200 dark:border-admin-700 overflow-hidden" id="tabContainer">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200 dark:border-admin-600 bg-gradient-to-r from-gray-50 to-white dark:from-admin-700 dark:to-admin-800">
                        <nav class="flex flex-wrap -mb-px overflow-x-auto scrollbar-hide">
                        <button onclick="switchTab('info')" data-tab="info" class="tab-button active-tab flex-1 min-w-0 py-4 px-6 lg:px-8 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-blue-600 whitespace-nowrap border-blue-500 text-blue-600 bg-blue-50 dark:bg-blue-900/20">
                            <div class="flex items-center justify-center space-x-2">
                                <x-heroicon name="information-circle" class="w-5 h-5" />
                                <span>{{ __('admin.settings.app.show.site_information') }}</span>
                            </div>
                        </button>
                            
                            <button onclick="switchTab('pref')" data-tab="pref" class="tab-button flex-1 min-w-0 py-4 px-6 lg:px-8 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-blue-600 whitespace-nowrap border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-admin-500">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ __('admin.settings.app.show.preferences') }}</span>
                                </div>
                            </button>
                            
                            <button onclick="switchTab('email')" data-tab="email" class="tab-button flex-1 min-w-0 py-4 px-6 lg:px-8 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-blue-600 whitespace-nowrap border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-admin-500">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                    <span>{{ __('admin.settings.app.show.email_google') }}</span>
                                </div>
                            </button>
                        </nav>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="p-4 sm:p-6 lg:p-8 xl:p-10">
                        <!-- Website Information Tab -->
                        <div id="tab-info" class="tab-content space-y-6">
                            @include('admin.Settings.AppSettings.webinfo')
                        </div>
                        
                        <!-- Preferences Tab -->
                        <div id="tab-pref" class="tab-content hidden space-y-6">
                            @include('admin.Settings.AppSettings.webpreference')
                        </div>
                        
                        <!-- Email/Google Tab -->
                        <div id="tab-email" class="tab-content hidden space-y-6">
                            @include('admin.Settings.AppSettings.email')
                        </div>
                        
                    </div>
                </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Tab switching functionality - Vanilla JavaScript (No Alpine)
        function switchTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('active-tab', 'border-blue-500', 'text-blue-600', 'bg-blue-50', 'dark:bg-blue-900/20');
                button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-300', 'hover:border-gray-300', 'dark:hover:border-admin-500');
            });
            
            // Show selected tab content
            const selectedContent = document.getElementById('tab-' + tabName);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }
            
            // Add active state to selected tab button
            const selectedButton = document.querySelector(`[data-tab="${tabName}"]`);
            if (selectedButton) {
                selectedButton.classList.add('active-tab', 'border-blue-500', 'text-blue-600', 'bg-blue-50', 'dark:bg-blue-900/20');
                selectedButton.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-300', 'hover:border-gray-300', 'dark:hover:border-admin-500');
            }
        }
        
        // Initialize tabs on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set default active tab to 'info'
            switchTab('info');
        });
        
        // Select2 initialization if needed
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('.select2').select2();
        }
        
        // Theme form handling
        document.getElementById("themeForm")?.addEventListener('submit', function(){
            const themeBtn = document.getElementById("themeBtn");
            if (themeBtn) themeBtn.disabled = true;
            
            const loadingElement = document.getElementById("loadingTheme");
            if (loadingElement) loadingElement.classList.remove("hidden");
        });
        
        // Currency change handler
        function changecurr() {
            const selectElement = document.getElementById("select_c");
            const hiddenElement = document.getElementById("s_c");
            if (selectElement && hiddenElement) {
                const selected = selectElement.options[selectElement.selectedIndex].id;
                hiddenElement.value = selected;
                console.log('{{ __('admin.settings.app.show.currency_changed_to') }}:', selected);
            }
        }

        // AJAX form submissions with modern fetch API
        const updatepreference = document.getElementById('updatepreference');
        if (updatepreference) {
            updatepreference.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                try {
                    const formData = new FormData(this);
                    const response = await fetch("{{ route('updatepreference') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.status === 200) {
                        showNotification('success', '{{ __('admin.settings.app.show.success') }}', result.success);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('error', '{{ __('admin.settings.app.show.error') }}', '{{ __('admin.settings.app.show.error_occurred') }}');
                }
            });
        }

        const emailform = document.getElementById('emailform');
        if (emailform) {
            emailform.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                try {
                    const formData = new FormData(this);
                    const response = await fetch("{{ route('updateemailpreference') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.status === 200) {
                        showNotification('success', '{{ __('admin.settings.app.show.success') }}', result.success);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('error', '{{ __('admin.settings.app.show.error') }}', '{{ __('admin.settings.app.show.error_occurred') }}');
                }
            });
        }

        // SMTP form toggle functionality
        const sendmailRadio = document.querySelector('#sendmailserver');
        const smtpRadio = document.querySelector('#smtpserver');
        const smtpFields = document.querySelectorAll('.smtp');
        
        function toggleSmtpFields() {
            smtpFields.forEach(field => {
                if (smtpRadio && smtpRadio.checked) {
                    field.classList.remove('hidden');
                    const input = field.querySelector('input');
                    if (input) input.setAttribute('required', '');
                } else {
                    field.classList.add('hidden');
                    const input = field.querySelector('input');
                    if (input) input.removeAttribute('required');
                }
            });
        }
        
        if (sendmailRadio) sendmailRadio.addEventListener('click', toggleSmtpFields);
        if (smtpRadio) smtpRadio.addEventListener('click', toggleSmtpFields);
        
        // Initialize SMTP fields based on current selection
        if (smtpRadio && smtpRadio.checked) {
            toggleSmtpFields();
        }

        // Modern notification system
        function showNotification(type, title, message) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        ${type === 'success' ? 
                            '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>' :
                            '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>'
                        }
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium">${title}</h3>
                        <div class="mt-1 text-sm">${message}</div>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200 focus:outline-none">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.transform = 'translateX(100%)';
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 5000);
        }
    </script>
@endsection