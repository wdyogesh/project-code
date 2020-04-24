<div class="box-body no-padding">
      <ul class="nav nav-pills nav-stacked">
        <li><a href="{{url('employee/mail-box')}}" style="{{ Request::is('employee/mail-box')? 'color:green' : ''}}"><i class="fa fa-inbox"></i> Inbox
          <span class="label label-success pull-right">{{$total_red_unread_messages_count}}</span></a></li>
        <li><a href="{{url('employee/sent-items')}}" style="{{ Request::is('employee/sent-items')? 'color:green' : ''}}"><i class="fa fa-envelope-o"></i> Sent<span class="label label-primary pull-right">{{$sent_messages_count}}</span></a></li>
       <!--  <li><a href="{{url('manager/drafts')}}" style="{{ Request::is('manager/drafts')? 'color:green' : ''}}"><i class="fa fa-file-text-o"></i> Drafts<span class="label label-warning pull-right">{{$draft_messages_count}}</span></a></li> -->
       <!--  <li><a href="#"><i class="fa fa-filter"></i> Junk <span class="label label-warning pull-right">65</span></a>
        </li> -->
        <li><a href="{{url('employee/trash')}}" style="{{ Request::is('employee/trash')? 'color:green' : ''}}"><i class="fa fa-trash-o"></i> Trash<span class="label label-danger pull-right">{{$trash_messages_count}}</span></a></li>
      </ul>
</div>