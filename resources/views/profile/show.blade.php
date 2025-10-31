
@extends('layouts.dasht')
@section('title', $title)
@section('content')
<div class="container mx-auto px-4 py-6">
    <x-danger-alert/>
	<x-success-alert/>
    
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Güvenlik/Hesap Silme') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Hesap güvenlik ayarlarınızı yönetin
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Two Factor Authentication -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        İki Faktörlü Kimlik Doğrulama
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Hesabınızın güvenliğini artırmak için 2FA'yı etkinleştirin
                    </p>
                </div>
                <div class="p-6">
                    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                        @livewire('profile.two-factor-authentication-form')
                    @endif
                </div>
            </div>
        </div>

        <!-- Security Information -->
        <div class="space-y-6">
            <!-- Active Sessions -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Aktif Oturumlar
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Diğer tarayıcılardaki oturumları yönetin
                    </p>
                </div>
                <div class="p-6">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>
            </div>

            <!-- Account Deletion -->
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="bg-red-50 dark:bg-red-900/10 rounded-2xl border border-red-200 dark:border-red-800 overflow-hidden">
                    <div class="px-6 py-4 border-b border-red-200 dark:border-red-800">
                        <h3 class="text-lg font-semibold text-red-900 dark:text-red-100">
                            Hesap Silme
                        </h3>
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">
                            Bu işlem geri alınamaz
                        </p>
                    </div>
                    <div class="p-6">
                        @livewire('profile.delete-user-form')
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
