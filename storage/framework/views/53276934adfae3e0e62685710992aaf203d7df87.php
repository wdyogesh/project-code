<div class="col-md-12">  
      <?php if(isset($all_client_notes)): ?>
      <?php $__currentLoopData = $all_client_notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-md-12">
            <!-- DIRECT CHAT PRIMARY -->
            <input type="hidden" value="<?php echo e($notes['client_id']); ?>" id="client_id">
            <div class="box box-primary direct-chat direct-chat-primary">
              <div class="box-header with-border">
               <h3 class="box-title"> <b><?php echo e($notes['consultation_type']); ?></b></h3>
              </div>
              <!-- /.box-header -->

              <div class="box-body">
               <!-- /.box-body -->
              <div class="box-footer">
                <form action="#" method="post">
                  <div class="input-group">
                    <p class="box-title"> <b style="color:#367fa9">Added By: </b><?php echo e($notes['consultation_type']); ?></p><hr>
                    <p class="box-title"> <b style="color:#367fa9">Appointment: </b><?php echo e($notes['appoiintment_date']); ?></p><hr>

                    <p class="box-title"> <b style="color:#367fa9">Category: </b><?php echo e($notes['category_name']); ?></p><hr>
                    <p class="box-title"> <b style="color:#367fa9">Other Party: </b><?php echo e($notes['other_party_name']); ?> [<?php echo e($notes['other_party_category']); ?>]</p><hr>
                    <h5 class="box-title"> <b style="color:#367fa9">Notes:</b><?php echo $notes['notes']; ?></h5><hr>
                     <p class="box-title"> <b style="color:#367fa9">Created Date: </b><?php echo e($notes['created_record_date']); ?></p><hr>
                        
                  </div>
                </form>
              </div>
              
              </div>
          
             <div class="box-header with-border">
               <?php if($notes['added_by_id'] == Auth::user()->id): ?>
               <a href="<?php echo e(url('employee/edit-client-notes/'.Hashids::encode($notes['notes_id']).'/'.Hashids::encode($notes['client_id']))); ?>" class="btn btn-info" title="Edit">
                 <span class="glyphicon glyphicon-pencil"></span>
               </a>
                <button class="btn btn-danger btn-delete delete-client" value="<?php echo e($notes['notes_id']); ?>" title="Delete"><span class="glyphicon glyphicon-trash"></span></button>
              <?php endif; ?>
            </div>
          

            </div>
            <!--/.direct-chat -->
          </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
      <?php else: ?>
      <h3 style="color:blue;" align="center">No Results Found</h3>
      <?php endif; ?>  
      </div>