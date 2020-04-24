@extends('frontend.client.layouts.master')
@section('title')
Business Manager-Edit Client Notes
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
					<h3 class="box-title">Edit Client Notes</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if (Session::has('fail'))
					<div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
					</div>
					@endif
					<form action="{{url('client/update-notes')}}" class="-bootstrap-modal-form form-horizontal" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="modal-body">
							<div class="box-body">
								<div class="form-group" style="font-size: 18px;margin-left:140px; ">
									<label name="login_error"></label>
								</div>
                                <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Category:</label>
									<div class="col-sm-9">
										<select class="form-control" name="category_name">
											<option value="">Select Category</option>
											@foreach($notes_category as $category)
											<option value="{{$category->id}}" @if($notes['category_name'] == $category->id) selected="select" @endif>{{$category->category_name}}</option>
											@endforeach
										</select>  
										<span class="text-danger">{{ $errors->first('category_name') }}</span>	
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Notes:</label>
									<div class="col-sm-9">
										<textarea id="compose-textarea" class="form-control" name="notes" style="height: 300px">{!! $notes['notes'] !!}</textarea>
										<span class="text-danger">{{ $errors->first('notes') }}</span>
									</div>
								</div>

								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Attach File:</label>
									<div class="col-sm-9">
						                  <input type="file" name="attachment" class="form-control">
						                  </div>
						                  <span class="text-danger">{{ $errors->first('attachment') }}</span>
									</div>

								</div>
								@if($notes['file_name'] == "")
								 @else
                                  <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Uploaded File:</label>
									<div class="col-sm-5">
										<a href="{{asset('uploads/client_notes_documents/' . $notes['file_name']) }}" title="Download Document" class="btn btn-default btn-xs" download><i class="fa fa-cloud-download"></i>{{$notes['file_name']}}</a>
									</div>
								   </div>
								 @endif 
								 <input type="hidden" name="notes_id" value="{{$notes->id}}">
								<div class="form-group" align="center">
									<a href="{{url('client/manage-notes')}}" class="btn btn-info">
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
