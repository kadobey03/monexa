<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name }} | {{ $title }}</title>
    <link rel="icon" href="{{ asset('storage/app/public/' . $settings->favicon) }}" type="image/png" />

    @section('styles')
        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
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
        
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- jQuery for existing functionality compatibility -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Select2 for enhanced select dropdowns -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        
        <!-- DataTables for table functionality -->
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/r-2.2.5/datatables.min.css" />
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/r-2.2.5/datatables.min.js"></script>

        <!-- Sweet Alert for beautiful alerts -->
        <script src="{{ asset('dash/js/plugin/sweetalert/sweetalert.min.js') }} "></script>
        
        <!-- Alpine.js for modern interactivity -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        
        <!-- Chart.js for charts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"></script>
        
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

            /* Modal compatibility */
            .modal {
                @apply fixed inset-0 z-50 overflow-y-auto;
            }
            
            .modal-dialog {
                @apply flex min-h-full items-center justify-center p-4;
            }
            
            .modal-content {
                @apply bg-white rounded-2xl shadow-2xl max-w-lg w-full;
            }
            
            .modal-header {
                @apply px-6 py-4 border-b border-gray-200;
            }
            
            .modal-body {
                @apply px-6 py-4;
            }
            
            .modal-footer {
                @apply px-6 py-4 border-t border-gray-200 flex justify-end space-x-3;
            }
            
            .modal-title {
                @apply text-lg font-semibold text-gray-900;
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
        <!-- Core functionality scripts -->
        <script src="{{ asset('dash/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('dash/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
        <script src="{{ asset('dash/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('dash/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset('dash/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

        <!-- Google Translate -->
        <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
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
            
            // Initialize Select2 with Tailwind styling
            $(document).ready(function() {
                $('.select2').select2({
                    theme: 'default',
                    width: '100%'
                });
            });
        </script>
    @show

</body>

</html>