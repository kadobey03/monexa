<div class="space-y-6">
    <div class="flex flex-wrap">
        <div class="w-full">
            <h3 class="text-xl font-medium text-blue-600 dark:text-blue-400 mb-6">This section describes how you want to use Pro Remedy Investment script.</h3>
            <form action="">
                <div class="flex flex-wrap gap-6">
                    <div class="w-full md:w-1/2 mt-4">
                        <h5 class="text-lg font-medium text-admin-700 dark:text-admin-300 mb-3">Investment:</h5>
                        <div class="flex rounded-lg border border-admin-300 dark:border-admin-600 overflow-hidden">
                            <label class="flex-1">
                                <input type="radio" class="sr-only" name="investment"
                                    wire:click="updateModule('investment','true')"
                                    {{ $mod['investment'] == 'true' ? 'checked' : '' }}>
                                <div class="flex-1 px-4 py-2 text-center cursor-pointer transition-colors {{ $mod['investment'] == 'true' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-admin-700 text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-600' }}">
                                    Enabled
                                </div>
                            </label>
                            <label class="flex-1">
                                <input type="radio" class="sr-only" name="investment"
                                    wire:click="updateModule('investment','false')"
                                    {{ $mod['investment'] == 'false' ? 'checked' : '' }}>
                                <div class="flex-1 px-4 py-2 text-center cursor-pointer transition-colors {{ $mod['investment'] == 'false' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-admin-700 text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-600' }}">
                                    Disabled
                                </div>
                            </label>
                        </div>
                        <div class="mt-2 pr-3">
                            <small class="text-sm text-admin-500 dark:text-admin-400">All features relating to user investment will be displayed on user dashboard(buying of plan and earning profit etc..).</small>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 mt-4">
                        <h5 class="text-lg font-medium text-admin-700 dark:text-admin-300 mb-3">Crypto Swap:</h5>
                        <div class="flex rounded-lg border border-admin-300 dark:border-admin-600 overflow-hidden">
                            <label class="flex-1">
                                <input type="radio" class="sr-only" name="cryptoswap"
                                    wire:click="updateModule('cryptoswap','true')"
                                    {{ $mod['cryptoswap'] ? 'checked' : '' }}>
                                <div class="flex-1 px-4 py-2 text-center cursor-pointer transition-colors {{ $mod['cryptoswap'] ? 'bg-blue-600 text-white' : 'bg-white dark:bg-admin-700 text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-600' }}">
                                    Enabled
                                </div>
                            </label>
                            <label class="flex-1">
                                <input type="radio" class="sr-only" name="cryptoswap"
                                    wire:click="updateModule('cryptoswap','false')"
                                    {{ $mod['cryptoswap'] ? '' : 'checked' }}>
                                <div class="flex-1 px-4 py-2 text-center cursor-pointer transition-colors {{ !$mod['cryptoswap'] ? 'bg-blue-600 text-white' : 'bg-white dark:bg-admin-700 text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-600' }}">
                                    Disabled
                                </div>
                            </label>
                        </div>
                        <div class="mt-2">
                            <small class="text-sm text-admin-500 dark:text-admin-400">If enabled, the system will display all functionalities about crypto swapping on user dashboard.</small>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
