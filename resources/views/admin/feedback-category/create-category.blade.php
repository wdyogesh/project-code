@extends('admin.layouts.master')
@section('admin-title')
Admin-Create Feed Back Category
@endsection
@section('admin-pagelevel-styles')
@endsection
@section('admin-content')
<section class="content">
	<div class="row">
		<div class="col-xs-12">

			<!-- /.box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Create Category</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if (Session::has('fail'))
					<div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
					</div>
					@endif
					<form action="{{url('admin/create-feedback-categories')}}" class="bootstrap-modal-form form-horizontal" method="post">
						{{ csrf_field() }}
						<div class="modal-body">
							<div class="box-body">
								<div class="form-group" style="font-size: 18px;margin-left:140px; ">
									<label name="login_error"></label>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Category Name:</label>
									<div class="col-sm-5">
										<input class="form-control" name="category_name" placeholder="Category" value="{{old('category_name')}}">
										<span class="text-danger">{{ $errors->first('category_name') }}</span>	
									</div>
								</div>

								<div class="form-group" align="center">
									<a href="{{url('admin/feedback-categories')}}" class="btn btn-info">
										Go back
									</a>
									<button type="submit" class="btn btn-success">Submit</button>
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
	@section('admin-pagelevel-script')

<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
	@endsection
