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

			<li class="{{ Request::is('other-party/dashboard')? 'active' : ''}}">
				<a href="{{url('other-party/dashboard')}}">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			
			<li class="{{ Request::is('other-party/mail-box') || Request::is('other-party/mail-box/*') || Request::is('other-party/compose-message') || Request::is('other-party/sent-items')|| Request::is('other-party/trash')|| Request::is('other-party/important-message') || Request::is('other-party/manage-group') || Request::is('other-party/add-group') || Request::is('other-party/edit-group/*')? 'active' : ''}}">
				<a href="{{url('other-party/mail-box')}}">
					<i class="fa fa-envelope"></i> <span>ICMAIL</span>
					<span class="pull-right-container">
						<!-- <small class="label pull-right bg-yellow">12</small>
						<small class="label pull-right bg-green">16</small>
						<small class="label pull-right bg-red">5</small> -->
					</span>
				</a>
			</li>
			
			<li class="treeview {{ Request::is('other-party/change-password') || Request::is('other-party/profile')|| Request::is('other-party/edit-profile/*') || Request::is('other-party/subscriptions') ? 'active' : ''}}">
				<a href="#">
					<i class="fa fa-cog"></i> <span>Settings</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{Request::is('other-party/profile') || Request::is('other-party/edit-profile/*')? 'active' : ''}}"><a href="{{url('other-party/profile')}}"><i class="fa fa-circle-o"></i>My Profile</a></li>
					<li class="{{Request::is('other-party/change-password')? 'active' : ''}}"><a href="{{url('other-party/change-password')}}"><i class="fa fa-circle-o "></i>Change Password</a></li>
				</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>