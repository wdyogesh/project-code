<?php $__env->startSection('title'); ?>
Business Client Details
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
					<h3 class="box-title"><?php echo e($data['client_name']); ?> <?php echo e($data['client_sur_name']); ?> Notes</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<?php if(Session::has('fail')): ?>
					<div  align="center" id="successMessage" class="alert alert-danger"><?php echo e(Session::get('fail')); ?>

					</div>
					<?php endif; ?>
					<form action="<?php echo e(url('client/create-client-notes')); ?>" class="bootstrap-modal-form form-horizontal" method="post" enctype="multipart/form-data">
						<?php echo e(csrf_field()); ?>

						<div class="modal-body">
							<div class="box-body">
								<div class="form-group" style="font-size: 18px;margin-left:140px; ">
									<label name="login_error"></label>
								</div>

									<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Client Name:</label>
									<div class="col-sm-5">
										<input class="form-control" name="category_name" placeholder="Category" value="<?php echo e($data['client_name']); ?> <?php echo e($data['client_sur_name']); ?>" readonly>
									</div>
								   </div>

								   <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Sur Name:</label>
									<div class="col-sm-5">
										<input class="form-control" name="category_name" placeholder="Category" value="<?php echo e($data['category_name']); ?>" readonly>
									</div>
								   </div>

								   <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Created By:</label>
									<div class="col-sm-5">
										<input class="form-control" name="category_name" placeholder="Category" value="<?php echo e($data['added_by']); ?> [<?php echo e($data['role_name']); ?>]" readonly>
									</div>
								   </div>

								    <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Created Date:</label>
									<div class="col-sm-5">
										<input class="form-control" name="category_name" placeholder="Category" value="<?php echo e($data['created_record_date']); ?>" readonly>
									</div>
								   </div>

								   <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Notes:</label>
									<div class="col-sm-5">
										<textarea id="compose-textarea" class="form-control" name="notes" style="height: 300px"><?php echo $data['notes']; ?></textarea>
									</div>
								   </div>
								 <?php if($data['file_name'] == ""): ?>
								 <?php else: ?>
                                  <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Uploaded File:</label>
									<div class="col-sm-5">
										<a href="<?php echo e(asset('uploads/client_notes_documents/' . $data['file_name'])); ?>" title="Download Document" class="btn btn-default btn-xs" download><i class="fa fa-cloud-download"></i><?php echo e($data['file_name']); ?></a>
									</div>
								   </div>
								 <?php endif; ?>  


								


								
								

								<div class="form-group" align="center">
									<a href="<?php echo e(url('client/manage-notes')); ?>" class="btn btn-info">
										Go back
									</a>
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