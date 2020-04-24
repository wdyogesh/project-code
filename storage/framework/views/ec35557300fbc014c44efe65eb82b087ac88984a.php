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
          <h3 class="box-title"><?php echo e($business_manager['name']); ?> <?php echo e($business_manager['surname']); ?> Subscriptions</h3>


          
          <a href="<?php echo e(url('admin/business-cliens-subscriptions')); ?>" class="btn btn-info pull-right">
          Go Back
         </a>
         
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
              <th>Subscription Date</th>
              <th>Package</th>
              <th>Data</th>
              <th>Used Data</th>
              <th>Price($)</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
          <?php $__currentLoopData = $business_mnager_level_all_subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business_mnager_level_all_subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($i++); ?></td>
              <td><?php echo e($business_mnager_level_all_subscription->subscription_date); ?></td>
              <td><?php echo e($business_mnager_level_all_subscription->package_name); ?>(<?php echo e($business_mnager_level_all_subscription->user_size_from); ?>-<?php echo e($business_mnager_level_all_subscription->user_size_to); ?>)</td>
              <td><?php echo e($business_mnager_level_all_subscription->data_size); ?>GB</td>
              <?php if($business_mnager_level_all_subscription->used_data == ""): ?>
              <td>--</td>
              <?php else: ?>
              <td><?php echo e($business_mnager_level_all_subscription->used_data); ?></td>
              <?php endif; ?>
              
              <td><?php echo e($business_mnager_level_all_subscription->price); ?>$</td>
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