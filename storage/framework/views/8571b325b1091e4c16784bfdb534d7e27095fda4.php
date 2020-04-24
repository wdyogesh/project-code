<?php $__env->startSection('title'); ?>
Business Manager-Settings
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
  <section class="content-header">
      <h1>
        Settings
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li class="active">Dashboard</li>
      </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua" >
            <div class="inner">
              <h4>General Settings</h4>

              <a href="<?php echo e(url('manager/profile')); ?>" style="color:#EE2B89;">-> My profile</a></br>
              <a href="<?php echo e(url('manager/change-password')); ?>" style="color:#EE2B89;">-> Change Password</a></br>
              <a href="<?php echo e(url('manager/subscriptions')); ?>" style="color:#EE2B89;">-> Subscription</a></br>
            </div>
          </div>
        </div>
        <!-- ./col -->
       <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua" style="width:400px;">
            <div class="inner" style="height: 117px;">
              <h4>Appointment & Face to face consultation settings</h4>

              <a href="<?php echo e(url('manager/appointment-settings')); ?>" style="color:#EE2B89;">-> Calendar setting</a></br>
              <a href="<?php echo e(url('manager/face-to-face-consultation-settings')); ?>" style="color:#EE2B89;">-> Face to face consultation availability setting</a>
            </div>
          </div>
        </div>
        <!-- ./col -->
      

      </div>
      <!-- /.row -->

      
      <!-- Main row -->
    
      <!-- /.row (main row) -->
  </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>            <a href="<?php echo e(url('manager/face-to-face-consultation-settings')); ?>" style="color:#EE2B89;">-> Face to face consultation availability setting</a>
		-->
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      
      <!-- Main row -->
    
      <!-- /.row (main row) -->
  </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>