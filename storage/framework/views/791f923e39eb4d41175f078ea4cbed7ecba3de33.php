<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  Hi <strong><?php echo e($name); ?> </strong>, 
  <p>Invitation From IntellComm</p> 
  <p>
   You can register as <b><?php echo e($other_party_name); ?></b> other party user with our <?php echo e($business_name); ?> business.
  </p>
<p>Business Manager Email: <b><?php echo e($manager_email); ?></b></p>
<p>Please click below link to register</p>
<a href="<?php echo e(url('business-other-party-users-registration/'.$id.'/'. Hashids::encode($other_party_id) )); ?>">IntellCOMM Other Party User Registration</a>
</body>
</html>

