<div class="box-body no-padding">
      <ul class="nav nav-pills nav-stacked">
        <li><a href="<?php echo e(url('manager/mail-box')); ?>" style="<?php echo e(Request::is('manager/mail-box')? 'color:green' : ''); ?>"><i class="fa fa-inbox"></i> Inbox
          <span class="label label-success pull-right"><?php echo e($total_red_unread_messages_count); ?></span></a></li>
        <li><a href="<?php echo e(url('manager/sent-items')); ?>" style="<?php echo e(Request::is('manager/sent-items')? 'color:green' : ''); ?>"><i class="fa fa-envelope-o"></i> Sent<span class="label label-primary pull-right"><?php echo e($sent_messages_count); ?></span></a></li>
       <!--  <li><a href="<?php echo e(url('manager/drafts')); ?>" style="<?php echo e(Request::is('manager/drafts')? 'color:green' : ''); ?>"><i class="fa fa-file-text-o"></i> Drafts<span class="label label-warning pull-right"><?php echo e($draft_messages_count); ?></span></a></li> -->
       <!--  <li><a href="#"><i class="fa fa-filter"></i> Junk <span class="label label-warning pull-right">65</span></a>
        </li> -->
        <li><a href="<?php echo e(url('manager/trash')); ?>" style="<?php echo e(Request::is('manager/trash')? 'color:green' : ''); ?>"><i class="fa fa-trash-o"></i> Trash<span class="label label-danger pull-right"><?php echo e($trash_messages_count); ?></span></a></li>
      </ul>
</div>