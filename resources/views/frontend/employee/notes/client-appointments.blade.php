@extends('frontend.employee.layouts.master')
@section('title')
Business Employee-Client Appointments
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
       Mr {{$client_record['name']}} {{$client_record['surname']}} / Appointments
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
              <h3 class="box-title">Appointments</h3>

            </div>
            <!-- /.box-header -->
           
       <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Id</th>
              <th>When</th>
              <th>Added By</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
          @if(isset($my_appointments))
            @foreach($my_appointments as $my_appointment)
            <tr>
              <td>{{$i++}}</td>
              <td></a>{{$my_appointment['appointment_start_time']}}</td>
              <td>{{$my_appointment['added_by']}}</td>   
          </tr>
              @endforeach  
          @endif
        </tbody>
        
      </table>
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