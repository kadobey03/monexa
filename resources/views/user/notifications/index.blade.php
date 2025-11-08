@extends('layouts.master', ['layoutType' => 'dashboard'])
@section('title', 'Bildirimler')

@section('content')
<div class="relative px-1 sm:px-2 md:px-3 lg:px-6 xl:px-8 max-w-screen-2xl mx-auto">
  <!-- Gradient Background Effect -->
  <div class="absolute inset-0 bg-gradient-to-br from-blue-50/30 via-transparent to-transparent dark:from-blue-900/10 dark:via-transparent dark:to-transparent rounded-xl -z-10 pointer-events-none"></div>

  <!-- Page Header -->
  <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 px-2">
    <div class="relative">
      <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center">
        <span class="relative">
          <svg class="w-8 h-8 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM15 17h-5l5-5v5zM12 2a10 10 0 100 20 10 10 0 000-20z"/>
          </svg>
          Bildirimler
          <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 to-blue-300 dark:from-blue-500 dark:to-blue-700"></span>
        </span>
        <span class="ml-2 inline-flex items-center justify-center w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-xs font-medium dark:bg-blue-900/50 dark:text-blue-400">{{ $notifications->total() }}</span>
      </h1>
      <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-lg">Önemli sistem uyarıları ve mesajlarla güncel kalmak için kişisel bildirim merkeziniz</p>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-wrap items-center gap-3 mt-6 md:mt-0">
      @if(count($notifications) > 0)
        <button onclick="markAllAsRead()" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-600 text-white text-sm font-medium rounded-full transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-green-500/25 dark:shadow-none">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          Hepsini Okundu İşaretle
        </button>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-600 text-white text-sm font-medium rounded-full transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25 dark:shadow-none">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
          Dashboard'a Dön
        </a>
      @endif
    </div>
  </div>

  <!-- Success/Error Messages -->
  @if(session('success'))
  <div id="success-alert" class="mb-8 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-900/10 backdrop-blur-sm p-4 rounded-xl shadow-lg border border-green-200/50 dark:border-green-700/30" role="alert">
    <div class="flex items-center">
      <div class="flex-shrink-0 bg-green-100 dark:bg-green-800/50 rounded-full p-1.5">
        <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
      </div>
      <div class="ml-3 flex-1">
        <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
      </div>
      <button onclick="closeAlert('success-alert')" class="ml-auto flex-shrink-0 p-1.5 rounded-full text-green-500 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-800/50 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>
  </div>
  @endif

  @if(session('error'))
  <div id="error-alert" class="mb-8 bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-900/10 backdrop-blur-sm p-4 rounded-xl shadow-lg border border-red-200/50 dark:border-red-700/30" role="alert">
    <div class="flex items-center">
      <div class="flex-shrink-0 bg-red-100 dark:bg-red-800/50 rounded-full p-1.5">
        <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <div class="ml-3 flex-1">
        <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
      </div>
      <button onclick="closeAlert('error-alert')" class="ml-auto flex-shrink-0 p-1.5 rounded-full text-red-500 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/50 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>
  </div>
  @endif

  <!-- Filter & Search Bar -->
  @if(count($notifications) > 0)
  <div class="mb-8 p-5 backdrop-blur-sm bg-white/70 dark:bg-gray-800/70 rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
      <div class="flex items-center gap-3">
        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
          <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
          </svg>
          Filtre
        </span>
        <div class="flex rounded-full backdrop-blur-sm bg-gray-100/80 dark:bg-gray-700/80 p-1 overflow-hidden">
          <button onclick="setFilter('all')" id="filter-all" class="filter-btn px-4 py-1.5 text-sm transition-all duration-200 rounded-full bg-white dark:bg-gray-800 text-blue-700 dark:text-blue-400 shadow-sm font-medium">
            Tümü
          </button>
          <button onclick="setFilter('unread')" id="filter-unread" class="filter-btn px-4 py-1.5 text-sm transition-all duration-200 rounded-full">
            Okunmamış
          </button>
          <button onclick="setFilter('read')" id="filter-read" class="filter-btn px-4 py-1.5 text-sm transition-all duration-200 rounded-full">
            Okunmuş
          </button>
        </div>
      </div>

      <div class="relative flex-1 max-w-xs ml-auto">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
        <input onkeyup="filterNotifications()" type="text" id="search-input" class="pl-10 pr-4 py-2.5 w-full bg-gray-100/80 dark:bg-gray-700/80 border-0 rounded-full text-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 transition-all duration-200" placeholder="Bildirimlerde ara...">
      </div>
    </div>
  </div>
  @endif

  <!-- Notifications List -->
  <div class="backdrop-blur-sm bg-white/70 dark:bg-gray-800/70 rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
    @if(count($notifications) > 0)
      <div class="overflow-hidden">
        <div class="max-h-[65vh] overflow-y-auto scroll-smooth" id="notifications-container">
          <div class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
            @foreach($notifications as $notification)
              <div class="notification-item group p-5 md:p-6 hover:bg-gray-50/80 dark:hover:bg-gray-700/50 transition-all duration-200 {{ !$notification->is_read ? 'bg-blue-50/50 dark:bg-blue-900/10 border-l-4 border-blue-500 dark:border-blue-600' : '' }}" 
                   data-read="{{ $notification->is_read ? 'true' : 'false' }}"
                   data-title="{{ strtolower($notification->title) }}"
                   data-message="{{ strtolower($notification->message) }}">
                <div class="flex flex-col md:flex-row">
                  <!-- Icon Based on Type -->
                  <div class="flex-shrink-0 mb-4 md:mb-0 transition-transform duration-300 group-hover:scale-110 relative">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full shadow-lg {{
                      $notification->type === 'warning' ? 'bg-gradient-to-br from-yellow-200 to-yellow-100 text-yellow-600 dark:from-yellow-900/40 dark:to-yellow-800/20 dark:text-yellow-500' :
                      ($notification->type === 'success' ? 'bg-gradient-to-br from-green-200 to-green-100 text-green-600 dark:from-green-900/40 dark:to-green-800/20 dark:text-green-500' :
                      ($notification->type === 'danger' ? 'bg-gradient-to-br from-red-200 to-red-100 text-red-600 dark:from-red-900/40 dark:to-red-800/20 dark:text-red-500' :
                      'bg-gradient-to-br from-blue-200 to-blue-100 text-blue-600 dark:from-blue-900/40 dark:to-blue-800/20 dark:text-blue-500')) }}">
                      @if($notification->type === 'warning')
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                      @elseif($notification->type === 'success')
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                      @elseif($notification->type === 'danger')
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                      @else
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                      @endif
                    </div>
                    @if(!$notification->is_read)
                      <div class="absolute h-3 w-3 rounded-full bg-blue-500 dark:bg-blue-400 ring-2 ring-white dark:ring-gray-800 -mt-2 ml-10"></div>
                    @endif
                  </div>

                  <!-- Notification Content -->
                  <div class="md:ml-6 flex-grow">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                      <div class="max-w-2xl">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white leading-tight {{ !$notification->is_read ? 'font-bold' : '' }}">
                          {{ $notification->title }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                          {{ $notification->message }}
                        </p>
                        <div class="mt-3 flex items-center flex-wrap gap-2">
                          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium shadow-sm {{
                            $notification->type === 'warning' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' :
                            ($notification->type === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' :
                            ($notification->type === 'danger' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' :
                            'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400')) }}">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                              <circle cx="10" cy="10" r="3"/>
                            </svg>
                            {{ ucfirst($notification->type) }}
                          </span>
                          <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                            <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $notification->created_at->diffForHumans() }}
                          </span>
                          <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                            @if($notification->is_read)
                              <svg class="h-3.5 w-3.5 mr-1 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                              </svg>
                            @else
                              <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                              </svg>
                            @endif
                            {{ $notification->is_read ? 'Okundu' : 'Okunmadı' }}
                          </span>
                        </div>
                      </div>

                      <!-- Action Buttons -->
                      <div class="flex items-center mt-4 md:mt-0 space-x-2 opacity-70 group-hover:opacity-100 transition-opacity duration-200">
                        <a href="{{ route('notifications.show', $notification->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-100/80 dark:bg-gray-800/80 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-full transition-all duration-200 hover:scale-105 hover:shadow-md">
                          <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                          </svg>
                          Görüntüle
                        </a>

                        @if(!$notification->is_read)
                          <button onclick="markAsRead({{ $notification->id }})" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-100/80 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50 rounded-full transition-all duration-200 hover:scale-105 hover:shadow-md">
                            <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Okundu İşaretle
                          </button>
                        @endif

                        <button onclick="showDeleteModal({{ $notification->id }})" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 bg-red-50/80 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-full transition-all duration-200 hover:scale-105 hover:shadow-md">
                          <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                          </svg>
                          Sil
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div class="px-6 py-4 bg-gradient-to-b from-transparent to-gray-50/80 dark:to-gray-800/50 border-t border-gray-200/50 dark:border-gray-700/50 flex items-center justify-between">
        <div class="flex-1 flex flex-col sm:flex-row sm:items-center sm:justify-between">
          <div class="mb-4 sm:mb-0">
            <p class="text-sm text-gray-600 dark:text-gray-400">
              <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $notifications->firstItem() ?? 0 }}</span> - 
              <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $notifications->lastItem() ?? 0 }}</span> arası, 
              toplam <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $notifications->total() }}</span> bildirim
            </p>
          </div>
          <div>
            {{ $notifications->onEachSide(1)->links('pagination::tailwind') }}
          </div>
        </div>
      </div>
    @else
      <!-- Empty state -->
      <div class="flex flex-col items-center justify-center py-20 px-4">
        <div class="relative">
          <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-blue-50 dark:from-blue-900/10 dark:to-blue-800/5 animate-pulse rounded-full blur-xl opacity-70"></div>
          <div class="relative mx-auto flex h-32 w-32 items-center justify-center rounded-full bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 shadow-inner">
            <svg class="h-16 w-16 text-gray-400 dark:text-gray-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13.5v-8A2.5 2.5 0 0017.5 3h-11A2.5 2.5 0 004 5.5v8a2.5 2.5 0 002.5 2.5h4l2 3 2-3h4a2.5 2.5 0 002.5-2.5z"/>
            </svg>
          </div>
        </div>
        <h3 class="mt-8 text-xl font-semibold text-gray-900 dark:text-white">Bildirim Yok</h3>
        <p class="mt-2 text-base text-gray-600 dark:text-gray-300 text-center max-w-md">Şu anda herhangi bir bildiriminiz bulunmuyor.</p>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Önemli bir şey olduğunda sizi bilgilendireceğiz.</p>

        <div class="mt-6">
          <a href="{{ route('dashboard') }}" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-600 text-white text-sm font-medium rounded-full transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25 dark:shadow-none">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Dashboard'a Dön
          </a>
        </div>
      </div>
    @endif
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm hidden">
  <div class="flex items-center justify-center min-h-screen px-4">
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="hideDeleteModal()"></div>
    <div class="relative bg-white/90 dark:bg-gray-800/90 rounded-2xl max-w-md w-full overflow-hidden shadow-2xl border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-md transform transition-all">
      <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 via-red-400 to-red-600"></div>
      <div class="p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0 bg-gradient-to-br from-red-100 to-red-50 dark:from-red-900/30 dark:to-red-900/10 p-3 rounded-full">
            <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
          </div>
          <div class="ml-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Bildirimi Sil</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Bu işlem geri alınamaz.</p>
          </div>
        </div>

        <div class="mt-5 bg-red-50/50 dark:bg-red-900/10 rounded-xl p-4 border border-red-100 dark:border-red-900/20">
          <p class="text-sm text-red-800 dark:text-red-300 flex items-start">
            <svg class="h-5 w-5 mr-2 flex-shrink-0 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            Bu bildirimi kalıcı olarak silmek istediğinizden emin misiniz?
          </p>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
          <button onclick="hideDeleteModal()" type="button" class="px-4 py-2.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 dark:focus:ring-offset-gray-800">
            İptal
          </button>
          <button onclick="confirmDelete()" type="button" class="px-4 py-2.5 rounded-full bg-gradient-to-r from-red-600 to-red-500 text-white text-sm font-medium hover:from-red-500 hover:to-red-600 transition-all duration-200 shadow-lg hover:shadow-red-500/25 dark:shadow-none focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transform hover:scale-105">
            Sil
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Global variables
    let currentDeleteId = null;
    let currentFilter = 'all';

    // CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                      '{{ csrf_token() }}';

    // Auto-dismiss alerts after 6 seconds
    setTimeout(() => {
        const successAlert = document.getElementById('success-alert');
        const errorAlert = document.getElementById('error-alert');
        if (successAlert) {
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 300);
        }
        if (errorAlert) {
            errorAlert.style.opacity = '0';
            setTimeout(() => errorAlert.remove(), 300);
        }
    }, 6000);

    // Filter functionality
    window.setFilter = function(filter) {
        currentFilter = filter;
        
        // Update button styles
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('bg-white', 'dark:bg-gray-800', 'text-blue-700', 'dark:text-blue-400', 'shadow-sm', 'font-medium');
        });
        
        const activeBtn = document.getElementById(`filter-${filter}`);
        if (activeBtn) {
            activeBtn.classList.add('bg-white', 'dark:bg-gray-800', 'text-blue-700', 'dark:text-blue-400', 'shadow-sm', 'font-medium');
        }
        
        // Filter notifications
        filterNotifications();
    };

    // Search and filter functionality
    window.filterNotifications = function() {
        const searchTerm = document.getElementById('search-input')?.value.toLowerCase() || '';
        const notifications = document.querySelectorAll('.notification-item');
        
        notifications.forEach(notification => {
            const isRead = notification.getAttribute('data-read') === 'true';
            const title = notification.getAttribute('data-title') || '';
            const message = notification.getAttribute('data-message') || '';
            
            // Filter by read status
            let showByFilter = true;
            if (currentFilter === 'read' && !isRead) showByFilter = false;
            if (currentFilter === 'unread' && isRead) showByFilter = false;
            
            // Filter by search term
            let showBySearch = true;
            if (searchTerm && !title.includes(searchTerm) && !message.includes(searchTerm)) {
                showBySearch = false;
            }
            
            // Show/hide notification
            if (showByFilter && showBySearch) {
                notification.style.display = 'block';
                notification.style.opacity = '1';
            } else {
                notification.style.display = 'none';
            }
        });
    };

    // Close alert functionality
    window.closeAlert = function(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }
    };

    // Mark single notification as read
    window.markAsRead = function(notificationId) {
        fetch('/notifications/ajax/mark-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                notification_id: notificationId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI
                const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationElement) {
                    notificationElement.setAttribute('data-read', 'true');
                    notificationElement.classList.remove('bg-blue-50/50', 'dark:bg-blue-900/10', 'border-l-4', 'border-blue-500', 'dark:border-blue-600');
                    
                    // Remove unread indicator
                    const unreadIndicator = notificationElement.querySelector('.absolute.h-3.w-3.rounded-full.bg-blue-500');
                    if (unreadIndicator) {
                        unreadIndicator.remove();
                    }
                    
                    // Update read/unread text
                    const statusSpan = notificationElement.querySelector('.text-xs.text-gray-500:last-child');
                    if (statusSpan) {
                        statusSpan.innerHTML = `
                            <svg class="h-3.5 w-3.5 mr-1 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Okundu
                        `;
                    }
                    
                    // Remove mark as read button
                    const markReadBtn = notificationElement.querySelector('button[onclick*="markAsRead"]');
                    if (markReadBtn) {
                        markReadBtn.remove();
                    }
                }
                
                showSuccessMessage('Bildirim okundu olarak işaretlendi.');
            } else {
                showErrorMessage(data.message || 'Bir hata oluştu.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorMessage('Bir hata oluştu.');
        });
    };

    // Mark all notifications as read
    window.markAllAsRead = function() {
        fetch('/notifications/ajax/mark-all-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload page to reflect changes
                window.location.reload();
            } else {
                showErrorMessage(data.message || 'Bir hata oluştu.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorMessage('Bir hata oluştu.');
        });
    };

    // Delete modal functionality
    window.showDeleteModal = function(notificationId) {
        currentDeleteId = notificationId;
        const modal = document.getElementById('delete-modal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    };

    window.hideDeleteModal = function() {
        const modal = document.getElementById('delete-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        currentDeleteId = null;
    };

    window.confirmDelete = function() {
        if (!currentDeleteId) return;
        
        // Create and submit form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("notifications.delete") }}';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'notification_id';
        idInput.value = currentDeleteId;
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        form.appendChild(idInput);
        
        document.body.appendChild(form);
        form.submit();
    };

    // Helper functions for showing messages
    function showSuccessMessage(message) {
        const alertHtml = `
            <div id="dynamic-success-alert" class="mb-8 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-900/10 backdrop-blur-sm p-4 rounded-xl shadow-lg border border-green-200/50 dark:border-green-700/30" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 dark:bg-green-800/50 rounded-full p-1.5">
                        <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">${message}</p>
                    </div>
                    <button onclick="closeAlert('dynamic-success-alert')" class="ml-auto flex-shrink-0 p-1.5 rounded-full text-green-500 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-800/50 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        
        const container = document.querySelector('.relative.px-1.sm\\:px-2');
        if (container) {
            container.insertAdjacentHTML('afterbegin', alertHtml);
            setTimeout(() => closeAlert('dynamic-success-alert'), 5000);
        }
    }

    function showErrorMessage(message) {
        const alertHtml = `
            <div id="dynamic-error-alert" class="mb-8 bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-900/10 backdrop-blur-sm p-4 rounded-xl shadow-lg border border-red-200/50 dark:border-red-700/30" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 dark:bg-red-800/50 rounded-full p-1.5">
                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">${message}</p>
                    </div>
                    <button onclick="closeAlert('dynamic-error-alert')" class="ml-auto flex-shrink-0 p-1.5 rounded-full text-red-500 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/50 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        
        const container = document.querySelector('.relative.px-1.sm\\:px-2');
        if (container) {
            container.insertAdjacentHTML('afterbegin', alertHtml);
            setTimeout(() => closeAlert('dynamic-error-alert'), 5000);
        }
    }

    // Add scroll reveal animations
    const notificationItems = document.querySelectorAll('.notification-item');
    let delay = 0;
    
    notificationItems.forEach((item, index) => {
        item.style.animationDelay = `${delay}ms`;
        delay += 50;
    });

    // Add hover effects for notifications container
    const container = document.getElementById('notifications-container');
    if (container) {
        container.addEventListener('mouseover', function(e) {
            const item = e.target.closest('.notification-item');
            if (item) {
                const siblings = Array.from(document.querySelectorAll('.notification-item'));
                siblings.forEach(sibling => {
                    if (sibling !== item) {
                        sibling.style.opacity = '0.6';
                    }
                });
            }
        });

        container.addEventListener('mouseout', function() {
            const items = document.querySelectorAll('.notification-item');
            items.forEach(item => {
                item.style.opacity = '1';
            });
        });
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('delete-modal');
        if (modal && e.target === modal) {
            hideDeleteModal();
        }
    });

    // Close modal with escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideDeleteModal();
        }
    });
});
</script>
@endsection