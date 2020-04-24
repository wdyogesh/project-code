<?php $__env->startSection('title'); ?>
Business Manager-Account Settings-Change Password
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
  <section class="content-header">
     <!--  <h1>
        Settings
        <small>Preview</small>
      </h1> -->
      <ol class="breadcrumb">
        <li><a href="<?php echo e(url('/')); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo e(url('employee/dashboard')); ?>">Dashboard</a></li>
        <li class="active">Settings(change password)</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
           <?php if(Session::has('success')): ?>
            <div  align="center" id="successMessage"  class="alert alert-info"><?php echo e(Session::get('success')); ?>

            </div>
            <?php endif; ?>
        <div class="col-md-2">
        </div>
        <!--change passsword start-->
           <div class="col-md-6">
          <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Change Password</h3>
                </div>
                <form class="form-horizontal" action="<?php echo e(url('employee/change-password')); ?>" method="post">
                <?php echo csrf_field(); ?>

                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Enter Password</label>

                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputEmail3" name="password" value="<?php echo e(old('password')); ?>" placeholder="Password">
                      </div>
                      <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Re Enter Password</label>

                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword3" name="repassword" value="<?php echo e(old('repassword')); ?>" placeholder="Password">
                      </div>
                      <span class="text-danger"><?php echo e($errors->first('repassword')); ?></span>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">Update</button>
                  </div>
                </form>
              </div>
        </div>
        <!--change password end-->
      </div>
      <!-- /.row -->
    </section>
 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.employee.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>