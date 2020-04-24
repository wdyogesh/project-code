<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SecurityQuestions;
use App\Models\Employee;
use App\Models\ManagerBusinessDetails;
use App\Models\ForgotCredentialRequests;
use App\Models\ManagerClients;
use App\Models\RegisteredOtherParties;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Mail;
use DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HomeController extends Controller {

	//Site home page will display
	public function index(){
	    return view('frontend.home');
    }
   //when click on mail linkthen, Employee redirect to this function for set security questions
    public function setSecurityQuestions($subdomain,$hashid=null){
    	//return $subdomain;
       $employee_id = Hashids::decode($hashid)[0];
       $employee_of_manager_id=Employee::where('employee_id',$employee_id)->select('manager_id')->first();
       $business_name=ManagerBusinessDetails::where('user_id',$employee_of_manager_id['manager_id'])->select('businesss_name')->first();
       $string_lower_business_name=Str::lower($business_name['businesss_name']);
       if($string_lower_business_name != $subdomain){
       	  return redirect()->to('http://intell-comm.com/');
       }
       $employee=User::where('id',$employee_id)->first();
       $security_questions= SecurityQuestions::all();
       if(count($employee) == 1 && $employee['password'] == "" && $employee['security_question_id'] == "" && $employee['answer'] == ""){
         return view('frontend.set-security-question',compact('employee_id','security_questions'));
       }else{
           return redirect()->to('http://intell-comm.com/');
       }
       $security_questions= SecurityQuestions::all();
       return view('frontend.set-security-question',compact('employee_id','security_questions'));
    } 
    public function insertSecurityQuestions(Request $request){
       $rules = array(
		'user_security_questions' => 'required',
		'security_question_answer' => 'required',
		);
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()){
			if($request->ajax()){
			return response()->json($validator->getMessageBag(), 301);
			} else {
			return redirect()->back()->withErrors($validator)
			->withInput();
			}
			$this->throwValidationException(
			$request, $validator
			);
		}else{
           // return 'hai';
			$data= $request->all();		           
            $user_record = User::whereId($data['employee_or_staff_id'])->first();
		    $user_record->update([
	                            'security_question_id' => $data['user_security_questions'],
	                            'answer' => $data['security_question_answer'],
		                        ]);                              			
			$url = url('set-password/'.Hashids::encode($data['employee_or_staff_id']));
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Client Created Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url);
	        }
			        
		}
    }

//after set security questions, Employee redirect to this function for set password
    public function setPassword($subdomain,$hashid){

         $employee_or_staff_id = Hashids::decode($hashid)[0];
         $employee_of_manager_id=Employee::where('employee_id',$employee_or_staff_id)->select('manager_id')->first();
         $business_name=ManagerBusinessDetails::where('user_id',$employee_of_manager_id['manager_id'])->select('businesss_name')->first();
         $string_lower_business_name=Str::lower($business_name['businesss_name']);
       if($string_lower_business_name != $subdomain){
       	  return redirect()->to('http://intell-comm.com/');
       }
         $employee=User::where('id',$employee_or_staff_id)->first();
        if($employee['password'] == ""){
    	    return view('frontend.set-password',compact('employee_or_staff_id'));
       }else{
       	  return redirect()->to('/');
       }
    }
    public function postSetPassword(Request $request){
    	//return $request->all();
    	$messages = [
       
        "password.required" => "Password field is required.",
        "password.min" => "Password minimum 8 digits, one capital, small, number, special character",
        //"password.regex" => "Password minimum 8 digits,one capittal,small, number,special character.",
	     ];
	   
    	$rules = array(
		'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/',
		'confirm_password' => 'required|same:password',
		);
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()){
			if($request->ajax()){
			return response()->json($validator->getMessageBag(), 301);
			} else {
			return redirect()->back()->withErrors($validator)
			->withInput();
			}
			$this->throwValidationException(
			$request, $validator
			);
		}else{
           // return 'hai';
			$data= $request->all();		           
            $user_record = User::whereId($data['employee_or_staff_id'])->first();
		    $user_record->update([
	                               'password' => bcrypt($data['password']),	
		                        ]);
		    if($user_record->role_id == 4){
		    	$url = url('/');
		    }elseif($user_record->role_id == 3){
		        $url = url('/');
		    }else{
		    	return 'sory.......';
		    }                                                  			
			
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Password SetSuccessfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url);
	        }
			        
		}
      
    }

    public function getPagenotFound(){
    	return view('errors.404');
    }

   //request send to business for reset security questions and answers start
    public function sendEmployeeRequestToManagerForResetLink($subdomain,$employeeid){
    	$dt = Carbon::now();   
    	$emplotte_table_record=Employee::where('employee_id',$employeeid)->first();
    	$user_record=User::where('id',$employeeid)->first();
    	$employee_record = ForgotCredentialRequests::create([
	            	            'request_id' => strtoupper("EM".date('dmHis')),
	                        	'business_manager_id'=>$emplotte_table_record['manager_id'],
	                        	'role_name'=>"Employee",
	                            'email'=>$user_record['email'],
	                            'request_by_internal_user_id'=>$user_record['id'],
	                            'status'=>0,
	                            'created_record_date'=>$dt->toDayDateTimeString(),                         
		                        ]);
       return redirect()->to('employee-login')->with('success', 'Your request has been sent to your business, you will be get reset link from your business through your registered mail after some time');
    }

    public function sendClientRequestToManagerForResetLink($subdomain,$clientid){
    	$dt = Carbon::now();   
    	$client_table_record=ManagerClients::where('client_id',$clientid)->first();
    	$user_record=User::where('id',$clientid)->first();
    	$employee_record = ForgotCredentialRequests::create([
	            	            'request_id' => strtoupper("CL".date('dmHis')),
	                        	'business_manager_id'=>$client_table_record['manager_id'],
	                        	'role_name'=>"Client",
	                            'email'=>$user_record['email'],
	                            'request_by_internal_user_id'=>$user_record['id'],
	                            'status'=>0,
	                            'created_record_date'=>$dt->toDayDateTimeString(),                         
		                        ]);
       return redirect()->to('client-login')->with('success', 'Your request has been sent to your business, you will be get reset link from your business through your registered mail after some time');
    }

    public function sendOtherPartyRequestToManagerForResetLink($subdomain,$otherpartyid){
    	$dt = Carbon::now();   
    	$other_party_table_record=RegisteredOtherParties::where('other_party_id',$otherpartyid)->first();
    	$user_record=User::where('id',$otherpartyid)->first();
    	$employee_record = ForgotCredentialRequests::create([
	            	            'request_id' => strtoupper("OT".date('dmHis')),
	                        	'business_manager_id'=>$other_party_table_record['manager_id'],
	                        	'role_name'=>"Other Party",
	                            'email'=>$user_record['email'],
	                            'request_by_internal_user_id'=>$user_record['id'],
	                            'status'=>0,
	                            'created_record_date'=>$dt->toDayDateTimeString(),                         
		                        ]);
       return redirect()->to('other-party-login')->with('success', 'Your request has been sent to your business, you will be get reset link from your business through your registered mail after some time');
    }

    public function sendManagerRequestToAdminForResetLink($subdomain,$managerid){
    	$dt = Carbon::now();
    	$user_record=User::where('id',$managerid)->first();
    	$employee_record = ForgotCredentialRequests::create([
	            	            'request_id' => strtoupper("BM".date('dmHis')),
	                        	'business_manager_id'=>$user_record['id'],
	                        	'role_name'=>"Business Manager",
	                            'email'=>$user_record['email'],
	                            'request_by_manager_user_id'=>$user_record['id'],
	                            'status'=>0,
	                            'created_record_date'=>$dt->toDayDateTimeString(),                         
		                        ]);
    	//return 'hai';
       return redirect()->to('manager-login?'.Hashids::encode($managerid))->with('success', 'Your request has been sent to your business provider, you will be get reset link from your business provider through your registered mail after some time');
    }

    //request send to business for reset security questions and answers end

    //response link send form business for reset security questions and answers start
     public function reSetSecurityquestion($subdomain,$hashuserid=NULL,$request_id){
          $record=ForgotCredentialRequests::where('request_id',$request_id)->select('user_reset_complete')->first();
          if($record['user_reset_complete'] != 1){
    	   $user_id = Hashids::decode($hashuserid)[0];
    	   $user_role_id=User::where('id',$user_id)->select('role_id')->first();
    	   if($user_role_id['role_id'] == 2){
    	   $manager_record = User::where('id',$user_id)->select('id as manager_id')->first();
    	   }elseif($user_role_id['role_id'] == 3){
    	   	$manager_record=ManagerClients::where('client_id',$user_id)->select('manager_id')->first();
    	   }elseif($user_role_id['role_id'] == 4){
            $manager_record=Employee::where('employee_id',$user_id)->select('manager_id')->first();
    	   }elseif($user_role_id['role_id'] == 5){
            $manager_record=RegisteredOtherParties::where('other_party_id',$user_id)->select('manager_id')->first();
    	   }       
	       $business_name=ManagerBusinessDetails::where('user_id',$manager_record['manager_id'])->select('businesss_name')->first();
	       $string_lower_business_name=Str::lower($business_name['businesss_name']);
	       if($string_lower_business_name != $subdomain){
	       	  return redirect()->to('/');
	       }
	       $user_record=User::where('id',$user_id)->first();
	       $security_questions= SecurityQuestions::all();  
	       return view('frontend.reset-security-questions',compact('user_record','security_questions','request_id'));
	   }else{
	   	 return redirect()->to('/');
	   }
    }

    public function updateResetSecurityquestion($subdomain,Request $request){
    	 $rules = array(
		'user_security_questions' => 'required',
		'security_question_answer' => 'required',
		);
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()){
			if($request->ajax()){
			return response()->json($validator->getMessageBag(), 301);
			} else {
			return redirect()->back()->withErrors($validator)
			->withInput();
			}
			$this->throwValidationException(
			$request, $validator
			);
		}else{
           // return 'hai';
			$data= $request->all();		           
            $user_record = User::whereId($data['user_id'])->first();
		    $user_record->update([
	                            'security_question_id' => $data['user_security_questions'],
	                            'answer' => $data['security_question_answer'],
		                        ]);                          			
			$url = url('user-re-set-password/'.Hashids::encode($data['user_id']).'/'.$data['request_id']);
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Client Created Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url);
	        }
			        
		}
    }

     public function reSetPassword($subdomain,$hashuserid,$request_id){
        $user_id = Hashids::decode($hashuserid)[0];
        $user_role_id=User::where('id',$user_id)->select('role_id')->first();
        if($user_role_id['role_id'] == 2){
    	   $manager_record = User::where('id',$user_id)->select('id as manager_id')->first();
        }elseif($user_role_id['role_id'] == 3){
	   	$manager_record=ManagerClients::where('client_id',$user_id)->select('manager_id')->first();
	    }elseif($user_role_id['role_id'] == 4){
        $manager_record=Employee::where('employee_id',$user_id)->select('manager_id')->first();
	    }elseif($user_role_id['role_id'] == 5){
        $manager_record=RegisteredOtherParties::where('other_party_id',$user_id)->select('manager_id')->first();
	    }   
	    $business_name=ManagerBusinessDetails::where('user_id',$manager_record['manager_id'])->select('businesss_name')->first();
         $string_lower_business_name=Str::lower($business_name['businesss_name']);
        if($string_lower_business_name != $subdomain){
       	  return redirect()->to('/');
        }
        $user_record=User::where('id',$user_id)->first();
        return view('frontend.user-re-set-password',compact('user_record','request_id'));  
    }

    public function updateReSetPassword(Request $request){
    	//return $request->all();
    	$messages = [
       
        "password.required" => "Password field is required.",
        "password.min" => "Password minimum 8 digits, one capittal, small, number, special character",
        //"password.regex" => "Password minimum 8 digits,one capittal,small, number,special character.",
	     ];
	   
    	$rules = array(
		'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/',
		'confirm_password' => 'required|same:password',
		);
		$validator = Validator::make($request->all(), $rules,$messages);
		if ($validator->fails()){
			if($request->ajax()){
			return response()->json($validator->getMessageBag(), 301);
			} else {
			return redirect()->back()->withErrors($validator)
			->withInput();
			}
			$this->throwValidationException(
			$request, $validator
			);
		}else{
           // return 'hai';
			$data= $request->all();		           
            $user_record = User::whereId($data['user_id'])->first();
		    $user_record->update([
	                               'password' => bcrypt($data['password']),	
		                        ]);
		   $table= ForgotCredentialRequests::where('request_id',$data['request_id'])->first();
		   $table->update([
	                               'user_reset_complete' =>1,	
		                  ]);
		    //return 'hai';
		    if($user_record->role_id == 2){
		    	$url = url('manager-login?'.Hashids::encode($user_record['id']));
		    }elseif($user_record->role_id == 3){
		    	$url = url('client-login');
		    }elseif($user_record->role_id == 4){
		    	$url = url('employee-login');
		    }elseif($user_record->role_id == 5){
		    	$url = url('other-party-login');
		    }                                                 			
			
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Password SetSuccessfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url);
	        }
			        
		}
      
    }
    //response link send form business for reset security questions and answers end
}







