@extends('admin.layouts.master')
@section('admin-title')
Admin-Subscriptions
@endsection
@section('admin-pagelevel-styles')
@endsection
@section('admin-content')
  <section class="content">
  <div class="alert alert-success alert-dismissable" id="successMessageDiv" style="display: none;">
         <i class="fa fa-check"></i>
         <b>Record Updated Success!</b>
         <span class="sucmsgdiv"></span>                     
       </div>
      <div class="row">
      @if (Session::has('error'))
          <div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('error') }}
          </div>
      @endif
      <div class="col-md-2">
      </div>
        <div class="col-md-6">
           
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Edit Subscription Package</h3>
            </div>
             <form action="{{url('admin/subscription-update')}}" class="-bootstrap-modal-form" method="post">
             {{ csrf_field() }}
            <div class="box-body">
              <!--User Size form-->
              <div class="form-group">
                <label>Package Name:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                   <!--  <i class="fa fa-user"></i> -->
                  </div>
                  <input type="text" class="form-control" name="package_name" value="{{$edit_record['package_name']}}" placeholder="Enter Package Name">
                   <span class="text-danger">{{ $errors->first('package_name') }}</span>
                </div>
              </div>
              <!--User Size to-->
              <div class="form-group">
                <label>Data Size:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i><b>GB</b></i>
                  </div>
                  <input type="text" class="form-control" name="data_size" value="{{$edit_record['data_size']}}" placeholder="Enter Data Size" >
                   <span class="text-danger">{{ $errors->first('data_size') }}</span>
                </div>
              </div>
              <div class="form-group">
                <label>User Size From:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="number" class="form-control" name="user_size_from" value="{{$edit_record['user_size_from']}}" placeholder="Users Count From" min="1">
                  <span class="text-danger">{{ $errors->first('user_size_from') }}</span>
                </div>
              </div>
              <!--User Size to-->
              <div class="form-group">
                <label>User Size To:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="number" class="form-control" name="user_size_to" value="{{$edit_record['user_size_to']}}" placeholder="Users Count To" min="1">
                  <span class="text-danger">{{ $errors->first('user_size_to') }}</span>
                </div>
              </div>

               <div class="form-group">
                <label>Price:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-dollar"></i>
                  </div>
                  <input type="text" class="form-control" name="price" value="{{$edit_record['price']}}" placeholder="Price">
                  <span class="text-danger">{{ $errors->first('price') }}</span>
                </div>
              </div>
              <input type="hidden" name="package_id" value="{{$edit_record['id']}}">

              <div class="form-group">
                <div class="input-group">
                  <button type="submit" class="btn btn-success">UPDATE</button>
                </div>
              </div>
             </form>
            </div>
            <!-- /.box-body -->
            </form>
          </div>
          <!-- /.box -->

          
          <!-- /.box -->

        </div>
      </div>
      <!-- /.row -->
  </section>
@endsection
@section('admin-pagelevel-script')
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>

@endsection