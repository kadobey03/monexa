
<?php $__env->startSection('title', 'Demo Trading History'); ?>
<?php $__env->startSection('content'); ?>

<!-- Simple Header -->
<div class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800" x-cloak>
    <div class="px-4 py-6 sm:py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="text-center lg:text-left">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    Demo Trading History
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Review your past demo trades and track your performance
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <div class="inline-flex items-center justify-center gap-2 px-3 py-2 sm:px-4 sm:py-3 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg text-xs sm:text-sm lg:text-base">
                    <i data-lucide="wallet" class="w-3 h-3 sm:w-4 sm:h-4 lg:w-5 lg:h-5"></i>
                    <span class="hidden sm:inline">Balance:</span> $<?php echo e(number_format(auth()->user()->demo_balance, 2)); ?>

                </div>
                <a href="<?php echo e(route('demo.trade')); ?>" class="inline-flex items-center justify-center gap-2 px-3 py-2 sm:px-4 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition-colors text-xs sm:text-sm lg:text-base">
                    <i data-lucide="plus" class="w-3 h-3 sm:w-4 sm:h-4 lg:w-5 lg:h-5"></i>
                    <span class="hidden sm:inline">New</span> Trade
                </a>
                <a href="<?php echo e(route('demo.dashboard')); ?>" class="inline-flex items-center justify-center gap-2 px-3 py-2 sm:px-4 sm:py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow transition-colors text-xs sm:text-sm lg:text-base">
                    <i data-lucide="arrow-left" class="w-3 h-3 sm:w-4 sm:h-4 lg:w-5 lg:h-5"></i> Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="px-4 py-6 sm:py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <!-- Alerts -->
    <div class="space-y-4 mb-6">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.danger-alert','data' => []]); ?>
<?php $component->withName('danger-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.success-alert','data' => []]); ?>
<?php $component->withName('success-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </div>

    <?php if($trades->count() > 0): ?>
    <!-- Statistics Summary -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
        <?php
            $totalTrades = $trades->total();
            $activeTrades = $trades->where('active', 'yes')->count();
            $winTrades = $trades->where('result_type', 'WIN')->count();
            $winRate = $totalTrades > 0 ? round(($winTrades / $totalTrades) * 100, 1) : 0;
            $totalPnL = $trades->sum(function($trade) {
                return $trade->active === 'yes' ? $trade->calculatePnL() : ($trade->profit_earned ?? 0);
            });
        ?>

        <div class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-100 dark:border-gray-800 p-3 sm:p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg sm:text-xl lg:text-2xl xl:text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($totalTrades); ?></h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Total Trades</p>
                </div>
                <div class="p-2 sm:p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <i data-lucide="trending-up" class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-100 dark:border-gray-800 p-3 sm:p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg sm:text-xl lg:text-2xl xl:text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($winRate); ?>%</h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Win Rate</p>
                </div>
                <div class="p-2 sm:p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <i data-lucide="target" class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-green-600 dark:text-green-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-100 dark:border-gray-800 p-3 sm:p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm sm:text-lg lg:text-2xl xl:text-3xl font-bold <?php echo e($totalPnL >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                        $<?php echo e(number_format($totalPnL, 2)); ?>

                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Total P&L</p>
                </div>
                <div class="p-2 sm:p-3 bg-<?php echo e($totalPnL >= 0 ? 'green' : 'red'); ?>-100 dark:bg-<?php echo e($totalPnL >= 0 ? 'green' : 'red'); ?>-900/30 rounded-lg">
                    <i data-lucide="dollar-sign" class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-<?php echo e($totalPnL >= 0 ? 'green' : 'red'); ?>-600 dark:text-<?php echo e($totalPnL >= 0 ? 'green' : 'red'); ?>-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-100 dark:border-gray-800 p-3 sm:p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg sm:text-xl lg:text-2xl xl:text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($activeTrades); ?></h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Active Trades</p>
                </div>
                <div class="p-2 sm:p-3 bg-orange-100 dark:bg-orange-900/30 rounded-lg">
                    <i data-lucide="activity" class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-orange-600 dark:text-orange-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm mb-6">
        <div class="p-3 sm:p-4 lg:p-6 border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between">
                <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white">Filters</h3>
                <button type="button" id="toggleFilters" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                    <span id="filterToggleText">Show Filters</span>
                    <i data-lucide="chevron-down" id="filterToggleIcon" class="w-3 h-3 sm:w-4 sm:h-4 inline-block ml-1 transition-transform"></i>
                </button>
            </div>
        </div>

        <div id="filterSection" class="hidden p-3 sm:p-4 lg:p-6">
            <form method="GET" action="<?php echo e(route('demo.history')); ?>" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Status</option>
                            <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                            <option value="closed" <?php echo e(request('status') === 'closed' ? 'selected' : ''); ?>>Closed</option>
                        </select>
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trade Type</label>
                        <select name="type" class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Types</option>
                            <option value="Buy" <?php echo e(request('type') === 'Buy' ? 'selected' : ''); ?>>Buy</option>
                            <option value="Sell" <?php echo e(request('type') === 'Sell' ? 'selected' : ''); ?>>Sell</option>
                        </select>
                    </div>

                    <!-- Result Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Result</label>
                        <select name="result" class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Results</option>
                            <option value="WIN" <?php echo e(request('result') === 'WIN' ? 'selected' : ''); ?>>Win</option>
                            <option value="LOSE" <?php echo e(request('result') === 'LOSE' ? 'selected' : ''); ?>>Loss</option>
                        </select>
                    </div>

                    <!-- Per Page -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Per Page</label>
                        <select name="per_page" class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="20" <?php echo e(request('per_page', 20) == 20 ? 'selected' : ''); ?>>20</option>
                            <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                            <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    <!-- Asset Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Asset</label>
                        <input type="text" name="asset" value="<?php echo e(request('asset')); ?>"
                               placeholder="e.g., BTC, ETH, EUR/USD"
                               class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Date From -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From Date</label>
                        <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"
                               class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">To Date</label>
                        <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"
                               class="w-full px-2 py-1.5 sm:px-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-4">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-colors">
                        <i data-lucide="search" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                        Apply Filters
                    </button>
                    <a href="<?php echo e(route('demo.history')); ?>" class="inline-flex items-center justify-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-xs sm:text-sm font-medium transition-colors">
                        <i data-lucide="x" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Trading History Table -->
    <div class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <div class="p-3 sm:p-4 lg:p-6 border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Trading History</h2>
                <?php if($trades->count() > 0): ?>
                    <span class="inline-flex items-center px-2 py-1 sm:px-3 sm:py-1 text-xs sm:text-sm bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full">
                        <?php echo e($trades->total()); ?> <?php echo e($trades->total() === 1 ? 'Trade' : 'Trades'); ?>

                    </span>
                <?php endif; ?>
            </div>
        </div>

        <?php if($trades->count() > 0): ?>
        <!-- Mobile Card Layout (hidden on lg+) -->
        <div class="block lg:hidden space-y-4 p-4">
            <?php $__currentLoopData = $trades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <!-- Asset and Type Row -->
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($trade->assets); ?></h4>
                        <?php if($trade->symbol && $trade->symbol !== $trade->assets): ?>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($trade->symbol); ?></p>
                        <?php endif; ?>
                    </div>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                        <?php echo e($trade->type === 'Buy' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'); ?>">
                        <?php echo e($trade->type); ?>

                    </span>
                </div>

                <!-- Amount and P&L Row -->
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Amount</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">$<?php echo e(number_format($trade->amount, 2)); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">P&L</p>
                        <?php
                            $pnl = $trade->active === 'yes' ? $trade->calculatePnL() : ($trade->profit_earned ?? 0);
                            $pnlClass = $pnl >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                            $returnPercentage = $trade->amount > 0 ? ($pnl / $trade->amount) * 100 : 0;
                        ?>
                        <div class="text-sm font-semibold <?php echo e($pnlClass); ?>">
                            <?php echo e($pnl >= 0 ? '+' : ''); ?>$<?php echo e(number_format($pnl, 2)); ?>

                        </div>
                        <div class="text-xs <?php echo e($pnlClass); ?>">
                            (<?php echo e($returnPercentage >= 0 ? '+' : ''); ?><?php echo e(number_format($returnPercentage, 2)); ?>%)
                        </div>
                    </div>
                </div>

                <!-- Status and Actions Row -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <?php if($trade->active === 'yes'): ?>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                Active
                            </span>
                        <?php else: ?>
                            <?php
                                $resultClass = match($trade->result_type) {
                                    'WIN' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                    'LOSE' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                    default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400'
                                };
                            ?>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($resultClass); ?>">
                                <?php echo e($trade->result_type ?? 'Closed'); ?>

                            </span>
                        <?php endif; ?>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            <?php echo e($trade->created_at->format('M d, Y H:i')); ?>

                        </span>
                    </div>
                    <?php if($trade->active === 'yes'): ?>
                        <form action="<?php echo e(route('demo.close', $trade->id)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 rounded-lg transition-colors"
                                    onclick="return confirm('Are you sure you want to close this trade?')">
                                <i data-lucide="x" class="w-3 h-3 mr-1"></i>
                                Close
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Desktop Table Layout (hidden on mobile) -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Asset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Leverage</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Entry</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Current</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">P&L</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <?php $__currentLoopData = $trades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                <?php echo e($trade->assets); ?>

                            </div>
                            <?php if($trade->symbol && $trade->symbol !== $trade->assets): ?>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                <?php echo e($trade->symbol); ?>

                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                <?php echo e($trade->type === 'Buy' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'); ?>">
                                <?php echo e($trade->type); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            $<?php echo e(number_format($trade->amount, 2)); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            <?php echo e($trade->leverage); ?>x
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            <?php if($trade->entry_price): ?>
                                $<?php echo e(number_format($trade->entry_price, 4)); ?>

                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            <?php if($trade->current_price): ?>
                                $<?php echo e(number_format($trade->current_price, 4)); ?>

                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                                $pnl = $trade->active === 'yes' ? $trade->calculatePnL() : ($trade->profit_earned ?? 0);
                                $pnlClass = $pnl >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
                                $returnPercentage = $trade->amount > 0 ? ($pnl / $trade->amount) * 100 : 0;
                            ?>
                            <div class="text-sm font-semibold <?php echo e($pnlClass); ?>">
                                <?php echo e($pnl >= 0 ? '+' : ''); ?>$<?php echo e(number_format($pnl, 2)); ?>

                            </div>
                            <div class="text-xs <?php echo e($pnlClass); ?>">
                                (<?php echo e($returnPercentage >= 0 ? '+' : ''); ?><?php echo e(number_format($returnPercentage, 2)); ?>%)
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($trade->active === 'yes'): ?>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    Active
                                </span>
                            <?php else: ?>
                                <?php
                                    $resultClass = match($trade->result_type) {
                                        'WIN' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                        'LOSE' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400'
                                    };
                                ?>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($resultClass); ?>">
                                    <?php echo e($trade->result_type ?? 'Closed'); ?>

                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div><?php echo e($trade->created_at->format('M d, Y')); ?></div>
                            <div class="text-xs"><?php echo e($trade->created_at->format('H:i')); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($trade->active === 'yes'): ?>
                                <form action="<?php echo e(route('demo.close', $trade->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 rounded-lg transition-colors"
                                            onclick="return confirm('Are you sure you want to close this trade?')">
                                        <i data-lucide="x" class="w-3 h-3 mr-1"></i>
                                        Close
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-gray-400 dark:text-gray-600 text-sm">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Enhanced Pagination -->
        <!-- Enhanced Pagination - Always show when there are trades -->
        <?php if($trades->count() > 0): ?>
        <div class="p-3 sm:p-4 lg:p-6 border-t border-gray-100 dark:border-gray-800">
            <div class="flex flex-col gap-4">
                <!-- Pagination Info -->
                <div class="text-center sm:text-left">
                    <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                        <?php if($trades->hasPages()): ?>
                            Showing <?php echo e($trades->firstItem() ?? 0); ?> to <?php echo e($trades->lastItem() ?? 0); ?>

                            of <?php echo e(number_format($trades->total())); ?> <?php echo e($trades->total() === 1 ? 'trade' : 'trades'); ?>

                        <?php else: ?>
                            Showing <?php echo e($trades->count()); ?> <?php echo e($trades->count() === 1 ? 'trade' : 'trades'); ?>

                        <?php endif; ?>
                    </div>
                    <?php if($trades->hasPages() && $trades->total() > $trades->perPage()): ?>
                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                            <?php echo e($trades->perPage()); ?> trades per page
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination Links -->
                <?php if($trades->hasPages()): ?>
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Previous/Next for Mobile -->
                    <div class="flex items-center gap-2 sm:hidden w-full">
                        <?php if($trades->onFirstPage()): ?>
                            <span class="flex-1 px-3 py-2 text-xs bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-600 rounded-lg text-center">
                                Previous
                            </span>
                        <?php else: ?>
                            <a href="<?php echo e($trades->previousPageUrl()); ?>" class="flex-1 px-3 py-2 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-center transition-colors">
                                Previous
                            </a>
                        <?php endif; ?>

                        <span class="px-3 py-2 text-xs bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-lg">
                            Page <?php echo e($trades->currentPage()); ?> of <?php echo e($trades->lastPage()); ?>

                        </span>

                        <?php if($trades->hasMorePages()): ?>
                            <a href="<?php echo e($trades->nextPageUrl()); ?>" class="flex-1 px-3 py-2 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-center transition-colors">
                                Next
                            </a>
                        <?php else: ?>
                            <span class="flex-1 px-3 py-2 text-xs bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-600 rounded-lg text-center">
                                Next
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Full Pagination for Desktop -->
                    <div class="hidden sm:flex items-center justify-center w-full">
                        <nav class="flex items-center gap-1" aria-label="Pagination">
                            <!-- Previous Button -->
                            <?php if($trades->onFirstPage()): ?>
                                <span class="px-3 py-2 text-sm bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-600 rounded-lg">
                                    Previous
                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($trades->previousPageUrl()); ?>" class="px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    Previous
                                </a>
                            <?php endif; ?>

                            <!-- Page Numbers -->
                            <?php $__currentLoopData = $trades->getUrlRange(max(1, $trades->currentPage() - 2), min($trades->lastPage(), $trades->currentPage() + 2)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $trades->currentPage()): ?>
                                    <span class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg font-medium">
                                        <?php echo e($page); ?>

                                    </span>
                                <?php else: ?>
                                    <a href="<?php echo e($url); ?>" class="px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <?php echo e($page); ?>

                                    </a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <!-- Show ellipsis if there are more pages -->
                            <?php if($trades->currentPage() < $trades->lastPage() - 3): ?>
                                <span class="px-2 py-2 text-sm text-gray-500 dark:text-gray-400">...</span>
                                <a href="<?php echo e($trades->url($trades->lastPage())); ?>" class="px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <?php echo e($trades->lastPage()); ?>

                                </a>
                            <?php endif; ?>

                            <!-- Next Button -->
                            <?php if($trades->hasMorePages()): ?>
                                <a href="<?php echo e($trades->nextPageUrl()); ?>" class="px-3 py-2 text-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    Next
                                </a>
                            <?php else: ?>
                                <span class="px-3 py-2 text-sm bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-600 rounded-lg">
                                    Next
                                </span>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Quick Page Jump (Desktop only) -->
                <?php if($trades->hasPages() && $trades->lastPage() > 5): ?>
                <div class="hidden lg:flex items-center justify-center gap-4">
                    <form method="GET" action="<?php echo e(route('demo.history')); ?>" class="flex items-center gap-2">
                        <!-- Preserve current filters -->
                        <?php $__currentLoopData = request()->except(['page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <label class="text-xs text-gray-500 dark:text-gray-400">Go to page:</label>
                        <input type="number" name="page" min="1" max="<?php echo e($trades->lastPage()); ?>"
                               value="<?php echo e($trades->currentPage()); ?>"
                               class="w-16 px-2 py-1 text-xs border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        <button type="submit" class="px-3 py-1 text-xs bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors">
                            Go
                        </button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div class="p-6 sm:p-8 lg:p-12 text-center">
            <div class="mx-auto w-12 h-12 sm:w-16 sm:h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                <i data-lucide="bar-chart-3" class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400 dark:text-gray-500"></i>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-2">No Trading History</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-sm mx-auto">You haven't placed any demo trades yet. Start trading to build your history and track your performance!</p>
            <a href="<?php echo e(route('demo.trade')); ?>" class="inline-flex items-center gap-2 px-4 py-2 sm:px-6 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors text-sm sm:text-base">
                <i data-lucide="plus" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                Place Your First Trade
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        lucide.createIcons();

        // Filter toggle functionality
        const toggleFilters = document.getElementById('toggleFilters');
        const filterSection = document.getElementById('filterSection');
        const filterToggleText = document.getElementById('filterToggleText');
        const filterToggleIcon = document.getElementById('filterToggleIcon');

        // Check if filters have values and show them initially
        const hasActiveFilters = <?php echo e(json_encode(
            request()->hasAny(['status', 'type', 'result', 'asset', 'date_from', 'date_to', 'per_page']) &&
            (request('per_page') != 20 || request()->hasAny(['status', 'type', 'result', 'asset', 'date_from', 'date_to']))
        )); ?>;

        if (hasActiveFilters) {
            filterSection.classList.remove('hidden');
            filterToggleText.textContent = 'Hide Filters';
            filterToggleIcon.style.transform = 'rotate(180deg)';
        }

        if (toggleFilters) {
            toggleFilters.addEventListener('click', function() {
                const isHidden = filterSection.classList.contains('hidden');

                if (isHidden) {
                    filterSection.classList.remove('hidden');
                    filterToggleText.textContent = 'Hide Filters';
                    filterToggleIcon.style.transform = 'rotate(180deg)';
                } else {
                    filterSection.classList.add('hidden');
                    filterToggleText.textContent = 'Show Filters';
                    filterToggleIcon.style.transform = 'rotate(0deg)';
                }
            });
        }

        // Auto-submit form when per_page changes (for better UX)
        const perPageSelect = document.querySelector('select[name="per_page"]');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                this.form.submit();
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/elitemaxpro/up.elitemaxpro.click/resources/views/user/demo/history.blade.php ENDPATH**/ ?>