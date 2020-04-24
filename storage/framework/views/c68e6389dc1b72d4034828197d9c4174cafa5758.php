<?php $__env->startSection('title'); ?>
Business Employee-Client Create
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<style type="text/css">
.manager-content-wrapper{margin-left: 0;}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper manager-content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <?php echo e($client_record['name']); ?> <?php echo e($client_record['surname']); ?> / Client Notes
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
         <!--  <a href="<?php echo e(url('manager/compose-message')); ?>" class="btn btn-primary btn-block margin-bottom">Compose</a>
 -->
          <div class="box box-solid">
            <div class="box-header with-border">
             <!--  <h3 class="box-title">Folders</h3> -->

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
          <?php echo $__env->make('frontend.employee.client-management.client-details-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          </div>
        
        </div>
    
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">File attachments</h3>

            </div>
            <!-- /.box-header -->
           
     <form action="<?php echo e(url('employee/save-attachment')); ?>" class="-bootstrap-modal-form form-horizontal" method="post" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <div class="modal-body">
              <div class="box-body">
                <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                  <label name="login_error"></label>
                </div>

                 <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Heading:</label>
                 <div class="col-sm-9">
                  <input type="text" name="heading" class="form-control" placeholder="Enter Heading">
                  <span class="text-danger"><?php echo e($errors->first('heading')); ?></span>
                  </div>
                              
                  </div>
                </div>

                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Attach File:</label>
                  <div class="col-sm-9">
                              <input type="file" name="file" class="form-control">
                               <span class="text-danger"><?php echo e($errors->first('file')); ?></span>
                  </div>
                             
                  </div>
                </div>

               
               <input type="hidden" name="client_name" value="<?php echo e($client_record['id']); ?>">
                <div class="form-group" align="center">
                 <!--  <a href="<?php echo e(url('manager/manage-client-notes')); ?>" class="btn btn-info">
                    Go back
                  </a> -->
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>

              </div>
            </div>

          </form>
           
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.employee.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>