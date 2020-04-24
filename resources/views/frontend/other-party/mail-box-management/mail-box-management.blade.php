@extends('frontend.other-party.layouts.master')
@section('title')
Other Party-Mail Box
@endsection
@section('pagelevel-styles')
<style type="text/css">
.manager-content-wrapper{margin-left: 0;}
</style>
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
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
          <a href="{{url('other-party/compose-message')}}" class="btn btn-primary btn-block margin-bottom">Compose</a>

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
      <form method="post" action="{{url('other-party/trash')}}">
        {{ csrf_field() }}
        <input type="hidden" name="page_name" value="Inbox">
        <!-- unread message inbox start -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
             <div class="col-md-1">
             </div>
             <!-- <div class="col-md-2">
             <a href="{{url('employee/mail-box')}}" class="btn {{ Request::is('employee/mail-box/*')? 'btn-primary' : 'btn-warning'}}"><span class="fa fa-envelope"></span> All</a>
             </div> -->
             <!-- <div class="col-md-2">
              <a href="{{url('employee/mail-box/ad')}}" class="btn btn-info"><span class="fa fa-envelope"></span> Admin</a>
              </div> -->
             <!--  <div class="col-md-2">
              <a href="{{url('employee/mail-box/em')}}" class="btn {{ Request::is('employee/mail-box/em')? 'btn-warning' : 'btn-primary'}} btn-block margin-bottom"><span class="fa fa-envelope"></span> Employees</a>
              </div> 
              <div class="col-md-2">
              <a href="{{url('employee/mail-box/cl')}}" class="btn {{ Request::is('employee/mail-box/cl')? 'btn-warning' : 'btn-primary'}}"><span class="fa fa-envelope"></span> Clients</a>
              </div> -->
             <!--  <div class="col-md-2">
              <a href="{{url('employee/mail-box/ot')}}" class="btn {{ Request::is('employee/mail-box/ot')? 'btn-warning' : 'btn-primary'}}"><span class="fa fa-envelope"></span> Other Party</a>
              </div> -->

            </div>
            <!-- /.box-header -->
           
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-trash-o" title="Trash"></i></button>
                 <!--  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button> -->
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm" onClick="window.location.reload();" title="Refresh"><i class="fa fa-refresh"></i></button>
                <!-- <div class="pull-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                </div> -->
                <!-- /.pull-right -->
              </div>
             <!--  unread message inbox start -->
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                   @if(count($inbox_messages) != 0)
                  @foreach($inbox_messages as $inbox_message)
                  <tr>
                   <td>
                   <input type="checkbox" name="selected[]" value="{{$inbox_message->master_table_email_id}}">
                   </td>
                    <td>
                    <a href="{{url('other-party/important',$inbox_message->master_table_email_id)}}"><i style="color:#999" class="fa fa-star @if($inbox_message->user_id != "") text-yellow @endif"></i></a></td>

                    <td class="mailbox-name"><a href="{{url('other-party/read-message-details/'.Hashids::encode($inbox_message->master_table_email_id).'/'.Hashids::encode(1) )}}" title="Subject">{{$inbox_message->subject}}</a></td>


                    <td class="mailbox-subject"><b title="Message">{!! str_limit($inbox_message->message,70) !!}</b>
                    </td>
                    @if(!empty($inbox_message->attachments))
                    <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                    @else
                    <td class="mailbox-attachment"></i></td>
                    @endif
                    <td class="mailbox-date">{{$inbox_message->date}}</td>
                  </tr>
                  @endforeach
                   @else
           
                <h3 style="color:green" align="center">
                 Box Empty

                </h3>
             
            @endif
             
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
            </div>
           
          </div>
          <!-- /. box -->
        </div>
        <!-- unread message inbox start -->
               
      <!-- read message inbox start -->
        @if(count($inbox_read_messages) != 0)
        <div class="col-md-9">
          <div class="box box-primary" style="border-top-color:green;">
            <div class="box-header with-border">
              <h3 class="box-title">Read Messages</h3>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  @foreach($inbox_read_messages as $inbox_message)
                  <tr>
                   <td>
                   <input type="checkbox" name="selected[]" value="{{$inbox_message->master_table_email_id}}">
                   </td>
                    <td>
                     <a href="{{url('other-party/important',$inbox_message->master_table_email_id)}}"><i style="color:#999" class="fa fa-star @if($inbox_message->email_table_id != "") text-yellow @endif"></i></a></td>
                    </td>
                    <td class="mailbox-name"><a href="{{url('other-party/read-message-details/'.Hashids::encode($inbox_message->master_table_email_id).'/'. Hashids::encode(2) )}}" title="Subject">{{$inbox_message->subject}}</a></td>
                  






                    <td class="mailbox-subject"><b title="Message">{!! str_limit($inbox_message->message,120) !!}</b>
                    </td>
                    @if(!empty($inbox_message->attachments))
                    <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                    @else
                    <td class="mailbox-attachment"></i></td>
                    @endif
                    <td class="mailbox-date">{{$inbox_message->date}}</td>
                  </tr>
                  @endforeach   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /. box -->
        </div>
        @endif
      <!-- read message inbox end -->  
    </form>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('pagelevel-script')
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<!-- email template script for checkbox start-->
<script>
  $(function () {
    //Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.mailbox-messages input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
        //Check all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }
      $(this).data("clicks", !clicks);
    });

    //Handle starring for glyphicon and font awesome
    $(".mailbox-star").click(function (e) {
      e.preventDefault();
      //detect type
      var $this = $(this).find("a > i");
      var glyph = $this.hasClass("glyphicon");
      var fa = $this.hasClass("fa");

      //Switch states
      if (glyph) {
        $this.toggleClass("glyphicon-star");
        $this.toggleClass("glyphicon-star-empty");
      }

      if (fa) {
        $this.toggleClass("fa-star");
        $this.toggleClass("fa-star-o");
      }
    });
  });
</script>
<!-- email template script for checkbox end-->
@endsection
