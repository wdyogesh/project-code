<?php $__env->startSection('title'); ?>
Business Manager-All Attachments
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<style type="text/css">
.manager-content-wrapper{margin-left: 0;}
.scrollable-menu {
    height: auto;
    max-height: 200px;
    overflow-x: hidden;
}
</style>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper manager-content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Mr <?php echo e($client_record['name']); ?> <?php echo e($client_record['surname']); ?> / Attachments
      </h1>
     <a href="<?php echo e(url('manager/attach-file/'.Hashids::encode($client_record['id']))); ?>" class="btn btn-info pull-right">Add</a>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">

          <div class="box box-solid">
            <div class="box-header with-border">
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
          <?php echo $__env->make('frontend.business-manager.client-management.client-details-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          </div>
        
        </div>
    
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
            <div class="btn-group" align="center">
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Select Heading<span class="caret"></span></button>
                <ul class="dropdown-menu scrollable-menu" role="menu">
                 <li><a href="<?php echo e(url('manager/client-attachments/'.Hashids::encode($client_record['id']))); ?>">All</a></li>
                <?php if(isset($attachments)): ?>
               <?php $__currentLoopData = $fileter_attachment_headings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <li><a href="<?php echo e(url('manager/client-attachments/'.Hashids::encode($client_record['id']).'/'.$attachment['heading'])); ?>"><?php echo e($attachment['heading']); ?></a></li>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php endif; ?>
                </ul>
            </div>  
               
            </div>
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
       <?php endif; ?>     <!-- /.box-header -->
         
       <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Id</th>
              <th>Heading</th>
              <th>Attachment</th>
              <th>Download</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
          <?php if(isset($attachments)): ?>
            <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($i++); ?></td>
              <td></a><?php echo e($attachment['heading']); ?></td>
              <td></a><?php echo e($attachment['file']); ?></td>
              <td><a href="<?php echo e(asset('uploads/attachments/' . $attachment['file'])); ?>" title="Download Document" class="btn btn-default btn-xs" download><i class="fa fa-cloud-download"></i></td>
              <td>
                 <?php if($attachment['common_user_id'] == Auth::user()->id): ?>
                  <a href="<?php echo e(url('manager/edit-attachment/'.Hashids::encode($attachment['id']).'/'.Hashids::encode($client_record['id']))); ?>" class="btn btn-info">
                   Edit
                 </a>
                   <button class="btn btn-danger btn-delete delete-employee" value="<?php echo e($attachment['id']); ?>">Delete</button>
                 <?php else: ?>
                
                 <?php endif; ?>  
              </td> 
          </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
          <?php endif; ?>
        </tbody>
        
      </table>
          </div>
          <!-- /. box -->
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<meta name="_token" content="<?php echo csrf_token(); ?>" />
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<script>
var url = "<?php echo e(url('manager/delete-attachment')); ?>";
$(document).on('click','.delete-employee',function(){
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
<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>