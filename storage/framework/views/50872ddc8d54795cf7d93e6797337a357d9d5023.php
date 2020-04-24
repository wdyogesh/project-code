<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  Hi <strong><?php echo e($name); ?> </strong>, 
  <p>welcome to intellComm</p> 
  <!-- <p>
  Your are successfully registered with our business as a client.
  </p> -->
<!-- <p><?php echo e($body); ?></p> -->
<p>Please click below link to verify</p>
<a href="<?php echo e(url('manager/manaager-verification-account-completion',$id)); ?>">Click here</a>

</body>
</html>

