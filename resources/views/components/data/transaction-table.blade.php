@props([
    'transactions' => [],
    'columns' => null,
    'sortable' => true,
    'filterable' => true,
    'pagination' => true,
    'emptyMessage' => __('No transactions found')
])

@php
    $defaultColumns = [
        'date' => ['label' => __('Date'), 'sortable' => true],
        'type' => ['label' => __('Type'), 'sortable' => true],
        'amount' => ['label' => __('Amount'), 'sortable' => true],
        'status' => ['label' => __('Status'), 'sortable' => false],
        'actions' => ['label' => __('Actions'), 'sortable' => false]
    ];

    $columns = $columns ?? $defaultColumns;
@endphp

<div class="bg-surface rounded-lg shadow overflow-hidden">
    <!-- Table Header -->
    <div class="px-6 py-4 border-b border-border">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-text-primary">
                {{ __('Transactions') }}
            </h3>

            @if($filterable)
                <div class="flex items-center space-x-4">
                    <input
                        type="text"
                        placeholder="{{ __('Search transactions...') }}"
                        class="px-3 py-2 border border-border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        wire:model.live.debounce.300ms="search"
                    />

                    <select
                        class="px-3 py-2 border border-border rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        wire:model.live="statusFilter"
                    >
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="completed">{{ __('Completed') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="failed">{{ __('Failed') }}</option>
                    </select>
                </div>
            @endif
        </div>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-border">
            <thead class="bg-surface-hover">
                <tr>
                    @foreach($columns as $key => $column)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase tracking-wider">
                            @if($sortable && ($column['sortable'] ?? false))
                                <button
                                    wire:click="sortBy('{{ $key }}')"
                                    class="flex items-center space-x-1 hover:text-text-primary focus:outline-none focus:text-text-primary"
                                >
                                    <span>{{ $column['label'] }}</span>
                                    @if(isset($sortField) && $sortField === $key)
                                        <x-ui.icon
                                            name="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                            class="w-4 h-4"
                                        />
                                    @endif
                                </button>
                            @else
                                {{ $column['label'] }}
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="bg-surface divide-y divide-border">
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-surface-hover">
                        @foreach(array_keys($columns) as $columnKey)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-primary">
                                @switch($columnKey)
                                    @case('date')
                                        {{ $transaction->created_at->format('M d, Y H:i') }}
                                        @break

                                    @case('type')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $transaction->type === 'deposit' ? 'bg-success-100 text-success-800' : 'bg-info-100 text-info-800' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                        @break

                                    @case('amount')
                                        <x-financial.amount-display
                                            :amount="$transaction->amount"
                                            :currency="$transaction->currency ?? 'USD'"
                                            size="sm"
                                        />
                                        @break

                                    @case('status')
                                        <x-financial.transaction-status :status="$transaction->status" />
                                        @break

                                    @case('actions')
                                        <div class="flex items-center space-x-2">
                                            <button
                                                wire:click="viewTransaction({{ $transaction->id }})"
                                                class="text-primary-600 hover:text-primary-900 text-sm font-medium"
                                            >
                                                {{ __('View') }}
                                            </button>
                                        </div>
                                        @break

                                    @default
                                        {{ $transaction->{$columnKey} ?? '-' }}
                                @endswitch
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) }}" class="px-6 py-12 text-center text-text-secondary">
                            <x-ui.icon name="document" class="mx-auto h-12 w-12 text-text-muted" />
                            <h3 class="mt-2 text-sm font-medium text-text-primary">{{ __('No transactions') }}</h3>
                            <p class="mt-1 text-sm text-text-secondary">{{ $emptyMessage }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($pagination && $transactions->hasPages())
        <div class="px-6 py-4 border-t border-border bg-surface">
            {{ $transactions->links() }}
        </div>
    @endif
</div>