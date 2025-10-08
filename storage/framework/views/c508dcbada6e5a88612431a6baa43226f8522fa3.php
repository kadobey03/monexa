
<?php $__env->startComponent('mail::message'); ?>
# Hello <?php echo e($demo->receiver_name); ?>,

This is to notify you that your investment plan (<?php echo e($demo->receiver_plan); ?> plan)  has expired and your capital for this plan has been added to your account for withdrawal. <br>

<strong>Plan:</strong> <?php echo e($demo->receiver_plan); ?> <br>

<strong>Amount:</strong> <?php echo e($demo->received_amount); ?> <br>

<strong>Date:</strong> <?php echo e($demo->date); ?> <br>

Kind regards,<br>
<?php echo e($demo->sender); ?>.
<?php echo $__env->renderComponent(); ?>

<?php /**PATH /datas/monexafi/public_html/resources/views/emails/endplan.blade.php ENDPATH**/ ?>