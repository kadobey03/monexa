{{-- Profile Dropdown Component --}}
<div class="relative">
    <button type="button" 
            class="profile-btn flex items-center space-x-2 p-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            id="profile-button">
        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
            @if(Auth::guard('admin')->check())
                @php
                    $admin = Auth::guard('admin')->user();
                    $initials = strtoupper(substr($admin->firstName ?? 'A', 0, 1) . substr($admin->lastName ?? 'U', 0, 1));
                @endphp
                <span class="text-sm font-medium text-gray-600">{{ $initials }}</span>
            @else
                <i class="fas fa-user text-gray-600 text-sm"></i>
            @endif
        </div>
        <span class="hidden sm:block">
            @if(Auth::guard('admin')->check())
                {{ Auth::guard('admin')->user()->firstName ?? 'Admin' }}
            @else
                Admin
            @endif
        </span>
        <i class="fas fa-chevron-down text-xs text-gray-400"></i>
    </button>

    {{-- Profile Dropdown Menu --}}
    <div id="profile-dropdown" 
         class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
        <div class="py-2">
            {{-- Profile Header --}}
            @if(Auth::guard('admin')->check())
            <div class="px-4 py-3 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-medium">{{ $initials }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ Auth::guard('admin')->user()->firstName }} {{ Auth::guard('admin')->user()->lastName }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ Auth::guard('admin')->user()->email }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Profile Menu Items --}}
            <div class="py-2">
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-tachometer-alt w-4 h-4 mr-3 text-gray-400"></i>
                    Dashboard
                </a>

                {{-- Account Settings --}}
                @if(route('admin.profile', [], false))
                <a href="{{ route('admin.profile') }}" 
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-user-cog w-4 h-4 mr-3 text-gray-400"></i>
                    Hesap Ayarları
                </a>
                @else
                <a href="{{ url('admin/dashboard/adminprofile') }}" 
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-user-cog w-4 h-4 mr-3 text-gray-400"></i>
                    Hesap Ayarları
                </a>
                @endif

                {{-- Change Password --}}
                <a href="{{ url('admin/dashboard/adminchangepassword') }}" 
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-key w-4 h-4 mr-3 text-gray-400"></i>
                    Şifre Değiştir
                </a>

                {{-- Preferences --}}
                <a href="#" 
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-cog w-4 h-4 mr-3 text-gray-400"></i>
                    Tercihler
                </a>

                {{-- Activity Log --}}
                <a href="#" 
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-history w-4 h-4 mr-3 text-gray-400"></i>
                    Aktivite Geçmişi
                </a>

                {{-- Divider --}}
                <hr class="my-2 border-gray-200">

                {{-- Help & Support --}}
                <a href="#" 
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-question-circle w-4 h-4 mr-3 text-gray-400"></i>
                    Yardım & Destek
                </a>

                {{-- Documentation --}}
                <a href="#" 
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-book w-4 h-4 mr-3 text-gray-400"></i>
                    Dokümantasyon
                </a>

                {{-- Divider --}}
                <hr class="my-2 border-gray-200">

                {{-- Logout --}}
                <a href="{{ route('adminlogout') }}" 
                   onclick="event.preventDefault(); document.getElementById('profile-logout-form').submit();"
                   class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                    <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i>
                    Çıkış Yap
                </a>
                <form id="profile-logout-form" action="{{ route('adminlogout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileButton = document.getElementById('profile-button');
    const profileDropdown = document.getElementById('profile-dropdown');
    
    if (profileButton && profileDropdown) {
        // Toggle profile dropdown
        profileButton.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            
            // Close other dropdowns if they exist
            const notificationsDropdown = document.getElementById('notifications-dropdown');
            if (notificationsDropdown) {
                notificationsDropdown.classList.add('hidden');
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                profileDropdown.classList.add('hidden');
            }
        });
        
        // Close dropdown when pressing Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                profileDropdown.classList.add('hidden');
            }
        });
    }
});
</script>
@endpush