<?php $__env->startSection('title'); ?>
Business Manager-Create Employee
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<!-- new date picker style start-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			
			<!-- /.box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Other Party Registration</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<?php if(Session::has('fail')): ?>
					<div  align="center" id="successMessage" class="alert alert-danger"><?php echo e(Session::get('fail')); ?>

					</div>
					<?php endif; ?>
					<form action="<?php echo e(url('employee/store-other-party')); ?>" class="-bootstrap-modal-form form-horizontal" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="modal-body">
							<div class="box-body">
                              <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                                </div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Category</label>
									<div class="col-sm-5">
										<select class="form-control" name="category_name">
											<option value="" selected>select..</option>
											<?php $__currentLoopData = $other_party_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($category->id); ?>"><?php echo e($category->category_name); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
										<span class="text-danger"><?php echo e($errors->first('category_name')); ?></span>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label"> Name</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party Name" name="name" value="<?php echo e(old('name')); ?>" maxlength="25">
										<span class="text-danger"><?php echo e($errors->first('name')); ?></span>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Email</label>

									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party Email" name="email" value="<?php echo e(old('email')); ?>" maxlength="30">
										<span class="text-danger"><?php echo e($errors->first('email')); ?></span>
									</div>
								</div>
								
								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Country</label>
									<div class="col-sm-5">
										<select id="country" name="country" class="form-control">
						                <option value="">Select Country
						                  </option>
						                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						                  
						                  <option value="<?php echo e($country); ?>"> <?php echo e($country); ?>

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
										</select>
										<span class="text-danger"><?php echo e($errors->first('state')); ?></span>
									</div>	
								</div>

                                 <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Type City</label>
									<div class="col-sm-5">
										<select name="city" id="city" class="form-control">
										<option value="">Select City</option>
                                        </select>
                                        <span class="text-danger"><?php echo e($errors->first('city')); ?></span>
									</div>
									
								</div>
								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Country Code</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="country_code" placeholder="Enter Country Code" name="country_code" value="<?php echo e(old('country_code')); ?>" maxlength="6" onkeypress="return isNumberKey(event)" readonly>
										<span class="text-danger"><?php echo e($errors->first('country_code')); ?></span>
									</div>	
								</div>

	                            <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Area Code</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Area Code" name="area_code" value="<?php echo e(old('area_code')); ?>" maxlength="6" onkeypress="return isNumberKey(event)">
										<span class="text-danger"><?php echo e($errors->first('area_code')); ?></span>
									</div>
								</div> 
								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Phone Number</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Phone Number" name="phone_number" value="<?php echo e(old('phone_number')); ?>" maxlength="10" onkeypress="return isNumberKey(event)">
										<span class="text-danger"><?php echo e($errors->first('phone_number')); ?></span>
									</div>	
								</div>

								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Pincode</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Pin Code" name="pincode" value="<?php echo e(old('pincode')); ?>" maxlength="6" onkeypress="return isNumberKey(event)">
										<span class="text-danger"><?php echo e($errors->first('pincode')); ?></span>
									</div>
									
								</div>
                            <div class="form-group" align="center">
								<a href="<?php echo e(url('emplloyee/manage-other-parties')); ?>" class="btn btn-info">
									Go back
								</a>
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
<!-- new date picker script start-->
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker").datepicker({changeYear: true, changeMonth: true, maxDate: '0', yearRange: "-90:+0"});
  } );
  </script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  } );
  </script>
  	<!-- new date picker script end-->
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
	<!-- <script src="<?php echo e(asset('js/country-states.js')); ?>"></script>
	<script language="javascript">
		populateCountries("country", "state");
		populateCountries("country2");
	</script> -->
	<script type="text/javascript">
    $('#country').change(function(){
    var country = $(this).val();    
    if(country){
        $.ajax({
           type:"GET",
           url:"<?php echo e(url('api/get-state-list')); ?>?country="+country,
           success:function(res){               
            if(res){
                 $("#state").empty();
                $("#city").empty();
                $("#state").append('<option>Select</option>');
                $("#city").append('<option>Select</option>');
                $.each(res,function(key,value){
                    $("#state").append('<option value="'+value+'">'+value+'</option>');
                });
           
            }else{
               $("#state").empty();
            }
           }
        });
    }else{
        $("#state").empty();
        $("#city").empty();
    }      
   });
    $('#state').on('change',function(){
    var state = $(this).val();    
    if(state){
        $.ajax({
           type:"GET",
           url:"<?php echo e(url('api/get-city-list')); ?>?state="+state,
           success:function(res){               
            if(res){
                $("#city").empty();
                $("#city").append('<option>Select</option>');
                $.each(res,function(key,value){
                    $("#city").append('<option value="'+value+'">'+value+'</option>');
                });
           
            }else{
               $("#city").empty();
            }
           }
        });
    }else{
        $("#city").empty();
    }
        
   });
</script>
<!-- state city select end -->
<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }    
</script>
<script>
var countryurl = "<?php echo e(url('api/country-and-codes')); ?>";
$(document).ready(function(){
        $('#country').on('change', function(){
             var country_name = $(this).val();
            //alert(country_name);
             if (country_name == '') {
               $('#country_code').val('');                
                $('#country_code_second').val('');
             }else{
              $.ajax({
              type: "GET",
              url: countryurl + '/' + country_name,         
              success: function (data) {
                //alert('hai');
                 /* alert('+' + ' ' + data.countries_isd_code);*/ 
                $('#country_code').val('+' + ' ' + data.phonecode);                
                $('#country_code_second').val('+' + ' ' + data.phonecode);                
                },
                error: function (data) {
                  console.log('Error:', data);
                }
              });
             }
             
    });
});
</script>

	<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.employee.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>