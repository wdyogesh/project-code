 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
         @if(Auth::user()->profile_pic == '')             
        <img src="{{asset('img1.jpg')}}" class="img-circle" alt="User Image" data-toggle="modal" data-target="#myModal">
        @else
        <img src="{{ asset('/uploads/profile_pics/'. Auth::user()->profile_pic) }}" class="img-circle" alt="User Image" data-toggle="modal" data-target="#myModal">
        @endif
      </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}} {{Auth::user()->surname}}</p>
         <!--  <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
      </div>
      <!-- search form -->
    
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">My Tabs</li>
        <li class="{{ Request::is('admin/dashboard')? 'active' : ''}}">
          <a href="{{url('admin')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
       
        <li class="treeview {{ Request::is('admin/client-management')? 'active' : ''}}">
          <a href="{{url('admin/client-management')}}">
            <i class="fa fa-user"></i> <span>Clients</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li class=""><a href="{{url('admin/client-management')}}"><i class="fa fa-circle-o"></i>Registered Clients</a></li>
          <li class=""><a href="{{url('admin/trialperiod-business-clients-list')}}"><i class="fa fa-circle-o"></i>Trial period clients list</a></li>
        </ul>
        </li>

        <li class="treeview">
          <a href="{{url('admin/subscriptions')}}">
            <i class="fa fa-calendar"></i> <span>Subscriptions</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li class=""><a href="{{url('admin/subscription-plans')}}"><i class="fa fa-circle-o"></i>Subscriptions Plans</a></li>
          <li class=""><a href="{{url('admin/business-cliens-subscriptions')}}"><i class="fa fa-circle-o"></i>Business Client Subscriptions</a></li>
        </ul>
        </li>
        <li class="{{ Request::is('admin/mail-box') || Request::is('admin/mail-box/*') || Request::is('admin/compose-message') || Request::is('admin/sent-items')|| Request::is('admin/trash')|| Request::is('admin/important-message') || Request::is('admin/manage-group') || Request::is('admin/add-group') || Request::is('admin/edit-group/*')? 'active' : ''}}">
          <a href="{{url('admin/mail-box')}}">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
             <!--  <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small> -->
            </span>
          </a>
        </li>
       <li class="{{ Request::is('admin/my-tickets') || Request::is('admin/create-ticket')? 'active' : ''}}">
        <a href="{{url('admin/my-tickets')}}">
          <i class="fa fa-ticket"></i> <span>My Tickets</span>
          <small class="label pull-right bg-green"><!-- {{$total_red_unread_messages_count}} --></small>
          <!-- <span class="pull-right-container">
            <small class="label pull-right bg-yellow">12</small>
            <small class="label pull-right bg-green">16</small>
            <small class="label pull-right bg-red">5</small>
          </span> -->
        </a>
      </li>
        <!-- <li>
          <a href="{{url('admin/feedback')}}">
            <i class="fa fa-share"></i> <span>Feedback</span>
            
          </a>
        </li> -->

        <li class="treeview {{Request::is('admin/feedback-categories') || Request::is('admin/create-feedback-categories') || Request::is('admin/edit-feedback-categories/*') || Request::is('admin/manage-feedback')? 'active' : ''}}">
        <a href="#">
          <i class="fa fa-hourglass"></i> <span>Feed Back</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{Request::is('admin/feedback-categories') || Request::is('admin/create-feedback-categories') || Request::is('admin/edit-feedback-categories/*')? 'active' : ''}}"><a href="{{url('admin/feedback-categories')}}"><i class="fa fa-circle-o"></i>Categories</a></li>
          <li class="{{Request::is('admin/manage-feedback')? 'active' : ''}}"><a href="{{url('admin/manage-feedback')}}"><i class="fa fa-circle-o "></i>Client Feed Backs</a></li>
        </ul>
      </li>

      <li class="{{ Request::is('admin/send-reset-credentials-link') ? 'active' : ''}}">
        <a href="{{url('admin/send-reset-credentials-link')}}">
          <i class="fa fa-user"></i> <span>Forgot Credential Requests</span>
          <small class="label pull-right bg-green"><!-- {{$total_red_unread_messages_count}} --></small>
          <!-- <span class="pull-right-container">
            <small class="label pull-right bg-yellow">12</small>
            <small class="label pull-right bg-green">16</small>
            <small class="label pull-right bg-red">5</small>
          </span> -->
        </a>
      </li>

       <li class="treeview {{ Request::is('admin/change-password') || Request::is('admin/profile')|| Request::is('admin/edit-profile/*') || Request::is('admin/subscriptions') ? 'active' : ''}}">
        <a href="#">
          <i class="fa fa-cog"></i> <span>Settings</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{Request::is('admin/profile') || Request::is('admin/edit-profile/*')? 'active' : ''}}"><a href="{{url('admin/profile')}}"><i class="fa fa-circle-o"></i>My Profile</a></li>
          <li class="{{Request::is('admin/change-password')? 'active' : ''}}"><a href="{{url('admin/change-password')}}"><i class="fa fa-circle-o "></i>Change Password</a></li>
        </ul>
      </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>