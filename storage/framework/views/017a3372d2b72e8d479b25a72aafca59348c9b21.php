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
					<h3 class="box-title">Client Notes</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<?php if(Session::has('fail')): ?>
					<div  align="center" id="successMessage" class="alert alert-danger"><?php echo e(Session::get('fail')); ?>

					</div>
					<?php endif; ?>
					<form action="<?php echo e(url('manager/notes')); ?>" class="bootstrap-modal-form form-horizontal" method="post">
						<?php echo e(csrf_field()); ?>

						<div class="modal-body">
							<div class="box-body">
								<div class="form-group" style="font-size: 18px;margin-left:140px; ">
									<label name="login_error"></label>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Client Name:</label>

									<div class="col-sm-9">
										<select class="form-control select2" name="client_id">
											<option value="">Select Client</option>
											<?php $__currentLoopData = $managers_clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $managers_client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($managers_client->id); ?>"><?php echo e($managers_client->name); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>  
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Notes Category:</label>
									<div class="col-sm-9">
										<input class="form-control" name="subject" placeholder="Subject" value="<?php echo e(old('subject')); ?>">
										<span class="text-danger"><?php echo e($errors->first('subject')); ?></span>	
									</div>
								</div>


								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Information:</label>
									<div class="col-sm-9">
										<textarea id="compose-textarea" class="form-control" name="message" style="height: 300px"><?php echo e(old('message')); ?></textarea>
										<span class="text-danger"><?php echo e($errors->first('message')); ?></span>
									</div>
								</div>

								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Attach File:</label>
									<div class="col-sm-9">
						                  <input type="file" name="attachments[]" class="form-control">
						                  </div>
									</div>
								</div>


								<div class="form-group" align="center">
									<a href="<?php echo e(url('manager/manage-client-notes')); ?>" class="btn btn-info">
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


	<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>