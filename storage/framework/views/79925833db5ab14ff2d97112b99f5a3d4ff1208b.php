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

			<li class="<?php echo e(Request::is('employee/dashboard')? 'active' : ''); ?>">
				<a href="<?php echo e(url('employee/dashboard')); ?>">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			
			
			<li class="<?php echo e(Request::is('employee/clients') || Request::is('employee/create-client') || Request::is('employee/edit-client/*') || Request::is('employee/client-details/*') || Request::is('employee/notes/*') || Request::is('employee/create-notes/*') || Request::is('employee/edit-client-notes/*') || Request::is('employee/details/*') || Request::is('employee/client-attachments/*') || Request::is('employee/client-appointments/*')? 'active' : ''); ?>">
				<a href="<?php echo e(url('employee/clients')); ?>">
					<i class="fa fa-user"></i> <span>Clients</span>
				</a>
			</li>

			<li class="<?php echo e(Request::is('employee/manage-notes-category') || Request::is('employee/create-notes-category') || Request::is('employee/edit-notes-category/*')? 'active' : ''); ?>">
				<a href="<?php echo e(url('employee/manage-notes-category')); ?>">
					<i class="glyphicon glyphicon-file"></i> <span>Notes Category</span>
				</a>
			</li>

			<!-- <li class="treeview <?php echo e(Request::is('employee/manage-notes-category') || Request::is('employee/create-notes-category') || Request::is('employee/edit-notes-category/*') || Request::is('employee/manage-client-notes') || Request::is('employee/create-client-notes') || Request::is('employee/edit-client-notes/*')? 'active' : ''); ?>">
				<a href="#">
					<i class="glyphicon glyphicon-file"></i> <span>Notes</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php echo e(Request::is('employee/manage-notes-category') || Request::is('employee/create-notes-category') || Request::is('employee/edit-notes-category/*')? 'active' : ''); ?>"><a href="<?php echo e(url('employee/manage-client-notes')); ?>">
					<a href="<?php echo e(url('employee/manage-notes-category')); ?>"><i class="fa fa-circle-o"></i>Notes Category</a></li>

					<li class="<?php echo e(Request::is('employee/manage-client-notes') || Request::is('employee/create-client-notes') || Request::is('employee/edit-client-notes/*')? 'active' : ''); ?>"><a href="<?php echo e(url('employee/manage-client-notes')); ?>"><i class="fa fa-circle-o"></i>Notes</a></li>
				</ul>
			</li> -->

			<li class="<?php echo e(Request::is('employee/appointments')? 'active' : ''); ?>">
				<a href="<?php echo e(url('employee/appointments')); ?>">
					<i class="fa fa-calendar"></i> <span>Appointments</span>
				</a>
			</li>

				<li class="treeview <?php echo e(Request::is('employee/invite-other-party')|| Request::is('employee/send-other-party-invitation') || Request::is('employee/manage-other-parties') || Request::is('employee/crete-other-parties') || Request::is('employee/edit-other-parties/*')? 'active' : ''); ?>">
				<a href="#">
					<i class="fa fa-users"></i> <span>Other Parties</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php echo e(Request::is('employee/invite-other-party') || Request::is('employee/send-other-party-invitation')? 'active' : ''); ?>"><a href="<?php echo e(url('employee/invite-other-party')); ?>"><i class="fa fa-circle-o"></i>Invited Other Party List</a></li>

					<li class="<?php echo e(Request::is('employee/manage-other-parties') || Request::is('employee/crete-other-parties') || Request::is('employee/edit-other-parties/*') || Request::is('employee/other-party-registration-by-manager')? 'active' : ''); ?>">
					<a href="<?php echo e(url('employee/manage-other-parties')); ?>"><i class="fa fa-circle-o"></i>Registered Other Party List</a></li>
				</ul>
			</li>

			
			<li class="<?php echo e(Request::is('employee/mail-box') || Request::is('employee/mail-box/*') || Request::is('employee/compose-message') || Request::is('employee/sent-items')|| Request::is('employee/trash')|| Request::is('employee/important-message') || Request::is('employee/manage-group') || Request::is('employee/add-group') || Request::is('employee/edit-group/*')? 'active' : ''); ?>">
				<a href="<?php echo e(url('employee/mail-box')); ?>">
					<i class="fa fa-envelope"></i> <span>ICMAIL</span>
					<span class="pull-right-container">
						<!-- <small class="label pull-right bg-yellow">12</small>
						<small class="label pull-right bg-green">16</small>
						<small class="label pull-right bg-red">5</small> -->
					</span>
				</a>
			</li>
			
			<li class="treeview <?php echo e(Request::is('employee/change-password') || Request::is('employee/profile')|| Request::is('employee/edit-profile/*') || Request::is('employee/subscriptions') ? 'active' : ''); ?>">
				<a href="#">
					<i class="fa fa-cog"></i> <span>Settings</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php echo e(Request::is('employee/profile') || Request::is('employee/edit-profile/*')? 'active' : ''); ?>"><a href="<?php echo e(url('employee/profile')); ?>"><i class="fa fa-circle-o"></i>My Profile</a></li>
					<li class="<?php echo e(Request::is('employee/change-password')? 'active' : ''); ?>"><a href="<?php echo e(url('employee/change-password')); ?>"><i class="fa fa-circle-o "></i>Change Password</a></li>
				</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>