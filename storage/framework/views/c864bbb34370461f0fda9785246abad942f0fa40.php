
<?php $__env->startComponent('mail::message'); ?>
# Deposit Confirmation - <?php echo e($foramin  ? 'Admin Notification' : 'Welcome to Your Trading Journey'); ?>


<?php if($foramin): ?>
## Administrative Alert: New Deposit Received

Dear Administrator,

We are pleased to inform you that a new deposit has been successfully received:

**Deposit Details:**
- **Client:** <?php echo e($user->name); ?>

- **Amount:** <?php echo e($user->currency); ?><?php echo e(number_format($deposit->amount, 2)); ?>

- **Status:** <?php echo e($deposit->status); ?>

- **Date:** <?php echo e(now()->format('F j, Y \a\t g:i A')); ?>


<?php if($deposit->status != "Processed"): ?>
**Action Required:** Please review and process this deposit through the admin dashboard.

<?php $__env->startComponent('mail::button', ['url' => config('app.url').'/admin/dashboard']); ?>
Process Deposit
<?php echo $__env->renderComponent(); ?>
<?php else: ?>
This deposit has been automatically processed and the client's account has been credited.
<?php endif; ?>

<?php else: ?>
## Dear <?php echo e($user->name); ?>,

<?php if($deposit->status == 'Processed'): ?>
**Congratulations! Your deposit has been successfully processed.**

We are delighted to confirm that your deposit of **<?php echo e($user->currency); ?><?php echo e(number_format($deposit->amount, 2)); ?>** has been received and processed. Your trading account has been credited with the full amount.

**What's Next?**
- Your funds are now available for trading
- Explore our advanced trading tools and analytics
- Start building your investment portfolio today

<?php $__env->startComponent('mail::button', ['url' => config('app.url').'/dashboard']); ?>
Start Trading Now
<?php echo $__env->renderComponent(); ?>

**Investment Opportunities Await:**
- Copy successful traders with our Copy Trading feature
- Access real-time market data and advanced charts
- Benefit from our algorithmic trading tools

<?php else: ?>
**Your deposit is being processed - Thank you for choosing us!**

We have successfully received your deposit of **<?php echo e($user->currency); ?><?php echo e(number_format($deposit->amount, 2)); ?>**. Our financial team is currently reviewing and confirming your transaction.

**Processing Status:** Under Review
**Expected Processing Time:** 1-3 business hours


You will receive an immediate notification once your deposit is confirmed and your trading account is credited.

<?php $__env->startComponent('mail::panel'); ?>
**Security Notice:** We employ bank-level security protocols to ensure your funds are safe and secure throughout the processing period.
<?php echo $__env->renderComponent(); ?>

<?php endif; ?>
<?php endif; ?>

---

**Need Assistance?**
Our dedicated support team is available 24/7 to assist you with any questions.

<?php $__env->startComponent('mail::button', ['url' => config('app.url').'/support', 'color' => 'success']); ?>
Contact Support
<?php echo $__env->renderComponent(); ?>

Best regards,<br>
**The <?php echo e(config('app.name')); ?> Team**<br>
*Your Trusted Trading Partner*

<?php $__env->startComponent('mail::subcopy'); ?>
This is an automated message from <?php echo e(config('app.name')); ?>. For security purposes, please do not share this email with anyone. If you did not initiate this deposit, please contact our support team immediately.
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->renderComponent(); ?>

<?php /**PATH C:\xampp\htdocs\algomain\resources\views/emails/success-deposit.blade.php ENDPATH**/ ?>