<?php $__env->startSection('title', 'Demo Trading Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<!-- Simple Header -->
<div class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800" x-cloak>
    <div class="px-4 py-6 sm:py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="text-center lg:text-left">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    Demo Trading Dashboard
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Practice trading with virtual money - Risk Free!
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <a href="<?php echo e(route('demo.trade')); ?>" class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition-colors text-sm sm:text-base">
                    <i data-lucide="plus" class="w-4 h-4 sm:w-5 sm:h-5"></i> Start Demo Trade
                </a>
                <a href="<?php echo e(route('demo.history')); ?>" class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow transition-colors text-sm sm:text-base">
                    <i data-lucide="history" class="w-4 h-4 sm:w-5 sm:h-5"></i> View History
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

    <!-- Demo Balance Card -->
    <div class="mb-6 sm:mb-8">
        <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 rounded-2xl p-6 sm:p-8 shadow-lg ring-1 ring-blue-400/20 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
            <div class="relative">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="text-center lg:text-left">
                        <div class="flex items-center justify-center lg:justify-start gap-2 mb-2">
                            <div class="w-3 h-3 rounded-full bg-green-400 animate-pulse"></div>
                            <span class="text-blue-100 text-sm font-medium">DEMO MODE ACTIVE</span>
                        </div>
                        <div class="text-4xl sm:text-5xl font-bold text-white mb-2">
                            $<?php echo e(number_format(auth()->user()->demo_balance, 2)); ?>

                        </div>
                        <p class="text-blue-100">Virtual Trading Balance</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="<?php echo e(route('trade.index')); ?>" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-lg font-medium transition-all border border-white/20">
                            <i data-lucide="trending-up" class="w-5 h-5"></i> Switch to Live Trading
                        </a>
                        <form action="<?php echo e(route('demo.reset')); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reset your demo account? This will close all active trades and reset your balance to $100,000.')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-orange-500/20 hover:bg-orange-500/30 backdrop-blur-sm text-white rounded-lg font-medium transition-all border border-orange-400/20">
                                <i data-lucide="refresh-cw" class="w-5 h-5"></i> Reset Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($totalTrades); ?></h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total Trades</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <i data-lucide="trending-up" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($winRate); ?>%</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Win Rate</p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <i data-lucide="target" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold <?php echo e($totalProfit >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                        $<?php echo e(number_format($totalProfit, 2)); ?>

                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total P&L</p>
                </div>
                <div class="p-3 bg-<?php echo e($totalProfit >= 0 ? 'green' : 'red'); ?>-100 dark:bg-<?php echo e($totalProfit >= 0 ? 'green' : 'red'); ?>-900/30 rounded-lg">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-<?php echo e($totalProfit >= 0 ? 'green' : 'red'); ?>-600 dark:text-<?php echo e($totalProfit >= 0 ? 'green' : 'red'); ?>-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($activeTrades->count()); ?></h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Active Trades</p>
                </div>
                <div class="p-3 bg-orange-100 dark:bg-orange-900/30 rounded-lg">
                    <i data-lucide="activity" class="w-6 h-6 text-orange-600 dark:text-orange-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-6 sm:mb-8">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <a href="<?php echo e(route('demo.trade')); ?>" class="flex items-center justify-center gap-3 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    <span>Start Demo Trade</span>
                </a>

                <a href="<?php echo e(route('demo.history')); ?>" class="flex items-center justify-center gap-3 px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                    <i data-lucide="history" class="w-5 h-5"></i>
                    <span>View History</span>
                </a>

                <a href="<?php echo e(route('trade.index')); ?>" class="flex items-center justify-center gap-3 px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                    <span>Live Trading</span>
                </a>

                <form action="<?php echo e(route('demo.reset')); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reset your demo account? This will close all active trades and reset your balance to $100,000.')">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                        <span>Reset Account</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Active Trades -->
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Active Demo Trades</h3>
                <?php if($activeTrades->count() > 0): ?>
                    <span class="inline-flex items-center px-3 py-1 text-sm bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full">
                        <?php echo e($activeTrades->count()); ?> Active
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="overflow-x-auto">
            <?php if($activeTrades->count() > 0): ?>
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Asset</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Leverage</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Current P&L</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Expires</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <?php $__currentLoopData = $activeTrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($trade->assets); ?></div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($trade->type === 'Buy' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'); ?>">
                                        <?php echo e($trade->type); ?>

                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    $<?php echo e(number_format($trade->amount, 2)); ?>

                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <?php echo e($trade->leverage); ?>x
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <?php
                                        $pnl = $trade->calculatePnL();
                                    ?>
                                    <span class="text-sm font-semibold <?php echo e($pnl >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                                        <?php echo e($pnl >= 0 ? '+' : ''); ?>$<?php echo e(number_format($pnl, 2)); ?>

                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden sm:table-cell">
                                    <?php echo e($trade->expire_date ? $trade->expire_date->diffForHumans() : 'N/A'); ?>

                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <form action="<?php echo e(route('demo.close', $trade->id)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 rounded-lg transition-colors">
                                            <i data-lucide="x" class="w-3 h-3 mr-1"></i>
                                            Close
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="p-8 sm:p-12 text-center">
                    <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="trending-up" class="w-8 h-8 text-gray-400 dark:text-gray-500"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Active Demo Trades</h4>
                    <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-sm mx-auto">Start your first demo trade to practice trading without any financial risk.</p>
                    <a href="<?php echo e(route('demo.trade')); ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Start Demo Trading
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\algo\resources\views/user/demo/dashboard.blade.php ENDPATH**/ ?>