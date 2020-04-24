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
                    <h3 class="box-title">Create Client</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                   @if (Session::has('fail'))
                   <div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
                   </div>
                   @endif
                   <form action="{{url('manager/send-ticket')}}" class="-bootstrap-modal-form form-horizontal" method="post" enctype="multipart/form-data">
                       {{ csrf_field() }}
                       <div class="modal-body">
                        <div class="box-body">
                          <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                          </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Category</label>

                                <div class="col-sm-9">
                                    <select id="country" name="category" class="form-control">
		                            <option value="">Select Category
		                              </option>
		                             <option value="Functional">Software
		                              </option>
                                    </select>
                              <span class="text-danger">{{ $errors->first('category') }}</span>
                                </div>
                            </div>

                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Subject</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Subject" name="subject" value="{{old('subject')}}" maxlength="70">
                                    <span class="text-danger">{{ $errors->first('subject') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Problem</label>
                                <div class="col-sm-9">
                                    <textarea  class="form-control" name="problem" style="height: 300px">{{old('problem')}}</textarea>
				                    <span class="text-danger">{{ $errors->first('problem') }}</span>
                                </div>
                            </div>

                             <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Attachment</label>
                                <div class="col-sm-9">
                                    <input type="file" name="attachments" class="form-control">
                                </div>
                            </div>


                  <div class="form-group" align="center">
                    <a href="{{url('manager/my-tickets')}}" class="btn btn-info">
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
<!-- /.col -->
</div>
<!-- /.row -->
</section>

@endsection
@section('pagelevel-script')
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>

@endsection
