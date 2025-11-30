<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
} else {
    $text = 'light';
}
?>
@extends('layouts.admin', ['title' => __('admin.users.admin_panel')])

@section('content')
    <!-- Main Content Area with Tailwind -->
    <div class="p-8 bg-gray-50 dark:bg-admin-900 min-h-screen transition-all duration-300">
        
        <!-- Page Header -->
        <div class="mb-8">
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800 rounded-2xl p-6 text-white shadow-2xl">
            <div class="flex items-center space-x-4">
                <div class="bg-white/20 p-4 rounded-xl backdrop-blur-sm">
                    <x-heroicon name="user-cog" class="w-8 h-8" />
                </div>
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ __('admin.users.admin_panel') }}</h1>
                    <p class="text-white/80 text-lg">{{ __('admin.users.manage_and_control_admins') }}</p>
                </div>
            </div>
        </div>
        </div>

        <!-- Alerts -->
        <div class="mb-6">
            <x-danger-alert />
            <x-success-alert />
        </div>

        <!-- Admin Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($admins as $admin)
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                        <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                            <x-heroicon name="shield-check" class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">{{ $admin->firstName }} {{ $admin->lastName }}</h3>
                            <p class="text-white/70 text-sm">ID: #{{ $admin->id }}</p>
                        </div>
                        </div>
                        <div>
                            @if ($admin->acnt_type_active == null || $admin->acnt_type_active == 'blocked')
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold animate-pulse">
                                    {{ __('admin.status.blocked') }}
                                </span>
                            @else
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ __('admin.status.active') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6 space-y-4">
                    <div class="flex items-center space-x-3 group">
                    <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg group-hover:bg-blue-200 dark:group-hover:bg-blue-800 transition-colors">
                        <x-heroicon name="envelope" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                    </div>
                    <span class="text-gray-700 dark:text-gray-300 group-hover:text-blue-600 transition-colors">{{ $admin->email }}</span>
                    </div>
                    
                    <div class="flex items-center space-x-3 group">
                    <div class="bg-green-100 dark:bg-green-900 p-2 rounded-lg group-hover:bg-green-200 dark:group-hover:bg-green-800 transition-colors">
                        <x-heroicon name="phone" class="w-4 h-4 text-green-600 dark:text-green-400" />
                    </div>
                    <span class="text-gray-700 dark:text-gray-300 group-hover:text-green-600 transition-colors">{{ $admin->phone ?: __('admin.users.no_phone') }}</span>
                    </div>
                    
                    <div class="flex items-center space-x-3 group">
                    <div class="bg-purple-100 dark:bg-purple-900 p-2 rounded-lg group-hover:bg-purple-200 dark:group-hover:bg-purple-800 transition-colors">
                        <x-heroicon name="tag" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                    </div>
                    <span class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-3 py-1 rounded-full text-sm font-medium">{{ $admin->type }}</span>
                    </div>
                </div>

                <!-- Card Footer - Action Buttons -->
            <div class="bg-gray-50 dark:bg-admin-700 p-6 border-t border-gray-200 dark:border-admin-600">
                    <!-- Primary Actions -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        @if ($admin->acnt_type_active == null || $admin->acnt_type_active == 'blocked')
                        <a href="{{ url('admin/dashboard/unblock') }}/{{ $admin->id }}"
                           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 text-center transform hover:scale-105 shadow-lg">
                            <x-heroicon name="lock-open" class="w-4 h-4 mr-2 inline" />{{ __('admin.actions.unblock') }}
                        </a>
                        @else
                        <a href="{{ url('admin/dashboard/ublock') }}/{{ $admin->id }}"
                           class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 text-center transform hover:scale-105 shadow-lg">
                            <x-heroicon name="lock-closed" class="w-4 h-4 mr-2 inline" />{{ __('admin.actions.block') }}
                        </a>
                        @endif
                        
                    <button onclick="openModal('editModal{{ $admin->id }}')"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <x-heroicon name="edit" class="w-4 h-4 mr-2 inline" />{{ __('admin.actions.edit') }}
                    </button>
                    </div>
                    
                    <!-- Secondary Actions -->
                    <div class="grid grid-cols-3 gap-2">
                        <button onclick="openModal('resetModal{{ $admin->id }}')"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-xs font-medium transition-all duration-300 transform hover:scale-105"
                                title="{{ __('admin.actions.reset_password') }}">
                            <i class="fas fa-key"></i>
                        </button>
                        
                        <button onclick="openModal('deleteModal{{ $admin->id }}')"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-xs font-medium transition-all duration-300 transform hover:scale-105"
                                title="{{ __('admin.actions.delete') }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        
                        <button onclick="openModal('emailModal{{ $admin->id }}')"
                                class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-2 rounded-lg text-xs font-medium transition-all duration-300 transform hover:scale-105"
                                title="{{ __('admin.actions.send_email') }}">
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
            <div id="resetModal{{ $admin->id }}" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all scale-95 hover:scale-100">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-600 p-6 rounded-t-2xl text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                                    <i class="fas fa-key text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold">{{ __('admin.actions.password_reset') }}</h3>
                                    <p class="text-white/80 text-sm">{{ $admin->firstName }} {{ $admin->lastName }}</p>
                                </div>
                            </div>
                            <button onclick="closeModal('resetModal{{ $admin->id }}')"
                                    class="text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/10">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Body -->
                    <div class="p-6 space-y-4">
                        <!-- Warning Alert -->
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded-r-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-yellow-700 font-medium">{{ __('admin.notifications.attention') }}!</p>
                                    <p class="text-yellow-600 text-sm">{{ __('admin.actions.password_reset_warning') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Password Info -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center space-x-3">
                                <div class="bg-yellow-500 p-3 rounded-full text-white">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ __('admin.forms.new_password') }}</h4>
                                    <p class="text-gray-600 font-mono bg-white px-2 py-1 rounded border">admin01236</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Confirmation Text -->
                        <p class="text-gray-700">{{ __('admin.actions.confirm_password_reset', ['name' => $admin->firstName]) }}</p>
                    </div>
                    
                    <!-- Footer -->
                    <div class="flex space-x-3 p-6 bg-gray-50 rounded-b-2xl">
                        <a href="{{ url('admin/dashboard/resetadpwd') }}/{{ $admin->id }}"
                           class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-600 text-white px-6 py-3 rounded-xl font-semibold text-center hover:from-yellow-600 hover:to-orange-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                            <i class="fas fa-key mr-2"></i>{{ __('admin.actions.yes_reset') }}
                        </a>
                        <button onclick="closeModal('resetModal{{ $admin->id }}')"
                                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                            {{ __('admin.actions.cancel') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Delete Modal -->
            <div id="deleteModal{{ $admin->id }}" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all scale-95 hover:scale-100">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-red-500 to-pink-600 p-6 rounded-t-2xl text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                                    <i class="fas fa-trash-alt text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold">{{ __('admin.actions.delete_admin') }}</h3>
                            </div>
                            <button onclick="closeModal('deleteModal{{ $admin->id }}')"
                                    class="text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/10">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Body -->
                    <div class="p-6">
                        <div class="text-center space-y-4">
                            <div class="bg-red-100 p-4 rounded-full w-16 h-16 mx-auto flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                            </div>
                            <p class="text-gray-700 text-lg">
                                {{ __('admin.actions.confirm_delete_user', ['name' => $admin->firstName . ' ' . $admin->lastName]) }}
                            </p>
                            <p class="text-red-600 text-sm">{{ __('admin.notifications.irreversible_action') }}</p>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="flex space-x-3 p-6 bg-gray-50 rounded-b-2xl">
                        <a href="{{ url('admin/dashboard/deleletadmin') }}/{{ $admin->id }}"
                           class="flex-1 bg-gradient-to-r from-red-500 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold text-center hover:from-red-600 hover:to-pink-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                            <i class="fas fa-trash mr-2"></i>{{ __('admin.actions.yes_delete') }}
                        </a>
                        <button onclick="closeModal('deleteModal{{ $admin->id }}')"
                                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                            {{ __('admin.actions.cancel') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div id="editModal{{ $admin->id }}" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 transform transition-all scale-95 hover:scale-100 max-h-screen overflow-y-auto">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 rounded-t-2xl text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                                    <i class="fas fa-user-edit text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold">{{ __('admin.actions.edit_user') }}</h3>
                            </div>
                            <button onclick="closeModal('editModal{{ $admin->id }}')"
                                    class="text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/10">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Body -->
                    <div class="p-6">
                        <form method="post" action="{{ route('editadmin') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $admin->id }}">
                            
                            <!-- First Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('admin.forms.first_name') }}</label>
                                <input type="text" name="fname" value="{{ $admin->firstName }}" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 outline-none">
                            </div>
                            
                            <!-- Last Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('admin.forms.last_name') }}</label>
                                <input type="text" name="l_name" value="{{ $admin->lastName }}" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 outline-none">
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('admin.users.email') }}</label>
                                <input type="email" name="email" value="{{ $admin->email }}" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 outline-none">
                            </div>
                            
                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('admin.users.phone') }}</label>
                                <input type="text" name="phone" value="{{ $admin->phone }}" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 outline-none">
                            </div>
                            
                            <!-- Type -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('admin.users.type') }}</label>
                                <select name="type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 outline-none">
                                    <option value="{{ $admin->type }}">{{ $admin->type }}</option>
                                    <option value="Süper Yönetici">{{ __('admin.users.super_admin') }}</option>
                                    <option value="Yönetici">{{ __('admin.users.admin') }}</option>
                                    <option value="Dönüşüm Aracısı">{{ __('admin.users.conversion_agent') }}</option>
                                </select>
                            </div>
                            
                            <!-- Footer -->
                            <div class="flex space-x-3 pt-4">
                                <button type="submit"
                                        class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                                    <i class="fas fa-save mr-2"></i>{{ __('admin.actions.update') }}
                                </button>
                                <button type="button" onclick="closeModal('editModal{{ $admin->id }}')"
                                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                                    {{ __('admin.actions.cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Email Modal -->
            <div id="emailModal{{ $admin->id }}" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 transform transition-all scale-95 hover:scale-100">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 rounded-t-2xl text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                                    <i class="fas fa-envelope text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold">{{ __('admin.actions.send_email') }}</h3>
                            </div>
                            <button onclick="closeModal('emailModal{{ $admin->id }}')"
                                    class="text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/10">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Body -->
                    <div class="p-6">
                        <div class="bg-blue-50 p-4 rounded-xl mb-4">
                            <p class="text-blue-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                {{ __('admin.actions.email_will_be_sent', ['name' => $admin->firstName . ' ' . $admin->lastName]) }}
                            </p>
                        </div>
                        
                        <form method="post" action="{{ route('sendmailtoadmin') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $admin->id }}">
                            
                            <!-- Subject -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('admin.forms.subject') }}</label>
                                <input type="text" name="subject" placeholder="{{ __('admin.forms.email_subject_placeholder') }}" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 outline-none">
                            </div>
                            
                            <!-- Message -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('admin.forms.message') }}</label>
                                <textarea name="message" rows="4" placeholder="{{ __('admin.forms.message_placeholder') }}" required
                                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 outline-none resize-none"></textarea>
                            </div>
                            
                            <!-- Footer -->
                            <div class="flex space-x-3 pt-4">
                                <button type="submit"
                                        class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                                    <i class="fas fa-paper-plane mr-2"></i>{{ __('admin.actions.send') }}
                                </button>
                                <button type="button" onclick="closeModal('emailModal{{ $admin->id }}')"
                                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                                    {{ __('admin.actions.cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <script>
            // Modern Tailwind Modal System
            function openModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                    
                    // Add smooth entrance animation
                    setTimeout(() => {
                        const modalContent = modal.querySelector('div > div');
                        if (modalContent) {
                            modalContent.classList.remove('scale-95');
                            modalContent.classList.add('scale-100');
                        }
                    }, 10);
                }
            }

            function closeModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    const modalContent = modal.querySelector('div > div');
                    if (modalContent) {
                        modalContent.classList.remove('scale-100');
                        modalContent.classList.add('scale-95');
                    }
                    
                    // Add smooth exit animation
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }, 200);
                }
            }

            // Close modal when clicking backdrop
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('backdrop-blur-sm')) {
                    const modalId = e.target.id;
                    if (modalId) {
                        closeModal(modalId);
                    }
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const openModals = document.querySelectorAll('.fixed:not(.hidden)');
                    openModals.forEach(modal => {
                        if (modal.id && modal.id.includes('Modal')) {
                            closeModal(modal.id);
                        }
                    });
                }
            });

            // Loading states for buttons
            document.addEventListener('DOMContentLoaded', function() {
                const actionButtons = document.querySelectorAll('a[href*="/admin/dashboard/"], button[type="submit"]');
                actionButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const icon = this.querySelector('i');
                        if (icon && !icon.classList.contains('fa-spinner')) {
                            const originalClass = icon.className;
                            icon.className = 'fas fa-spinner fa-spin mr-2';
                            
                            // Restore original icon after 3 seconds
                            setTimeout(() => {
                                if (icon) {
                                    icon.className = originalClass;
                                }
                            }, 3000);
                        }
                    });
                });

                console.log('{{ __("admin.notifications.modern_admin_panel_loaded") }}');
        });
    </script>
@endsection
