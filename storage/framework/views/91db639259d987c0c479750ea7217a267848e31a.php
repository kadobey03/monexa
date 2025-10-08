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
    <div class="main-panel ">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-5">
                    <h1 class="title1 d-inline ">Process Withdrawal Request</h1>
                    <div class="d-inline">
                        <div class="float-right btn-group">

                            <a class="btn btn-primary btn-sm" href="<?php echo e(route('mwithdrawals')); ?>"> <i
                                    class="fa fa-arrow-left"></i> back</a>
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
                <div class="mb-5 row">
                    <div class="col-lg-8 offset-lg-2 card p-md-4 p-2  shadow">
                        <!-- Withdrawal Details Edit Section -->
                        <div class="mb-4 p-3 border rounded" style="background-color: #f8f9fa; border-color: #dee2e6;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    <i class="fa fa-edit text-primary"></i> Edit Withdrawal Details
                                </h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="toggleEditForm">
                                    <i class="fa fa-eye"></i> Toggle Edit Form
                                </button>
                            </div>

                            <div id="editFormContainer" style="display: none;">
                                <form action="<?php echo e(route('edit.withdrawal')); ?>" method="POST" id="editWithdrawalForm">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="withdrawal_id" value="<?php echo e($withdrawal->id); ?>">

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="edit_amount"><strong>Amount</strong></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="number" step="0.01" class="form-control" name="amount" id="edit_amount"
                                                       value="<?php echo e($withdrawal->amount); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="edit_status"><strong>Status</strong></label>
                                            <select name="status" id="edit_status" class="form-control" required>
                                                <option value="Pending" <?php echo e($withdrawal->status == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                                <option value="Processed" <?php echo e($withdrawal->status == 'Processed' ? 'selected' : ''); ?>>Processed</option>
                                                <option value="Rejected" <?php echo e($withdrawal->status == 'Rejected' ? 'selected' : ''); ?>>Rejected</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="edit_payment_mode"><strong>Payment Mode</strong></label>
                                            <input type="text" class="form-control" name="payment_mode" id="edit_payment_mode"
                                                   value="<?php echo e($withdrawal->payment_mode); ?>" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="edit_created_at"><strong>Created Date</strong></label>
                                            <input type="datetime-local" class="form-control" name="created_at" id="edit_created_at"
                                                   value="<?php echo e(\Carbon\Carbon::parse($withdrawal->created_at)->format('Y-m-d\TH:i')); ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="edit_paydetails"><strong>Payment Details</strong></label>
                                        <textarea class="form-control" name="paydetails" id="edit_paydetails" rows="3"
                                                  placeholder="Enter payment details..."><?php echo e($withdrawal->paydetails); ?></textarea>
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="button" class="btn btn-secondary mr-2" id="cancelEdit">
                                            <i class="fa fa-times"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Update Withdrawal Details
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Current Values Display -->
                            <div id="currentValues">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Current Amount:</strong> $<?php echo e(number_format($withdrawal->amount, 2)); ?></p>
                                        <p><strong>Current Status:</strong>
                                            <span class="badge badge-<?php echo e($withdrawal->status == 'Processed' ? 'success' : ($withdrawal->status == 'Pending' ? 'warning' : 'danger')); ?>">
                                                <?php echo e($withdrawal->status); ?>

                                            </span>
                                        </p>
                                        <p><strong>Current Payment Mode:</strong> <?php echo e($withdrawal->payment_mode); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Created Date:</strong> <?php echo e(\Carbon\Carbon::parse($withdrawal->created_at)->format('M d, Y H:i A')); ?></p>
                                        <p><strong>Payment Details:</strong> <?php echo e($withdrawal->paydetails ?: 'Not specified'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <hr class="my-4">

                        <div class="mb-3">
                            <?php if($withdrawal->status != 'Processed'): ?>
                                <h4 class="">Send Funds to <?php echo e($user->name?? "N/A"); ?> through his payment details below</h4>
                            <?php else: ?>
                                <h4 class="text-success">Payment Completed</h4>
                            <?php endif; ?>
                        </div>
                        <div class="">
                            <?php if($method->defaultpay == 'yes'): ?>
                                <?php if($withdrawal->payment_mode == 'Bitcoin'): ?>
                                    <div class="mb-3 form-group">
                                        <h5 class="">BTC Address</h5>
                                        <input type="text" class="form-control readonly  "
                                            value="<?php echo e($withdrawal->duser->btc_address); ?>" readonly>
                                    </div>
                                <?php elseif($withdrawal->payment_mode == 'Ethereum'): ?>
                                    <div class="mb-3 form-group">
                                        <h5 class="">ETH Address</h5>
                                        <input type="text" class="form-control readonly  "
                                            value="<?php echo e($withdrawal->duser->eth_address); ?>" readonly>
                                    </div>
                                <?php elseif($withdrawal->payment_mode == 'Litecoin'): ?>
                                    <div class="mb-3 form-group">
                                        <h5 class="">LTC Address</h5>
                                        <input type="text" class="form-control readonly  "
                                            value="<?php echo e($withdrawal->duser->ltc_address); ?>" readonly>
                                    </div>
                                <?php elseif($withdrawal->payment_mode == 'USDT'): ?>
                                    <h5 class="">USDT Address</h5>
                                    <input type="text" class="form-control readonly  "
                                        value="<?php echo e($withdrawal->duser->usdt_address); ?>" readonly>
                                <?php elseif($withdrawal->payment_mode == 'BUSD'): ?>
                                    <h5 class="">BUSD Address</h5>
                                    <input type="text" class="form-control readonly  "
                                        value="<?php echo e($withdrawal->paydetails); ?>" readonly>
                                <?php elseif($withdrawal->payment_mode == 'Bank Transfer'): ?>
                                    <div class="mb-3 form-group">
                                        <h5 class="">Bank Name</h5>
                                        <input type="text" class="form-control readonly  "
                                            value="<?php echo e($withdrawal->duser->bank_name); ?>" readonly>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <h5 class="">Account Name</h5>
                                        <input type="text" class="form-control readonly  "
                                            value="<?php echo e($withdrawal->duser->account_name); ?>" readonly>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <h5 class="">Account Number</h5>
                                        <input type="text" class="form-control readonly  "
                                            value="<?php echo e($withdrawal->duser->account_number); ?>" readonly>
                                    </div>
                                    <?php if(!empty($withdrawal->duser->swift_code)): ?>
                                        <div class="mb-3 form-group">
                                            <h5 class="">Swift Code</h5>
                                            <input type="text" class="form-control readonly  "
                                                value="<?php echo e($withdrawal->duser->swift_code); ?>" readonly>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($method->methodtype == 'crypto'): ?>
                                    <div class="mb-3 form-group">
                                        <h5 class=""><?php echo e($withdrawal->payment_mode); ?> Address</h5>
                                        <input type="text" class="form-control readonly  "
                                            value="<?php echo e($withdrawal->paydetails); ?>" readonly>
                                    </div>
                                <?php else: ?>
                                    <div class="mb-3 form-group">
                                        <h5 class=""><?php echo e($withdrawal->payment_mode); ?> Payment Details</h5>
                                        <input type="text" class="form-control readonly  "
                                            value="<?php echo e($withdrawal->paydetails); ?>" readonly>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <?php if($withdrawal->status != 'Processed'): ?>
                            <div class="mt-1">
                                <form action="<?php echo e(route('pwithdrawal')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <h6 class="">Action</h6>
                                            <select name="action" id="action" class="  mb-2 form-control">
                                                
                                                <option value="Paid">Paid</option>
                                                <option value="Reject">Reject</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row d-none" id="emailcheck">
                                        <div class="col-md-12 form-group">
                                            <div class="selectgroup">
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="emailsend" id="dontsend" value="false"
                                                        class="selectgroup-input" checked="">
                                                    <span class="selectgroup-button">Don't Send Email</span>
                                                </label>
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="emailsend" id="sendemail" value="true"
                                                        class="selectgroup-input">
                                                    <span class="selectgroup-button">Send Email</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row d-none" id="emailtext">
                                        <div class="form-group col-md-12">
                                            <h6 class="">Subject</h6>
                                            <input type="text" name="subject" id="subject" class="  form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <h6 class="">Enter Reasons for rejecting this withdrawal request</h6>
                                            <textarea class="  form-control" row="3" placeholder="Type in here" name="reason" id="message"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php echo e($withdrawal->id); ?>">
                                        <input type="submit" class="px-3 btn btn-primary" value="Proccess">
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let action = document.getElementById('action');

            $('#action').change(function() {
                if (action.value === "Reject") {
                    document.getElementById('emailcheck').classList.remove('d-none');
                } else {
                    document.getElementById('emailcheck').classList.add('d-none');
                    document.getElementById('emailtext').classList.add('d-none');
                    document.getElementById('dontsend').checked = true;
                    document.getElementById('subject').removeAttribute('required');
                    document.getElementById('message').removeAttribute('required');
                }
            });

            $('#sendemail').click(function() {
                document.getElementById('emailtext').classList.remove('d-none');
                document.getElementById('subject').setAttribute('required', '');
                document.getElementById('message').setAttribute('required', '');
            });

            $('#dontsend').click(function() {
                document.getElementById('emailtext').classList.add('d-none');
                document.getElementById('subject').removeAttribute('required');
                document.getElementById('message').removeAttribute('required');
            });

            // Toggle edit form visibility
            $('#toggleEditForm').click(function() {
                const editContainer = document.getElementById('editFormContainer');
                const currentValues = document.getElementById('currentValues');
                const button = this;

                if (editContainer.style.display === 'none') {
                    editContainer.style.display = 'block';
                    currentValues.style.display = 'none';
                    button.innerHTML = '<i class="fa fa-eye-slash"></i> Hide Edit Form';
                } else {
                    editContainer.style.display = 'none';
                    currentValues.style.display = 'block';
                    button.innerHTML = '<i class="fa fa-eye"></i> Toggle Edit Form';
                }
            });

            // Cancel edit functionality
            $('#cancelEdit').click(function() {
                document.getElementById('editFormContainer').style.display = 'none';
                document.getElementById('currentValues').style.display = 'block';
                document.getElementById('toggleEditForm').innerHTML = '<i class="fa fa-eye"></i> Toggle Edit Form';
            });

            // Form validation
            $('#editWithdrawalForm').submit(function(e) {
                const amount = parseFloat($('#edit_amount').val());
                if (amount < 0) {
                    e.preventDefault();
                    alert('Amount cannot be negative');
                    return false;
                }

                if (confirm('Are you sure you want to update this withdrawal request?')) {
                    return true;
                } else {
                    e.preventDefault();
                    return false;
                }
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\algomain\resources\views/admin/Withdrawals/pwithrdawal.blade.php ENDPATH**/ ?>