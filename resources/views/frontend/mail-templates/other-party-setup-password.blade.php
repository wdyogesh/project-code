<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  Hi <strong>{{ $name }} </strong>, 
  <p>welcome to intellComm</p> 
  <p>
  You are successfully registered with our {{$business_name}} business as a Other Party.
  </p>
<!-- <p>{{ $body }}</p> -->
<p>Please click below link to set your password</p>
<a href="{{url('/other-party-set-security-question/'.$id)}}">Click here to set password</a>

</body>
</html>

