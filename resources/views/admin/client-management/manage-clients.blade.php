@extends('admin.layouts.master')
@section('admin-title')
Admin-Clients
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
          <h3 class="box-title">Business Clients</h3>
          
          <a href="{{url('admin/create-business-client')}}" class="btn btn-info pull-right">
           Create Business Client
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
              <th>Client Name</th>
              <th>Email</th>
              <th>Country</th>
              <th>Phone Number</th>
              <th>Business Name</th>
              <th>Business Type</th>
              <th>Created Date</th>
              <th>Updated Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
            @foreach($all_business_clients as $business_client)
            <tr>
              <td>{{ $i++}}</td>
              <td>{{$business_client->name}} {{$business_client->surname}}</td>
              <td>{{$business_client->email}}</td>
              <td>{{$business_client->country}}</td>
              <td>{{$business_client->country_code}}{{$business_client->phone_number}}</td>
              <td>{{$business_client->businesss_name}}</td>
              <td>{{$business_client->business_type}}</td>
              <td>{{$business_client->main_user_table_created_record_date}}</td>
              @if($business_client->updated_record_date == "")
              <td>--</td>
              @else
              <td>{{$business_client->main_user_table_updated_record_date}}</td>
              @endif
              <td>
                 <!--  <button class="btn btn-primary" value="{{$business_client->main_user_id}}">Password Setup Link</button> -->

                  <button class="btn btn-warning btn-detail open_modal" value="{{$business_client->main_user_id}}" title="Details"><span class="glyphicon glyphicon-folder-open"></span></button>
                            
                 <a href="{{url('admin/edit-business-client/'.Hashids::encode($business_client->main_user_id))}}" class="btn btn-info" title="Edit">
                   <span class="glyphicon glyphicon-pencil"></span>
                 </a>
                 @if($business_client->active == 1)
                   <button class="btn btn btn open_modal_active_account" value="{{$business_client->main_user_id}}">Active</button>
                 @else
                 <button class="btn btn-danger open_modal_active_account" value="{{$business_client->main_user_id}}">In Active</button>
                 @endif  
              </td>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Complete Details</h4>
            </div>
            <div class="modal-body">
            <form id="frmProducts" name="frmProducts" class="form-horizontal" novalidate="">
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Role</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="business_manager_role_name" name="business_manager_role_name" placeholder="Role Name" value="" readonly>
                    </div>
                </div> 
                <div class="form-group error">
                 <label for="inputName" class="col-sm-3 control-label">Full Name</label>
                   <div class="col-sm-9">
                    <input type="text" class="form-control has-error" id="name" name="name" placeholder="Product Name" value="" readonly="">
                   </div>
                   </div>

                 <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Business Name</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="business_name" name="business_name" placeholder="Business Name" value="" readonly>
                    </div>
                </div> 
                 <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Business Type</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="business_type" name="business_type" placeholder="Business Type" value="" readonly>
                    </div>
                </div>  

                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="" readonly>
                    </div>
                </div>
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Country</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="" readonly>
                    </div>
                </div>
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">State</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="state" name="state" placeholder="state" value="" readonly>
                    </div>
                </div>
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">City</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" value="" readonly>
                    </div>
                </div>
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Phone</label>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" id="country_code" name="country_code" placeholder="Country Code" value="" readonly>
                    </div>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" id="area_code" name="area_code" placeholder="Area Code" value="" readonly>
                    </div>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" value="" readonly>
                    </div>
                </div>
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Pincode</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" value="" readonly>
                    </div>
                </div>        
            </form>
            </div>
           <!--  <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
            <input type="hidden" id="product_id" name="product_id" value="0">
            </div> -->
        </div>
      </div>
  </div>

<!-- //active account modal start -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Business Manager Account activation</h4>
            </div>
            <div class="modal-body">
            <form class="bootstrap-modal-form" action="{{url('admin/active-manager-account')}}" method="post">
             {{ csrf_field() }}
                <div class="form-group">
                 <label for="inputDetail" class="col-sm-3 control-label">Active/Inactive</label>
                    <div class="col-sm-9">
                     <select id="active_account" name="active" class="form-control">
                      <option value="">Select option</option>
                      <option value="1">Active</option>
                      <option value="0">In Active</option>
                     </select>
                    </div>
                </div>
                <input type="hidden" name="manager_id" value="" id='manager_id'>    
                <button type="submit" class="btn btn-primary"> Submit</button>   
            </form>
            </div>
           <!--  <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
            <input type="hidden" id="product_id" name="product_id" value="0">
            </div> -->
        </div>
      </div>
  </div>

<!-- //active account modal end -->
@endsection
@section('admin-pagelevel-script')
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
var url_manager_details = "{{url('admin/business-client-details')}}";
var url_manager_active_account = "{{url('admin/active-business-client')}}";
$(document).on('click','.open_modal',function(){
  //alert('hai');
        var business_manager_id = $(this).val();
       //alert(business_manager_id);
        $.get(url_manager_details + '/' + business_manager_id, function (data) {
            //success data
            console.log(data);
            $('#business_manager_role_name').val(data.role_name);
            $('#name'). val(data.name + ' ' +data.surname );
            $('#email').val(data.email);
            $('#business_name').val(data.businesss_name);
            $('#business_type').val(data.business_type);
            $('#country').val(data.country);
            $('#state').val(data.state);
            $('#city').val(data.city);
            $('#country_code').val(data.country_code);
            $('#area_code').val(data.area_code);
            $('#phone_number').val(data.phone_number);
            $('#pincode').val(data.pincode);
            $('#myModal').modal('show');
        }) 
    });

$(document).on('click','.open_modal_active_account',function(){
        var business_manager_id = $(this).val();

       //alert(business_manager_id);
        $.get(url_manager_active_account + '/' + business_manager_id, function (data) {
            //success data
             //alert('hai');
            console.log(data);
            $('#active_account').val(data.active);
            $('#manager_id').val(data.id);
             $('#myModal2').modal('show');
        }) 
    });
</script>
@endsection
