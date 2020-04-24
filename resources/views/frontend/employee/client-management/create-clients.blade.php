@extends('frontend.employee.layouts.master')
@section('title')
Business Employee-Create Client
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
                    <h3 class="box-title">Create Client</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                   @if (Session::has('fail'))
                   <div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
                   </div>
                   @endif
                   <form action="{{url('employee/store-client')}}" class="bootstrap-modal-form form-horizontal" method="post">
                       {{ csrf_field() }}
                      <div class="modal-body">
                        <div class="box-body">
                          <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                          </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Client Name" name="client_name" value="{{old('client_name')}}" maxlength="30">
                                    <span class="text-danger">{{ $errors->first('client_name') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Sur Name</label>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Sur Name" name="surname" value="{{old('surname')}}" maxlength="20">
                                    <span class="text-danger">{{ $errors->first('surname') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Client Email" name="client_email" value="{{old('client_email')}}" maxlength="30">
                                    <span class="text-danger">{{ $errors->first('client_email') }}</span>
                                </div>
                            </div>

                           <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-5">
                    <select id="country" name="country" class="form-control">
                            <option value="">Select Country
                              </option>
                            @foreach($countries as $key => $country)
                              
                              <option value="{{$country}}"> {{$country}}
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
                    </select>
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                  </div>  
                </div>

                  <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Type City</label>
                  <div class="col-sm-5">
                    <select name="city" id="city" class="form-control">
                    <option value="">Select City</option>
                                        </select>
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                  </div>
                  
                </div>
                  
                </div>

                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Country Code</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="country_code" placeholder="Enter Country Code" name="country_code" value="{{old('country_code')}}" maxlength="6" onkeypress="return isNumberKey(event)" readonly>
                    <span class="text-danger">{{ $errors->first('country_code') }}</span>
                  </div>  
                </div>


                                <div class="form-group">                  
                                <label for="inputEmail3" class="col-sm-2 control-label">Phone Number</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Phone Number" name="phone_number" value="{{old('phone_number')}}" maxlength="10" onkeypress="return isNumberKey(event)">
                                    <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                </div>
                                </div>

                            <div class="form-group">                  
                                <label for="inputEmail3" class="col-sm-2 control-label">Date of birth</label>
                                <div class="col-sm-5">
                                    <div class="input-group date">
                                    <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker" name="dateof_birth" value="{{old('dateof_birth')}}">
                                  </div>
                                    <span class="text-danger">{{ $errors->first('dateof_birth') }}</span>
                                </div>
                            </div>


                            <!-- <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-5">
                            <textarea class="form-control" rows="3" placeholder="Enter Address..." name="address" maxlength="200">{{old('address')}}</textarea>
                            <span class="text-danger">{{ $errors->first('address') }}</span>
                            </div>
                            </div>
 -->
                            <div class="form-group" align="center">
                    <a href="{{url('employee/clients')}}" class="btn btn-info">
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

@endsection
@section('pagelevel-script')
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
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
<script>
    function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
      return true;
    }    
  </script>
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
