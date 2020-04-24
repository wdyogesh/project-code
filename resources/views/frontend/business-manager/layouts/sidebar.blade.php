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
				<p>{{Auth::user()->name}}</p>
				<!--  <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
			</div>
		</div>
		<!-- search form -->
		
		<!-- /.search form -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">My Tabs</li>

			<li class="{{ Request::is('manager/dashboard')? 'active' : ''}}">
				<a href="{{url('manager/dashboard')}}">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			
			<li class="treeview {{Request::is('manager/employee-roles') || Request::is('manager/employees') || Request::is('manager/create-employees') || Request::is('manager/edit-employee/*')? 'active' : ''}}">
				<a href="#">
					<i class="fa fa-users"></i> <span>Employee Management</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<!-- <li class="{{Request::is('manager/employee-roles') || Request::is('manager/create-emoloyee-role') || Request::is('manager/edit-emoloyee-role') ? 'active' : ''}}"><a href="{{url('manager/employee-roles')}}"><i class="fa fa-circle-o "></i>Roles</a></li> -->
					<li class="{{Request::is('manager/employees') || Request::is('manager/create-employees') || Request::is('manager/edit-employee/*')? 'active' : ''}}"><a href="{{url('manager/employees')}}"><i class="fa fa-circle-o"></i>Employees</a></li>
				</ul>
			</li>

			<li class="{{ Request::is('manager/clients') || Request::is('manager/create-client') || Request::is('manager/edit-client/*') || Request::is('manager/client-details/*') || Request::is('manager/notes/*') || Request::is('manager/create-notes/*') || Request::is('manager/edit-client-notes/*') || Request::is('manager/details/*') || Request::is('manager/client-attachments/*') || Request::is('manager/client-appointments/*')? 'active' : ''}}">
				<a href="{{url('manager/clients')}}">
					<i class="fa fa-users"></i> <span>Clients</span>
				</a>
			</li>

			<li class="{{Request::is('manager/manage-notes-category') || Request::is('manager/create-notes-category') || Request::is('manager/edit-notes-category/*')? 'active' : ''}}">
				<a href="{{url('manager/manage-notes-category')}}">
					<i class="glyphicon glyphicon-file"></i> <span>Notes Category</span>
				</a>
			</li>

			<!-- <li class="{{Request::is('manager/manage-notes-category') || Request::is('manager/create-notes-category') || Request::is('manager/edit-notes-category/*')? 'active' : ''}}"><a href="{{url('manager/manage-notes-category')}}">
				<a href="#">
					<i class="glyphicon glyphicon-file"></i> <span>Notes Category</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{Request::is('manager/manage-notes-category') || Request::is('manager/create-notes-category') || Request::is('manager/edit-notes-category/*')? 'active' : ''}}"><a href="{{url('manager/manage-client-notes')}}">
					<a href="{{url('manager/manage-notes-category')}}"><i class="fa fa-circle-o"></i>Notes Category</a></li>

					<li class="{{Request::is('manager/manage-client-notes') || Request::is('manager/create-client-notes') || Request::is('manager/edit-client-notes/*')? 'active' : ''}}"><a href="{{url('manager/manage-client-notes')}}"><i class="fa fa-circle-o"></i>Notes</a></li>
				</ul>
			</li> -->

			<li class="{{ Request::is('manager/appointments')? 'active' : ''}}">
				<a href="{{url('manager/appointments')}}">
					<i class="fa fa-calendar"></i> <span>Appointments</span>
				</a>
			</li>

			

			<li class="treeview {{Request::is('manager/manage-other-party-category') || Request::is('manager/create-other-party-category') || Request::is('manager/edit-other-party-category/*') || Request::is('manager/invite-other-party')|| Request::is('manager/send-other-party-invitation') || Request::is('manager/other-party-registration-by-manager') || Request::is('manager/manage-other-parties') || Request::is('manager/crete-other-parties') || Request::is('manager/edit-other-parties/*')? 'active' : ''}}">
				<a href="#">
					<i class="fa fa-users"></i> <span>Other Parties</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{Request::is('manager/manage-other-party-category') || Request::is('manager/create-other-party-category') || Request::is('manager/edit-other-party-category/*')? 'active' : ''}}">
					<a href="{{url('manager/manage-other-party-category')}}"><i class="fa fa-circle-o "></i>Categories</a></li>

					<li class="{{Request::is('manager/invite-other-party') || Request::is('manager/send-other-party-invitation')? 'active' : ''}}"><a href="{{url('manager/invite-other-party')}}"><i class="fa fa-circle-o"></i>Invited Other Party List</a></li>

					<li class="{{Request::is('manager/manage-other-parties') || Request::is('manager/crete-other-parties') || Request::is('manager/edit-other-parties/*') || Request::is('manager/other-party-registration-by-manager')? 'active' : ''}}">
					<a href="{{url('manager/manage-other-parties')}}"><i class="fa fa-circle-o"></i>Registered Other Party List</a></li>
				</ul>
			</li>

			<li class="{{ Request::is('manager/audit-management')? 'active' : ''}}">
				<a href="{{url('manager/audit-management')}}">
					<i class="fa fa-laptop"></i>
					<span>Audit Management</span>
					<span class="pull-right-container">
						<!-- <i class="fa fa-angle-left pull-right"></i> -->
					</span>
				</a>
			</li>
			<li class="{{ Request::is('manager/mail-box') || Request::is('manager/mail-box/*') || Request::is('manager/compose-message') || Request::is('manager/sent-items')|| Request::is('manager/trash')|| Request::is('manager/important-message') || Request::is('manager/manage-group') || Request::is('manager/add-group') || Request::is('manager/edit-group/*')? 'active' : ''}}">
				<a href="{{url('manager/mail-box')}}">
					<i class="fa fa-envelope"></i> <span>ICMAIL</span>
					<small class="label pull-right bg-green"><!-- {{$total_red_unread_messages_count}} --></small>
					<!-- <span class="pull-right-container">
						<small class="label pull-right bg-yellow">12</small>
						<small class="label pull-right bg-green">16</small>
						<small class="label pull-right bg-red">5</small>
					</span> -->
				</a>
			</li>

			<li class="{{ Request::is('manager/my-tickets') || Request::is('manager/create-ticket')? 'active' : ''}}">
				<a href="{{url('manager/my-tickets')}}">
					<i class="fa fa-ticket"></i> <span>My Tickets</span>
					<small class="label pull-right bg-green"><!-- {{$total_red_unread_messages_count}} --></small>
					<!-- <span class="pull-right-container">
						<small class="label pull-right bg-yellow">12</small>
						<small class="label pull-right bg-green">16</small>
						<small class="label pull-right bg-red">5</small>
					</span> -->
				</a>
			</li>

			<li class="{{ Request::is('manager/send-reset-credentials-link') ? 'active' : ''}}">
				<a href="{{url('manager/send-reset-credentials-link')}}">
					<i class="fa fa-user"></i> <span>Forgot Credential Requests</span>
					<small class="label pull-right bg-green"><!-- {{$total_red_unread_messages_count}} --></small>
					<!-- <span class="pull-right-container">
						<small class="label pull-right bg-yellow">12</small>
						<small class="label pull-right bg-green">16</small>
						<small class="label pull-right bg-red">5</small>
					</span> -->
				</a>
			</li>

			<li class="{{ Request::is('manager/settings') || Request::is('manager/profile') || Request::is('manager/edit-profile/*') || Request::is('manager/change-password') || Request::is('manager/subscriptions') || Request::is('manager/appointment-settings') || Request::is('manager/face-to-face-consultation-settings') || Request::is('manager/appointment-settings')|| Request::is('manager/edit-appointment-settings/*')? 'active' : ''}}">
				<a href="{{url('manager/settings')}}">
					<i class="fa fa-cog"></i> <span>Settings</span>
					<small class="label pull-right bg-green"></small>
				</a>
            </li>
			
			<!-- <li class="treeview {{ Request::is('manager/change-password') || Request::is('manager/profile')|| Request::is('manager/edit-profile/*') || Request::is('manager/subscriptions') ? 'active' : ''}}">
				<a href="#">
					<i class="fa fa-cog"></i> <span>Settings</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{Request::is('manager/profile') || Request::is('manager/edit-profile/*')? 'active' : ''}}"><a href="{{url('manager/profile')}}"><i class="fa fa-circle-o"></i>My Profile</a></li>
					<li class="{{Request::is('manager/change-password')? 'active' : ''}}"><a href="{{url('manager/change-password')}}"><i class="fa fa-circle-o "></i>Change Password</a></li>
					<li class="{{Request::is('manager/subscriptions')? 'active' : ''}}"><a href="{{url('manager/subscriptions')}}"><i class="fa fa-circle-o"></i>Subscription</a></li>
				</ul>
			</li> -->
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>