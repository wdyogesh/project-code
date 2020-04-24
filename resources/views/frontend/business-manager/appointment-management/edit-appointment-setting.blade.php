@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Edit Employee
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
					<h3 class="box-title">Manage appointment settings</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					@if (Session::has('fail'))
					<div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
					</div>
					@endif
					<form action="{{url('manager/appointment-settings-update')}}" class="-bootstrap-modal-form form-horizontal" method="post">
						{{ csrf_field() }}
						<div class="modal-body">
							<div class="box-body">
								<div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                                </div>
                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Slot Duration:</label>
								<div class="col-sm-8">
									<div class="col-sm-2">
										<select id="country" name="time_slot_size" class="form-control">
										  <option value="10" @if($count_record['time_slot_size'] == 10) selected="select" @endif>10</option>
						                  <option value="15" @if($count_record['time_slot_size'] == 15) selected="select" @endif>15</option>
						                  <option value="30" @if($count_record['time_slot_size'] == 30) selected="select" @endif>30</option>
						                </select>
						            </div>
								</div>
								</div>
                              <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                                </div>
                                <div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Calendar time range:</label>
								<div class="col-sm-8">
									<div class="col-sm-2">
										<select id="country" name="business_time_start" class="form-control">
						                  <option value="0"@if($count_record['business_time_start'] == 0) selected="select" @endif>0</option>
						                  <option value="1"@if($count_record['business_time_start'] == 1) selected="select" @endif>1</option>
						                  <option value="2"@if($count_record['business_time_start'] == 2) selected="select" @endif>2</option>
						                  <option value="3"@if($count_record['business_time_start'] == 3) selected="select" @endif>3</option>
						                  <option value="4"@if($count_record['business_time_start'] == 4) selected="select" @endif>4</option>
						                  <option value="5"@if($count_record['business_time_start'] == 5) selected="select" @endif>5</option>
						                  <option value="6"@if($count_record['business_time_start'] == 6) selected="select" @endif>6</option>
						                  <option value="7"@if($count_record['business_time_start'] == 7) selected="select" @endif>7</option>
						                  <option value="8"@if($count_record['business_time_start'] == 8) selected="select" @endif>8</option>
						                  <option value="9"@if($count_record['business_time_start'] == 9) selected="select" @endif>9</option>
						                  <option value="10"@if($count_record['business_time_start'] == 10) selected="select" @endif>10</option>
						                  <option value="11"@if($count_record['business_time_start'] == 11) selected="select" @endif>11</option>
						                  <option value="12"@if($count_record['business_time_start'] == 12) selected="select" @endif>12</option>
						                  <option value="13"@if($count_record['business_time_start'] == 13) selected="select" @endif>13</option>
						                  <option value="14"@if($count_record['business_time_start'] == 14) selected="select" @endif>14</option>
						                  <option value="15"@if($count_record['business_time_start'] == 15) selected="select" @endif>15</option>
						                  <option value="16"@if($count_record['business_time_start'] == 16) selected="select" @endif>16</option>
						                  <option value="17"@if($count_record['business_time_start'] == 17) selected="select" @endif>17</option>
						                  <option value="18"@if($count_record['business_time_start'] == 18) selected="select" @endif>18</option>
						                  <option value="19"@if($count_record['business_time_start'] == 19) selected="select" @endif>19</option>
						                  <option value="20"@if($count_record['business_time_start'] == 20) selected="select" @endif>20</option>
						                  <option value="21"@if($count_record['business_time_start'] == 21) selected="select" @endif>21</option>
						                  <option value="22"@if($count_record['business_time_start'] == 22) selected="select" @endif>22</option>
						                  <option value="23"@if($count_record['business_time_start'] == 23) selected="select" @endif>23</option>
						                </select>
						            </div>
						            <div class="col-sm-1" style="margin-top: 5px;margin-left: -17px;">:00</div>
						            <div class="col-sm-1" style="margin-left: -22px;margin-top: 4px;">--</div>
						            <div class="col-sm-2">
										<select id="country" name="business_time_end" class="form-control" style="margin-left: -30px;">
						                  <option value="1"@if($count_record['business_time_end'] == 1) selected="select" @endif>1</option>
						                  <option value="2"@if($count_record['business_time_end'] == 2) selected="select" @endif>2</option>
						                  <option value="3"@if($count_record['business_time_end'] == 3) selected="select" @endif>3</option>
						                  <option value="4"@if($count_record['business_time_end'] == 4) selected="select" @endif>4</option>
						                  <option value="5"@if($count_record['business_time_end'] == 5) selected="select" @endif>5</option>
						                  <option value="6"@if($count_record['business_time_end'] == 6) selected="select" @endif>6</option>
						                  <option value="7"@if($count_record['business_time_end'] == 7) selected="select" @endif>7</option>
						                  <option value="8"@if($count_record['business_time_end'] == 8) selected="select" @endif>8</option>
						                  <option value="9"@if($count_record['business_time_end'] == 9) selected="select" @endif>9</option>
						                  <option value="10"@if($count_record['business_time_end'] == 10) selected="select" @endif>10</option>
						                  <option value="11"@if($count_record['business_time_end'] == 11) selected="select" @endif>11</option>
						                  <option value="12"@if($count_record['business_time_end'] == 12) selected="select" @endif>12</option>
						                  <option value="13"@if($count_record['business_time_end'] == 13) selected="select" @endif>13</option>
						                  <option value="14"@if($count_record['business_time_end'] == 14) selected="select" @endif>14</option>
						                  <option value="15"@if($count_record['business_time_end'] == 15) selected="select" @endif>15</option>
						                  <option value="16"@if($count_record['business_time_end'] == 16) selected="select" @endif>16</option>
						                  <option value="17"@if($count_record['business_time_end'] == 17) selected="select" @endif>17</option>
						                  <option value="18"@if($count_record['business_time_end'] == 18) selected="select" @endif>18</option>
						                  <option value="19"@if($count_record['business_time_end'] == 19) selected="select" @endif>19</option>
						                  <option value="20"@if($count_record['business_time_end'] == 20) selected="select" @endif>20</option>
						                  <option value="21"@if($count_record['business_time_end'] == 21) selected="select" @endif>21</option>
						                  <option value="22"@if($count_record['business_time_end'] == 22) selected="select" @endif>22</option>
						                  <option value="23"@if($count_record['business_time_end'] == 23) selected="select" @endif>23</option>
						                  <option value="24"@if($count_record['business_time_end'] == 24) selected="select" @endif>24</option>
						                </select>
						             </div>
						             <div class="col-sm-1" style="margin-top: 5px;
    margin-left: -50px;">:00</div>
									</div>
								</div>

								<div class="form-group">                  
									<label for="inputEmail3" class="col-sm-2 control-label">Advance Booking Weeks:</label>
								<div class="col-sm-8">
									<div class="col-sm-2">
										<select id="country" name="advance_booking_weeks" class="form-control">
										  <option value="1" @if($count_record['advance_booking_weeks'] == 1)selected="select" @endif>1</option>
						                  <option value="2" @if($count_record['advance_booking_weeks'] == 2)selected="select" @endif>2</option>
						                </select>
						            </div>
								</div>
								</div>	

						     <div class="form-group">                  
								<label for="inputEmail3" class="col-sm-2 control-label">Appointment Color(Arrived):</label>
								<div class="col-sm-8">
								      <div id="cp2" class="input-group colorpicker colorpicker-component"> 
									      <input type="text" name="color_arrived" value="{{$count_record['color_arrived']}}" class="form-control"/> 
									      <span class="input-group-addon"><i></i></span> 
									    </div>
						          
								</div>
								</div>	

								 <div class="form-group">                  
								<label for="inputEmail3" class="col-sm-2 control-label">Appointment Color(In Process):</label>
								<div class="col-sm-8">
								      <div id="cp2" class="input-group colorpicker colorpicker-component"> 
									      <input type="text" name="color_in_process" value="{{$count_record['color_in_process']}}" class="form-control"/> 
									      <span class="input-group-addon"><i></i></span> 
									    </div>
						          
								</div>
								</div>	

								 <div class="form-group">                  
								<label for="inputEmail3" class="col-sm-2 control-label">Appointment Color(Seen):</label>
								<div class="col-sm-8">
								      <div id="cp2" class="input-group colorpicker colorpicker-component"> 
									      <input type="text" name="color_in_seen" value="{{$count_record['color_in_seen']}}" class="form-control"/> 
									      <span class="input-group-addon"><i></i></span> 
									    </div>
						          
								</div>
								</div>	

								 <div class="form-group">                  
								<label for="inputEmail3" class="col-sm-2 control-label">Appointment Color(DNA):</label>
								<div class="col-sm-8">
								      <div id="cp2" class="input-group colorpicker colorpicker-component"> 
									      <input type="text" name="color_in_dna" value="{{$count_record['color_in_dna']}}" class="form-control"/> 
									      <span class="input-group-addon"><i></i></span> 
									    </div>
						          
								</div>
								</div>

								 <div class="form-group">                  
								<label for="inputEmail3" class="col-sm-2 control-label">Appointment Color(Booked):</label>
								<div class="col-sm-8">
								      <div id="cp2" class="input-group colorpicker colorpicker-component"> 
									      <input type="text" name="color_in_booked" value="{{$count_record['color_in_booked']}}" class="form-control"/> 
									      <span class="input-group-addon"><i></i></span> 
									    </div>
						          
								</div>
								</div>	
								<input type="hidden" name="appointment_setting_id" value="{{$count_record['id']}}">	
                           <div class="form-group" style="margin-left: 206px;">
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
	</script>
	@endsection
