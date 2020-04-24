<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<title>Intell-Comm Manager Registration</title>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontpages/html/css/bootstrap.min.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontpages/html/css/style.css')); ?>">

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
              <!--  <li><img src="<?php echo e(asset('frontpages/html/images/user_icon.png')); ?>"><a href="<?php echo e(url('manager-registration')); ?>">New Business User</a></li>
                <li><img src="<?php echo e(asset('frontpages/html/images/registered_user.png')); ?>"><a href="<?php echo e(url('manager-login')); ?>">Login Business Users</a></li> -->
                 <li><img src="<?php echo e(asset('frontpages/html/images/user_icon.png')); ?>"><a href="<?php echo e(url('manager-registration')); ?>">New Users</a></li>
               <li>
               <img src="<?php echo e(asset('frontpages/html/images/registered_user.png')); ?>"><a href="<?php echo e(url('login-category')); ?>">Registered Users</a>
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
      <a class="navbar-brand" href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('frontpages/html/images/logo.png')); ?>"></a> </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            
      <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="<?php echo e(url('/')); ?>">HOME</a></li>
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
             <h1>Business Manager Registration</h1>
            <form class="bootstrap-modal-form" action="<?php echo e(url('manager-registration')); ?>" method="post" files='true'>
            <?php echo e(csrf_field()); ?>

             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="email">Business Name</label>
                <input type=text name='business_name' placeholder="Business Name" class="form-control" id="textname" maxlength="20">
              </div>
             </div>
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="pwd">Business Type</label>
                <select id="purpose" name="business_category_type" class="form-control">
                  <option value="" selected>select..</option>
                  <?php $__currentLoopData = $business_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business_categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option style="color:brown;font-size:17px;" readonly><?php echo e($business_categorie->category_name); ?></option>
                  <?php $__currentLoopData = $business_categorie->professions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profession): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($profession->business_profession_type); ?>"><?php echo e($profession->business_profession_type); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <option value="Other professions" style="color:green;font-size:17px; ">Other professions</option>
                 </select>
              </div>
             </div>
             
              <div class="clearfix"></div>

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style='display:none;' id='business_type'>
              <div class="form-group">
                <label for="email">Enter your Profession Type</label>
                   <input type="text" class="form-control" name="other_business" maxlength="20">
              </div>
             </div>
            
             
             <div class="clearfix"></div>
             
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="name">Name</label>
                 <input type="name" placeholder="Enter Full Name" class="form-control" name="name" maxlength="20">
              </div>
             </div>
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="pwd">Email</label>
                 <input type="text" class="form-control" placeholder="Enter Email" name="email" maxlength="40">
              </div>
             </div>
             
             <div class="clearfix"></div>
             
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="pwd">Password</label>
                 <input type="password" class="form-control" placeholder="Enter Password" name="password" maxlength="10">
              </div>
             </div>
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="pwd">Confirm Password</label>
                 <input type="password" class="form-control" placeholder="Enter Confirm Password" name="confirm_password" maxlength="10">
              </div>
             </div>
             
              <div class="clearfix"></div>

              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="email">Country</label>
               <select id="country" name="country" class="form-control">
                <option value="">Select Country
                  </option>
                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  
                  <option value="<?php echo e($country); ?>"> <?php echo e($country); ?>

                  </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </select>
              </div>
             </div>
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="pwd">State</label>
                <select id="state" name="state" class="form-control">
                <option value="">Select State
                  </option> 
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
                <option value="">Select City
                  </option> 
                </select>
              </div>
             </div>
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="pwd">PinCode</label>
              <input type="text" name="pincode" id="pincode" placeholder="Enter Pincode" class="form-control" maxlength="6">
              </div>
             </div>
             
             <div class="clearfix"></div>
             
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label for="email">Enter Security Question</label>
                <select id="select_security_question" name="user_security_questions" class="form-control">
                    <option value="" selected>select..</option>
                    <?php $__currentLoopData = $security_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $security_question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($security_question->id); ?>"><?php echo e($security_question->security_question); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
             <div class="Popup-next">
             <label style="color:green"><input type="checkbox" class="coupon_question" name="checkbox" value="1" onchange="valueChanged()"/>  Do you want to add alternative account?</label> 
             </div>
            </div>
              <div class="clearfix"></div>
              
              <div style="display:none;" class="alternative_details_form">

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                  <label for="email">Name</label>
                   <input type=text name="alternative_name" placeholder="Enter Name" id="textname" class="form-control" maxlength="20"> 
                </div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                  <label for="pwd">Email</label>
                 <input type="text" name="alternative_email" placeholder="Enter Email" id="fathername" class="form-control" maxlength="40">
                </div>
               </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                  <label for="email">Password</label>
                  <input type="password" name="alternative_password" placeholder="Enter Password" id="fathername" class="form-control" maxlength="10">
                </div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                  <label for="pwd">Country Code</label>
                 <input type="text" name="alternative_country_code" id="country_code" maxlength="5" placeholder="Country Code" class="form-control"  onkeypress="return isNumberKey(event)" readonly>
                </div>
               </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                   <label for="pwd">Area Code</label>
                  <input type="text" name="alternative_area_code" id="paddress" size="6" placeholder="Area Code" class="form-control" maxlength="5" onkeypress="return isNumberKey(event)">
                </div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                   <label for="pwd">Phone Number</label>
                <input type="text" name="alternative_phone_number" id="paddress" size="10" placeholder="Phone Number" class="form-control" maxlength="10" onkeypress="return isNumberKey(event)">
                </div>
               </div>

               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <label for="email">Enter Alternative Manager Security Question</label>
               <select id="select_alternative_security_question" name="alternative_user_security_questions" class="form-control">
                <option value="" selected>select..</option>
                <?php $__currentLoopData = $security_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $security_question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($security_question->id); ?>"><?php echo e($security_question->security_question); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>
             </div> 
               
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style='display:none;' id='alternative_security_question_answer'>
              <div class="form-group">
                <label for="email">Enter Alternative Manager Security Question Answer</label>
                  <input type='text' name='alternative_security_question_answer' maxlength="20" class="form-control"/>
              </div>
             </div>
            </div>  
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="learn_more_btn">
                <button type="submit" class="btn btn-success">SUBMIT</button>
              </div>
             </div>
       
            </form>
           </div>
          </div>
         </div>
        </div>
    
 <?php echo $__env->make('frontend.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
 
 </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo e(asset('frontpages/html/js/bootstrap.min.js')); ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
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
<!-- <script src="<?php echo e(asset('js/country-states.js')); ?>"></script>
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
</body>
</html>