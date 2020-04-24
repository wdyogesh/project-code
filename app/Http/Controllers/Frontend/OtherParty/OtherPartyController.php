<?php

namespace App\Http\Controllers\Frontend\OtherParty;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SecurityQuestions;
use App\Models\BusinessProfessionCategory;
use App\Models\BusinessProfessionTypes;
use App\Models\ManagerAlternativeAccountFindingTable;
use App\Models\ManagerBusinessDetails;
use App\Models\Appointments;
use App\Models\Role;
use App\Models\UserAddresses;
use App\Models\RegisteredOtherParties;
use App\Models\OtherPartyInvitedUsers;
use App\Models\OtherPartyCategory;
use App\Models\ManagerClients;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Hashids;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Mail;
use DB;

class OtherPartyController extends Controller {

	//Admin Login Form displayed
    public function create($subdomain,$hacsh_invitation_id,$category_id){
         $invitation_id = Hashids::decode($hacsh_invitation_id)[0];
         $invitation_otherparty_category_id = Hashids::decode($category_id)[0];
         $other_party_details = OtherPartyInvitedUsers::where('id',$invitation_id)->where('other_party_category_id',$invitation_otherparty_category_id)->first();
         if($other_party_details['registration_completed'] == 1){
         	return redirect()->to('/');
         }
        $invitation_category=OtherPartyCategory::where('id',$invitation_otherparty_category_id)->select('category_name')->first();
        $business_name=ManagerBusinessDetails::where('user_id',$other_party_details['manager_id'])->select('businesss_name')->first();
        $countries = DB::table("countries")->pluck("name","id");
	     $security_questions = SecurityQuestions::all();
		return view('frontend.other-party.other-party-registration',compact('countries','security_questions','invitation_category','business_name','other_party_details','invitation_id'));
    }
    public function save(Request $request){
    	//return $request->all();
    	 $messages = [
        "password.required" => "Password field is required.",
        "password.min" => "Password minimum 8 digits, atleast one capittal, small, number,special character",
        "password.regex" => "Password minimum 8 digits, one capittal, small, number, special character.",
	     ];
	   
    	 $rules = array(
    	'name' => 'required|regex:/[a-zA-Z]+/',
      	'email' => 'required|email',
      	'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/',
		'confirm_password' => 'required|same:password',
		'country_code' => 'required',
		'area_code' => 'required|numeric',
		'phone_number' => 'required|numeric',
		'country' => 'required',
		'state' => 'required',
		'city' => 'required',
		'pincode' => 'required|numeric',
		'user_security_questions' => 'required',
		'security_question_answer' => 'required',
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
          $data = $request->all();
          $dt = Carbon::now();
          //when enter user first have to check mail is in business level employee,client,other parties list(business level every user unique)

			//business manager level
			  $business_manager_record= User::where('id',$data['manager_id'])->first();
			  if($business_manager_record['email'] == $data['email']){
			  	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in this business with same email')->withInput();
                 }
			  }
			  //business manager alter native level
			 $manager_alternative_mail_check= ManagerAlternativeAccountFindingTable::where('main_manager_id',$business_manager_record['id'])->select('alternative_business_manager_account_user_id')->first();
			$manager_alternative_mail= User::where('id',$manager_alternative_mail_check['alternative_business_manager_account_user_id'])->first();
			  if($manager_alternative_mail['email'] == $data['email']){
			  	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in this business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in this business with same email')->withInput();
                 }
			  }

			//business client level
			$manager_level_client_ids = ManagerClients::where('manager_id',$business_manager_record['id'])->pluck('client_id')->all();
			$managers_clients_mail_unique_check = User::whereIn('id',$manager_level_client_ids)->where('email',$data['email'])->get();
			 if(count($managers_clients_mail_unique_check) != 0){
	        	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in this business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in this business with same email')->withInput();
                 }
	          }
			//business employee level		
			$manager__level_employee_ids = Employee::where('manager_id',$business_manager_record['id'])->pluck('employee_id')->all();
	        $managers_employee_mail_unique_check = User::whereIn('id',$manager__level_employee_ids)->where('email',$data['email'])->get();
	         if(count($managers_employee_mail_unique_check) != 0){
	        	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in this business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in this business with same email')->withInput();
                 }
	          }

           //business other party level
			$manager_level_otherparty_ids = RegisteredOtherParties::where('manager_id',$business_manager_record['id'])->pluck('other_party_id')->all();
			$managers_otherparty_mail_unique_check = User::whereIn('id',$manager_level_otherparty_ids)->where('email',$data['email'])->get();
			 if(count($managers_otherparty_mail_unique_check) != 0){
	        	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
	          }  
	        //end
	        $other_party_record = User::create([
	            	            'registration_id' => strtoupper(substr($data['country'], 0, 2))."OP".date('dmHis'),
	                        	'name'=>$data['name'],
	                            'email'=>$data['email'],
	                            'password' => bcrypt($data['password']),
	                            'country_code'=>$data['country_code'],
	                            'area_code'=>$data['area_code'],
	                            'phone_number'=>$data['phone_number'],
	                            'security_question_id' => $data['user_security_questions'],
	                            'answer' => $data['security_question_answer'],
	                            'role_id'=>5,
	                            'active'=>1,
	                            'created_record_date'=>$dt->toDayDateTimeString(),                         
		                        ]);
	        
			$registered_other_party = RegisteredOtherParties::create([
	                            	'other_party_id'=>$other_party_record->id,
		                            'manager_id'=>$data['manager_id'],
		                            'invitation_table_record_id'=>$data['invitation_id'],
		                            ]);
			 $registered_other_address=UserAddresses::create([
	                            	'user_id'=>$other_party_record->id,
		                            'country'=>$data['country'],
		                            'state'=>$data['state'],
		                            'city'=>$data['city'],
		                            'pincode'=>$data['pincode'],
		                            ]);
		                     
		    $invitation_record = OtherPartyInvitedUsers::where('id',$data['invitation_id'])->first();
			$invitation_record->update([
		                            'registration_completed'=>1,
		                            'updated_record_date'=>$dt->toDayDateTimeString(),
			                        ]);
			    //mail sent to set security questions and password start
			   
			     /*you can provide to employee to which business he registered*/
			$employee_register_under_manager_business_name=ManagerBusinessDetails::where('user_id',$business_manager_record['id'])->first();

			$data = array('id'=>Hashids::encode($other_party_record['id']),'name'=>$other_party_record['name'],'email'=>$other_party_record['email'],'business_name' =>$employee_register_under_manager_business_name['businesss_name'], "body" => "Test mail");

	        /*    //mail sent to set security questions and password start
	        $mail_sent=Mail::send('frontend.mail-templates.other-party-setup-password', $data, function($message) use ($data){
				        	$message->to($data['email'], 'Receiver')
				                    ->subject('IntellCOMM request for set password');
				            $message->from('muralidharan.bora@gmail.com','Sender');         
				        });
	            //mail sent to set security questions and password end*/

				//return $client_record;                               			
				$url = url('other-party-login');
				if ($request->ajax()){
		            return response()->json(array(
		              'success' => 'Other Party User Created Successfully',
		              'modal' => true,
		              'redirect_url' => $url,
		              'status' => 200,
		              ), 200);
		        }else{
		            return redirect()->intended($url)->with('success', 'Other Party User Created Successfully');
		        }            
		}
    }

    public function login($subdomain,Request $request){
    	$data=$request->all();
        $kay_user_send_login_forgot="";
        $user_email="";
        foreach($data as $key => $value){
           $kay_user_send_login_forgot=$key;
           $client_id = Hashids::decode($key)[0];
           $user_email=User::where('id',$client_id)->select('email')->first();
        }
		return view('frontend/other-party/login',compact('user_email','kay_user_send_login_forgot'));
	}

	public function postLogin($subdomain,Request $request){
		//return $request->all();
	 $rules = array(
	     'email' => 'required|email',                      
	     'password' => 'required', 
	  );
	  $validator = Validator::make($request->all(), $rules);
	    if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json($validator->getMessageBag(), 301);
            } else {
                return redirect()->back()->withErrors($validator)
                    ->withInput();
            }
            $this->throwValidationException(
                $request, $validator
            );
	    }else{
        $manager_id=ManagerBusinessDetails::where('businesss_name',$subdomain)->select('user_id')->first();
        $manager_level_other_party_ids = RegisteredOtherParties::where('manager_id',$manager_id['user_id'])->pluck('other_party_id')->all();
        $users=User::whereIn('id',$manager_level_other_party_ids)->where('email',Input::get('email'))->select('email','id')->first();
        if(count($users) == 0){
                if ($request->ajax()) {
                $validator->errors()->add("login_error", "Soryy! you are entered wrong credentials");
                     return response()->json($validator->getMessageBag(), 301);
                 }else{
                    return redirect()->back()->with('fail', 'Soryy! you are entered wrong credentials')->withInput();
                 }
          }
	        if(Auth::attempt(['email' => Input::get('email'), 'password' =>Input::get('password'), 'id' => $users['id']])){   
                   //return 'main';
	                $verification_account=Auth::user()->account_verification; 
		            if(Auth::user()->account_verification == 0){
                         return response()->json(array(
		                'redirect_url' => url('other-party/verificatin-account'),
		                'status'       => 200,
		               ), 200); 
		            }    
	                   return response()->json(array(
		                'redirect_url' => url('other-party/dashboard'),
		                'status'       => 200,
		            ), 200);  
	        }else{
             	if ($request->ajax()) {
                $validator->errors()->add("login_error", "Username or password doesn't match");
                return response()->json($validator->getMessageBag(), 301);
                 } 
	        }

	    }
   
    }

     public function verificationAccount($subdomain){
    	if(Auth::user()->account_verification == 0){
    		return view('frontend/other-party/verification_account');
    	}else{
    		return redirect()->to('other-party/dashboard');
    	}
    	
    }
    
    //mail link sent for verification mail
    public function verificationAccountLink($subdomain,$hashid){
    	$employee_id = Hashids::decode($hashid)[0];
    	$employee_record=User::where('id',$employee_id)->first();
    	if($employee_record['account_verification'] == 0){
    		$data = array('id'=>Hashids::encode($employee_record['id']),'name'=>$employee_record['name'],'email'=>$employee_record['email'], "body" => "Test mail");
        $mail_sent=Mail::send('frontend.mail-templates.otherparty-verification-link', $data, function($message) use ($data){
			        	$message->to($data['email'], 'Receiver')
			                    ->subject('IntellCOMM verification link');
			            $message->from('muralidharan.bora@gmail.com','Sender');         
			        });
       return redirect()->back()->with('success', 'Please check your registered mailbox for the verification email. Click and verify.')->withInput();
    }else{
    	return redirect()->to('other-party/dashboard');
    }
    	
         
    }

    public function verificationAccountComplete($subdomain,$id){
    	$manager_id = Hashids::decode($id)[0];
    	$manager_record=User::where('id',$manager_id)->first();
    	$manager_record->update([
	                    'account_verification' => 1,
	                    ]);
    	return redirect()->to('other-party/dashboard');
    }

	public function dashboard(Request $request){
             
        if(Auth::user()->account_verification == 0){
         return redirect()->to('other-party/verificatin-account');
       }
		return view('frontend/other-party/dashboard');
	}

//Admin Logged Out
	public function logout(){

	    Auth::logout();
	    return redirect()->to('/')->with('message', 'Your are now logged out!');
	}


		

   
}







