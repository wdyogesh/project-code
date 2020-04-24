<?php $__env->startSection('title'); ?>
Business Manager-Create Client
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
					<h3 class="box-title">Send Request</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<?php if(Session::has('fail')): ?>
					<div  align="center" id="successMessage" class="alert alert-danger"><?php echo e(Session::get('fail')); ?>

					</div>
					<?php endif; ?>
					<form action="<?php echo e(url('client/send-request')); ?>" class="-bootstrap-modal-form form-horizontal" method="post" enctype="multipart/form-data">
						<?php echo e(csrf_field()); ?>

						<div class="modal-body">
							<div class="box-body">
								<div class="form-group" style="font-size: 18px;margin-left:140px; ">
									<label name="login_error"></label>
								</div>

								  <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Subject:</label>
									<div class="col-sm-9">
									    <input type="text" name="subject" value="<?php echo e(old('subject')); ?>" class="form-control" >
										<span class="text-danger"><?php echo e($errors->first('subject')); ?></span>
									</div>
								</div>


                                <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Write Your Request:</label>
									<div class="col-sm-9">
										<textarea id="compose-textarea" class="form-control" name="message" style="height: 300px"><?php echo e(old('message')); ?></textarea>
										<span class="text-danger"><?php echo e($errors->first('message')); ?></span>
									</div>
								</div>

								

								<div class="form-group" align="center">
									<a href="<?php echo e(url('employee/manage-client-notes')); ?>" class="btn btn-info">
										Go back
									</a>
									<button type="submit" class="btn btn-success">Submit</button>
								</div>

							</div>
						</div>

					</form>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>

		<!-- /.row -->
	</section>

	<?php $__env->stopSection(); ?>
	<?php $__env->startSection('pagelevel-script'); ?>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>

	<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.client.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>