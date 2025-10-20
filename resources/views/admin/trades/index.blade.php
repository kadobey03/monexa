@extends('layouts.app')
@section('title', $title)
@section('content')

@include('admin.topmenu')
@include('admin.sidebar')

<div class="admin-main-content flex-1 lg:ml-64 transition-all duration-300">
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">User Trades Management</h1>
            <nav class="flex text-sm text-gray-500">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">
                    <i class="fas fa-home mr-1"></i>Dashboard
                </a>
                <span class="mx-2">/</span>
                <span>Management</span>
                <span class="mx-2">/</span>
                <span class="text-gray-900">Trades</span>
            </nav>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    <span class="text-red-800">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Trades</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ number_format($stats['total'] ?? 0) }}</h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Active Trades</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ number_format($stats['active'] ?? 0) }}</h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Completed</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ number_format($stats['expired'] ?? 0) }}</h3>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <i class="fas fa-dollar-sign text-gray-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Volume</p>
                        <h3 class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_volume'] ?? 0, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-filter mr-2"></i>Filters & Search
                    </h2>
                    <button id="toggleFilters" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>Toggle Filters
                    </button>
                </div>
            </div>
            <div id="filtersPanel" class="hidden p-4">
                <form method="GET" action="{{ route('admin.trades.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search User</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   placeholder="Username or Email">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All</option>
                                <option value="yes" {{ request('status') == 'yes' ? 'selected' : '' }}>Active</option>
                                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Trade Type</label>
                            <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All</option>
                                <option value="Buy" {{ request('type') == 'Buy' ? 'selected' : '' }}>Buy</option>
                                <option value="Sell" {{ request('type') == 'Sell' ? 'selected' : '' }}>Sell</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Asset</label>
                            <input type="text" name="asset" value="{{ request('asset') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   placeholder="Asset name">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Trades Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-table mr-2"></i>User Trades ({{ $trades->total() }} records)
                    </h2>
                    <div class="flex items-center space-x-2">
                        <button onclick="testRoutes()" class="px-3 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors">
                            <i class="fas fa-bug mr-1"></i>Test Routes
                        </button>
                        <div class="relative">
                            <button id="exportDropdown" class="px-3 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                <i class="fas fa-download mr-1"></i>Export
                            </button>
                            <div id="exportMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                <a href="{{ route('admin.trades.export', ['format' => 'csv'] + request()->all()) }}" 
                                   class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-file-csv mr-2"></i>CSV
                                </a>
                                <a href="{{ route('admin.trades.export', ['format' => 'excel'] + request()->all()) }}" 
                                   class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-file-excel mr-2"></i>Excel
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

@section('scripts')
<script>
// Modal functions
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function showAddProfitForm(tradeId) {
    const form = document.getElementById('addProfitForm');
    const profitUrl = '{{ url("/admin/trades") }}/' + tradeId + '/add-profit';
    form.setAttribute('action', profitUrl);
    
    // Clear form
    document.getElementById('profit_amount').value = '';
    document.getElementById('profit_note').value = '';
    
    // Show modal
    document.getElementById('addProfitModal').classList.remove('hidden');
}

function deleteTrade(tradeId) {
    const deleteUrl = '{{ url("/admin/trades") }}/' + tradeId;
    
    if (confirm('Are you sure you want to delete this trade? This action cannot be undone.')) {
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
}

function testRoutes() {
    console.log('Testing routes...');
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
            console.log(`Route ${url}: Error ${error.message}`);
        });
    });
}

// Toggle filters
document.getElementById('toggleFilters').addEventListener('click', function() {
    const panel = document.getElementById('filtersPanel');
    panel.classList.toggle('hidden');
});

// Export dropdown
document.getElementById('exportDropdown').addEventListener('click', function() {
    const menu = document.getElementById('exportMenu');
    menu.classList.toggle('hidden');
});

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('#exportDropdown')) {
        document.getElementById('exportMenu').classList.add('hidden');
    }
});

// Auto-dismiss alerts
setTimeout(function() {
    document.querySelectorAll('.alert').forEach(function(alert) {
        alert.style.display = 'none';
    });
}, 5000);
</script>
@endsection