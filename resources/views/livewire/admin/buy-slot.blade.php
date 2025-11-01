<div>
    <form wire:submit.prevent='purchaseSlot' class="space-y-4">
        @csrf
        <div>
            <label for="" class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">Number of Slot</label>
            <input type="number" name="numofslot" wire:keyup='calculateSlot' wire:model='slot' class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg bg-white dark:bg-admin-700 text-admin-900 dark:text-admin-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                required>
            <small class="text-sm text-red-600 mt-1 block">{{ $message }}</small>
        </div>
        <div>
            <label for="" class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">You will be charged ($)</label>
            <input type="number" name="amount" wire:model='amount' class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg bg-admin-50 dark:bg-admin-600 text-admin-900 dark:text-admin-100" readonly>
            <small class="text-sm text-admin-500 dark:text-admin-400 mt-1 block">Amount will be deducted from your wallet</small>
        </div>
        <div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors font-medium">
                Purchase
            </button>
        </div>
    </form>
</div>
