<?php $__env->startSection('title'); ?>
Business Manager-Practionar availability
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<!-- new date picker style start-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>  
<!-- new date picker style start-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			
			<!-- /.box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Editing <?php echo e($practionar['name']); ?> <?php echo e($practionar['surname']); ?> availability</h3>
				</div>
				<div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              
         
            <div class="col-md-1">
                <div class="dropdown">
                  <a href="<?php echo e(url('manager/face-to-face-consultant-availability/'.$hashemployeeid)); ?>" class="btn <?php echo e(Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid) ? 'btn-warning' : 'btn-default'); ?>"><span class="">Sunday</span></a>
                </div>
            </div>

            <div class="col-md-1">
                <div class="dropdown">
                  <a href="<?php echo e(url('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'mon')); ?>" class="btn <?php echo e(Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'mon') ? 'btn-warning' : 'btn-default'); ?>"><span class="">Monday</span></a>
                </div>
            </div>
            <div class="col-md-1">
                <div class="dropdown">
                <a href="<?php echo e(url('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'tue')); ?>" class="btn <?php echo e(Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'tue') ? 'btn-warning' : 'btn-default'); ?>"><span class="">Tuesday</span></a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="dropdown">
                  <a href="<?php echo e(url('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'wed')); ?>" class="btn <?php echo e(Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'wed') ? 'btn-warning' : 'btn-default'); ?>"><span class="">Wednesday</span></a>
                </div>
            </div>
              
            <div class="col-md-1">
                <div class="dropdown">
                  <a href="<?php echo e(url('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'thu')); ?>" style="margin-left: -60px;" class="btn <?php echo e(Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'thu') ? 'btn-warning' : 'btn-default'); ?>"><span class="">Thursday</span></a>
                </div>
            </div>

            <div class="col-md-1">
                <div class="dropdown">
                  <a href="<?php echo e(url('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'fri')); ?>" style="margin-left: -53px;" class="btn <?php echo e(Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'fri') ? 'btn-warning' : 'btn-default'); ?>"><span class="">Friday</span></a>
                </div>
            </div>

            <div style="margin-left: -65px;" class="col-md-1">
                <div class="dropdown">
                 <a href="<?php echo e(url('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'sat')); ?>" class="btn <?php echo e(Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'sat') ? 'btn-warning' : 'btn-default'); ?>"><span class="">Saturday</span></a>
                </div>
            </div>
             
           
            </div>
            <!-- /.box-header -->
       
				<!-- /.box-header -->
				<div class="box-body">
					<?php if(Session::has('fail')): ?>
					<div  align="center" id="successMessage" class="alert alert-danger"><?php echo e(Session::get('fail')); ?>

					</div>
					<?php endif; ?>
					<?php if($errors->any()): ?>
				    <div class="alert alert-danger">
				        <ul>
				            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				                <li><?php echo e($error); ?></li>
				            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				        </ul>
				    </div>
				    <?php endif; ?>
					<form action="<?php echo e(url('manager/face-to-face-consultant-availability')); ?>" class="-bootstrap-modal-form form-horizontal" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="modal-body">
							<div class="box-body">
                    <!--  //availability time-->

                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Availability Time:</label>
								<div class="col-sm-8">

									<div class="col-sm-3 bootstrap-timepicker">
									  <input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="availability_start_time" value="<?php echo e(old('availability_start_time')); ?>">
						            </div>
		

							         <div class="col-sm-1" style="margin-left: -2px;margin-top: 4px;">
							         --
							         </div>

					                <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter End Time" name="availability_end_time" value="<?php echo e(old('availability_end_time')); ?>">
						            </div>
								</div>
						</div>
	                <!--  //availability time end -->
                  
	                <!--  //break1 time-->
                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Break-1:</label>
								<div class="col-sm-8">
									<div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="break1_start_time" value="<?php echo e(old('break1_start_time')); ?>">
						            </div>
						           

						           <div class="col-sm-1" style="margin-left: -2px;margin-top: 4px;">--</div>
					                <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter End Time" name="break1_end_time" value="<?php echo e(old('break1_end_time')); ?>">
						            </div>
									
								</div>
						</div>
	                <!--  //break1 time end -->

	                <!--  //break2 time-->
                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Break-2:</label>
								<div class="col-sm-8">
									<div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="break2_start_time" value="<?php echo e(old('break2_start_time')); ?>">
									</div>
						           

						        <div class="col-sm-1" style="margin-left: -2px;margin-top: 4px;">--</div>
					                <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter End Time" name="break2_end_time" value="<?php echo e(old('break2_end_time')); ?>">
						            </div>
									
								</div>
						</div>
	                <!--  //break2 time end -->

	                <!--  //break3 time-->
                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Break-3:</label>
								<div class="col-sm-8">
									<div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="break3_start_time" value="<?php echo e(old('break3_start_time')); ?>">
									</div>
						           

						       <div class="col-sm-1" style="margin-left: -2px;margin-top: 4px;">--</div>


								<div class="col-sm-3 bootstrap-timepicker">
								<input type="text" class="form-control timepicker" id="break3_end_time" placeholder="Enter End Time" name="break3_end_time" value="<?php echo e(old('break3_end_time')); ?>">
								</div>
						           
									
								</div>
						</div>
	                <!--  //break3 time end -->
                  
                           <input type="hidden" name="dayname" value="<?php echo e($dayname); ?>">
                           <input type="hidden" name="practionar_id" value="<?php echo e($practionar_id); ?>">
                           <div class="form-group" style="margin-left: 306px;">
                           	<button type="submit" class="btn btn-success">Update</button>
							</div>
								

								</div>
							</div>
							
						</form>
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
     <script type="text/javascript">
	  $('.colorpicker').colorpicker();

	  //$('#start_time').timepicker({defaultTime: '07:00 AM'});

	</script>
	<!-- <script type="text/javascript">
		function valueChanged()
    {
        if($('.coupon_question').is(":checked"))   
            $(".add_breakes").show();
        else
            $(".add_breakes").hide();
    }
	</script> -->
	
	<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></div>
	                <!--  //break2 time end -->

	                <!--  //break3 time-->
                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Break-3:</label>
								<div class="col-sm-8">
								 <?php if($break3_start_time == ""): ?>
									<div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="break3_start_time" value="<?php echo e(old('break3_start_time')); ?>">
									</div>
							    <?php else: ?>
							        <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="break3_start_time" value="<?php echo e($break3_start_time); ?>">
									</div>
							    <?php endif; ?>		
						           

						       <div class="col-sm-1" style="margin-left: -2px;margin-top: 4px;">--</div>

                               <?php if($break3_end_time == ""): ?>
								<div class="col-sm-3 bootstrap-timepicker">
								<input type="text" class="form-control timepicker" id="break3_end_time" placeholder="Enter End Time" name="break3_end_time" value="<?php echo e(old('break3_end_time')); ?>">
								</div>
							  <?php else: ?>
							  <div class="col-sm-3 bootstrap-timepicker">
								<input type="text" class="form-control timepicker" id="break3_end_time" placeholder="Enter End Time" name="break3_end_time" value="<?php echo e($break3_end_time); ?>">
							  <?php endif; ?>	
						           
									
								</div>
						</div>
	                <!--  //break3 time end -->
                          
                           <input type="hidden" name="when_update_record_employee_id" value="<?php echo e($practionar_employee_id); ?>">
                        
                           <input type="hidden" name="dayname" value="<?php echo e($dayname); ?>">
                           <input type="hidden" name="practionar_id" value="<?php echo e($practionar_id); ?>">
                           <input type="hidden" name="hashemployeeid" value="<?php echo e($hashemployeeid); ?>">
                           <div class="form-group" style="margin-left: 306px;">
                           	<button type="submit" class="btn btn-success">Update</button>
							</div>
								

								</div>
							</div>
							
						</form>
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
     <script type="text/javascript">
	  $('.colorpicker').colorpicker();

	/* $('.timepicker').timepicker({defaultTime: ''});*/

	</script>
	<!-- <script type="text/javascript">
		function valueChanged()
    {
        if($('.coupon_question').is(":checked"))   
            $(".add_breakes").show();
        else
            $(".add_breakes").hide();
    }
	</script> -->
	
	<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>