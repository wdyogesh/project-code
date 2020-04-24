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

			<li class="{{ Request::is('client/dashboard')? 'active' : ''}}">
				<a href="{{url('client/dashboard')}}">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>

			<li class="{{ Request::is('client/my-appointments')? 'active' : ''}}">
				<a href="{{url('client/my-appointments')}}">
					<i class="fa fa-calendar"></i> <span>My Appointments</span>
				</a>
			</li>
			
			<!-- <li class="{{ Request::is('client/manage-notes') || Request::is('client/create-notes') || Request::is('client/edit-notes/*') || Request::is('client/note-details/*') ? 'active' : ''}}">
				<a href="{{url('client/manage-notes')}}">
					<i class="glyphicon glyphicon-file"></i> <span>Notes</span>
				</a>
			</li> -->

			
			<li class="{{ Request::is('client/mail-box') || Request::is('client/mail-box/*') || Request::is('client/compose-message') || Request::is('client/sent-items')|| Request::is('client/trash')|| Request::is('client/important-message') || Request::is('client/manage-group') || Request::is('client/add-group') || Request::is('client/edit-group/*')? 'active' : ''}}">
				<a href="{{url('client/mail-box')}}">
					<i class="fa fa-envelope"></i> <span>ICMAIL</span>
					<span class="pull-right-container">
						<!-- <small class="label pull-right bg-yellow">12</small>
						<small class="label pull-right bg-green">16</small>
						<small class="label pull-right bg-red">5</small> -->
					</span>
				</a>
			</li>
			
			<li class="treeview {{ Request::is('client/change-password') || Request::is('client/profile')|| Request::is('client/edit-profile/*') || Request::is('client/subscriptions') ? 'active' : ''}}">
				<a href="#">
					<i class="fa fa-cog"></i> <span>Settings</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{Request::is('client/profile') || Request::is('client/edit-profile/*')? 'active' : ''}}"><a href="{{url('client/profile')}}"><i class="fa fa-circle-o"></i>My Profile</a></li>
					<li class="{{Request::is('client/change-password')? 'active' : ''}}"><a href="{{url('client/change-password')}}"><i class="fa fa-circle-o "></i>Change Password</a></li>
				</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>