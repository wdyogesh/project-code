@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Edit Employee
@endsection
@section('pagelevel-styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			
			<!-- /.box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Edit Employee</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if (Session::has('fail'))
					<div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
					</div>
					@endif
					<form action="{{url('manager/update-employee')}}" class="bootstrap-modal-form form-horizontal" method="post">
						{{ csrf_field() }}
						<div class="modal-body">
							<div class="box-body">
                              <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                                </div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Select Role</label>
									<div class="col-sm-5">
										<select class="form-control" id="" name="role_name">
											<option value="" selected>select..</option>
											@foreach($business_managers_employee_roles as $business_managers_employee_role)
											<option value="{{$business_managers_employee_role->id}}" @if($employee_record['id'] == $business_managers_employee_role->id) selected="select" @endif >{{$business_managers_employee_role->employee_role_name}}</option>
											@endforeach
										</select>
										<span class="text-danger">{{ $errors->first('role_name') }}</span>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">First Name</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Employee Name" name="employee_name" value="{{ucfirst($employee_record['name'])}}" maxlength="25">
										<span class="text-danger">{{ $errors->first('employee_name') }}</span>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Sur Name</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Surname" name="surname" value="{{ucfirst($employee_record['surname'])}}" maxlength="20">
										<span class="text-danger">{{ $errors->first('surname') }}</span>
									</div>			
								</div>

									<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Date of birth</label>

									<div class="col-sm-5">
										<input type="text" class="form-control" name="dateof_birth" id="datepicker" placeholder="DD/MM/YYYY " value="{{$employee_record['dateof_birth']}}" maxlength="30">
										<span class="text-danger">{{ $errors->first('dateof_birth') }}</span>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Email</label>

									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Employee Email" name="employee_email" value="{{$employee_record['email']}}" maxlength="30" readonly>
										<span class="text-danger">{{ $errors->first('employee_email') }}</span>
									</div>
								</div>

								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Select Country</label>
									<div class="col-sm-5">
									<select id="country" name="country" class="form-control">
									<option value="">Select Country
						                  </option>
									@foreach($countries as $key => $country)
								        <option value="{{$country}}"  @if($country == $employee_record['country']) selected="select" @endif >
											{{$country}}
										</option>
									@endforeach
			                        </select>
				
									<span class="text-danger">{{ $errors->first('country') }}</span>
									</div>
								</div>

								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Select State</label>
									<div class="col-sm-5">
										<select id="state" name="state" class="form-control" >
										<option value="">Select State</option>
									@if($selected_countery_all_states_foreah != "")
										@foreach($selected_countery_all_states_foreah as $key => $state)
										<option value="{{$state}}"  @if($state == $employee_record['state']) selected="select" @endif>{{$state}}
										</option>
									    @endforeach
									@else
									@endif    


										</select>
										<span class="text-danger">{{ $errors->first('state') }}</span>
									</div>
								</div>

								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Select City</label>
									<div class="col-sm-5">
										<select id="city" name="city" class="form-control" >
										<option value="">Select City</option>
										@if($selected_state_all_cities_foreah != "")
										@foreach($selected_state_all_cities_foreah as $key => $city)
										<option value="{{$city}}"  @if($city == $employee_record['city']) selected="select" @endif>{{$city}}
										</option>
									    @endforeach
									    @else
									    @endif
									   

										</select>
										<span class="text-danger">{{ $errors->first('city') }}</span>
									</div>
								</div>

								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Country Code</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="country_code" placeholder="Enter Country Code" name="country_code" value="{{$employee_record['country_code']}}" maxlength="6" onkeypress="return isNumberKey(event)" readonly>
										<span class="text-danger">{{ $errors->first('country_code') }}</span>
									</div>
								</div>

                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Area Code</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Area Code" name="area_code" value="{{$employee_record['area_code']}}" maxlength="6" onkeypress="return isNumberKey(event)">
										<span class="text-danger">{{ $errors->first('area_code') }}</span>
									</div>
								</div> 
								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Phone Number</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Phone Number" name="phone_number" value="{{$employee_record['phone_number']}}" maxlength="10" onkeypress="return isNumberKey(event)">
										<span class="text-danger">{{ $errors->first('phone_number') }}</span>
									</div>
								</div>

								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Pincode</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Pin Code" name="pincode" value="{{$employee_record['pincode']}}" maxlength="6"> 
										<span class="text-danger">{{ $errors->first('pincode') }}</span>
									</div>
									
								</div>

								<input type="hidden" name="employee_id" value="{{$employee_record['main_user_id']}}">
			@if($employee_record['id'] == 5)
				<input type="hidden" name="admin_role_identify" value="admin">
			@else
			    <input type="hidden" name="admin_role_identify" value="other">
			@endif

							 <div class="form-group" align="center">
								<a href="{{url('manager/employees')}}" class="btn btn-info">
									Go back
								</a>
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
	
	@endsection
@section('pagelevel-script')
	<!-- new date picker script start-->
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker").datepicker({changeYear: true, changeMonth: true, maxDate: '0', yearRange: "1950:2003"});
  } );
  </script>
 <!--  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  } );
  </script> -->
  	<!-- new date picker script end-->
	<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
	<script>
		$("#edit").click(function (e) {

			alert($('#edit').val());

		});
	</script>
	<!-- <script src="{{asset('js/country-states.js')}}"></script>
	<script type="text/javascript">
		$(window).on('load', function() {
		var database_country="{{$employee_record['country']}}";
		  $('#country').val(database_country);
		  //alert(country_arr);
		})
	</script>
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
           url:"{{url('api/get-state-list')}}?country="+country,
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
           url:"{{url('api/get-city-list')}}?state="+state,
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
var countryurl = "{{url('api/country-and-codes')}}";
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
@endsection
