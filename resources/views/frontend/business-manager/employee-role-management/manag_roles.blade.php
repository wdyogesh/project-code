@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Employee Management
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
              <h3 class="box-title">Manage Employee Roles</h3>
      
              <a href="{{url('manager/create-emoloyee-role')}}" class="btn btn-info pull-right">
               Create Role
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
                  <th>Role Name</th>
                  <th>Created Date</th>
                  <th>Updated Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($Business_manager_employee_roles as $Business_manager_employee_role)
                <tr>
                  <td>{{$Business_manager_employee_role->employee_role_name}}</td> 
                  <td>{{$Business_manager_employee_role->created_record_date}}</td>                
                  @if($Business_manager_employee_role->updated_record_date == "")
                  <td>--</td>
                  @else
                  <td>{{$Business_manager_employee_role->updated_record_date}}</td>
                  @endif
                  <td>
                       <a href="{{url('manager/edit-emoloyee-role/'.Hashids::encode($Business_manager_employee_role->id))}}" class="btn btn-info">
                         Edit
                       </a>
                   </td>

                   <td>
                     
                        <button class="btn btn-danger btn-delete delete-role" value="{{$Business_manager_employee_role->id}}">Delete</button>
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
@endsection
@section('pagelevel-script')
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
var url = "{{url('manager/delete-emoloyee-role')}}";
$(document).on('click','.delete-role',function(){
        if(confirm('Are you sure want to delete?')){
            var role_id = $(this).val();
           alert(role_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                type: "DELETE",
                url: url + '/' + role_id,         
                success: function (data) {
                    console.log(data);
                    //$("#user" + user_id).remove();
                    $('#sucMsgDeleteDiv').show('slow');
                  setTimeout(function(){ $('#sucMsgDeleteDiv').hide('slow');location.reload(); }, 2000);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });
  </script>
@endsection
