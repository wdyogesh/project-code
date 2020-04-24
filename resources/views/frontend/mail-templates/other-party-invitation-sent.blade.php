<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  Hi <strong>{{ $name }} </strong>, 
  <p>Invitation From IntellComm</p> 
  <p>
   You can register as <b>{{$other_party_name}}</b> other party user with our {{ $business_name }} business.
  </p>
<p>Business Manager Email: <b>{{ $manager_email }}</b></p>
<p>Please click below link to register</p>
<a href="{{url('business-other-party-users-registration/'.$id.'/'. Hashids::encode($other_party_id) )}}">IntellCOMM Other Party User Registration</a>
</body>
</html>

