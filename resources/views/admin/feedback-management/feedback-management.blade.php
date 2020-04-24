@extends('admin.layouts.master')
@section('admin-title')
Admin-Feed Back Management
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
          <h3 class="box-title">Feed Backs</h3>
          
         <!--  <a href="{{url('admin/create-feedback-categories')}}" class="btn btn-info pull-right">
           Add
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
              <th>Id</th>
              <th>Client Name</th>
              <th>Client Email</th>
              <th>Feed Back Category</th>
              <th>Rating</th>
              <th>Created Date</th>
             <!--  <th>Action</th> -->
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
          @if(isset($main))
            @foreach($main as $feed)
            <tr>
              <td>{{ $i++}}</td>
              <td>{{ucfirst($feed['client_name'])}}</td>
              <td>{{$feed['email']}}</td>
              <td>{{$feed['category_name']}}</td>
              <td>{{$feed['rating']}} / 10</td>
              <td>{{$feed['created_record_date']}}</td>
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
@section('admin-pagelevel-script')
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
  var url = "{{url('admin/delete-feedback-categories')}}";
  $(document).on('click','.delete-client',function(){
    if(confirm('Are you sure want to delete?')){
      var user_id = $(this).val();
      /*alert(user_id);*/
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      })
      $.ajax({
        type: "DELETE",
        url: url + '/' + user_id,         
        success: function (data) {
          console.log(data);
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
