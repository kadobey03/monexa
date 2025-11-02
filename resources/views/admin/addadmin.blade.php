@extends('layouts.admin', ['title' => 'Yeni Yönetici Ekle'])

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-admin-900 dark:via-admin-800 dark:to-admin-900">
            <!-- Header Section -->
            <div class="bg-white dark:bg-admin-800 border-b border-gray-200 dark:border-admin-700 shadow-sm">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Yeni Yönetici Ekle</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Sisteminize yeni bir yönetici kullanıcı ekleyin</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                <x-danger-alert />
                <x-success-alert />
            </div>
            
            <!-- Form Content -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-xl border border-gray-200 dark:border-admin-700 overflow-hidden">
                        <!-- Form Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-blue-50 dark:from-admin-700 dark:to-admin-600 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                Yönetici Bilgileri
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Tüm alanları doldurduğunuzdan emin olun</p>
                        </div>
                        
                        <!-- Form Body -->
                        <div class="p-6">
                            <form method="POST" action="{{ url('admin/dashboard/saveadmin') }}" class="space-y-6">
                                @csrf
                                
                                <!-- Personal Information Section -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- First Name -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                            Ad
                                        </label>
                                        <input type="text" 
                                               name="fname" 
                                               value="{{ old('fname') }}" 
                                               required
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 {{ $errors->has('fname') ? 'border-red-500 bg-red-50 dark:bg-red-900' : '' }}"
                                               placeholder="Adını girin">
                                        @if ($errors->has('fname'))
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $errors->first('fname') }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <!-- Last Name -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i data-lucide="user" class="w-4 h-4 inline mr-1"></i>
                                            Soyad
                                        </label>
                                        <input type="text"
                                               name="l_name"
                                               value="{{ old('l_name') }}"
                                               required
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 {{ $errors->has('l_name') ? 'border-red-500 bg-red-50 dark:bg-red-900' : '' }}"
                                               placeholder="Soyadını girin">
                                        @if ($errors->has('l_name'))
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $errors->first('l_name') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Contact Information Section -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Email -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i data-lucide="mail" class="w-4 h-4 inline mr-1"></i>
                                            E-posta Adresi
                                        </label>
                                        <input type="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               required
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 {{ $errors->has('email') ? 'border-red-500 bg-red-50 dark:bg-red-900' : '' }}"
                                               placeholder="E-posta adresini girin">
                                        @if ($errors->has('email'))
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $errors->first('email') }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <!-- Phone -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i data-lucide="phone" class="w-4 h-4 inline mr-1"></i>
                                            Telefon Numarası
                                        </label>
                                        <input type="number"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               required
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 {{ $errors->has('phone') ? 'border-red-500 bg-red-50 dark:bg-red-900' : '' }}"
                                               placeholder="Telefon numarasını girin">
                                        @if ($errors->has('phone'))
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $errors->first('phone') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Admin Type -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <i data-lucide="shield-check" class="w-4 h-4 inline mr-1"></i>
                                        Yönetici Türü
                                    </label>
                                    <select name="type" required class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                                        <option value="" disabled selected>Yönetici türü seçin</option>
                                        <option value="Süper Yönetici">Süper Yönetici</option>
                                        <option value="Yönetici">Yönetici</option>
                                        <option value="Dönüştürme Temsilcisi">Dönüştürme Temsilcisi</option>
                                    </select>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                        <strong>Süper Yönetici:</strong> Tüm sistem yetkilerine sahip • 
                                        <strong>Yönetici:</strong> Sınırlı yetki • 
                                        <strong>Dönüştürme Temsilcisi:</strong> Müşteri işlemleri
                                    </p>
                                </div>
                                
                                <!-- Password Section -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Password -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i data-lucide="lock" class="w-4 h-4 inline mr-1"></i>
                                            Şifre
                                        </label>
                                        <input type="password"
                                               name="password"
                                               required
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 {{ $errors->has('password') ? 'border-red-500 bg-red-50 dark:bg-red-900' : '' }}"
                                               placeholder="Güçlü bir şifre girin">
                                        @if ($errors->has('password'))
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $errors->first('password') }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <!-- Confirm Password -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <i data-lucide="shield-check" class="w-4 h-4 inline mr-1"></i>
                                            Şifreyi Onayla
                                        </label>
                                        <input type="password"
                                               name="password_confirmation"
                                               required
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 {{ $errors->has('password_confirmation') ? 'border-red-500 bg-red-50 dark:bg-red-900' : '' }}"
                                               placeholder="Şifreyi tekrar girin">
                                        @if ($errors->has('password_confirmation'))
                                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $errors->first('password_confirmation') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Security Notice -->
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i data-lucide="info" class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-200">Güvenlik Uyarısı</h4>
                                            <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                                • Şifre en az 8 karakter olmalıdır<br>
                                                • Büyük/küçük harf, sayı ve özel karakter içermelidir<br>
                                                • Yönetici bilgileri güvenli tutulmalıdır
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="flex items-center justify-between pt-6">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        <span class="text-red-500">*</span> Gerekli alanlar
                                    </div>
                                    <button type="submit" 
                                            class="group relative inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                        <svg class="w-5 h-5 mr-2 group-hover:animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                                        </svg>
                                        Kullanıcıyı Kaydet
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Styles for Enhanced UX -->
    <style>
        /* Input focus animations */
        input:focus, select:focus, textarea:focus {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px -8px rgba(59, 130, 246, 0.25);
        }
        
        /* Smooth transitions for all form elements */
        input, select, textarea, button {
            transition: all 0.3s ease;
        }
        
        /* Enhanced button hover effects */
        button[type="submit"]:hover {
            box-shadow: 0 10px 30px -10px rgba(79, 70, 229, 0.4);
        }
        
        /* Custom scrollbar for better UX */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
    
    <!-- Form Validation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const passwordInput = document.querySelector('input[name="password"]');
            const confirmPasswordInput = document.querySelector('input[name="password_confirmation"]');
            
            // Real-time password confirmation check
            confirmPasswordInput.addEventListener('input', function() {
                if (this.value !== passwordInput.value) {
                    this.classList.add('border-red-500', 'bg-red-50');
                    this.classList.remove('border-gray-300');
                } else {
                    this.classList.remove('border-red-500', 'bg-red-50');
                    this.classList.add('border-green-500', 'bg-green-50');
                }
            });
            
            // Form submission loading state
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Kaydediliyor...
                `;
                submitBtn.disabled = true;
                
                // Prevent multiple submissions
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                }, 10000);
            });
            
            console.log('Add Admin form initialized with Tailwind CSS');
        });
    </script>
@endsection