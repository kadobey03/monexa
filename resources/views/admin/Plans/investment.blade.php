@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    
    <!-- Main Content -->
    <div class="flex-1 ml-0 md:ml-64 transition-all duration-300">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
            <!-- Header Section -->
            <div class="bg-white border-b border-gray-200 shadow-sm">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Aktif Müşteri İşlemleri</h1>
                            <p class="text-gray-600 mt-1">Müşteri yatırımlarını ve aktif işlemlerini görüntüleyin</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                <x-danger-alert />
                <x-success-alert />
            </div>
            
            <!-- Stats Cards -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Total Active Trades -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Toplam Aktif İşlem</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ count($plans) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Investment -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Toplam Yatırım</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $settings->currency }}{{ number_format($plans->sum('amount')) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Profit -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Toplam Kâr</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $settings->currency }}{{ number_format($plans->sum('profit_earned')) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Active Users -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Aktif Kullanıcı</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $plans->where('puser')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Table -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <!-- Table Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-gray-900">Aktif Yatırım İşlemleri</h2>
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center space-x-2 bg-white px-3 py-2 rounded-lg border border-gray-200">
                                    <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                    <input type="text" placeholder="Arama..." class="border-0 focus:ring-0 focus:outline-none text-sm w-32" id="searchInput">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table Content -->
                    <div class="overflow-x-auto">
                        <table id="investmentTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center space-x-1">
                                            <span>Müşteri Adı</span>
                                            <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path>
                                            </svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Varlıklar
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Yatırım Miktarı
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Süre
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kâr Getirisi
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Başlangıç Tarihi
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bitiş Tarihi
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        İşlemler
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($plans as $plan)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <!-- Customer Name -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if(isset($plan->puser->name) && $plan->puser->name != null)
                                                    <div class="flex items-center">
                                                        <div class="h-10 w-10 flex-shrink-0">
                                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                                                <span class="text-sm font-medium text-white">{{ substr($plan->puser->name, 0, 1) }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">{{ $plan->puser->name }}</div>
                                                            <div class="text-sm text-gray-500">{{ $plan->puser->email ?? 'Email not available' }}</div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="flex items-center">
                                                        <div class="h-10 w-10 flex-shrink-0">
                                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="ml-4">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                Kullanıcı Silindi
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <!-- Assets -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                {{ $plan->assets }}
                                            </span>
                                        </td>
                                        
                                        <!-- Investment Amount -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(isset($plan->puser->currency) && $plan->puser->currency != null)
                                                <div class="flex items-center">
                                                    <div class="p-1 bg-green-100 rounded-lg mr-2">
                                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="text-lg font-semibold text-gray-900">{{ $plan->puser->currency }}{{ number_format($plan->amount) }}</span>
                                                </div>
                                            @else
                                                <span class="text-gray-500">N/A</span>
                                            @endif
                                        </td>
                                        
                                        <!-- Duration -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                                {{ $plan->inv_duration }}
                                            </span>
                                        </td>
                                        
                                        <!-- ROI -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(isset($plan->puser->currency) && $plan->puser->currency != null)
                                                <div class="flex items-center">
                                                    <div class="p-1 bg-emerald-100 rounded-lg mr-2">
                                                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="text-lg font-semibold text-emerald-600">{{ $plan->puser->currency }}{{ $plan->profit_earned ? number_format($plan->profit_earned) : '0' }}</span>
                                                </div>
                                            @else
                                                <span class="text-gray-500">N/A</span>
                                            @endif
                                        </td>
                                        
                                        <!-- Start Date -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $plan->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </td>
                                        
                                        <!-- End Date -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($plan->expire_date)->format('d/m/Y H:i') }}
                                            </div>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="relative inline-block text-left">
                                                <div>
                                                    <button type="button" class="inline-flex items-center justify-center w-full rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="menu-button-{{ $plan->id }}" aria-expanded="true" aria-haspopup="true" onclick="toggleDropdown('{{ $plan->id }}')">
                                                        İşlemler
                                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" role="menu" aria-orientation="vertical" aria-labelledby="menu-button-{{ $plan->id }}" tabindex="-1" id="dropdown-{{ $plan->id }}">
                                                    <div class="py-1" role="none">
                                                        <a href="{{ route('deleteplan', $plan->id) }}" onclick="return confirm('Bu işlemi silmek istediğinizden emin misiniz?')" class="flex items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50 hover:text-red-900" role="menuitem" tabindex="-1">
                                                            <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            Sil
                                                        </a>
                                                        @if(isset($plan->puser) && $plan->puser)
                                                            <a href="{{ route('user.plans', $plan->puser->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem" tabindex="-1">
                                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                Kullanıcı Detayları
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">Aktif İşlem Bulunamadı</h3>
                                                <p class="text-gray-500">Şu anda hiç aktif yatırım işlemi bulunmuyor.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript for Dropdown Functionality -->
    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById('dropdown-' + id);
            dropdown.classList.toggle('hidden');
            
            // Close other dropdowns
            document.querySelectorAll('[id^="dropdown-"]').forEach(function(element) {
                if (element.id !== 'dropdown-' + id) {
                    element.classList.add('hidden');
                }
            });
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = event.target.closest('[id^="menu-button-"]');
            if (!isClickInside) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(function(element) {
                    element.classList.add('hidden');
                });
            }
        });
        
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#investmentTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection