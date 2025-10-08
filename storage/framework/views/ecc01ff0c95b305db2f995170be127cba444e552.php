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
			<div class="content bg-<?php echo e($bg); ?>">
				<div class="page-inner">
					<div class="mt-2 mb-4">
						<h1 class="title1 text-<?php echo e($text); ?>">Update Copy Trading Plan</h1>
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
						<div class="col-lg-10 d-flex justify-content-center ">
                            <div class="p-3 card bg-<?php echo e($bg); ?>">
                                <form role="form" method="post" action="<?php echo e(route('updatecopytrading')); ?>" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <h5 class="text-<?php echo e($text); ?>">Expert Trader Tag (MID/PRO)</h5>
                                            <input  class="form-control text-<?php echo e($text); ?> bg-<?php echo e($bg); ?>" value ="<?php echo e($copytrading->tag); ?>" placeholder="Enter Expert Trader Tag" type="text" name="tag" required>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <h5 class="text-<?php echo e($text); ?>">Trader Name</h5> 
                                            <input class="form-control text-<?php echo e($text); ?> bg-<?php echo e($bg); ?>" placeholder="Enter Expert Trader Name" type="text" name="name" value ="<?php echo e($copytrading->name); ?>" required>   
                                            
                                       </div>	
                                       <div class="form-group col-md-5">
                                            <h5 class="text-<?php echo e($text); ?>">Expert Trader Number of Followers</h5> 			 
                                             <input placeholder="Enter Expert Trader Number of Followers" class="form-control text-<?php echo e($text); ?> bg-<?php echo e($bg); ?>" type="text" name="followers" value ="<?php echo e($copytrading->followers); ?>" required>  
                                             <small class="text-<?php echo e($text); ?>">This is the  number of followers who currently trading with the Expert</small> 
                                       </div>
                                       <div class="form-group col-md-5">
                                             <h5 class="text-<?php echo e($text); ?>">Enter Expert Total profit (<?php echo e($settings->currency); ?>)</h5> 			 
                                             <input class="form-control text-<?php echo e($text); ?> bg-<?php echo e($bg); ?>" placeholder="Enter Expert Total profit" type="text" name="total_profit"  value ="<?php echo e($copytrading->total_profit); ?>" required> 
                                            <small class="text-<?php echo e($text); ?>">This is the Total Profit made by this Expert trader</small> 
                                       </div>
                                       <div class="form-group col-md-5">
                                            <h5 class="text-<?php echo e($text); ?>">Copy Trade Type (Copy/Buy)</h5> 
                                            <select class="form-control text-<?php echo e($text); ?> bg-<?php echo e($bg); ?>" name="button_name" value ="<?php echo e($copytrading->button_name); ?>">
                                                <option>Copy</option>
                                                <option>Buy</option>
                
                                            </select>  
                                        
                                       </div>
                                       <div class="form-group col-md-5">
                                            <h5 class="text-<?php echo e($text); ?>">Expert Trader Active Days</h5> 
                                           <input class="form-control text-<?php echo e($text); ?> bg-<?php echo e($bg); ?>" placeholder="Enter maximum return" type="text" name="active_days"  value ="<?php echo e($copytrading->active_days); ?>" required>  
                                           <small class="text-<?php echo e($text); ?>">This is the expected days trader is available</small> 
                                       </div>
                                       <div class="form-group col-md-5">
                                            <h5 class="text-<?php echo e($text); ?>">Equity (Wining rate) %</h5> 
                                           <input class="form-control text-<?php echo e($text); ?> bg-<?php echo e($bg); ?>" placeholder="Enter Expert trade Equity" type="text" name="equity" value ="<?php echo e($copytrading->equity); ?>" value="0" required>  
                                           <small class="text-<?php echo e($text); ?>">This is Expert Wining Rate </small>  
                                       </div>
                                       
                                      

                                       <div class="form-group col-md-5">
                                           <h5 class="text-<?php echo e($text); ?>"> Startup Amount (<?php echo e($settings->currency); ?>)</h5> 
                                           <input class="form-control text-<?php echo e($text); ?> bg-<?php echo e($bg); ?>" placeholder=" Startup Amount" type="text" name="price" value ="<?php echo e($copytrading->price); ?>" required> 
                                           <small class="text-<?php echo e($text); ?>">This is the price of this Copytrading </small>   
                                       </div>
                                      
                                       <div class="form-group col-md-5">
                                        <h5 class="text-<?php echo e($text); ?>">Expert Trader rating</h5> 
                                           <input class="form-control text-<?php echo e($text); ?> bg-<?php echo e($bg); ?>" placeholder="Expert Trader rating" type="text" name="rating"   value ="<?php echo e($copytrading->rating); ?>" required> 
                                           <small class="text-<?php echo e($text); ?>">This Expert Trader rating </small> 
                                           <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                             <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                            
                                       </div>



                                       <div class="form-group col-md-5">
                                        <h5 class="text-<?php echo e($text); ?>">Expert Trader Photo</h5> 
                                           <input class="form-control text-<?php echo e($text); ?> bg-<?php echo e($bg); ?>"  value ="<?php echo e($copytrading->photo); ?>" placeholder="Expert Trader photo" type="file" name="photo"  > 
                                           <small class="text-<?php echo e($text); ?>">This Expert Trader Photo </small> 
                                            
                                       </div>
                                       <div class="form-group col-md-12">
                                        <input type="hidden" name="id" value="<?php echo e($copytrading->id); ?>">
                                           <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                           <input type="submit" class="btn btn-secondary" value="Add New Copy Trading Plan">   
                                       </div>
                                    </div>
                               </form>
                            </div>
						</div>
					</div>
				</div>
			</div>
            
            <div id="durationModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body bg-<?php echo e($bg); ?>">
                            <h5 class="text-<?php echo e($text); ?>">FIRSTLY, Always preceed the time frame with a digit, that is do not write the number in letters, <br> <br> SECONDLY, always add space after the number, <br> <br> LASTLY, the first letter of the timeframe should be in CAPS and always add 's' to the timeframe even if your duration is just a day, month or year.</h5>
                            <h2 class="text-<?php echo e($text); ?>">Eg, 1 Days, 3 Weeks, 1 Hours, 48 Hours, 4 Months, 1 Years, 9 Months</h2>
                           
                        </div>
                    </div>
                </div>
            </div>
            <div id="topupModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body bg-<?php echo e($bg); ?>">
                            
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .checked {
  color: orange;
}
                </style>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/elitemaxpro/check.elitemaxpro.click/resources/views/admin/copytrading/editcopytrading.blade.php ENDPATH**/ ?>