@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Reset Password Management
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
					<h3 class="box-title">All Requests</h3>
					
				<!-- 	<a href="{{url('manager/create-ticket')}}" class="btn btn-info pull-right">
					 New
				 </a> -->
				 
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
						@foreach($my_requests as $my_request)
						<tr>
							<td>{{$i++}}</td>
							<td>{{$my_request->request_id}}</td>
							<td>{{$my_request->role_name}}</td>
							<td>{{$my_request->email}}</td>
							<td>{{$my_request->created_record_date}}</td>
							<td>
							@if($my_request->status == 0)
							<a href="{{url('manager/send-reset-link/'.str_slug($my_request->role_name,'-').'/'.Hashids::encode($my_request->id))}}" class="btn btn-info">Send Reset Link
							</a>
							@else
							<td>---</td>
							@endif
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
@endsection
