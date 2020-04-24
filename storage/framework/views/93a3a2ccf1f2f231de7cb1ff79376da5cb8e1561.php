<?php $__env->startSection('title'); ?>
Business Manager-Other Party Category Management
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
					<h3 class="box-title">Manage Other Party Categories</h3>
					
					<a href="<?php echo e(url('manager/create-other-party-category')); ?>" class="btn btn-info pull-right">
					 Create Category
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
							<th>Id</th>
							<th>Category Name</th>
							<th>Created Date</th>
							<th>Updated Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php $i=1;?>
						<?php $__currentLoopData = $other_party_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $other_party_categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($i++); ?></td>
							<td><?php echo e($other_party_categorie->category_name); ?></td>
							<td><?php echo e($other_party_categorie->created_record_date); ?></td>
							<?php if($other_party_categorie->updated_record_date == ""): ?>
							<td>--</td>
							<?php else: ?>
							<td><?php echo e($other_party_categorie->updated_record_date); ?></td>
							<?php endif; ?>

							
							<td>
							  <a href="<?php echo e(url('manager/edit-other-party-category/'.Hashids::encode($other_party_categorie->id))); ?>" class="btn btn-info" title="Edit">
								 <span class="glyphicon glyphicon-pencil"></span>
							 </a>
							 <button class="btn btn-danger btn-delete delete-employee" value="<?php echo e($other_party_categorie->id); ?>" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
							 
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Complete Details</h4>
            </div>
            <div class="modal-body">
            <form id="frmProducts" name="frmProducts" class="form-horizontal" novalidate="">
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Role</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="business_manager_role_name" name="business_manager_role_name" placeholder="Role Name" value="" readonly>
                    </div>
                </div> 
                <div class="form-group error">
                 <label for="inputName" class="col-sm-3 control-label">Full Name</label>
                   <div class="col-sm-9">
                    <input type="text" class="form-control has-error" id="name" name="name" placeholder="Product Name" value="" readonly="">
                   </div>
                   </div>

                 <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Date of Birth</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="dateof_birth" name="dateof_birth" placeholder="Date of birth" value="" readonly>
                    </div>
                </div>  

                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="" readonly>
                    </div>
                </div>
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Country</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="" readonly>
                    </div>
                </div>
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">State</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="state" name="state" placeholder="state" value="" readonly>
                    </div>
                </div>
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">City</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" value="" readonly>
                    </div>
                </div>
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Phone</label>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" id="country_code" name="country_code" placeholder="Country Code" value="" readonly>
                    </div>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" id="area_code" name="area_code" placeholder="Area Code" value="" readonly>
                    </div>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" value="" readonly>
                    </div>
                </div>
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" value="" readonly>
                    </div>
                </div>
                
            </form>
            </div>
           <!--  <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
            <input type="hidden" id="product_id" name="product_id" value="0">
            </div> -->
        </div>
      </div>
  </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>
<meta name="_token" content="<?php echo csrf_token(); ?>" />
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<script>
var url = "<?php echo e(url('manager/delete-other-party-category')); ?>";
var url_employee_details = "<?php echo e(url('manager/employee-details')); ?>";
$(document).on('click','.delete-employee',function(){
	if(confirm('Are you sure want to delete?')){
		var user_id = $(this).val();
		/*alert(user_id);*/
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		$.ajax({
			type: "GET",
			url: url + '/' + user_id,         
			success: function (data) {
				//console.log(data);
			//$("#user" + user_id).remove();
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