
<?php $__env->startSection('title'); ?>
Business Manager-Create Client
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<!-- new date picker style start-->
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->

<!-- new date picker style start-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <?php if($message = Session::get('success')): ?>
                <div class="custom-alerts alert alert-success fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <?php echo $message; ?>

                </div>
                <?php Session::forget('success');?>
                <?php endif; ?>
                <?php if($message = Session::get('error')): ?>
                <div class="custom-alerts alert alert-danger fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <?php echo $message; ?>

                </div>
                <?php Session::forget('error');?>
                <?php endif; ?>
                <div class="panel-heading">Paywith Stripe</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" id="payment-form" role="form" action="<?php echo e(url('manager/addmoney/stripe')); ?>" >
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group<?php echo e($errors->has('card_no') ? ' has-error' : ''); ?>">
                            <label for="card_no" class="col-md-4 control-label">Card No</label>
                            <div class="col-md-6">
                                <input id="card_no" type="text" class="form-control" name="card_no" value="<?php echo e(old('card_no')); ?>" autofocus>
                                <?php if($errors->has('card_no')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('card_no')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group<?php echo e($errors->has('ccExpiryMonth') ? ' has-error' : ''); ?>">
                            <label for="ccExpiryMonth" class="col-md-4 control-label">Expiry Month</label>
                            <div class="col-md-6">
                                <input id="ccExpiryMonth" type="text" class="form-control" name="ccExpiryMonth" value="<?php echo e(old('ccExpiryMonth')); ?>" autofocus>
                                <?php if($errors->has('ccExpiryMonth')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('ccExpiryMonth')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group<?php echo e($errors->has('ccExpiryYear') ? ' has-error' : ''); ?>">
                            <label for="ccExpiryYear" class="col-md-4 control-label">Expiry Year</label>
                            <div class="col-md-6">
                                <input id="ccExpiryYear" type="text" class="form-control" name="ccExpiryYear" value="<?php echo e(old('ccExpiryYear')); ?>" autofocus>
                                <?php if($errors->has('ccExpiryYear')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('ccExpiryYear')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group<?php echo e($errors->has('cvvNumber') ? ' has-error' : ''); ?>">
                            <label for="cvvNumber" class="col-md-4 control-label">CVV No.</label>
                            <div class="col-md-6">
                                <input id="cvvNumber" type="text" class="form-control" name="cvvNumber" value="<?php echo e(old('cvvNumber')); ?>" autofocus>
                                <?php if($errors->has('cvvNumber')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('cvvNumber')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group<?php echo e($errors->has('amount') ? ' has-error' : ''); ?>">
                            <label for="amount" class="col-md-4 control-label">Amount</label>
                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control" name="amount" value="$ <?php echo e($package_plan_access['price']); ?>" autofocus readonly>
                                <?php if($errors->has('amount')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('amount')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Paywith Stripe
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>