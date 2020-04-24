@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Practionar Settings
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
					<h3 class="box-title">Face to face consultation staff</h3>
					
					<!-- <a href="{{url('manager/create-employees')}}" class="btn btn-info pull-right">
					 Create New Employee
				    </a> -->
				   
				 
			 </div>
			<!--  <div class="alert alert-success alert-dismissable" id="sucMsgDeleteDiv" style="display: none;">
				 <i class="fa fa-check"></i>
				 <b>Record Deleted Success!</b>
				 <span class="sucmsgdiv"></span>                     
			 </div> -->
			 
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
							<th>Employee Name</th>
							<th>Email</th>
							<th>Action</th>	
						</tr>

					</thead>
					<tbody>
					<?php $i=1;?>
						@foreach($managers_face_to_face_employees as $managers_employee)
						<tr>
							<td>{{$i++}}</td>
							<td>{{ucfirst($managers_employee->name)}} {{ucfirst($managers_employee->surname)}}</td>
							<td>{{$managers_employee->email}}</td>
							<td>
							<a href="{{url('manager/face-to-face-consultant-availability/'.Hashids::encode($managers_employee->main_user_id))}}" class="btn btn-info" title="Edit">
								 <span class="fa fa-cog"></span> 
							</a>
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
