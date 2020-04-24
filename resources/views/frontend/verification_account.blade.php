<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title')</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="{{asset('dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{asset('dashboard/bower_components/font-awesome/css/font-awesome.min.css')}}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="{{asset('dashboard/bower_components/Ionicons/css/ionicons.min.css')}}">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.print.css" media="print"/>
	<link rel="stylesheet" href="{{asset('dashboard/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('dashboard/dist/css/AdminLTE.min.css')}}">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="{{asset('dashboard/dist/css/skins/_all-skins.min.css')}}">
	<!-- Morris chart -->
	<link rel="stylesheet" href="{{asset('dashboard/bower_components/bower_components/morris.js/morris.css')}}">
	<!-- jvectormap -->
	<link rel="stylesheet" href="{{asset('dashboard/bower_components/jvectormap/jquery-jvectormap.css')}}">
	<!-- Date Picker -->
	<link rel="stylesheet" href="{{asset('dashboard/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
	<link rel="stylesheet" href="{{asset('dashboard/plugins/iCheck/all.css')}}">
	<link rel="stylesheet" href="{{asset('dashboard/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
	<link rel="stylesheet" href="{{asset('dashboard/plugins/timepicker/bootstrap-timepicker.min.css')}}">
	<link rel="stylesheet" href="{{asset('dashboard/bower_components/select2/dist/css/select2.min.css')}}">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{asset('dashboard/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="{{asset('dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">




	<!-- HTML5 Shim and Respond.js')}} IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js')}} doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js')}}"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js')}}"></script>
	<![endif]-->

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<style>
		.example-modal .modal {
			position: relative;
			top: auto;
			bottom: auto;
			right: auto;
			left: auto;
			display: block;
			z-index: 1;
		}

		.example-modal .modal {
			background: transparent !important;
		}
	</style>
	<style>
	
   </style> 
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

		@include('frontend.business-manager.layouts.header')
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				@if(Auth::user()->profile_pic == '')             
				<img src="{{asset('img1.jpg')}}" class="img-circle" alt="User Image">
				@else
				<img src="{{ asset('/uploads/profile_pics/'. Auth::user()->profile_pic) }}" class="img-circle" alt="User Image">
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

			<li class="">
				<a href="#">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			
			<li class="treeview">
				<a href="#">
					<i class="fa fa-users"></i> <span>Employee Management</span>
					
				</a>
				
			</li>

			<li class="">
				<a href="#">
					<i class="fa fa-user"></i> <span>Clients</span>
				</a>
			</li>

			<li class="">
				<a href="#">
					<i class="fa fa-calendar"></i> <span>Appointments</span>
				</a>
			</li>

			<li class="treeview ">
				<a href="#">
					<i class="fa fa-users"></i> <span>Other Parties</span>
					
				</a>
				
			</li>

			<li class="">
				<a href="#">
					<i class="fa fa-laptop"></i>
					<span>Audit Management</span>
					<span class="pull-right-container">
						<!-- <i class="fa fa-angle-left pull-right"></i> -->
					</span>
				</a>
			</li>
			<li class="">
				<a href="#">
					<i class="fa fa-envelope"></i> <span>Mailbox</span>
					<!-- <span class="pull-right-container">
						<small class="label pull-right bg-yellow">12</small>
						<small class="label pull-right bg-green">16</small>
						<small class="label pull-right bg-red">5</small>
					</span> -->
				</a>
			</li>
			
			<li class="treeview">
				   <a href="#">
					<i class="fa fa-cog"></i> <span>Settings</span>
					
				</a>
				
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>

	 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
 <!--    <section class="content-header">
      <h1>
        Modals
        <small>new</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">UI</a></li>
        <li class="active">Modals</li>
      </ol>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <div class="callout callout-info">
        <marquee><h4>Hello {{Auth::user()->name}}, Welcome to IntellCOMM!</h4></marquee>
       Your account verification not completed, 
        <a href="{{route('manager-verificatin-account-link',Hashids::encode(Auth::user()->id))}}">Click here to verify</a>
      </div>
       @if(Session::has('success'))
       <div  align="center" id="successMessage"  class="alert alert-info" style="background-color: #3c8dbc;padding: 5px;">{{ Session::get('success') }}
       </div>
       @endif
    </section>
    <!-- /.content -->
  </div>
		<!-- /.content-wrapper -->
		@include('frontend.business-manager.layouts.footer')

		<!-- Control Sidebar -->
		
		<!-- /.control-sidebar -->
	<!-- Add the sidebar's background. This div must be placed
	immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{asset('dashboard/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script>
  $(function () {
    //Add text editor
    $("#compose-textarea").wysihtml5();
  });
</script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('dashboard/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
@yield('example-script')
@yield('file-multiple-upload-script')
<script src="{{asset('dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('dashboard/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('dashboard/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{asset('dashboard/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('dashboard/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script src="{{asset('dashboard/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('dashboard/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- Morris.js')}} charts -->
<script src="{{asset('dashboard/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{asset('dashboard/bower_components/morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('dashboard/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{asset('dashboard/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('dashboard/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('dashboard/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('dashboard/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('dashboard/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('dashboard/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('dashboard/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{asset('dashboard/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('dashboard/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('dashboard/plugins/iCheck/icheck.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('dashboard/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dashboard/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dashboard/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->

<script src="{{asset('dashboard/dist/js/demo.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>


<script>
$(document).ready(function() {
    if(localStorage.getItem('popState') != 'shown'){
        $("#popup").delay(20).fadeIn();
        localStorage.setItem('popState','shown')
    }

});
</script>

</body>
</html>
