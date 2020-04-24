<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  Hi <strong>{{ $name }} {{ $surname }} </strong>, 
  <p>Welcome to intellComm</p> 
  <p>
  Your appointment was conformed with <b>{{$business_name}}</b> business.
  </p>

<h3 style="color:green;">Your appointment details are</h3>
 
 <p>Appointment Date:  {{$appointment_start_date_time}}</p>
 <p>Appointment with:  {{$practionar_name}} {{$practionar_surname}}[{{$practionar_email}}]</p>
 
</body>
</html>

