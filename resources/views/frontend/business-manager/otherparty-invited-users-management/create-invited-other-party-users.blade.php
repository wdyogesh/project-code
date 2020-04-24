@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Send Other Party Invitation
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
					<h3 class="box-title">Send Invitation For Other Party Users</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if (Session::has('fail'))
					<div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
					</div>
					@endif
					<form action="{{url('manager/send-other-party-invitation')}}" class="bootstrap-modal-form form-horizontal" method="post">
						{{ csrf_field() }}
						<div class="modal-body">
							<div class="box-body">
							 <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                                </div>
							    <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Category</label>
									<div class="col-sm-5">
										<select class="form-control" name="category_name">
											<option value="" selected>select..</option>
											@foreach($categories as $categorie)
											<option value="{{$categorie->id}}">{{$categorie->category_name	}}</option>
											@endforeach
										</select>
										<span class="text-danger">{{ $errors->first('category_name') }}</span>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Name" name="other_party_user_name" value="{{old('other_party_user_name')}}" maxlength="25">
										<span class="text-danger">{{ $errors->first('	other_party_user_name') }}</span>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
									<div class="col-sm-5">
										<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Other Party User Email" name="other_party_email" value="{{old('other_party_email')}}" maxlength="40">
										<span class="text-danger">{{ $errors->first('	other_party_email') }}</span>
									</div>
								</div>
								
								</div>
                            <div class="form-group" align="center">
								<a href="{{url('manager/invite-other-party')}}" class="btn btn-info">
									Go back
								</a>
								<button type="submit" class="btn btn-success">Send Invitation</button>
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
