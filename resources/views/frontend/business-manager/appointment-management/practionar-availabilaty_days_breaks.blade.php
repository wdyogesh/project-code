@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Practionar availability
@endsection
@section('pagelevel-styles')
<!-- new date picker style start-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>  
<!-- new date picker style start-->
@endsection
@section('content')
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			
			<!-- /.box -->
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Editing {{$practionar['name']}} {{$practionar['surname']}} availability</h3>
				</div>
				<div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              
         
            <div class="col-md-1">
                <div class="dropdown">
                  <a href="{{url('manager/face-to-face-consultant-availability/'.$hashemployeeid)}}" class="btn {{Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid) ? 'btn-warning' : 'btn-default'}}"><span class="">Sunday</span></a>
                </div>
            </div>

            <div class="col-md-1">
                <div class="dropdown">
                  <a href="{{url('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'mon')}}" class="btn {{ Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'mon') ? 'btn-warning' : 'btn-default'}}"><span class="">Monday</span></a>
                </div>
            </div>
            <div class="col-md-1">
                <div class="dropdown">
                <a href="{{url('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'tue')}}" class="btn {{ Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'tue') ? 'btn-warning' : 'btn-default'}}"><span class="">Tuesday</span></a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="dropdown">
                  <a href="{{url('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'wed')}}" class="btn {{ Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'wed') ? 'btn-warning' : 'btn-default'}}"><span class="">Wednesday</span></a>
                </div>
            </div>
              
            <div class="col-md-1">
                <div class="dropdown">
                  <a href="{{url('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'thu')}}" style="margin-left: -60px;" class="btn {{ Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'thu') ? 'btn-warning' : 'btn-default'}}"><span class="">Thursday</span></a>
                </div>
            </div>

            <div class="col-md-1">
                <div class="dropdown">
                  <a href="{{url('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'fri')}}" style="margin-left: -53px;" class="btn {{ Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'fri') ? 'btn-warning' : 'btn-default'}}"><span class="">Friday</span></a>
                </div>
            </div>

            <div style="margin-left: -65px;" class="col-md-1">
                <div class="dropdown">
                 <a href="{{url('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'sat')}}" class="btn {{ Request::is('manager/face-to-face-consultant-availability/'.$hashemployeeid.'/'.'sat') ? 'btn-warning' : 'btn-default'}}"><span class="">Saturday</span></a>
                </div>
            </div>
             
           
            </div>
            <!-- /.box-header -->
       
				<!-- /.box-header -->
				<div class="box-body">
					@if (Session::has('fail'))
					<div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
					</div>
					@endif
					@if ($errors->any())
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				    @endif
					<form action="{{url('manager/face-to-face-consultant-availability')}}" class="-bootstrap-modal-form form-horizontal" method="post">
						{{ csrf_field() }}
						<div class="modal-body">
							<div class="box-body">
                    <!--  //availability time-->

                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Availability Time:</label>
								<div class="col-sm-8">
                                   @if($availability_start_time == "")
									<div class="col-sm-3 bootstrap-timepicker">
									  <input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="availability_start_time" value="{{old('availability_start_time')}}">
						            </div>
						            @else
						            <div class="col-sm-3 bootstrap-timepicker">
									  <input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="availability_start_time" value="{{$availability_start_time}}">
						            </div>
						            @endif
		

							         <div class="col-sm-1" style="margin-left: -2px;margin-top: 4px;">
							         --
							         </div>
                                @if($availability_end_time == "")
					                <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter End Time" name="availability_end_time" value="{{old('availability_end_time')}}">
						            </div>
						        @else
						            <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter End Time" name="availability_end_time" value="{{$availability_end_time}}">
						            </div>
						        @endif     
								</div>
						</div>
	                <!--  //availability time end -->
                  
	                <!--  //break1 time-->
                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Break-1:</label>
								<div class="col-sm-8">
								 @if($break1_start_time == "")
									<div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="break1_start_time" value="{{old('break1_start_time')}}">
						            </div>
						         @else
						           <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="break1_start_time" value="{{$break1_start_time}}">
						            </div>
						         @endif   
						           

						           <div class="col-sm-1" style="margin-left: -2px;margin-top: 4px;">--</div>
						            @if($break1_end_time == "")
					                <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter End Time" name="break1_end_time" value="{{old('break1_end_time')}}">
						            </div>
						            @else
						             <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter End Time" name="break1_end_time" value="{{$break1_end_time}}">
						             </div>
						            @endif
									
								</div>
						</div>
	                <!--  //break1 time end -->

	                <!--  //break2 time-->
                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Break-2:</label>
								<div class="col-sm-8">
								@if($break2_start_time == "")
									<div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="break2_start_time" value="{{old('break2_start_time')}}">
									</div>
							    @else
							       <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="break2_start_time" value="{{$break2_start_time}}">
									</div>
							    @endif		
						           

						        <div class="col-sm-1" style="margin-left: -2px;margin-top: 4px;">--</div>
						          @if($break2_end_time == "")
					                <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter End Time" name="break2_end_time" value="{{old('break2_end_time')}}">
						            </div>
						          @else
						           <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter End Time" name="break2_end_time" value="{{$break2_end_time}}">
						            </div>
						          @endif   
									
								</div>
						</div>
	                <!--  //break2 time end -->

	                <!--  //break3 time-->
                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Break-3:</label>
								<div class="col-sm-8">
								 @if($break3_start_time == "")
									<div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="break3_start_time" value="{{old('break3_start_time')}}">
									</div>
							    @else
							        <div class="col-sm-3 bootstrap-timepicker">
										<input type="text" class="form-control timepicker" id="start_time" placeholder="Enter Start Time" name="break3_start_time" value="{{$break3_start_time}}">
									</div>
							    @endif		
						           

						       <div class="col-sm-1" style="margin-left: -2px;margin-top: 4px;">--</div>

                               @if($break3_end_time == "")
								<div class="col-sm-3 bootstrap-timepicker">
								<input type="text" class="form-control timepicker" id="break3_end_time" placeholder="Enter End Time" name="break3_end_time" value="{{old('break3_end_time')}}">
								</div>
							  @else
							  <div class="col-sm-3 bootstrap-timepicker">
								<input type="text" class="form-control timepicker" id="break3_end_time" placeholder="Enter End Time" name="break3_end_time" value="{{$break3_end_time}}">
							  @endif	
						           
									
								</div>
						</div>
	                <!--  //break3 time end -->
                          
                           <input type="hidden" name="when_update_record_employee_id" value="{{$practionar_employee_id}}">
                        
                           <input type="hidden" name="dayname" value="{{$dayname}}">
                           <input type="hidden" name="practionar_id" value="{{$practionar_id}}">
                           <input type="hidden" name="hashemployeeid" value="{{$hashemployeeid}}">
                           <div class="form-group" style="margin-left: 306px;">
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
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	
	@endsection
	@section('pagelevel-script')
	<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
     <script type="text/javascript">
	  $('.colorpicker').colorpicker();

	 $('#start_time').timepicker({defaultTime: '07:00 AM'});

	</script>
	<!-- <script type="text/javascript">
		function valueChanged()
    {
        if($('.coupon_question').is(":checked"))   
            $(".add_breakes").show();
        else
            $(".add_breakes").hide();
    }
	</script> -->
	
	@endsection
