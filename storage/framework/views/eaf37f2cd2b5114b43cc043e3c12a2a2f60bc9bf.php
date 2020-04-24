<?php $__env->startSection('title'); ?>
Business Employee-Client Edit
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
       Mr <?php echo e($client_record['name']); ?> <?php echo e($client_record['surname']); ?> / Client details
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
              <h3 class="box-title">Edit Client</h3>

            </div>
            <!-- /.box-header -->
           
       <form action="<?php echo e(url('employee/update-client')); ?>" class="bootstrap-modal-form form-horizontal" method="post">
            <?php echo e(csrf_field()); ?>

                       <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Client Name" name="client_name" value="<?php echo e($managers_client_record['name']); ?>" maxlength="30">
                                    <span class="text-danger"><?php echo e($errors->first('client_name')); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Sur Name</label>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Sur Name" name="surname" value="<?php echo e($managers_client_record['surname']); ?>" maxlength="20">
                                    <span class="text-danger"><?php echo e($errors->first('surname')); ?></span>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Client Email" name="client_email" value="<?php echo e($managers_client_record['email']); ?>" maxlength="30"  readonly>
                                    <span class="text-danger"><?php echo e($errors->first('client_email')); ?></span>
                                </div>
                            </div>
  <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Select Country</label>
                  <div class="col-sm-5">
                  <select id="country" name="country" class="form-control">
                  <option value="">Select Country
                              </option>
                  <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($country); ?>"  <?php if($country == $managers_client_record['country']): ?> selected="select" <?php endif; ?> >
                      <?php echo e($country); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
        
                  <span class="text-danger"><?php echo e($errors->first('country')); ?></span>
                  </div>
                </div>

                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Select State</label>
                  <div class="col-sm-5">
                    <select id="state" name="state" class="form-control" >
                    <option value="">Select State</option>
                    <?php if($selected_countery_all_states_foreah != ""): ?>
                    <?php $__currentLoopData = $selected_countery_all_states_foreah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($state); ?>"  <?php if($state == $managers_client_record['state']): ?> selected="select" <?php endif; ?>><?php echo e($state); ?>

                    </option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <?php endif; ?>  
                    </select>
                    <span class="text-danger"><?php echo e($errors->first('state')); ?></span>
                  </div>
                </div>

                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Select City</label>
                  <div class="col-sm-5">
                    <select id="city" name="city" class="form-control" >
                    <option value="">Select City</option>
                    <?php if($selected_state_all_cities_foreah != ""): ?>
                    <?php $__currentLoopData = $selected_state_all_cities_foreah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($city); ?>"  <?php if($city == $managers_client_record['city']): ?> selected="select" <?php endif; ?>><?php echo e($city); ?>

                    </option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <?php endif; ?>   
                    </select>
                    <span class="text-danger"><?php echo e($errors->first('city')); ?></span>
                  </div>
                </div>

                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Country Code</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="country_code" placeholder="Enter Country Code" name="country_code" value="<?php echo e($managers_client_record['country_code']); ?>" maxlength="6" onkeypress="return isNumberKey(event)" readonly>
                    <span class="text-danger"><?php echo e($errors->first('country_code')); ?></span>
                  </div>
                </div>


                            <div class="form-group">                  
                                <label for="inputEmail3" class="col-sm-2 control-label">Phone Number</label>
                                  <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Phone Number" name="phone_number" value="<?php echo e($managers_client_record['phone_number']); ?>" maxlength="10" onkeypress="return isNumberKey(event)">
                                    <span class="text-danger"><?php echo e($errors->first('phone_number')); ?></span>
                                </div>
                            </div>

                            <div class="form-group">                  
                                <label for="inputEmail3" class="col-sm-2 control-label">Date of birth</label>
                                <div class="col-sm-5">
                                    <div class="input-group date">
                                    <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker" name="dateof_birth" value="<?php echo e($managers_client_record['dateof_birth']); ?>">
                                  </div>
                                    <span class="text-danger"><?php echo e($errors->first('dateof_birth')); ?></span>
                                </div>
                            </div>
                            <input type="hidden" name="client_id" value="<?php echo e($managers_client_record['client_id']); ?>">
                     <div class="modal-footer" align="center">
                   <!--  <a href="<?php echo e(url('employee/clients')); ?>" class="btn btn-info">
                       Go back
                   </a> -->
                   <button type="submit" class="btn btn-success">Update</button>
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
<!-- email template script for checkbox start-->
<script>
  $(function () {
    //Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.mailbox-messages input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
        //Check all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }
      $(this).data("clicks", !clicks);
    });

    //Handle starring for glyphicon and font awesome
    $(".mailbox-star").click(function (e) {
      e.preventDefault();
      //detect type
      var $this = $(this).find("a > i");
      var glyph = $this.hasClass("glyphicon");
      var fa = $this.hasClass("fa");

      //Switch states
      if (glyph) {
        $this.toggleClass("glyphicon-star");
        $this.toggleClass("glyphicon-star-empty");
      }

      if (fa) {
        $this.toggleClass("fa-star");
        $this.toggleClass("fa-star-o");
      }
    });
  });
</script>
<!-- email template script for checkbox end-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.employee.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>