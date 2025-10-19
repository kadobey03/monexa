<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
} else {
    $text = 'light';
}
?>
@extends('layouts.app')
@section('content')
@section('styles')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#667eea',
                    secondary: '#764ba2'
                }
            }
        }
    }
</script>
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .glass-effect {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.1);
    }
</style>
@endsection
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <!-- Modern Header -->
                <div class="mb-8">
                    <div class="gradient-bg rounded-2xl p-6 text-white shadow-2xl">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <i class="fas fa-users-cog text-3xl"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold">Yöneticiler Paneli</h1>
                                <p class="text-white text-opacity-80 text-lg">Sistem yöneticilerini yönetin ve kontrol edin</p>
                            </div>
                        </div>
                    </div>
                </div>

                <x-danger-alert />
                <x-success-alert />

                <!-- Admin Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach ($admins as $admin)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <!-- Card Header -->
                        <div class="gradient-bg p-6 rounded-t-xl">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                                        <i class="fas fa-user-shield text-xl text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-white font-bold text-lg">{{ $admin->firstName }} {{ $admin->lastName }}</h3>
                                        <p class="text-white text-opacity-80">ID: #{{ $admin->id }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if ($admin->acnt_type_active == null || $admin->acnt_type_active == 'blocked')
                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Engelli</span>
                                    @else
                                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Aktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-envelope text-blue-500 w-5"></i>
                                    <span class="text-gray-700">{{ $admin->email }}</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-phone text-green-500 w-5"></i>
                                    <span class="text-gray-700">{{ $admin->phone ?: 'Telefon yok' }}</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-tag text-purple-500 w-5"></i>
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">{{ $admin->type }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer - Action Buttons -->
                        <div class="border-t p-4 bg-gray-50 rounded-b-xl">
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                @if ($admin->acnt_type_active == null || $admin->acnt_type_active == 'blocked')
                                    <a href="{{ url('admin/dashboard/unblock') }}/{{ $admin->id }}"
                                       class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                                        <i class="fas fa-unlock mr-1"></i>Engeli Kaldır
                                    </a>
                                @else
                                    <a href="{{ url('admin/dashboard/ublock') }}/{{ $admin->id }}"
                                       class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                                        <i class="fas fa-lock mr-1"></i>Engelle
                                    </a>
                                @endif
                                <button onclick="openModal('editModal{{ $admin->id }}')"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                    <i class="fas fa-edit mr-1"></i>Düzenle
                                </button>
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <button onclick="openModal('resetModal{{ $admin->id }}')"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-2 rounded-lg text-xs font-medium transition-colors">
                                    <i class="fas fa-key"></i>
                                </button>
                                <button onclick="openModal('deleteModal{{ $admin->id }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded-lg text-xs font-medium transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button onclick="openModal('emailModal{{ $admin->id }}')"
                                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-2 py-2 rounded-lg text-xs font-medium transition-colors">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>

        <!-- Modern Tailwind Modals -->
        @foreach ($admins as $admin)
            <!-- Reset Password Modal -->
            <div id="resetModal{{ $admin->id }}" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
                    <div class="gradient-bg p-6 rounded-t-2xl text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white bg-opacity-20 rounded-full p-3">
                                    <i class="fas fa-key text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold">Şifre Sıfırlama</h3>
                                    <p class="text-white text-opacity-80 text-sm">{{ $admin->firstName }} {{ $admin->lastName }}</p>
                                </div>
                            </div>
                            <button onclick="closeModal('resetModal{{ $admin->id }}')" class="text-white hover:text-gray-200">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                                <p class="text-yellow-700"><strong>Dikkat!</strong> Şifre varsayılan değere sıfırlanacak.</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="bg-yellow-500 rounded-full p-2">
                                    <i class="fas fa-lock text-white"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Yeni Şifre</p>
                                    <p class="text-gray-600">admin01236</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-6">{{ $admin->firstName }} için şifreyi sıfırlamak istediğinizden emin misiniz?</p>
                        <div class="flex space-x-3">
                            <a href="{{ url('admin/dashboard/resetadpwd') }}/{{ $admin->id }}"
                               class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center">
                                <i class="fas fa-key mr-2"></i>Evet, Sıfırla
                            </a>
                            <button onclick="closeModal('resetModal{{ $admin->id }}')"
                                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                                İptal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            <div id="deleteModal{{ $admin->id }}" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
                    <div class="bg-red-500 p-6 rounded-t-2xl text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white bg-opacity-20 rounded-full p-3">
                                    <i class="fas fa-trash-alt text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold">Yöneticiyi Sil</h3>
                            </div>
                            <button onclick="closeModal('deleteModal{{ $admin->id }}')" class="text-white hover:text-gray-200">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 mb-6">{{ $admin->firstName }} {{ $admin->lastName }} kullanıcısını silmek istediğinizden emin misiniz?</p>
                        <div class="flex space-x-3">
                            <a href="{{ url('admin/dashboard/deleletadmin') }}/{{ $admin->id }}"
                               class="flex-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center">
                                <i class="fas fa-trash mr-2"></i>Evet, Sil
                            </a>
                            <button onclick="closeModal('deleteModal{{ $admin->id }}')"
                                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                                İptal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div id="editModal{{ $admin->id }}" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 transform transition-all max-h-screen overflow-y-auto">
                    <div class="bg-blue-500 p-6 rounded-t-2xl text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white bg-opacity-20 rounded-full p-3">
                                    <i class="fas fa-user-edit text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold">Kullanıcı Düzenle</h3>
                            </div>
                            <button onclick="closeModal('editModal{{ $admin->id }}')" class="text-white hover:text-gray-200">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <form method="post" action="{{ route('editadmin') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $admin->id }}">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ad</label>
                                <input type="text" name="fname" value="{{ $admin->firstName }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Soyad</label>
                                <input type="text" name="l_name" value="{{ $admin->lastName }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">E-posta</label>
                                <input type="email" name="email" value="{{ $admin->email }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
                                <input type="text" name="phone" value="{{ $admin->phone }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tür</label>
                                <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="{{ $admin->type }}">{{ $admin->type }}</option>
                                    <option value="Süper Yönetici">Süper Yönetici</option>
                                    <option value="Yönetici">Yönetici</option>
                                    <option value="Dönüşüm Aracısı">Dönüşüm Aracısı</option>
                                </select>
                            </div>
                            
                            <div class="flex space-x-3 pt-4">
                                <button type="submit"
                                        class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                    <i class="fas fa-save mr-2"></i>Güncelle
                                </button>
                                <button type="button" onclick="closeModal('editModal{{ $admin->id }}')"
                                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                                    İptal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Email Modal -->
            <div id="emailModal{{ $admin->id }}" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 transform transition-all">
                    <div class="bg-indigo-500 p-6 rounded-t-2xl text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white bg-opacity-20 rounded-full p-3">
                                    <i class="fas fa-envelope text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold">E-posta Gönder</h3>
                            </div>
                            <button onclick="closeModal('emailModal{{ $admin->id }}')" class="text-white hover:text-gray-200">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 mb-4">{{ $admin->firstName }} {{ $admin->lastName }} kullanıcısına mesaj gönderilecek.</p>
                        <form method="post" action="{{ route('sendmailtoadmin') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $admin->id }}">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Konu</label>
                                <input type="text" name="subject" placeholder="E-posta konusu girin"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mesaj</label>
                                <textarea name="message" rows="4" placeholder="Mesajınızı buraya yazın" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                            </div>
                            
                            <div class="flex space-x-3 pt-4">
                                <button type="submit"
                                        class="flex-1 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                    <i class="fas fa-paper-plane mr-2"></i>Gönder
                                </button>
                                <button type="button" onclick="closeModal('emailModal{{ $admin->id }}')"
                                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                                    İptal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <script>
            // Wait for DOM to be fully loaded
            document.addEventListener('DOMContentLoaded', function() {
                
                // Modal functionality with null checks
                window.openModal = function(modalId) {
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.style.overflow = 'hidden';
                    }
                }

                window.closeModal = function(modalId) {
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        document.body.style.overflow = 'auto';
                    }
                }

                // Initialize modal event listeners safely
                function initializeModals() {
                    const modals = document.querySelectorAll('[id*="Modal"]');
                    modals.forEach(modal => {
                        if (modal) {
                            // Close modal when clicking backdrop
                            modal.addEventListener('click', function(e) {
                                if (e.target === modal) {
                                    window.closeModal(modal.id);
                                }
                            });
                        }
                    });
                }

                // Initialize modals
                initializeModals();

                // Close modal with Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        const allModals = document.querySelectorAll('[id*="Modal"]:not(.hidden)');
                        allModals.forEach(modal => {
                            if (modal) {
                                window.closeModal(modal.id);
                            }
                        });
                    }
                });

                // Add loading states to action buttons
                const actionButtons = document.querySelectorAll('a[href*="/admin/dashboard/"]');
                actionButtons.forEach(button => {
                    if (button) {
                        button.addEventListener('click', function() {
                            const icon = this.querySelector('i');
                            if (icon && !icon.classList.contains('fa-spinner')) {
                                const originalClass = icon.className;
                                icon.className = 'fas fa-spinner fa-spin';
                                
                                // Restore original icon after 3 seconds if page hasn't changed
                                setTimeout(() => {
                                    if (icon) {
                                        icon.className = originalClass;
                                    }
                                }, 3000);
                            }
                        });
                    }
                });

                console.log('Admin panel loaded successfully');
            });

            // Global functions for backward compatibility
            function openModal(modalId) {
                if (window.openModal) {
                    window.openModal(modalId);
                }
            }

            function closeModal(modalId) {
                if (window.closeModal) {
                    window.closeModal(modalId);
                }
            }

            // Error handling for missing dependencies
            window.addEventListener('error', function(e) {
                if (e.message.includes('$ is not defined') ||
                    e.message.includes('jQuery') ||
                    e.message.includes('livewire')) {
                    console.warn('Some external dependencies are missing, but core functionality should work');
                }
            });
        </script>
    @endsection
