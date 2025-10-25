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
@extends('layouts.admin', ['title' => 'Uygulama Ayarları'])

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-admin-900 dark:via-admin-800 dark:to-admin-900">
            <!-- Header Section -->
        <div class="bg-white dark:bg-admin-800 border-b border-gray-200 dark:border-admin-700 shadow-sm">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg">
                            <i data-lucide="settings" class="w-8 h-8 text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Uygulama Ayarları</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Sistem yapılandırması ve tercihlerini yönetin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                <x-danger-alert />
                <x-success-alert />
                @if (count($errors) > 0)
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Aşağıdaki hatalar oluştu:</h3>
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
            <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-xl border border-gray-200 dark:border-admin-700 overflow-hidden">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200 dark:border-admin-600 bg-gradient-to-r from-gray-50 to-white dark:from-admin-700 dark:to-admin-800">
                        <nav class="flex flex-wrap" x-data="{ activeTab: 'info' }">
                        <button @click="activeTab = 'module'" :class="{ 'border-blue-500 text-blue-600 bg-blue-50 dark:bg-blue-900': activeTab === 'module', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300': activeTab !== 'module' }" class="flex-1 min-w-0 py-4 px-6 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-blue-600">
                            <div class="flex items-center justify-center space-x-2">
                                <i data-lucide="grid-3x3" class="w-5 h-5"></i>
                                <span>Modül</span>
                            </div>
                        </button>
                            
                        <button @click="activeTab = 'info'" :class="{ 'border-blue-500 text-blue-600 bg-blue-50 dark:bg-blue-900': activeTab === 'info', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300': activeTab !== 'info' }" class="flex-1 min-w-0 py-4 px-6 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-blue-600">
                            <div class="flex items-center justify-center space-x-2">
                                <i data-lucide="info" class="w-5 h-5"></i>
                                <span>Site Bilgileri</span>
                            </div>
                        </button>
                            
                            <button @click="activeTab = 'pref'" :class="{ 'border-blue-500 text-blue-600 bg-blue-50': activeTab === 'pref', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'pref' }" class="flex-1 min-w-0 py-4 px-6 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-blue-600">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Tercihler</span>
                                </div>
                            </button>
                            
                            <button @click="activeTab = 'email'" :class="{ 'border-blue-500 text-blue-600 bg-blue-50': activeTab === 'email', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'email' }" class="flex-1 min-w-0 py-4 px-6 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-blue-600">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                    <span>E-posta/Google</span>
                                </div>
                            </button>
                            
                            <button @click="activeTab = 'display'" :class="{ 'border-blue-500 text-blue-600 bg-blue-50': activeTab === 'display', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'display' }" class="flex-1 min-w-0 py-4 px-6 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-blue-600">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H4zm12 12H4v-5h12v5z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Tema/Görünüm</span>
                                </div>
                            </button>
                        </nav>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="p-6 sm:p-8 lg:p-10" x-data="{ activeTab: 'info' }">
                        <!-- Module Tab -->
                        <div x-show="activeTab === 'module'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">
                            {{-- <livewire:admin.software-module /> --}}
                            <div class="p-4 bg-yellow-100 border border-yellow-300 rounded-lg">
                                <p class="text-yellow-800">Modül bileşeni geçici olarak devre dışı bırakıldı.</p>
                            </div>
                        </div>
                        
                        <!-- Website Information Tab -->
                        <div x-show="activeTab === 'info'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">
                            @include('admin.Settings.AppSettings.webinfo')
                        </div>
                        
                        <!-- Preferences Tab -->
                        <div x-show="activeTab === 'pref'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">
                            @include('admin.Settings.AppSettings.webpreference')
                        </div>
                        
                        <!-- Email/Google Tab -->
                        <div x-show="activeTab === 'email'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">
                            @include('admin.Settings.AppSettings.email')
                        </div>
                        
                        <!-- Theme/Display Tab -->
                        <div x-show="activeTab === 'display'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">
                            @include('admin.Settings.AppSettings.theme')
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
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
                console.log('Currency changed to:', selected);
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
                        showNotification('success', 'Başarılı', result.success);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('error', 'Hata', 'Bir hata oluştu');
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
                        showNotification('success', 'Başarılı', result.success);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('error', 'Hata', 'Bir hata oluştu');
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