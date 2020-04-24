
<?php $__env->startSection('title'); ?>
Business Manager-Subscriptions
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 <section class="content-header">
     
  
<section class="content">
    
     <div class="row">
        <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title"><b style="color:green">Subject:</b><?php echo e($main_ticket['subject']); ?></h3>
            </div>
            <div class="box-body">
        
              <div class="form-group">
                <label><b>Ticket Id:</b></label> <?php echo e($main_ticket['ticket_id']); ?>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <b>Status:</b> </label> <?php echo e($main_ticket['status']); ?>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><b> Created Date:</b> </label>  <?php echo e($main_ticket['record_created_date']); ?>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label><b> Last Action:</b> </label>  <?php echo e($main_ticket['record_updated_date']); ?>

              </div>
            </div>
        </div>
          <!-- /.box -->
     </div>
<?php $__currentLoopData = $main_thread; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thread): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="row">
    	<div class="col-xs-2">
    	</div>
     	 <div class="col-xs-8">
     		 <div class="box box-success" style="border-top-color:brown;background: #ccc;">
            <div class="box-header">
            	<div style="clear: both">
				    <p style="float: left;color:white"><b style="color:yellow">Messaged By:</b> <?php echo e($thread['name']); ?></p>
				    <p style="float: right;color:white"><b style="color:yellow">Date:</b> <?php echo e($thread['created_date']); ?></p>
				</div>
				<hr />
              
               
            </div>
            <div class="box-body">
               <p><?php echo $thread['message']; ?></p>
            </div>
            <?php if($thread['file'] != ""): ?>
            <div class="box-body">
               <p>
               	 <a href="<?php echo e(asset('uploads/ticketing-documents/' . $thread['file'])); ?>" title="Attachment" class="btn btn-default btn-xs pull-right" download><i class="fa fa-cloud-download"></i></a>
               </p>
            </div>
            <?php endif; ?>
        </div>
     	</div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
<?php if($main_ticket['closed'] != 1): ?>   
    <div class="row">
    	           <form action="<?php echo e(url('manager/reply-ticket')); ?>" class="-bootstrap-modal-form form-horizontal" method="post" enctype="multipart/form-data">
                       <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="ticket_id" value="<?php echo e($main_ticket['id']); ?>">   
                       <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Reply</label>
                                <div class="col-sm-8">
                                    <textarea  class="form-control" name="problem" style="height:100px"><?php echo e(old('problem')); ?></textarea>
				                    <span class="text-danger"><?php echo e($errors->first('problem')); ?></span>
                                </div>
                            </div>

                             <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Attachment</label>
                                <div class="col-sm-8">
                                    <input type="file" name="attachments" class="form-control">
                                </div>
                            </div>


                  <div class="form-group" align="center">
                    <a href="<?php echo e(url('manager/my-tickets')); ?>" class="btn btn-info">
                       Go back
                   </a>
                   <button type="submit" class="btn btn-success">Submit</button>
               </div>
                  </div>
                </div>  
           </form>
    </div>
<?php endif; ?>
  
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.business-manager.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>