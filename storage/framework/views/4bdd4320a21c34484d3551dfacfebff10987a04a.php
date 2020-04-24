
<?php $__env->startSection('title'); ?>
Business Manager-Ticket Management
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
					<h3 class="box-title">My Tickets</h3>
					
					<a href="<?php echo e(url('manager/create-ticket')); ?>" class="btn btn-info pull-right">
					 New
				 </a>
				 
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
							<th>Ticket Id</th>
							<th>Category</th>
							<th>Subject</th>
							<th>Created Date</th>
							<th>Last Action</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php $__currentLoopData = $my_tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $my_ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($my_ticket->ticket_id); ?></td>
							<td><?php echo e($my_ticket->category); ?></td>
							<td><?php echo str_limit($my_ticket->subject,20); ?></td>
							<td><?php echo e($my_ticket->record_created_date); ?></td>
							<td><?php echo e($my_ticket->record_updated_date); ?></td>
							<td><?php echo e($my_ticket->status); ?></td>
							<td>
							<a href="<?php echo e(url('manager/open-thread/'.Hashids::encode($my_ticket->id))); ?>" class="btn btn-info">Open Thread
							</a>
							<?php if($my_ticket->closed ==1): ?>
							<a href="#" class=" btn btn-success">Resolved</a>
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