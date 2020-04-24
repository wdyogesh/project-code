@extends('admin.layouts.master')
@section('admin-title')
Admin-Subscriptions
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
          <h3 class="box-title">Subscription Packages</h3>
          
          <a href="{{url('admin/crate-subscription-plans')}}" class="btn btn-info pull-right">
           Create Subscription
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
              <th>Package Name</th>
              <th>Data Size</th>
              <th>Users Size</th>
              <th>Price($)</th>
              <th>Created Date</th>
              <th>Updated Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
            @foreach($all_plans as $all_plan)
            <tr>
              <td>{{ $i++}}</td>
              <td>{{$all_plan->package_name}}</td>
              <td>{{$all_plan->data_size}}GB</td>
              <td>{{$all_plan-> user_size_from}} - {{$all_plan->  user_size_to}}</td>
              <td>{{$all_plan->price}}</td>
              <td>{{$all_plan->created_at}}</td>
              @if($all_plan->created_at == "")
              <td>--</td>
              @else
              <td>{{$all_plan->created_at}}</td>
              @endif
              <td>
              <a href="{{url('admin/edit-subscription-plan/'.Hashids::encode($all_plan->id))}}" class="btn btn-info" title="Edit">
                  <span class="glyphicon glyphicon-pencil"></span>
                 </a>
               <button class="btn btn-danger btn-delete delete-package" value="{{$all_plan->id}}" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
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
@section('admin-pagelevel-script')
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
var url = "{{url('admin/delete-subscription-package')}}";
$(document).on('click','.delete-package',function(){
  //alert('hai');
  if(confirm('Are you sure want to delete?')){
    var id = $(this).val();
    //alert(id);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    })
    $.ajax({
      type: "DELETE",
      url: url + '/' + id,         
      success: function (data) {
        alert('hi');
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
