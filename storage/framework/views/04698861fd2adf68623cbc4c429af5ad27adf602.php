<?php $__env->startSection('title'); ?>
Business Client Appointments
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
					<h3 class="box-title">Appointments</h3>
					
					<!-- <a href="<?php echo e(url('employee/create-notes-category')); ?>" class="btn btn-info pull-right">
					 Add
				 </a>
				  -->
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
							<!-- <th>Category Name</th> -->
							<!-- <th>Added By</th> -->
							<th>Consultation With</th>
							<th>Appointment Date</th>
							<th>Start Time</th>
							<th>End Time</th>
							<!-- <th>Status</th> -->
						<!-- 	<th>Action</th> -->
						</tr>
					</thead>
					<tbody>
					<?php if(isset($all_data)): ?>
						<?php $__currentLoopData = $all_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($appointments['practionar_name']); ?> <?php echo e($appointments['practionar_surname']); ?></td>
							<td><?php echo e($appointments['date']); ?></td>
							<td><?php echo e($appointments['start_time']); ?></td>
							<td><?php echo e($appointments['end_time']); ?></td>
							<!-- <?php if($appointments['progress'] = 'Expired'): ?>
							<td>Expired</td>
							<?php else: ?>
							<td>Acitve-</td>
							<?php endif; ?> -->
						</tr>
					   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
				    <?php endif; ?> 
					
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
<script>
	var url = "<?php echo e(url('employee/delete-notes-category')); ?>";
	$(document).on('click','.delete-client',function(){
		if(confirm('Are you sure want to delete?')){
			var user_id = $(this).val();
			/*alert(user_id);*/
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				}
			})
			$.ajax({
				type: "DELETE",
				url: url + '/' + user_id,         
				success: function (data) {
					console.log(data);
					$('#sucMsgDeleteDiv').show('slow');
					setTimeout(function(){ $('#sucMsgDeleteDiv').hide('slow');location.reload(); }, 500);
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		}
	});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.client.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>