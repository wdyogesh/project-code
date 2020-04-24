<?php $__env->startSection('title'); ?>
Employee-Dashboard
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
  <section class="content-header">
      <h1>
        Dashboard
        <!-- <small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo e(url('/')); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo e($manager_software_clients_count); ?></h3>

              <p>Clients</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo e(url('employee/clients')); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

              <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo e($total_manager_software_appointments_count); ?></h3>

              <p>Appointments</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo e(url('employee/appointments')); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
       
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo e($managers_other_parties_count); ?></h3>

              <p>Other Parties</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href<?php echo e(url('employee/manage-other-parties')); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
  
      </div>
      <!-- /.row -->
      <!-- Main row -->
    
      <!-- /.row (main row) -->
  </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.employee.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>