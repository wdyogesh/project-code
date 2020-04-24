<?php $__env->startSection('title'); ?>
Business Manager-Practionar Settings
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
					<h3 class="box-title">Face to face consultation staff</h3>
					
					<!-- <a href="<?php echo e(url('manager/create-employees')); ?>" class="btn btn-info pull-right">
					 Create New Employee
				    </a> -->
				   
				 
			 </div>
			<!--  <div class="alert alert-success alert-dismissable" id="sucMsgDeleteDiv" style="display: none;">
				 <i class="fa fa-check"></i>
				 <b>Record Deleted Success!</b>
				 <span class="sucmsgdiv"></span>                     
			 </div> -->
			 
			 <!-- /.box-header -->
			 <?php if(Session::has('success')): ?>
			 <div  align="center" id="successMessage"  class="alert alert-info"><?php echo e(Session::get('success')); ?>

			 </div>
			 <?php endif; ?>
			 <div class="box-body">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					
						<tr>
							<th>Id</th>
							<th>Employee Name</th>
							<th>Email</th>
							<th>Action</th>	
						</tr>

					</thead>
					<tbody>
					<?php $i=1;?>
						<?php $__currentLoopData = $managers_face_to_face_employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $managers_employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e(ucfirst($managers_employee->name)); ?> <?php echo e(ucfirst($managers_employee->surname)); ?></td>
							<td><?php echo e($managers_employee->email); ?></td>
							<td>
							<a href="<?php echo e(url('manager/face-to-face-consultant-availability/'.Hashids::encode($managers_employee->main_user_id))); ?>" class="btn btn-info" title="Edit">
								 <span class="fa fa-cog"></span> 
							</a>
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