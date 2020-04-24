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

        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Sent Box</h3>

             <!--  <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Search Mail">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div> -->
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            @if(count($sent_messages) != 0)
            <form method="post" action="{{url('other-party/trash')}}">
             {{ csrf_field() }}
              <input type="hidden" name="page_name" value="Sent Box">
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
               <!--  <div class="pull-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                </div> -->
                <!-- /.pull-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  @foreach($sent_messages as $sent_message)
                  <tr>
                   <td>
                   <input type="checkbox" name="selected[]" value="{{$sent_message->master_table_email_id}}">
                   </td>
                    <td>
                    <a href="{{url('other-party/important',$sent_message->master_table_email_id)}}"><i style="color:#999" class="fa fa-star @if($sent_message->email_table_id != "") text-yellow @endif"></i></a>
                    </td>
                    <td class="mailbox-name"><a href="{{url('other-party/read-message-details/'.Hashids::encode($sent_message->master_table_email_id).'/'. Hashids::encode(3) )}}" title="Subject">{{$sent_message->subject}}</a></td>

                   

                    <td class="mailbox-subject"><b title="Message">{!! str_limit($sent_message->message,40) !!}</b>
                    </td>
                    @if(!empty($sent_message->attachments))
                    <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                    @else
                    <td class="mailbox-attachment"></i></td>
                    @endif
                    <td class="mailbox-date">{{$sent_message->date}}</td>

                  </tr>
                  @endforeach
                
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
           
            </form>
            @else
            <div class="box-body no-padding">
             
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                 
                  <h3 style="color:red" align="center">
                   Your Sent Box Empty

                  </h3>
                  
                
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            @endif
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
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
