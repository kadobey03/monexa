{{-- Admin Sidebar Component - Extracted from admin.blade.php --}}
<aside class="sidebar-transition fixed inset-y-0 left-0 z-50 bg-white dark:bg-admin-800 shadow-elegant dark:shadow-glass-dark border-r border-admin-200 dark:border-admin-700 w-64 -translate-x-full lg:translate-x-0"
       id="sidebar">
    
    <!-- Sidebar Header -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-admin-200 dark:border-admin-700 bg-gradient-to-r from-primary-600 to-primary-700">
        <div class="flex items-center space-x-3" id="sidebarHeader">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <x-heroicon name="shield-check" class="w-6 h-6 text-white" />
            </div>
            <div class="text-white" id="sidebarHeaderText">
                @php $adminUser = Auth::guard('admin')->user(); @endphp
                <h2 class="text-lg font-bold truncate">{{ $adminUser?->firstName ?? 'Admin' }}</h2>
                <p class="text-xs text-primary-100">{{ $adminUser?->type ?? 'User' }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="sidebar-nav flex-1 overflow-y-auto py-6 px-4" style="height: calc(100vh - 180px);" id="sidebarNav">
        
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-700 dark:hover:text-primary-300 transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : '' }}"
           title="{{ __('admin.navigation.dashboard') }}">
            <x-heroicon name="layout-dashboard" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" />
            <span class="font-medium">{{ __('admin.navigation.dashboard') }}</span>
        </a>

        @php $adminUser = Auth::guard('admin')->user(); @endphp
        @if ($adminUser && ($adminUser->type == 'Super Admin' || $adminUser->type == 'Admin'))
        
        <!-- Users Management -->
        <div class="mt-4" id="usersMenu">
            <button onclick="toggleSubMenu('usersMenu')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700/50 transition-all duration-200 group"
                    title="{{ __('admin.navigation.users') }}">
                <div class="flex items-center">
                    <x-heroicon name="users" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-emerald-500" />
                    <span class="font-medium">{{ __('admin.navigation.users') }}</span>
                </div>
                <x-heroicon name="chevron-down" class="w-4 h-4 transition-transform" id="usersMenuChevron" />
            </button>
            
            <div class="mt-2 ml-12 space-y-1" id="usersMenuContent" style="display: none;">
                <a href="{{ route('manageusers') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                    {{ __('admin.navigation.all_users') }}
                </a>
            </div>
        </div>

        <!-- Financial Management -->
        <div class="mt-6">
            <div class="px-4 mb-3">
                <span class="text-xs font-semibold text-admin-400 dark:text-admin-500 uppercase tracking-wider">{{ __('admin.navigation.financial_management') }}</span>
            </div>
            
            <a href="{{ route('mdeposits') }}" 
               class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-300 transition-all duration-200 group {{ request()->routeIs('mdeposits') ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : '' }}"
               title="{{ __('admin.navigation.manage_deposits') }}">
                <x-heroicon name="trending-up" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-emerald-500" />
                <span class="font-medium">{{ __('admin.navigation.deposits') }}</span>
            </a>

            <a href="{{ route('mwithdrawals') }}" 
               class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-700 dark:hover:text-rose-300 transition-all duration-200 group {{ request()->routeIs('mwithdrawals') ? 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300' : '' }}"
               title="{{ __('admin.navigation.manage_withdrawals') }}">
                <x-heroicon name="trending-down" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-rose-500" />
                <span class="font-medium">{{ __('admin.navigation.withdrawals') }}</span>
            </a>
        </div>

        <!-- Business Management -->
        <div class="mt-6">
            <div class="px-4 mb-3">
                <span class="text-xs font-semibold text-admin-400 dark:text-admin-500 uppercase tracking-wider">{{ __('admin.navigation.business_management') }}</span>
            </div>

            <a href="{{ route('emailservices') }}"
               class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-700 dark:hover:text-blue-300 transition-all duration-200 group {{ request()->routeIs('emailservices') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : '' }}"
               title="{{ __('admin.navigation.email_services') }}">
                <x-heroicon name="mail" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-blue-500" />
                <span class="font-medium">{{ __('admin.navigation.email_services') }}</span>
            </a>

            <a href="{{ route('kyc') }}"
               class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-teal-50 dark:hover:bg-teal-900/20 hover:text-teal-700 dark:hover:text-teal-300 transition-all duration-200 group {{ request()->routeIs('kyc') ? 'bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-300' : '' }}"
               title="{{ __('admin.navigation.kyc_applications') }}">
                <x-heroicon name="user-check" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-teal-500" />
                <span class="font-medium">{{ __('admin.navigation.kyc_applications') }}</span>
            </a>

            <a href="{{ route('admin.trades.index') }}"
               class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-violet-50 dark:hover:bg-violet-900/20 hover:text-violet-700 dark:hover:text-violet-300 transition-all duration-200 group {{ request()->routeIs('admin.trades.index') ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' : '' }}"
               title="{{ __('admin.navigation.trade_management') }}">
                <x-heroicon name="trending-up" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-violet-500" />
                <span class="font-medium">{{ __('admin.navigation.trade_management') }}</span>
            </a>

        </div>

        <!-- Content Management -->
        <div class="mt-6">
            <div class="px-4 mb-3">
                <span class="text-xs font-semibold text-admin-400 dark:text-admin-500 uppercase tracking-wider">{{ __('admin.navigation.content_management') }}</span>
            </div>
            
            <a href="{{ route('admin.phrases') }}"
               class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-pink-50 dark:hover:bg-pink-900/20 hover:text-pink-700 dark:hover:text-pink-300 transition-all duration-200 group {{ request()->routeIs('admin.phrases') ? 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300' : '' }}"
               title="{{ __('admin.navigation.language_phrases') }}">
                <x-heroicon name="languages" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-pink-500" />
                <span class="font-medium">{{ __('admin.navigation.language_phrases') }}</span>
            </a>

            @if ($adminUser && $adminUser->type == 'Super Admin')
            <!-- Status Management Menu - Super Admin Only -->
            <a href="{{ route('admin.lead-statuses.index') }}"
               class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-cyan-50 dark:hover:bg-cyan-900/20 hover:text-cyan-700 dark:hover:text-cyan-300 transition-all duration-200 group {{ request()->routeIs('admin.lead-statuses.*') ? 'bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300' : '' }}"
               title="{{ __('admin.navigation.status_management') }}">
                <x-heroicon name="tag" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-cyan-500" />
                <span class="font-medium">{{ __('admin.navigation.status_management') }}</span>
            </a>
            @endif
        </div>

        @endif

        <!-- Tasks Management -->
        <div class="mt-6" id="tasksMenu">
            <button onclick="toggleSubMenu('tasksMenu')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-slate-50 dark:hover:bg-slate-900/20 hover:text-slate-700 dark:hover:text-slate-300 transition-all duration-200 group"
                    title="{{ __('admin.navigation.tasks') }}">
                <div class="flex items-center">
                    <x-heroicon name="list-checks" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-slate-500" />
                    <span class="font-medium">{{ __('admin.navigation.tasks') }}</span>
                </div>
                <x-heroicon name="chevron-down" class="w-4 h-4 transition-transform" id="tasksMenuChevron" />
            </button>
            
            <div class="mt-2 ml-12 space-y-1" id="tasksMenuContent" style="display: none;">
                @if ($adminUser && $adminUser->type == 'Super Admin')
                    <a href="{{ url('/admin/dashboard/task') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                        {{ __('admin.navigation.create_task') }}
                    </a>
                    <a href="{{ url('/admin/dashboard/mtask') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                        {{ __('admin.navigation.manage_tasks') }}
                    </a>
                @else
                    <a href="{{ url('/admin/dashboard/viewtask') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                        {{ __('admin.navigation.view_my_tasks') }}
                    </a>
                @endif
            </div>
        </div>

        @if ($adminUser && $adminUser->type == 'Super Admin')
        
        <!-- Advanced Admin Management -->
        <div class="mt-4" id="managersMenu">
            <button onclick="toggleSubMenu('managersMenu')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-300 transition-all duration-200 group {{ request()->routeIs('admin.managers.*') ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : '' }}"
                    title="{{ __('admin.navigation.managers') }}">
                <div class="flex items-center">
                    <x-heroicon name="user-cog" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-red-500" />
                    <span class="font-medium">{{ __('admin.navigation.managers') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    @php
                        $totalManagers = \App\Models\Admin::where('type', '!=', 'Super Admin')->count();
                    @endphp
                    <span class="text-xs bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 px-2 py-0.5 rounded-full font-medium">{{ $totalManagers }}</span>
                    <x-heroicon name="chevron-down" class="w-4 h-4 transition-transform" id="managersMenuChevron" />
                </div>
            </button>
            
            <div class="mt-2 ml-12 space-y-1" id="managersMenuContent" style="display: none;">
                <a href="{{ route('admin.managers.index') }}"
                   class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors flex items-center justify-between group {{ request()->routeIs('admin.managers.index') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300' : '' }}">
                    <span>{{ __('admin.navigation.managers_list') }}</span>
                    <x-heroicon name="list" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" />
                </a>
                <a href="{{ route('admin.managers.create') }}"
                   class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-lg transition-colors flex items-center justify-between group {{ request()->routeIs('admin.managers.create') ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300' : '' }}">
                    <span>{{ __('admin.navigation.add_manager') }}</span>
                    <x-heroicon name="user-plus" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" />
                </a>
                <a href="{{ route('admin.hierarchy.index') }}"
                   class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-violet-600 dark:hover:text-violet-400 hover:bg-violet-50 dark:hover:bg-violet-900/20 rounded-lg transition-colors flex items-center justify-between group {{ request()->routeIs('admin.hierarchy.*') ? 'bg-violet-50 dark:bg-violet-900/20 text-violet-700 dark:text-violet-300' : '' }}">
                    <span>{{ __('admin.navigation.hierarchy_view') }}</span>
                    <x-heroicon name="git-branch" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" />
                </a>
            </div>
        </div>

        <!-- Permissions & Roles Management -->
        <div class="mt-4" id="permissionsMenu">
            <button onclick="toggleSubMenu('permissionsMenu')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-700 dark:hover:text-indigo-300 transition-all duration-200 group {{ request()->routeIs('admin.permissions.*') || request()->routeIs('admin.roles.*') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300' : '' }}"
                    title="{{ __('admin.navigation.permissions_roles') }}">
                <div class="flex items-center">
                    <x-heroicon name="shield-check" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-indigo-500" />
                    <span class="font-medium">{{ __('admin.navigation.permissions_roles') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    @php
                        $totalRoles = \App\Models\Role::count();
                        $totalPermissions = \App\Models\Permission::count();
                    @endphp
                    <span class="text-xs bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 px-2 py-0.5 rounded-full font-medium">{{ $totalRoles }}/{{ $totalPermissions }}</span>
                    <x-heroicon name="chevron-down" class="w-4 h-4 transition-transform" id="permissionsMenuChevron" />
                </div>
            </button>
            
            <div class="mt-2 ml-12 space-y-1" id="permissionsMenuContent" style="display: none;">
                <a href="{{ route('admin.permissions.index') }}"
                   class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors flex items-center justify-between group {{ request()->routeIs('admin.permissions.index') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300' : '' }}">
                    <span>{{ __('admin.navigation.permissions_matrix') }}</span>
                    <x-heroicon name="grid-3x3" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" />
                </a>
                <a href="{{ route('admin.roles.index') }}"
                   class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-purple-600 dark:hover:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-lg transition-colors flex items-center justify-between group {{ request()->routeIs('admin.roles.*') ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300' : '' }}">
                    <span>{{ __('admin.navigation.role_management') }}</span>
                    <x-heroicon name="users" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" />
                </a>
                <a href="{{ route('admin.permissions.audit-log') }}"
                   class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-colors flex items-center justify-between group">
                    <span>{{ __('admin.navigation.permissions_history') }}</span>
                    <x-heroicon name="history" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" />
                </a>
            </div>
        </div>

        <!-- Super Admin Settings -->
        <div class="mt-8 pt-6 border-t border-admin-200 dark:border-admin-700">
            <div class="px-4 mb-3">
                <span class="text-xs font-semibold text-admin-400 dark:text-admin-500 uppercase tracking-wider">{{ __('admin.navigation.system_management') }}</span>
            </div>
            
            <!-- System Settings Menu -->
            <a href="{{ route('appsettingshow') }}"
               class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 hover:text-orange-700 dark:hover:text-orange-300 transition-all duration-200 group {{ request()->routeIs('appsettingshow') ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}"
               title="{{ __('admin.navigation.system_settings') }}">
                <x-heroicon name="server" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-orange-500" />
                <span class="font-medium">{{ __('admin.navigation.system_settings') }}</span>
            </a>

            <!-- Settings Dropdown -->
            <div class="mt-4" id="settingsMenu">
                <button onclick="toggleSubMenu('settingsMenu')"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:text-purple-700 dark:hover:text-purple-300 transition-all duration-200 group"
                        title="{{ __('admin.navigation.other_settings') }}">
                    <div class="flex items-center">
                        <x-heroicon name="settings" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-purple-500" />
                        <span class="font-medium">{{ __('admin.navigation.other_settings') }}</span>
                    </div>
                    <x-heroicon name="chevron-down" class="w-4 h-4 transition-transform" id="settingsMenuChevron" />
                </button>
                
                <div class="mt-2 ml-12 space-y-1" id="settingsMenuContent" style="display: none;">
                    <a href="{{ route('refsetshow') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                        {{ __('admin.navigation.referral_bonus_settings') }}
                    </a>
                    <a href="{{ route('paymentview') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                        {{ __('admin.navigation.payment_settings') }}
                    </a>
                    <a href="{{ url('/admin/dashboard/ipaddress') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                        {{ __('admin.navigation.ip_address') }}
                    </a>
                </div>
            </div>
        </div>
        @endif

    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-center space-x-2" id="sidebarFooterControls">
            <!-- Dark Mode Toggle -->
            <button onclick="toggleDarkMode()"
                    class="p-2 rounded-lg bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors"
                    id="darkModeToggle" title="{{ __('admin.common.change_theme') }}">
                <x-heroicon name="sun" class="w-4 h-4" id="sunIcon" />
                <x-heroicon name="moon" class="w-4 h-4" id="moonIcon" style="display: none;" />
            </button>
            
            <!-- Collapse Toggle (Desktop Only) -->
            <button onclick="toggleSidebarCollapse()"
                    class="hidden lg:block p-2 rounded-lg bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors"
                    id="collapseToggle" title="{{ __('admin.common.collapse') }}">
                <x-heroicon name="panel-left" class="w-4 h-4" id="panelLeftIcon" />
                <x-heroicon name="panel-right" class="w-4 h-4" id="panelRightIcon" style="display: none;" />
            </button>
        </div>
        
        <div class="mt-3 text-center" id="sidebarFooterText">
            <p class="text-xs text-admin-500">{{ isset($settings) ? $settings->site_name : 'Admin Panel' }}</p>
            <p class="text-xs text-admin-400">© {{ date('Y') }}</p>
        </div>
    </div>

</aside>

<!-- Mobile Sidebar Overlay -->
<div id="mobileOverlay" onclick="closeMobileSidebar()"
     class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden transition-opacity ease-linear duration-300 opacity-0"
     style="display: none;"></div>

<script>
// Sidebar functionality is already included in admin layout JavaScript
// This ensures submenu toggles work properly
if (typeof toggleSubMenu === 'undefined') {
    function toggleSubMenu(menuId) {
        if (typeof adminState !== 'undefined' && adminState.sidebarCollapsed) return;
        
        const isOpen = (typeof adminState !== 'undefined' && adminState.openMenus && adminState.openMenus[menuId]) || false;
        if (typeof adminState !== 'undefined' && adminState.openMenus) {
            adminState.openMenus[menuId] = !isOpen;
        }
        
        const content = document.getElementById(menuId + 'Content');
        const chevron = document.getElementById(menuId + 'Chevron');
        
        if (content && chevron) {
            if ((typeof adminState !== 'undefined' && adminState.openMenus && adminState.openMenus[menuId]) || !isOpen) {
                content.style.display = 'block';
                chevron.classList.add('rotate-180');
            } else {
                content.style.display = 'none';
                chevron.classList.remove('rotate-180');
            }
        }
    }
}
</script>