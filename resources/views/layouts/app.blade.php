<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name }} | {{ $title }}</title>
    <link rel="icon" href="{{ $settings->favicon ? asset('storage/' . $settings->favicon) : asset('favicon.ico') }}" type="image/png" />

    @section('styles')
        <script>
            tailwind.config = {
                important: true,
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50: '#eff6ff',
                                100: '#dbeafe',
                                200: '#bfdbfe',
                                300: '#93c5fd',
                                400: '#60a5fa',
                                500: '#3b82f6',
                                600: '#2563eb',
                                700: '#1d4ed8',
                                800: '#1e40af',
                                900: '#1e3a8a'
                            },
                            success: {
                                DEFAULT: '#10b981',
                                50: '#ecfdf5',
                                100: '#d1fae5',
                                200: '#a7f3d0',
                                300: '#6ee7b7',
                                400: '#34d399',
                                500: '#10b981',
                                600: '#059669',
                                700: '#047857',
                                800: '#065f46',
                                900: '#064e3b'
                            },
                            warning: {
                                DEFAULT: '#f59e0b',
                                50: '#fffbeb',
                                100: '#fef3c7',
                                200: '#fde68a',
                                300: '#fcd34d',
                                400: '#fbbf24',
                                500: '#f59e0b',
                                600: '#d97706',
                                700: '#b45309',
                                800: '#92400e',
                                900: '#78350f'
                            },
                            danger: {
                                DEFAULT: '#ef4444',
                                50: '#fef2f2',
                                100: '#fee2e2',
                                200: '#fecaca',
                                300: '#fca5a5',
                                400: '#f87171',
                                500: '#ef4444',
                                600: '#dc2626',
                                700: '#b91c1c',
                                800: '#991b1b',
                                900: '#7f1d1d'
                            },
                            info: {
                                DEFAULT: '#06b6d4',
                                50: '#ecfeff',
                                100: '#cffafe',
                                200: '#a5f3fc',
                                300: '#67e8f9',
                                400: '#22d3ee',
                                500: '#06b6d4',
                                600: '#0891b2',
                                700: '#0e7490',
                                800: '#155e75',
                                900: '#164e63'
                            }
                        },
                        fontFamily: {
                            sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', "Segoe UI", 'Roboto', "Helvetica Neue", 'Arial', "Noto Sans", 'sans-serif'],
                        },
                        animation: {
                            'fade-in': 'fadeIn 0.5s ease-in-out',
                            'slide-in': 'slideIn 0.3s ease-out',
                            'bounce-in': 'bounceIn 0.6s ease-in-out',
                        },
                        keyframes: {
                            fadeIn: {
                                '0%': { opacity: '0' },
                                '100%': { opacity: '1' },
                            },
                            slideIn: {
                                '0%': { transform: 'translateY(-10px)', opacity: '0' },
                                '100%': { transform: 'translateY(0)', opacity: '1' },
                            },
                            bounceIn: {
                                '0%, 20%, 40%, 60%, 80%': { transform: 'translateY(0)', opacity: '0' },
                                '100%': { transform: 'translateY(0)', opacity: '1' },
                            }
                        }
                    }
                },
                corePlugins: {
                    preflight: false // Prevents complete style reset
                }
            }
        </script>
        
        <!-- FontAwesome REMOVED - Using unified Heroicons instead -->
        <!-- Unified Icon Service loaded via Vite assets -->
        
        <!-- Console Error Fixes - Ultimate System -->

        <!-- jQuery - Local -->

        <!-- Console Error Fixes - Full -->

        <!-- Sweet Alert for notifications -->

        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!--PayPal Integration-->
        @if(!empty($settings->pp_ci) && $settings->pp_ci !== 'iidjdjdj')
        <script>
            // Add your client ID and secret
            var PAYPAL_CLIENT = '{{ $settings->pp_ci }}';
            var PAYPAL_SECRET = '{{ $settings->pp_cs }}';
            // Point your server to the PayPal API
            var PAYPAL_ORDER_API = 'https://api.paypal.com/v2/checkout/orders/';
        </script>
        <script src="https://www.paypal.com/sdk/js?client-id={{ $settings->pp_ci }}"></script>
        @endif

        <!-- Custom Admin Styles -->
        <style>
            /* Tailwind-based custom styles for admin panel */
            .main-panel {
                @apply bg-gray-50 min-h-screen;
            }
            
            .page-inner {
                @apply p-6;
            }
            
            .content {
                @apply p-0;
            }
            
            .title1 {
                @apply text-2xl font-bold text-gray-800;
            }
            
            /* Custom button styles */
            .btn {
                @apply px-4 py-2 rounded-lg font-medium transition-all duration-200 inline-flex items-center justify-center;
            }
            
            .btn-primary {
                @apply bg-blue-600 text-white hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2;
            }
            
            .btn-secondary {
                @apply bg-gray-600 text-white hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2;
            }
            
            .btn-success {
                @apply bg-green-600 text-white hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2;
            }
            
            .btn-warning {
                @apply bg-yellow-600 text-white hover:bg-yellow-700 focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2;
            }
            
            .btn-danger {
                @apply bg-red-600 text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2;
            }
            
            .btn-info {
                @apply bg-cyan-600 text-white hover:bg-cyan-700 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2;
            }
            
            .btn-outline-primary {
                @apply border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white;
            }
            
            /* Form controls */
            .form-control {
                @apply w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent;
            }
            
            .form-label {
                @apply block text-sm font-medium text-gray-700 mb-2;
            }
            
            /* Card styles */
            .card {
                @apply bg-white rounded-2xl shadow-lg overflow-hidden;
            }
            
            .card-header {
                @apply px-6 py-4 border-b border-gray-200;
            }
            
            .card-body {
                @apply p-6;
            }
            
            /* Table styles */
            .table {
                @apply w-full;
            }
            
            .table thead th {
                @apply px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider;
            }
            
            .table tbody td {
                @apply px-6 py-4 whitespace-nowrap text-sm text-gray-900;
            }
            
            /* Badge styles */
            .badge {
                @apply inline-flex items-center px-2 py-1 rounded-full text-xs font-medium;
            }
            
            .badge-primary {
                @apply bg-blue-100 text-blue-800;
            }
            
            .badge-success {
                @apply bg-green-100 text-green-800;
            }
            
            .badge-warning {
                @apply bg-yellow-100 text-yellow-800;
            }
            
            .badge-danger {
                @apply bg-red-100 text-red-800;
            }
            
            .badge-info {
                @apply bg-cyan-100 text-cyan-800;
            }
            
            .badge-secondary {
                @apply bg-gray-100 text-gray-800;
            }
            
            /* Alert styles */
            .alert {
                @apply p-4 rounded-lg mb-4;
            }
            
            .alert-success {
                @apply bg-green-100 text-green-800 border border-green-200;
            }
            
            .alert-danger {
                @apply bg-red-100 text-red-800 border border-red-200;
            }
            
            .alert-warning {
                @apply bg-yellow-100 text-yellow-800 border border-yellow-200;
            }
            
            .alert-info {
                @apply bg-blue-100 text-blue-800 border border-blue-200;
            }

            /* Modal compatibility - Fixed Z-Index Issues */
            .modal {
                @apply fixed inset-0 overflow-y-auto;
                z-index: 9999 !important;
                background-color: rgba(0, 0, 0, 0.5);
            }
            
            .modal-dialog {
                @apply flex min-h-full items-center justify-center p-4;
                z-index: 10000 !important;
            }
            
            .modal-content {
                @apply bg-white rounded-2xl shadow-2xl max-w-lg w-full;
                z-index: 10001 !important;
                position: relative;
            }
            
            .modal-lg .modal-content {
                max-width: 800px !important;
            }
            
            .modal-header {
                @apply px-6 py-4 border-b border-gray-200;
                position: relative;
                z-index: 10002 !important;
            }
            
            .modal-body {
                @apply px-6 py-4;
                position: relative;
                z-index: 10002 !important;
            }
            
            .modal-footer {
                @apply px-6 py-4 border-t border-gray-200 flex justify-end space-x-3;
                position: relative;
                z-index: 10002 !important;
            }
            
            .modal-title {
                @apply text-lg font-semibold text-gray-900;
            }
            
            /* Bootstrap Modal Backdrop Fix */
            .modal-backdrop {
                z-index: 9998 !important;
                background-color: rgba(0, 0, 0, 0.5) !important;
            }
            
            /* Ensure modal shows above navbar and sidebar */
            .modal.show {
                display: block !important;
                z-index: 9999 !important;
            }
            
            /* Fix for dropdown menus inside modals */
            .modal .dropdown-menu {
                z-index: 10003 !important;
            }
            
            /* Additional positioning fixes */
            .modal-dialog-centered {
                display: flex;
                align-items: center;
                min-height: calc(100vh - 1rem);
            }
            
            /* Prevent body scroll when modal is open */
            body.modal-open {
                overflow: hidden;
                padding-right: 0 !important;
            }
            
            /* Footer styles */
            .footer {
                @apply bg-white border-t border-gray-200 py-4 mt-auto;
            }
            
            /* Notification styles */
            .notification-success {
                @apply fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50;
            }
            
            .notification-error {
                @apply fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50;
            }
            
            /* Responsive utilities */
            @media (max-width: 768px) {
                .main-panel {
                    @apply ml-0;
                }
            }
            
            /* Smooth transitions */
            * {
                transition: all 0.2s ease;
            }
            
            /* Fix menu underline issues */
            .sidebar nav a,
            .sidebar nav button {
                text-decoration: none !important;
                border-bottom: none !important;
            }
            
            /* Fix dropdown styling */
            .sidebar-dropdown-btn:focus,
            .sidebar-dropdown-btn:active {
                box-shadow: none !important;
                outline: none !important;
            }
            
            /* Ensure proper background for dropdowns */
            .sidebar [id$="-dropdown"] {
                background-color: white !important;
            }
            
            /* Header improvements */
            header {
                backdrop-filter: blur(10px);
                background-color: rgba(255, 255, 255, 0.95) !important;
            }
            
            /* Remove any unwanted borders or underlines */
            .no-underline {
                text-decoration: none !important;
            }
            
            /* Sidebar background improvements */
            #sidebar {
                background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            }
            
            /* Simple sidebar positioning */
            #sidebar {
                transform: translateX(-100%);
            }
            
            @media (min-width: 1024px) {
                #sidebar {
                    transform: translateX(0);
                }
                
                #sidebar.sidebar-hidden {
                    transform: translateX(-100%) !important;
                }
            }
            
            #sidebar.sidebar-open {
                transform: translateX(0) !important;
            }
            
            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }
            
            ::-webkit-scrollbar-thumb {
                background: linear-gradient(135deg, #667eea, #764ba2);
                border-radius: 10px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(135deg, #5a6fd8, #6a4190);
            }
        </style>
    @show
    @livewireStyles
</head>

<body class="bg-gray-50 font-sans antialiased">
   
    <div id="app">
        <div class="min-h-screen flex flex-col">
            <div class="flex-1">
                @yield('content')
                <footer class="footer bg-white border-t border-gray-200 py-6 mt-auto">
                    <div class="max-w-7xl mx-auto px-6">
                        <div class="text-center text-gray-600">
                            <p class="text-sm">© {{ date('Y') }} {{ $settings->site_name }}. All Rights Reserved.</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    
    @livewireScripts
    
    @section('scripts')
        <!-- Chart.js for charts - Local -->

        <!-- Core functionality scripts -->

        <!-- Google Translate -->
        
        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'en'
                }, 'google_translate_element');
            }
        </script>

        <!-- Custom notification system using Tailwind -->
        <script>
            // Tailwind-based notification system
            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
                
                notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-${type === 'success' ? 'check' : 'times'}-circle mr-3"></i>
                        <span>${message}</span>
                        <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                // Show notification
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);
                
                // Auto hide after 5 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 300);
                }, 5000);
            }

            // Global notification functions for compatibility
            window.showSuccess = (message) => showNotification(message, 'success');
            window.showError = (message) => showNotification(message, 'error');
            
            // jQuery ready function for legacy compatibility
            $(document).ready(function() {
                console.log('Admin panel initialized');
            });
        </script>
    @show

    <!-- Communication Widget System -->
    <!-- Chat Widget Priority: Tawk.to > Tidio (Only one loads) -->
    @if(isset($settings))
        @if(!empty($settings->tawk_to))
            <!-- Tawk.to Chat Widget -->
            @if(str_contains($settings->tawk_to, '<script'))
                <!-- Full Tawk.to Widget Code -->
                {!! $settings->tawk_to !!}
            @else
                <!-- Tawk.to Widget ID Only -->
                <script type="text/javascript">
                    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
                    (function(){
                        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
                        s1.async = true;
                        s1.src = 'https://embed.tawk.to/{{ $settings->tawk_to }}{{ str_contains($settings->tawk_to, "/") ? "" : "/default" }}';
                        s1.charset = 'UTF-8';
                        s1.setAttribute('crossorigin','*');
                        s0.parentNode.insertBefore(s1,s0);
                    })();
                </script>
            @endif
            
            <!-- Tawk.to Mobile Compatibility CSS -->
            <style>
                /* Ensure Tawk.to widget appears on mobile */
                #tawkchat-container,
                .widget-chat-container {
                    z-index: 9999 !important;
                    position: fixed !important;
                }
                
                /* Mobile responsive adjustments */
                @media (max-width: 768px) {
                    #tawkchat-container,
                    .widget-chat-container {
                        bottom: 10px !important;
                        right: 10px !important;
                        z-index: 9999 !important;
                    }
                    
                    /* Ensure chat bubble is visible on mobile */
                    .tawk-chat-bubble {
                        display: block !important;
                        visibility: visible !important;
                        opacity: 1 !important;
                    }
                }
            </style>
        @elseif(!empty($settings->tido))
            <!-- Tidio Live Chat Integration (fallback) -->
            <script src="//code.tidio.co/{{ $settings->tido }}.js" async></script>
        @endif
        
        <!-- Social Media Contact Buttons -->
        @if(!empty($settings->whatsapp) || !empty($settings->telegram))
            <div class="fixed right-4 top-1/2 transform -translate-y-1/2 flex flex-col space-y-3 z-40">
                <!-- WhatsApp Button -->
                @if(!empty($settings->whatsapp))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}"
                       target="_blank"
                       class="bg-green-500 hover:bg-green-600 text-white p-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110 group"
                       title="WhatsApp ile iletişime geçin">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        <span class="absolute right-16 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-2 py-1 rounded text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            Bize ulaşın
                        </span>
                    </a>
                @endif
                
                <!-- Telegram Button -->
                @if(!empty($settings->telegram))
                    <a href="https://t.me/{{ ltrim($settings->telegram, '@') }}"
                       target="_blank"
                       class="bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110 group"
                       title="Telegram ile iletişime geçin">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                        </svg>
                        <span class="absolute right-16 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-2 py-1 rounded text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            Telegram
                        </span>
                    </a>
                @endif
            </div>
        @endif
    @endif

</body>

</html>