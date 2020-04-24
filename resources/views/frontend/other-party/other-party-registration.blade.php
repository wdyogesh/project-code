<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<title>Intell-Comm Other Party Registration</title>
<link rel="stylesheet" type="text/css" href="{{asset('frontpages/html/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontpages/html/css/style.css')}}">

<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

</head>

<body>
<div class="main">
 <div class="wrapper">
 
  <div class="header">
      <div class="top_header">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <ul class="pull-right">
             <!--   <li><img src="{{asset('frontpages/html/images/user_icon.png')}}"><a href="{{url('manager-registration')}}">New Business User</a></li>
                <li><img src="{{asset('frontpages/html/images/registered_user.png')}}"><a href="{{url('manager-login')}}">Login Business Users</a></li> -->
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="bottom_header">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
      
              
            <nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="http://intell-comm.com"><img src="{{asset('frontpages/html/images/logo.png')}}"></a> </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            
      <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="{{url('/')}}">HOME</a></li>
                  <li><a href="#">ABOUT US</a></li>
                  <li><a href="#">FEATURES</a></li>
                  <li><a href="#">TEAM</a></li>
                  <li><a href="#">OUR SERVICES</a></li>
                  <li><a href="#">CONTACT</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    
        <div class="registration_section">
         <div class="container">
          <div class="row">
           <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-6  col-sm-offset-6">
             <h1>Other Party Registration</h1>
            <form class="bootstrap-modal-form" action="{{url('other-party-registration')}}" method="post" files='true'>
            @if (Session::has('fail'))
          <div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
          </div>
          @endif
            {{ csrf_field() }}
               <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                    <label name="login_error"></label>
                </div>
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="email">Invited Business Name</label>
                <input type=text name='business_name' class="form-control" id="textname" maxlength="40" value="{{$business_name['businesss_name']}}" readonly>
              </div>
              </div>

              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="email">Invitation Other Party Category</label>
                <input type=text name='invetation_category' class="form-control" id="textname" maxlength="40" value="{{$invitation_category['category_name']}}" readonly>
              </div>
             </div>
             
 
             <div class="clearfix"></div>
            
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="name">Name</label>
                 <input type="name" class="form-control" name="name" maxlength="20">
              </div>
             </div>
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="pwd">Email</label>
                 <input type="text" class="form-control" name="email" maxlength="40">
              </div>
             </div>
             
             <div class="clearfix"></div>
             
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="pwd">Password</label>
                 <input type="password" class="form-control" name="password" maxlength="15">
              </div>
             </div>
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="pwd">Confirm Password</label>
                 <input type="password" class="form-control" name="confirm_password" maxlength="15">
              </div>
             </div>
             
              <div class="clearfix"></div>

              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="email">Country</label>
               <select id="country" name="country" class="form-control">
                <option value="">Select Country
                  </option>
                @foreach($countries as $key => $country)
                  
                  <option value="{{$country}}"> {{$country}}
                  </option>
                @endforeach
               </select>
              </div>
             </div>
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="pwd">State</label>
                <select id="state" name="state" class="form-control">   
                </select>
              </div>
             </div>
             
             <div class="clearfix"></div>
             
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="form-group">
                <label for="email">Country Code</label>
                 <input type="text" name="country_code" id="country_code_second" maxlength="5" placeholder="Country Code" class="form-control" onkeypress="return isNumberKey(event)" readonly>
              </div>
             </div>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="form-group">
                <label for="pwd">Area Code</label>
                  <input type="text" name="area_code" id="paddress" maxlength="5" placeholder="Area Code" class="form-control" onkeypress="return isNumberKey(event)">
              </div>
             </div>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="form-group">
                <label for="pwd">Phone Number</label>
                 <input type="text" name="phone_number" id="paddress" maxlength="10" placeholder="Phone Number" class="form-control" onkeypress="return isNumberKey(event)">
              </div>
             </div>
             
              <div class="clearfix"></div>
             
             
             
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="email">City</label>
                <select name="city" id="city" class="form-control">
                </select>
              </div>
             </div>
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="pwd">PinCode</label>
              <input type="text" name="pincode" id="pincode" class="form-control" maxlength="6" onkeypress="return isNumberKey(event)">
              </div>
             </div>
             
             <div class="clearfix"></div>
             
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label for="email">Enter Security Question</label>
                <select id="select_security_question" name="user_security_questions" class="form-control">
                    <option value="" selected>select..</option>
                    @foreach($security_questions as $security_question)
                    <option value="{{$security_question->id}}">{{$security_question->security_question}}</option>
                    @endforeach
                </select>
              </div>
             </div> 
              <div class="clearfix"></div>
               
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style='display:none;' id='security_question_answer'>
              <div class="form-group">
                <label for="email">Write above security question answer</label>
                   <input type="text" class="form-control" name='security_question_answer' maxlength="20" >
              </div>
             </div>
               
              <div class="clearfix"></div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="learn_more_btn">
            <input type="hidden" name="manager_id" value="{{$other_party_details['manager_id']}}">  
            <input type="hidden" name="invitation_id" value="{{$invitation_id}}">
                <button type="submit" class="btn btn-success">SUBMIT</button>
              </div>
             </div>
              </div>
            </form>
           </div>
          </div>
         </div>
        </div>
    
    @include('frontend.footer')
 
 </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{asset('frontpages/html/js/bootstrap.min.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#purpose').on('change', function() {
            if ( this.value == 'Other professions')
            {
                $("#business_type").show();
            }
            else
            {
                $("#business_type").hide();
            }
        });


        $('#select_security_question').on('change', function() {
            if (this.value == '')
            {
                $("#security_question_answer").hide();
                
            }
            else
            {
                $("#security_question_answer").show();
            }
        });

        $('#select_alternative_security_question').on('change', function() {
            if (this.value == '')
            {
                $("#alternative_security_question_answer").hide();
                
            }
            else
            {
                $("#alternative_security_question_answer").show();
            }
        });
    });

    function valueChanged()
    {
        if($('.coupon_question').is(":checked"))   
            $(".alternative_details_form").show();
        else
            $(".alternative_details_form").hide();
    }
</script>
<!-- <script src="{{asset('js/country-states.js')}}"></script>
<script language="javascript">
    populateCountries("country", "state");
    populateCountries("country2");
</script> -->
<!-- state city select start -->
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
</body>
</html>