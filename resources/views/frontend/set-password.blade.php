<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<title>Intell-Comm-Set Password</title>
<link rel="stylesheet" type="text/css" href="{{asset('frontpages/html/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontpages/html/css/style.css')}}">

<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
<style type="text/css">
  .help-block{
    text-align: left;
  }
</style>

</head>

<body>


<div class="login-form">

  <div class="row">
   @if (Session::has('message'))
    <div  align="center" id="successMessage" class="alert alert-info" style="color:red">{{ Session::get('message') }}
    </div>
    @endif
    
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  
    <h1>Setup Password</h1>
     @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
   @endif 
   <form action="{{url('set-password')}}" class="bootstrap-modal-form" method="post">
        {{ csrf_field() }}
    <div class="login-form-section" style="padding: 28px;">
     <div class="form-group" align="center" style="margin-left:37px;">
        <label  name="login_error"></label>
       </div>
    <div class="form-group">
      <input type="password" class="form-control" name="password" placeholder="Password" maxlength="15">
    </div>
    
    <div class="form-group">
     <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" maxlength="15">
    </div>
    <input type='hidden' name='employee_or_staff_id' value="{{$employee_or_staff_id}}" class="form-control"/>
    <div class="learn_more_btn">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
   </div>
    </form>
    </div>
  </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{asset('frontpages/html/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>

<script>
$(document).ready(function(){
        setTimeout(function() {
          $('#successMessage').fadeOut('slow');
        }, 2000); // <-- time in milliseconds
    });
</script>
</body>
</html>
