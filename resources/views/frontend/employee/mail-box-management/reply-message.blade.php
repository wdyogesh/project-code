@extends('frontend.employee.layouts.master')
@section('title')
Employee-Mail Box
@endsection
@section('pagelevel-styles')
<style type="text/css">
.manager-content-wrapper{margin-left: 0;}
.select2-container--default .select2-selection--multiple .select2-selection__choice
{color:#333;}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
 <link href="{{asset('multiple-file-upload/css/style.css')}}" rel="stylesheet" />
 <style type="text/css">
 </style>
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
          <a href="{{url('employee/read-message-details/'.Hashids::encode($message_id).'/'. Hashids::encode($page_name_dummy_number) )}}" class="btn btn-primary btn-block margin-bottom">Go Back</a>


          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            @include('frontend.employee.mail-box-management.message-sidebar-up')
            
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
          @include('frontend.employee.mail-box-management.message-sidebar-lables')
       
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9" style="max-height: 550px;overflow-y: scroll;">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Reply Message</h3>
            </div>
            <!-- /.box-header -->
            <form action="{{url('employee/reply-message-post')}}" class="-bootstrap-modal-form" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">

              <div class="form-group">
                  <select id="tag_list" name="to[]" class="form-control" multiple>
                   <option value="{{$reply_to_message_record['id']}}" selected="select">{{$reply_to_message_record['email_address']}}</option>
                  </select>
                  <span class="text-danger">{{ $errors->first('to') }}</span>
              </div>

               <div class="form-group">
                <input class="form-control" name="subject" placeholder="Subject:" value="{{$reply_to_message_record['subject']}}">
                <span class="text-danger">{{ $errors->first('subject') }}</span>
              </div>

              <div class="form-group">
                    <textarea id="compose-textarea" class="form-control" name="message" style="height:120px;" style="max-height: 550px;overflow-y: scroll;">{{old('message')}}
                     
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
            <input type="hidden" name="master_message_id" value="{{$reply_to_message_record['id']}}">
              <div class="pull-right">
               <!--  <button type="submit" name="drafts" value="active" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button> -->
                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
              <!-- <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button> -->
            </div>
           </form>
            <!-- /.box-footer -->
            <div class="mailbox-read-message"><b>Last Message:</b>
            {!! $reply_to_message_record['date'] !!}
            </div>
            <div class="mailbox-read-message">
            {!! $reply_to_message_record['message'] !!} 
            </div>
            <div class="box-footer">
              <ul class="mailbox-attachments clearfix">
                @if ($reply_to_message_record['attachments'] != "")
                  @foreach(explode(',', $reply_to_message_record['attachments']) as $info) 
                     <li>
                        <span class="mailbox-attachment-icon">
                       @if(pathinfo($info, PATHINFO_EXTENSION) == 'jpg' || pathinfo($info, PATHINFO_EXTENSION) == 'png') 
                        <img class="img-responsive" src="{{asset('uploads/mail-attachments/' . $info) }}" alt="">
                        </span>
                        <div class="mailbox-attachment-info">
                          <a href="{{asset('uploads/mail-attachments/' . $info) }}" class="mailbox-attachment-name" download><i class="fa fa-camera"></i></i>{{$info}}</a>
                        @else
                        <i class="fa fa-file-pdf-o"></i>
                        </span>
                        <div class="mailbox-attachment-info">
                          <a href="{{asset('uploads/mail-attachments/' . $info) }}" class="mailbox-attachment-name" download><i class="fa fa-paperclip"></i></i></i>{{$info}}</a>
                        @endif  
                        <?php
                        $size= filesize(public_path('uploads/mail-attachments/'.$info));
                        $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
                        $power = $size > 0 ? floor(log($size, 1024)) : 0; 
                        //($size * .0009765625) * .0009765625 
                        $size= number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
                        ?>         
                            <span class="mailbox-attachment-size">

                            {{ $size }}
                            <a href="{{asset('uploads/mail-attachments/' . $info) }}" class="btn btn-default btn-xs pull-right" download><i class="fa fa-cloud-download"></i></a>
                              </span>
                        </div>
                     </li>
                  @endforeach
                @endif
               
                <!-- <li>
                  <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> App Description.docx</a>
                        <span class="mailbox-attachment-size">
                          1,245 KB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                  </div>
                </li>
                <li>
                  <span class="mailbox-attachment-icon has-img"><img src="{{asset('dashboard/dist/img/photo1.png')}}" alt="Attachment"></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
                        <span class="mailbox-attachment-size">
                          2.67 MB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                  </div>
                </li>
                <li>
                  <span class="mailbox-attachment-icon has-img"><img src="{{asset('dashboard/dist/img/photo2.png')}}" alt="Attachment"></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
                        <span class="mailbox-attachment-size">
                          1.9 MB
                          <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                        </span>
                  </div>
                </li> -->
              </ul>
            </div>
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
            minimumInputLength: 1,
            ajax: {
                url: "{{url('employee/emial-data')}}",
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

