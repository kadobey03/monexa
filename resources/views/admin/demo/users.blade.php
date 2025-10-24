@extends('layouts.admin', ['title' => 'Demo Kullanıcı Yönetimi'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Demo Kullanıcı Yönetimi</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Demo hesaplarını yönet ve kontrol et</p>
        </div>
        <div class="flex space-x-3 mt-4 sm:mt-0">
            <form action="{{ route('admin.demo.bulk-reset') }}" method="POST" class="inline"
                  onsubmit="return confirm('Tüm demo hesapları sıfırlamak istediğinizden emin misiniz? Bu işlem tüm kullanıcıları etkileyecek.')">
                @csrf
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-admin-800">
                    <i data-lucide="rotate-cw" class="h-4 w-4 mr-2"></i>
                    Toplu Sıfırla
                </button>
            </form>
            <a href="{{ route('admin.demo.trades') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                <i data-lucide="trending-up" class="h-4 w-4 mr-2"></i>
                Demo İşlemler
            </a>
        </div>
    </div>

    <x-danger-alert />
    <x-success-alert />

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <i data-lucide="users" class="h-6 w-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Toplam Demo Kullanıcı</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $demoStats['total_users'] ?? $users->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <i data-lucide="trending-up" class="h-6 w-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aktif Demo İşlem</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $demoStats['active_demo_trades'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                        <i data-lucide="dollar-sign" class="h-6 w-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Ort. Demo Bakiye</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">${{ number_format($demoStats['avg_demo_balance'] ?? 0, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                        <i data-lucide="coins" class="h-6 w-6 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Toplam Demo Hacim</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">${{ number_format($demoStats['total_demo_volume'] ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Filter -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Demo Kullanıcı Ara</h3>
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="İsim, e-posta veya kullanıcı adına göre arama yapın"
                       class="w-full rounded-md border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div class="flex space-x-3">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                    <i data-lucide="search" class="h-4 w-4 mr-2"></i>
                    Ara
                </button>
                <a href="{{ route('admin.demo.users') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                    <i data-lucide="x" class="h-4 w-4 mr-2"></i>
                    Temizle
                </a>
            </div>
        </form>
    </div>

    <!-- Demo Users Table -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Demo Kullanıcılar</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-admin-700">
                <thead class="bg-gray-50 dark:bg-admin-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kullanıcı Adı</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">E-posta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Demo Bakiye</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Demo Mod</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hesap Bakiyesi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kayıt Tarihi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-admin-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $user->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->demo_balance > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300' }}">
                                ${{ number_format($user->demo_balance, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->demo_mode)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                                    <i data-lucide="x-circle" class="w-3 h-3 mr-1"></i>
                                    Pasif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${{ number_format($user->account_bal, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <button type="button"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800"
                                    @click="openEditModal({{ $user->id }}, '{{ $user->name }}', {{ $user->demo_balance }})"
                                    title="Demo Bakiye Düzenle">
                                <i data-lucide="edit" class="w-3 h-3 mr-1"></i>
                                Düzenle
                            </button>

                            <form action="{{ route('admin.demo.reset-user', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-admin-800"
                                        onclick="return confirm('Bu kullanıcının demo hesabını sıfırlamak istediğinizden emin misiniz?')"
                                        title="Demo Hesap Sıfırla">
                                    <i data-lucide="rotate-cw" class="w-3 h-3 mr-1"></i>
                                    Sıfırla
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="users" class="h-12 w-12 text-gray-400 dark:text-gray-500 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Kullanıcı bulunamadı</h3>
                                <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Mevcut arama kriterlerinizle eşleşen kullanıcı yok.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-admin-700">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Update Balance Modal -->
<div x-data="{
    editModal: false,
    editUserId: null,
    editUserName: '',
    editCurrentBalance: 0,
    action: 'set',
    amount: 100000
}"
     x-show="editModal"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="editModal = false"></div>

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
                    <i data-lucide="edit" class="h-6 w-6 text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Demo Bakiye Düzenle</h3>
                    
                    <form :action="`/admin/demo/users/${editUserId}/balance`" method="POST" class="mt-4 space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kullanıcı Adı</label>
                            <input type="text"
                                   :value="editUserName"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white bg-gray-50 dark:bg-admin-900 shadow-sm"
                                   readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mevcut Demo Bakiye</label>
                            <input type="text"
                                   :value="`$${parseFloat(editCurrentBalance).toFixed(2)}`"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white bg-gray-50 dark:bg-admin-900 shadow-sm"
                                   readonly>
                        </div>

                        <div>
                            <label for="action" class="block text-sm font-medium text-gray-700 dark:text-gray-300">İşlem</label>
                            <select name="action"
                                    x-model="action"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="set">Bakiyeyi Ayarla</option>
                                <option value="add">Miktar Ekle</option>
                                <option value="subtract">Miktar Çıkar</option>
                            </select>
                        </div>

                        <div>
                            <label for="demo_balance" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Miktar</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                </div>
                                <input type="number"
                                       step="0.01"
                                       name="demo_balance"
                                       x-model="amount"
                                       min="0"
                                       max="10000000"
                                       class="block w-full pl-7 rounded-md border-gray-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       required>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse space-y-2 sm:space-y-0 sm:space-x-reverse sm:space-x-3">
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800 sm:ml-3 sm:w-auto sm:text-sm">
                                Güncelle
                            </button>
                            <button type="button"
                                    @click="editModal = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-admin-600 shadow-sm px-4 py-2 bg-white dark:bg-admin-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800 sm:mt-0 sm:w-auto sm:text-sm">
                                İptal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.openEditModal = function(userId, userName, currentBalance) {
    Alpine.nextTick(() => {
        const modalData = Alpine.findClosest(document.body, '[x-data]').__x.$data;
        modalData.editModal = true;
        modalData.editUserId = userId;
        modalData.editUserName = userName;
        modalData.editCurrentBalance = currentBalance;
        modalData.action = 'set';
        modalData.amount = 100000;
    });
};
</script>
@endsection
