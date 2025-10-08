<?php
if (Auth('admin')->User()->dashboard_style == "light") {
    $text = "dark";
	$bg = "light";
} else {
	$bg = 'dark';
    $text = "light";
}
?>


<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.topmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title"><?php echo e($bot->name); ?> Details</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.bots.index')); ?>">Bot Trading</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#"><?php echo e($bot->name); ?></a>
                </li>
            </ul>
        </div>

        <!-- Bot Information Card -->
        <div class="row">
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card-header" style="background-image: url('<?php echo e(asset('dash/img/blogpost.jpg')); ?>')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                <?php if($bot->image): ?>
                                    <img src="<?php echo e(asset('storage/app/public/' . $bot->image)); ?>" alt="Bot" class="avatar-img rounded-circle">
                                <?php else: ?>
                                    <div class="avatar-img rounded-circle bg-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-robot text-white fa-2x"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name"><?php echo e($bot->name); ?></div>
                            <div class="job"><?php echo e(ucfirst($bot->bot_type)); ?> Trading Bot</div>
                            <div class="desc"><?php echo e($bot->description); ?></div>
                            <div class="social-media">
                                <a class="btn btn-info btn-twitter btn-sm btn-link" href="<?php echo e(route('admin.bots.edit', $bot)); ?>">
                                    <span class="btn-label just-icon"><i class="flaticon-edit"></i></span>
                                </a>
                                <a class="btn btn-success btn-twitter btn-sm btn-link" href="<?php echo e(route('admin.bots.analytics', $bot)); ?>">
                                    <span class="btn-label just-icon"><i class="flaticon-chart-pie"></i></span>
                                </a>
                                <form action="<?php echo e(route('admin.bots.toggle-status', $bot)); ?>" method="POST" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-<?php echo e($bot->status == 'active' ? 'warning' : 'primary'); ?> btn-sm btn-link">
                                        <span class="btn-label just-icon">
                                            <i class="flaticon-<?php echo e($bot->status == 'active' ? 'pause' : 'play'); ?>"></i>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row user-stats text-center">
                            <div class="col">
                                <div class="number"><?php echo e($bot->user_investments_count ?? 0); ?></div>
                                <div class="title">Investors</div>
                            </div>
                            <div class="col">
                                <div class="number"><?php echo e($bot->success_rate); ?>%</div>
                                <div class="title">Success Rate</div>
                            </div>
                            <div class="col">
                                <div class="number"><?php echo e($bot->duration_days); ?></div>
                                <div class="title">Days</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Bot Statistics -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Bot Performance Statistics</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ml-3 ml-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category">Total Earned</p>
                                                    <h4 class="card-title">$<?php echo e(number_format($bot->total_earned, 2)); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ml-3 ml-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category">Total Users</p>
                                                    <h4 class="card-title"><?php echo e($bot->total_users); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                                    <i class="fas fa-chart-line"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ml-3 ml-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category">Profit Range</p>
                                                    <h4 class="card-title"><?php echo e($bot->daily_profit_min); ?>%-<?php echo e($bot->daily_profit_max); ?>%</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ml-3 ml-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category">Last Trade</p>
                                                    <h4 class="card-title">
                                                        <?php if($bot->last_trade): ?>
                                                            <?php echo e($bot->last_trade->diffForHumans()); ?>

                                                        <?php else: ?>
                                                            Never
                                                        <?php endif; ?>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bot Configuration -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Bot Configuration</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-typo">
                                    <tbody>
                                        <tr>
                                            <td><strong>Market Type:</strong></td>
                                            <td><?php echo e(ucfirst($bot->bot_type)); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Min Investment:</strong></td>
                                            <td>$<?php echo e(number_format($bot->min_investment, 2)); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Max Investment:</strong></td>
                                            <td>$<?php echo e(number_format($bot->max_investment, 2)); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Success Rate:</strong></td>
                                            <td><?php echo e($bot->success_rate); ?>%</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Duration:</strong></td>
                                            <td><?php echo e($bot->duration_days); ?> days</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-typo">
                                    <tbody>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <?php if($bot->status == 'active'): ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php elseif($bot->status == 'inactive'): ?>
                                                    <span class="badge badge-secondary">Inactive</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Maintenance</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Daily Profit Min:</strong></td>
                                            <td><?php echo e($bot->daily_profit_min); ?>%</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Daily Profit Max:</strong></td>
                                            <td><?php echo e($bot->daily_profit_max); ?>%</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td><?php echo e($bot->created_at->format('M d, Y')); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Updated:</strong></td>
                                            <td><?php echo e($bot->updated_at->format('M d, Y')); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <?php if($bot->trading_pairs): ?>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5>Trading Pairs</h5>
                                <div class="d-flex flex-wrap">
                                    <?php
                                        $tradingPairs = $bot->trading_pairs;
                                        if (is_string($tradingPairs)) {
                                            $tradingPairs = json_decode($tradingPairs, true) ?: [];
                                        } elseif (!is_array($tradingPairs)) {
                                            $tradingPairs = [];
                                        }
                                    ?>
                                    <?php $__currentLoopData = $tradingPairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge badge-primary mr-2 mb-2"><?php echo e($pair); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Trades -->
        <?php if(count($recentTrades) > 0): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Recent Trading Activity</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Investment</th>
                                        <th>Pair</th>
                                        <th>Result</th>
                                        <th>Profit/Loss</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentTrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($trade->userBotInvestment->user->name ?? 'N/A'); ?></td>
                                        <td>$<?php echo e(number_format($trade->userBotInvestment->investment_amount, 2)); ?></td>
                                        <td><?php echo e($trade->trading_pair); ?></td>
                                        <td>
                                            <?php if($trade->result == 'profit'): ?>
                                                <span class="badge badge-success">Profit</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Loss</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="text-<?php echo e($trade->result == 'profit' ? 'success' : 'danger'); ?>">
                                                $<?php echo e(number_format($trade->profit_loss, 2)); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($trade->created_at->format('M d, Y H:i')); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/elitemaxpro/check.elitemaxpro.click/resources/views/admin/bots/show.blade.php ENDPATH**/ ?>