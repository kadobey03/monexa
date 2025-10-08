<?php $__env->startSection('title', 'Demo Trading'); ?>
<?php $__env->startSection('content'); ?>

<!-- Simple Header -->
<div class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800" x-cloak>
    <div class="px-4 py-6 sm:py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="text-center lg:text-left">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    Demo Trading
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Practice trading with virtual money - Risk Free!
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <div class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg text-sm sm:text-base">
                    <i data-lucide="wallet" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    Demo Balance: $<?php echo e(number_format(auth()->user()->demo_balance, 2)); ?>

                </div>
                <a href="<?php echo e(route('demo.dashboard')); ?>" class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow transition-colors text-sm sm:text-base">
                    <i data-lucide="arrow-left" class="w-4 h-4 sm:w-5 sm:h-5"></i> Back to Dashboard
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

    <!-- Main Grid Layout -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Trading Form Card -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Place Demo Trade
                        </h2>
                        <div class="flex items-center gap-2 px-3 py-1 bg-blue-50 dark:bg-blue-900/20 rounded-full">
                            <i data-lucide="shield-check" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                            <span class="text-sm text-blue-600 dark:text-blue-400">Virtual Money</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Select an asset and configure your virtual trade
                    </p>
                </div>

                <form action="<?php echo e(route('demo.execute')); ?>" method="POST" id="demoTradeForm" class="p-4 sm:p-6 space-y-6">
                    <?php echo csrf_field(); ?>

                    <!-- Asset Selection -->
                    <div class="space-y-2">
                        <label for="asset" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Select Asset <span class="text-red-500">*</span>
                        </label>
                        <select name="asset" id="asset" required
                                class="block w-full px-3 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                                       rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Choose an asset to trade...</option>
                            <?php $__currentLoopData = $instruments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instrument): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($instrument->symbol); ?>"
                                        data-name="<?php echo e($instrument->name); ?>"
                                        data-type="<?php echo e($instrument->type); ?>"
                                        data-price="<?php echo e($instrument->price); ?>">
                                    <?php echo e($instrument->symbol); ?> - <?php echo e($instrument->name); ?>

                                    <?php if($instrument->price): ?>
                                        ($<?php echo e(number_format($instrument->price, 2)); ?>)
                                    <?php endif; ?>
                                    [<?php echo e(ucfirst($instrument->type)); ?>]
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Trade Type and Amount Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Trade Type -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Trade Direction <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative flex items-center justify-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-green-300 dark:hover:border-green-600 transition-colors">
                                    <input type="radio" name="order_type" value="Buy" class="sr-only peer" required>
                                    <div class="text-center peer-checked:text-green-600 dark:peer-checked:text-green-400">
                                        <div class="w-8 h-8 mx-auto mb-2 flex items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30 peer-checked:bg-green-200 dark:peer-checked:bg-green-800/50">
                                            <i data-lucide="trending-up" class="w-4 h-4 text-green-600 dark:text-green-400"></i>
                                        </div>
                                        <span class="text-sm font-medium">BUY</span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Price goes up</p>
                                    </div>
                                    <div class="absolute inset-0 border-2 border-transparent peer-checked:border-green-500 rounded-lg"></div>
                                </label>

                                <label class="relative flex items-center justify-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-red-300 dark:hover:border-red-600 transition-colors">
                                    <input type="radio" name="order_type" value="Sell" class="sr-only peer" required>
                                    <div class="text-center peer-checked:text-red-600 dark:peer-checked:text-red-400">
                                        <div class="w-8 h-8 mx-auto mb-2 flex items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30 peer-checked:bg-red-200 dark:peer-checked:bg-red-800/50">
                                            <i data-lucide="trending-down" class="w-4 h-4 text-red-600 dark:text-red-400"></i>
                                        </div>
                                        <span class="text-sm font-medium">SELL</span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Price goes down</p>
                                    </div>
                                    <div class="absolute inset-0 border-2 border-transparent peer-checked:border-red-500 rounded-lg"></div>
                                </label>
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="space-y-2">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Investment Amount <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 dark:text-gray-400">$</span>
                                </div>
                                <input type="number" name="amount" id="amount" required
                                       min="1" step="0.01" max="<?php echo e(auth()->user()->demo_balance); ?>"
                                       placeholder="0.00"
                                       class="block w-full pl-8 pr-3 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                                              rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Max: $<?php echo e(number_format(auth()->user()->demo_balance, 2)); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Leverage and Duration Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Leverage -->
                        <div class="space-y-2">
                            <label for="leverage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Leverage <span class="text-red-500">*</span>
                            </label>
                            <select name="leverage" id="leverage" required
                                    class="block w-full px-3 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                                           rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="1">1x (No Leverage)</option>
                                <option value="2">2x</option>
                                <option value="5">5x</option>
                                <option value="10">10x</option>
                                <option value="20">20x</option>
                                <option value="50">50x</option>
                                <option value="100">100x (High Risk)</option>
                            </select>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Higher leverage = Higher potential profit/loss
                            </p>
                        </div>

                        <!-- Expiration -->
                        <div class="space-y-2">
                            <label for="expire" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Trade Duration <span class="text-red-500">*</span>
                            </label>
                            <select name="expire" id="expire" required
                                    class="block w-full px-3 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                                           rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="5 minutes">5 Minutes</option>
                                <option value="15 minutes">15 Minutes</option>
                                <option value="30 minutes">30 Minutes</option>
                                <option value="1 hour">1 Hour</option>
                                <option value="4 hours">4 Hours</option>
                                <option value="1 day">1 Day</option>
                                <option value="1 week">1 Week</option>
                            </select>
                        </div>
                    </div>

                    <!-- Trade Summary -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Trade Summary</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Asset:</span>
                                <span id="summary-asset" class="font-medium text-gray-900 dark:text-white ml-2">-</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Amount:</span>
                                <span id="summary-amount" class="font-medium text-gray-900 dark:text-white ml-2">$0.00</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Leverage:</span>
                                <span id="summary-leverage" class="font-medium text-gray-900 dark:text-white ml-2">1x</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Max Risk:</span>
                                <span id="summary-risk" class="font-medium text-red-600 dark:text-red-400 ml-2">$0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="play" class="w-5 h-5"></i>
                            Execute Demo Trade
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="space-y-6">
            <!-- Demo Trading Tips Card -->
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Trading Tips</h3>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Risk Management</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Never risk more than you can afford to lose, even in demo trading.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full mt-2 flex-shrink-0"></div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Start Small</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Begin with smaller amounts and lower leverage to learn the basics.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2 flex-shrink-0"></div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Leverage Caution</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Higher leverage amplifies both profits and losses significantly.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 flex-shrink-0"></div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Practice Makes Perfect</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Use demo trading to test strategies before going live.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Demo Account Info Card -->
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Demo Account</h3>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Available Balance</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">$<?php echo e(number_format(auth()->user()->demo_balance, 2)); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Currency</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">USD</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Trading Mode</span>
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full">
                                Demo
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <form action="<?php echo e(route('demo.reset')); ?>" method="POST" onsubmit="return confirm('Reset demo account to $100,000?')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2.5 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                Reset Demo Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        lucide.createIcons();

        // Form elements
        const assetSelect = document.getElementById('asset');
        const amountInput = document.getElementById('amount');
        const leverageSelect = document.getElementById('leverage');
        const orderTypeInputs = document.querySelectorAll('input[name="order_type"]');

        // Summary elements
        const summaryAsset = document.getElementById('summary-asset');
        const summaryAmount = document.getElementById('summary-amount');
        const summaryLeverage = document.getElementById('summary-leverage');
        const summaryRisk = document.getElementById('summary-risk');

        function updateSummary() {
            // Update asset
            const selectedAsset = assetSelect.options[assetSelect.selectedIndex];
            summaryAsset.textContent = selectedAsset.value ? selectedAsset.dataset.name : '-';

            // Update amount
            const amount = parseFloat(amountInput.value) || 0;
            summaryAmount.textContent = '$' + amount.toFixed(2);

            // Update leverage
            const leverage = leverageSelect.value;
            summaryLeverage.textContent = leverage + 'x';

            // Calculate max risk (for demo, it's the amount invested)
            summaryRisk.textContent = '$' + amount.toFixed(2);
        }

        // Add event listeners
        assetSelect.addEventListener('change', updateSummary);
        amountInput.addEventListener('input', updateSummary);
        leverageSelect.addEventListener('change', updateSummary);

        // Add change listeners to order type radio buttons
        orderTypeInputs.forEach(input => {
            input.addEventListener('change', updateSummary);
        });

        // Initial update
        updateSummary();

        // Form validation
        document.getElementById('demoTradeForm').addEventListener('submit', function(e) {
            const amount = parseFloat(amountInput.value);
            const maxBalance = <?php echo e(auth()->user()->demo_balance); ?>;

            if (amount > maxBalance) {
                e.preventDefault();
                alert('Amount exceeds your demo balance of $' + maxBalance.toFixed(2));
                return;
            }

            if (amount < 1) {
                e.preventDefault();
                alert('Minimum trade amount is $1.00');
                return;
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/elitemaxpro/up.elitemaxpro.click/resources/views/user/demo/trade.blade.php ENDPATH**/ ?>