<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Intell-Comm Domain Choosing</title>
  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontpages/html/css/bootstrap.min.css')); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontpages/html/css/style.css')); ?>">

  <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
  <style type="text/css">
    .main{
      background: url()no-repeat;
     
    }
    .login-form h1 {
      background:#344234;
      color: #fff;
    }
   
   .learn_more_btn .btn {
    background: #5187a2;
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
              <!--  <li><img src="<?php echo e(asset('frontpages/html/images/user_icon.png')); ?>"><a href="<?php echo e(url('manager-registration')); ?>">New Business User</a></li>
               <li><img src="<?php echo e(asset('frontpages/html/images/registered_user.png')); ?>"><a href="<?php echo e(url('manager-login')); ?>">Login Business Users</a></li> -->
                <li><img src="<?php echo e(asset('frontpages/html/images/user_icon.png')); ?>"><a href="<?php echo e(url('manager-registration')); ?>">New Users</a></li>
               <li>
               <img src="<?php echo e(asset('frontpages/html/images/registered_user.png')); ?>"><a href="<?php echo e(url('login-category')); ?>">Registered Users</a>
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

  <div class="registration_section main">
   <div class="container">
    <div class="login-form">

      <div class="row">
       <?php if(Session::has('message')): ?>
       <div  align="center" id="successMessage" class="alert alert-info" style="color:red"><?php echo e(Session::get('message')); ?>

       </div>
       <?php endif; ?>

       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <h1>Which business do you want to log in to?</h1>
        <?php if($errors->any()): ?>
        <div class="alert alert-danger">
          <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li style="color:red"><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
        <?php endif; ?> 
        <form  action="#" class="bootstrap-modal-form" method="post">

          <div class="login-form-section" style="padding: 28px;">
          <?php $__currentLoopData = $business_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $business_detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <div class="learn_more_btn">
            <a href="<?php echo e(route('employee-login',[$business_detail['business_name']['businesss_name'],Hashids::encode($business_detail['employee_id']['id'])])); ?>" class="btn btn-success"><?php echo e($business_detail['business_name']['businesss_name']); ?></a>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
</div>

<?php echo $__env->make('frontend.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo e(asset('frontpages/html/js/bootstrap.min.js')); ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>

</body>
</html>