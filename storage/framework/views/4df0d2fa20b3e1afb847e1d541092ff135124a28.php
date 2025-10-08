<?php
if (Auth('admin')->User()->dashboard_style == "light") {
    $text = "dark";
	$bg = 'light';
} else {
    $text = "light";
	$bg = 'dark';
}
?>

    <?php $__env->startSection('content'); ?>
        <?php echo $__env->make('admin.topmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="main-panel">
			<div class="content bg-<?php echo e(Auth('admin')->User()->dashboard_style); ?>">
				<div class="page-inner">
					<div class="mt-2 mb-4">
						<h1 class="title1 text-<?php echo e($text); ?>">System Copy trading Plans</h1>
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
					<div class="mb-5 row">
						<div class="mt-2 mb-3 col-lg-12">
							<a class="btn btn-primary" href="<?php echo e(route('newcopytrading')); ?>"><i class="fa fa-plus"></i> New Copy Trading Plans </a>
						</div>
						<?php $__empty_1 = true; $__currentLoopData = $copytradings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $copytrading): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
						<div class="col-lg-3">
							
							<div class="pricing-table purple border p-4 card bg-<?php echo e($bg); ?> shadow">
								<div>
									
								<span class='badge badge-warning'><?php echo e($copytrading->tag); ?></span>
								</div>
								<div class="text-center">
									<img src="<?php echo e(asset('storage/app/public/'.$copytrading->photo)); ?>"  width="85" height="75" class="rounded-circle rounded" alt="<?php echo e($copytrading->name); ?>">
									<h3 class="text-<?php echo e($text); ?> text-center text-primary"><span class="px-4 mx-auto bg-white shadow-sm  rounded-bottom"><?php echo e($copytrading->name); ?></span></h3>
									
								</div>
								
								
								<!-- Price -->
								
								<!-- Features -->
								<div class="pricing-features">
									<div class="feature text-<?php echo e($text); ?>">
										Copy Trading Price:<span class="text-<?php echo e($text); ?>"><?php echo e($settings->currency); ?><?php echo e(number_format( $copytrading->price)); ?></span>
									</div>

									<div class="feature text-<?php echo e($text); ?>">
										Expert Total Followers:<span class="text-<?php echo e($text); ?>"><?php echo e(number_format( $copytrading->followers)); ?></span>
									</div>
									<div class="feature text-<?php echo e($text); ?>">
										Expert Total Profit:<span class="text-<?php echo e($text); ?>"><?php echo e($settings->currency); ?><?php echo e(number_format( $copytrading->total_profit)); ?></span>
									</div>
									<div class="feature text-<?php echo e($text); ?>">
										Equity:<span class="text-<?php echo e($text); ?>"><?php echo e(number_format( $copytrading->equity)); ?>%</span>
									</div>
									<div class="feature text-<?php echo e($text); ?>">
										Active Days:<span class="text-<?php echo e($text); ?>"><?php echo e(number_format( $copytrading->active_days)); ?> Days</span>
									</div>
									<div class="feature text-<?php echo e($text); ?>">
										Expert ratings:
										<?php if($copytrading->rating==5): ?>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										 <span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<?php elseif($copytrading->rating==4): ?>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										 <span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star "></span>
										<?php elseif($copytrading->rating==3): ?>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										 <span class="fa fa-star checked"></span>
										<span class="fa fa-star "></span>
										<span class="fa fa-star "></span>
										<?php elseif($copytrading->rating==2): ?>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star checked"></span>
										 <span class="fa fa-star "></span>
										<span class="fa fa-star "></span>
										<span class="fa fa-star "></span>
										<?php elseif($copytrading->rating==1): ?>
										<span class="fa fa-star checked"></span>
										<span class="fa fa-star "></span>
										 <span class="fa fa-star "></span>
										<span class="fa fa-star "></span>
										<span class="fa fa-star "></span>
										<?php endif; ?>

										<style>
											.checked {
							  color: orange !important;
							}
											</style>
									</div>
									
									
									
								</div> <br>
								
								<!-- Button -->
								<div class="text-center">
									<a href="<?php echo e(route('editcopytrading',  $copytrading->id)); ?>" class="btn btn-primary"><i class="text-white flaticon-pencil"></i>
									</a> &nbsp; 
									<a href="<?php echo e(url('admin/dashboard/trashcopytrading')); ?>/<?php echo e($copytrading->id); ?>" class="btn btn-danger"><i class="text-white fa fa-times"></i>
									</a>
								</div>
							</div>
						</div>	
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
						<div class="col-lg-8">
							<div class="pricing-table card purple border bg-<?php echo e($bg); ?> shadow p-4">
								<h4 class="text-<?php echo e($text); ?>">No Copytrading Plan at the moment, click the button above to add a Copy trading.</h4>
							</div>
						</div>
						<?php endif; ?>
						
					</div>
				</div>
			</div>
			
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/elitemaxpro/check.elitemaxpro.click/resources/views/admin/copytrading/copytrading.blade.php ENDPATH**/ ?>