<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  Hi <strong>{{ $name }} </strong>, 
  <p>welcome to intellComm</p> 
  <!-- <p>
  Your are successfully registered with our business as a client.
  </p> -->
<!-- <p>{{ $body }}</p> -->
<p>Please click below link to verify</p>
<a href="{{url('other-party/verification-account-completion',$id)}}">Click here</a>

</body>
</html>

