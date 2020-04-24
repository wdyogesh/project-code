<?php $__env->startSection('title'); ?>
Business Manager-Client Management
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
					<h3 class="box-title">Manage Clients</h3>
					
					<a href="<?php echo e(url('manager/create-client')); ?>" class="btn btn-info pull-right">
					 Create New Client
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
							<th>Client Name</th>
							<th>Email</th>
							<th>Country</th>
							<th>Registration Id</th>
							<th>Phone Number</th>
							<!-- <th>Address</th> -->
							<th>Dateof Birth</th>
							<th>Created Date</th>
							<th>Updated Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $__currentLoopData = $managers_clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $managers_client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($managers_client->name); ?> <?php echo e($managers_client->surname); ?></td>
							<td><?php echo e($managers_client->email); ?></td>
							<td><?php echo e($managers_client->country); ?></td>
							<td><?php echo e($managers_client->registration_id); ?></td>
							<td><?php echo e($managers_client->country_code); ?><?php echo e($managers_client->phone_number); ?></td>
							<!-- <td><?php echo e($managers_client->address); ?></td> -->
							<td><?php echo e($managers_client->dateof_birth); ?></td>
							<td>
							<?php echo e($managers_client->client_table_created_date); ?>

							</td>
							<?php if($managers_client->client_table_update_date == null): ?>
							<td>--</td>
							<?php else: ?>
							<td>
							<?php echo e($managers_client->client_table_update_date); ?>

							</td>
							<?php endif; ?>
							<td>
						    <a href="<?php echo e(url('manager/client-details/'.Hashids::encode($managers_client->client_id))); ?>" class="btn btn-warning" title="Details">
								 <span class="glyphicon glyphicon-folder-open"></span>
							</a>
							<!--  <a href="<?php echo e(url('manager/edit-client/'.Hashids::encode($managers_client->client_id))); ?>" class="btn btn-info" title="Edit">
								 <span class="glyphicon glyphicon-pencil"></span>
							 </a> -->
							 <button class="btn btn-danger btn-delete delete-client" value="<?php echo e($managers_client->client_id); ?>" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
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
<script>
	var url = "<?php echo e(url('manager/delete-client')); ?>";
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

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>