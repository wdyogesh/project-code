<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SecurityQuestions;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Mail;
use DB;

class ForgotPasswordController extends Controller {

	/*public function mailcheck(){
	    return view('frontend/business-manager/forgot-password');
    }

    public function postMailcheck(Request $request){   	 
    	$rules = array(
		'email' => 'required|email',
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
            //return 'hai';
			$data= $request->all();		           
            $user_record = User::where('email',$data['email'])->where('role_id', 2)->first();
            if(count($user_record) == 1){
             $url = url('manager/regitered-security-questions-choosing/'.Hashids::encode($user_record['id']));
			    if ($request->ajax()){
		            return response()->json(array(
		              'success' => ' Mail find succes fully',
		              'modal' => true,
		              'redirect_url' => $url,
		              'status' => 200,
		              ), 200);
		        }else{
		            return redirect()->intended($url);
		        }	
            }else{
            	if ($request->ajax()) {
                   $validator->errors()->add("login_error", "Sorry you are entering wrong mail");
                   return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry you are entering wrong mail')->withInput();
                 } 

            }
		   
	    }    
	    
    }*/

    public function enterSecurityQuestion($subdomain,$hashmanagerid){
    	 $manager_id = Hashids::decode($hashmanagerid)[0];
    	 $security_questions= SecurityQuestions::all();
    	 return view('frontend/business-manager/remember-security-questions',compact('manager_id','security_questions','subdomain'));
    } 

    public function checkSecurityQuestionAnswer($subdomain,Request $request){
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
            $manager_record = User::whereId($data['manager_id'])
                                    ->where('security_question_id',$data['user_security_questions'])
                                     ->where('answer',$data['security_question_answer'])
                                    ->first();                             		
            if(count($manager_record) == 1){
            	$url = url('manager/password-setup/'.Hashids::encode($data['manager_id']));
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
            }else{
            	if ($request->ajax()) {
                   $validator->errors()->add("login_error", "Sorry you are entering wrong security question or answer, please click <a href='".url('manager-send-forgot-credentials-request/'.$data['manager_id'])."'>here</a> to send request to your business provider for reset your credentials");
                   return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry you are entering wrong security question or answer, please contact service team')->withInput();
                 } 
            	
            }                        	        
		}
    }

    public function passwordSetup($subdomain,$hashmanagerid){
    	$manager_id = Hashids::decode($hashmanagerid)[0];
    	return view('frontend/business-manager/manager-set-password',compact('manager_id','subdomain'));
    }
    public function postSetupPassword($subdomain,Request $request){
    	$messages = [
       
        "password.required" => "Password field is required.",
        "password.min" => "Password minimum 8 digits,one capital,small, number,special character",
        "password.regex" => "Password minimum 8 digits,one capital,small, number,special character.",
	     ];
	   
    	$rules = array(
		'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/',
		'confirm_password' => 'required|same:password',
		);
		$validator = Validator::make($request->all(),$rules,$messages);
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
            $user_record = User::whereId($data['manager_id'])->first();
		    $user_record->update([
	                               'password' => bcrypt($data['password']),	
		                        ]);
		    if($user_record->role_id == 2){
		    	$url = route('manager-login',[$subdomain,Hashids::encode($data['manager_id'])]);
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
}







