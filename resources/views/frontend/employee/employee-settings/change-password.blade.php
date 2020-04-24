@extends('frontend.employee.layouts.master')
@section('title')
Business Manager-Account Settings-Change Password
@endsection
@section('pagelevel-styles')
@endsection
@section('content')
  <section class="content-header">
     <!--  <h1>
        Settings
        <small>Preview</small>
      </h1> -->
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('employee/dashboard')}}">Dashboard</a></li>
        <li class="active">Settings(change password)</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
           @if(Session::has('success'))
            <div  align="center" id="successMessage"  class="alert alert-info">{{ Session::get('success') }}
            </div>
            @endif
        <div class="col-md-2">
        </div>
        <!--change passsword start-->
           <div class="col-md-6">
          <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Change Password</h3>
                </div>
                <form class="form-horizontal" action="{{url('employee/change-password')}}" method="post">
                {!! csrf_field() !!}
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Enter Password</label>

                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputEmail3" name="password" value="{{old('password')}}" placeholder="Password">
                      </div>
                      <span class="text-danger">{{ $errors->first('password') }}</span>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Re Enter Password</label>

                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword3" name="repassword" value="{{old('repassword')}}" placeholder="Password">
                      </div>
                      <span class="text-danger">{{ $errors->first('repassword') }}</span>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">Update</button>
                  </div>
                </form>
              </div>
        </div>
        <!--change password end-->
      </div>
      <!-- /.row -->
    </section>
 
@endsection
@section('pagelevel-script')
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>

@endsection
