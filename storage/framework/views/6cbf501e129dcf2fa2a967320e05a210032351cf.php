<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Intell-Comm Employee Login</title>
  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontpages/html/css/bootstrap.min.css')); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontpages/html/css/style.css')); ?>">

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
                <?php if(Auth::check() && Auth::user()->role_id == 4): ?>
                <li><img src="<?php echo e(asset('frontpages/html/images/user_icon.png')); ?>">
                 <?php echo e(Auth::user()->name); ?> 
                     <a href="<?php echo e(url('employee-logout')); ?>" style="text-decoration: none;color:green">(Logout)</a> /  
                     <a href="<?php echo e(url('employee/dashboard')); ?>" style="text-decoration: none;color:green">(Dashboard)</a>
                </li>
                <?php else: ?>
                <li><img src="<?php echo e(asset('frontpages/html/images/user_icon.png')); ?>"><a href="<?php echo e(url('employee-login')); ?>" style="text-decoration: none;">Employee Login</a></li>
                <?php endif; ?>

                <?php if(Auth::check() && Auth::user()->role_id == 5): ?>
                <li style="color:#ff7800"><img src="<?php echo e(asset('frontpages/html/images/user_icon.png')); ?>"><?php echo e(Auth::user()->name); ?> 
                     <a href="<?php echo e(url('other-party-logout')); ?>" style="text-decoration: none;color:green">(Logout)</a> /  
                     <a href="<?php echo e(url('other-party/dashboard')); ?>" style="text-decoration: none;color:green">(Dashboard)</a>
                </li>
                <?php else: ?>
                 <li><img src="<?php echo e(asset('frontpages/html/images/user_icon.png')); ?>"><a href="<?php echo e(url('other-party-login')); ?>" style="text-decoration: none;">Other Party Login</a></li>
                <?php endif; ?>
               
                <?php if(Auth::check() && Auth::user()->role_id == 3): ?>
                <li><img src="<?php echo e(asset('frontpages/html/images/registered_user.png')); ?>">
                <?php echo e(Auth::user()->name); ?> 
                     <a href="<?php echo e(url('client-logout')); ?>" style="text-decoration: none;color:green">(Logout)</a> /  
                     <a href="<?php echo e(url('client/dashboard')); ?>" style="text-decoration: none;color:green">(Dashboard)</a>
                </li>
                <?php else: ?>
                <li><img src="<?php echo e(asset('frontpages/html/images/registered_user.png')); ?>">
                <a href="<?php echo e(url('client-login')); ?>" style="text-decoration: none;">Client Login
                </a>
                </li>
                <?php endif; ?>
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
                 <a class="navbar-brand" href="http://intell-comm.com"><img src="<?php echo e(asset('frontpages/html/images/logo.png')); ?>"></a> </a>
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
       <?php if(Session::has('message')): ?>
       <div  align="center" id="successMessage" class="alert alert-info" style="color:red"><?php echo e(Session::get('message')); ?>

       </div>
       <?php endif; ?>

      <?php if(Session::has('success')): ?>
       <div  align="center" id="successMessage"  class="alert alert-info"><?php echo e(Session::get('success')); ?>

       </div>
      <?php endif; ?>



       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <h1>Enter Your Password</h1>
     <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li style="color:red"><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
   <?php endif; ?> 
    <form  action="<?php echo e(url('manager-login')); ?>" class="bootstrap-modal-form" method="post">
      <?php echo e(csrf_field()); ?>

    <div class="login-form-section" style="padding: 28px;">
     <div class="form-group" align="center" style="margin-left:70px;">
        <label  name="login_error"></label>
       </div>
    <div class="form-group">
    <?php if(isset($user_email)): ?>
      <input type="text" class="form-control" id="email" name="email"  value="<?php echo e($user_email['email']); ?>" placeholder="Email" readonly>
    <?php else: ?>
      <input type="text" class="form-control" id="email" name="email" placeholder="Email">
    <?php endif; ?>
    </div>
    
    <div class="form-group">
      <input type="password" class="form-control" id="email" name="password" placeholder="Password">
    </div>
    
    <div class="learn_more_btn">
      <button type="submit" class="btn btn-success">MANAGER LOGIN</button>
    </div>
    <div class="learn_more_btn">
     <!--  <a href="<?php echo e(url('manager-registration')); ?>">Do you want to register?</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
      <a href="<?php echo e(url('manager/regitered-security-questions-choosing/'.$kay_user_send_login_forgot)); ?>">Forgotten account?</a>
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
          <div class="social-icon"> <a href="#"><img src="<?php echo e(asset('frontpages/html/images/fb.png')); ?>"></a> <a href="#"><img src="<?php echo e(asset('frontpages/html/images/twitter.png')); ?>"></a> <a href="#"><img src="<?php echo e(asset('frontpages/html/images/circle_cross.png')); ?>"></a> </div>
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
<script src="<?php echo e(asset('frontpages/html/js/bootstrap.min.js')); ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>

</body>
</html>