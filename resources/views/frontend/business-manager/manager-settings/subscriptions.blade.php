@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Subscriptions
@endsection
@section('pagelevel-styles')
@endsection
@section('content')
 <section class="content-header">
      <h1>
       Business Client
        <small>Subscription Plans</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Settings</a></li>
        <li class="active">Subscriptions</li>
      </ol>
    </section>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
   @endif
    @if(Session::has('success'))
       <div  align="center" id="successMessage"  class="alert alert-info">{{ Session::get('success') }}
       </div>
    @endif
      <section class="content">

 <form action="{{url('manager/suscribe-package')}}" method="post">
{{ csrf_field() }} 
@if(count($subscription_packages) != 0)    
@foreach($subscription_packages as $subscription_package)
      <div class="row">
       <div class="col-md-3">
       </div>
     
        <div class="col-md-6">
          <!-- iCheck -->
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title"><b style="color:green">Package Name:</b> {{$subscription_package->package_name}}</h3>
            </div>
            <div class="box-body">
        
              <div class="form-group">
                <label>
                 <b>Data Size:</b> </label> {{$subscription_package->data_size}} GB</h3>
                </label><br>
                 <label>
                 <b>Price:</b> </label> {{$subscription_package->price}}$</h3>
                </label><br>
                <label>
                  User Limit: </label><br>        
                     <input type="radio" name="package_id" class="minimal" value="{{$subscription_package->id}}">
                   {{$subscription_package->user_size_from}} - {{$subscription_package->user_size_to}} Users
                </label>
              </div>
            </div>
            <!-- /.box-body -->
           
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col (right) -->

      </div>
  @endforeach 
       <!-- /.row -->
    <div class="form-group" align="center">
     <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    <button type="submit" class="btn btn-success">Subscribe</button>
  </div>
  @else
  <h2 align="center" style="color:red">No Subscription Packages</h2>
  @endif  
                
 </form>
@endsection
@section('pagelevel-script')
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
@endsection
