<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  Hi <strong><?php echo e($name); ?> <?php echo e($surname); ?> </strong>, 
  <p>welcome to intellComm</p> 
  <p>
  As per your request <b>IntellCOMM</b> have been sent re-set credentials link.
  </p>

<a href="http://<?php echo e($business_name); ?>.intell-comm.com/re-set-security-question-password/<?php echo e($id); ?>/<?php echo e($request_id); ?>">Click me to re-set your security question and password</a>
</body>
</html>

<!-- http://indiaqo.intell-comm.com/manager-login?G7

<?php echo e(url('/re-set-security-question-password/'.$id.'/'.$request_id)); ?> -->
<!-- http://intell-comm.com/admin/send-reset-credentials-link -->