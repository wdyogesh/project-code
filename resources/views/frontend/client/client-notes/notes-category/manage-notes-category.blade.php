@extends('frontend.employee.layouts.master')
@section('title')
Business Manager-Client Notes Category
@endsection
@section('pagelevel-styles')
@endsection
@section('content')
<section class="content">
	<div class="row">
		<div class="col-xs-12">
		 
			<!-- /.box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Notes Category</h3>
					
					<a href="{{url('employee/create-notes-category')}}" class="btn btn-info pull-right">
					 Add
				 </a>
				 
			 </div>
			 <div class="alert alert-success alert-dismissable" id="sucMsgDeleteDiv" style="display: none;">
				 <i class="fa fa-check"></i>
				 <b>Record Deleted Success!</b>
				 <span class="sucmsgdiv"></span>                     
			 </div>
			 <!-- /.box-header -->
			 @if(Session::has('success'))
			 <div  align="center" id="successMessage"  class="alert alert-info">{{ Session::get('success') }}
			 </div>
			 @endif
			 <div class="box-body">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Category Name</th>
							<th>Added By</th>
							<th>Created Date</th>
							<th>Updated Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					@if(isset($all_records))
						@foreach($all_records as $category)
						<tr>
							<td>{{ucfirst($category['category_name'])}}</td>
							<td>{{$category['added_by']}}<b>[{{$category['role_name']}}]</b></td>
							<td>{{$category['created_record_date']}}</td>
							@if($category['created_record_date'] == "")
							<td>--</td>
							@else
							<td>{{$category['updated_record_date']}}</td>
							@endif
							<td>
							@if($category['role_name'] == "Business Manager")
							--
							@else
							 <a href="{{url('employee/edit-notes-category/'.Hashids::encode($category['category_id']))}}" class="btn btn-info" title="Edit">
							 <span class="glyphicon glyphicon-pencil"></span>
							  </a>
							@endif
								 
							@if($category['role_name'] == "Business Manager")
							--
							@else
							 <button class="btn btn-danger btn-delete delete-client" value="{{$category['category_id']}}" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
							@endif
						    </td>
                        </tr>
					   @endforeach 
				    @endif 
					
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
@endsection
@section('pagelevel-script')
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
	var url = "{{url('employee/delete-notes-category')}}";
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
@endsection
