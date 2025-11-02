@extends('layouts.admin')

@section('content')
{{-- Defensive coding: Check if manager exists --}}
@if(!isset($manager) || !$manager || !$manager->exists)
    <div class="flex items-center justify-center min-h-[60vh]">
        <div class="text-center">
            <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-12 h-12 text-red-600 dark:text-red-400"></i>
            </div>
            <h2 class="text-2xl font-bold text-admin-900 dark:text-white mb-2">Yönetici Bulunamadı</h2>
            <p class="text-admin-600 dark:text-admin-400 mb-6">
                Aradığınız yönetici bulunamadı. Yönetici silinmiş veya mevcut olmayabilir.
            </p>
            <a href="{{ route('admin.managers.index') }}"
               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Yöneticiler Listesine Dön
            </a>
        </div>
    </div>
@else
<div class="space-y-6" x-data="managerProfileData()">
    
    <!-- Profile Header -->
    <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 rounded-2xl shadow-elegant p-8 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <a href="{{ route('admin.managers.index') }}" 
                   class="p-2 rounded-lg bg-white/20 hover:bg-white/30 transition-colors">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                
                <!-- Profile Image -->
                <div class="relative">
                    @if($manager->getProfileImage())
                        <img src="{{ $manager->getProfileImage() }}" 
                             alt="{{ $manager->getFullName() }}"
                             class="w-24 h-24 rounded-2xl object-cover border-4 border-white/20 shadow-2xl">
                    @else
                        <div class="w-24 h-24 bg-white/20 rounded-2xl flex items-center justify-center border-4 border-white/20 shadow-2xl">
                            <i data-lucide="user" class="w-12 h-12 text-white/70"></i>
                        </div>
                    @endif
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 {{ $manager->is_active ? 'bg-green-500' : 'bg-red-500' }} rounded-full border-4 border-white flex items-center justify-center">
                        <i data-lucide="{{ $manager->is_active ? 'check' : 'x' }}" class="w-4 h-4 text-white"></i>
                    </div>
                </div>
                
                <!-- Basic Info -->
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $manager->getFullName() }}</h1>
                    <div class="flex items-center space-x-4 text-white/80">
                        @if($manager->role)
                            <span class="flex items-center">
                                <i data-lucide="shield" class="w-4 h-4 mr-2"></i>
                                {{ $manager->role->display_name }}
                            </span>
                        @endif
                        @if($manager->department)
                            <span class="flex items-center">
                                <i data-lucide="building" class="w-4 h-4 mr-2"></i>
                                {{ $manager->getDepartmentName() }}
                            </span>
                        @endif
                        @if($manager->employee_id)
                            <span class="flex items-center">
                                <i data-lucide="id-card" class="w-4 h-4 mr-2"></i>
                                {{ $manager->employee_id }}
                            </span>
                        @endif
                    </div>
                    @if($manager->position)
                        <p class="text-white/70 text-lg mt-1">{{ $manager->position }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.managers.edit', $manager) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl transition-all duration-200">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                    Düzenle
                </a>
                
                <button @click="toggleStatus()" 
                        class="inline-flex items-center px-4 py-2 rounded-xl transition-all duration-200"
                        :class="isActive ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600'">
                    <i :data-lucide="isActive ? 'user-x' : 'user-check'" class="w-4 h-4 mr-2"></i>
                    <span x-text="isActive ? 'Deaktive Et' : 'Aktive Et'"></span>
                </button>
                
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl transition-all duration-200">
                        <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                    </button>
                    
                    <div x-show="open" 
                         x-transition 
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-admin-800 rounded-xl shadow-elegant border border-admin-200 dark:border-admin-700 py-1 z-10">
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-700">
                            <i data-lucide="mail" class="w-4 h-4 mr-3"></i>
                            E-posta Gönder
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-700">
                            <i data-lucide="key" class="w-4 h-4 mr-3"></i>
                            Şifre Sıfırla
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-700">
                            <i data-lucide="download" class="w-4 h-4 mr-3"></i>
                            Rapor İndir
                        </a>
                        <hr class="my-1 border-admin-200 dark:border-admin-600">
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-3"></i>
                            Hesabı Sil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 dark:text-green-400 font-medium">Bu Ay Gelir</p>
                    <p class="text-2xl font-bold text-green-700 dark:text-green-300">
                        ₺{{ number_format($manager->getCurrentMonthRevenue(), 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                        @php
                            $lastMonth = $manager->getLastMonthRevenue();
                            $current = $manager->getCurrentMonthRevenue();
                            $change = $lastMonth > 0 ? (($current - $lastMonth) / $lastMonth) * 100 : 0;
                        @endphp
                        @if($change > 0)
                            <i data-lucide="trending-up" class="w-3 h-3 inline mr-1"></i>
                            +{{ number_format($change, 1) }}% geçen aya göre
                        @elseif($change < 0)
                            <i data-lucide="trending-down" class="w-3 h-3 inline mr-1"></i>
                            {{ number_format($change, 1) }}% geçen aya göre
                        @else
                            <i data-lucide="minus" class="w-3 h-3 inline mr-1"></i>
                            Değişim yok
                        @endif
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Hedef Başarısı</p>
                    <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">
                        {{ number_format($manager->getTargetAchievement(), 1) }}%
                    </p>
                    <div class="w-full bg-blue-200 dark:bg-blue-700 rounded-full h-2 mt-2">
                        <div class="bg-blue-500 h-2 rounded-full transition-all duration-1000" 
                             style="width: {{ min($manager->getTargetAchievement(), 100) }}%"></div>
                    </div>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="target" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-2xl p-6 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">Toplam Lead</p>
                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-300">
                        {{ number_format($manager->getTotalLeads()) }}
                    </p>
                    <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">
                        Bu ay {{ number_format($manager->getCurrentMonthLeads()) }} yeni
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-2xl p-6 border border-amber-200 dark:border-amber-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-amber-600 dark:text-amber-400 font-medium">Dönüşüm Oranı</p>
                    <p class="text-2xl font-bold text-amber-700 dark:text-amber-300">
                        {{ number_format($manager->getConversionRate(), 1) }}%
                    </p>
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">
                        Son 30 gün ortalaması
                    </p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Tabs -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="border-b border-admin-200 dark:border-admin-700">
            <nav class="flex space-x-8 px-6" role="tablist">
                <button @click="activeTab = 'overview'" 
                        :class="activeTab === 'overview' ? 'border-blue-500 text-blue-600' : 'border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>
                    Genel Bakış
                </button>
                <button @click="activeTab = 'hierarchy'" 
                        :class="activeTab === 'hierarchy' ? 'border-blue-500 text-blue-600' : 'border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <i data-lucide="git-branch" class="w-4 h-4 inline mr-2"></i>
                    Hiyerarşi
                </button>
                <button @click="activeTab = 'performance'" 
                        :class="activeTab === 'performance' ? 'border-blue-500 text-blue-600' : 'border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <i data-lucide="bar-chart" class="w-4 h-4 inline mr-2"></i>
                    Performans
                </button>
                <button @click="activeTab = 'activity'" 
                        :class="activeTab === 'activity' ? 'border-blue-500 text-blue-600' : 'border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <i data-lucide="activity" class="w-4 h-4 inline mr-2"></i>
                    Aktivite
                </button>
                <button @click="activeTab = 'settings'" 
                        :class="activeTab === 'settings' ? 'border-blue-500 text-blue-600' : 'border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <i data-lucide="settings" class="w-4 h-4 inline mr-2"></i>
                    Ayarlar
                </button>
            </nav>
        </div>
        
        <!-- Overview Tab -->
        <div x-show="activeTab === 'overview'" x-transition class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Personal Information -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                        <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Kişisel Bilgiler</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-admin-600 dark:text-admin-400">E-posta</label>
                                <p class="text-admin-900 dark:text-white">{{ $manager->email }}</p>
                            </div>
                            @if($manager->phone)
                                <div>
                                    <label class="text-sm font-medium text-admin-600 dark:text-admin-400">Telefon</label>
                                    <p class="text-admin-900 dark:text-white">{{ $manager->phone }}</p>
                                </div>
                            @endif
                            @if($manager->employee_id)
                                <div>
                                    <label class="text-sm font-medium text-admin-600 dark:text-admin-400">Çalışan ID</label>
                                    <p class="text-admin-900 dark:text-white">{{ $manager->employee_id }}</p>
                                </div>
                            @endif
                            <div>
                                <label class="text-sm font-medium text-admin-600 dark:text-admin-400">Kayıt Tarihi</label>
                                <p class="text-admin-900 dark:text-white">{{ $manager->created_at->format('d.m.Y') }}</p>
                            </div>
                            @if($manager->last_login_at)
                                <div>
                                    <label class="text-sm font-medium text-admin-600 dark:text-admin-400">Son Giriş</label>
                                    <p class="text-admin-900 dark:text-white">{{ $manager->last_login_at->format('d.m.Y H:i') }}</p>
                                </div>
                            @endif
                            @if($manager->time_zone)
                                <div>
                                    <label class="text-sm font-medium text-admin-600 dark:text-admin-400">Saat Dilimi</label>
                                    <p class="text-admin-900 dark:text-white">{{ $manager->time_zone }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($manager->bio)
                            <div class="mt-4">
                                <label class="text-sm font-medium text-admin-600 dark:text-admin-400">Biografi</label>
                                <p class="text-admin-900 dark:text-white mt-1">{{ $manager->bio }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Recent Activity -->
                    <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                        <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Son Aktiviteler</h3>
                        <div class="space-y-3">
                            @forelse($manager->recentActivities()->take(5)->get() as $activity)
                                <div class="flex items-center space-x-3 p-3 bg-white dark:bg-admin-800 rounded-lg border border-admin-200 dark:border-admin-600">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                        <i data-lucide="activity" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-admin-900 dark:text-white">{{ $activity->description }}</p>
                                        <p class="text-xs text-admin-500">{{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-admin-500 text-sm">Henüz aktivite bulunmuyor.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar Information -->
                <div class="space-y-6">
                    <!-- Role & Permissions -->
                    <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                        <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Rol & Yetkiler</h3>
                        @if($manager->role)
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-admin-600 dark:text-admin-400">Rol</span>
                                    <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-lg">
                                        {{ $manager->role->display_name }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-admin-600 dark:text-admin-400">Hiyerarşi Seviyesi</span>
                                    <span class="text-sm font-medium text-admin-900 dark:text-white">
                                        {{ $manager->role->hierarchy_level }}
                                    </span>
                                </div>
                                <div class="mt-3">
                                    <span class="text-sm text-admin-600 dark:text-admin-400">Yetkiler</span>
                                    <div class="mt-2 space-y-1">
                                        @foreach($manager->role->permissions()->take(5)->get() as $permission)
                                            <span class="inline-block px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs rounded">
                                                {{ $permission->display_name }}
                                            </span>
                                        @endforeach
                                        @if($manager->role->permissions()->count() > 5)
                                            <span class="text-xs text-admin-500">
                                                ve {{ $manager->role->permissions()->count() - 5 }} yetki daha...
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-admin-500 text-sm">Rol atanmamış</p>
                        @endif
                    </div>
                    
                    <!-- Statistics -->
                    <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                        <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">İstatistikler</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-admin-600 dark:text-admin-400">Aktif Gün</span>
                                <span class="text-sm font-medium text-admin-900 dark:text-white">
                                    {{ $manager->created_at->diffInDays(now()) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-admin-600 dark:text-admin-400">Toplam Giriş</span>
                                <span class="text-sm font-medium text-admin-900 dark:text-white">
                                    {{ $manager->login_count ?? 0 }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-admin-600 dark:text-admin-400">Başarı Oranı</span>
                                <span class="text-sm font-medium text-admin-900 dark:text-white">
                                    {{ number_format($manager->getSuccessRate(), 1) }}%
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-admin-600 dark:text-admin-400">Verimlilik</span>
                                <span class="text-sm font-medium" 
                                      :class="$manager->getEfficiencyScore() >= 80 ? 'text-green-600 dark:text-green-400' : 
                                              ($manager->getEfficiencyScore() >= 60 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400')">
                                    {{ number_format($manager->getEfficiencyScore(), 1) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hierarchy Tab -->
        <div x-show="activeTab === 'hierarchy'" x-transition class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Supervisor -->
                <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                    <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Süpervizör</h3>
                    @if($manager->supervisor)
                        <div class="flex items-center space-x-4">
                            @if($manager->supervisor->getProfileImage())
                                <img src="{{ $manager->supervisor->getProfileImage() }}" 
                                     class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div class="w-12 h-12 bg-admin-200 dark:bg-admin-600 rounded-full flex items-center justify-center">
                                    <i data-lucide="user" class="w-6 h-6 text-admin-400"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-medium text-admin-900 dark:text-white">
                                    {{ $manager->supervisor->getFullName() }}
                                </h4>
                                @if($manager->supervisor->role)
                                    <p class="text-sm text-admin-600 dark:text-admin-400">
                                        {{ $manager->supervisor->role->display_name }}
                                    </p>
                                @endif
                                <p class="text-xs text-admin-500">
                                    {{ $manager->supervisor->email }}
                                </p>
                            </div>
                            <div class="ml-auto">
                                <a href="{{ route('admin.managers.show', $manager->supervisor) }}" 
                                   class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                    <i data-lucide="external-link" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </div>
                    @else
                        <p class="text-admin-500 text-sm">Süpervizör atanmamış</p>
                    @endif
                </div>
                
                <!-- Subordinates -->
                <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                    <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">
                        Alt Yöneticiler ({{ $manager->subordinates()->count() }})
                    </h3>
                    @if($manager->subordinates()->count() > 0)
                        <div class="space-y-3 max-h-64 overflow-y-auto">
                            @foreach($manager->subordinates as $subordinate)
                                <div class="flex items-center space-x-3 p-2 bg-white dark:bg-admin-800 rounded-lg">
                                    @if($subordinate->getProfileImage())
                                        <img src="{{ $subordinate->getProfileImage() }}" 
                                             class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 bg-admin-200 dark:bg-admin-600 rounded-full flex items-center justify-center">
                                            <i data-lucide="user" class="w-4 h-4 text-admin-400"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-admin-900 dark:text-white">
                                            {{ $subordinate->getFullName() }}
                                        </p>
                                        @if($subordinate->role)
                                            <p class="text-xs text-admin-500">
                                                {{ $subordinate->role->display_name }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="w-2 h-2 {{ $subordinate->is_active ? 'bg-green-500' : 'bg-red-500' }} rounded-full"></span>
                                        <a href="{{ route('admin.managers.show', $subordinate) }}" 
                                           class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                            <i data-lucide="external-link" class="w-3 h-3"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-admin-500 text-sm">Alt yönetici bulunmuyor</p>
                    @endif
                </div>
            </div>
            
            <!-- Hierarchy Tree -->
            <div class="mt-6 bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Hiyerarşi Ağacı</h3>
                <div class="hierarchy-tree" x-data="hierarchyTree()">
                    <!-- Tree visualization will be implemented with JavaScript -->
                    <div id="hierarchy-chart" class="min-h-96"></div>
                </div>
            </div>
        </div>
        
        <!-- Performance Tab -->
        <div x-show="activeTab === 'performance'" x-transition class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Charts -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Revenue Chart -->
                    <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                        <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Aylık Gelir Trendi</h3>
                        <div class="h-64" x-data="revenueChart()">
                            <canvas x-ref="revenueCanvas"></canvas>
                        </div>
                    </div>
                    
                    <!-- Lead Performance -->
                    <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                        <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Lead Performansı</h3>
                        <div class="h-64" x-data="leadChart()">
                            <canvas x-ref="leadCanvas"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Performance Metrics -->
                <div class="space-y-6">
                    <!-- Goals -->
                    <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                        <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Hedefler</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-admin-600 dark:text-admin-400">Aylık Gelir Hedefi</span>
                                    <span class="text-sm font-medium text-admin-900 dark:text-white">
                                        {{ number_format($manager->getTargetAchievement(), 1) }}%
                                    </span>
                                </div>
                                <div class="w-full bg-admin-200 dark:bg-admin-600 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full transition-all duration-1000" 
                                         style="width: {{ min($manager->getTargetAchievement(), 100) }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-admin-500 mt-1">
                                    <span>₺{{ number_format($manager->getCurrentMonthRevenue(), 0, ',', '.') }}</span>
                                    <span>₺{{ number_format($manager->monthly_target ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-admin-600 dark:text-admin-400">Lead Hedefi</span>
                                    <span class="text-sm font-medium text-admin-900 dark:text-white">
                                        {{ number_format($manager->getLeadTargetAchievement(), 1) }}%
                                    </span>
                                </div>
                                <div class="w-full bg-admin-200 dark:bg-admin-600 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full transition-all duration-1000" 
                                         style="width: {{ min($manager->getLeadTargetAchievement(), 100) }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-admin-500 mt-1">
                                    <span>{{ $manager->getCurrentMonthLeads() }}</span>
                                    <span>{{ ($manager->max_leads_per_day ?? 50) * date('j') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Performance Score -->
                    <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                        <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Performans Skoru</h3>
                        <div class="text-center">
                            <div class="relative w-24 h-24 mx-auto">
                                <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="40" stroke="currentColor" 
                                            stroke-width="10" fill="transparent" 
                                            class="text-admin-200 dark:text-admin-600"/>
                                    <circle cx="50" cy="50" r="40" stroke="currentColor" 
                                            stroke-width="10" fill="transparent" 
                                            stroke-dasharray="{{ 2 * pi() * 40 }}" 
                                            stroke-dashoffset="{{ 2 * pi() * 40 * (100 - $manager->getPerformanceScore()) / 100 }}"
                                            class="text-blue-500 transition-all duration-1000"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-admin-900 dark:text-white">
                                        {{ number_format($manager->getPerformanceScore(), 0) }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-sm text-admin-600 dark:text-admin-400 mt-2">
                                Genel performans skoru
                            </p>
                        </div>
                    </div>
                    
                    <!-- Recent Achievements -->
                    <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                        <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Son Başarılar</h3>
                        <div class="space-y-3">
                            @php
                                $achievements = $manager->getRecentAchievements();
                            @endphp
                            @forelse($achievements as $achievement)
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center">
                                        <i data-lucide="award" class="w-4 h-4 text-yellow-600 dark:text-yellow-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-admin-900 dark:text-white">{{ $achievement['title'] }}</p>
                                        <p class="text-xs text-admin-500">{{ $achievement['date'] }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-admin-500 text-sm">Henüz başarı bulunmuyor.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Activity Tab -->
        <div x-show="activeTab === 'activity'" x-transition class="p-6">
            <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-admin-900 dark:text-white">Aktivite Geçmişi</h3>
                    <select class="admin-input text-sm" x-model="activityFilter" @change="filterActivities()">
                        <option value="all">Tümü</option>
                        <option value="login">Giriş/Çıkış</option>
                        <option value="lead">Lead İşlemleri</option>
                        <option value="system">Sistem</option>
                    </select>
                </div>
                
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse($manager->activities()->latest()->take(50)->get() as $activity)
                        <div class="flex items-start space-x-3 p-3 bg-white dark:bg-admin-800 rounded-lg border border-admin-200 dark:border-admin-600">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mt-1"
                                 :class="{
                                     'bg-green-100 dark:bg-green-900/30': '{{ $activity->type }}' === 'login',
                                     'bg-blue-100 dark:bg-blue-900/30': '{{ $activity->type }}' === 'lead',
                                     'bg-purple-100 dark:bg-purple-900/30': '{{ $activity->type }}' === 'system'
                                 }">
                                <i :data-lucide="{
                                       'login': 'log-in',
                                       'lead': 'user-plus',
                                       'system': 'settings'
                                   }['{{ $activity->type }}'] || 'activity'" 
                                   class="w-4 h-4"
                                   :class="{
                                       'text-green-600 dark:text-green-400': '{{ $activity->type }}' === 'login',
                                       'text-blue-600 dark:text-blue-400': '{{ $activity->type }}' === 'lead',
                                       'text-purple-600 dark:text-purple-400': '{{ $activity->type }}' === 'system'
                                   }"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-admin-900 dark:text-white">{{ $activity->description }}</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <p class="text-xs text-admin-500">{{ $activity->created_at->format('d.m.Y H:i') }}</p>
                                    @if($activity->ip_address)
                                        <span class="text-admin-400">•</span>
                                        <p class="text-xs text-admin-500">{{ $activity->ip_address }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-admin-500 text-sm">Aktivite geçmişi bulunmuyor.</p>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Settings Tab -->
        <div x-show="activeTab === 'settings'" x-transition class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Account Settings -->
                <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                    <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Hesap Ayarları</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-admin-900 dark:text-white">Hesap Durumu</p>
                                <p class="text-sm text-admin-600 dark:text-admin-400">
                                    Hesap şu anda {{ $manager->is_active ? 'aktif' : 'pasif' }}
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $manager->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' }}">
                                {{ $manager->is_active ? 'Aktif' : 'Pasif' }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-admin-900 dark:text-white">İki Faktörlü Doğrulama</p>
                                <p class="text-sm text-admin-600 dark:text-admin-400">
                                    {{ $manager->two_factor_enabled ? 'Aktif' : 'Pasif' }}
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $manager->two_factor_enabled ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' }}">
                                {{ $manager->two_factor_enabled ? 'Açık' : 'Kapalı' }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-admin-900 dark:text-white">E-posta Bildirimleri</p>
                                <p class="text-sm text-admin-600 dark:text-admin-400">
                                    {{ $manager->email_notifications ? 'Açık' : 'Kapalı' }}
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $manager->email_notifications ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' }}">
                                {{ $manager->email_notifications ? 'Açık' : 'Kapalı' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Performance Settings -->
                <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                    <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Performans Ayarları</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-admin-600 dark:text-admin-400">Aylık Hedef</label>
                            <p class="text-lg font-semibold text-admin-900 dark:text-white">
                                ₺{{ number_format($manager->monthly_target ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-admin-600 dark:text-admin-400">Günlük Maksimum Lead</label>
                            <p class="text-lg font-semibold text-admin-900 dark:text-white">
                                {{ $manager->max_leads_per_day ?? 50 }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-admin-600 dark:text-admin-400">Saat Dilimi</label>
                            <p class="text-lg font-semibold text-admin-900 dark:text-white">
                                {{ $manager->time_zone ?? 'Europe/Istanbul' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4">
                    <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Hızlı İşlemler</h3>
                    <div class="space-y-3">
                        <button @click="resetPassword()" 
                                class="w-full flex items-center px-4 py-3 bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-lg transition-colors">
                            <i data-lucide="key" class="w-4 h-4 mr-3"></i>
                            Şifre Sıfırla
                        </button>
                        
                        <button @click="sendEmail()" 
                                class="w-full flex items-center px-4 py-3 bg-green-100 dark:bg-green-900/30 hover:bg-green-200 dark:hover:bg-green-900/50 text-green-700 dark:text-green-300 rounded-lg transition-colors">
                            <i data-lucide="mail" class="w-4 h-4 mr-3"></i>
                            E-posta Gönder
                        </button>
                        
                        <button @click="generateReport()" 
                                class="w-full flex items-center px-4 py-3 bg-purple-100 dark:bg-purple-900/30 hover:bg-purple-200 dark:hover:bg-purple-900/50 text-purple-700 dark:text-purple-300 rounded-lg transition-colors">
                            <i data-lucide="download" class="w-4 h-4 mr-3"></i>
                            Rapor İndir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function managerProfileData() {
    return {
        activeTab: 'overview',
        isActive: {{ $manager->is_active ? 'true' : 'false' }},
        activityFilter: 'all',
        
        toggleStatus() {
            // AJAX call to toggle manager status
            fetch(`{{ route('admin.managers.toggle-status', $manager) }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ is_active: !this.isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.isActive = data.is_active;
                    
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                    
                    // Reload page after delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Hata!', 'Bir hata oluştu.', 'error');
            });
        },
        
        filterActivities() {
            // Filter activities based on selected type
            const activities = document.querySelectorAll('[data-activity-type]');
            activities.forEach(activity => {
                const type = activity.getAttribute('data-activity-type');
                if (this.activityFilter === 'all' || type === this.activityFilter) {
                    activity.style.display = 'block';
                } else {
                    activity.style.display = 'none';
                }
            });
        },
        
        resetPassword() {
            Swal.fire({
                title: 'Şifre Sıfırla',
                text: '{{ $manager->getFullName() }} kullanıcısının şifresini sıfırlamak istediğinizden emin misiniz?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Evet, Sıfırla',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to reset password
                    fetch(`{{ route('admin.managers.reset-password', $manager) }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Başarılı!', data.message, 'success');
                        } else {
                            Swal.fire('Hata!', data.message, 'error');
                        }
                    });
                }
            });
        },
        
        sendEmail() {
            Swal.fire({
                title: 'E-posta Gönder',
                html: `
                    <textarea id="emailMessage" class="swal2-textarea" placeholder="Mesajınızı yazın..."></textarea>
                `,
                showCancelButton: true,
                confirmButtonText: 'Gönder',
                cancelButtonText: 'İptal',
                preConfirm: () => {
                    const message = document.getElementById('emailMessage').value;
                    if (!message) {
                        Swal.showValidationMessage('Lütfen bir mesaj yazın');
                    }
                    return { message: message };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to send email
                    Swal.fire('Başarılı!', 'E-posta gönderildi.', 'success');
                }
            });
        },
        
        generateReport() {
            // Generate and download performance report
            window.open(`{{ route('admin.managers.report', $manager) }}`, '_blank');
        }
    }
}

function hierarchyTree() {
    return {
        init() {
            // Initialize hierarchy tree visualization
            // This would integrate with a library like D3.js or similar
            console.log('Hierarchy tree initialized');
        }
    }
}

function revenueChart() {
    return {
        chart: null,
        
        init() {
            const ctx = this.$refs.revenueCanvas.getContext('2d');
            
            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran'],
                    datasets: [{
                        label: 'Gelir',
                        data: @json($manager->getMonthlyRevenueData()),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
}

function leadChart() {
    return {
        chart: null,
        
        init() {
            const ctx = this.$refs.leadCanvas.getContext('2d');
            
            this.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'],
                    datasets: [{
                        label: 'Lead Sayısı',
                        data: @json($manager->getWeeklyLeadData()),
                        backgroundColor: 'rgba(34, 197, 94, 0.8)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});
</script>
@endpush