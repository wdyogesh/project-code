@extends('frontend.employee.layouts.master')
@section('title')
Business Manager-Edit Client Notes Category
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
					<h3 class="box-title">Edit Category</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if (Session::has('fail'))
					<div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
					</div>
					@endif
					<form action="{{url('employee/edit-notes-category')}}" class="bootstrap-modal-form form-horizontal" method="post">
						{{ csrf_field() }}
						<div class="modal-body">
							<div class="box-body">
								<div class="form-group" style="font-size: 18px;margin-left:140px; ">
									<label name="login_error"></label>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Category Name:</label>
									<div class="col-sm-5">
										<input class="form-control" name="category_name" placeholder="Category" value="{{$notes_category['category_name']}}">
										<span class="text-danger">{{ $errors->first('category_name') }}</span>	
									</div>
								</div>
								<input type="hidden" name="category_id" value="{{$notes_category['id']}}">
								<input type="hidden" name="category_hidden_name" value="{{$notes_category['category_name']}}">

								<div class="form-group" align="center">
									<a href="{{url('employee/manage-notes-category')}}" class="btn btn-info">
										Go back
									</a>
									<button type="submit" class="btn btn-success">Update</button>
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
