<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  Hi <strong><?php echo e($name); ?> <?php echo e($surname); ?> </strong>, 
  <p>welcome to intellComm</p> 
  <p>
  As per your request <b><?php echo e($business_name); ?></b> business have been sent re-set credentials link.
  </p>

<a href="<?php echo e(url('/re-set-security-question-password/'.$id.'/'.$request_id)); ?>">Click me to re-set your security question and password</a>
</body>
</html>

