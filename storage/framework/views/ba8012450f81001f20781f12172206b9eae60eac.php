<?php $__env->startSection('title'); ?>
Business Manager-Create Employee
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
					<h3 class="box-title">Appointment Settings</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<?php if(Session::has('fail')): ?>
					<div  align="center" id="successMessage" class="alert alert-danger"><?php echo e(Session::get('fail')); ?>

					</div>
					<?php endif; ?>
					<form action="<?php echo e(url('manager/appointment-settings')); ?>" class="bootstrap-modal-form form-horizontal" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="modal-body">
							<div class="box-body">
								<div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                                </div>
                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Slot Duration:</label>
								<div class="col-sm-8">
									<div class="col-sm-2">
										<select id="country" name="time_slot_size" class="form-control">
										  <option value="10">10</option>
						                  <option value="15">15</option>
						                  <option value="30">30</option>
						                </select>
						            </div>
								</div>
								</div>
                              <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                                </div>
                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Calendar time range:</label>
								<div class="col-sm-8">
									<div class="col-sm-2">
										<select id="country" name="business_time_start" class="form-control">
						                  <option value="0">0</option>
						                  <option value="1">1</option>
						                  <option value="2">2</option>
						                  <option value="3">3</option>
						                  <option value="4">4</option>
						                  <option value="5">5</option>
						                  <option value="6">6</option>
						                  <option value="7">7</option>
						                  <option value="8">8</option>
						                  <option value="9">9</option>
						                  <option value="10">10</option>
						                  <option value="11">11</option>
						                  <option value="12">12</option>
						                  <option value="13">13</option>
						                  <option value="14">14</option>
						                  <option value="15">15</option>
						                  <option value="16">16</option>
						                  <option value="17">17</option>
						                  <option value="18">18</option>
						                  <option value="19">19</option>
						                  <option value="20">20</option>
						                  <option value="21">21</option>
						                  <option value="22">22</option>
						                  <option value="23">23</option>
						                </select>
						            </div>
						            <div class="col-sm-1" style="margin-top: 5px;margin-left: -17px;">:00</div>
						            <div class="col-sm-1" style="margin-left: -22px;margin-top: 4px;">--</div>
						            <div class="col-sm-2">
										<select id="country" name="business_time_end" class="form-control" style="margin-left: -30px;">
						                  <option value="1">1</option>
						                  <option value="2">2</option>
						                  <option value="3">3</option>
						                  <option value="4">4</option>
						                  <option value="5">5</option>
						                  <option value="6">6</option>
						                  <option value="7">7</option>
						                  <option value="8">8</option>
						                  <option value="9">9</option>
						                  <option value="10">10</option>
						                  <option value="11">11</option>
						                  <option value="12">12</option>
						                  <option value="13">13</option>
						                  <option value="14">14</option>
						                  <option value="15">15</option>
						                  <option value="16">16</option>
						                  <option value="17">17</option>
						                  <option value="18">18</option>
						                  <option value="19">19</option>
						                  <option value="20">20</option>
						                  <option value="21">21</option>
						                  <option value="22">22</option>
						                  <option value="23">23</option>
						                  <option value="24">24</option>
						                </select>
						             </div>
						             <div class="col-sm-1" style="margin-top: 5px;
    margin-left: -50px;">:00</div>
									</div>
								</div>

							 <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Advance Booking Weeks:</label>
								<div class="col-sm-8">
									<div class="col-sm-2">
										<select id="country" name="advance_booking_weeks" class="form-control">
										  <option value="1">1</option>
						                  <option value="2">2</option>
						                </select>
						            </div>
								</div>
								</div>	

						     <div class="form-group">                  
								<label for="inputEmail3" class="col-sm-2 control-label">Appointment Color(Arrived):</label>
								<div class="col-sm-8">
								      <div id="cp2" class="input-group colorpicker colorpicker-component"> 
									      <input type="text" name="color_arrived" value="#00AABB" class="form-control"/> 
									      <span class="input-group-addon"><i></i></span> 
									    </div>
						          
								</div>
								</div>	

								 <div class="form-group">                  
								<label for="inputEmail3" class="col-sm-2 control-label">Appointment Color(In Process):</label>
								<div class="col-sm-8">
								      <div id="cp2" class="input-group colorpicker colorpicker-component"> 
									      <input type="text" name="color_in_process" value="#00AABB" class="form-control"/> 
									      <span class="input-group-addon"><i></i></span> 
									    </div>
						          
								</div>
								</div>	

								 <div class="form-group">                  
								<label for="inputEmail3" class="col-sm-2 control-label">Appointment Color(Seen):</label>
								<div class="col-sm-8">
								      <div id="cp2" class="input-group colorpicker colorpicker-component"> 
									      <input type="text" name="color_in_seen" value="#00AABB" class="form-control"/> 
									      <span class="input-group-addon"><i></i></span> 
									    </div>
						          
								</div>
								</div>	

								 <div class="form-group">                  
								<label for="inputEmail3" class="col-sm-2 control-label">Appointment Color(DNA):</label>
								<div class="col-sm-8">
								      <div id="cp2" class="input-group colorpicker colorpicker-component"> 
									      <input type="text" name="color_in_dna" value="#00AABB" class="form-control"/> 
									      <span class="input-group-addon"><i></i></span> 
									    </div>
						          
								</div>
								</div>

								<div class="form-group">                  
								<label for="inputEmail3" class="col-sm-2 control-label">Appointment Color(Booked):</label>
								<div class="col-sm-8">
								      <div id="cp2" class="input-group colorpicker colorpicker-component"> 
									      <input type="text" name="color_in_booked" value="#00AABB" class="form-control"/> 
									      <span class="input-group-addon"><i></i></span> 
									    </div>
						          
								</div>
								</div>		
                           <div class="form-group" style="margin-left: 206px;">
                           	<button type="submit" class="btn btn-success">Submit</button>
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
	</script>
	<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>