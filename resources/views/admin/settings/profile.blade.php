@extends('admin.layouts.master')
@section('admin-title')
Admin-Change Password
@endsection
@section('admin-pagelevel-styles')
<style>
.box-body {
    padding: 241px;
    margin-top: -214px;
}
</style>
@endsection
@section('admin-content')
  <section class="content-header">
      <h1>
        My Profile
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
        <li class="active">Settings(profile)</li>
      </ol>
    </section>

    <!-- Main content -->
     <section class="content">

      <div class="row">
      

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
             @if($user_profile['profile_pic'] == '')
              <img class="profile-user-img img-responsive img-circle" src="{{asset('img1.jpg')}}" alt="User profile picture" data-toggle="modal" data-target="#myModal">
             @else
              <img class="profile-user-img img-responsive img-circle" src="{{ asset('/uploads/profile_pics/'. $user_profile['profile_pic']) }}" alt="User profile picture" data-toggle="modal" data-target="#myModal">
             @endif 

              <h3 class="profile-username text-center">{{$user_profile['name']}}</h3>
              <p class="text-muted text-center">{{$user_role['role_name']}}</p>

             
              <ul  class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <h3 align="center"><b>Personal Details</b></h3>
                </li>
                 <li class="list-group-item">
                  <b>Registration Id</b> <a class="pull-right">{{$user_profile['registration_id']}}</a>
                </li>
                <li class="list-group-item">
                  <b>Full Name</b> <a class="pull-right">{{$user_profile['name']}}</a>
                </li> 
               
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right">{{$user_profile['email']}}</a>
                </li>
                @if(isset($user_profile['dateof_birth']))
                <li class="list-group-item">
                  <b>Date Of Birth</b> <a class="pull-right">{{$user_profile['dateof_birth']}}</a>
                </li>
                @endif
                <li class="list-group-item">
                  <b>Phone Number</b> <a class="pull-right">{{$user_profile['country_code']}}-{{$user_profile['area_code']}}-{{$user_profile['phone_number']}}</a>
                </li>
                <li class="list-group-item">
                  <b>Country</b> <a class="pull-right">{{$user_profile['useraddresses']['country']}}</a>
                </li>
                <li class="list-group-item">
                  <b>State</b> <a class="pull-right">{{$user_profile['useraddresses']['state']}}</a>
                </li>
                <li class="list-group-item">
                  <b>City</b> <a class="pull-right">{{$user_profile['useraddresses']['city']}}</a>
                </li>
                <li class="list-group-item">
                  <b>Pincode</b> <a class="pull-right">{{$user_profile['useraddresses']['pincode']}}</a>
                </li>
              </ul>
              <a href="{{url('admin/edit-profile',Hashids::encode($user_profile['id']))}}" class="btn btn-primary btn-block"><b>Edit</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          
        
      </div>
      <!-- /.row -->

    </section>
 
@endsection
@section('admin-pagelevel-script')
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>

@endsection
