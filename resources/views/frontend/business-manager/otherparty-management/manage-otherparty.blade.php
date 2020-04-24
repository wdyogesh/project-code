@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Other Party Invited User Management
@endsection
@section('pagelevel-styles')
@endsection
@section('content')
<section class="content">
  <div class="row">
    <div class="col-xs-12">
     
      <!-- /.box -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Registered Other Party Users</h3>
          
        <a href="{{url('manager/other-party-registration-by-manager')}}" class="btn btn-info pull-right">
           Other Party Registration By Manager
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
              <th>Id</th>
              <th>Registration Id</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Invitation Category Name</th>
              <th>Registration Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1;?>
          @if(isset($main_other_party_register_users))
            @foreach($main_other_party_register_users as $main_other_party_register_users)
            <tr>
              <td>{{$i++}}</td>
              <td>{{$main_other_party_register_users['registration_id']}}</td>
              <td>{{$main_other_party_register_users['name']}}</td>
              <td>{{$main_other_party_register_users['email']}}</td>
              <td>{{$main_other_party_register_users['country_code']}}{{$main_other_party_register_users['area_code']}}{{$main_other_party_register_users['phone_number']}}</td>
              <td>{{$main_other_party_register_users['invitation_category_name']}}</td>
              <td>{{$main_other_party_register_users['main_user_table_created_record_date']}}</td>
              <td>         
               <a href="{{url('manager/other-party-details',Hashids::encode($main_other_party_register_users['main_user_id']))}}" class="btn btn-warning" title="Details"><span class="glyphicon glyphicon-folder-open"></span></a>
              <!--  @if($main_other_party_register_users['other_party_active'] == 1)
               <a href="{{url('manager/other-party-activation/'.Hashids::encode($main_other_party_register_users['main_user_id']).'/'.Hashids::encode(Auth::user()->id) )}}" class="btn btn-success">Active</a>
               @else
               <a href="{{url('manager/other-party-activation/'.Hashids::encode($main_other_party_register_users['main_user_id']).'/'.Hashids::encode(Auth::user()->id) )}}" class="btn btn-danger">In Active</a>
               @endif -->

              </td>
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
@section('pagelevel-script')
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
var url = "{{url('manager/delete-other-party-invitation')}}";
$(document).on('click','.delete-employee',function(){
  if(confirm('Are you sure want to delete?')){
    var other_party_link_sent_id = $(this).val();
    /*alert(user_id);*/
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    })
    $.ajax({
      type: "DELETE",
      url: url + '/' + other_party_link_sent_id,         
      success: function (data) {
        console.log(data);
      //$("#user" + user_id).remove();
      $('#sucMsgDeleteDiv').show('slow');
      setTimeout(function(){ $('#sucMsgDeleteDiv').hide('slow');location.reload(); }, 500);
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
 }
});
</script>

@endsection
