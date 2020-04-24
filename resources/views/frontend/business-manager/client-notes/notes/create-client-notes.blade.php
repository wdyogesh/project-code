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
					<h3 class="box-title">Client Notes</h3>
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

									<div class="col-sm-9">
										<select class="form-control select2" name="client_name">
											<option value="">Select Client</option>
											@foreach($managers_clients as $managers_client)
											<option value="{{$managers_client->id}}">{{$managers_client->name}}</option>
											@endforeach
										</select>  
									</div>
									<span class="text-danger">{{ $errors->first('client_name') }}</span>	
								</div>



								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Category:</label>
									<div class="col-sm-9">
										<select class="form-control" name="category_name">
											<option value="">Select Category</option>
											@foreach($notes_category as $category)
											<option value="{{$category->id}}">{{$category->category_name}}</option>
											@endforeach
										</select>  
										<span class="text-danger">{{ $errors->first('category_name') }}</span>	
									</div>
								</div>


								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Notes:</label>
									<div class="col-sm-9">
										<textarea id="compose-textarea" class="form-control" name="notes" style="height: 300px">{{old('notes')}}</textarea>
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

								<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Other Party:</label>
								<div class="col-sm-9">
									<select class="form-control" name="other_party">
										<option value="">Link Other Party</option>
										@if(isset($otherparties))
										@foreach($otherparties as $otherpartie)
										<option value="{{$otherpartie['id']}}">{{$otherpartie['user_name']}} [{{$otherpartie['category_name']}}]</option>
										@endforeach
										@endif
									</select>  
									<span class="text-danger">{{ $errors->first('other_party') }}</span>	
								</div>
							</div>


								<div class="form-group" align="center">
									<a href="{{url('manager/manage-client-notes')}}" class="btn btn-info">
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
	@section('pagelevel-script')
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>

	@endsection
