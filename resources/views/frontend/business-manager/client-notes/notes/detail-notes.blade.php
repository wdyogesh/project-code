@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Create Client
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
					<h3 class="box-title">{{$data['client_name']}} {{$data['client_sur_name']}} Notes</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if (Session::has('fail'))
					<div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
					</div>
					@endif
					<form action="{{url('manager/create-client-notes')}}" class="bootstrap-modal-form form-horizontal" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="modal-body">
							<div class="box-body">
								<div class="form-group" style="font-size: 18px;margin-left:140px; ">
									<label name="login_error"></label>
								</div>

									<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Client Name:</label>
									<div class="col-sm-5">
										<input class="form-control" name="category_name" placeholder="Category" value="{{$data['client_name']}} {{$data['client_sur_name']}}" readonly>
									</div>
								   </div>

								   <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Sur Name:</label>
									<div class="col-sm-5">
										<input class="form-control" name="category_name" placeholder="Category" value="{{$data['category_name']}}" readonly>
									</div>
								   </div>

								   <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Created By:</label>
									<div class="col-sm-5">
										<input class="form-control" name="category_name" placeholder="Category" value="{{$data['added_by']}} [{{$data['role_name']}}]" readonly>
									</div>
								   </div>

								    <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Created Date:</label>
									<div class="col-sm-5">
										<input class="form-control" name="category_name" placeholder="Category" value="{{$data['created_record_date']}}" readonly>
									</div>
								   </div>

								   <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Notes:</label>
									<div class="col-sm-5">
										<textarea id="compose-textarea" class="form-control" name="notes" style="height: 300px">{!! $data['notes'] !!}</textarea>
									</div>
								   </div>
								 @if($data['file_name'] == "")
								 @else
                                  <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Uploaded File:</label>
									<div class="col-sm-5">
										<a href="{{asset('uploads/client_notes_documents/' . $data['file_name']) }}" title="Download Document" class="btn btn-default btn-xs" download><i class="fa fa-cloud-download"></i>{{$data['file_name']}}</a>
									</div>
								   </div>
								 @endif  


								


								
								

								<div class="form-group" align="center">
									<a href="{{url('manager/manage-client-notes')}}" class="btn btn-info">
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

		<!-- /.row -->
	</section>

	@endsection
	@section('pagelevel-script')
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>

	@endsection
