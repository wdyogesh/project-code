@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Client Edit
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
       {{$client_record['name']}} {{$client_record['surname']}} / Client Notes
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
          @include('frontend.business-manager.client-management.client-details-sidebar')
          </div>
        
        </div>
    
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Note</h3>

            </div>
            <!-- /.box-header -->
           
     <form action="{{url('manager/update-notes')}}" class="-bootstrap-modal-form form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="box-body">
                <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                  <label name="login_error"></label>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Template:</label>
                  <div class="col-sm-9">
                    <select class="form-control" name="consultation_type">
                      <option value="Initial Consultation" @if($notes['consultation_type'] == 'Initial Consultation') selected="select" @endif>Initial Consultation</option>
                      <option value="Standard Consultation" @if($notes['consultation_type'] == 'Standard Consultation') selected="select" @endif>Standard Consultation</option>
                    </select>  
                  </div>
                  <span class="text-danger">{{ $errors->first('consultation_type') }}</span>  
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Appointment:</label>
                  <div class="col-sm-9">
                  <select class="form-control" name="appointments">
                      <option value="">None</option>
                      @if(isset($apointment_details))
                    @foreach($apointment_details as $appointment)
                      <option value="{{$appointment['appointment_id']}}" @if($notes['appointment_id'] == $appointment['appointment_id']) selected="select" @endif>{{$appointment['appointment_date']}}[{{$appointment['client_name']}}]</option>
                    @endforeach
                    @endif  
                    </select>  
                     <span class="text-danger">{{ $errors->first('appointments') }}</span>  
                  </div>
                 
                </div>



                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Category:</label>
                  <div class="col-sm-9">
                    <select class="form-control select2" name="category_name">
                      <option value="">Select Category</option>
                      @foreach($notes_category as $category)
                      <option value="{{$category->id}}"  @if($notes['category_name'] == $category->id) selected="select" @endif>{{$category->category_name}}</option>
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


               <!--  <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Attach File:</label>
                  <div class="col-sm-9">
                              <input type="file" name="attachment" class="form-control">
                              </div>
                              <span class="text-danger">{{ $errors->first('attachment') }}</span>
                  </div>

                </div>

                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Add Above Attached File Name:</label>
                 <div class="col-sm-9">
                  <input type="text" name="add_attached_file_name" class="form-control" placeholder="Enter Attached Filename">
                  <span class="text-danger">{{ $errors->first('add_attached_file_name') }}</span>
                  </div>
                              
                  </div>
                </div> -->

                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Other Party:</label>
                <div class="col-sm-9">
                  <select class="form-control" name="other_party">
                    <option value="">Link Other Party</option>
                    @if(isset($otherparties))
                    @foreach($otherparties as $otherpartie)
                    <option value="{{$otherpartie['id']}}"  @if($notes['other_party_id'] == $otherpartie['id']) selected="select" @endif>{{$otherpartie['user_name']}} [{{$otherpartie['category_name']}}]</option>
                    @endforeach
                    @endif
                  </select>  
                  <span class="text-danger">{{ $errors->first('other_party') }}</span>  
                </div>
              </div>

               <input type="hidden" name="notes_id" value="{{$notes->id}}">
               <input type="hidden" name="client_name" value="{{$notes->client_id}}">
                <div class="form-group" align="center">
                <!--   <a href="{{url('manager/manage-client-notes')}}" class="btn btn-info">
                    Go back
                  </a> -->
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>

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