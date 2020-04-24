<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<title>Intell-Comm</title>
<link rel="stylesheet" type="text/css" href="{{asset('frontpages/html/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontpages/html/css/style.css')}}">

<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

</head>

<body>


<div class="main">
  <div class="wrapper">
    <div class="header">
      <div class="top_header">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <ul class="pull-right">
                @if(Auth::check() && Auth::user()->role_id == 4)
                <li><img src="{{asset('frontpages/html/images/user_icon.png')}}">
                 {{Auth::user()->name}} 
                     <a href="{{url('employee-logout')}}" style="text-decoration: none;color:green">(Logout)</a> /  
                     <a href="{{url('employee/dashboard')}}" style="text-decoration: none;color:green">(Dashboard)</a>
                </li>
                @else
                <li><img src="{{asset('frontpages/html/images/user_icon.png')}}"><a href="{{url('employee-login')}}" style="text-decoration: none;">Employee Login</a></li>
                @endif

                @if(Auth::check() && Auth::user()->role_id == 5)
                <li style="color:#ff7800"><img src="{{asset('frontpages/html/images/user_icon.png')}}">{{Auth::user()->name}} 
                     <a href="{{url('other-party-logout')}}" style="text-decoration: none;color:green">(Logout)</a> /  
                     <a href="{{url('other-party/dashboard')}}" style="text-decoration: none;color:green">(Dashboard)</a>
                </li>
                @else
                 <li><img src="{{asset('frontpages/html/images/user_icon.png')}}"><a href="{{url('other-party-login')}}" style="text-decoration: none;">Other Party Login</a></li>
                @endif
               
                @if(Auth::check() && Auth::user()->role_id == 3)
                <li><img src="{{asset('frontpages/html/images/registered_user.png')}}">
                {{Auth::user()->name}} 
                     <a href="{{url('client-logout')}}" style="text-decoration: none;color:green">(Logout)</a> /  
                     <a href="{{url('client/dashboard')}}" style="text-decoration: none;color:green">(Dashboard)</a>
                </li>
                @else
                <li><img src="{{asset('frontpages/html/images/registered_user.png')}}">
                <a href="{{url('client-login')}}" style="text-decoration: none;">Client Login
                </a>
                </li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="bottom_header">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
      
              
            <nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="http://intell-comm.com"><img src="{{asset('frontpages/html/images/logo.png')}}"></a> </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            
      <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="http://intell-comm.com">HOME</a></li>
                  <li><a href="#">ABOUT US</a></li>
                  <li><a href="#">FEATURES</a></li>
                  <li><a href="#">TEAM</a></li>
                  <li><a href="#">OUR SERVICES</a></li>
                  <li><a href="#">CONTACT</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="banner-inner-slider">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="heading_fadd">
              <h1>Innovative reliable solution for School profession</h1>
            </div>
            <div class="learn_more_btn">
              <button type="button" class="btn btn-success">LEARN MORE</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="intel_comm_section primary-school-section">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4  col-sm-offset-4">
            <div class="intel_comm_section_right">
              <h3>Welcome to</h3>
              <h2><span>PRIMARY</span>SCHOOL</h2>
              <p>We understand the with ever growing demands of work , exceeding  clients  expectations in this competitive world is a great challenge for all businesses. </p>
              <p>Effective communication helps to build and maintain relationship among team members, clients and other parties. It facilitates innovation and helps to build an effective team.It develops good team spirit among team members that improves staff and clients satisfaction. </p>
              <p>Effective communication tool can help any business to achieve above and ensures transparency. </p>
              <p>Empower your team and clients with Intell-COMM !</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="our_team_section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 "> <img src="{{asset('frontpages/html/images/affordable.png')}}" />
              <h2>Affordable</h2>
              <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint...</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 "> <img src="{{asset('frontpages/html/images/free_trial.png')}}">
              <h2>1 Month free trial</h2>
              <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint...</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 "> <img src="{{asset('frontpages/html/images/cancel_anytime.png')}}">
              <h2>Cancel Anytime</h2>
              <p>Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    
    <div class="registration_process_section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h2>Registration</h2>
            <span>Process</span>
            <div class="clearfix"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 registration_process_section_left">
              <div class="register_business">
                <div class="register_business_left"> <img src="{{asset('frontpages/html/images/business_man.png')}}"> </div>
                <div class="register_business_right">
                  <h3>REGISTRATION OF BUSSINESS</h3>
                  <P>Registration process required registered business and  manager’s details  to access the system. Registered business can allocate registered manager with their log in details. Registered manager can further grant access to other members of the team with their log in details. Once registered manager and other members of the staff will be able to communicate, record messages from clients as well as third parties.</P>
                </div>
              </div>
              <div class="register_business">
                <div class="register_business_left"> <img src="{{asset('frontpages/html/images/client_registration.png')}}"> </div>
                <div class="register_business_right">
                  <h3>REGISTRATION OF CLIENTS</h3>
                  <P>Clients can be registered with the business with their basic details.Once registered ,their details will be saved within system.All communications between clients and business will be saved via secured portal with audit trail.Clients will be offered their log in details. clients will be able to send and receive messages via secured portal to the registered business/manager when needed. </P>
                </div>
              </div>
              <div class="register_business">
                <div class="register_business_left"> <img src="{{asset('frontpages/html/images/third_party_registration.png')}}"> </div>
                <div class="register_business_right">
                  <h3>REGISTRATION OF THIRD PARTIES</h3>
                  <P>Other parties which are linked with the business can be registered with their registration details with the help of registered manager. other parties will be given log in details and can send or received messages to the registered business via a secured portal.</P>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="feature_section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3><span>OUR</span> FEATURES</h3>
            <p>Effective communication is a vital tool to foster any business.  It can help foster a good working relationship among team members  wich can in turn improve work efficiency and professional satisfaction.</p>
            <p>Reliable, secure communication tool can help to develop strong relationship between Business owner ,clients and third parties.</p>
            <p>IntellCOMM is a communication solution for your business. It supports team members for completing their tasks, communication with their team members , booking appointments with their clients , sending secure messaging to clients and third parties.
              It is a secure , efficient , reliable portal for all businesses.</p>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 padding_appointment">
              <div class="appointement_section">
                <div class="appointement_section_left"> <img src="{{asset('frontpages/html/images/appointement_system.png')}}"> </div>
                <div class="appointement_section_right">
                  <h2>Appointment system.</h2>
                  <span>System offers efficient and simple appointment system for your business clients. Appointments can be booked in advance or same day appointments. Manager can allocate staff to offer appointments to clients.(please see demo for further details).</span> </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="appointement_section">
                <div class="appointement_section_left"> <img src="{{asset('frontpages/html/images/notes_document.png')}}"> </div>
                <div class="appointement_section_right">
                  <h2>Notes and Documents.</h2>
                  <span>staff members will be able to record messages and notes for each client within secured portal for future reference. They will also be able to upload any documents needed related to respective clients. Same can be done for other parties.
                  All above information will be saved in a secured portal. </span> </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="appointement_section">
                <div class="appointement_section_left"> <img src="{{asset('frontpages/html/images/appointement_system.png')}}"> </div>
                <div class="appointement_section_right">
                  <h2>Messages</h2>
                  <span>Staff members can message to other members of the staff ,registered clients and other parties related with business. All messages will have their audit trail to ensure reliability and improve communication standards to meet business needs.</span> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="our_services_section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h2>OUR<span> SERVICES</span></h2>
            <p>We offer secured, reliable and efficient communication solutions to all businesses. For further details please see youtube.
              We also offer customised communication solutions. Please contact us for further details.</p>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 our_services_section_left"> <img src="{{asset('frontpages/html/images/services_intelCOMM.png')}}" style="width:100%;"> <span>effective communication tool for your business. </span> </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 our_services_section_right"> <img src="{{asset('frontpages/html/images/services_img_right.png')}}" style="width:100%;"> </div>
          </div>
        </div>
      </div>
    </div>
  @include('frontend.footer')
  </div>
</div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{asset('frontpages/html/js/bootstrap.min.js')}}"></script>
</body>
</html>
