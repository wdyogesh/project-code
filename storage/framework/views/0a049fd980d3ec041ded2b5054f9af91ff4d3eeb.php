<?php $__env->startSection('admin-title'); ?>
Admin-Subscriptions
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-pagelevel-styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
  <section class="content">
  <div class="alert alert-success alert-dismissable" id="successMessageDiv" style="display: none;">
         <i class="fa fa-check"></i>
         <b>Record Updated Success!</b>
         <span class="sucmsgdiv"></span>                     
       </div>
      <div class="row">
      <?php if(Session::has('error')): ?>
          <div  align="center" id="successMessage" class="alert alert-danger"><?php echo e(Session::get('error')); ?>

          </div>
      <?php endif; ?>
      <div class="col-md-2">
      </div>
        <div class="col-md-6">
           
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Edit Subscription Package</h3>
            </div>
             <form action="<?php echo e(url('admin/subscription-update')); ?>" class="-bootstrap-modal-form" method="post">
             <?php echo e(csrf_field()); ?>

            <div class="box-body">
              <!--User Size form-->
              <div class="form-group">
                <label>Package Name:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                   <!--  <i class="fa fa-user"></i> -->
                  </div>
                  <input type="text" class="form-control" name="package_name" value="<?php echo e($edit_record['package_name']); ?>" placeholder="Enter Package Name">
                   <span class="text-danger"><?php echo e($errors->first('package_name')); ?></span>
                </div>
              </div>
              <!--User Size to-->
              <div class="form-group">
                <label>Data Size:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i><b>GB</b></i>
                  </div>
                  <input type="text" class="form-control" name="data_size" value="<?php echo e($edit_record['data_size']); ?>" placeholder="Enter Data Size" >
                   <span class="text-danger"><?php echo e($errors->first('data_size')); ?></span>
                </div>
              </div>
              <div class="form-group">
                <label>User Size From:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="number" class="form-control" name="user_size_from" value="<?php echo e($edit_record['user_size_from']); ?>" placeholder="Users Count From" min="1">
                  <span class="text-danger"><?php echo e($errors->first('user_size_from')); ?></span>
                </div>
              </div>
              <!--User Size to-->
              <div class="form-group">
                <label>User Size To:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="number" class="form-control" name="user_size_to" value="<?php echo e($edit_record['user_size_to']); ?>" placeholder="Users Count To" min="1">
                  <span class="text-danger"><?php echo e($errors->first('user_size_to')); ?></span>
                </div>
              </div>

               <div class="form-group">
                <label>Price:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-dollar"></i>
                  </div>
                  <input type="text" class="form-control" name="price" value="<?php echo e($edit_record['price']); ?>" placeholder="Price">
                  <span class="text-danger"><?php echo e($errors->first('price')); ?></span>
                </div>
              </div>
              <input type="hidden" name="package_id" value="<?php echo e($edit_record['id']); ?>">

              <div class="form-group">
                <div class="input-group">
                  <button type="submit" class="btn btn-success">UPDATE</button>
                </div>
              </div>
             </form>
            </div>
            <!-- /.box-body -->
            </form>
          </div>
          <!-- /.box -->

          
          <!-- /.box -->

        </div>
      </div>
      <!-- /.row -->
  </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-pagelevel-script'); ?>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>