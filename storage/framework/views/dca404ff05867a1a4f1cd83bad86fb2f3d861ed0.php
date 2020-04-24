<div class="box-body no-padding">
      <ul class="nav nav-pills nav-stacked">
        <li><a href="<?php echo e(url('manager/client-details/'.Hashids::encode($client_record['id']))); ?>" style="<?php echo e(Request::is('manager/client-details/*') || Request::is('manager/edit-client/*')? 'color:green' : ''); ?>"><i class="fa fa-inbox"></i>Client Details
          <span class="label label-success pull-right"></span></a></li>

        <li><a href="<?php echo e(url('manager/notes/'.Hashids::encode($client_record['id']))); ?>" style="<?php echo e(Request::is('manager/notes/*') || Request::is('manager/create-notes/*')|| Request::is('manager/edit-client-notes/*') || Request::is('manager/details/*')? 'color:green' : ''); ?>"><i class="glyphicon glyphicon-file"></i>Notes<span class="label label-primary pull-right"><!-- 0 --></span></a></li>

        <li><a href="<?php echo e(url('manager/client-attachments/'.Hashids::encode($client_record['id']))); ?>" style="<?php echo e(Request::is('manager/client-attachments/*')? 'color:green' : ''); ?>"><i class="fa fa-file-text-o"></i>Attachments<span class="label label-warning pull-right"><!-- 0 --></span></a></li>
     
        <li><a href="<?php echo e(url('manager/client-appointments/'.Hashids::encode($client_record['id']))); ?>" style="<?php echo e(Request::is('manager/client-appointments/*')? 'color:green' : ''); ?>"><i class="fa fa-calendar"></i>Appointments<span class="label label-danger pull-right"><!-- 0 --></span></a></li>

        <li><a href="<?php echo e(url('manager/compose-message/'.Hashids::encode($client_record['id']))); ?>"><i class="fa fa-envelope"></i> ICMAIL<span class="label label-danger pull-right"><!-- 0 --></span></a></li>
      </ul>
</div>