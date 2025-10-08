<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<div class="container mx-auto px-4 py-8"
     x-data="tradeMonitor()"
     x-cloak>

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.notify-alert','data' => []]); ?>
<?php $component->withName('notify-alert'); ?>
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

    <!-- Header Section -->
    <div class="mb-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mb-4">
            <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-gray-900 dark:hover:text-white transition-colors">
                <i data-lucide="home" class="w-4 h-4"></i>
            </a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <a href="<?php echo e(route('trade.index')); ?>" class="hover:text-gray-900 dark:hover:text-white transition-colors">Markets</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <?php if($instrument): ?>
                <a href="<?php echo e(route('trade.single', $instrument->id)); ?>" class="hover:text-gray-900 dark:hover:text-white transition-colors"><?php echo e($instrument->symbol); ?></a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <?php endif; ?>
            <span class="text-gray-900 dark:text-white">Monitor Trade</span>
        </nav>

        <!-- Trade Header -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <!-- Trade Info -->
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <?php if($instrument && $instrument->logo): ?>
                            <img src="<?php echo e($instrument->logo); ?>" alt="<?php echo e($trade->assets); ?>" class="w-14 h-14 rounded-full object-cover">
                        <?php else: ?>
                            <span class="text-white font-bold text-lg"><?php echo e(substr($trade->assets, 0, 2)); ?></span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                            <?php echo e($trade->type); ?> <?php echo e($trade->assets); ?>

                        </h1>
                        <p class="text-gray-600 dark:text-gray-400">
                            Trade ID: #<?php echo e($trade->id); ?> • <?php echo e(\Carbon\Carbon::parse($trade->created_at)->format('M d, Y H:i')); ?>

                        </p>
                    </div>
                </div>

                <!-- Trade Status -->
                <div class="flex flex-col lg:items-end gap-2">
                    <?php if($trade->active === 'yes'): ?>
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 rounded-full">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                            <span class="font-medium">Active Trade</span>
                        </div>
                    <?php elseif($trade->active === 'expired'): ?>
                        <?php
                            // Use actual profit_earned to determine if trade was successful
                            $actualProfitEarned = $trade->profit_earned ?? 0;
                            $isSuccessful = $actualProfitEarned > 0;
                        ?>
                        <div class="inline-flex items-center gap-2 px-4 py-2 <?php echo e($isSuccessful ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400'); ?> rounded-full">
                            <div class="w-2 h-2 <?php echo e($isSuccessful ? 'bg-green-500' : 'bg-red-500'); ?> rounded-full"></div>
                            <span class="font-medium"><?php echo e($isSuccessful ? 'Profitable' : 'Loss'); ?></span>
                        </div>
                    <?php else: ?>
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-400 rounded-full">
                            <div class="w-2 h-2 bg-gray-500 rounded-full"></div>
                            <span class="font-medium">Unknown</span>
                        </div>
                    <?php endif; ?>

                    <div class="text-right">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            <?php echo e(Auth::user()->currency); ?><?php echo e(number_format($trade->amount, 2)); ?>

                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Leverage: 1:<?php echo e($trade->leverage ?? 'N/A'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Left Column - Trade Details -->
        <div class="xl:col-span-2 space-y-6">

            <!-- Real-time Progress -->
            <?php if($trade->active === 'yes' && $trade->expire_date): ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Live Progress</h3>

                    <?php
                        $start = \Carbon\Carbon::parse($trade->activated_at ?? $trade->created_at);
                        $end = \Carbon\Carbon::parse($trade->expire_date);
                        $now = \Carbon\Carbon::now();
                        $total = $start->diffInMinutes($end);
                        $elapsed = $start->diffInMinutes($now);
                        $progress = $total > 0 ? min(($elapsed / $total) * 100, 100) : 0;
                        $timeLeft = $now < $end ? $now->diffForHumans($end) : 'Expired';
                    ?>

                    <div class="space-y-4">
                        <!-- Progress Bar -->
                        <div class="relative">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                                <span>Started <?php echo e($start->diffForHumans()); ?></span>
                                <span><?php echo e($timeLeft); ?></span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-1000 relative overflow-hidden"
                                     style="width: <?php echo e($progress); ?>%">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-pulse"></div>
                                </div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <span>0%</span>
                                <span class="font-medium"><?php echo e(number_format($progress, 1)); ?>%</span>
                                <span>100%</span>
                            </div>
                        </div>

                        <!-- Live Metrics -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-4 text-center">
                                <div class="text-xs text-blue-600 dark:text-blue-400 mb-1">Duration</div>
                                <div class="font-bold text-blue-900 dark:text-blue-300"><?php echo e($trade->inv_duration ?? 'N/A'); ?></div>
                            </div>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-4 text-center">
                                <div class="text-xs text-green-600 dark:text-green-400 mb-1">Current P&L</div>
                                <?php
                                    $currentPnL = $trade->profit_earned ?? 0;
                                    $isProfit = $currentPnL >= 0;
                                ?>
                                <div class="font-bold <?php echo e($isProfit ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                                    <?php echo e($isProfit ? '+' : ''); ?><?php echo e(Auth::user()->currency); ?><?php echo e(number_format(abs($currentPnL), 2)); ?>

                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg p-4 text-center">
                                <div class="text-xs text-purple-600 dark:text-purple-400 mb-1">Return %</div>
                                <?php
                                    $returnPercentage = $trade->amount > 0 ? ($currentPnL / $trade->amount) * 100 : 0;
                                ?>
                                <div class="font-bold <?php echo e($isProfit ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                                    <?php echo e($isProfit ? '+' : ''); ?><?php echo e(number_format($returnPercentage, 2)); ?>%
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-lg p-4 text-center">
                                <div class="text-xs text-yellow-600 dark:text-yellow-400 mb-1">Time Left</div>
                                <div class="font-bold text-yellow-900 dark:text-yellow-300" x-text="timeLeft" x-data="{ timeLeft: '<?php echo e($timeLeft); ?>' }"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Trade Details -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Trade Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Asset</span>
                            <span class="font-medium text-gray-900 dark:text-white"><?php echo e($trade->assets); ?></span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Trade Type</span>
                            <span class="font-medium <?php echo e($trade->type === 'Buy' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                                <?php echo e($trade->type); ?>

                            </span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Investment Amount</span>
                            <span class="font-medium text-gray-900 dark:text-white"><?php echo e(Auth::user()->currency); ?><?php echo e(number_format($trade->amount, 2)); ?></span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Leverage</span>
                            <span class="font-medium text-gray-900 dark:text-white">1:<?php echo e($trade->leverage ?? 'N/A'); ?></span>
                        </div>
                        <?php if($trade->active === 'expired'): ?>
                            <?php
                                $finalPnL = $trade->profit_earned ?? 0;
                                $finalIsProfit = $finalPnL >= 0;
                            ?>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-400">Final P&L</span>
                                <span class="font-medium <?php echo e($finalIsProfit ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                                    <?php echo e($finalIsProfit ? '+' : ''); ?><?php echo e(Auth::user()->currency); ?><?php echo e(number_format(abs($finalPnL), 2)); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Timeline Info -->
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Created</span>
                            <span class="font-medium text-gray-900 dark:text-white"><?php echo e(\Carbon\Carbon::parse($trade->created_at)->format('M d, Y H:i')); ?></span>
                        </div>
                        <?php if($trade->activated_at): ?>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-400">Activated</span>
                                <span class="font-medium text-gray-900 dark:text-white"><?php echo e(\Carbon\Carbon::parse($trade->activated_at)->format('M d, Y H:i')); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Duration</span>
                            <span class="font-medium text-gray-900 dark:text-white"><?php echo e($trade->inv_duration ?? 'N/A'); ?></span>
                        </div>
                        <?php if($trade->expire_date): ?>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-gray-600 dark:text-gray-400"><?php echo e($trade->active === 'yes' ? 'Expires' : 'Expired'); ?></span>
                                <span class="font-medium <?php echo e($trade->active === 'yes' ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-900 dark:text-white'); ?>">
                                    <?php echo e(\Carbon\Carbon::parse($trade->expire_date)->format('M d, Y H:i')); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Current Market Data -->
            <?php if($instrument): ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Current Market Data</h3>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">Current Price</div>
                            <div class="font-bold text-gray-900 dark:text-white">
                                $<?php echo e(number_format($instrument->price, $instrument->price >= 1 ? 2 : 6)); ?>

                            </div>
                        </div>

                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">24h Change</div>
                            <div class="font-bold <?php echo e($instrument->percent_change_24h >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                                <?php echo e($instrument->percent_change_24h >= 0 ? '+' : ''); ?><?php echo e(number_format($instrument->percent_change_24h, 2)); ?>%
                            </div>
                        </div>

                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">24h High</div>
                            <div class="font-bold text-gray-900 dark:text-white">
                                $<?php echo e(number_format($instrument->high ?? 0, $instrument->price >= 1 ? 2 : 6)); ?>

                            </div>
                        </div>

                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">24h Low</div>
                            <div class="font-bold text-gray-900 dark:text-white">
                                $<?php echo e(number_format($instrument->low ?? 0, $instrument->price >= 1 ? 2 : 6)); ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Related Trades -->
            <?php if($relatedTrades->count() > 0): ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Recent Trades (<?php echo e($trade->assets); ?>)</h3>

                    <div class="space-y-3">
                        <?php $__currentLoopData = $relatedTrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedTrade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full <?php echo e($relatedTrade->type === 'Buy' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30'); ?> flex items-center justify-center">
                                        <?php if($relatedTrade->type === 'Buy'): ?>
                                            <i data-lucide="trending-up" class="w-4 h-4 text-green-600 dark:text-green-400"></i>
                                        <?php else: ?>
                                            <i data-lucide="trending-down" class="w-4 h-4 text-red-600 dark:text-red-400"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white"><?php echo e($relatedTrade->type); ?> <?php echo e($relatedTrade->assets); ?></div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400"><?php echo e(\Carbon\Carbon::parse($relatedTrade->created_at)->format('M d, H:i')); ?></div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-gray-900 dark:text-white"><?php echo e(Auth::user()->currency); ?><?php echo e(number_format($relatedTrade->amount, 2)); ?></div>
                                    <div class="text-xs <?php echo e($relatedTrade->active === 'yes' ? 'text-yellow-600 dark:text-yellow-400' : ($relatedTrade->active === 'expired' ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400')); ?>">
                                        <?php echo e($relatedTrade->active === 'yes' ? 'Active' : ($relatedTrade->active === 'expired' ? 'Completed' : 'Unknown')); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Column - Statistics & Actions -->
        <div class="xl:col-span-1 space-y-6">

            <!-- Trading Statistics -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Trading Stats (<?php echo e($trade->assets); ?>)</h3>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Total Trades</span>
                        <span class="font-bold text-gray-900 dark:text-white"><?php echo e($stats->total_trades ?? 0); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Active Trades</span>
                        <span class="font-bold text-yellow-600 dark:text-yellow-400"><?php echo e($stats->active_trades ?? 0); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Completed</span>
                        <span class="font-bold text-green-600 dark:text-green-400"><?php echo e($stats->completed_trades ?? 0); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Total Invested</span>
                        <span class="font-bold text-gray-900 dark:text-white"><?php echo e(Auth::user()->currency); ?><?php echo e(number_format($stats->total_invested ?? 0, 2)); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Avg Trade Size</span>
                        <span class="font-bold text-gray-900 dark:text-white"><?php echo e(Auth::user()->currency); ?><?php echo e(number_format($stats->avg_trade_size ?? 0, 2)); ?></span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Quick Actions</h3>

                <div class="space-y-3">
                    <?php if($instrument): ?>
                        <a href="<?php echo e(route('trade.single', $instrument->id)); ?>"
                           class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            <i data-lucide="trending-up" class="w-4 h-4"></i>
                            Trade <?php echo e($trade->assets); ?> Again
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo e(route('trade.index')); ?>"
                       class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        Browse Markets
                    </a>

                    <a href="<?php echo e(route('tradinghistory')); ?>"
                       class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                        <i data-lucide="history" class="w-4 h-4"></i>
                        All My Trades
                    </a>
                </div>
            </div>

            <!-- Risk Information -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl border border-yellow-200 dark:border-yellow-800 p-6">
                <div class="flex items-start gap-3">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 flex-shrink-0"></i>
                    <div>
                        <h4 class="font-medium text-yellow-800 dark:text-yellow-300 mb-2">Risk Disclaimer</h4>
                        <p class="text-sm text-yellow-700 dark:text-yellow-400 leading-relaxed">
                            Trading involves substantial risk and may result in loss of funds.
                            Past performance is not indicative of future results.
                            Please ensure you understand the risks involved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function tradeMonitor() {
    return {
        isActive: <?php echo json_encode($trade->active === 'yes', 15, 512) ?>,
        tradeData: <?php echo json_encode($trade, 15, 512) ?>,

        init() {
            // Update time left every minute if trade is active
            if (this.isActive) {
                setInterval(() => {
                    this.updateTimeLeft();
                }, 60000); // Update every minute
            }

            // Initialize Lucide icons
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        },

        updateTimeLeft() {
            if (!this.tradeData.expire_date) return;

            const now = new Date();
            const expireDate = new Date(this.tradeData.expire_date);
            const diffMs = expireDate - now;

            if (diffMs <= 0) {
                this.$refs.timeLeft.textContent = 'Expired';
                this.isActive = false;
                return;
            }

            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMins / 60);
            const diffDays = Math.floor(diffHours / 24);

            let timeLeft = '';
            if (diffDays > 0) {
                timeLeft = `${diffDays}d ${diffHours % 24}h`;
            } else if (diffHours > 0) {
                timeLeft = `${diffHours}h ${diffMins % 60}m`;
            } else {
                timeLeft = `${diffMins}m`;
            }

            if (this.$refs.timeLeft) {
                this.$refs.timeLeft.textContent = timeLeft;
            }
        }
    }
}

// Re-initialize icons after Alpine updates
document.addEventListener('alpine:updated', () => {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\algo\resources\views/user/trade/monitor.blade.php ENDPATH**/ ?>