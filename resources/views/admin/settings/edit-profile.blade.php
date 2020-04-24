@extends('admin.layouts.master')
@section('admin-title')
Admin-Edit Profile
@endsection
@section('admin-pagelevel-styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('admin-content')
  <section class="content-header">
      <h1>
        Edit Profile
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('client/dashboard')}}">Dashboard</a></li>
        <li class="active">Settings(edit-profile)</li>
      </ol>
  </section>
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <!-- /.box -->
          <div class="box">
            <!-- <div class="box-header">
              <h3 class="box-title">Create Client</h3>
            </div> -->
            <!-- /.box-header -->
            <div class="box-body">
             @if (Session::has('fail'))
            <div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
            </div>
            @endif
            <form action="{{url('admin/edit-profile')}}" class="-bootstrap-modal-form form-horizontal" method="post">
               {{ csrf_field() }}
              <div class="modal-body">
                <div class="box-body">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Name" name="name" value="{{$user_profile['name']}}">
                       <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                  </div>

                  <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Date of birth</label>

                  <div class="col-sm-5">
                    <!-- <input type="text" class="form-control" id="inputEmail3" placeholder="DD/MM/YYYY " name="dateof_birth" value="{{old('dateof_birth')}}" maxlength="30">
                    <span class="text-danger">{{ $errors->first('dateof_birth') }}</span> -->
                    <input type="text" class="form-control" name="dateof_birth" id="datepicker" placeholder="DD/MM/YYYY " value="{{$user_profile['dateof_birth']}}">
                    <span class="text-danger">{{ $errors->first('dateof_birth') }}</span>
                  </div>
                </div>

                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-5">
                    <select id="country" name="country" class="form-control">
                            <option value="">Select Country
                              </option>
                           @foreach($countries as $key => $country)
                             <option value="{{$country}}"  @if($country == $user_profile['useraddresses']['country']) selected="select" @endif >
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
                    <option value="{{$state}}"  @if($state == $user_profile['useraddresses']['state']) selected="select" @endif>{{$state}}
                    </option>
                      @endforeach
                  @else
                  @endif
                    </select>
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                  </div>  
                </div>

                                 <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Type City</label>
                  <div class="col-sm-5">
                    <select name="city" id="city" class="form-control">
                   <option value="">Select City</option>
                    @if($selected_state_all_cities_foreah != "")
                    @foreach($selected_state_all_cities_foreah as $key => $city)
                    <option value="{{$city}}"  @if($city == $user_profile['useraddresses']['city']) selected="select" @endif>{{$city}}
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
                    <input type="text" class="form-control" id="country_code" placeholder="Enter Country Code" name="country_code" value="{{$user_profile['country_code']}}" maxlength="6" onkeypress="return isNumberKey(event)" readonly>
                    <span class="text-danger">{{ $errors->first('country_code') }}</span>
                  </div>  
                </div>

                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Area Code</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Area Code" name="area_code" value="{{$user_profile['area_code']}}" maxlength="6" onkeypress="return isNumberKey(event)">
                    <span class="text-danger">{{ $errors->first('area_code') }}</span>
                  </div>
                </div> 
                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Phone Number</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Phone Number" name="phone_number" value="{{$user_profile['phone_number']}}" maxlength="10" onkeypress="return isNumberKey(event)">
                    <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                  </div>  
                </div>

                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Pincode</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Pin Code" name="pincode" value="{{$user_profile['useraddresses']['pincode']}}" maxlength="6" onkeypress="return isNumberKey(event)">
                    <span class="text-danger">{{ $errors->first('pincode') }}</span>
                  </div>
                  
                </div>
              </div>
              </div>
              <div class="modal-footer">
                <a href="{{url('admin/profile')}}" class="btn btn-info pull-left">
               Go back
              </a>
                <button type="submit" class="btn btn-info">Update</button>
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
@section('admin-pagelevel-script')
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
  <script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
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
  <!-- <script src="{{asset('js/country-states.js')}}"></script>
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
