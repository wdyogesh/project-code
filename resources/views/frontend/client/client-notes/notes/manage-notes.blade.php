@extends('frontend.client.layouts.master')
@section('title')
Business Manager-Client Notes
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
					<h3 class="box-title">My Notes</h3>
					
					<a href="{{url('client/create-notes')}}" class="btn btn-info pull-right">
					 Create
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
							<th>Client Name</th>
							<!-- <th>Added By</th> -->
							<th>Category</th>
							<th>Notes</th>
							<th>Document</th>
							<th>Created Date</th>
							<!-- <th>Updated Date</th> -->
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					@if(isset($all_client_notes))
						@foreach($all_client_notes as $notes)
						<tr>
							<td>{{$notes['client_name']}} {{$notes['client_sur_name']}}</td>
							<td>{{$notes['category_name']}}</td>
							<td>{!! str_limit($notes['notes'],20) !!}</td>
                           @if($notes['file_name'] == "")
                            <td>--</td>
                           @else
                            <td><a href="{{asset('uploads/client_notes_documents/' . $notes['file_name']) }}" title="Download Document" class="btn btn-default btn-xs" download><i class="fa fa-cloud-download"></i></a>{{$notes['file_name']}}</td>
                           @endif
							<td>{{$notes['created_record_date']}}</td>
							<!-- @if($notes['updated_record_date'] == "")
							<td>--</td>
							@else
							<td>{{$notes['updated_record_date']}}</td>
							@endif -->
							<td>
							 <a href="{{url('client/note-details/'.Hashids::encode($notes['notes_id']))}}" class="btn btn-warning btn-detail open_modal" title="Details">
								<span class="glyphicon glyphicon-folder-open"></span>
							 </a>
							 @if($notes['role_name'] == 'Business Manager' || $notes['role_name'] == 'Staff')
							 @else
							 <a href="{{url('client/edit-notes/'.Hashids::encode($notes['notes_id']))}}" class="btn btn-info" title="Edit">
								 <span class="glyphicon glyphicon-pencil"></span>
							 </a>
							 <button class="btn btn-danger btn-delete delete-client" value="{{$notes['notes_id']}}" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
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
	var url = "{{url('client/delete-notes')}}";
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
