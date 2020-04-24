@extends('frontend.employee.layouts.master')
@section('title')
Business Employee-Notes Details
@endsection
@section('pagelevel-styles')
<style type="text/css">
.manager-content-wrapper{margin-left: 0;}
</style>
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper manager-content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Mr {{$client_record['name']}} {{$client_record['surname']}} / Detail Notes
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
         <!--  <a href="{{url('manager/compose-message')}}" class="btn btn-primary btn-block margin-bottom">Compose</a>
 -->
          <div class="box box-solid">
            <div class="box-header with-border">
             <!--  <h3 class="box-title">Folders</h3> -->

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
          @include('frontend.employee.client-management.client-details-sidebar')
          </div>
        
        </div>
    
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Details</h3>

            </div>
            <!-- /.box-header -->
           
      <form action="{{url('employee/create-client-notes')}}" class="bootstrap-modal-form form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="box-body">
                <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                  <label name="login_error"></label>
                </div>

                  <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Client Name:</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="category_name" placeholder="Category" value="{{$data['client_name']}} {{$data['client_sur_name']}}" readonly>
                  </div>
                   </div>

                   <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Sur Name:</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="category_name" placeholder="Category" value="{{$data['category_name']}}" readonly>
                  </div>
                   </div>

                   <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Created By:</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="category_name" placeholder="Category" value="{{$data['added_by']}} [{{$data['role_name']}}]" readonly>
                  </div>
                   </div>

                    <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Created Date:</label>
                  <div class="col-sm-7">
                    <input class="form-control" name="category_name" placeholder="Category" value="{{$data['created_record_date']}}" readonly>
                  </div>
                   </div>

                   <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Notes:</label>
                  <div class="col-sm-9">
                    <textarea id="compose-textarea" class="form-control" name="notes" style="height: 300px">{!! $data['notes'] !!}</textarea>
                  </div>
                   </div>
                 @if($data['file_name'] == "")
                 @else
                                  <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Uploaded File:</label>
                  <div class="col-sm-7">
                    <a href="{{asset('uploads/client_notes_documents/' . $data['file_name']) }}" title="Download Document" class="btn btn-default btn-xs" download><i class="fa fa-cloud-download"></i>{{$data['file_name']}}</a>
                  </div>
                   </div>
                 @endif  


                


                
                

                <!-- <div class="form-group" align="center">
                  <a href="{{url('manager/manage-client-notes')}}" class="btn btn-info">
                    Go back
                  </a>
                </div>
 -->
              </div>
            </div>

          </form>
          </div>
          <!-- /. box -->
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('pagelevel-script')
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
@endsection