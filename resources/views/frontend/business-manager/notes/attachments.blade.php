@extends('frontend.business-manager.layouts.master')
@section('title')
Business Manager-All Attachments
@endsection
@section('pagelevel-styles')
<style type="text/css">
.manager-content-wrapper{margin-left: 0;}
.scrollable-menu {
    height: auto;
    max-height: 200px;
    overflow-x: hidden;
}
</style>

@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper manager-content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Mr {{$client_record['name']}} {{$client_record['surname']}} / Attachments
      </h1>
     <a href="{{url('manager/attach-file/'.Hashids::encode($client_record['id']))}}" class="btn btn-info pull-right">Add</a>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">

          <div class="box box-solid">
            <div class="box-header with-border">
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
          @include('frontend.business-manager.client-management.client-details-sidebar')
          </div>
        
        </div>
    
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
            <div class="btn-group" align="center">
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Select Heading<span class="caret"></span></button>
                <ul class="dropdown-menu scrollable-menu" role="menu">
                 <li><a href="{{url('manager/client-attachments/'.Hashids::encode($client_record['id']))}}">All</a></li>
                @if(isset($attachments))
               @foreach($fileter_attachment_headings as $attachment)

                    <li><a href="{{url('manager/client-attachments/'.Hashids::encode($client_record['id']).'/'.$attachment['heading'])}}">{{$attachment['heading']}}</a></li>
               @endforeach
               @endif
                </ul>
            </div>  
               
            </div>
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
       @endif     <!-- /.box-header -->
         
       <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Id</th>
              <th>Heading</th>
              <th>Attachment</th>
              <th>Download</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; ?>
          @if(isset($attachments))
            @foreach($attachments as $attachment)
            <tr>
              <td>{{$i++}}</td>
              <td></a>{{$attachment['heading']}}</td>
              <td></a>{{$attachment['file']}}</td>
              <td><a href="{{asset('uploads/attachments/' . $attachment['file']) }}" title="Download Document" class="btn btn-default btn-xs" download><i class="fa fa-cloud-download"></i></td>
              <td>
                 @if($attachment['common_user_id'] == Auth::user()->id)
                  <a href="{{url('manager/edit-attachment/'.Hashids::encode($attachment['id']).'/'.Hashids::encode($client_record['id']))}}" class="btn btn-info">
                   Edit
                 </a>
                   <button class="btn btn-danger btn-delete delete-employee" value="{{$attachment['id']}}">Delete</button>
                 @else
                
                 @endif  
              </td> 
          </tr>
              @endforeach  
          @endif
        </tbody>
        
      </table>
          </div>
          <!-- /. box -->
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('pagelevel-script')
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
var url = "{{url('manager/delete-attachment')}}";
$(document).on('click','.delete-employee',function(){
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