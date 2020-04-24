@extends('admin.layouts.master')
@section('admin-title')
Admin-Dashboard
@endsection
@section('admin-pagelevel-styles')
@endsection
@section('admin-content')
  <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
  </section>
  <!-- Main content -->
  <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$business_clients}}</h3>

              <p>Business Clients</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{url('admin/client-management')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$subscriptions_count}}<sup style="font-size: 20px"></sup></h3>

              <p>Subscriptions</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{url('admin/business-cliens-subscriptions')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
       
      </div>
      <!-- /.row -->
      <!-- Main row -->
    
      <!-- /.row (main row) -->
  </section>
@endsection
@section('admin-pagelevel-script')
@endsection
