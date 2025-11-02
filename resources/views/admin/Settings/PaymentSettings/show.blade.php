@extends('layouts.admin', ['title' => 'Ödeme Ayarları'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                <i data-lucide="credit-card" class="h-6 w-6 text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Ödeme Ayarları</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ödeme yöntemlerini ve tercihlerini yapılandırın</p>
        </div>
    </div>

    <x-danger-alert />
    <x-success-alert />

    <!-- Payment Settings Tabs -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 overflow-hidden">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 dark:border-admin-700">
            <nav class="flex flex-wrap" x-data="{ activeTab: 'methods' }">
                <button @click="activeTab = 'methods'"
                        :class="{ 'border-blue-500 text-blue-600 bg-blue-50 dark:bg-blue-900 dark:text-blue-400': activeTab === 'methods', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-admin-600': activeTab !== 'methods' }"
                        class="flex-1 min-w-0 py-4 px-6 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none">
                    <div class="flex items-center justify-center space-x-2">
                        <i data-lucide="credit-card" class="w-4 h-4"></i>
                        <span>Ödeme Yöntemleri</span>
                    </div>
                </button>
                
                <button @click="activeTab = 'preferences'"
                        :class="{ 'border-blue-500 text-blue-600 bg-blue-50 dark:bg-blue-900 dark:text-blue-400': activeTab === 'preferences', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-admin-600': activeTab !== 'preferences' }"
                        class="flex-1 min-w-0 py-4 px-6 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none">
                    <div class="flex items-center justify-center space-x-2">
                        <i data-lucide="settings" class="w-4 h-4"></i>
                        <span>Ödeme Tercihleri</span>
                    </div>
                </button>
                
                <button @click="activeTab = 'coinpayment'"
                        :class="{ 'border-blue-500 text-blue-600 bg-blue-50 dark:bg-blue-900 dark:text-blue-400': activeTab === 'coinpayment', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-admin-600': activeTab !== 'coinpayment' }"
                        class="flex-1 min-w-0 py-4 px-6 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none">
                    <div class="flex items-center justify-center space-x-2">
                        <i data-lucide="coins" class="w-4 h-4"></i>
                        <span>Coinpayment</span>
                    </div>
                </button>
                
                <button @click="activeTab = 'gateways'"
                        :class="{ 'border-blue-500 text-blue-600 bg-blue-50 dark:bg-blue-900 dark:text-blue-400': activeTab === 'gateways', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-admin-600': activeTab !== 'gateways' }"
                        class="flex-1 min-w-0 py-4 px-6 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none">
                    <div class="flex items-center justify-center space-x-2">
                        <i data-lucide="link" class="w-4 h-4"></i>
                        <span>Gateway'ler</span>
                    </div>
                </button>
                
                <button @click="activeTab = 'transfer'"
                        :class="{ 'border-blue-500 text-blue-600 bg-blue-50 dark:bg-blue-900 dark:text-blue-400': activeTab === 'transfer', 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-admin-600': activeTab !== 'transfer' }"
                        class="flex-1 min-w-0 py-4 px-6 text-sm font-medium text-center border-b-2 transition-all duration-200 focus:outline-none">
                    <div class="flex items-center justify-center space-x-2">
                        <i data-lucide="arrow-right-left" class="w-4 h-4"></i>
                        <span>Transfer</span>
                    </div>
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6" x-data="{ activeTab: 'methods' }">
            <!-- Payment Methods Tab -->
            <div x-show="activeTab === 'methods'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                @include('admin.Settings.PaymentSettings.deposit')
            </div>
            
            <!-- Payment Preferences Tab -->
            <div x-show="activeTab === 'preferences'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                @include('admin.Settings.PaymentSettings.withdrawal')
            </div>
            
            <!-- Coinpayment Tab -->
            <div x-show="activeTab === 'coinpayment'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                @include('admin.Settings.PaymentSettings.coinpayment')
            </div>
            
            <!-- Gateways Tab -->
            <div x-show="activeTab === 'gateways'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                @include('admin.Settings.PaymentSettings.gateway')
            </div>
            
            <!-- Transfer Tab -->
            <div x-show="activeTab === 'transfer'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                @include('admin.Settings.PaymentSettings.transfers')
            </div>
        </div>
    </div>
</div>

<script>
    // Modern form submission handlers with fetch API
    document.addEventListener('DOMContentLoaded', function() {
        
        // Payment preference form handler
        const paypreform = document.getElementById('paypreform');
        if (paypreform) {
            paypreform.addEventListener('submit', async function(e) {
                e.preventDefault();
                
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
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('error', 'Hata', 'Bir hata oluştu');
                }
            });
        }

        // Coinpayment form handler
        const coinpayform = document.getElementById('coinpayform');
        if (coinpayform) {
            coinpayform.addEventListener('submit', async function(e) {
                e.preventDefault();
                
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
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('error', 'Hata', 'Bir hata oluştu');
                }
            });
        }

        // Gateway form handler
        const gatewayform = document.getElementById('gatewayform');
        if (gatewayform) {
            gatewayform.addEventListener('submit', async function(e) {
                e.preventDefault();
                
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
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('error', 'Hata', 'Bir hata oluştu');
                }
            });
        }

        // Transfer form handler
        const trasfer = document.getElementById('trasfer');
        if (trasfer) {
            trasfer.addEventListener('submit', async function(e) {
                e.preventDefault();
                
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
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('error', 'Hata', 'Bir hata oluştu');
                }
            });
        }

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
                            '<i data-lucide="check-circle" class="w-5 h-5"></i>' :
                            '<i data-lucide="x-circle" class="w-5 h-5"></i>'
                        }
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium">${title}</h3>
                        <div class="mt-1 text-sm">${message}</div>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200 focus:outline-none">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Initialize lucide icons in the notification
            if (typeof lucide !== 'undefined') {
                lucide.createIcons({ nameAttr: 'data-lucide' });
            }
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.transform = 'translateX(100%)';
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 5000);
        }

        // Make showNotification available globally
        window.showNotification = showNotification;
    });
</script>
@endsection
