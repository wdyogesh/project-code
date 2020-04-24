@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Other Party Invited User Management
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
					<h3 class="box-title">Invited Other Party Users</h3>
					
					<a href="{{url('manager/send-other-party-invitation')}}" class="btn btn-info pull-right">
					 Send New Invitation
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
							<th>Id</th>
							<th>Category Name</th>
							<th>Other Party Name</th>
							<th>Other Party Email</th>
							<th>Invitation Sent By</th>
							<th>Sent Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php $i=1;?>
					@if(isset($main_other_party_invitation_sent_users))
						@foreach($main_other_party_invitation_sent_users as $other_party_invited_user)
						<tr>
							<td>{{$i++}}</td>
							<td>{{$other_party_invited_user['category_name']}}</td>
							<td>{{$other_party_invited_user['other_party_name']}}</td>
							<td>{{$other_party_invited_user['other_party_email']}}</td>
							<td>{{$other_party_invited_user['sent_by_name']}} {{$other_party_invited_user['sent_by_surname']}}  (<b>{{$other_party_invited_user['sent_by_role']}}</b>)</td>
							<td>{{$other_party_invited_user['created_record_date']}}</td>
                            <td>
                            @if($other_party_invited_user['registration_completed'] == 1)
                            <button class="btn btn-success"><span class="fa fa-user"></span> User Registered</button>
                            @elseif($other_party_invited_user['registration_completed'] == 0)
                             <button class="btn btn-danger btn-warning" value=""><span class="fa fa-user"></span> Registration Pending</button>
							
							@else
							 <button class="btn btn-danger btn-delete delete-employee" value="{{$other_party_invited_user['otherparty_id']}}" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
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
var url = "{{url('manager/delete-other-party-invitation')}}";
$(document).on('click','.delete-employee',function(){
	if(confirm('Are you sure want to delete?')){
		var other_party_link_sent_id = $(this).val();
		/*alert(user_id);*/
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		$.ajax({
			type: "DELETE",
			url: url + '/' + other_party_link_sent_id,         
			success: function (data) {
				console.log(data);
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

@endsection
