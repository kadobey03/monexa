@extends('layouts.admin', ['title' => 'Yeni Görev Oluştur'])

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-admin-900 dark:via-admin-800 dark:to-admin-900">
        <!-- Header Section -->
        <div class="bg-white dark:bg-admin-800 border-b border-gray-200 dark:border-admin-700 shadow-sm">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg">
                        <i data-lucide="clipboard-list" class="w-8 h-8 text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Yeni Görev Oluştur</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Sistemde yeni görev tanımlayın ve yöneticiye atayın</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Alert Messages -->
        <div class="px-4 sm:px-6 lg:px-8 pt-4">
            <x-danger-alert />
            <x-success-alert />
        </div>
        
        <!-- Form Content -->
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-xl border border-gray-200 dark:border-admin-700 overflow-hidden">
                    <!-- Form Header -->
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
                        <div class="flex items-center">
                            <i data-lucide="plus-circle" class="w-6 h-6 mr-3"></i>
                            <h2 class="text-xl font-bold">Görev Bilgileri</h2>
                        </div>
                    </div>
                    
                    <!-- Form Body -->
                    <div class="p-6">
                        <form method="post" action="{{ route('addtask') }}" enctype="multipart/form-data">
                            @csrf

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800 hover:shadow-md transition-all duration-200">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                        <i data-lucide="type" class="w-5 h-5 text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-blue-700 dark:text-blue-300 font-semibold mb-1">Görev Başlığı</h6>
                                        <p class="text-blue-600 dark:text-blue-400 text-sm">Görev için açıklayıcı başlık</p>
                                    </div>
                                </div>
                                <input type="text" name="tasktitle"
                                       class="w-full px-4 py-3 border border-blue-200 dark:border-blue-700 bg-white dark:bg-admin-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                       placeholder="Görev başlığını buraya yazın..." required>
                            </div>
                                        </div>

                                        <div class="space-y-4">
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 p-4 rounded-xl border border-green-100 dark:border-green-800 hover:shadow-md transition-all duration-200">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center mr-3">
                                        <i data-lucide="user-check" class="w-5 h-5 text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-green-700 dark:text-green-300 font-semibold mb-1">Sorumlu Yönetici</h6>
                                        <p class="text-green-600 dark:text-green-400 text-sm">Görev atanacak yönetici</p>
                                    </div>
                                </div>
                                <select name="delegation"
                                        class="w-full px-4 py-3 border border-green-200 dark:border-green-700 bg-white dark:bg-admin-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200" required>
                                    <option value="" disabled selected>Yönetici seçin...</option>
                                    @foreach ($admin as $user)
                                        <option value="{{ $user->id }}">{{ $user->firstName }} {{ $user->lastName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-4 rounded-xl border border-purple-100">
                                            <label class="flex items-center text-purple-700 font-semibold mb-3">
                                                <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-align-left text-white text-sm"></i>
                                                </div>
                                                Görev Açıklaması
                                            </label>
                                            <textarea name="note" rows="5"
                                                      class="w-full px-4 py-3 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-white/70 backdrop-blur-sm resize-none"
                                                      placeholder="Görev ile ilgili detaylı açıklamayı buraya yazın..." required></textarea>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div class="bg-gradient-to-r from-green-50 to-teal-50 p-4 rounded-xl border border-green-100">
                                            <div class="flex items-center mb-3">
                                                <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-teal-600 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-play text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-green-700 font-semibold">Başlangıç Tarihi</h6>
                                                    <small class="text-green-600">Görev başlangıç zamanı</small>
                                                </div>
                                            </div>
                                            <input type="date" name="start_date"
                                                   class="w-full px-4 py-3 border border-green-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white/70 backdrop-blur-sm" required>
                                        </div>

                                        <div class="bg-gradient-to-r from-red-50 to-pink-50 p-4 rounded-xl border border-red-100">
                                            <div class="flex items-center mb-3">
                                                <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-pink-600 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-stop text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-red-700 font-semibold">Bitiş Tarihi</h6>
                                                    <small class="text-red-600">Görev bitiş zamanı</small>
                                                </div>
                                            </div>
                                            <input type="date" name="end_date"
                                                   class="w-full px-4 py-3 border border-red-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200 bg-white/70 backdrop-blur-sm" required>
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 p-4 rounded-xl border border-amber-100">
                                            <div class="flex items-center mb-3">
                                                <div class="w-10 h-10 bg-gradient-to-r from-amber-500 to-yellow-600 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-amber-700 font-semibold">Öncelik Seviyesi</h6>
                                                    <small class="text-amber-600">Görevin aciliyet derecesi</small>
                                                </div>
                                            </div>
                                            <select name="priority"
                                                    class="w-full px-4 py-3 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 bg-white/70 backdrop-blur-sm" required>
                                                <option value="" disabled selected>Öncelik seviyesi seçin...</option>
                                                <option value="Hemen" class="bg-red-50 text-red-700">🚨 Hemen - Kritik</option>
                                                <option value="Yüksek" class="bg-orange-50 text-orange-700">🔥 Yüksek - Acil</option>
                                                <option value="Orta" class="bg-yellow-50 text-yellow-700">⚡ Orta - Normal</option>
                                                <option value="Düşük" class="bg-green-50 text-green-700">⏰ Düşük - Ertelenebilir</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <input type="hidden" name="id" value="{{ Auth('admin')->User()->id }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-semibold px-8 py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 inline-flex items-center">
                                            <i class="fas fa-paper-plane mr-2"></i>
                                            Görev Oluştur
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
