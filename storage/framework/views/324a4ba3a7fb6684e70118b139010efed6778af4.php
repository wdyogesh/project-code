 <aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	   <section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
			   <?php if(Auth::user()->profile_pic == ''): ?>             
				<img src="<?php echo e(asset('img1.jpg')); ?>" class="img-circle" alt="User Image" data-toggle="modal" data-target="#myModal">
				<?php else: ?>
				<img src="<?php echo e(asset('/uploads/profile_pics/'. Auth::user()->profile_pic)); ?>" class="img-circle" alt="User Image" data-toggle="modal" data-target="#myModal">
				<?php endif; ?>
			</div>
			<div class="pull-left info">
				<p><?php echo e(Auth::user()->name); ?> <?php echo e(Auth::user()->surname); ?></p>
				<!--  <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
			</div>
		</div>
		<!-- search form -->
		
		<!-- /.search form -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">My Tabs</li>

			<li class="<?php echo e(Request::is('client/dashboard')? 'active' : ''); ?>">
				<a href="<?php echo e(url('client/dashboard')); ?>">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>

			<li class="<?php echo e(Request::is('client/my-appointments')? 'active' : ''); ?>">
				<a href="<?php echo e(url('client/my-appointments')); ?>">
					<i class="fa fa-calendar"></i> <span>My Appointments</span>
				</a>
			</li>
			
			<!-- <li class="<?php echo e(Request::is('client/manage-notes') || Request::is('client/create-notes') || Request::is('client/edit-notes/*') || Request::is('client/note-details/*') ? 'active' : ''); ?>">
				<a href="<?php echo e(url('client/manage-notes')); ?>">
					<i class="glyphicon glyphicon-file"></i> <span>Notes</span>
				</a>
			</li> -->

			
			<li class="<?php echo e(Request::is('client/mail-box') || Request::is('client/mail-box/*') || Request::is('client/compose-message') || Request::is('client/sent-items')|| Request::is('client/trash')|| Request::is('client/important-message') || Request::is('client/manage-group') || Request::is('client/add-group') || Request::is('client/edit-group/*')? 'active' : ''); ?>">
				<a href="<?php echo e(url('client/mail-box')); ?>">
					<i class="fa fa-envelope"></i> <span>ICMAIL</span>
					<span class="pull-right-container">
						<!-- <small class="label pull-right bg-yellow">12</small>
						<small class="label pull-right bg-green">16</small>
						<small class="label pull-right bg-red">5</small> -->
					</span>
				</a>
			</li>
			
			<li class="treeview <?php echo e(Request::is('client/change-password') || Request::is('client/profile')|| Request::is('client/edit-profile/*') || Request::is('client/subscriptions') ? 'active' : ''); ?>">
				<a href="#">
					<i class="fa fa-cog"></i> <span>Settings</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php echo e(Request::is('client/profile') || Request::is('client/edit-profile/*')? 'active' : ''); ?>"><a href="<?php echo e(url('client/profile')); ?>"><i class="fa fa-circle-o"></i>My Profile</a></li>
					<li class="<?php echo e(Request::is('client/change-password')? 'active' : ''); ?>"><a href="<?php echo e(url('client/change-password')); ?>"><i class="fa fa-circle-o "></i>Change Password</a></li>
				</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>