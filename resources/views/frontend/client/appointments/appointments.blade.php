@extends('frontend.client.layouts.master')
@section('title')
Business Client Appointments
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
					<h3 class="box-title">Appointments</h3>
					
					<!-- <a href="{{url('employee/create-notes-category')}}" class="btn btn-info pull-right">
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
			 @if(Session::has('success'))
			 <div  align="center" id="successMessage"  class="alert alert-info">{{ Session::get('success') }}
			 </div>
			 @endif
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
					@if(isset($all_data))
						@foreach($all_data as $appointments)
						<tr>
							<td>{{$appointments['practionar_name']}} {{$appointments['practionar_surname']}}</td>
							<td>{{$appointments['date']}}</td>
							<td>{{$appointments['start_time']}}</td>
							<td>{{$appointments['end_time']}}</td>
							<!-- @if($appointments['progress'] = 'Expired')
							<td>Expired</td>
							@else
							<td>Acitve-</td>
							@endif -->
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
