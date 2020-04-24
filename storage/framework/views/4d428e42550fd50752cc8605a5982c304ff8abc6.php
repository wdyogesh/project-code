<?php $__env->startSection('admin-title'); ?>
Admin-Settings
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
              <h3 class="box-title">Settings Management Comming Soon.....</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             
            <div  align="center" id="successMessage" class="alert alert-success">Settings Management Comming Soon.....
            </div>
           
         
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
<?php $__env->startSection('pagelevel-script'); ?>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<script>
$("#edit").click(function (e) {

  alert($('#edit').val());

});
  </script>
  <script>
$(document).ready(function(){
     $("#select_security_question").change(function() {
   var val = $(this).val();
   if (val != "") {
      $("#admDivCheck").show();
   }
});
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>