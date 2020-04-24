<div class="box-body no-padding">
      <ul class="nav nav-pills nav-stacked">
        <li><a href="<?php echo e(url('employee/client-details/'.Hashids::encode($client_record['id']))); ?>" style="<?php echo e(Request::is('employee/client-details/*') || Request::is('employee/edit-client/*')? 'color:green' : ''); ?>"><i class="fa fa-inbox"></i>Client Details
          <span class="label label-success pull-right"></span></a></li>

        <li><a href="<?php echo e(url('employee/notes/'.Hashids::encode($client_record['id']))); ?>" style="<?php echo e(Request::is('employee/notes/*') || Request::is('employee/create-notes/*')|| Request::is('employee/edit-client-notes/*') || Request::is('employee/details/*')? 'color:green' : ''); ?>"><i class="glyphicon glyphicon-file"></i>Notes<span class="label label-primary pull-right"><!-- 0 --></span></a></li>

        <li><a href="<?php echo e(url('employee/client-attachments/'.Hashids::encode($client_record['id']))); ?>" style="<?php echo e(Request::is('employee/client-attachments/*')? 'color:green' : ''); ?>"><i class="fa fa-file-text-o"></i>Attachments<span class="label label-warning pull-right"><!-- 0 --></span></a></li>
     
        <li><a href="<?php echo e(url('employee/client-appointments/'.Hashids::encode($client_record['id']))); ?>" style="<?php echo e(Request::is('employee/client-appointments/*')? 'color:green' : ''); ?>"><i class="fa fa-calendar"></i>Appointments<span class="label label-danger pull-right"><!-- 0 --></span></a></li>
        <li><a href="<?php echo e(url('employee/compose-message/'.Hashids::encode($client_record['id']))); ?>"><i class="fa fa-envelope"></i> ICMAIL<span class="label label-danger pull-right"><!-- 0 --></span></a></li>
      </ul>
</div>