ss<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  Hi <strong><?php echo e($name); ?> </strong>, 
  <p>welcome to intellComm</p> 
  <p>
  Your registration process is completed as a client with <?php echo e($business_name); ?> business.
  </p>
<!-- <p><?php echo e($body); ?></p> -->
<p>Please click below link to set your password</p>
<a href="<?php echo e(url('client-set-security-question/'.$id)); ?>">Click me to set password</a>
</body>
</html>

