<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SecurityQuestions;
use App\Models\Employee;
use App\Models\ManagerBusinessDetails;
use App\Models\ManagerClients;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Mail;
use DB;
use Illuminate\Support\Str;

class ClientSetPasswordAndSecurityQuestion extends Controller {

   //when click on mail linkthen, Employee redirect to this function for set security questions
    public function setSecurityQuestions($subdomain,$hashid=null){
    	//return $subdomain;
       $client_id = Hashids::decode($hashid)[0];
       $clients_of_manager_id=ManagerClients::where('client_id',$client_id)->select('manager_id')->first();
       $business_name=ManagerBusinessDetails::where('user_id',$clients_of_manager_id['manager_id'])->select('businesss_name')->first();
       $string_lower_business_name=Str::lower($business_name['businesss_name']);
       if($string_lower_business_name != $subdomain){
       	  return redirect()->to('/');
       }
       $clients=User::where('id',$client_id)->first();
       $security_questions= SecurityQuestions::all();
       if(count($clients) == 1 && $clients['password'] == "" && $clients['security_question_id'] == "" && $clients['answer'] == ""){

         return view('frontend.client-set-security-question',compact('client_id','security_questions'));
       }else{
           return redirect()->to('/');
       }
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
            $user_record = User::whereId($data['client_id'])->first();
		    $user_record->update([
	                            'security_question_id' => $data['user_security_questions'],
	                            'answer' => $data['security_question_answer'],
		                        ]);                              			
			$url = url('client-set-password/'.Hashids::encode($data['client_id']));
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
         $client_id = Hashids::decode($hashid)[0];
         $client_of_manager_id=ManagerClients::where('client_id',$client_id)->select('manager_id')->first();
         $business_name=ManagerBusinessDetails::where('user_id',$client_of_manager_id['manager_id'])->select('businesss_name')->first();
         $string_lower_business_name=Str::lower($business_name['businesss_name']);
       if($string_lower_business_name != $subdomain){
       	  return redirect()->to('/');
       }
       $employee=User::where('id',$client_id)->first();
       if($employee['password'] == ""){
    	    return view('frontend.client-set-password',compact('client_id'));
       }else{
       	  return redirect()->to('/');
       }
    }
    public function postSetPassword(Request $request){
    	//return $request->all();
    	$messages = [
       
        "password.required" => "Password field is required.",
        "password.min" => "Password min 8 digits, one capital, small, number, special character",
        "password.regex" => "Password min 8 digits, one capital, small, number, special character",
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
            $user_record = User::whereId($data['client_id'])->first();
		    $user_record->update([
	                               'password' => bcrypt($data['password']),	
		                        ]);
		    if($user_record->role_id == 3){
		    	$url = url('/');
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

}







