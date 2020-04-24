<?php $__env->startSection('title'); ?>
Business Manager-Create Client
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 <section class="content">
  <div class="row">
    <div class="col-xs-12">
     
      <!-- /.box -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">My Requests</h3>
          
          <a href="<?php echo e(url('client/send-request')); ?>" class="btn btn-info pull-right">
           Send Request
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
              <th>Subject</th>
              <th>Message</th>
              <th>Created Date</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
            <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($i++); ?></td>
              <td><?php echo e($request->subject); ?></td>
              <td><?php echo str_limit($request->message,400); ?></td>
              <td><?php echo e($request->created_record_date); ?></td>
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

</div>
<!-- //active account modal end -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.client.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>