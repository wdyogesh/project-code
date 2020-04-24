<?php $__env->startSection('title'); ?>
Business Manager-Mail Box
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<style type="text/css">
.manager-content-wrapper{margin-left: 0;}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
          <a href="<?php echo e(url('manager/compose-message')); ?>" class="btn btn-primary btn-block margin-bottom">Compose</a>

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
          <?php echo $__env->make('frontend.business-manager.mail-box-management.message-sidebar-up', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
       <?php echo $__env->make('frontend.business-manager.mail-box-management.message-sidebar-lables', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <!-- /.box -->
        </div>
      <form method="post" action="<?php echo e(url('manager/trash')); ?>">
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="page_name" value="Inbox">
        <!-- unread message inbox start -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
             <div class="col-md-1">
             </div>
             <div class="col-md-2">
               <a href="<?php echo e(url('manager/mail-box')); ?>" class="btn <?php echo e(Request::is('manager/mail-box/*')? 'btn-primary' : 'btn-warning'); ?>"><span class="fa fa-envelope"></span> All</a>
             </div>
             <div class="col-md-2">
              <a href="<?php echo e(url('manager/mail-box/ad')); ?>" class="btn <?php echo e(Request::is('manager/mail-box/ad')? 'btn-warning' : 'btn-primary'); ?> btn-block margin-bottom"><span class="fa fa-envelope"></span> Admin</a>
              </div>
              <div class="col-md-2">
              <a href="<?php echo e(url('manager/mail-box/em')); ?>" class="btn <?php echo e(Request::is('manager/mail-box/em')? 'btn-warning' : 'btn-primary'); ?> btn-block margin-bottom"><span class="fa fa-envelope"></span> Employees</a>
              </div> 
              <div class="col-md-2">
              <a href="<?php echo e(url('manager/mail-box/cl')); ?>" class="btn <?php echo e(Request::is('manager/mail-box/cl')? 'btn-warning' : 'btn-primary'); ?> btn-block margin-bottom"><span class="fa fa-envelope"></span> Clients</a>
              </div>
              <div class="col-md-2">
               <a href="<?php echo e(url('manager/mail-box/ot')); ?>" class="btn <?php echo e(Request::is('manager/mail-box/ot')? 'btn-warning' : 'btn-primary'); ?> btn-block margin-bottom"><span class="fa fa-envelope"></span> Other Party</a>
            
              </div>

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
                   <?php if(count($inbox_messages) != 0): ?>
                  <?php $__currentLoopData = $inbox_messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inbox_message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                   <td>
                   <input type="checkbox" name="selected[]" value="<?php echo e($inbox_message->master_table_email_id); ?>">
                   </td>
                    <td>
                    <a href="<?php echo e(url('manager/important',$inbox_message->master_table_email_id)); ?>"><i style="color:#999" class="fa fa-star <?php if($inbox_message->user_id != ""): ?> text-yellow <?php endif; ?>"></i></a></td>

                    <td class="mailbox-name"><a href="<?php echo e(url('manager/read-message-details/'.Hashids::encode($inbox_message->master_table_email_id).'/'.Hashids::encode(1) )); ?>" title="Subject"><?php echo e($inbox_message->subject); ?></a></td>


                    <td class="mailbox-subject"><b title="Message"><?php echo str_limit($inbox_message->message,70); ?></b>
                    </td>
                    <?php if(!empty($inbox_message->attachments)): ?>
                    <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                    <?php else: ?>
                    <td class="mailbox-attachment"></i></td>
                    <?php endif; ?>
                    <td class="mailbox-date"><?php echo e($inbox_message->date); ?></td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   <?php else: ?>
           
                <h3 style="color:green" align="center">
                 Box Empty

                </h3>
             
            <?php endif; ?>
             
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
        <?php if(count($inbox_read_messages) != 0): ?>
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
                  <?php $__currentLoopData = $inbox_read_messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inbox_message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                   <td>
                   <input type="checkbox" name="selected[]" value="<?php echo e($inbox_message->master_table_email_id); ?>">
                   </td>
                    <td>
                     <a href="<?php echo e(url('manager/important',$inbox_message->master_table_email_id)); ?>"><i style="color:#999" class="fa fa-star <?php if($inbox_message->email_table_id != ""): ?> text-yellow <?php endif; ?>"></i></a></td>
                    </td>
                    <td class="mailbox-name"><a href="<?php echo e(url('manager/read-message-details/'.Hashids::encode($inbox_message->master_table_email_id).'/'. Hashids::encode(2) )); ?>" title="Subject"><?php echo e($inbox_message->subject); ?></a></td>
                  






                    <td class="mailbox-subject"><b title="Message"><?php echo str_limit($inbox_message->message,120); ?></b>
                    </td>
                    <?php if(!empty($inbox_message->attachments)): ?>
                    <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                    <?php else: ?>
                    <td class="mailbox-attachment"></i></td>
                    <?php endif; ?>
                    <td class="mailbox-date"><?php echo e($inbox_message->date); ?></td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /. box -->
        </div>
        <?php endif; ?>
      <!-- read message inbox end -->  
    </form>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>