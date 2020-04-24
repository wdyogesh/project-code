<?php $__env->startSection('admin-title'); ?>
Admin-Business Manager Subscriptions
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-pagelevel-styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
 <section class="content">
  <div class="row">
    <div class="col-xs-12">
     
      <!-- /.box -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Subscribed Clients</h3>
          
          <!-- <a href="<?php echo e(url('admin/crate-subscription-plans')); ?>" class="btn btn-info pull-right">
           Create Subscription
         </a> -->
         
       </div>
       <div class="alert alert-success alert-dismissable" id="sucMsgDeleteDiv" style="display: none;">
         <i class="fa fa-check"></i>
         <b>Record Deleted Success!</b>
         <span class="sucmsgdiv"></span>                     
       </div>
       <!-- /.box-header -->
       <?php if(Session::has('success')): ?>
       <div  align="center" id="successMessage"  class="alert alert-info"><?php echo e(Session::get('success')); ?>

       </div>
       <?php endif; ?>
       <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Business</th>
              <th>All Subscriptions</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
          <?php $__currentLoopData = $all_business_mnagers_subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $all_business_mnagers_subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($i++); ?></td>
              <td><?php echo e($all_business_mnagers_subscription->name); ?> <?php echo e($all_business_mnagers_subscription->surname); ?></td>
              <td><?php echo e($all_business_mnagers_subscription->email); ?></td>
              <td><?php echo e($all_business_mnagers_subscription->country_code); ?><?php echo e($all_business_mnagers_subscription->ares_code); ?><?php echo e($all_business_mnagers_subscription->phone_number); ?></td>
              <td><?php echo e($all_business_mnagers_subscription->businesss_name); ?></td>
              <td><a href="<?php echo e(url('admin/business-level-subscriptions/'.Hashids::encode($all_business_mnagers_subscription->main_user_id))); ?>">Click Here</a></td>
             </tr>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          
        </tbody>
        
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
  
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</section>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-pagelevel-script'); ?>
<meta name="_token" content="<?php echo csrf_token(); ?>" />
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>