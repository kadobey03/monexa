<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.topmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 d-inline text-<?php echo e($text); ?>">Demo Trades Management</h1>
                    <div class="d-inline">
                        <div class="float-right btn-group">
                            <a class="btn btn-primary btn-sm" href="<?php echo e(route('admin.demo.users')); ?>">
                                <i class="fa fa-users"></i> Manage Demo Users
                            </a>
                        </div>
                    </div>
                </div>
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

                <!-- Statistics Cards -->
                <div class="mb-4 row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Demo Trades</div>
                                        <div class="h5 mb-0 font-weight-bold text-<?php echo e($text); ?>"><?php echo e($stats['total_trades']); ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Active Trades</div>
                                        <div class="h5 mb-0 font-weight-bold text-<?php echo e($text); ?>"><?php echo e($stats['active_trades']); ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-play-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Total Volume</div>
                                        <div class="h5 mb-0 font-weight-bold text-<?php echo e($text); ?>">
                                            $<?php echo e(number_format($stats['total_volume'], 2)); ?>

                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Profitable Trades</div>
                                        <div class="h5 mb-0 font-weight-bold text-<?php echo e($text); ?>"><?php echo e($stats['profitable_trades']); ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-trophy fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="mb-4 row">
                    <div class="col-12 card shadow p-4">
                        <h6 class="m-0 font-weight-bold text-primary mb-3">Filter Demo Trades</h6>
                        <form method="GET" class="row">
                            <div class="col-md-3 mb-3">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" class="form-control" id="search" name="search"
                                       value="<?php echo e(request('search')); ?>" placeholder="User name, email, or asset">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">All Status</option>
                                    <option value="yes" <?php echo e(request('status') == 'yes' ? 'selected' : ''); ?>>Active</option>
                                    <option value="no" <?php echo e(request('status') == 'no' ? 'selected' : ''); ?>>Closed</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="">All Types</option>
                                    <option value="buy" <?php echo e(request('type') == 'buy' ? 'selected' : ''); ?>>Buy</option>
                                    <option value="sell" <?php echo e(request('type') == 'sell' ? 'selected' : ''); ?>>Sell</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="asset" class="form-label">Asset</label>
                                <input type="text" class="form-control" id="asset" name="asset"
                                       value="<?php echo e(request('asset')); ?>" placeholder="BTC, ETH, etc.">
                            </div>
                            <div class="col-md-3 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">Filter</button>
                                <a href="<?php echo e(route('admin.demo.trades')); ?>" class="btn btn-secondary ml-2">Clear</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Demo Trades Table -->
                <div class="mb-5 row">
                    <div class="col-12 card shadow p-4">
                        <div class="table-responsive" data-example-id="hoverable-table">
                            <table id="ShipTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Trade ID</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Asset</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Leverage</th>
                                        <th>Entry Price</th>
                                        <th>Current P&L</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $demoTrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($trade->id); ?></td>
                                        <td><?php echo e($trade->user->name ?? 'N/A'); ?></td>
                                        <td><?php echo e($trade->user->email ?? 'N/A'); ?></td>
                                        <td>
                                            <span class="badge badge-info"><?php echo e($trade->assets); ?></span>
                                        </td>
                                        <td>
                                            <span class="badge <?php echo e($trade->type == 'buy' ? 'badge-success' : 'badge-danger'); ?>">
                                                <?php echo e(strtoupper($trade->type)); ?>

                                            </span>
                                        </td>
                                        <td>$<?php echo e(number_format($trade->amount, 2)); ?></td>
                                        <td><?php echo e($trade->leverage); ?>x</td>
                                        <td>$<?php echo e(number_format($trade->entry_price, 2)); ?></td>
                                        <td>
                                            <?php
                                                $pnl = $trade->calculatePnL();
                                            ?>
                                            <span class="badge <?php echo e($pnl >= 0 ? 'badge-success' : 'badge-danger'); ?>">
                                                $<?php echo e(number_format($pnl, 2)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php if($trade->active == 'yes'): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Closed</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($trade->created_at->toDayDateTimeString()); ?></td>
                                        <td>
                                            <?php if($trade->active == 'yes'): ?>
                                                <form action="<?php echo e(route('admin.demo.close-trade', $trade->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-warning btn-sm m-1"
                                                            onclick="return confirm('Are you sure you want to close this demo trade?')"
                                                            title="Close Trade">
                                                        <i class="fa fa-stop-circle"></i> Close
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <a href="<?php echo e(route('admin.demo.users')); ?>?search=<?php echo e($trade->user->email ?? ''); ?>"
                                               class="btn btn-info btn-sm m-1" title="View User">
                                                <i class="fa fa-user"></i> View User
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-chart-line fa-3x text-gray-300 mb-3"></i>
                                                <h5 class="text-gray-500">No demo trades found</h5>
                                                <p class="text-muted">No demo trading activity matches your current filters.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-refresh page every 30 seconds for real-time data
            setInterval(function() {
                if (!document.querySelector('.dropdown.show')) {
                    window.location.reload();
                }
            }, 30000);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\algo\resources\views/admin/demo/trades.blade.php ENDPATH**/ ?>