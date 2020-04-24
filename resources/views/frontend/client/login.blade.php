<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Intell-Comm Client Login</title>
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
                @if(Auth::check() && Auth::user()->role_id == 4)
                <li><img src="{{asset('frontpages/html/images/user_icon.png')}}">
                 {{Auth::user()->name}} 
                     <a href="{{url('employee-logout')}}" style="text-decoration: none;color:green">(Logout)</a> /  
                     <a href="{{url('employee/dashboard')}}" style="text-decoration: none;color:green">(Dashboard)</a>
                </li>
                @else
                <li><img src="{{asset('frontpages/html/images/user_icon.png')}}"><a href="{{url('employee-login')}}" style="text-decoration: none;">Employee Login</a></li>
                @endif

                @if(Auth::check() && Auth::user()->role_id == 5)
                <li style="color:#ff7800"><img src="{{asset('frontpages/html/images/user_icon.png')}}">{{Auth::user()->name}} 
                     <a href="{{url('other-party-logout')}}" style="text-decoration: none;color:green">(Logout)</a> /  
                     <a href="{{url('other-party/dashboard')}}" style="text-decoration: none;color:green">(Dashboard)</a>
                </li>
                @else
                 <li><img src="{{asset('frontpages/html/images/user_icon.png')}}"><a href="{{url('other-party-login')}}" style="text-decoration: none;">Other Party Login</a></li>
                @endif
               
                @if(Auth::check() && Auth::user()->role_id == 3)
                <li><img src="{{asset('frontpages/html/images/registered_user.png')}}">
                {{Auth::user()->name}} 
                     <a href="{{url('client-logout')}}" style="text-decoration: none;color:green">(Logout)</a> /  
                     <a href="{{url('client/dashboard')}}" style="text-decoration: none;color:green">(Dashboard)</a>
                </li>
                @else
                <li><img src="{{asset('frontpages/html/images/registered_user.png')}}">
                <a href="{{url('client-login')}}" style="text-decoration: none;">Client Login
                </a>
                </li>
                @endif
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
            <li class="active"><a href="http://intell-comm.com">HOME</a></li>
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
        @if(Session::has('success'))
       <div  align="center" id="successMessage"  class="alert alert-info">{{ Session::get('success') }}
       </div>
      @endif

       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <h1>Business Client Login</h1>
     @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
   @endif 
    <form  action="{{url('client-login')}}" class="bootstrap-modal-form" method="post">
      {{ csrf_field() }}
    <div class="login-form-section" style="padding: 28px;">
     <div class="form-group" align="center" style="margin-left:37px;">
        <label  name="login_error"></label>
       </div>
    <div class="form-group">
      @if(!empty($user_email))
      <input type="text" class="form-control" value="{{$user_email['email']}}" id="email" name="email" placeholder="Email" readonly>
      @else
      <input type="text" class="form-control" id="email" name="email" placeholder="Email">
      @endif
    </div>
    
    <div class="form-group">
      <input type="password" class="form-control" id="email" name="password" placeholder="Password">
    </div>
    
     <div class="learn_more_btn">
      <button type="submit" class="btn btn-success">LOGIN</button>
    </div>
    <div class="learn_more_btn">
     <a href="{{url('client/forgot-password')}}">Forgotten account?</a>
    </div>
   </div>
    </form>
      </div>
    </div>

  </div>
</div>
</div>

@include('frontend.footer')
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{asset('frontpages/html/js/bootstrap.min.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>

</body>
</html>