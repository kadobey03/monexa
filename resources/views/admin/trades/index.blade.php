@extends('layouts.admin')

@section('content')

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between bg-gradient-to-r from-violet-600 via-purple-700 to-indigo-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                <i data-lucide="trending-up" class="w-8 h-8 text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold mb-1">İşlem Yönetimi</h1>
                <p class="text-violet-100 text-lg">Kullanıcı işlemlerini izleyin ve yönetin</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <div class="hidden md:flex items-center space-x-2 text-white/80">
                <i data-lucide="home" class="w-4 h-4"></i>
                <span>Dashboard</span>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span>Yönetim</span>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-white font-semibold">İşlemler</span>
            </div>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<x-success-alert />
<x-danger-alert />

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg p-6 border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-admin-500 dark:text-admin-400 text-sm font-medium mb-2">Toplam İşlem</p>
                <h3 class="text-3xl font-bold text-admin-900 dark:text-admin-100">{{ number_format($stats['total'] ?? 0) }}</h3>
                <p class="text-xs text-admin-400 mt-1">Tüm işlemler</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="trending-up" class="w-7 h-7 text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg p-6 border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-admin-500 dark:text-admin-400 text-sm font-medium mb-2">Aktif İşlemler</p>
                <h3 class="text-3xl font-bold text-admin-900 dark:text-admin-100">{{ number_format($stats['active'] ?? 0) }}</h3>
                <p class="text-xs text-admin-400 mt-1">Devam eden</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="clock" class="w-7 h-7 text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg p-6 border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-admin-500 dark:text-admin-400 text-sm font-medium mb-2">Tamamlanan</p>
                <h3 class="text-3xl font-bold text-admin-900 dark:text-admin-100">{{ number_format($stats['expired'] ?? 0) }}</h3>
                <p class="text-xs text-admin-400 mt-1">Bitmiş işlemler</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="check-circle" class="w-7 h-7 text-white"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg p-6 border border-admin-200 dark:border-admin-700 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-admin-500 dark:text-admin-400 text-sm font-medium mb-2">Toplam Hacim</p>
                <h3 class="text-3xl font-bold text-admin-900 dark:text-admin-100">${{ number_format($stats['total_volume'] ?? 0, 2) }}</h3>
                <p class="text-xs text-admin-400 mt-1">USD değeri</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-violet-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="dollar-sign" class="w-7 h-7 text-white"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700 mb-8">
    <div class="p-6 border-b border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="search" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-admin-900 dark:text-admin-100">Filtreler ve Arama</h2>
                    <p class="text-admin-500 dark:text-admin-400 text-sm">İşlemleri filtreleyin ve arayın</p>
                </div>
            </div>
            <button id="toggleFilters" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl transition-all duration-200 shadow-lg">
                <i data-lucide="filter" class="w-4 h-4 mr-2"></i>
                Filtreleri Aç/Kapat
            </button>
        </div>
    </div>
    <div id="filtersPanel" class="hidden p-6">
        <form method="GET" action="{{ route('admin.trades.index') }}" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">Kullanıcı Ara</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-admin-900 dark:text-admin-100"
                           placeholder="Kullanıcı adı veya e-posta">
                </div>
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">Durum</label>
                    <select name="status" class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-admin-900 dark:text-admin-100">
                        <option value="">Tümü</option>
                        <option value="yes" {{ request('status') == 'yes' ? 'selected' : '' }}>Aktif</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Tamamlandı</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">İşlem Türü</label>
                    <select name="type" class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-admin-900 dark:text-admin-100">
                        <option value="">Tümü</option>
                        <option value="Buy" {{ request('type') == 'Buy' ? 'selected' : '' }}>Alış</option>
                        <option value="Sell" {{ request('type') == 'Sell' ? 'selected' : '' }}>Satış</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">Varlık</label>
                    <input type="text" name="asset" value="{{ request('asset') }}"
                           class="w-full px-4 py-3 bg-white dark:bg-admin-700 border border-admin-300 dark:border-admin-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-admin-900 dark:text-admin-100"
                           placeholder="Varlık adı">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl transition-all duration-200 shadow-lg">
                        <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                        Filtrele
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Trades Table -->
<div class="bg-white dark:bg-admin-800 rounded-2xl shadow-lg border border-admin-200 dark:border-admin-700">
    <div class="p-6 border-b border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-admin-900 dark:text-admin-100">Kullanıcı İşlemleri</h2>
                    <p class="text-admin-500 dark:text-admin-400 text-sm">{{ $trades->total() }} toplam kayıt</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="testRoutes()" class="px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl transition-colors shadow-lg">
                    <i data-lucide="bug" class="w-4 h-4 mr-2"></i>
                    Test
                </button>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" id="exportDropdown" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-colors shadow-lg">
                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                        Dışa Aktar
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition id="exportMenu" class="absolute right-0 mt-2 w-48 bg-white dark:bg-admin-800 rounded-xl shadow-xl border border-admin-200 dark:border-admin-700 z-50">
                        <a href="{{ route('admin.trades.export', ['format' => 'csv'] + request()->all()) }}"
                           class="flex items-center px-4 py-3 text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-700 rounded-t-xl transition-colors">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>CSV
                        </a>
                        <a href="{{ route('admin.trades.export', ['format' => 'excel'] + request()->all()) }}"
                           class="flex items-center px-4 py-3 text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-700 rounded-b-xl transition-colors">
                            <i data-lucide="file-spreadsheet" class="w-4 h-4 mr-2"></i>Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asset</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leverage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profit/Loss</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($trades as $trade)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">#{{ $trade->id }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <i class="fas fa-user-circle text-2xl text-gray-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $trade->user->name ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $trade->user->email ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">{{ $trade->assets ?? 'N/A' }}</span>
                                    @if($trade->symbol)
                                        <div class="text-xs text-gray-500 mt-1">{{ $trade->symbol }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($trade->type)
                                        <span class="px-2 py-1 text-xs rounded {{ $trade->type == 'Buy' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            <i class="fas {{ $trade->type == 'Buy' ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                                            {{ $trade->type }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ${{ number_format($trade->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">1:{{ $trade->leverage ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($trade->profit_earned)
                                        @if($trade->profit_earned > 0)
                                            <span class="text-green-600 font-medium">
                                                <i class="fas fa-arrow-up mr-1"></i>
                                                +${{ number_format($trade->profit_earned, 2) }}
                                            </span>
                                        @else
                                            <span class="text-red-600 font-medium">
                                                <i class="fas fa-arrow-down mr-1"></i>
                                                ${{ number_format($trade->profit_earned, 2) }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">$0.00</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($trade->active == 'yes')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">
                                            <i class="fas fa-clock mr-1"></i>Active
                                        </span>
                                    @elseif($trade->active == 'expired')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">
                                            <i class="fas fa-check mr-1"></i>Completed
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">{{ ucfirst($trade->active ?? 'N/A') }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>{{ $trade->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $trade->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($trade->expire_date)
                                        <div>{{ \Carbon\Carbon::parse($trade->expire_date)->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($trade->expire_date)->format('H:i') }}</div>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.trades.edit', $trade->id) }}" 
                                           class="text-blue-600 hover:text-blue-900" title="Edit Trade">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="showAddProfitForm({{ $trade->id }})" 
                                                class="text-green-600 hover:text-green-900" title="Add Profit">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button onclick="deleteTrade({{ $trade->id }})" 
                                                class="text-red-600 hover:text-red-900" title="Delete Trade">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No trades found</h3>
                                        <p class="text-gray-500">Try adjusting your filters or search criteria.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($trades->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $trades->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Profit Modal -->
<div id="addProfitModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-plus-circle mr-2"></i>Add Profit to User ROI
                    </h3>
                    <button onclick="closeModal('addProfitModal')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <form id="addProfitForm" method="POST" action="">
                @csrf
                <div class="p-6">
                    <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            This will add the specified amount to both the trade's profit_earned and the user's ROI.
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Profit Amount ($)</label>
                        <input type="number" id="profit_amount" name="profit_amount" step="0.01" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter amount to add">
                        <p class="text-xs text-gray-500 mt-1">Use positive numbers for profit, negative for loss</p>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Note (Optional)</label>
                        <textarea id="profit_note" name="note" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Add a note about this profit adjustment..."></textarea>
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('addProfitModal')" 
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-1"></i>Add Profit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal functions
    window.closeModal = function(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    };

    window.showAddProfitForm = function(tradeId) {
        const form = document.getElementById('addProfitForm');
        const profitUrl = '{{ url("/admin/trades") }}/' + tradeId + '/add-profit';
        form.setAttribute('action', profitUrl);
        
        // Clear form
        document.getElementById('profit_amount').value = '';
        document.getElementById('profit_note').value = '';
        
        // Show modal
        document.getElementById('addProfitModal').classList.remove('hidden');
    };

    window.deleteTrade = function(tradeId) {
        const deleteUrl = '{{ url("/admin/trades") }}/' + tradeId;
        
        Swal.fire({
            title: 'İşlemi Sil?',
            text: 'Bu işlem geri alınamaz. Devam etmek istiyor musunuz?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Evet, Sil',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    };

    window.testRoutes = function() {
        console.log('Route testi başlatılıyor...');
        const baseUrl = '{{ url('/') }}';
        const routes = [
            baseUrl + '/admin/trades',
            baseUrl + '/admin/trades/1',
            baseUrl + '/admin/trades/1/edit'
        ];

        routes.forEach(url => {
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log(`Route ${url}: Status ${response.status}`);
            })
            .catch(error => {
                console.log(`Route ${url}: Hata ${error.message}`);
            });
        });
    };

    // Toggle filters
    const toggleFilters = document.getElementById('toggleFilters');
    if (toggleFilters) {
        toggleFilters.addEventListener('click', function() {
            const panel = document.getElementById('filtersPanel');
            panel.classList.toggle('hidden');
        });
    }

    // Initialize Lucide icons after content is loaded
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Auto-dismiss alerts
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            alert.style.display = 'none';
        });
    }, 5000);
});
</script>
@endpush