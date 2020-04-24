<?php $__env->startSection('title'); ?>
Business Manager-Subscriptions
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 <section class="content-header">
      <h1>
       Business Client
        <small>Subscription Plans</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Settings</a></li>
        <li class="active">Subscriptions</li>
      </ol>
    </section>
    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
   <?php endif; ?>
    <?php if(Session::has('success')): ?>
       <div  align="center" id="successMessage"  class="alert alert-info"><?php echo e(Session::get('success')); ?>

       </div>
    <?php endif; ?>
      <section class="content">

 <form action="<?php echo e(url('manager/suscribe-package')); ?>" method="post">
<?php echo e(csrf_field()); ?> 
<?php if(count($subscription_packages) != 0): ?>    
<?php $__currentLoopData = $subscription_packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription_package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="row">
       <div class="col-md-3">
       </div>
     
        <div class="col-md-6">
          <!-- iCheck -->
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title"><b style="color:green">Package Name:</b> <?php echo e($subscription_package->package_name); ?></h3>
            </div>
            <div class="box-body">
        
              <div class="form-group">
                <label>
                 <b>Data Size:</b> </label> <?php echo e($subscription_package->data_size); ?> GB</h3>
                </label><br>
                 <label>
                 <b>Price:</b> </label> <?php echo e($subscription_package->price); ?>$</h3>
                </label><br>
                <label>
                  User Limit: </label><br>        
                     <input type="radio" name="package_id" class="minimal" value="<?php echo e($subscription_package->id); ?>">
                   <?php echo e($subscription_package->user_size_from); ?> - <?php echo e($subscription_package->user_size_to); ?> Users
                </label>
              </div>
            </div>
            <!-- /.box-body -->
           
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col (right) -->

      </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
       <!-- /.row -->
    <div class="form-group" align="center">
     <input type="hidden" name="user_id" value="<?php echo e(Auth::user()->id); ?>">
    <button type="submit" class="btn btn-success">Subscribe</button>
  </div>
  <?php else: ?>
  <h2 align="center" style="color:red">No Subscription Packages</h2>
  <?php endif; ?>  
                
 </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>