<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6 lg:py-8" x-data="{ showCopied: false }">

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

    <!-- Dashboard Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6 sm:mb-8 gap-4">
        <div class="text-center lg:text-left">
           <?php
    $userCreatedAt = \Carbon\Carbon::parse(Auth::user()->created_at);
    $secondsSinceCreated = now()->diffInSeconds($userCreatedAt);
?>

<?php if($secondsSinceCreated <= 90): ?>
    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
        Welcome, <?php echo e(Auth::user()->name); ?>!
    </h1>
<?php else: ?>
    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
        Welcome back, <?php echo e(Auth::user()->name); ?>!
    </h1>
<?php endif; ?>

            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mt-1">Your investment dashboard overview</p>
        </div>
        <div class="hidden sm:flex flex-col sm:flex-row gap-2 sm:gap-3">
            <?php if($settings->wallet_status == "on"): ?>
                <a href="<?php echo e(route('connect_wallet')); ?>" class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-lg shadow hover:from-indigo-700 transition animate-pulse text-sm sm:text-base">
                    <i data-lucide="link" class="w-4 h-4 sm:w-5 sm:h-5"></i> Connect Wallet
                </a>
            <?php else: ?>
                <div class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg text-sm sm:text-base">
                    <i data-lucide="check-circle" class="w-4 h-4 sm:w-5 sm:h-5"></i> Wallet Connected
                </div>
            <?php endif; ?>
            <a href="<?php echo e(route('mplans')); ?>" class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition text-sm sm:text-base">
                <i data-lucide="trending-up" class="w-4 h-4 sm:w-5 sm:h-5"></i> Invest Now
            </a>
        </div>
    </div>




    <!-- Signal Strength -->
    <?php if(Auth::user()->progress > 2): ?>
    <div class="mb-6 sm:mb-8">
        <?php
            $signalStrength = Auth::user()->progress;
            $signalColor = '';
            $signalText = '';
            $signalIcon = '';

            if ($signalStrength < 25) {
                $signalColor = 'from-red-500 to-red-600';
                $signalText = 'Weak Signal';
                $signalIcon = 'signal-low';
            } elseif ($signalStrength >= 25 && $signalStrength < 50) {
                $signalColor = 'from-yellow-500 to-orange-500';
                $signalText = 'Moderate Signal';
                $signalIcon = 'signal-medium';
            } else {
                $signalColor = 'from-green-500 to-emerald-600';
                $signalText = 'Strong Signal';
                $signalIcon = 'signal-high';
            }
        ?>

        <div class="bg-white dark:bg-gray-900 rounded-xl p-4 sm:p-6 shadow-sm ring-1 ring-gray-200 dark:ring-gray-800">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="<?php echo e($signalIcon); ?>" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i>
                    <h2 class="text-sm sm:text-base font-semibold text-gray-800 dark:text-gray-100">Trading Signal Strength</h2>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white"><?php echo e($signalStrength); ?>%</span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full
                        <?php echo e($signalStrength < 25 ? 'bg-red-100 text-red-700 dark:bg-red-900/20 dark:text-red-400' :
                           ($signalStrength < 50 ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-400' :
                            'bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400')); ?>">
                        <?php echo e($signalText); ?>

                    </span>
                </div>
            </div>

            <div class="w-full h-3 sm:h-4 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden relative">
                <div class="bg-gradient-to-r <?php echo e($signalColor); ?> h-full rounded-full transition-all duration-700 ease-out relative"
                     style="width: <?php echo e($signalStrength); ?>%">
                    <div class="absolute inset-0 bg-white/20 animate-pulse rounded-full"></div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-2 text-xs text-gray-500 dark:text-gray-400">
                <span>0% Weak</span>
                <span>25% Moderate</span>
                <span>50%+ Strong</span>
            </div>

            <p class="text-xs text-gray-600 dark:text-gray-400 mt-3 text-center">
                <?php if($signalStrength < 25): ?>
                    ⚠️ Signal strength is low. Consider waiting for better market conditions.
                <?php elseif($signalStrength < 50): ?>
                    ⚡ Moderate signal detected. Proceed with caution and proper risk management.
                <?php else: ?>
                    🚀 Strong signal strength! Optimal conditions for trading opportunities.
                <?php endif; ?>
            </p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Demo Trading Promotion Banner -->
    <?php if(Auth::user()->demo_balance <= 0): ?>
    <div class="bg-gradient-to-r from-green-500 via-green-600 to-green-700 rounded-xl p-4 sm:p-6 mb-6 sm:mb-8 shadow-lg ring-1 ring-green-400/20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        <div class="relative">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i data-lucide="graduation-cap" class="w-6 h-6 sm:w-8 sm:h-8 text-white"></i>
                    </div>
                    <div class="text-center sm:text-left">
                        <h3 class="text-lg sm:text-xl font-bold text-white mb-1">Start Demo Trading!</h3>
                        <p class="text-sm sm:text-base text-green-100">Practice with $100,000 virtual money - Risk-free learning!</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <a href="<?php echo e(route('demo.dashboard')); ?>" class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-white text-green-600 rounded-lg shadow hover:bg-green-50 transition-all duration-300 font-medium text-sm sm:text-base min-w-[120px] group">
                        <i data-lucide="play" class="w-4 h-4 group-hover:scale-110 transition-transform duration-300"></i>
                        Start Demo
                    </a>
                    <a href="<?php echo e(route('mplans')); ?>" class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-green-800/50 text-white rounded-lg shadow hover:bg-green-800/70 transition-all duration-300 font-medium text-sm sm:text-base min-w-[120px] backdrop-blur-sm">
                        <i data-lucide="trending-up" class="w-4 h-4"></i>
                        Go Live
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 rounded-xl p-4 sm:p-6 mb-6 sm:mb-8 shadow-lg ring-1 ring-blue-400/20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        <div class="relative">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i data-lucide="graduation-cap" class="w-6 h-6 sm:w-8 sm:h-8 text-white"></i>
                    </div>
                    <div class="text-center sm:text-left">
                        <h3 class="text-lg sm:text-xl font-bold text-white mb-1">Demo Account Active</h3>
                        <p class="text-sm sm:text-base text-blue-100">Demo Balance: <?php echo e(Auth::user()->currency); ?><?php echo e(number_format(Auth::user()->demo_balance, 2, '.', ',')); ?></p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <a href="<?php echo e(route('demo.dashboard')); ?>" class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-white text-blue-600 rounded-lg shadow hover:bg-blue-50 transition-all duration-300 font-medium text-sm sm:text-base min-w-[120px] group">
                        <i data-lucide="play" class="w-4 h-4 group-hover:scale-110 transition-transform duration-300"></i>
                        Switch to Demo Trading
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>


 <!-- Investment Dashboard - Clean Modern Layout -->
<div class="grid grid-cols-1 xl:grid-cols-5 gap-4 sm:gap-6 items-stretch mb-6 sm:mb-8">
    <!-- Account Balance -->
    <div class="xl:col-span-2 h-full rounded-2xl bg-white dark:bg-gray-900 p-4 sm:p-5 lg:p-6 shadow-sm ring-1 ring-gray-200 dark:ring-gray-800 transition-all group" id="balanceCard">
        <div class="flex justify-between items-start mb-4">
            <div class="text-center sm:text-left w-full sm:w-auto">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-white flex items-center justify-center sm:justify-start">
                    <i data-lucide="wallet" class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-gray-500 dark:text-gray-300"></i>
                    Account Balance
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Your available funds</p>
            </div>
            
        </div>

        <div class="flex flex-col">
            <div class="flex items-center justify-center sm:justify-start mb-3">
                <h3 id="balanceAmount" class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mr-2 break-all">
                    <?php echo e(Auth::user()->currency); ?><?php echo e(number_format(Auth::user()->account_bal, 2, '.', ',')); ?>

                </h3>
                <h3 id="hiddenBalance" class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mr-2 hidden">••••••</h3>
            </div>




              <?php if(isset($bitcoin_price) && $bitcoin_price && $btc_equivalent > 0): ?>
            <!-- Bitcoin Equivalent -->
            <div class="flex items-center justify-center sm:justify-start mb-2">
                <div class="inline-flex items-center px-3 py-1 text-sm rounded-lg bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-800">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.638 14.904c-1.602 6.43-8.113 10.34-14.542 8.736C2.67 22.05-1.244 15.525.362 9.105 1.962 2.67 8.475-1.243 14.9.358c6.43 1.605 10.342 8.115 8.738 14.546z"/>
                        <path fill="#fff" d="M17.455 11.252c.234-1.569-.963-2.413-2.601-2.977l.531-2.131-1.297-.323-.518 2.075c-.341-.085-.691-.165-1.039-.243l.522-2.092-1.297-.324-.531 2.13c-.283-.065-.56-.128-.829-.196l.002-.007-1.788-.446-.345 1.385s.963.22.943.234c.525.131.62.478.605.753l-.606 2.43c.036.009.083.022.135.042l-.137-.034-.849 3.4c-.064.159-.227.398-.594.307.013.019-.944-.235-.944-.235l-.643 1.485 1.688.421c.314.078.621.16.923.238l-.536 2.153 1.297.323.531-2.131c.355.096.699.185 1.035.269l-.53 2.121 1.297.323.536-2.15c2.211.419 3.873.25 4.573-1.75.564-1.61-.028-2.538-1.191-3.144.847-.195 1.485-.752 1.656-1.902zm-2.961 4.15c-.401 1.61-3.11.74-3.99.521l.713-2.854c.879.219 3.695.653 3.277 2.333zm.401-4.176c-.365 1.464-2.621.72-3.353.538l.645-2.587c.732.183 3.089.524 2.708 2.049z"/>
                    </svg>
                    <span class="font-medium"><?php echo e(number_format($btc_equivalent, 6, '.', ',')); ?> BTC</span>
                    <!--<?php if($bitcoin_price->price): ?>-->
                    <!--    <span class="text-xs ml-1 opacity-75">(₿<?php echo e(number_format($bitcoin_price->price, 2, '.', ',')); ?>)</span>-->
                    <!--<?php endif; ?>-->
                </div>
            </div>
            <?php endif; ?>

            <div class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 mb-4 w-fit mx-auto sm:mx-0">
                <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i> Available for Withdrawal
            </div>

            <?php if(isset($settings->enable_kyc) && $settings->enable_kyc === 'yes'): ?>
                <!-- KYC Status Notification -->
                <div class="mb-3 w-fit mx-auto sm:mx-0">
                    <?php if(Auth::user()->account_verify === 'Verified'): ?>
                        <div class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 animate-pulse">
                            <i data-lucide="shield-check" class="w-3 h-3 mr-1"></i>
                            <span class="font-medium">Verified Account</span>
                        </div>
                    <?php elseif(Auth::user()->account_verify === 'Under review'): ?>
                        <div class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 animate-pulse">
                            <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                            <span class="font-medium">Under Review</span>
                        </div>
                    <?php else: ?>
                        <div class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 animate-pulse">
                            <i data-lucide="alert-circle" class="w-3 h-3 mr-1"></i>
                            <span class="font-medium">Unverified</span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 text-center sm:text-left">Last updated: <?php echo e(now()->format('M d, Y h:i A')); ?></p>

            <div class="mt-auto flex flex-col sm:flex-row gap-2">
                <a href="<?php echo e(route('deposits')); ?>" class="flex items-center justify-center w-full gap-1 text-xs sm:text-sm font-medium px-3 sm:px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-900 dark:text-white transition">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Deposit
                </a>
                <a href="<?php echo e(route('withdrawalsdeposits')); ?>" class="flex items-center justify-center w-full gap-1 text-xs sm:text-sm font-medium px-3 sm:px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-900 dark:text-white transition">
                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i> Withdraw
                </a>
            </div>
        </div>
    </div>

    <!-- Secondary Metrics -->
    <div class="xl:col-span-3 grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-2 gap-3 sm:gap-4">
        <?php
            $cards = [
                ['label' => 'Total Profit', 'value' => Auth::user()->roi, 'icon' => 'dollar-sign'],
                ['label' => 'Total Deposit', 'value' => $deposited, 'icon' => 'arrow-down'],
                ['label' => 'Total Withdrawal', 'value' => $total_withdrawal, 'icon' => 'arrow-up'],
                ['label' => 'Bonus', 'value' => Auth::user()->bonus ?? 0, 'icon' => 'gift'],
            ];
        ?>

        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded-2xl bg-white dark:bg-gray-900 p-3 sm:p-4 shadow-sm ring-1 ring-gray-200 dark:ring-gray-800 flex flex-col">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400"><?php echo e($card['label']); ?></span>
                    <div class="w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                        <i data-lucide="<?php echo e($card['icon']); ?>" class="w-3 h-3 sm:w-4 sm:h-4 text-gray-500 dark:text-gray-300"></i>
                    </div>
                </div>

                <h3 class="text-sm sm:text-lg font-semibold text-gray-900 dark:text-white mb-1 truncate">
                    <?php echo e(Auth::user()->currency); ?><?php echo e(number_format($card['value'], 2, '.', ',')); ?>

                </h3>

                <div class="text-xs text-gray-500 dark:text-gray-400 mt-auto flex items-center gap-1">
                    <i data-lucide="calendar" class="w-3 h-3"></i>
                    <span><?php echo e($card['label'] === 'Total Profit' ? 'Last period' : 'All time'); ?></span>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>




    <?php if(isset($settings->enable_kyc) && $settings->enable_kyc === 'yes'): ?>
        <!-- KYC Verification Component -->
        <div class="mb-6 sm:mb-8" x-data="{ kycDropdownOpen: false }" x-cloak>
            <?php if(Auth::user()->account_verify === 'Verified'): ?>
                <!-- Verified Status -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 p-4 sm:p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400"></i>
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white mb-1">
                                Account Verified
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                Your identity has been verified. All features are now available.
                            </p>
                        </div>
                        <div class="px-3 py-1 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-full text-xs font-medium">
                            Verified
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- KYC Verification Needed -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 shadow-sm">
                    <!-- Header -->
                    <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                    <i data-lucide="shield-check" class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white mb-1">
                                        Identity Verification
                                    </h3>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                        Complete verification to access all features
                                    </p>
                                </div>
                            </div>

                            <!-- Toggle Button -->
                            <button @click="kycDropdownOpen = !kycDropdownOpen"
                                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                <span class="flex items-center justify-center gap-2">
                                    <span>View Details</span>
                                    <i data-lucide="chevron-down"
                                       :class="kycDropdownOpen ? 'rotate-180' : 'rotate-0'"
                                       class="w-4 h-4 transition-transform"></i>
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Dropdown Content -->
                    <div x-show="kycDropdownOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         class="p-4 sm:p-6 border-t border-gray-100 dark:border-gray-800">

                        <?php if(Auth::user()->account_verify === 'Under review'): ?>
                            <!-- Under Review State -->
                            <div class="text-center space-y-4">
                                <div class="w-16 h-16 mx-auto bg-yellow-50 dark:bg-yellow-900/20 rounded-full flex items-center justify-center">
                                    <i data-lucide="clock" class="w-8 h-8 text-yellow-600 dark:text-yellow-400"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                        Under Review
                                    </h4>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm max-w-md mx-auto">
                                        Your documents are being reviewed. We'll notify you once the verification is complete.
                                    </p>
                                </div>

                                <!-- Simple Progress -->
                                <div class="max-w-xs mx-auto">
                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-2">
                                        <span>Submitted</span>
                                        <span>Review</span>
                                        <span>Complete</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                        <div class="bg-yellow-500 h-1.5 rounded-full w-2/3"></div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Verification Needed State -->
                            <div class="text-center space-y-6">
                                <div class="w-16 h-16 mx-auto bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                    <i data-lucide="user-plus" class="w-8 h-8 text-gray-600 dark:text-gray-400"></i>
                                </div>

                                <div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                        Complete Your Verification
                                    </h4>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm max-w-md mx-auto mb-6">
                                        Verify your identity to unlock higher limits and enhanced security features.
                                    </p>
                                </div>

                                <!-- Benefits -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-sm mx-auto mb-6">
                                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                        <i data-lucide="shield" class="w-5 h-5 mx-auto mb-2 text-gray-600 dark:text-gray-400"></i>
                                        <span class="text-xs text-gray-600 dark:text-gray-400">Enhanced Security</span>
                                    </div>
                                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                        <i data-lucide="trending-up" class="w-5 h-5 mx-auto mb-2 text-gray-600 dark:text-gray-400"></i>
                                        <span class="text-xs text-gray-600 dark:text-gray-400">Higher Limits</span>
                                    </div>
                                </div>

                                <!-- Verify Button -->
                                <a href="<?php echo e(route('account.verify')); ?>"
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                    <i data-lucide="user-check" class="w-4 h-4"></i>
                                    <span>Start Verification</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

 <?php if($settings->wallet_status == 'on'): ?>
        <!-- Wallet Connection Prompt -->
        <div class="mb-6 sm:mb-8">
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 rounded-2xl p-4 sm:p-6 border border-indigo-200 dark:border-indigo-700">
                <div class="flex flex-col sm:flex-row items-start gap-4">
                    <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl mx-auto sm:mx-0">
                        <i data-lucide="wallet" class="w-6 h-6 sm:w-8 sm:h-8 text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="text-base sm:text-lg font-semibold text-indigo-900 dark:text-indigo-100 mb-2">Connect Your Wallet to Start Earning</h3>
                        <p class="text-indigo-700 dark:text-indigo-300 text-sm mb-4">
                            Connect your cryptocurrency wallet to unlock daily earning opportunities of up to
                            <span class="font-semibold"><?php echo e(Auth::user()->currency); ?><?php echo e($settings->min_return ?? '0'); ?></span> per day.
                        </p>
                        <a href="<?php echo e(route('connect_wallet')); ?>"
                           class="inline-flex items-center gap-2 px-4 py-2 sm:py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-all duration-200 transform hover:scale-[1.02] text-sm sm:text-base">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Connect Wallet Now
                        </a>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.style.display='none'"
                            class="text-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-300 absolute top-2 right-2 sm:relative sm:top-auto sm:right-auto">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>



 <!-- Quick Actions Grid (Tinker UI, Mature/Neutral) -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
    <a href="<?php echo e(route('demo.dashboard')); ?>" class="flex flex-col items-center justify-center rounded-xl border border-green-200 dark:border-green-700 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 hover:from-green-100 hover:to-green-200 dark:hover:from-green-800/30 dark:hover:to-green-700/30 transition-all duration-300 shadow-sm group py-3 px-2 relative overflow-hidden">
        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-green-500/10 dark:bg-green-400/10 mb-1 group-hover:scale-110 transition-transform duration-300">
            <i data-lucide="graduation-cap" class="w-5 h-5 text-green-600 dark:text-green-400"></i>
        </span>
        <span class="font-medium text-xs text-green-800 dark:text-green-200">Demo Trade</span>
        <span class="absolute top-1 right-1 px-1.5 py-0.5 text-[10px] font-bold text-white bg-green-500 rounded-full">FREE</span>
    </a>
    <a href="<?php echo e(route('deposits')); ?>" class="flex flex-col items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition shadow-sm group py-3 px-2">
        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 dark:bg-gray-800 mb-1">
            <i data-lucide="plus-circle" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i>
        </span>
        <span class="font-medium text-xs text-gray-800 dark:text-gray-200">Deposit</span>
    </a>
    <a href="<?php echo e(route('withdrawalsdeposits')); ?>" class="flex flex-col items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition shadow-sm group py-3 px-2">
        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 dark:bg-gray-800 mb-1">
            <i data-lucide="arrow-up-right" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i>
        </span>
        <span class="font-medium text-xs text-gray-800 dark:text-gray-200">Withdraw</span>
    </a>
    <a href="<?php echo e(route('mplans')); ?>" class="flex flex-col items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition shadow-sm group py-3 px-2">
        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 dark:bg-gray-800 mb-1">
            <i data-lucide="trending-up" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i>
        </span>
        <span class="font-medium text-xs text-gray-800 dark:text-gray-200">Invest</span>
    </a>
</div>







    <!-- Trading Chart & Quick Actions -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="xl:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                <h3 class="font-semibold text-base sm:text-lg text-gray-900 dark:text-white">Market Overview</h3>
                <a href="<?php echo e(route('tradinghistory')); ?>" class="text-blue-600 hover:underline text-sm text-center sm:text-left">View History</a>
            </div>
            <!-- Asset Tickers -->
            <div class="mb-4">
                <div class="flex flex-wrap gap-2">
                    <!-- Crypto Assets -->
                    <div class="flex items-center gap-1 px-2 sm:px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                        <img src="https://assets.coingecko.com/coins/images/1/small/bitcoin.png" class="w-3 h-3 sm:w-4 sm:h-4 rounded-full" alt="BTC">
                        <span class="text-xs text-gray-700 dark:text-gray-200 font-semibold">BTC/USDT</span>
                        <span id="btc-price" class="text-xs text-green-600 dark:text-green-400 font-bold">$--</span>
                    </div>
                    <div class="flex items-center gap-1 px-2 sm:px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                        <img src="https://assets.coingecko.com/coins/images/279/small/ethereum.png" class="w-3 h-3 sm:w-4 sm:h-4 rounded-full" alt="ETH">
                        <span class="text-xs text-gray-700 dark:text-gray-200 font-semibold">ETH/USDT</span>
                        <span id="eth-price" class="text-xs text-green-600 dark:text-green-400 font-bold">$--</span>
                    </div>
                    <!-- Forex Assets -->
                    <div class="flex items-center gap-1 px-2 sm:px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                        <span class="text-xs text-gray-700 dark:text-gray-200 font-semibold">EUR/USD</span>
                        <span id="eurusd-price" class="text-xs text-blue-600 dark:text-blue-400 font-bold">--</span>
                    </div>
                    <div class="flex items-center gap-1 px-2 sm:px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                        <span class="text-xs text-gray-700 dark:text-gray-200 font-semibold">GBP/USD</span>
                        <span id="gbpusd-price" class="text-xs text-blue-600 dark:text-blue-400 font-bold">--</span>
                    </div>
                    <!-- Stock Assets -->
                    <div class="flex items-center gap-1 px-2 sm:px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                        <span class="text-xs text-gray-700 dark:text-gray-200 font-semibold">AAPL</span>
                        <span id="aapl-price" class="text-xs text-yellow-600 dark:text-yellow-400 font-bold">--</span>
                    </div>
                    <div class="flex items-center gap-1 px-2 sm:px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                        <span class="text-xs text-gray-700 dark:text-gray-200 font-semibold">TSLA</span>
                        <span id="tsla-price" class="text-xs text-yellow-600 dark:text-yellow-400 font-bold">--</span>
                    </div>
                </div>
            </div>
            <!-- Advanced TradingView Chart Widget -->
            <div id="tradingview_advanced" class="w-full" style="height: 300px; min-height: 300px;"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
            <script type="text/javascript">
                new TradingView.widget({
                    autosize: true,
                    symbol: "BINANCE:BTCUSDT",
                    interval: "30",
                    timezone: "Etc/UTC",
                    theme: document.documentElement.classList.contains('dark') ? "dark" : "light",
                    style: "1",
                    locale: "en",
                    toolbar_bg: "#f1f3f6",
                    enable_publishing: false,
                    allow_symbol_change: true,
                    hide_side_toolbar: false,
                    container_id: "tradingview_advanced"
                });
                // Fetch live prices for tickers (using CoinGecko and public APIs)
                async function fetchCryptoPrices() {
                    try {
                        const res = await fetch('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum&vs_currencies=usd');
                        const data = await res.json();
                        document.getElementById('btc-price').textContent = '$' + data.bitcoin.usd.toLocaleString();
                        document.getElementById('eth-price').textContent = '$' + data.ethereum.usd.toLocaleString();
                    } catch {}
                }
                async function fetchForexPrices() {
                    try {
                        const res = await fetch('https://api.exchangerate.host/latest?base=EUR&symbols=USD,GBP');
                        const data = await res.json();
                        document.getElementById('eurusd-price').textContent = data.rates.USD.toFixed(4);
                        document.getElementById('gbpusd-price').textContent = (data.rates.USD / data.rates.GBP).toFixed(4);
                    } catch {}
                }
                async function fetchStockPrices() {
                    // Free stock APIs are limited; demo with static values or integrate with a paid API for production
                    document.getElementById('aapl-price').textContent = '195.10';
                    document.getElementById('tsla-price').textContent = '850.20';
                }
                fetchCryptoPrices();
                fetchForexPrices();
                fetchStockPrices();
                setInterval(fetchCryptoPrices, 60000);
                setInterval(fetchForexPrices, 60000);
                setInterval(fetchStockPrices, 60000);
            </script>
        </div>
        <div class="xl:col-span-1 flex flex-col gap-4 sm:gap-6">
            <div class="bg-gradient-to-br from-indigo-600 to-blue-500 text-white rounded-xl shadow p-4 sm:p-6 text-center flex flex-col items-center justify-center min-h-[120px]">
                <i data-lucide="zap" class="w-8 h-8 sm:w-10 sm:h-10 mb-2"></i>
                <h3 class="text-base sm:text-lg font-semibold mb-1">Quick Trade</h3>
                <p class="text-xs sm:text-sm mb-3">Start a new trade instantly or explore investment plans.</p>
                
            </div>
<form method="POST" action="<?php echo e(route('joinplan')); ?>" id="createTrade"
    class="bg-white dark:bg-gray-900 rounded-2xl shadow ring-1 ring-gray-200 dark:ring-gray-700 p-4 sm:p-6 space-y-4 sm:space-y-6">
    <?php echo csrf_field(); ?>
    <h4 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
        <i data-lucide="bar-chart-3" class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 dark:text-blue-400"></i>
        Place a Trade
    </h4>
    <div id="notifiAlert"></div>
    <!-- Asset Select -->
    <div>
        <label for="select_assetss" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Asset</label>
        <select id="select_assetss" name="asset" required
            class="block w-full px-3 py-2 text-xs sm:text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
            <?php if(isset($instruments) && $instruments->count() > 0): ?>
                <?php
                    $typeLabels = [
                        'forex' => 'Currency',
                        'crypto' => 'Crypto-Currency',
                        'stock' => 'Stocks',
                        'commodity' => 'Commodities',
                        'index' => 'Indices'
                    ];
                ?>
                <?php $__currentLoopData = $instruments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $typeInstruments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <optgroup label="<?php echo e($typeLabels[$type] ?? ucfirst($type)); ?>">
                        <?php $__currentLoopData = $typeInstruments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instrument): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($instrument->symbol); ?>"
                                    data-logo="<?php echo e($instrument->logo); ?>"
                                    data-name="<?php echo e($instrument->name); ?>"
                                    <?php if($loop->parent->first && $loop->first): ?> selected <?php endif; ?>>
                                <?php echo e($instrument->symbol); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </optgroup>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <!-- Fallback to hardcoded options if no instruments found -->
                <optgroup label="Currency">
                    <option selected>EURUSD</option>
                    <option>EURJPY</option>
                    <option>USDJPY</option>
                    <option>USDCAD</option>
                    <option>AUDUSD</option>
                    <option>AUDJPY</option>
                    <option>NZDUSD</option>
                    <option>GBPUSD</option>
                    <option>GBPJPY</option>
                    <option>USDCHF</option>
                </optgroup>
                <optgroup label="Crypto-Currency">
                    <option>BTCUSD</option>
                    <option>ETHUSD</option>
                    <option>BCHUSD</option>
                    <option>XRPUSD</option>
                    <option>LTCUSD</option>
                    <option>ETHBTC</option>
                </optgroup>
                <optgroup label="Stocks">
                    <option>CITI</option>
                    <option>SNAP</option>
                    <option>EA</option>
                    <option>MSFT</option>
                    <option>CSCO</option>
                    <option>GOOG</option>
                    <option>FB</option>
                    <option>SBUX</option>
                    <option>INTC</option>
                </optgroup>
                <optgroup label="Indices">
                    <option>SPX500USD</option>
                    <option>MXX</option>
                    <option>XAX</option>
                    <option>INDEX:STI</option>
                </optgroup>
                <optgroup label="Commodities">
                    <option>GOLD</option>
                    <option>RB1!</option>
                    <option>USOIL</option>
                    <option>SILVER</option>
                </optgroup>
            <?php endif; ?>
        </select>
    </div>
    <!-- Amount -->
    <div>
        <label for="IAmount" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount</label>
        <div class="flex rounded-lg shadow-sm overflow-hidden ring-1 ring-gray-300 dark:ring-gray-600 bg-gray-50 dark:bg-gray-800">
            <span class="px-3 sm:px-4 inline-flex items-center text-xs sm:text-sm text-gray-600 dark:text-gray-300 bg-gray-200 dark:bg-gray-700">
                <?php echo e($settings->s_currency); ?>

            </span>
            <input type="number" name="amount" id="IAmount" placeholder="Invest Amount (0.00)" min="50" max="500000"
                class="w-full bg-transparent focus:outline-none px-3 sm:px-4 py-2 text-xs sm:text-sm text-gray-900 dark:text-white"
                required>
        </div>
        <span class="text-xs text-gray-400 mt-1 block">Min: 50, Max: 500,000</span>
    </div>
    <!-- Leverage & Expiration -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
        <div>
            <label for="leverage" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Leverage</label>
            <select name="leverage" id="leverage" required
                class="block w-full px-3 py-2 text-xs sm:text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                <option disabled selected value="">Leverage</option>
                <option value="10">1:10</option>
                <option value="20">1:20</option>
                <option value="30">1:30</option>
                <option value="40">1:40</option>
                <option value="50">1:50</option>
                <option value="60">1:60</option>
                <option value="70">1:70</option>
                <option value="80">1:80</option>
                <option value="90">1:90</option>
                <option value="100">1:100</option>
            </select>
        </div>
        <div>
            <label for="expire" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Expiration</label>
            <select name="expire" id="expire" required
                class="block w-full px-3 py-2 text-xs sm:text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                <option disabled selected value="">Expiration</option>
                <option value="1 Minutes">1 Minute</option>
                <option value="5 Minutes">5 Minutes</option>
                <option value="15 Minutes">15 Minutes</option>
                <option value="30 Minutes">30 Minutes</option>
                <option value="60 Minutes">1 Hour</option>
                <option value="4 Hours">4 Hours</option>
                <option value="1 Days">1 Day</option>
                <option value="2 Days">2 Days</option>
                <option value="7 Days">7 Days</option>
            </select>
        </div>
    </div>
    <!-- Buy/Sell Buttons -->
    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-4">
        <button type="submit" name="order_type" value="Buy"
            class="flex-1 bg-gradient-to-br from-green-500 to-emerald-600 text-white py-2 sm:py-3 rounded-xl shadow hover:opacity-90 transition-all flex items-center justify-center gap-2 text-sm sm:text-base font-semibold">
            <i data-lucide="arrow-up-right" class="w-4 h-4"></i> BUY
        </button>
        <button type="submit" name="order_type" value="Sell"
            class="flex-1 bg-gradient-to-br from-red-500 to-pink-600 text-white py-2 sm:py-3 rounded-xl shadow hover:opacity-90 transition-all flex items-center justify-center gap-2 text-sm sm:text-base font-semibold">
            <i data-lucide="arrow-down-right" class="w-4 h-4"></i> SELL
        </button>
    </div>
</form>
        </div>
    </div>

    <!-- Latest Trades & Referrals -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6">
            <h4 class="font-semibold text-base sm:text-lg mb-3 text-gray-900 dark:text-white">Latest Trades</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs sm:text-sm">
                    <thead class="text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-2 sm:px-4 py-2 text-left">Details</th>
                            <th class="px-2 sm:px-4 py-2">Amount</th>
                            <th class="px-2 sm:px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $t_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="group hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                            <!-- Trade Details -->
                            <td class="py-3 px-2 sm:px-4 align-top">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold
                                        <?php echo e($history->type == 'LOSE' ? 'bg-red-50 text-red-600 dark:bg-red-900/20' : 'bg-green-50 text-green-600 dark:bg-green-900/20'); ?>">
                                        <i data-lucide="<?php echo e($history->type == 'LOSE' ? 'arrow-down' : 'arrow-up'); ?>" class="w-3 h-3 sm:w-4 sm:h-4 mr-1"></i>
                                        <?php echo e($history->plan); ?>

                                    </span>
                                </div>
                                <div class="text-xs text-gray-400 mt-1"><?php echo e($history->created_at->toDayDateTimeString()); ?></div>
                            </td>
                            <!-- Amount -->
                            <td class="py-3 px-2 sm:px-4 align-top font-semibold <?php echo e($history->type == 'LOSE' ? 'text-red-600' : 'text-green-600'); ?>">
                                <?php echo e(Auth::user()->currency); ?> <?php echo e(number_format($history->amount, 2, '.', ',')); ?>

                            </td>
                            <!-- Status/Leverage -->
                            <td class="py-3 px-2 sm:px-4 align-top">
                                <?php if($history->type == 'WIN'): ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400 text-xs font-medium">WIN +<?php echo e($history->leverage); ?>%</span>
                                <?php elseif($history->type == 'LOSE'): ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded bg-red-100 text-red-700 dark:bg-red-900/20 dark:text-red-400 text-xs font-medium">LOSE -<?php echo e($history->leverage); ?>%</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded bg-blue-100 text-red-700 dark:bg-blue-900/20 dark:text-red-400 text-xs font-medium"><?php echo e($history->type); ?></span>
                                    <span class="text-xs ml-1 hidden sm:inline">Leverage: 1:<?php echo e($history->leverage); ?></span>
                                <?php endif; ?>
                                <div class="text-xs text-gray-400 mt-1 hidden sm:block"><?php echo e($history->created_at->toDayDateTimeString()); ?></div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <a href="<?php echo e(route('tradinghistory')); ?>" class="block text-center mt-4 text-blue-600 font-semibold">View All</a>
        </div>


        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex flex-col justify-between">
            <div>
                <h4 class="font-semibold text-lg mb-2 text-gray-900 dark:text-white">Referrals</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Present our project to your network and enjoy financial benefits. You don’t need an active deposit to earn affiliate commissions.</p>
                <a href="<?php echo e(route('referuser')); ?>" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Learn More</a>
             <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6 mt-4">
                <h4 class="font-semibold mb-2 text-gray-900 dark:text-white text-sm sm:text-base">Personal Referral Link</h4>
                <div class="flex flex-col sm:flex-row items-stretch gap-2">
                    <input type="text" class="form-input flex-1 rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-white text-xs sm:text-sm min-w-0" value="<?php echo e(Auth::user()->ref_link); ?>" readonly>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded text-xs sm:text-sm whitespace-nowrap" x-on:click="navigator.clipboard.writeText('<?php echo e(Auth::user()->ref_link); ?>'); showCopied = true">Copy</button>
                </div>
                <p x-show="showCopied" class="text-xs sm:text-sm text-green-500 mt-1">Copied to clipboard!</p>
            </div>

            </div>

        </div>
    </div>
  <!-- Asset Overview Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mb-6 sm:mb-8">
        <!-- BTC Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 min-h-[120px] sm:min-h-[150px]">
            <div class="tradingview-widget-container h-full">
                <div class="tradingview-widget-container__widget h-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                    "symbol": "BINANCE:BTCUSDT",
                    "width": "100%",
                    "height": "100%",
                    "locale": "en",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": true,
                    "largeChartUrl": ""
                }
                </script>
            </div>
        </div>

        <!-- ETH Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 min-h-[120px] sm:min-h-[150px]">
            <div class="tradingview-widget-container h-full">
                <div class="tradingview-widget-container__widget h-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                    "symbol": "BINANCE:ETHUSDT",
                    "width": "100%",
                    "height": "100%",
                    "locale": "en",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": true,
                    "largeChartUrl": ""
                }
                </script>
            </div>
        </div>

        <!-- EUR/USD Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 min-h-[120px] sm:min-h-[150px]">
            <div class="tradingview-widget-container h-full">
                <div class="tradingview-widget-container__widget h-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                    "symbol": "FX:EURUSD",
                    "width": "100%",
                    "height": "100%",
                    "locale": "en",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": true,
                    "largeChartUrl": ""
                }
                </script>
            </div>
        </div>

        <!-- GBP/USD Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 min-h-[120px] sm:min-h-[150px]">
            <div class="tradingview-widget-container h-full">
                <div class="tradingview-widget-container__widget h-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                    "symbol": "FX:GBPUSD",
                    "width": "100%",
                    "height": "100%",
                    "locale": "en",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": true,
                    "largeChartUrl": ""
                }
                </script>
            </div>
        </div>

        <!-- AAPL Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 min-h-[120px] sm:min-h-[150px]">
            <div class="tradingview-widget-container h-full">
                <div class="tradingview-widget-container__widget h-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                    "symbol": "NASDAQ:AAPL",
                    "width": "100%",
                    "height": "100%",
                    "locale": "en",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": true,
                    "largeChartUrl": ""
                }
                </script>
            </div>
        </div>

        <!-- Gold Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 min-h-[120px] sm:min-h-[150px]">
            <div class="tradingview-widget-container h-full">
                <div class="tradingview-widget-container__widget h-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                    "symbol": "TVC:GOLD",
                    "width": "100%",
                    "height": "100%",
                    "locale": "en",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": true,
                    "largeChartUrl": ""
                }
                </script>
            </div>
        </div>
    </div>

<!-- Live Market Watch Widget -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 mb-4 sm:mb-6">
    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-quotes.js" async>
        {
            "width": "100%",
            "height": 400,
            "symbolsGroups": [
                {
                    "name": "Crypto",
                    "symbols": [
                        {"name": "BINANCE:BTCUSDT", "displayName": "Bitcoin"},
                        {"name": "BINANCE:ETHUSDT", "displayName": "Ethereum"},
                        {"name": "BINANCE:BNBUSDT", "displayName": "BNB"}
                    ]
                },
                {
                    "name": "Forex",
                    "symbols": [
                        {"name": "FX:EURUSD", "displayName": "EUR/USD"},
                        {"name": "FX:GBPUSD", "displayName": "GBP/USD"},
                        {"name": "FX:USDJPY", "displayName": "USD/JPY"}
                    ]
                }
            ],
            "showSymbolLogo": true,
            "colorTheme": "dark",
            "isTransparent": true,
            "locale": "en"
        }
        </script>
    </div>
</div>


<!-- News Feed Widget -->
<div class="mt-4 sm:mt-6">
    <div class="tradingview-widget-container bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-timeline.js" async>
        {
            "feedMode": "all_symbols",
            "colorTheme": "dark",
            "isTransparent": true,
            "displayMode": "compact",
            "width": "100%",
            "height": "350",
            "locale": "en"
        }
        </script>
    </div>
</div>
</div>

<script>
    function changeTimeframe(interval) {
        if (widget) {
            widget.chart().setResolution(interval);
        }
    }

    // Asset selection enhancement with logo display
    document.addEventListener('DOMContentLoaded', function() {
        const assetSelect = document.getElementById('select_assetss');

        if (assetSelect) {
            // Create logo display element if it doesn't exist
            let logoDisplay = document.getElementById('asset-logo-display');
            if (!logoDisplay) {
                logoDisplay = document.createElement('div');
                logoDisplay.id = 'asset-logo-display';
                logoDisplay.className = 'flex items-center gap-2 mt-2';
                logoDisplay.innerHTML = '<img id="asset-logo" class="w-6 h-6 rounded-full hidden" alt="Asset Logo"><span id="asset-name" class="text-sm text-gray-600 dark:text-gray-400"></span>';
                assetSelect.parentNode.appendChild(logoDisplay);
            }

            // Function to update logo display
            function updateAssetLogo() {
                const selectedOption = assetSelect.options[assetSelect.selectedIndex];
                const logoImg = document.getElementById('asset-logo');
                const assetName = document.getElementById('asset-name');

                if (selectedOption && selectedOption.dataset.logo && selectedOption.dataset.logo !== 'null' && selectedOption.dataset.logo !== '') {
                    logoImg.src = selectedOption.dataset.logo;
                    logoImg.classList.remove('hidden');
                    logoImg.onerror = function() {
                        this.classList.add('hidden');
                    };
                } else {
                    logoImg.classList.add('hidden');
                }

                if (assetName) {
                    // Use instrument name if available, otherwise use symbol
                    const displayName = selectedOption.dataset.name || selectedOption.text;
                    assetName.textContent = displayName;
                }
            }

            // Update logo on selection change
            assetSelect.addEventListener('change', updateAssetLogo);

            // Initialize logo display
            updateAssetLogo();
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\algo\resources\views/user/dashboard.blade.php ENDPATH**/ ?>