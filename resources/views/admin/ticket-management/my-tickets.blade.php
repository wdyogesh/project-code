@extends('admin.layouts.master')
@section('admin-title')
Admin-Business Manager Tickets
@endsection
@section('admin-pagelevel-styles')
@endsection
@section('admin-content')
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">My Tickets</h3>
					
					<a href="{{url('admin/create-ticket')}}" class="btn btn-info pull-right">
					 New
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
							<th>S.No</th>
							<th>Ticket Id</th>
							<th>Business Name</th>
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
						@foreach($my_tickets as $my_ticket)
						<tr>
							<td>{{$i++}}</td>
							<td>{{$my_ticket->ticket_id}}</td>
							<td>{{$my_ticket->business_name}}</td>
							<td>{{$my_ticket->category}}</td>
							<td>{!! str_limit($my_ticket->subject,20) !!}</td>	
							<td>{{$my_ticket->record_created_date}}</td>
							<td>{{$my_ticket->record_updated_date}}</td>
							<td>{{$my_ticket->status}}</td>
							<td>
							<a href="{{url('admin/open-thread/'.Hashids::encode($my_ticket->id))}}" class="btn btn-info">Open Thread</a>
                            @if($my_ticket->closed == 0)
							<a href="{{url('admin/closed-tickets/'.$my_ticket->id)}}" class=" btn btn-danger">Close Ticket</a>
							@else
							 <a href="#" class=" btn btn-success">Resolved</a> 
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
