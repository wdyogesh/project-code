@extends('frontend.other-party.layouts.master')
@section('title')
Other Party-Manage Mail Group
@endsection
@section('pagelevel-styles')
<!-- multi select styles checkbox start  -->    
<link href="http://34.211.31.84:9005/front/css/bootstrap.min.css" rel="stylesheet">
<link href="http://34.211.31.84:9005/front/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
        rel="stylesheet" type="text/css" />
<!-- multi select styles checkbox end  -->   
<style type="text/css">
.manager-content-wrapper{margin-left: 0;}
.select2-container--default .select2-selection--multiple .select2-selection__choice
{color:#333;}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
 <link href="{{asset('multiple-file-upload/css/style.css')}}" rel="stylesheet" />

 
@endsection
@section('content')
  <div class="content-wrapper manager-content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ICMAIL
      </h1>
      <a href="{{url('other-party/add-group')}}" class="btn btn-info pull-right">
           Add Group
      </a>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="{{url('other-party/mail-box')}}" class="btn btn-primary btn-block margin-bottom">Back to Inbox</a>

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            @include('frontend.other-party.mail-box-management.message-sidebar-up')
            
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
          @include('frontend.other-party.mail-box-management.message-sidebar-lables')
       
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
          <div class="alert alert-success alert-dismissable" id="sucMsgDeleteDiv" style="display: none;">
         <i class="fa fa-check"></i>
         <b>Record Deleted Success!</b>
         <span class="sucmsgdiv"></span>                     
       </div>  
          @if (Session::has('fail'))
					<div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
					</div>
					@endif 
		  @if (Session::has('success'))
			<div  align="center" id="successMessage" class="alert alert-success">{{ Session::get('success') }}
			</div>
		  @endif   
      <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Group Name</th>
              <th>Group Emial</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
        @if(isset($mail_group))
          @foreach($mail_group as $group)
            @if($group['mail_group_common_user_id'] == Auth::user()->id)
            <tr>
              <td>{{$group['name']}}</td>
              <td>{{$group['email']}}</td>
              @if($group['mail_group_common_user_id'] == Auth::user()->id)
              <td>
               <a href="{{url('other-party/edit-group/'.Hashids::encode($group['group_user_id']))}}" class="btn btn-info" title="Edit">
                 <span class="glyphicon glyphicon-pencil"></span>
               </a>
               <button class="btn btn-danger btn-delete delete-group" value="{{$group['group_user_id']}}" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
               </td>   
               @else
               <td>--</td>
               @endif 
            @endif 
            @endforeach          
        @endif
        </tbody>
        
      </table>
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@section('pagelevel-script')
<!-- multi select script checkbox start  --> 
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
        rel="stylesheet" type="text/css" />
    <script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
        type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('#employee').multiselect({
                includeSelectAllOption: true
            });
            $('#btnSelected').click(function () {
                var selected = $("#employee option:selected");
                var message = "";
                selected.each(function () {
                    message += $(this).text() + " " + $(this).val() + "\n";
                });
                alert(message);
            });

            $('#clients').multiselect({
                includeSelectAllOption: true
            });
            $('#btnSelected').click(function () {
                var selected = $("#clients option:selected");
                var message = "";
                selected.each(function () {
                    message += $(this).text() + " " + $(this).val() + "\n";
                });
                alert(message);
            });

            $('#otherparties').multiselect({
                includeSelectAllOption: true
            });
            $('#btnSelected').click(function () {
                var selected = $("#otherparties option:selected");
                var message = "";
                selected.each(function () {
                    message += $(this).text() + " " + $(this).val() + "\n";
                });
                alert(message);
            });
        });
    </script>
<!-- multi select script checkbox end  -->  
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<meta name="_token" content="{!! csrf_token() !!}" />
<script>
var url = "{{url('other-party/delete-group')}}";
$(document).on('click','.delete-group',function(){
  //alert('hai');
  if(confirm('Are you sure want to delete?')){
    var group_id = $(this).val();
    /*alert(user_id);*/
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    })
    $.ajax({
      type: "DELETE",
      url: url + '/' + group_id,         
      success: function (data) {
       // alert(data);
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
@section('example-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $('#tag_list').select2({
            placeholder: "To:",
            minimumInputLength: 2,
            ajax: {
                url: "{{url('other-party/emial-data')}}",
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    </script>
@endsection
@section('file-multiple-upload-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript">
             $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="file" name="attachments[]" class="form-control"/><a href="#" class="remove_field fa fa-trash-o" style="color:#dd4b39;"></a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>

@endsection

