
<?php $__env->startSection('admin-title'); ?>
Admin-Trila-Period-Clients
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
          <h3 class="box-title">Business Trial period Clients</h3>
          
         <!--  <a href="<?php echo e(url('admin/create-business-client')); ?>" class="btn btn-info pull-right">
           Create Business Client
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
              <th>Client Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Business Name</th>
              <th>Trial Period Expired(completed days/Total days)</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
          <?php if(isset($main)): ?>
            <?php $__currentLoopData = $main; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diff_in_day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($i++); ?></td>
              <td><?php echo e($diff_in_day['name']); ?> <?php echo e($diff_in_day['surname']); ?></td>
              <td><?php echo e($diff_in_day['email']); ?></td>
              <td><?php echo e($diff_in_day['country_code']); ?><?php echo e($diff_in_day['phone_number']); ?></td>
              <td><?php echo e($diff_in_day['businesss_name']); ?></td>
              <td><?php echo e($diff_in_day['diff_in_days']); ?> days completed / 30 (days)</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
          <?php endif; ?>
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
<script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>