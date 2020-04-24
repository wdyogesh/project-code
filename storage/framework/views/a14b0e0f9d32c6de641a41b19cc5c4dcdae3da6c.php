<?php $__env->startSection('title'); ?>
Business Manager-Reset Password Management
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
		 
			<!-- /.box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">All Requests</h3>
					
				<!-- 	<a href="<?php echo e(url('manager/create-ticket')); ?>" class="btn btn-info pull-right">
					 New
				 </a> -->
				 
			 </div>
			 <div class="alert alert-success alert-dismissable" id="sucMsgDeleteDiv" style="display: none;">
				 <i class="fa fa-check"></i>
				 <b>Record Deleted Success!</b>
				 <span class="sucmsgdiv"></span>                     
			 </div>
			 <!-- /.box-header -->
			 <?php if(Session::has('success')): ?>
			 <div  align="center" id="successMessage"  class="alert alert-info"><?php echo e(Session::get('success')); ?>

			 </div>
			 <?php endif; ?>
			 <div class="box-body">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Request Id</th>
							<th>Role</th>
							<th>Email</th>
							<th>Requested Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $__currentLoopData = $my_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $my_request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($my_request->request_id); ?></td>
							<td><?php echo e($my_request->role_name); ?></td>
							<td><?php echo e($my_request->email); ?></td>
							<td><?php echo e($my_request->created_record_date); ?></td>
							<td>
							<?php if($my_request->status == 0): ?>
							<a href="<?php echo e(url('manager/send-reset-link/'.str_slug($my_request->role_name,'-').'/'.Hashids::encode($my_request->id))); ?>" class="btn btn-info">Send Reset Link
							</a>
							<?php else: ?>
							<td>---</td>
							<?php endif; ?>
						  </td>
						</tr>
					     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
					
				</tbody>
				
			</table>
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
<meta name="_token" content="<?php echo csrf_token(); ?>" />
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>