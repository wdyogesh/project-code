<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<title>Intell-Comm-Reset Security Question</title>
<link rel="stylesheet" type="text/css" href="{{asset('frontpages/html/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('frontpages/html/css/style.css')}}">

<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
<style type="text/css">
  .help-block{
    text-align: left;
  }
</style>

</head>

<body>


<div class="login-form">

  <div class="row">
  
   <!--  <div  align="center" id="" class="alert alert-info" style="color:red">Please select security question and answer
    </div> -->
    
    
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  
    <h1>Re-Set Security Question</h1>
     @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
   @endif 
    <form class="bootstrap-modal-form" action="{{url('re-set-security-question')}}" method="post" files='true'>
{{ csrf_field() }}
    <div class="login-form-section" style="padding: 28px;">
     <div class="form-group" align="center" style="margin-left:37px;">
        <label  name="login_error"></label>
       </div>
    <div class="form-group">
      <select id="select_security_question" name="user_security_questions" class="form-control">
            <option value="" selected>Select Security Quetion </option>
            @foreach($security_questions as $security_question)
            <option value="{{$security_question->id}}">{{$security_question->security_question}}</option>
            @endforeach
     </select>
    </div>
    
    <div class="form-group" style='display:none;' id='security_question_answer'>
     <input type='text' class='text' placeholder="Write Answer" name='security_question_answer' maxlength="20" class="form-control"/>
    </div>
     <input type='hidden' name='user_id' value="{{$user_record['id']}}" class="form-control"/>
     <input type='hidden' name='request_id' value="{{$request_id}}" class="form-control"/>
    <div class="learn_more_btn">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
   </div>
    </form>
    </div>
  </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{asset('frontpages/html/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script src="{{asset('js/login-bootstrap-modal-form.js')}}"></script>
<script>
    $(document).ready(function(){
       


        $('#select_security_question').on('change', function() {
            if (this.value == '')
            {
                $("#security_question_answer").hide();
                
            }
            else
            {
                $("#security_question_answer").show();
            }
        });

       
    });
</script>
</body>
</html>
