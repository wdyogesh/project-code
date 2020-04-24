<?php $__env->startSection('title'); ?>
Business Manager-Mail Box
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<style type="text/css">
.manager-content-wrapper{margin-left: 0;}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
              
                <h5><?php if($dummy_page_wise_numbers == 3 || $dummy_page_wise_numbers == 4): ?> To <?php else: ?> From <?php endif; ?>: <?php if($dummy_page_wise_numbers == 3 || $dummy_page_wise_numbers == 4): ?><?php echo e($to_mail['email']); ?><?php else: ?> <?php echo e($from_mail['email']); ?> <?php endif; ?>
                  <span class="mailbox-read-time pull-right"><?php echo e($message_record_detail['date']); ?></span></h5>
                    <h5><b>Subject:</b><?php echo e($message_record_detail['subject']); ?></h5>
               
              </div>
              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                 <form <?php if($dummy_page_wise_numbers == 5): ?> action="<?php echo e(url('manager/detail-message-perminant-delete')); ?>" <?php else: ?> action="<?php echo e(url('manager/detail-message-trash')); ?>"<?php endif; ?> method="post">
                  <?php echo e(csrf_field()); ?>

                  <input type="hidden" name="detail_message" value="<?php echo e($message_record_detail['id']); ?>">
                  <input type="hidden" name="page_name" value="<?php echo e($dummy_page_wise_numbers); ?>">
                   <button type="submit" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete"><i class="fa fa-trash-o"></i></button>
                   <a href="<?php echo e(url('manager/manager-reply-message/'.Hashids::encode($message_record_detail['id']).'/'. Hashids::encode($dummy_page_wise_numbers) )); ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">


                    <i class="fa fa-reply"></i></a>
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
                <?php echo $message_record_detail['message']; ?>

              </div>
              <div class="box-footer">
                <ul class="mailbox-attachments clearfix">
                  <?php if($message_record_detail['attachments'] != ""): ?>
                    <?php $__currentLoopData = explode(',', $message_record_detail['attachments']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                       <li>
                          <span class="mailbox-attachment-icon">
                         <?php if(pathinfo($info, PATHINFO_EXTENSION) == 'jpg' || pathinfo($info, PATHINFO_EXTENSION) == 'png'): ?> 
                          <img class="img-responsive" src="<?php echo e(asset('uploads/mail-attachments/' . $info)); ?>" alt="">
                          </span>
                          <div class="mailbox-attachment-info">
                            <a href="<?php echo e(asset('uploads/mail-attachments/' . $info)); ?>" class="mailbox-attachment-name" download><i class="fa fa-camera"></i></i><?php echo e($info); ?></a>
                          <?php else: ?>
                          <i class="fa fa-file-pdf-o"></i>
                          </span>
                          <div class="mailbox-attachment-info">
                            <a href="<?php echo e(asset('uploads/mail-attachments/' . $info)); ?>" class="mailbox-attachment-name" download><i class="fa fa-paperclip"></i></i></i><?php echo e($info); ?></a>
                          <?php endif; ?>  
                          <?php
                          $size= filesize(public_path('uploads/mail-attachments/'.$info));
                          $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
                          $power = $size > 0 ? floor(log($size, 1024)) : 0; 
                          //($size * .0009765625) * .0009765625 
                          $size= number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
                          ?>         
                              <span class="mailbox-attachment-size">

                              <?php echo e($size); ?>

                              <a href="<?php echo e(asset('uploads/mail-attachments/' . $info)); ?>" class="btn btn-default btn-xs pull-right" download><i class="fa fa-cloud-download"></i></a>
                                </span>
                          </div>
                       </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                 
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
                    <span class="mailbox-attachment-icon has-img"><img src="<?php echo e(asset('dashboard/dist/img/photo1.png')); ?>" alt="Attachment"></span>

                    <div class="mailbox-attachment-info">
                      <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
                          <span class="mailbox-attachment-size">
                            2.67 MB
                            <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                          </span>
                    </div>
                  </li>
                  <li>
                    <span class="mailbox-attachment-icon has-img"><img src="<?php echo e(asset('dashboard/dist/img/photo2.png')); ?>" alt="Attachment"></span>

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
            <?php if(isset($thread_reply_messages)): ?>
            <?php $__currentLoopData = $thread_reply_messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thread_reply_message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="mailbox-read-message">
                <h5><b><?php echo e($thread_reply_message['date']); ?></b></h5>
              </div>
              <div class="mailbox-read-message">
                <?php echo $thread_reply_message['message']; ?>

              </div>
              <div class="box-footer">
                <ul class="mailbox-attachments clearfix">
                  <?php if($thread_reply_message['attachments'] != ""): ?>
                    <?php $__currentLoopData = explode(',', $thread_reply_message['attachments']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                       <li>
                          <span class="mailbox-attachment-icon">
                         <?php if(pathinfo($info, PATHINFO_EXTENSION) == 'jpg' || pathinfo($info, PATHINFO_EXTENSION) == 'png'): ?> 
                          <img class="img-responsive" src="<?php echo e(asset('uploads/mail-attachments/' . $info)); ?>" alt="">
                          </span>
                          <div class="mailbox-attachment-info">
                            <a href="<?php echo e(asset('uploads/mail-attachments/' . $info)); ?>" class="mailbox-attachment-name" download><i class="fa fa-camera"></i></i><?php echo e($info); ?></a>
                          <?php else: ?>
                          <i class="fa fa-file-pdf-o"></i>
                          </span>
                          <div class="mailbox-attachment-info">
                            <a href="<?php echo e(asset('uploads/mail-attachments/' . $info)); ?>" class="mailbox-attachment-name" download><i class="fa fa-paperclip"></i></i></i><?php echo e($info); ?></a>
                          <?php endif; ?>  
                          <?php
                          $size= filesize(public_path('uploads/mail-attachments/'.$info));
                          $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
                          $power = $size > 0 ? floor(log($size, 1024)) : 0; 
                          //($size * .0009765625) * .0009765625 
                          $size= number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
                          ?>         
                              <span class="mailbox-attachment-size">

                              <?php echo e($size); ?>

                              <a href="<?php echo e(asset('uploads/mail-attachments/' . $info)); ?>" class="btn btn-default btn-xs pull-right" download><i class="fa fa-cloud-download"></i></a>
                                </span>
                          </div>
                       </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </ul>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<script>
function myFunction() {
    window.print();
}
</script>
<!-- email template script for checkbox start-->

<!-- email template script for checkbox end-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>