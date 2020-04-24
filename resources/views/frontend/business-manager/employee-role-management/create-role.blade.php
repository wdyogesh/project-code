@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Create Role
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
              <h3 class="box-title">Create Role</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             @if (Session::has('fail'))
            <div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
            </div>
            @endif
            <form action="{{url('manager/create-emoloyee-role')}}" class="-bootstrap-modal-form form-horizontal" method="post">
               {{ csrf_field() }}
              <div class="modal-body">
                <div class="box-body">

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Role Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Role Name" name="role_name" value="{{old('role_name')}}">
                       <span class="text-danger">{{ $errors->first('role_name') }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <a href="{{url('manager/employee-roles')}}" class="btn btn-info pull-left">
               Go back
              </a>
                <button type="submit" class="btn btn-info">Submit</button>
              </div>
              </form>
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
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
$("#edit").click(function (e) {

  alert($('#edit').val());

});
  </script>
  <script>
$(document).ready(function(){
     $("#select_security_question").change(function() {
   var val = $(this).val();
   if (val != "") {
      $("#admDivCheck").show();
   }
});
});
</script>
<script src="{{asset('js/country-states.js')}}"></script>
    <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
    </script>
    <script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}    
</script>
@endsection
