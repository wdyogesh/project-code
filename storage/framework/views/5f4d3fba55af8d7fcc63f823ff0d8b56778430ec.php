<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  Hi <strong><?php echo e($name); ?> <?php echo e($surname); ?> </strong>, 
  <p>Welcome to intellComm</p> 
  <p>
  Your appointment was conformed with <b><?php echo e($business_name); ?></b> business.
  </p>

<h3 style="color:green;">Your appointment details are</h3>
 
 <p>Appointment Date:  <?php echo e($appointment_start_date_time); ?></p>
 <p>Appointment with:  <?php echo e($practionar_name); ?> <?php echo e($practionar_surname); ?>[<?php echo e($practionar_email); ?>]</p>
 
</body>
</html>

