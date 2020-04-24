@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Client Management
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
					<h3 class="box-title">Manage Clients</h3>
					
					<a href="{{url('manager/create-client')}}" class="btn btn-info pull-right">
					 Create New Client
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
						@foreach($managers_clients as $managers_client)
						<tr>
							<td>{{$managers_client->name}} {{$managers_client->surname}}</td>
							<td>{{$managers_client->email}}</td>
							<td>{{$managers_client->country}}</td>
							<td>{{$managers_client->registration_id}}</td>
							<td>{{$managers_client->country_code}}{{$managers_client->phone_number}}</td>
							<!-- <td>{{$managers_client->address}}</td> -->
							<td>{{$managers_client->dateof_birth}}</td>
							<td>
							{{$managers_client->client_table_created_date}}
							</td>
							@if($managers_client->client_table_update_date == null)
							<td>--</td>
							@else
							<td>
							{{$managers_client->client_table_update_date}}
							</td>
							@endif
							<td>
						    <a href="{{url('manager/client-details/'.Hashids::encode($managers_client->client_id))}}" class="btn btn-warning" title="Details">
								 <span class="glyphicon glyphicon-folder-open"></span>
							</a>
							<!--  <a href="{{url('manager/edit-client/'.Hashids::encode($managers_client->client_id))}}" class="btn btn-info" title="Edit">
								 <span class="glyphicon glyphicon-pencil"></span>
							 </a> -->
							 <button class="btn btn-danger btn-delete delete-client" value="{{$managers_client->client_id}}" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
						 </td>
                       </tr>
					@endforeach  
					
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
	var url = "{{url('manager/delete-client')}}";
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
