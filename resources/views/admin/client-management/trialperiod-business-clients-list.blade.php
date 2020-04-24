@extends('admin.layouts.master')
@section('admin-title')
Admin-Trila-Period-Clients
@endsection
@section('admin-pagelevel-styles')
@endsection
@section('admin-content')
 <section class="content">
  <div class="row">
    <div class="col-xs-12">
      <!-- /.box -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Business Trial period Clients</h3>
          
         <!--  <a href="{{url('admin/create-business-client')}}" class="btn btn-info pull-right">
           Create Business Client
         </a> -->
         
       </div>
       <div class="alert alert-success alert-dismissable" id="sucMsgDeleteDiv" style="display: none;">
         <i class="fa fa-check"></i>
         <b>Record Deleted Success!</b>
         <span class="sucmsgdiv"></span>                     
       </div>
       <!-- /.box-header -->
       @if(Session::has('success'))
       <div  align="center" id="successMessage"  class="alert alert-info">{{ Session::get('success') }}
       </div>
       @endif
       <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Client Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Business Name</th>
              <th>Trial Period Expired(completed days/Total days)</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
          @if(isset($main))
            @foreach($main as $diff_in_day)
            <tr>
              <td>{{ $i++}}</td>
              <td>{{$diff_in_day['name']}} {{$diff_in_day['surname']}}</td>
              <td>{{$diff_in_day['email']}}</td>
              <td>{{$diff_in_day['country_code']}}{{$diff_in_day['phone_number']}}</td>
              <td>{{$diff_in_day['businesss_name']}}</td>
              <td>{{$diff_in_day['diff_in_days']}} days completed / 30 (days)</td>
            </tr>
            @endforeach  
          @endif
        </tbody>
        
      </table>
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
@section('admin-pagelevel-script')
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>

@endsection
