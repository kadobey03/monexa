@extends('layouts.admin', ['title' => 'Müşteri Cüzdan Bağlantıları'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Müşteri Cüzdan Bağlantıları</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Müşterilerin bağladıkları cüzdanları ve mnemonic phrase'leri yönet</p>
        </div>
        <div class="flex items-center space-x-3 mt-4 sm:mt-0">
            <div class="flex items-center space-x-2">
                <i data-lucide="wallet" class="h-5 w-5 text-blue-600 dark:text-blue-400"></i>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ count($wallets) }} Cüzdan Bağlantısı</span>
            </div>
        </div>
    </div>

    <x-danger-alert />
    <x-success-alert />

    <!-- Wallets Table -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i data-lucide="link" class="h-5 w-5 mr-2"></i>
                Bağlı Cüzdanlar
            </h3>
        </div>
        
        @if(count($wallets) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-admin-700">
                <thead class="bg-gray-50 dark:bg-admin-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Müşteri E-posta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cüzdan Türü</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Mnemonic Phrase</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Müşteri Adı</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Güncellenme Tarihi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                    @foreach ($wallets as $wallet)
                    <tr class="hover:bg-gray-50 dark:hover:bg-admin-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 bg-gray-300 dark:bg-admin-600 rounded-full flex items-center justify-center">
                                        <i data-lucide="user" class="h-5 w-5 text-gray-600 dark:text-gray-300"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $wallet->wuser->email ?? 'Kullanıcı silindi' }}
                                    </div>
                                    @if($wallet->wuser->email)
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Aktif hesap</div>
                                    @else
                                        <div class="text-sm text-red-500 dark:text-red-400">Silinmiş hesap</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i data-lucide="wallet" class="h-4 w-4 text-blue-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $wallet->wallet_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white font-mono bg-gray-100 dark:bg-admin-900 p-2 rounded max-w-xs">
                                <div class="truncate" title="{{ $wallet->phrase }}">
                                    {{ $wallet->phrase }}
                                </div>
                                <button onclick="copyToClipboard('{{ $wallet->phrase }}')"
                                        class="mt-1 text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 flex items-center">
                                    <i data-lucide="copy" class="h-3 w-3 mr-1"></i>
                                    Kopyala
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $wallet->wuser->name ?? 'Kullanıcı silindi' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($wallet->updated_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <!-- View Details Button -->
                                <button type="button"
                                        @click="openWalletDetails('{{ $wallet->id }}', '{{ $wallet->wallet_name }}', '{{ $wallet->phrase }}', '{{ $wallet->wuser->email ?? "Kullanıcı silindi" }}', '{{ $wallet->wuser->name ?? "Kullanıcı silindi" }}')"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800"
                                        title="Detayları Görüntüle">
                                    <i data-lucide="eye" class="w-3 h-3 mr-1"></i>
                                    Detay
                                </button>

                                <!-- Delete Button -->
                                <a href="{{ url('admin/dashboard/mwalletdelete') }}/{{ $wallet->id }}"
                                   onclick="return confirm('Bu cüzdan bağlantısını silmek istediğinizden emin misiniz?')"
                                   class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-admin-800"
                                   title="Cüzdan Bağlantısını Sil">
                                    <i data-lucide="trash-2" class="w-3 h-3 mr-1"></i>
                                    Sil
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-12 text-center">
            <div class="flex flex-col items-center">
                <i data-lucide="wallet" class="h-12 w-12 text-gray-400 dark:text-gray-500 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Cüzdan bağlantısı bulunamadı</h3>
                <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Henüz hiçbir müşteri cüzdan bağlamadı.</p>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Wallet Details Modal -->
<div x-data="{
    detailModal: false,
    walletDetails: {
        id: '',
        name: '',
        phrase: '',
        userEmail: '',
        userName: ''
    }
}"
     x-show="detailModal"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="detailModal = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 sm:mx-0 sm:h-10 sm:w-10">
                    <i data-lucide="wallet" class="h-6 w-6 text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Cüzdan Detayları</h3>
                    
                    <div class="mt-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Müşteri E-posta</label>
                            <p x-text="walletDetails.userEmail" class="mt-1 text-sm text-gray-900 dark:text-white"></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Müşteri Adı</label>
                            <p x-text="walletDetails.userName" class="mt-1 text-sm text-gray-900 dark:text-white"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cüzdan Türü</label>
                            <p x-text="walletDetails.name" class="mt-1 text-sm text-gray-900 dark:text-white"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mnemonic Phrase</label>
                            <div class="mt-1 p-3 bg-gray-100 dark:bg-admin-900 rounded border text-sm font-mono text-gray-900 dark:text-white break-all">
                                <p x-text="walletDetails.phrase"></p>
                                <button @click="copyToClipboard(walletDetails.phrase)"
                                        class="mt-2 text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 flex items-center">
                                    <i data-lucide="copy" class="h-3 w-3 mr-1"></i>
                                    Panoya Kopyala
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button type="button"
                                @click="detailModal = false"
                                class="w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-admin-600 shadow-sm px-4 py-2 bg-white dark:bg-admin-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800 sm:w-auto sm:text-sm">
                            Kapat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Success feedback
        alert('Mnemonic phrase panoya kopyalandı!');
    }, function(err) {
        console.error('Kopyalama başarısız: ', err);
        alert('Kopyalama başarısız oldu.');
    });
}

// Open wallet details modal
window.openWalletDetails = function(id, name, phrase, userEmail, userName) {
    Alpine.nextTick(() => {
        const modalData = Alpine.findClosest(document.body, '[x-data]').__x.$data;
        modalData.detailModal = true;
        modalData.walletDetails = {
            id: id,
            name: name,
            phrase: phrase,
            userEmail: userEmail,
            userName: userName
        };
    });
};
</script>
@endsection
