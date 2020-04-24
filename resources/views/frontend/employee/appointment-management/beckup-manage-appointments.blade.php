@extends('frontend.employee.layouts.master')
@section('title')
Business Employee-Appointments
@endsection
@section('pagelevel-styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- <link rel="stylesheet" href="{{asset('dist/jquery.yacal.css')}}">
 -->
 <style>
 .fc-center{
    margin-left:600px;
    color: #08c;
 }
 .modal-header{
  background-color: #33b1f1;
 }
 .h1, .h2, .h3, h1, h2, h3 {
    margin-top: 1px;
    margin-bottom: 10px;
}
body {  
    color: #08c;
    padding-right: 0px !important;
}
.help-block{
  margin-left: 197px;
  }
 
.bootstrap-timepicker-widget{
    margin-left: 527px !important;
    /*margin-top: -155px;*/
    margin-top: -125px;
 } 
 
 </style>
@endsection
@section('content')
<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <div class="col-xs-2">
         
                <h3>Appointments:</h3>
           
            <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
               Create Appointment
            </button> -->
        </div>
       
      <div class="col-xs-8" style="float: right;">
           
            <div class="col-xs-1">
                <a href="{{url('employee/appointments/'.Hashids::encode(1))}}" class="btn {{ Request::is('employee/appointments') || Request::is('employee/appointments/'.Hashids::encode(1))? 'btn-warning' : 'btn-info'}}">
              1 Day
               </a>
            </div>
            <div class="col-xs-1">
              <a href="{{url('employee/appointments/'.Hashids::encode(3))}}" class="btn {{Request::is('employee/appointments/'.Hashids::encode(3))? 'btn-warning' : 'btn-info'}}">
                  3 Days
              </a>
            </div>

            <div class="col-xs-1">
               <a href="{{url('employee/appointments/'.Hashids::encode(6))}}" class="btn {{Request::is('employee/appointments/'.Hashids::encode(6))? 'btn-warning' : 'btn-info'}}">
                  6 Days
              </a>
            </div>
            <div class="col-xs-1">
               <a href="{{url('employee/appointments/'.Hashids::encode(7))}}" class="btn {{Request::is('employee/appointments/'.Hashids::encode(7))? 'btn-warning' : 'btn-info'}}">
                  7 Days
              </a>
            </div>
            <div class="col-xs-1">
               <a href="{{url('employee/appointments/'.Hashids::encode(5))}}" class="btn {{Request::is('employee/appointments/'.Hashids::encode(5))? 'btn-warning' : 'btn-info'}}">
                  Work Week
              </a>
            </div>
      </div>
      
                
     @if (Session::has('success'))
     <div  align="center" id="successMessage" class="alert alert-info">{{ Session::get('success') }}
     </div>
     @endif

     <div class="alert alert-success alert-dismissable" id="cancelDiv" style="display: none;">
       <i class="fa fa-check"></i>
       <b>Appointment cancelled successfully!</b>
       <span class="sucmsgdiv"></span>                     
     </div>
     
   </div>
   <!-- /.col -->
 </div>
 <div class="row">
  <div class="col-xs-6">
  </div>
  
 </div> 
 <div class="row">
 
  <!-- <div class="col-xs-3">
    <div id="calendarTemplate"></div>
  </div> -->
  

  <div class="col-xs-12">
    <!-- /.box -->   
    {!! $calendar->calendar() !!} 
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<!-- popup start -->
<div class="modal fade" id="modaldefault">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
          <b><h4 class="modal-title"  style="color:#333">New Appointment</h4></b>
        </div>
        <div class="modal-body" style="background-color: #483e3d ">
          <div>    <!-- //start form -->
            <form action="{{url('employee/store-appointment')}}" class="bootstrap-modal-form form-horizontal" method="post">
             {{ csrf_field() }}
             <div class="modal-body">
              <div class="box-body">
                <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                </div>
                 <div class="form-group">
                 </div>
                  <div class="form-group">
                 </div>
                  <div class="form-group">
                 </div>


               <div class="form-group">
                 <label for="inputEmail3" class="col-sm-4 control-label">Practitioner:</label>
                 <div class="col-sm-8">
                  <select class="form-control select2" name="employee_practitioner_id" style="width: 100%;">
                    <option value="">Select Practitioner</option>
                    @foreach($practitioners as $practitioner)
                    <option value="{{$practitioner->id}}">{{$practitioner['email']}}[{{$practitioner->name}}]</option>
                    @endforeach
                  </select>
                </div>             
              </div>   
              <div class="form-group" id="client_dropdown">
                 <label for="inputEmail3" class="col-sm-4 control-label">Select Client Name:</label>
                 <div class="col-sm-8">
                  <select class="form-control select2" name="client_id" style="width: 100%;">
                    <option value="">Select Client</option>
                    @foreach($managers_clients as $managers_client)
                    <option value="{{$managers_client->id}}">{{$managers_client['email']}}[{{$managers_client->name}}]</option>
                    @endforeach
                  </select>
                </div>             
              </div>
              
             <div style="display: none" id="clint_registration_fields">
              <div class="form-group">
                 <label for="inputEmail3" class="col-sm-4 control-label">First Name:</label>
                 <div class="col-sm-8">
                 <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Client Name" name="client_name" value="{{old('client_name')}}" maxlength="30">
                </div>
              </div>
              <div class="form-group">
                 <label for="inputEmail3" class="col-sm-4 control-label">Sur Name:</label>
                 <div class="col-sm-8">
                 <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Sur Name" name="surname" value="{{old('surname')}}" maxlength="30">
                </div>
              </div>
              <div class="form-group">
                 <label for="inputEmail3" class="col-sm-4 control-label">Email:</label>
                 <div class="col-sm-8">
                   <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Client Email" name="client_email" value="{{old('client_email')}}" maxlength="30">
                </div>
              </div>
              <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-4 control-label">Country:</label>
                  <div class="col-sm-8">
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
                  <label for="inputEmail3" class="col-sm-4 control-label">State:</label>
                  <div class="col-sm-8">
                    <select id="state" name="state" class="form-control" >
                      <option value="">Select State</option>
                    </select>
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                  </div>  
                </div>

                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-4 control-label">City:</label>
                  <div class="col-sm-8">
                    <select name="city" id="city" class="form-control">
                    <option value="">Select City</option>
                    </select>
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                  </div>
                  
                </div>

              <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-4 control-label">Country Code:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="country_code" placeholder="Enter Country Code" name="country_code" value="{{old('country_code')}}" maxlength="6" onkeypress="return isNumberKey(event)" readonly>
                    <span class="text-danger">{{ $errors->first('country_code') }}</span>
                  </div>  
                </div>


              <div class="form-group">                  
              <label for="inputEmail3" class="col-sm-4 control-label">Phone Number:</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Phone Number" name="phone_number" value="{{old('phone_number')}}" maxlength="10" onkeypress="return isNumberKey(event)">
                  <span class="text-danger">{{ $errors->first('phone_number') }}</span>
              </div>
              </div>

             <div class="form-group">
               <label for="inputEmail3" class="col-sm-4 control-label">Date of birth:</label>
                <div class="col-sm-8">
                  <input onchange="checkDate()" type="text" class="form-control" id="datepicker4" placeholder="Select Date" name="dateof_birth" value="{{old('dateof_birth')}}" maxlength="15" onkeypress="return isNumberKey(event)" data-date-format="mm/dd/yyyy">
                  <p id="date_of_birth_error"><span class="text-danger"><!-- {{ $errors->first('dateof_birth') }} --></span></p>
                </div>
            </div>
            </div>


             <div class="form-group">
              <div class="col-sm-4">
              </div>
             <div class="col-sm-7">
             <label style="color:green;"> <input type="checkbox" id="coupon_question" name="checkbox" value="1"/>Do you want to register new client?</label>
            
              </div>
            </div>

              <div class="form-group">
               <label for="inputEmail3" class="col-sm-4 control-label">Appointment Date:</label>
                <div class="col-sm-8">
                  <input onchange="appointmentDate()" type="text" class="form-control" id="datepicker" placeholder="Select Date" name="appointment_date" value="{{old('appointment_date')}}" maxlength="15" onkeypress="return isNumberKey(event)">
                    <p id="date_of_appointment_error"><span class="text-danger"><!-- {{ $errors->first('dateof_birth') }} --></span></p>
                </div>
            </div>

            <div class="bootstrap-timepicker">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Start Time:</label>
                <div class="col-sm-8">
                 <input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="start_time" value="{{old('start_time')}}">
              </div>
            </div>


            <div class="bootstrap-timepicker">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">End Time:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control timepicker" id="inputEmail3" placeholder="Enter End Time" name="end_time" value="{{old('end_time')}}">
                </div>
                </div>
               <input type="hidden" name="manager_id" value="{{$manager_id['manager_id']}}">
               <div class="form-group" align="center">
                <button type="submit" class="btn btn-info">Book</button>
              </div>
              </div>       
            </div>
          </div>
          
        </form>
      </div>
      <!-- //end form -->
    </div>
    
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
</section>
 <div id="calendarModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #483e3d">
       <div class="alert alert-success alert-dismissable" id="sucMsgDeleteDiv" style="display: none;">
         <i class="fa fa-check"></i>
         <b>Record Deleted Success!</b>
         <span class="sucmsgdiv"></span>                     
       </div>
       <div id="read">  
        <h4 class="modal-title">Client Appointment Details</h4>
        <div class="modal-body">
          <div class="box-body">
           
              
          <div class="form-group">
             <label for="inputEmail3" class="col-sm-4 control-label">Practionar Name:</label>
             <div class="col-sm-6">
               <h5 id="modalpractionarname" class="modal-title"></h5>
             </div>
           </div><br>

            <div class="form-group">
             <label for="inputEmail3" class="col-sm-4 control-label">Client Name:</label>
             <div class="col-sm-6">
               <h5 id="modalTitle" class="modal-title"></h5>
             </div>
           </div><br>

           <div class="form-group">
             <label for="inputEmail3" class="col-sm-4 control-label">Email:</label>
             <div class="col-sm-6">
               <h5 id="modalEmail" class="modal-email"></h5>
             </div>
           </div><br>

           <div class="form-group">
             <label for="inputEmail3" class="col-sm-4 control-label">Phone Number:</label>
             <div class="col-sm-6">
               <h5 id="modalPhone" class="modal-phone"></h5>
             </div>
           </div><br>

           <div class="form-group">
             <label for="inputEmail3" class="col-sm-4 control-label">Appointment Date:</label>
             <div class="col-sm-6">
               <h5 id="modalAppointmentDate" class="modal-appointmentdate"></h5>
             </div>
           </div><br> 

           <div class="form-group">
             <label for="inputEmail3" class="col-sm-4 control-label">Time:</label>
             <div class="col-sm-6">
               <h5 id="modalStartTime" class="modal-starttime"></h5> <b>to</b><h5 id="modalEndTime" class="modal-endtime"></h5>
             </div>
           </div><br>

           <div class="form-group">
             <div class="col-sm-12">
              <button type="button" class="btn btn-default deleteProduct" data-dismiss="modal">Close</button>        
              <button class="btn btn-info edit" value="" id="AppointmentId">Edit</button>
              <button class="btn btn-danger btn-delete delete-product" value="" id="modalAppointmentId">Delete</button>
             <button class="btn btn-warning client-details" value="" id="clientId">Action</button>
            </div>
          </div><br>
        </div>
      </div>
    </div>

    <!--  edit appointment start -->
    <div id="record-edit" style="display: none">  
      <h4 class="modal-title">Edit Appointment Details</h4>
      <div class="modal-body">
        <div id="view-show" class="box-body">
          <form action="{{url('employee/update-appointment')}}" class="bootstrap-modal-form form-horizontal" method="post">
            {{ csrf_field() }}
             
             <div class="form-group">
                 <label for="inputEmail3" class="col-sm-4 control-label">Practitioner:</label>
                 <div class="col-sm-8">
                  <select id="option_practionar" class="form-control" name="employee_practitioner_id" style="width: 100%;">
                    <option value="">Select Practitioner</option>
                    @foreach($practitioners as $practitioner)
                    <option value="{{$practitioner->id}}">{{$practitioner['email']}}[{{$practitioner->name}}]</option>
                    @endforeach
                  </select>
                </div>             
              </div>  

            <div class="form-group">
             <label for="inputEmail3" class="col-sm-4 control-label">Client Name:</label>
             <div class="col-sm-8">
              <select id="option_client" class="form-control" name="client_id" style="width: 100%;">
                <option value="">Select Client</option>
                @foreach($managers_clients_edit_page as $managers_client)
                <option value="{{$managers_client->id}}">{{$managers_client->email}}[{{$managers_client->name}}]</option>
                @endforeach
              </select>
            </div>
          </div><br>

          <div class="form-group">
               <label  for="inputEmail3" class="col-sm-4 control-label">Appointment Date:</label>
                <div class="col-sm-8">
                  <input onchange="editAppointmentDate()" type="text" class="form-control" id="datepicker2" placeholder="Select Date" name="appointment_date" value="" maxlength="15" onkeypress="return isNumberKey(event)">
               </div>
                 <p id="edit_date_of_appointment_error"><span style="margin-left: 199px;
" class="text-danger"><!-- {{ $errors->first('dateof_birth') }} --></span></p>
          </div>

         <div class="bootstrap-timepicker">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Start Time:</label>
                <div class="col-sm-8">
                 <input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="start_time" value="">
              </div>
              <!-- /.input group -->
            </div>
          </div>
          <div class="bootstrap-timepicker">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">End Time:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control timepicker" id="end_time" placeholder="Enter End Time" name="end_time" value="">
                </div>
              </div>
          </div>      
         
      <input type="hidden" name="appointment_id" id="appointment_id" value="">
      <div class="form-group">
       <div class="col-sm-12">
        <button type="button" class="btn btn-default deleteProduct" data-dismiss="modal">Close</button>        
        <button class="btn btn-info" value="">Update</button>
      </div>
    </div><br>
  </form>  
  </div>
</div>
</div>
</div>
<!--  edit end -->
</div>
</div>
</div>
<!-- modal details end
-->
<!--  edit record popup start -->
@endsection
@section('pagelevel-script')
{!! $calendar->script() !!}

<meta name="_token" content="{!! csrf_token() !!}" />
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
  var deleteurl = "{{url('employee/delete-appointment')}}";
  var editurl = "{{url('employee/edit-client-appointment')}}";
  var redirect_url= "{{url('employee/client-details')}}";
  var cancel_appointment_url = "{{url('employee/cancel-appointment')}}";
  $(document).on('click','.delete-product',function(){
    if(confirm('Are you sure want to delete tis appointment?')){
      var appointment_id = $(this).val();
            //alert(user_id);
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
            })
            $.ajax({
              type: "DELETE",
              url: deleteurl + '/' + appointment_id,         
              success: function (data) {
                    //console.log(data);
                    //$("#user" + user_id).remove();
                    $('#sucMsgDeleteDiv').show('slow');
                    setTimeout(function(){ $('#sucMsgDeleteDiv').hide('slow');location.reload(); }, 500);
                  },
                  error: function (data) {
                    console.log('Error:', data);
                  }
                });
          }
        });

  $(document).on('click','.client-details',function(){
      var appointment_id = $(this).val();
      /*alert(appointment_id);*/
      /* alert(appointment_id);*/
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      })
      $.ajax({
        type: "get",
        url: cancel_appointment_url + '/' + appointment_id,         
        success: function (data) {
         alert(data);
          window.location.href = redirect_url + '/' +data;
                    //console.log(data);
                    //$("#user" + user_id).remove();
                   /* $('#calendarModal').hide();
                    $('#cancelDiv').show('slow');
                    setTimeout(function(){ $('#cancelDiv').hide('slow');location.reload(); },500);*/
                  },
                  error: function (data) {
                    console.log('Error:', data);
                  }
                });
   
  });

  $(document).on('click','.edit',function(){
    
    var appointment_id = $(this).val();
    /* alert(appointment_id);*/
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    })
    $.ajax({
      type: "GET",
      url: editurl + '/' + appointment_id,         
      success: function (data) {
        console.log(data);
        $('#end_time').val(data.end_time);
        $('#start_time').val(data.start_time);
        $('#datepicker2').val(data.date);
        $('#appointment_id').val(data.appointment_id);
        $('#option_client').val(data.client_id);
        $('#option_practionar').val(data.practionar_id);
        $('#record-edit').show();
        $('#read').hide();                    
          /*setTimeout(function(){ $('#sucMsgDeleteDiv').hide('slow');location.reload(); }, 2000);*/
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    
  });
</script>
<script>
    function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
      return true;
    }    
  </script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#coupon_question").click(function () {
            if ($(this).is(":checked")) {
                $("#clint_registration_fields").show();
                 $("#client_dropdown").hide();
            } else {
                 $("#clint_registration_fields").hide();
                 $("#client_dropdown").show();
            }
        });
    });
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
<!-- new calendar start-->
<script>
 $(document).on('click','.fc-widget-content',function(){
     $("#modaldefault").modal();
  });
</script>
<script type="text/javascript">
  function checkDate() {
   var selectedText = document.getElementById('datepicker4').value;
   //alert(selectedText);
   var selectedDate = new Date(selectedText);
   var now = new Date();
   //alert(now);
   if (selectedDate > now) {
      $("#date_of_birth_error span").html("Date of birth must be before today");
      $('#datepicker4').val("");
   }else{
    $("#date_of_birth_error span").html("");
   }
 }
</script>

<script type="text/javascript">
  function appointmentDate() {
   var selectedText = document.getElementById('datepicker').value;
   //alert(selectedText);
   var selectedDate = new Date(selectedText);
   var now = new Date();
   if (selectedDate > now.setDate(now.getDate() - 1)) {
     $("#date_of_appointment_error span").html("");
   }else{
     $("#date_of_appointment_error span").html("Date of appointment must be after yesterday");
     $('#datepicker').val("");
     $('.help-block').hide();
   }
 }
</script>
<script type="text/javascript">
  function editAppointmentDate() {
   var selectedText = document.getElementById('datepicker2').value;
   //alert(selectedText);
   var selectedDate = new Date(selectedText);
   var now = new Date();
   if (selectedDate > now.setDate(now.getDate() - 1)) {
     $("#edit_date_of_appointment_error span").html("");
   }else{
     $("#edit_date_of_appointment_error span").html("Date of appointment must be after yesterday");
     $('#datepicker2').val("");
     $('.help-block').hide();
   }
 }
</script>

@endsection