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
@extends('layouts.admin', ['title' => 'IP Adresi Kara Listesi'])

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-admin-900 dark:via-admin-800 dark:to-admin-900">
        <!-- Header Section -->
        <div class="bg-white dark:bg-admin-800 border-b border-gray-200 dark:border-admin-700 shadow-sm">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-red-500 to-pink-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">IP Adresi Kara Listesi</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Erişimi engellenecek IP adreslerini yönetin</p>
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Add IP Address Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-xl border border-gray-200 dark:border-admin-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-red-500 to-pink-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                IP Adresi Ekle
                            </h3>
                            <p class="text-red-100 mt-1">Yeni IP adresini kara listeye ekle</p>
                        </div>
                        
                        <div class="p-6">
                            <form id="addIpForm" class="space-y-6">
                                @csrf
                                
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        IP Adresi
                                    </label>
                                    <input type="text" 
                                           name="ipaddress" 
                                           id="ipAddress" 
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-admin-700 dark:text-white transition-colors duration-200"
                                           placeholder="192.168.1.1"
                                           pattern="^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$"
                                           required>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">IPv4 formatında IP adresi girin (örn: 192.168.1.1)</p>
                                </div>
                                
                                <div class="pt-4 border-t border-gray-200 dark:border-admin-600">
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-admin-800">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Kara Listeye Ekle
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- IP Address List -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-xl border border-gray-200 dark:border-admin-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Kara Listedeki IP Adresleri
                            </h3>
                            <p class="text-blue-100 mt-1">Engellenmiş IP adreslerinin listesi</p>
                        </div>
                        
                        <div class="p-0">
                            <!-- Loading State -->
                            <div id="loadingState" class="flex items-center justify-center py-12">
                                <svg class="animate-spin h-8 w-8 text-blue-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">IP adresleri yükleniyor...</span>
                            </div>
                            
                            <!-- Empty State -->
                            <div id="emptyState" class="text-center py-12 px-6" style="display:none;">
                                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Henüz kara listeye alınmış IP adresi yok</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">Sol taraftaki formu kullanarak IP adresi ekleyebilirsiniz.</p>
                            </div>
                            
                            <!-- IP Table -->
                            <div id="ipTableContainer" class="overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-admin-600">
                                        <thead class="bg-gray-50 dark:bg-admin-700">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">IP Adresi</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Eklenme Tarihi</th>
                                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ipTableBody" class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-600">
                                            <!-- IP adresleri buraya yüklenecek -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Modern Vanilla JavaScript - No Alpine.js
        document.addEventListener('DOMContentLoaded', function() {
            // Load IP addresses on page load
            loadIpAddresses();
            
            // Add IP form submission
            document.getElementById('addIpForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const button = this.querySelector('button[type="submit"]');
                const originalText = button.innerHTML;
                const ipInput = document.getElementById('ipAddress');
                
                // Validate IP format
                const ipPattern = /^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/;
                if (!ipPattern.test(ipInput.value)) {
                    showNotification('error', 'Geçersiz Format', 'Geçerli bir IP adresi girin (örn: 192.168.1.1)');
                    return;
                }
                
                // Check if IP parts are valid (0-255)
                const parts = ipInput.value.split('.');
                for (let part of parts) {
                    if (parseInt(part) > 255) {
                        showNotification('error', 'Geçersiz IP', 'IP adresi geçersiz. Her bölüm 0-255 arasında olmalı.');
                        return;
                    }
                }
                
                button.disabled = true;
                button.innerHTML = `
                    <span class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Ekleniyor...
                    </span>
                `;
                
                try {
                    const formData = new FormData(this);
                    const response = await fetch("{{ route('addipaddress') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.status === 200) {
                        showNotification('success', 'Başarılı!', result.success);
                        ipInput.value = ''; // Clear form
                        loadIpAddresses(); // Reload list
                    } else {
                        showNotification('error', 'Hata!', result.message || 'IP adresi eklenemedi');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('error', 'Hata!', 'Bir hata oluştu');
                } finally {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            });
            
            // Input validation for IP format
            document.getElementById('ipAddress').addEventListener('input', function() {
                const value = this.value;
                const isValid = /^(?:[0-9]{1,3}\.){0,3}[0-9]{0,3}$/.test(value);
                
                if (!isValid && value !== '') {
                    this.classList.add('border-red-500', 'ring-red-500');
                    this.classList.remove('border-gray-300', 'focus:ring-red-500');
                } else {
                    this.classList.remove('border-red-500', 'ring-red-500');
                    this.classList.add('border-gray-300');
                }
            });
        });

        // Load IP addresses function
        async function loadIpAddresses() {
            const tableBody = document.getElementById('ipTableBody');
            const loadingState = document.getElementById('loadingState');
            const emptyState = document.getElementById('emptyState');
            const tableContainer = document.getElementById('ipTableContainer');
            
            loadingState.style.display = 'flex';
            emptyState.style.display = 'none';
            tableContainer.style.display = 'none';
            
            try {
                const response = await fetch("{{ route('allipaddress') }}", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });
                
                const result = await response.json();
                
                loadingState.style.display = 'none';
                
                if (result.status === 200) {
                    if (result.data.includes('No Record Added')) {
                        emptyState.style.display = 'block';
                    } else {
                        // Parse the HTML and convert to Tailwind format
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = result.data;
                        const rows = tempDiv.querySelectorAll('tr');
                        
                        let tableHTML = '';
                        rows.forEach((row, index) => {
                            const cells = row.querySelectorAll('td');
                            if (cells.length >= 3) {
                                const ip = cells[0].textContent.trim();
                                const date = cells[1].textContent.trim();
                                const deleteButton = cells[2].querySelector('a');
                                const id = deleteButton ? deleteButton.id : '';
                                
                                tableHTML += `
                                    <tr class="hover:bg-gray-50 dark:hover:bg-admin-700 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="p-2 bg-red-100 dark:bg-red-900 rounded-lg mr-3">
                                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white font-mono">${ip}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${date}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <button onclick="deleteip('${id}')" class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:hover:bg-red-800 text-red-700 dark:text-red-300 text-sm font-medium rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Sil
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            }
                        });
                        
                        if (tableHTML) {
                            tableBody.innerHTML = tableHTML;
                            tableContainer.style.display = 'block';
                        } else {
                            emptyState.style.display = 'block';
                        }
                    }
                } else {
                    emptyState.style.display = 'block';
                    showNotification('error', 'Hata!', 'IP adresleri yüklenemedi');
                }
            } catch (error) {
                console.error('Error:', error);
                loadingState.style.display = 'none';
                emptyState.style.display = 'block';
                showNotification('error', 'Hata!', 'Bağlantı hatası oluştu');
            }
        }

        // Delete IP function
        async function deleteip(id) {
            if (!confirm('Bu IP adresini kara listeden çıkarmak istediğinizden emin misiniz?')) {
                return;
            }
            
            try {
                const response = await fetch(`{{ route('deleteip', ':id') }}`.replace(':id', id), {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });
                
                const result = await response.json();
                
                if (result.status === 200) {
                    showNotification('success', 'Başarılı!', result.success);
                    loadIpAddresses(); // Reload list
                } else {
                    showNotification('error', 'Hata!', 'IP adresi silinemedi');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('error', 'Hata!', 'Bir hata oluştu');
            }
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