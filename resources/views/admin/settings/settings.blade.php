@extends('admin.layouts.master')
@section('admin-title')
Admin-Settings
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
              <h3 class="box-title">Settings Management Comming Soon.....</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             
            <div  align="center" id="successMessage" class="alert alert-success">Settings Management Comming Soon.....
            </div>
           
         
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
@endsection
