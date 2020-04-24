<div class="box-body no-padding">
      <ul class="nav nav-pills nav-stacked">
        <li><a href="{{url('other-party/mail-box')}}" style="{{ Request::is('other-party/mail-box')? 'color:green' : ''}}"><i class="fa fa-inbox"></i> Inbox
          <span class="label label-success pull-right">{{$total_red_unread_messages_count}}</span></a></li>
        <li><a href="{{url('other-party/sent-items')}}" style="{{ Request::is('other-party/sent-items')? 'color:green' : ''}}"><i class="fa fa-envelope-o"></i> Sent<span class="label label-primary pull-right">{{$sent_messages_count}}</span></a></li>
       <!--  <li><a href="{{url('manager/drafts')}}" style="{{ Request::is('manager/drafts')? 'color:green' : ''}}"><i class="fa fa-file-text-o"></i> Drafts<span class="label label-warning pull-right">{{$draft_messages_count}}</span></a></li> -->
       <!--  <li><a href="#"><i class="fa fa-filter"></i> Junk <span class="label label-warning pull-right">65</span></a>
        </li> -->
        <li><a href="{{url('other-party/trash')}}" style="{{ Request::is('other-party/trash')? 'color:green' : ''}}"><i class="fa fa-trash-o"></i> Trash<span class="label label-danger pull-right">{{$trash_messages_count}}</span></a></li>
      </ul>
</div>