<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Intell-Comm Manager Login</title>
  <link rel="stylesheet" type="text/css" href="{{asset('frontpages/html/css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('frontpages/html/css/style.css')}}">

  <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
  <style type="text/css">
    .main{
      background: url()no-repeat;
     
    }
    .login-form h1 {
      background:#d2b481;
      color: #fff;
    }
   
    .learn_more_btn .btn {
    background: #776d5a;
     }

  </style>
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
              <!--  <li><img src="{{asset('frontpages/html/images/user_icon.png')}}"><a href="{{url('manager-registration')}}">New Business User</a></li>
               <li><img src="{{asset('frontpages/html/images/registered_user.png')}}"><a href="{{url('manager-login')}}">Login Business Users</a></li> -->
               <li><img src="{{asset('frontpages/html/images/user_icon.png')}}"><a href="http://intell-comm.com/manager-registration">New Users</a></li>
               <li>
               <img src="{{asset('frontpages/html/images/registered_user.png')}}"><a href="http://intell-comm.com/login-category">Registered Users</a>
               </li>
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
                  <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('frontpages/html/images/logo.png')}}"></a> </a>
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

  <div class="registration_section main">
   <div class="container">
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
   <form action="{{url('manager/password-setup')}}" class="bootstrap-modal-form" method="post">
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
    <input type='hidden' name='manager_id' value="{{$manager_id}}" class="form-control"/>
    <div class="learn_more_btn">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
     <div class="learn_more_btn">
      <a href="{{route('manager-login',[$subdomain,Hashids::encode($manager_id)])}}">Go back to login page</a>
    </div>
   </div>
    </form>
      </div>
    </div>

  </div>
</div>
</div>

<div class="footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <h2>Our Address</h2>
          <ul>
            <li><a>11 Waterdale </a></li>
            <li><a>wolverhampton</a></li>
            <li><a>WV3 9DY,England.</a></li>
          </ul>
          <div class="social-icon"> <a href="#"><img src="{{asset('frontpages/html/images/fb.png')}}"></a> <a href="#"><img src="{{asset('frontpages/html/images/twitter.png')}}"></a> <a href="#"><img src="{{asset('frontpages/html/images/circle_cross.png')}}"></a> </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <h2>Company</h2>
          <ul>
            <li><a>Our story</a></li>
            <li><a>Mission</a></li>
            <li><a>Journal</a></li>
            <li><a>Careers</a></li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <h2>Support</h2>
          <ul>
            <li><a>FAQ</a></li>
            <li><a>Contact us</a></li>
            <li><a>Policies</a></li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <h2>About Us.</h2>
          <ul>
            <li><a>Excepteur sint occaecat cupidatat non</a></li>
            <li><a>proident, sunt in culpa qui officia est </a></li>
            <li><a>deserunt mollit anim laborum.</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© 2017 -  All Rights Reserved  -  Intell-Comm</p>
      </div>
    </div>
  </div>
</div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{asset('frontpages/html/js/bootstrap.min.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>

</body>
</html>