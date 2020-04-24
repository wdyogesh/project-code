@extends('frontend.business-manager.layouts.master')
@section('title')
Other Party Details
@endsection
@section('pagelevel-styles')
<!-- new date picker style start-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- new date picker style start-->
@endsection
@section('content')
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			
			<!-- /.box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Details</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if (Session::has('fail'))
					<div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
					</div>
					@endif
					<form action="#" class="bootstrap-modal-form form-horizontal" method="post">
						{{ csrf_field() }}
						<div class="modal-body">
							<div class="box-body">
							 <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                                </div>
                                <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Account Verification</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Name" name="other_party_user_name" value="@if($main_other_party_register_users[0]['account_verification'] == 0) Not Completed @else Done @endif" readonly>
									</div>
								</div> 

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Registration Id</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Name" name="other_party_user_name" value="{{$main_other_party_register_users[0]['registration_id']}}" readonly>
									</div>
								</div> 
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Name" name="other_party_user_name" value="{{$main_other_party_register_users[0]['name']}}" maxlength="25" readonly>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Email" name="other_party_email" value="{{$main_other_party_register_users[0]['email']}}" readonly>
									
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Phone</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Email" name="other_party_email" value="{{$main_other_party_register_users[0]['country_code']}} {{$main_other_party_register_users[0]['area_code']}} {{$main_other_party_register_users[0]['phone_number']}}" readonly>
									
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Country</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Email" name="other_party_email" value="{{$main_other_party_register_users[0]['country']}}" readonly>
									
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">State</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Email" name="other_party_email" value="{{$main_other_party_register_users[0]['state']}}" readonly>
									
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">City</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Email" name="other_party_email" value="{{$main_other_party_register_users[0]['city']}}" readonly>
									
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Other Party Category</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Email" name="other_party_email" value="{{$main_other_party_register_users[0]['invitation_category_name']}}" readonly>
									
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Registration Date</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Email" name="other_party_email" value="{{$main_other_party_register_users[0]['main_user_table_created_record_date']}}" readonly>
									
									</div>
								</div>
								
								</div>
                            <div class="form-group" align="center">
								<a href="{{url('manager/manage-other-parties')}}" class="btn btn-info">
									Go back
								</a>
							</div>
								

								</div>
							</div>
							
						</form>
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
	<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
	@endsection
