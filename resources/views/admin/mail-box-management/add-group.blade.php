@extends('admin.layouts.master')
@section('admin-title')
Admin-Mail Box
@endsection
@section('admin-pagelevel-styles')
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
@section('admin-content')
  <div class="content-wrapper manager-content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ICMAIL
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">ICMAIL</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="{{url('admin/mail-box')}}" class="btn btn-primary btn-block margin-bottom">Back to Inbox</a>

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            @include('admin.mail-box-management.message-sidebar-up')
            
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
          @include('admin.mail-box-management.message-sidebar-lables')
       
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
          @if (Session::has('fail'))
          <div  align="center" id="successMessage" class="alert alert-danger">{{ Session::get('fail') }}
          </div>
          @endif 
      @if (Session::has('success'))
      <div  align="center" id="successMessage" class="alert alert-success">{{ Session::get('success') }}
      </div>
      @endif   
            <!-- /.box-header -->
         <form action="{{url('admin/add-group')}}" class="-bootstrap-modal-form form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="box-body">
                              <div class="form-group" style="font-size: 18px;margin-left:140px; ">
                                 <label name="login_error"></label>
                                </div>
                                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Group Name</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Grouop Name" name="group_name" value="{{old('group_name')}}">
                    <span class="text-danger">{{ $errors->first('group_name') }}</span>
                  </div>
                  
                </div>

                <div class="form-group">                  
                  <label for="inputEmail3" class="col-sm-2 control-label">Group Email</label>
                   <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Grouop Email" name="email" value="{{old('email')}}" maxlength="30">
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                  </div>
                   <div class="col-sm-3">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="Enter Grouop Email" name="email_end_fixed" style="margin-left:-62px;" value="@intellcomm.com" readonly>
                    <!-- <span class="text-danger">{{ $errors->first('email') }}</span> -->
                  </div>
                  
                </div>

               

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Business Clients</label>
                  <div class="col-sm-5">
                    <select class="form-control" id="clients" name="clients[]"  multiple="multiple" style="height:100px; overflow-x: scroll;">
                        @foreach($admins_business_clients as $client)
                         <option value="{{$client->id}}">{{$client->email}}[{{$client->name}} {{$client->surname}}]</option>
                         @endforeach
                    </select>
                    <span class="text-danger">{{ $errors->first('clients') }}</span>
                  </div>
                </div>

                
                    <div class="form-group" align="center">
                  <a href="{{url('admin/manage-group')}}" class="btn btn-info">Go Back</a>
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
                

                </div>
              </div>
              
            </form>
            <!-- /.box-footer -->
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

@section('admin-pagelevel-script')
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
                url: "{{url('admin/emial-data')}}",
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

