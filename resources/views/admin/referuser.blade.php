@extends('layouts.admin', ['title' => 'Yeni Kullanıcı Ekle'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Yeni Kullanıcı Ekle</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $settings->site_name }} topluluğuna yeni kullanıcılar ekleyin</p>
        </div>
        <div class="flex items-center space-x-2">
            <x-heroicon name="user-plus" class="h-5 w-5 text-gray-500 dark:text-gray-400" />
            <span class="text-sm text-gray-500 dark:text-gray-400">Manuel Kayıt</span>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (Session::has('message'))
        <div class="rounded-md bg-blue-50 dark:bg-blue-900/50 p-4 border border-blue-200 dark:border-blue-700">
            <div class="flex">
                <x-heroicon name="information-circle" class="h-5 w-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3" />
                <div class="text-sm text-blue-700 dark:text-blue-300">{{ Session::get('message') }}</div>
            </div>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="rounded-md bg-red-50 dark:bg-red-900/50 p-4 border border-red-200 dark:border-red-700">
            <div class="flex">
                <x-heroicon name="exclamation-triangle" class="h-5 w-5 text-red-600 dark:text-red-400 mt-0.5 mr-3" />
                <div class="text-sm text-red-700 dark:text-red-300">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- User Registration Form -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <x-heroicon name="user-plus" class="h-5 w-5 mr-2" />
                Kullanıcı Bilgileri
            </h2>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ url('admin/dashboard/saveuser') }}" class="space-y-6">
                @csrf

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <x-heroicon name="at-sign" class="h-4 w-4 inline mr-1" />
                        Kullanıcı Adı
                    </label>
                    <input type="text"
                           id="username"
                           name="username"
                           value="{{ old('username') }}"
                           placeholder="Benzersiz kullanıcı adı girin"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white dark:placeholder-gray-400 @error('username') border-red-300 @enderror"
                           required>
                    @error('username')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <x-heroicon name="user" class="h-4 w-4 inline mr-1" />
                        Ad Soyad
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Tam adını girin"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white dark:placeholder-gray-400 @error('name') border-red-300 @enderror"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <x-heroicon name="envelope" class="h-4 w-4 inline mr-1" />
                        E-posta Adresi
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="email@example.com"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white dark:placeholder-gray-400 @error('email') border-red-300 @enderror"
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <x-heroicon name="phone" class="h-4 w-4 inline mr-1" />
                        Telefon Numarası
                    </label>
                    <input type="tel"
                           id="phone"
                           name="phone"
                           value="{{ old('phone') }}"
                           placeholder="Telefon numarasını girin"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white dark:placeholder-gray-400 @error('phone') border-red-300 @enderror"
                           required>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <x-heroicon name="lock-closed" class="h-4 w-4 inline mr-1" />
                            Şifre
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="password"
                                   name="password"
                                   placeholder="Güçlü şifre girin"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white dark:placeholder-gray-400 @error('password') border-red-300 @enderror"
                                   required>
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <x-heroicon name="eye" class="h-4 w-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" id="password-eye" />
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <x-heroicon name="lock-closed" class="h-4 w-4 inline mr-1" />
                            Şifre Onayı
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Şifreyi tekrar girin"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700 dark:border-admin-600 dark:text-white dark:placeholder-gray-400 @error('password_confirmation') border-red-300 @enderror"
                                   required>
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <x-heroicon name="eye" class="h-4 w-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" id="password_confirmation-eye" />
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-admin-700">
                    <a href="{{ route('admin.dashboard') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-admin-700 dark:border-admin-600 dark:text-gray-300 dark:hover:bg-admin-600">
                        <x-heroicon name="arrow-left" class="h-4 w-4 mr-2" />
                        İptal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                        <x-heroicon name="user-plus" class="h-4 w-4 mr-2" />
                        Kullanıcıyı Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Information Card -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-lg p-6 border border-blue-200 dark:border-blue-700">
        <div class="flex items-start">
            <x-heroicon name="information-circle" class="h-5 w-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3" />
            <div>
                <h3 class="font-medium text-blue-900 dark:text-blue-100">Önemli Bilgiler</h3>
                <div class="mt-2 text-sm text-blue-700 dark:text-blue-300 space-y-1">
                    <p>• Kullanıcı adı benzersiz olmalıdır</p>
                    <p>• E-posta adresi geçerli ve aktif olmalıdır</p>
                    <p>• Şifre en az 8 karakter olmalıdır</p>
                    <p>• Telefon numarası doğru formatta girilmelidir</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        // Heroicon: eye icon changed to eye-slash;
    } else {
        field.type = 'password';
        // Heroicon: eye icon changed to eye;
    }

}
</script>
@endsection
