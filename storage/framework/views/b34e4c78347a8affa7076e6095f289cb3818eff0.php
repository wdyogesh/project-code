<?php $__env->startSection('title'); ?>
Business Manager-Client Edit
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
       Mr <?php echo e($client_record['name']); ?> <?php echo e($client_record['surname']); ?> / Client Notes
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
          <?php echo $__env->make('frontend.business-manager.client-management.client-details-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          </div>
        
        </div>
    
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Note</h3>

            </div>
            <!-- /.box-header -->
           
     <form action="<?php echo e(url('manager/update-notes')); ?>" class="-bootstrap-modal-form form-horizontal" method="post" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <div class="modal-body">
              <div class="box-body">
                <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                  <label name="login_error"></label>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Template:</label>
                  <div class="col-sm-9">
                    <select class="form-control" name="consultation_type">
                      <option value="Initial Consultation" <?php if($notes['consultation_type'] == 'Initial Consultation'): ?> selected="select" <?php endif; ?>>Initial Consultation</option>
                      <option value="Standard Consultation" <?php if($notes['consultation_type'] == 'Standard Consultation'): ?> selected="select" <?php endif; ?>>Standard Consultation</option>
                    </select>  
                  </div>
                  <span class="text-danger"><?php echo e($errors->first('consultation_type')); ?></span>  
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Appointment:</label>
                  <div class="col-sm-9">
                  <select class="form-control" name="appointments">
                      <option value="">None</option>
                      <?php if(isset($apointment_details)): ?>
                    <?php $__currentLoopData = $apointment_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($appointment['appointment_id']); ?>" <?php if($notes['appointment_id'] == $appointment['appointment_id']): ?> selected="select" <?php endif; ?>><?php echo e($appointment['appointment_date']); ?>[<?php echo e($appointment['client_name']); ?>]</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>  
                    </select>  
                     <span class="text-danger"><?php echo e($errors->first('appointments')); ?></span>  
                  </div>
                 
                </div>



                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Category:</label>
                  <div class="col-sm-9">
                    <select class="form-control select2" name="category_name">
                      <option value="">Select Category</option>
                      <?php $__currentLoopData = $notes_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($category->id); ?>"  <?php if($notes['category_name'] == $category->id): ?> selected="select" <?php endif; ?>><?php echo e($category->category_name); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>  
                    <span class="text-danger"><?php echo e($errors->first('category_name')); ?></span>  
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Notes:</label>
                  <div class="col-sm-9">
                    <textarea id="compose-textarea" class="form-control" name="notes" style="height: 300px"><?php echo $notes['notes']; ?></textarea>
                    <span class="text-danger"><?php echo e($errors->first('notes')); ?></span>
                  </div>
                </div>


               <!--  <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Attach File:</label>
                  <div class="col-sm-9">
                              <input type="file" name="attachment" class="form-control">
                              </div>
                              <span class="text-danger"><?php echo e($errors->first('attachment')); ?></span>
                  </div>

                </div>

                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Add Above Attached File Name:</label>
                 <div class="col-sm-9">
                  <input type="text" name="add_attached_file_name" class="form-control" placeholder="Enter Attached Filename">
                  <span class="text-danger"><?php echo e($errors->first('add_attached_file_name')); ?></span>
                  </div>
                              
                  </div>
                </div> -->

                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Other Party:</label>
                <div class="col-sm-9">
                  <select class="form-control" name="other_party">
                    <option value="">Link Other Party</option>
                    <?php if(isset($otherparties)): ?>
                    <?php $__currentLoopData = $otherparties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otherpartie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($otherpartie['id']); ?>"  <?php if($notes['other_party_id'] == $otherpartie['id']): ?> selected="select" <?php endif; ?>><?php echo e($otherpartie['user_name']); ?> [<?php echo e($otherpartie['category_name']); ?>]</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                  </select>  
                  <span class="text-danger"><?php echo e($errors->first('other_party')); ?></span>  
                </div>
              </div>

               <input type="hidden" name="notes_id" value="<?php echo e($notes->id); ?>">
               <input type="hidden" name="client_name" value="<?php echo e($notes->client_id); ?>">
                <div class="form-group" align="center">
                <!--   <a href="<?php echo e(url('manager/manage-client-notes')); ?>" class="btn btn-info">
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
<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>