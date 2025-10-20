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
                        <div class="p-3 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Üye Takip Sistemi</h1>
                            <p class="text-gray-600 mt-1">Tüm sistem üyelerini görüntüleyin ve yönetin</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                <x-danger-alert />
                <x-success-alert />
            </div>
            
            <!-- Customer Statistics -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Users -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-blue-100 text-sm font-medium">Toplam Üye</p>
                                        <p class="text-2xl font-bold mt-1">{{ $users->count() }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Active Users -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-green-100 text-sm font-medium">Aktif Üyeler</p>
                                        <p class="text-2xl font-bold mt-1">{{ $users->where('status', 'active')->count() }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Balance -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-purple-100 text-sm font-medium">Toplam Bakiye</p>
                                        <p class="text-2xl font-bold mt-1">${{ number_format($users->sum('account_bal'), 2) }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total with Plans -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-orange-500 to-red-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-orange-100 text-sm font-medium">Planlı Üyeler</p>
                                        <p class="text-2xl font-bold mt-1">{{ $users->whereNotNull('plan')->count() }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Table -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <!-- Table Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 lg:mb-0">Üye Listesi</h2>
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                <div class="relative">
                                    <input type="text" id="searchInput" placeholder="Üye ara..." 
                                           class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <svg class="absolute left-3 top-2.5 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="relative">
                                    <select id="statusFilter" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="all">Tüm Durumlar</option>
                                        <option value="active">Aktif</option>
                                        <option value="blocked">Engellenmiş</option>
                                        <option value="pending">Beklemede</option>
                                    </select>
                                    <svg class="absolute right-2 top-2.5 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table Content -->
                    <div class="overflow-x-auto">
                        <table id="customerTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Üye</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Bakiye</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İletişim</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kayıt Tarihi</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <!-- ID -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">#{{ $user->id }}</div>
                                        </td>
                                        
                                        <!-- User -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }} {{ $user->l_name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Balance -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $user->account_bal > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                ${{ number_format($user->account_bal, 2) }}
                                            </div>
                                        </td>
                                        
                                        <!-- Contact -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="text-sm text-gray-900 flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                                    </svg>
                                                    {{ $user->phone_number ?: 'Yok' }}
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <!-- Plan -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if (isset($user->dplan->name))
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                                    </svg>
                                                    {{ $user->dplan->name }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                                                    Plan Yok
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($user->status == 'active')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Aktif
                                                </span>
                                            @elseif ($user->status == 'blocked')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Engellenmiş
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ $user->status }}
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <!-- Date -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center text-sm text-gray-900">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                </svg>
                                                <div>
                                                    <div>{{ \Carbon\Carbon::parse($user->created_at)->format('d.m.Y') }}</div>
                                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($user->created_at)->format('H:i') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <button onclick="openEditModal({{ $user->id }})" 
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-100 hover:bg-blue-200 rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                                Düzenle
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz Üye Bulunmuyor</h3>
                                                <p class="text-gray-500">Üyeler kayıt olduğunda burada görünecektir.</p>
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
    
    <!-- Edit Modal -->
    @foreach ($users as $user)
        <div id="editModal{{ $user->id }}" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all scale-95">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 rounded-t-2xl text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold">Kullanıcı Durumunu Düzenle</h3>
                        </div>
                        <button onclick="closeEditModal({{ $user->id }})"
                                class="text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/10">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="p-6">
                    <div class="mb-4">
                        <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                <span class="text-sm font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $user->name }} {{ $user->l_name }}</p>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <form method="post" action="{{ route('updateuser') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kullanıcı Durumu</label>
                            <textarea name="userupdate" 
                                      rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 resize-none" 
                                      placeholder="Kullanıcı durum notunu buraya girin..." 
                                      required>{{ $user->userupdate }}</textarea>
                        </div>
                        
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        
                        <!-- Footer -->
                        <div class="flex space-x-3 pt-4">
                            <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                                <svg class="w-4 h-4 mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Kaydet
                            </button>
                            <button type="button" onclick="closeEditModal({{ $user->id }})"
                                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                                İptal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    
    <!-- JavaScript -->
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#customerTable tbody tr');
            
            rows.forEach(row => {
                if (row.cells.length > 1) {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
        
        // Status filter
        document.getElementById('statusFilter').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('#customerTable tbody tr');
            
            rows.forEach(row => {
                if (row.cells.length > 1) {
                    const statusCell = row.cells[5];
                    const statusText = statusCell.textContent.toLowerCase();
                    
                    let showRow = true;
                    if (filterValue !== 'all') {
                        showRow = statusText.includes(filterValue.toLowerCase());
                    }
                    
                    row.style.display = showRow ? '' : 'none';
                }
            });
        });
        
        // Modal functions
        function openEditModal(userId) {
            document.getElementById('editModal' + userId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Add entrance animation
            setTimeout(() => {
                const modal = document.querySelector('#editModal' + userId + ' .bg-white');
                if (modal) {
                    modal.classList.remove('scale-95');
                    modal.classList.add('scale-100');
                }
            }, 10);
        }
        
        function closeEditModal(userId) {
            const modal = document.getElementById('editModal' + userId);
            const modalContent = modal.querySelector('.bg-white');
            
            if (modalContent) {
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');
            }
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 200);
        }
        
        // Close modal on backdrop click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('backdrop-blur-sm')) {
                const modalId = e.target.id;
                if (modalId && modalId.includes('editModal')) {
                    const userId = modalId.replace('editModal', '');
                    closeEditModal(userId);
                }
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('.fixed:not(.hidden)');
                openModals.forEach(modal => {
                    if (modal.id && modal.id.includes('editModal')) {
                        const userId = modal.id.replace('editModal', '');
                        closeEditModal(userId);
                    }
                });
            }
        });
        
        console.log('Customer management page loaded successfully with Tailwind CSS');
    </script>
@endsection