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
          <h3 class="box-title">Subscribed Clients</h3>
          
          <!-- <a href="{{url('admin/crate-subscription-plans')}}" class="btn btn-info pull-right">
           Create Subscription
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
              <th>Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Business</th>
              <th>All Subscriptions</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
          @foreach($all_business_mnagers_subscriptions as $all_business_mnagers_subscription)
            <tr>
              <td>{{ $i++}}</td>
              <td>{{$all_business_mnagers_subscription->name}} {{$all_business_mnagers_subscription->surname}}</td>
              <td>{{$all_business_mnagers_subscription->email}}</td>
              <td>{{$all_business_mnagers_subscription->country_code}}{{$all_business_mnagers_subscription->ares_code}}{{$all_business_mnagers_subscription->phone_number}}</td>
              <td>{{$all_business_mnagers_subscription->businesss_name}}</td>
              <td><a href="{{url('admin/business-level-subscriptions/'.Hashids::encode($all_business_mnagers_subscription->main_user_id))}}">Click Here</a></td>
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
