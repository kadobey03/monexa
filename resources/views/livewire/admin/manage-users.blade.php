@php
     $isDark = Auth('admin')->User()->dashboard_style !== 'light';
@endphp
<div class="min-h-screen bg-gray-50 {{ $isDark ? 'dark:bg-gray-900' : '' }}">
    <!-- Header Section -->
    <div class="bg-white {{ $isDark ? 'dark:bg-gray-800' : '' }} shadow-sm border-b border-gray-200 {{ $isDark ? 'dark:border-gray-700' : '' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 {{ $isDark ? 'dark:text-white' : '' }} flex items-center">
                        <i class="fas fa-users text-blue-600 mr-3"></i>
                        {{ $settings->site_name }} Kullanıcıları
                    </h1>
                    <p class="mt-1 text-sm text-gray-500 {{ $isDark ? 'dark:text-gray-400' : '' }}">
                        Kullanıcı hesaplarını yönetin ve düzenleyin
                    </p>
                </div>
                <div class="flex items-center">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 {{ $isDark ? 'dark:bg-blue-800 dark:text-blue-100' : '' }}">
                        <i class="fas fa-user-check mr-2"></i>
                        {{ $users->total() }} Kullanıcı
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        {{-- Error Alert --}}
        <div id="general-error-alert" class="hidden mb-4">
            <div class="rounded-md bg-red-50 p-4 border border-red-200 {{ $isDark ? 'dark:bg-red-900 dark:border-red-700' : '' }}">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 {{ $isDark ? 'dark:text-red-100' : '' }}">
                            Bir Hata Oluştu!
                        </h3>
                        <div class="mt-2 text-sm text-red-700 {{ $isDark ? 'dark:text-red-200' : '' }}">
                            <span id="error-message-text">Lütfen tekrar deneyin veya sistem yöneticisiyle iletişime geçin.</span>
                        </div>
                    </div>
                    <div class="ml-auto pl-3">
                        <button onclick="document.getElementById('general-error-alert').classList.add('hidden')"
                                class="text-red-400 hover:text-red-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Success Alert --}}
        <div id="success-alert" class="hidden mb-4">
            <div class="rounded-md bg-green-50 p-4 border border-green-200 {{ $isDark ? 'dark:bg-green-900 dark:border-green-700' : '' }}">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800 {{ $isDark ? 'dark:text-green-100' : '' }}">
                            Başarılı!
                        </h3>
                        <div class="mt-2 text-sm text-green-700 {{ $isDark ? 'dark:text-green-200' : '' }}">
                            <span id="success-message-text">İşlem başarıyla tamamlandı.</span>
                        </div>
                    </div>
                    <div class="ml-auto pl-3">
                        <button onclick="document.getElementById('success-alert').classList.add('hidden')"
                                class="text-green-400 hover:text-green-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <!-- Main Content Card -->
        <div class="bg-white {{ $isDark ? 'dark:bg-gray-800' : '' }} shadow-xl rounded-lg border border-gray-200 {{ $isDark ? 'dark:border-gray-700' : '' }}">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 rounded-t-lg">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    <!-- Search Box -->
                    <div class="flex-1 lg:max-w-md">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input wire:model.debounce.500ms="searchvalue"
                                   type="search"
                                   class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                   placeholder="👤 İsim, kullanıcı adı veya 📧 e-posta ile ara..."
                                   aria-label="Kullanıcı arama"
                                   autocomplete="off">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-filter text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap items-center gap-2">
                        @if ($checkrecord)
                            <div class="flex items-center space-x-2">
                                <select wire:model="action"
                                        class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                                    <option value="Delete">🗑️ Sil</option>
                                    <option value="Clear">🧹 Hesabı Temizle</option>
                                </select>
                                <button wire:click="delsystemuser"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fas fa-check mr-2"></i>Uygula
                                </button>
                            </div>
                            <button onclick="openModal('TradingModal')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <i class="fas fa-coins mr-2"></i>ROI Ekle
                            </button>
                            <button onclick="openModal('topupModal')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-plus mr-2"></i>Bakiye Yükle
                            </button>
                        @else
                            <button onclick="openModal('adduser')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-user-plus mr-2"></i>Yeni Kullanıcı
                            </button>
                            <a href="{{ route('emailservices') }}"
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-envelope mr-2"></i>Mesaj Gönder
                            </a>
                        @endif
                    </div>
                </div>
                
                <!-- Gelişmiş Filtreleme Bölümü -->
                <div class="mt-4 bg-white bg-opacity-10 backdrop-blur rounded-lg p-4 border border-white border-opacity-20">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Lead Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-white mb-2">
                                <i class="fas fa-tags mr-2"></i>LEAD STATUS
                            </label>
                            <select wire:model="statusFilter"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900">
                                <option value="">Tüm Durumlar</option>
                                @foreach ($this->leadStatuses as $status)
                                    <option value="{{ $status->name }}">{{ $status->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Assigned Admin Filter -->
                        <div>
                            <label class="block text-sm font-medium text-white mb-2">
                                <i class="fas fa-user-tie mr-2"></i>ASSIGNED ADMIN
                            </label>
                            <select wire:model="adminFilter"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900">
                                <option value="">Tüm Adminler</option>
                                @foreach ($this->admins as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->firstName }} {{ $admin->lastName }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Date From Filter -->
                        <div>
                            <label class="block text-sm font-medium text-white mb-2">
                                <i class="fas fa-calendar-alt mr-2"></i>BAŞLANGIÇ TARİHİ
                            </label>
                            <input type="date"
                                   wire:model="dateFromFilter"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900"
                                   placeholder="gg.aa.yyyy">
                        </div>
                        
                        <!-- Date To Filter -->
                        <div>
                            <label class="block text-sm font-medium text-white mb-2">
                                <i class="fas fa-calendar-check mr-2"></i>BİTİŞ TARİHİ
                            </label>
                            <input type="date"
                                   wire:model="dateToFilter"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-900"
                                   placeholder="gg.aa.yyyy">
                        </div>
                    </div>
                    
                    <!-- Filter Actions -->
                    <div class="mt-4 flex justify-end space-x-2">
                        <button wire:click="clearFilters"
                                class="inline-flex items-center px-4 py-2 border border-white border-opacity-30 rounded-md shadow-sm text-sm font-medium text-white bg-white bg-opacity-10 hover:bg-opacity-20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                            <i class="fas fa-eraser mr-2"></i>Filtreleri Temizle
                        </button>
                    </div>
                </div>
            </div>
            <!-- Table Section -->
            <div class="overflow-hidden">
                <!-- Desktop Table -->
                <div class="hidden lg:block">
                    <table class="min-w-full divide-y divide-gray-200 {{ $isDark ? 'dark:divide-gray-700' : '' }}">
                        <thead class="bg-gray-50 {{ $isDark ? 'dark:bg-gray-700' : '' }}">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }} uppercase tracking-wider">
                                    <input type="checkbox"
                                           wire:model="selectPage"
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           aria-label="Tüm kullanıcıları seç">
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }} uppercase tracking-wider">
                                    <i class="fas fa-user mr-2 text-blue-600"></i>Müşteri Adı var
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }} uppercase tracking-wider">
                                    <i class="fas fa-at mr-2 text-blue-600"></i>Kullanıcı Adı
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }} uppercase tracking-wider">
                                    <i class="fas fa-envelope mr-2 text-blue-600"></i>E-posta
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }} uppercase tracking-wider">
                                    <i class="fas fa-phone mr-2 text-blue-600"></i>Telefon
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }} uppercase tracking-wider">
                                    <i class="fas fa-toggle-on mr-2 text-blue-600"></i>Durum
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }} uppercase tracking-wider">
                                    <i class="fas fa-tags mr-2 text-blue-600"></i>Lead Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }} uppercase tracking-wider">
                                    <i class="fas fa-bullseye mr-2 text-blue-600"></i>UTM Bilgileri
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }} uppercase tracking-wider">
                                    <i class="fas fa-calendar mr-2 text-blue-600"></i>Kayıt Tarihi
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }} uppercase tracking-wider">
                                    <i class="fas fa-cogs mr-2 text-blue-600"></i>İşlem
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white {{ $isDark ? 'dark:bg-gray-800' : '' }} divide-y divide-gray-200 {{ $isDark ? 'dark:divide-gray-700' : '' }}">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 {{ $isDark ? 'dark:hover:bg-gray-700' : '' }} transition-colors duration-150 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <input type="checkbox"
                                               wire:model="checkrecord"
                                               value="{{ $user->id }}"
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                               aria-label="{{ $user->name }} kullanıcısını seç">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-blue-100 {{ $isDark ? 'dark:bg-blue-800' : '' }} flex items-center justify-center">
                                                    <span class="text-sm font-medium text-blue-800 {{ $isDark ? 'dark:text-blue-100' : '' }}">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 {{ $isDark ? 'dark:text-white' : '' }}">
                                                    {{ $user->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 {{ $isDark ? 'dark:bg-gray-700 dark:text-gray-200' : '' }}">
                                            {{ $user->username }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }}">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 {{ $isDark ? 'dark:text-white' : '' }}">
                                        {{ $user->phone ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($user->status == 'active')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i>Pasif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <select wire:change="updateLeadStatus({{ $user->id }}, $event.target.value)"
                                                class="text-xs rounded-md border-0 py-1.5 px-3 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset {{ $isDark ? 'dark:bg-gray-700 dark:text-white dark:ring-gray-600' : 'bg-white text-gray-900 ring-gray-300' }}"
                                                style="background-color: {{ $user->leadStatus?->color ?? '#6c757d' }}; color: white; min-width: 120px;">
                                            <option value="" style="background-color: #6c757d; color: white;">Status Seç</option>
                                            @foreach ($this->leadStatuses as $status)
                                                <option value="{{ $status->name }}"
                                                        style="background-color: {{ $status->color }}; color: white;"
                                                        @if($user->lead_status === $status->name) selected @endif>
                                                    {{ $status->display_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }}">
                                        <div class="space-y-1">
                                            @if($user->utm_source)
                                                <div class="flex items-center text-xs">
                                                    <span class="text-gray-400 font-medium mr-1">Source:</span>
                                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full">{{ $user->utm_source }}</span>
                                                </div>
                                            @endif
                                            @if($user->utm_campaign)
                                                <div class="flex items-center text-xs">
                                                    <span class="text-gray-400 font-medium mr-1">Campaign:</span>
                                                    <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full">{{ $user->utm_campaign }}</span>
                                                </div>
                                            @endif
                                            @if(!$user->utm_source && !$user->utm_campaign)
                                                <span class="text-xs text-gray-400 italic">Bilgi yok</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }}">
                                        <div class="text-sm">{{ $user->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('viewuser', $user->id) }}"
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 ease-in-out {{ $isDark ? 'dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600' : '' }}">
                                            <i class="fas fa-edit mr-2"></i>Yönet
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-12 text-center">
                                        <div class="text-gray-400">
                                            <i class="fas fa-users text-6xl mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900 {{ $isDark ? 'dark:text-white' : '' }} mb-2">Kullanıcı Bulunamadı</h3>
                                            <p class="text-sm text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }}">
                                                Henüz hiç kullanıcı eklenmemiş veya arama kriterlerinize uygun kullanıcı bulunamadı.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="lg:hidden">
                    <div class="space-y-4 p-4">
                        @forelse ($users as $user)
                            <div class="bg-white {{ $isDark ? 'dark:bg-gray-700' : '' }} rounded-lg shadow border border-gray-200 {{ $isDark ? 'dark:border-gray-600' : '' }} p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               wire:model="checkrecord"
                                               value="{{ $user->id }}"
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 mr-3">
                                        <div class="h-8 w-8 rounded-full bg-blue-100 {{ $isDark ? 'dark:bg-blue-800' : '' }} flex items-center justify-center mr-3">
                                            <span class="text-xs font-medium text-blue-800 {{ $isDark ? 'dark:text-blue-100' : '' }}">
                                                {{ substr($user->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900 {{ $isDark ? 'dark:text-white' : '' }}">{{ $user->name }}</h3>
                                            <p class="text-xs text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }}">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    @if ($user->status == 'active')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>Pasif
                                        </span>
                                    @endif
                                </div>
                                <div class="grid grid-cols-2 gap-3 text-xs text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-3">
                                    <div>
                                        <span class="font-medium">Kullanıcı Adı:</span>
                                        <span class="ml-1 px-2 py-1 bg-gray-100 {{ $isDark ? 'dark:bg-gray-600' : '' }} rounded">{{ $user->username }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Telefon:</span> {{ $user->phone ?? '-' }}
                                    </div>
                                    <div class="col-span-2">
                                        <span class="font-medium">Lead Status:</span>
                                        <select wire:change="updateLeadStatus({{ $user->id }}, $event.target.value)"
                                                class="ml-2 text-xs rounded border-0 py-1 px-2 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset {{ $isDark ? 'dark:bg-gray-600 dark:text-white dark:ring-gray-500' : 'bg-white text-gray-900 ring-gray-300' }}"
                                                style="background-color: {{ $user->leadStatus?->color ?? '#6c757d' }}; color: white; min-width: 100px; font-size: 10px;">
                                            <option value="" style="background-color: #6c757d; color: white;">Status Seç</option>
                                            @foreach ($this->leadStatuses as $status)
                                                <option value="{{ $status->name }}"
                                                        style="background-color: {{ $status->color }}; color: white;"
                                                        @if($user->lead_status === $status->name) selected @endif>
                                                    {{ $status->display_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <span class="font-medium">UTM Bilgileri:</span>
                                        <div class="mt-1 space-y-1">
                                            @if($user->utm_source)
                                                <div class="flex items-center text-xs">
                                                    <span class="text-gray-400 font-medium mr-1">Source:</span>
                                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full">{{ $user->utm_source }}</span>
                                                </div>
                                            @endif
                                            @if($user->utm_campaign)
                                                <div class="flex items-center text-xs">
                                                    <span class="text-gray-400 font-medium mr-1">Campaign:</span>
                                                    <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full">{{ $user->utm_campaign }}</span>
                                                </div>
                                            @endif
                                            @if(!$user->utm_source && !$user->utm_campaign)
                                                <span class="text-xs text-gray-400 italic">Bilgi yok</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-span-2">
                                        <span class="font-medium">Kayıt:</span> {{ $user->created_at->format('d M Y') }} ({{ $user->created_at->diffForHumans() }})
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <a href="{{ route('viewuser', $user->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 {{ $isDark ? 'dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200 dark:hover:bg-gray-500' : '' }}">
                                        <i class="fas fa-edit mr-1"></i>Yönet
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 {{ $isDark ? 'dark:text-white' : '' }} mb-2">Kullanıcı Bulunamadı</h3>
                                <p class="text-sm text-gray-500 {{ $isDark ? 'dark:text-gray-300' : '' }}">
                                    Henüz hiç kullanıcı eklenmemiş veya arama kriterlerinize uygun kullanıcı bulunamadı.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Footer / Pagination -->
            <div class="bg-gray-50 {{ $isDark ? 'dark:bg-gray-700' : '' }} px-6 py-4 border-t border-gray-200 {{ $isDark ? 'dark:border-gray-600' : '' }} rounded-b-lg">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                    <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                        <div class="flex items-center space-x-2">
                            <label class="text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }}">Sayfa başına:</label>
                            <select wire:model="pagenum"
                                    class="rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500 {{ $isDark ? 'dark:bg-gray-600 dark:border-gray-500 dark:text-white' : '' }}">
                                <option>10</option>
                                <option>20</option>
                                <option>50</option>
                                <option>100</option>
                                <option>200</option>
                            </select>
                        </div>
                        <div class="flex items-center space-x-2">
                            <label class="text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }}">Sırala:</label>
                            <select wire:model="orderby"
                                    class="rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500 {{ $isDark ? 'dark:bg-gray-600 dark:border-gray-500 dark:text-white' : '' }}">
                                <option value="id">ID</option>
                                <option value="name">İsim</option>
                                <option value="email">E-posta</option>
                                <option value="created_at">Kayıt Tarihi</option>
                            </select>
                            <select wire:model="orderdirection"
                                    class="rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500 {{ $isDark ? 'dark:bg-gray-600 dark:border-gray-500 dark:text-white' : '' }}">
                                <option value="desc">↓ Azalan</option>
                                <option value="asc">↑ Artan</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col sm:items-end">
                        <div class="text-sm text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-2">
                            {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} arası,
                            toplam {{ $users->total() }} kullanıcı
                        </div>
                        <div>
                            <x-admin-pagination :paginator="$users" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modern Modal System with Tailwind CSS -->

<!-- Add User Modal -->
<div id="adduser" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal('adduser')"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white {{ $isDark ? 'dark:bg-gray-800' : '' }} rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-white" id="addUserModalLabel">
                        <i class="fas fa-user-plus mr-2"></i>Yeni Kullanıcı Ekle
                    </h3>
                    <button onclick="closeModal('adduser')" class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-6">
                <form wire:submit.prevent="saveUser">
                    <div class="space-y-6">
                        <!-- Ad Soyad -->
                        <div>
                            <label for="fullname" class="block text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-2">
                                <i class="fas fa-user mr-2 text-blue-600"></i>Ad Soyad
                            </label>
                            <input type="text"
                                   wire:model.defer="fullname"
                                   id="fullname"
                                   class="block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $isDark ? 'dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400' : '' }} @error('fullname') border-red-300 @enderror"
                                   placeholder="Ad ve soyad girin"
                                   required>
                            @error('fullname')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- E-posta -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-2">
                                <i class="fas fa-envelope mr-2 text-blue-600"></i>E-posta
                            </label>
                            <input type="email"
                                   wire:model.defer="email"
                                   id="email"
                                   class="block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $isDark ? 'dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400' : '' }} @error('email') border-red-300 @enderror"
                                   placeholder="ornek@domain.com"
                                   required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Telefon -->
                        <div>
                            <label for="mobile_number" class="block text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-2">
                                <i class="fas fa-phone mr-2 text-blue-600"></i>Telefon
                            </label>
                            <input type="tel"
                                   wire:model.defer="mobile_number"
                                   id="mobile_number"
                                   class="block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $isDark ? 'dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400' : '' }} @error('mobile_number') border-red-300 @enderror"
                                   placeholder="+90 5XX XXX XX XX"
                                   required>
                            @error('mobile_number')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Rol -->
                        <div>
                            <label for="user_role" class="block text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-2">
                                <i class="fas fa-user-tag mr-2 text-blue-600"></i>Rol
                            </label>
                            <select wire:model.defer="user_role"
                                    id="user_role"
                                    class="block w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $isDark ? 'dark:bg-gray-700 dark:border-gray-600 dark:text-white' : '' }} @error('user_role') border-red-300 @enderror"
                                    required>
                                <option value="user" selected>Kullanıcı</option>
                                <option value="admin">Admin</option>
                                <option value="moderator">Moderatör</option>
                            </select>
                            @error('user_role')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Şifre -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-2">
                                <i class="fas fa-lock mr-2 text-blue-600"></i>Şifre
                            </label>
                            <input type="password"
                                   wire:model.defer="password"
                                   id="password"
                                   class="block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $isDark ? 'dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400' : '' }} @error('password') border-red-300 @enderror"
                                   placeholder="En az 8 karakter"
                                   required>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Şifre Tekrar -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-2">
                                <i class="fas fa-lock mr-2 text-blue-600"></i>Şifre Tekrar
                            </label>
                            <input type="password"
                                   wire:model.defer="password_confirmation"
                                   id="password_confirmation"
                                   class="block w-full px-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $isDark ? 'dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400' : '' }} @error('password_confirmation') border-red-300 @enderror"
                                   placeholder="Şifreyi tekrar girin"
                                   required>
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Butonlar -->
                    <div class="mt-8 flex space-x-3">
                        <button type="button"
                                onclick="closeModal('adduser')"
                                class="flex-1 py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 {{ $isDark ? 'dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600' : '' }}">
                            <i class="fas fa-times mr-2"></i>İptal
                        </button>
                        <button type="submit"
                                wire:loading.attr="disabled"
                                wire:target="saveUser"
                                class="flex-1 py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="saveUser" class="flex items-center justify-center">
                                <i class="fas fa-user-plus mr-2"></i>Kullanıcı Ekle
                            </span>
                            <span wire:loading wire:target="saveUser" class="flex items-center justify-center">
                                <i class="fas fa-spinner fa-spin mr-2"></i>Ekleniyor...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Trading/ROI Modal -->
<div id="TradingModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal('TradingModal')"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white {{ $isDark ? 'dark:bg-gray-800' : '' }} rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <!-- Modal Header -->
            <div class="bg-yellow-500 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-white">
                        <i class="fas fa-coins mr-2"></i>Seçili Kullanıcılara ROI Ekle
                    </h3>
                    <button onclick="closeModal('TradingModal')" class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-6">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Toplu ROI Ekleme:</strong> Seçili kullanıcılara aynı plan üzerinden ROI eklenecektir.
                            </p>
                        </div>
                    </div>
                </div>

                <form wire:submit.prevent="addRoi">
                    <div class="space-y-6">
                        <!-- Plan Selection -->
                        <div>
                            <label for="plan" class="block text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-2">
                                <i class="fas fa-chart-line mr-2 text-yellow-500"></i>Yatırım Planı Seçin
                            </label>
                            <select wire:model.defer="plan"
                                    id="plan"
                                    class="block w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm {{ $isDark ? 'dark:bg-gray-700 dark:border-gray-600 dark:text-white' : '' }}"
                                    required>
                                <option value="">Plan seçin...</option>
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}">
                                        {{ $plan->name }} - {{ $plan->percentage }}%
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="datecreated" class="block text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-2">
                                <i class="fas fa-calendar mr-2 text-yellow-500"></i>Tarih
                            </label>
                            <input type="date"
                                   wire:model.defer="datecreated"
                                   id="datecreated"
                                   class="block w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm {{ $isDark ? 'dark:bg-gray-700 dark:border-gray-600 dark:text-white' : '' }}"
                                   required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <i class="fas fa-plus-circle mr-2"></i>ROI Geçmişi Ekle
                        </button>

                        <!-- Info Alert -->
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-lightbulb text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>İpucu:</strong> Sistem, kullanıcıların yatırım tutarı ve seçili planda belirtilen yüzde üzerinden ROI'yi otomatik hesaplayacaktır.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Topup Modal -->
<div id="topupModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal('topupModal')"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white {{ $isDark ? 'dark:bg-gray-800' : '' }} rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <!-- Modal Header -->
            <div class="bg-green-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg leading-6 font-medium text-white">
                        <i class="fas fa-wallet mr-2"></i>Bakiye İşlemleri
                    </h3>
                    <button onclick="closeModal('topupModal')" class="text-white hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-6">
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                <strong>Bakiye Yükleme:</strong> Seçili kullanıcıların hesaplarına para ekleme veya çıkarma işlemi yapın.
                            </p>
                        </div>
                    </div>
                </div>

                <form wire:submit.prevent="topup">
                    <div class="space-y-6">
                        <!-- Amount -->
                        <div>
                            <label for="topamount" class="block text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-2">
                                <i class="fas fa-money-bill mr-2 text-green-600"></i>Tutar
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-dollar-sign text-gray-400"></i>
                                </div>
                                <input type="number"
                                       step="any"
                                       wire:model.defer="topamount"
                                       id="topamount"
                                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm {{ $isDark ? 'dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400' : '' }}"
                                       placeholder="0.00"
                                       required>
                            </div>
                            @if($topamount)
                                <p class="mt-2 text-sm text-gray-500">
                                    Girilen tutar: <strong>{{ $topamount }}</strong>
                                </p>
                            @endif
                        </div>

                        <!-- Account Type -->
                        <div>
                            <label for="topcolumn" class="block text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-2">
                                <i class="fas fa-piggy-bank mr-2 text-green-600"></i>Hesap Türü
                            </label>
                            <select wire:model.defer="topcolumn"
                                    id="topcolumn"
                                    class="block w-full px-3 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm {{ $isDark ? 'dark:bg-gray-700 dark:border-gray-600 dark:text-white' : '' }}"
                                    required>
                                <option value="">Hesap türü seçin...</option>
                                <option value="Bonus">🎁 Bonus Hesabı</option>
                                <option value="balance">💰 Ana Bakiye</option>
                            </select>
                        </div>

                        <!-- Transaction Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 {{ $isDark ? 'dark:text-gray-300' : '' }} mb-3">
                                <i class="fas fa-exchange-alt mr-2 text-green-600"></i>İşlem Türü
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <input type="radio"
                                           wire:model.defer="toptype"
                                           value="Credit"
                                           id="credit"
                                           class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
                                    <label for="credit" class="ml-3 block text-sm font-medium text-green-700">
                                        <i class="fas fa-plus-circle mr-1"></i>Ekle (Kredi)
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio"
                                           wire:model.defer="toptype"
                                           value="Debit"
                                           id="debit"
                                           class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300">
                                    <label for="debit" class="ml-3 block text-sm font-medium text-red-700">
                                        <i class="fas fa-minus-circle mr-1"></i>Çıkar (Borç)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-save mr-2"></i>İşlemi Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Modal Functionality -->
<script>
    // Modal Functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = ['adduser', 'TradingModal', 'topupModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal && !modal.classList.contains('hidden')) {
                    closeModal(modalId);
                }
            });
        }
    });

    // Livewire Events
    document.addEventListener('livewire:init', function () {
        // Close modal and show success message when user is added
        Livewire.on('userAdded', function() {
            closeModal('adduser');
            
            const successAlert = document.getElementById('success-alert');
            const successMessageText = document.getElementById('success-message-text');

            if (successAlert && successMessageText) {
                successMessageText.textContent = 'Kullanıcı başarıyla oluşturuldu!';
                successAlert.classList.remove('hidden');

                // Auto hide after 5 seconds
                setTimeout(function() {
                    successAlert.classList.add('hidden');
                }, 5000);
            }
        });

        // Handle other success messages
        Livewire.on('showSuccessMessage', function(message) {
            const successAlert = document.getElementById('success-alert');
            const successMessageText = document.getElementById('success-message-text');

            if (successAlert && successMessageText) {
                successMessageText.textContent = message || 'İşlem başarıyla tamamlandı!';
                successAlert.classList.remove('hidden');

                setTimeout(function() {
                    successAlert.classList.add('hidden');
                }, 5000);
            }
        });
    });
</script>
</div>
