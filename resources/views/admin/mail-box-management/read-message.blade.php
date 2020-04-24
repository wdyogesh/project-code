@extends('admin.layouts.master')
@section('admin-title')
Admin-Mail Box
@endsection
@section('admin-pagelevel-styles')
<style type="text/css">
.manager-content-wrapper{margin-left: 0;}
</style>
@endsection
@section('admin-content')
 <div class="content-wrapper manager-content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Read Mail
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Mailbox</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="{{url('admin/compose-message')}}" class="btn btn-primary btn-block margin-bottom">Compose</a>

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
        <div class="col-md-9" style="max-height: 550px;overflow-y: scroll;">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Read Mail</h3>

              <div class="box-tools pull-right">
               <!--  <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a> -->
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
              
                <h5>@if($dummy_page_wise_numbers == 3 || $dummy_page_wise_numbers == 4) To @else From @endif: @if($dummy_page_wise_numbers == 3 || $dummy_page_wise_numbers == 4){{$to_mail['email']}}@else {{$from_mail['email']}} @endif
                  <span class="mailbox-read-time pull-right">{{$message_record_detail['date']}}</span></h5>
                    <h5><b>Subject:</b>{{$message_record_detail['subject']}}</h5>
               
              </div>
              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                 <form @if($dummy_page_wise_numbers == 5) action="{{url('admin/detail-message-perminant-delete')}}" @else action="{{url('admin/detail-message-trash')}}"@endif method="post">
                  {{ csrf_field() }}
                  <input type="hidden" name="detail_message" value="{{$message_record_detail['id']}}">
                  <input type="hidden" name="page_name" value="{{$dummy_page_wise_numbers}}">
                   <button type="submit" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete"><i class="fa fa-trash-o"></i></button>
                  <!--  <a href="{{url('admin/reply-message/'.Hashids::encode($message_record_detail['id']).'/'. Hashids::encode($dummy_page_wise_numbers) )}}" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">


                    <i class="fa fa-reply"></i></a> -->
                   <!-- <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward">
                    <i class="fa fa-share"></i></button> -->
                  </form>
                </div>
                <!-- /.btn-group -->
                
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">
                  <i class="fa fa-print" onclick="myFunction()"></i></button>
              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                {!! $message_record_detail['message'] !!}
              </div>
              <div class="box-footer">
                <ul class="mailbox-attachments clearfix">
                  @if ($message_record_detail['attachments'] != "")
                    @foreach(explode(',', $message_record_detail['attachments']) as $info) 
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
              <!-- /.mailbox-read-message -->
              <!-- Reply Messages thread -->
            @if(isset($thread_reply_messages))
            @foreach($thread_reply_messages as $thread_reply_message)
              <div class="mailbox-read-message">
                <h5><b>{{$thread_reply_message['date']}}</b></h5>
              </div>
              <div class="mailbox-read-message">
                {!! $thread_reply_message['message'] !!}
              </div>
              <div class="box-footer">
                <ul class="mailbox-attachments clearfix">
                  @if ($thread_reply_message['attachments'] != "")
                    @foreach(explode(',', $thread_reply_message['attachments']) as $info) 
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
                </ul>
              </div>
            @endforeach
            @endif
              <!-- Reply Messages thread -->
            </div>
            <!-- /.box-body -->
          
            <!-- /.box-footer -->
            <!-- <div class="box-footer">
              <div class="pull-right">
                <button type="button" class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
                <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
              </div>
              <button type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button>
              <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
            </div> -->
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
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
function myFunction() {
    window.print();
}
</script>
<!-- email template script for checkbox start-->

<!-- email template script for checkbox end-->
@endsection
