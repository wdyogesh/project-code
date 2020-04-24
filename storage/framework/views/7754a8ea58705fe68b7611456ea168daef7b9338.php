<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<title>Intell-Comm-Setup Security Question</title>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontpages/html/css/bootstrap.min.css')); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('frontpages/html/css/style.css')); ?>">

<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
<style type="text/css">
  .help-block{
    text-align: left;
  }
</style>

</head>

<body>


<div class="login-form">

  <div class="row">
  
    <div  align="center" id="" class="alert alert-info" style="color:red">Please select Security question for set password
    </div>
    
    
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  
    <h1>Setup Security Question</h1>
     <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li style="color:red"><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
   <?php endif; ?> 
    <form class="bootstrap-modal-form" action="<?php echo e(url('set-security-question')); ?>" method="post" files='true'>
<?php echo e(csrf_field()); ?>

    <div class="login-form-section" style="padding: 28px;">
     <div class="form-group" align="center" style="margin-left:37px;">
        <label  name="login_error"></label>
       </div>
    <div class="form-group">
      <select id="select_security_question" name="user_security_questions" class="form-control">
            <option value="" selected>Select Security Qusetion </option>
            <?php $__currentLoopData = $security_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $security_question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($security_question->id); ?>"><?php echo e($security_question->security_question); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     </select>
    </div>
    
    <div class="form-group" style='display:none;' id='security_question_answer'>
     <input type='text' class='text' placeholder="Write Answer" name='security_question_answer' maxlength="20" class="form-control"/>
    </div>
     <input type='hidden' name='employee_or_staff_id' value="<?php echo e($employee_id); ?>" class="form-control"/>
    <div class="learn_more_btn">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
   </div>
    </form>
    </div>
  </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo e(asset('frontpages/html/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<script>
    $(document).ready(function(){
       


        $('#select_security_question').on('change', function() {
            if (this.value == '')
            {
                $("#security_question_answer").hide();
                
            }
            else
            {
                $("#security_question_answer").show();
            }
        });

       
    });
</script>
</body>
</html>
