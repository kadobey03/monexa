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
@extends('layouts.admin', ['title' => 'Ödeme Ayarları'])

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-admin-900 dark:via-admin-800 dark:to-admin-900">
        <!-- Header Section -->
        <div class="bg-white dark:bg-admin-800 border-b border-gray-200 dark:border-admin-700 shadow-sm">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Ödeme Ayarları</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Ödeme yöntemlerini ve tercihlerini yapılandırın</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        <div class="px-4 sm:px-6 lg:px-8 pt-4">
            <x-danger-alert />
            <x-success-alert />
        </div>

        <!-- Main Content -->
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-xl border border-gray-200 dark:border-admin-700 overflow-hidden" id="tabContainer">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200 dark:border-admin-600 bg-gradient-to-r from-gray-50 to-white dark:from-admin-700 dark:to-admin-800">
                    <nav class="flex flex-wrap -mb-px overflow-x-auto scrollbar-hide">
                        <button onclick="switchTab('methods')" data-tab="methods" class="tab-button active-tab flex-1 min-w-0 py-4 px-6 lg:px-8 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-emerald-600 whitespace-nowrap border-emerald-500 text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <span>Ödeme Yöntemleri</span>
                            </div>
                        </button>
                        
                        <button onclick="switchTab('preferences')" data-tab="preferences" class="tab-button flex-1 min-w-0 py-4 px-6 lg:px-8 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-emerald-600 whitespace-nowrap border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-admin-500">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Ödeme Tercihleri</span>
                            </div>
                        </button>
                        
                        <button onclick="switchTab('coinpayment')" data-tab="coinpayment" class="tab-button flex-1 min-w-0 py-4 px-6 lg:px-8 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-emerald-600 whitespace-nowrap border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-admin-500">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Coinpayment</span>
                            </div>
                        </button>
                        
                        <button onclick="switchTab('gateways')" data-tab="gateways" class="tab-button flex-1 min-w-0 py-4 px-6 lg:px-8 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-emerald-600 whitespace-nowrap border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-admin-500">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                <span>Gateway'ler</span>
                            </div>
                        </button>
                        
                        <button onclick="switchTab('transfer')" data-tab="transfer" class="tab-button flex-1 min-w-0 py-4 px-6 lg:px-8 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none focus:text-emerald-600 whitespace-nowrap border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-admin-500">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                <span>Transfer</span>
                            </div>
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-4 sm:p-6 lg:p-8 xl:p-10">
                    <!-- Payment Methods Tab -->
                    <div id="tab-methods" class="tab-content space-y-6">
                        @include('admin.Settings.PaymentSettings.deposit')
                    </div>
                    
                    <!-- Payment Preferences Tab -->
                    <div id="tab-preferences" class="tab-content hidden space-y-6">
                        @include('admin.Settings.PaymentSettings.withdrawal')
                    </div>
                    
                    <!-- Coinpayment Tab -->
                    <div id="tab-coinpayment" class="tab-content hidden space-y-6">
                        @include('admin.Settings.PaymentSettings.coinpayment')
                    </div>
                    
                    <!-- Gateways Tab -->
                    <div id="tab-gateways" class="tab-content hidden space-y-6">
                        @include('admin.Settings.PaymentSettings.gateway')
                    </div>
                    
                    <!-- Transfer Tab -->
                    <div id="tab-transfer" class="tab-content hidden space-y-6">
                        @include('admin.Settings.PaymentSettings.transfers')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Modern Vanilla JavaScript - No Alpine.js
        document.addEventListener('DOMContentLoaded', function() {
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
                    button.classList.remove('active-tab', 'border-emerald-500', 'text-emerald-600', 'bg-emerald-50', 'dark:bg-emerald-900/20');
                    button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-300', 'hover:border-gray-300', 'dark:hover:border-admin-500');
                });
                
                // Show selected tab content with animation
                const selectedContent = document.getElementById('tab-' + tabName);
                if (selectedContent) {
                    selectedContent.classList.remove('hidden');
                    selectedContent.style.opacity = '0';
                    selectedContent.style.transform = 'translateY(16px)';
                    
                    // Trigger animation
                    setTimeout(() => {
                        selectedContent.style.transition = 'all 0.3s ease-out';
                        selectedContent.style.opacity = '1';
                        selectedContent.style.transform = 'translateY(0)';
                    }, 10);
                }
                
                // Add active state to selected tab button
                const selectedButton = document.querySelector(`[data-tab="${tabName}"]`);
                if (selectedButton) {
                    selectedButton.classList.add('active-tab', 'border-emerald-500', 'text-emerald-600', 'bg-emerald-50', 'dark:bg-emerald-900/20');
                    selectedButton.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-300', 'hover:border-gray-300', 'dark:hover:border-admin-500');
                }
            }
            
            // Make switchTab available globally
            window.switchTab = switchTab;
            
            // Initialize tabs on page load
            switchTab('methods');
            
            // Payment preference form handler
            const paypreform = document.getElementById('paypreform');
            if (paypreform) {
                paypreform.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton ? submitButton.innerHTML : '';
                    
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = `
                            <span class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                İşleniyor...
                            </span>
                        `;
                    }
                    
                    try {
                        const formData = new FormData(this);
                        const response = await fetch("{{ route('paypreference') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        });
                        
                        const result = await response.json();
                        
                        if (result.status === 200) {
                            showNotification('success', 'Başarılı', result.success);
                        } else {
                            showNotification('error', 'Hata', result.message || 'Bir hata oluştu');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showNotification('error', 'Hata', 'Bağlantı hatası oluştu');
                    } finally {
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalText;
                        }
                    }
                });
            }

            // Coinpayment form handler
            const coinpayform = document.getElementById('coinpayform');
            if (coinpayform) {
                coinpayform.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton ? submitButton.innerHTML : '';
                    
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = `
                            <span class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                İşleniyor...
                            </span>
                        `;
                    }
                    
                    try {
                        const formData = new FormData(this);
                        const response = await fetch("{{ route('updatecpd') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        });
                        
                        const result = await response.json();
                        
                        if (result.status === 200) {
                            showNotification('success', 'Başarılı', result.success);
                        } else {
                            showNotification('error', 'Hata', result.message || 'Bir hata oluştu');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showNotification('error', 'Hata', 'Bağlantı hatası oluştu');
                    } finally {
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalText;
                        }
                    }
                });
            }

            // Gateway form handler
            const gatewayform = document.getElementById('gatewayform');
            if (gatewayform) {
                gatewayform.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton ? submitButton.innerHTML : '';
                    
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = `
                            <span class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                İşleniyor...
                            </span>
                        `;
                    }
                    
                    try {
                        const formData = new FormData(this);
                        const response = await fetch("{{ route('updategateway') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        });
                        
                        const result = await response.json();
                        
                        if (result.status === 200) {
                            showNotification('success', 'Başarılı', result.success);
                        } else {
                            showNotification('error', 'Hata', result.message || 'Bir hata oluştu');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showNotification('error', 'Hata', 'Bağlantı hatası oluştu');
                    } finally {
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalText;
                        }
                    }
                });
            }

            // Transfer form handler
            const trasfer = document.getElementById('trasfer');
            if (trasfer) {
                trasfer.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton ? submitButton.innerHTML : '';
                    
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = `
                            <span class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                İşleniyor...
                            </span>
                        `;
                    }
                    
                    try {
                        const formData = new FormData(this);
                        const response = await fetch("{{ route('updatetransfer') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        });
                        
                        const result = await response.json();
                        
                        if (result.status === 200) {
                            showNotification('success', 'Başarılı', result.success);
                        } else {
                            showNotification('error', 'Hata', result.message || 'Bir hata oluştu');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showNotification('error', 'Hata', 'Bağlantı hatası oluştu');
                    } finally {
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalText;
                        }
                    }
                });
            }
        });

        // Modern notification system
        function showNotification(type, title, message) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white max-w-md`;
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