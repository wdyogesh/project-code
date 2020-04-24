<?php $__env->startSection('title'); ?>
Business Employee-Client Notes
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-styles'); ?>
<style type="text/css">
.manager-content-wrapper{margin-left: 0;}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper manager-content-wrapper">
  <section class="content">


      <div class="row">
         <div class="col-md-3">
          <a href"#" class="btn btn-primary btn-block margin-bottom"><h4>
          <?php echo e($client_record['name']); ?> <?php echo e($client_record['surname']); ?> / Notes
         </h4>
         </a>

          <div class="box box-solid">
            <div class="box-header with-border">
             <!--  <h3 class="box-title">Folders</h3> -->

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
           <?php echo $__env->make('frontend.employee.client-management.client-details-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          </div>
        
        </div>
        <div class="col-md-9">

                <div class="box-footer">

                  <div class="col-md-10" >
                    <input type="text" name="message"  placeholder="Type Message ..." id="message" class="form-control">
                  </div>   
                  <div class="col-md-2"  >
                  <a href="<?php echo e(url('employee/create-notes/'.Hashids::encode($client_record['id']))); ?>" class="btn btn btn-success btn-flat pull-right">Add Note</a>
                  </div>    
                </div><br>
       <div class="alert alert-success alert-dismissable" id="sucMsgDeleteDiv" style="display: none;">
         <i class="fa fa-check"></i>
         <b>Record Deleted Success!</b>
         <span class="sucmsgdiv"></span>                     
       </div>
        <?php if(Session::has('success')): ?>
       <div  align="center" id="successMessage"  class="alert alert-info"><?php echo e(Session::get('success')); ?>

       </div>
       <?php endif; ?> 
                   <input type="hidden" value="<?php echo e($client_id); ?>" id="client_id">

       <div id="ajaxnotes">
        <div class="col-md-12">  
      <?php if(isset($all_client_notes)): ?>
      <?php $__currentLoopData = $all_client_notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-md-12">
            <!-- DIRECT CHAT PRIMARY -->
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
      <?php endif; ?>  
      </div>
      </div>
      </div>
      </div>
      <!-- /.row -->
    </section>
  </div>
  <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagelevel-script'); ?>
<meta name="_token" content="<?php echo csrf_token(); ?>" />
<script src="<?php echo e(asset('js/login-bootstrap-modal-form.js')); ?>"></script>
<script>
  var url = "<?php echo e(url('employee/delete-client-notes')); ?>";
  $(document).on('click','.delete-client',function(){
    if(confirm('Are you sure want to delete?')){
      var user_id = $(this).val();
      /*alert(user_id);*/
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      })
      $.ajax({
        type: "DELETE",
        url: url + '/' + user_id,         
        success: function (data) {
          console.log(data);
          $('#sucMsgDeleteDiv').show('slow');
          setTimeout(function(){ $('#sucMsgDeleteDiv').hide('slow');location.reload(); }, 500);
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    }
  });


$("#message").on('keyup blur keypress', function() {

  var mesg = $("#message").val();
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
    })
  if(mesg.length == 0){
    $.ajax({
            type: "POST",
            url: "<?php echo e(url('employee/searchnotes')); ?>",
            data: {search: '', client_id: $("#client_id").val()},
            success: function( msg ) {
              $("#ajaxnotes").empty();
              $("#ajaxnotes").append(msg);
              //alert(msg);
                //$("#ajaxResponse").append("<div>"+msg+"</div>");
            }
        });
  }else{
    if(mesg.length > 2) {

   $.ajax({
            type: "POST",
            url: "<?php echo e(url('employee/searchnotes')); ?>",
            data: {search: mesg, client_id: $("#client_id").val()},
            success: function( msg ) {
              $("#ajaxnotes").empty();
              $("#ajaxnotes").append(msg);
              //alert(msg);
                //$("#ajaxResponse").append("<div>"+msg+"</div>");
            }
        });
  }
 }
})

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.employee.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>