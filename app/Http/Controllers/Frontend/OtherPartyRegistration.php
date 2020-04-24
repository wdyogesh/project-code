<?php

namespace App\Http\Controllers\Frontend\Manager;
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
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Hashids;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Mail;
use DB;

class ManagerController extends Controller {

	//Admin Login Form displayed

   public function create(){
		return view('frontend.business-manager.registration',compact('countries','security_questions','business_profession_types','business_categories'));
    }

    public function postBusinessManagerRegistration(Request $request){
	     //$data= $request->all();
	     $messages = [
		        "business_name.required" => "Business name is required.",
		        "business_category_type.required" => "Business type is required.",
		        "other_business.required" => "Please enter your business profession type.",
		        "name.required" => "Business manager name is required.",
	           ];
	   
		$rules = array(
		'business_name' => 'required|unique:manager_business_details,businesss_name',
		'business_category_type' => 'required',
		'name' => 'required|regex:/[a-zA-Z]+/',
		'email' => 'required|email|unique:users',
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
		if($request->get('business_category_type') == 'Other professions'){
			$rules = array_add($rules, 'other_business', 'required');
		}

		if($request->get('checkbox') == 1) {
	      $rules = array_add($rules, 'alternative_name', 'required');
	      $rules = array_add($rules, 'alternative_email', 'required|email|different:email|unique:users,email');
	      $rules = array_add($rules, 'alternative_password', 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/');		     
	      $rules = array_add($rules, 'alternative_country_code', 'required');
	      $rules = array_add($rules, 'alternative_area_code', 'required|numeric');
	      $rules = array_add($rules, 'alternative_phone_number', 'required|numeric');
	      $rules = array_add($rules, 'alternative_user_security_questions', 'required');
	      $rules = array_add($rules, 'alternative_security_question_answer', 'required');
	    }

		$validator = Validator::make($request->all(), $rules,$messages);
		if ($validator->fails()) {
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
	    $data= $request->all();
	    $dt = Carbon::now();
		$manager_record = User::create([
	                    'name' => $data['name'],
	                    'registration_id' => strtoupper(substr($data['country'], 0, 2))."BM".date('dmHis'),
	                    'country_code' => $data['country_code'],
	                    'area_code' => $data['area_code'],
	                    'phone_number' => $data['phone_number'],
	                    'email' => $data['email'],
	                    'password' => bcrypt($data['password']),
	                    'security_question_id' => $data['user_security_questions'],
	                    'answer' => $data['security_question_answer'],
	                    'role_id'=>2,
	                    'manager_account_alternativeaccount_identification_flag'=>1,
	                    'created_record_date'=>$dt->toDayDateTimeString(),
	                    ]);
		if($request->get('checkbox') == 1) {
			$alternative_manager_record = User::create([
	                    'name' => $data['alternative_name'],
	                    'registration_id' => strtoupper(substr($data['country'], 0, 2))."BM".date('dmHis'),
	                    'country_code' => $data['alternative_country_code'],
	                    'area_code' => $data['alternative_area_code'],
	                    'phone_number' => $data['alternative_phone_number'],
	                    'email' => $data['alternative_email'],
	                    'password' => bcrypt($data['alternative_password']),
	                    'security_question_id' => $data['alternative_user_security_questions'],
	                    'answer' => $data['alternative_security_question_answer'],
	                    'role_id'=>2,
	                    'created_record_date'=>$dt->toDayDateTimeString(),
	                    ]);
			ManagerAlternativeAccountFindingTable::create([
				        'main_manager_id' => $manager_record['id'],
	                    'alternative_business_manager_account_user_id' => $alternative_manager_record['id'],
				]);
		 }
		 $business_type = $data['business_category_type'];
		if($business_type != 'Other professions'){
		  $busines_type = $business_type;
			
		}else{
		  $busines_type = $data['other_business'];
		}
		$business_details = ManagerBusinessDetails::create([
	                    'user_id' => $manager_record->id,
	                    'businesss_name' => $data['business_name'],
	                    'business_type' => $busines_type,
		            ]);
		$user_address = UserAddresses::create([
	                    'user_id' => $manager_record->id,
	                    'country' => $data['country'],
	                    'state' => isset($data['state'])?$data['state']:'',
	                    'city' => $data['city'],
	                    'pincode' => $data['pincode'],
		            ]);
		  $url = url('manager-login');
	      if ($request->ajax()) {
	        return response()->json(array(
	          'success' => 'Your Account Created Success Successfully',
	          'modal' => true,
	          'redirect_url' => $url,
	          'status' => 200,
	          ), 200);
	      }else{
	        return redirect()->intended($url)->with('success', 'Your Account Created Success Successfully');
	      }
		}
	}

	public function login(){
		return view('frontend.business-manager.login');
	}

	public function postLogin(Request $request){
		/*return $request->all();*/
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
	  	    $userdata = array(
	        'email' => Input::get('email'),
	        'password' => Input::get('password')
	        );
	        if(Auth::validate($userdata)) {
	             if (Auth::attempt($userdata)) {
		            $verification_account=Auth::user()->account_verification; 
		            if(Auth::user()->account_verification == 0){
                         return response()->json(array(
		                'redirect_url' => route('manager-verificatin-account'),
		                'status'       => 200,
		               ), 200); 
		            }  
	                return response()->json(array(
		                'redirect_url' => route('manager-dashboard'),
		                'status'       => 200,
		            ), 200);  
	             }
	        }else{
             	if ($request->ajax()) {
                $validator->errors()->add("login_error", "Username or password doesn't match");
                return response()->json($validator->getMessageBag(), 301);
                 } 
	        }

	    }
   
    }

    public function verificationAccount(){
    	if(Auth::user()->account_verification == 0){
    		return view('frontend.business-manager.verification_account');
    	}else{
    		return redirect()->route('manager-dashboard');
    	}
    	
    }
    
    //mail link sent for verification mail
    public function verificationAccountLink($hashid){
    	$manager_id = Hashids::decode($hashid)[0];
    	$manager_record=User::where('id',$manager_id)->first();
    	if($manager_record['account_verification'] == 0){
    		$data = array('id'=>Hashids::encode($manager_record['id']),'name'=>$manager_record['name'],'email'=>$manager_record['email'], "body" => "Test mail");
        $mail_sent=Mail::send('frontend.mail-templates.manager-verification-link', $data, function($message) use ($data){
			        	$message->to($data['email'], 'Receiver')
			                    ->subject('IntellCOMM verification link');
			            $message->from('muralidharan.bora@gmail.com','Sender');         
			        });
       return redirect()->back()->with('success', 'You got verification link to your registered mail, please check and verify')->withInput();
    }else{
    	return redirect()->route('manager-dashboard');
    }
    	
         
    }

    public function verificationAccountComplete($id){
    	$manager_id = Hashids::decode($id)[0];
    	$manager_record=User::where('id',$manager_id)->first();
    	$manager_record->update([
	                    'account_verification' => 1,
	                    ]);
    	return redirect()->route('manager-dashboard');
    }

	public function dashboard(Request $request){
		$managers_employees_count= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
                   ->join('roles', 'role_id', '=', 'roles.id')
                   ->join('employees','users.id','=','employees.employee_id')
                   ->join('businessmanagers_employee_roles','employees.businessmanagers_employee_roles_id','=','businessmanagers_employee_roles.id')
                   ->where('role_id',4)
                   ->where('employees.manager_id',Auth::user()->id)
                   ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date','roles.id as main_role_id','businessmanagers_employee_roles.id as business_manager_level_employee_role_id')
                   ->count();
        $managers_clients_count= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
                   ->join('manager_clients','users.id','=','manager_clients.client_id')
                   ->where('manager_clients.manager_id',Auth::user()->id)
                   ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date','manager_clients.id as client_table_id')
                   ->count();
         $total_appointments_count = Appointments::join('users as info', 'info.id', '=', 'appointments.client_id')
                  			->where('appointments.manager_id', Auth::user()->id)
                        ->where('cancellation',NULL)
                  			->select('*','appointments.id as appointment_id')
                  			->count();                     
       if(Auth::user()->account_verification == 0){
         return redirect()->route('manager-verificatin-account');
       } 
		return view('frontend/business-manager/dashboard',compact('managers_employees_count','managers_clients_count','total_appointments_count'));
	}

//Admin Logged Out
	public function logout(){

	    Auth::logout();
	    return redirect()->to('manager-login')->with('message', 'Your are now logged out!');
	}


			                  

}







