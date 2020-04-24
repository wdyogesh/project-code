<?php $__env->startSection('admin-title'); ?>
Admin-Subscriptions
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
          <h3 class="box-title">Subscription Packages</h3>
          
          <a href="<?php echo e(url('admin/crate-subscription-plans')); ?>" class="btn btn-info pull-right">
           Create Subscription
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
              <th>Package Name</th>
              <th>Data Size</th>
              <th>Users Size</th>
              <th>Price($)</th>
              <th>Created Date</th>
              <th>Updated Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
            <?php $__currentLoopData = $all_plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $all_plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($i++); ?></td>
              <td><?php echo e($all_plan->package_name); ?></td>
              <td><?php echo e($all_plan->data_size); ?>GB</td>
              <td><?php echo e($all_plan-> user_size_from); ?> - <?php echo e($all_plan->  user_size_to); ?></td>
              <td><?php echo e($all_plan->price); ?></td>
              <td><?php echo e($all_plan->created_at); ?></td>
              <?php if($all_plan->created_at == ""): ?>
              <td>--</td>
              <?php else: ?>
              <td><?php echo e($all_plan->created_at); ?></td>
              <?php endif; ?>
              <td>
              <a href="<?php echo e(url('admin/edit-subscription-plan/'.Hashids::encode($all_plan->id))); ?>" class="btn btn-info" title="Edit">
                  <span class="glyphicon glyphicon-pencil"></span>
                 </a>
               <button class="btn btn-danger btn-delete delete-package" value="<?php echo e($all_plan->id); ?>" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
              </td>
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
<script>
var url = "<?php echo e(url('admin/delete-subscription-package')); ?>";
$(document).on('click','.delete-package',function(){
  //alert('hai');
  if(confirm('Are you sure want to delete?')){
    var id = $(this).val();
    //alert(id);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    })
    $.ajax({
      type: "DELETE",
      url: url + '/' + id,         
      success: function (data) {
        alert('hi');
        console.log(data);
      //$("#user" + user_id).remove();
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