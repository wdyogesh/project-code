<?php $__env->startSection('title'); ?>
Business Manager-Send Other Party Invitation
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<!-- new date picker style start-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- new date picker style start-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			
			<!-- /.box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Send Invitation For Other Party Users</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<?php if(Session::has('fail')): ?>
					<div  align="center" id="successMessage" class="alert alert-danger"><?php echo e(Session::get('fail')); ?>

					</div>
					<?php endif; ?>
					<form action="<?php echo e(url('manager/send-other-party-invitation')); ?>" class="bootstrap-modal-form form-horizontal" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="modal-body">
							<div class="box-body">
							 <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                                </div>
							    <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Category</label>
									<div class="col-sm-5">
										<select class="form-control" name="category_name">
											<option value="" selected>select..</option>
											<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($categorie->id); ?>"><?php echo e($categorie->category_name); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
										<span class="text-danger"><?php echo e($errors->first('category_name')); ?></span>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Name" name="other_party_user_name" value="<?php echo e(old('other_party_user_name')); ?>" maxlength="25">
										<span class="text-danger"><?php echo e($errors->first('	other_party_user_name')); ?></span>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Email" name="other_party_email" value="<?php echo e(old('other_party_email')); ?>" maxlength="40">
										<span class="text-danger"><?php echo e($errors->first('	other_party_email')); ?></span>
									</div>
								</div>
								
								</div>
                            <div class="form-group" align="center">
								<a href="<?php echo e(url('manager/invite-other-party')); ?>" class="btn btn-info">
									Go back
								</a>
								<button type="submit" class="btn btn-success">Send Invitation</button>
							</div>
								

								</div>
						
							
						</form>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	
	<?php $__env->stopSection(); ?>
	<?php $__env->startSection('pagelevel-script'); ?>
	<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
	<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>