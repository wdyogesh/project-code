<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  Hi <strong>{{ $name }} </strong>, 
  <p>welcome to intellComm</p> 
  <p>
  Your registration process is completed as a employee with {{ $business_name }} business.
  </p>
<!-- <p>{{ $body }}</p> -->
<p>Please click below link to set your password</p>
<a href="{{url('/set-security-question/'.$id)}}">Click me to set password</a>
</body>
</html>

