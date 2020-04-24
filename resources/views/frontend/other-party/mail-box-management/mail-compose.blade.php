@extends('frontend.other-party.layouts.master')
@section('title')
Other Party-Mail Box
@endsection
@section('pagelevel-styles')
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
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">ICMAIL</li>
      </ol>
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
              
              <!-- <div class="col-md-2">
              <a href="{{url('client/manage-group')}}" class="btn  btn-block margin-bottom" style="background-color: #555555;"><span class="fa fa-users">Add Group</span></a>
              </div>
              <div class="col-md-2">
              <a href="{{url('client/compose-message/all')}}" class="btn {{ Request::is('client/compose-message/all')? 'btn-warning' : 'btn-default'}}"><span class="fa fa-envelope"></span> All</a>
              </div>
              <div class="col-md-2">
              <a href="{{url('client/compose-message/em')}}" class="btn {{ Request::is('client/compose-message/em')? 'btn-warning' : 'btn-default'}}"><span class="fa fa-envelope"></span> Staff</a>
              </div> 
              <div class="col-md-2">
              <a href="{{url('client/compose-message/cl')}}" class="btn {{ Request::is('client/compose-message/cl')? 'btn-warning' : 'btn-default'}}"><span class="fa fa-envelope"></span> Clients</a>
              </div>
              <div class="col-md-2">
              <a href="{{url('client/compose-message/ot')}}" class="btn {{ Request::is('client/compose-message/ot')? 'btn-warning' : 'btn-default'}}"><span class="fa fa-envelope"></span> Other Party</a>
              </div> -->
               <div class="col-md-2">
                <a href="{{url('other-party/compose-message')}}" class="btn btn-default btn-sm" title="Refresh"><i class="fa fa-refresh"></i></a>
              </div>
            </div>
            <!-- /.box-header -->
          <form action="{{url('other-party/send-mail')}}" class="-bootstrap-modal-form" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">

              <div class="form-group">
              @if(!empty($users))
               <select id="tag_list" name="to[]" class="form-control" multiple>
                 <!-- @foreach($users as $user)
                  <option value="{{$user['id']}}" selected="select">{{$user['email']}} @if($user['role_id'] == 3)[Client] @elseif($user['role_id'] == 4) [Staff] @elseif($user['role_id'] == 5) [Other Party]@endif</option>
                @endforeach -->
                @foreach($users as $user)
                  <option value="{{$user['id']}}" selected="select">{{$user['email']}} [{{$user['surname']}}{{ $user['name']}}]</option>
                @endforeach
               </select>
              @else
               <select id="tag_list" name="to[]" class="form-control" multiple>

               </select>
              @endif
                 
                  <span class="text-danger">{{ $errors->first('to') }}</span>
              </div>

               <div class="form-group">
                <input class="form-control" id="TextBox1" name="subject" placeholder="Subject:" value="{{old('subject')}}">
                <span class="text-danger">{{ $errors->first('subject') }}</span>
              </div>

              <div class="form-group">
                    <textarea id="compose-textarea" class="form-control" name="message" style="height: 300px">{{old('message')}}
                     
                    </textarea>
                    <span class="text-danger">{{ $errors->first('message') }}</span>
              </div>

              <div class="input_fields_wrap">
                  <div class="form-group">
                  <label><b>Attachments:</b></label>
                  <input type="file" name="attachments[]" class="form-control">
                  </div>
                  <a href="#" class="add_field_button fa fa-arrows" style="color:green">Add More</a>
              </div>


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
               <!--  <button type="submit" name="drafts" value="active" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button> -->
                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
              <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
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

@section('pagelevel-script')
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

