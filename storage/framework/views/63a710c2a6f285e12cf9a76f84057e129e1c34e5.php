<?php $__env->startSection('admin-title'); ?>
Admin-Feed Back Management
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
          <h3 class="box-title">Feed Backs</h3>
          
         <!--  <a href="<?php echo e(url('admin/create-feedback-categories')); ?>" class="btn btn-info pull-right">
           Add
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
              <th>Id</th>
              <th>Client Name</th>
              <th>Client Email</th>
              <th>Feed Back Category</th>
              <th>Rating</th>
              <th>Created Date</th>
             <!--  <th>Action</th> -->
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
          <?php if(isset($main)): ?>
            <?php $__currentLoopData = $main; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($i++); ?></td>
              <td><?php echo e(ucfirst($feed['client_name'])); ?></td>
              <td><?php echo e($feed['email']); ?></td>
              <td><?php echo e($feed['category_name']); ?></td>
              <td><?php echo e($feed['rating']); ?> / 10</td>
              <td><?php echo e($feed['created_record_date']); ?></td>
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
  var url = "<?php echo e(url('admin/delete-feedback-categories')); ?>";
  $(document).on('click','.delete-client',function(){
    if(confirm('Are you sure want to delete?')){
      var user_id = $(this).val();
      /*alert(user_id);*/
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      })
      $.ajax({
        type: "DELETE",
        url: url + '/' + user_id,         
        success: function (data) {
          console.log(data);
          $('#sucMsgDeleteDiv').show('slow');
          setTimeout(function(){ $('#sucMsgDeleteDiv').hide('slow');location.reload(); }, 500);
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    }
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>