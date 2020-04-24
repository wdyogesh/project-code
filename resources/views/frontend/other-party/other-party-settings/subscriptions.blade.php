@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-Subscriptions
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
              <h3 class="box-title">Subscription Management Comming Soon.....</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             
            <div  align="center" id="successMessage" class="alert alert-success">Subscription Management Comming Soon.....
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
