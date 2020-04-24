@extends('admin.layouts.master')
@section('admin-title')
Admin-Business Manager Subscriptions
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
          <h3 class="box-title">{{$business_manager['name']}} {{$business_manager['surname']}} Subscriptions</h3>


          
          <a href="{{url('admin/business-cliens-subscriptions')}}" class="btn btn-info pull-right">
          Go Back
         </a>
         
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
              <th>Subscription Date</th>
              <th>Package</th>
              <th>Data</th>
              <th>Used Data</th>
              <th>Price($)</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
          @foreach($business_mnager_level_all_subscriptions as $business_mnager_level_all_subscription)
            <tr>
              <td>{{ $i++}}</td>
              <td>{{$business_mnager_level_all_subscription->subscription_date}}</td>
              <td>{{$business_mnager_level_all_subscription->package_name}}({{$business_mnager_level_all_subscription->user_size_from}}-{{$business_mnager_level_all_subscription->user_size_to}})</td>
              <td>{{$business_mnager_level_all_subscription->data_size}}GB</td>
              @if($business_mnager_level_all_subscription->used_data == "")
              <td>--</td>
              @else
              <td>{{$business_mnager_level_all_subscription->used_data}}</td>
              @endif
              
              <td>{{$business_mnager_level_all_subscription->price}}$</td>
             </tr>
         @endforeach
          
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
@endsection
