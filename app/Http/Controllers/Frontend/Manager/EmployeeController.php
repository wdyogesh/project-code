<?php

namespace App\Http\Controllers\Frontend\Manager;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SecurityQuestions;
use App\Models\BusinessProfessionCategory;
use App\Models\BusinessManagersEmployeeRole;
use App\Models\BusinessProfessionTypes;
use App\Models\ManagerBusinessDetails;
use App\Models\RegisteredOtherParties;
use App\Models\ManagerAlternativeAccountFindingTable;
use App\Models\Role;
use App\Models\Employee;
use App\Models\UserAddresses;
use App\Models\ManagerClients;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use Mail;
use DB;

class EmployeeController extends Controller {
//where 'role_id' is user table column
    public function index(){
     	//original manager's employee management condition start	
     	   $managers_employees= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
                   ->join('roles', 'role_id', '=', 'roles.id')
                   ->join('employees','users.id','=','employees.employee_id')
                   ->join('businessmanagers_employee_roles','employees.businessmanagers_employee_roles_id','=','businessmanagers_employee_roles.id')
                   ->where('role_id',4)
                   ->where('employees.manager_id',Auth::user()->id)
                   ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date','roles.id as main_role_id','businessmanagers_employee_roles.id as business_manager_level_employee_role_id')
                   ->get();
          /// dd($managers_employees);        
	 return view('frontend.business-manager.employee-management.manage-employees',compact('managers_employees'));
    }

    public function create(){    	
	  $countries = DB::table("countries")->pluck("name","id");
	  $business_managers_employee_roles=BusinessManagersEmployeeRole::all();	  
	  return view('frontend.business-manager.employee-management.create-employees',compact('business_managers_employee_roles','countries'));
    }

    public function store(Request $request){ 
      /* return $request->all();*/
      $rules = array(
      	'employee_email' => 'required|email',
		'role_name' => 'required',
		'employee_name' => 'required|regex:/[a-zA-Z]+/',
		'dateof_birth' => 'required',
		'surname' => 'required|regex:/[a-zA-Z]+/',
		'employee_email' => 'required|email',
		'country_code' => 'required',
		'area_code' => 'required|numeric',
		'phone_number' => 'required|numeric',
		'pincode' => 'alpha_num',
		'country' => 'required',
		'state' => 'required',
		'city' => 'required',
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
			$data= $request->all();
			//when enter user first have to check mail is in business level employee,client,other parties list(business level every user unique)

			//business manager level
			  $manager_mail= Auth::user()->email;
			  if($manager_mail == $data['employee_email']){
			  	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
			  }

			  //business manager alter native level
			 $manager_alternative_mail_check= ManagerAlternativeAccountFindingTable::where('main_manager_id',Auth::user()->id)->select('alternative_business_manager_account_user_id')->first();
			 $manager_alternative_mail= User::where('id',$manager_alternative_mail_check['alternative_business_manager_account_user_id'])->first();
			  if($manager_alternative_mail['email'] == $data['employee_email']){
			  	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
			  }
			//business client level
			$manager_level_client_ids = ManagerClients::where('manager_id',Auth::user()->id)->pluck('client_id')->all();
			$managers_clients_mail_unique_check = User::whereIn('id',$manager_level_client_ids)->where('email',$data['employee_email'])->get();
			 if(count($managers_clients_mail_unique_check) != 0){
	        	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
	          }
			//business employee level		
			$manager__level_employee_ids = Employee::where('manager_id',Auth::user()->id)->pluck('employee_id')->all();
	        $managers_employee_mail_unique_check = User::whereIn('id',$manager__level_employee_ids)->where('email',$data['employee_email'])->get();
	         if(count($managers_employee_mail_unique_check) != 0){
	        	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
	          }

			 //business other party level
			$manager_level_otherparty_ids = RegisteredOtherParties::where('manager_id',Auth::user()->id)->pluck('other_party_id')->all();
			$managers_otherparty_mail_unique_check = User::whereIn('id',$manager_level_otherparty_ids)->where('email',$data['employee_email'])->get();
			 if(count($managers_otherparty_mail_unique_check) != 0){
	        	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
	          }
	        //end	           
             $dt = Carbon::now();     
            	//role mnager level admin role check in employee table      
	        	if($data['role_name'] == 5){
	        		$emapolee_level_admin_count=Employee::where('manager_id',Auth::user()->id)->where('businessmanagers_employee_roles_id',5)->count();
	        		if($emapolee_level_admin_count == 1){
                        if ($request->ajax()) {
	                       $validator->errors()->add("login_error", "Sorry Manager Level only one admin role can possible");
			                return response()->json($validator->getMessageBag(), 301);
		                 }else{
		                 	return redirect()->back()->with('fail', 'Sorry Manager Level only one admin role can possible')->withInput();
		                 }
	        		}	
	        	}

	            $employee_record = User::create([
	            	            'registration_id' => strtoupper(substr($data['country'], 0, 2))."EM".date('dmHis'),
	                        	'name'=>$data['employee_name'],
	                        	'surname'=>$data['surname'],
	                            'email'=>$data['employee_email'],
	                            'dateof_birth'=>$data['dateof_birth'],
	                            'country_code'=>$data['country_code'],
	                            'area_code'=>$data['area_code'],
	                            'phone_number'=>$data['phone_number'],
	                            'role_id'=>4,
	                            'active'=>1,
	                            'created_record_date'=>$dt->toDayDateTimeString(),                         
		                        ]);
			    $employee_addess = UserAddresses::create([
	                            	'user_id'=>$employee_record->id,
		                            'country'=>$data['country'],
		                            'state'=>$data['state'],
		                            'city'=>$data['city'],
		                            'pincode'=>$data['pincode'],
		                            ]);

			    $manager_employees = Employee::create([
		                            'employee_id'=>$employee_record->id,
		                            'businessmanagers_employee_roles_id'=>$data['role_name'],
		                            'manager_id'=>Auth::user()->id,
		                            'created_record_date'=>$dt->toDayDateTimeString(),
			                        ]);
			    //mail sent to set security questions and password start
			   
			     /*you can provide to employee to which business he registered*/
			    $employee_register_under_manager_business_name=ManagerBusinessDetails::where('user_id',$manager_employees['manager_id'])->first();

			    $data = array('id'=>Hashids::encode($employee_record['id']),'name'=>$employee_record['name'],'email'=>$employee_record['email'],'business_name' =>$employee_register_under_manager_business_name['businesss_name'], "body" => "Test mail");

	            //mail sent to set security questions and password start
	            $mail_sent=Mail::send('frontend.mail-templates.password-setup-employee', $data, function($message) use ($data){
				        	$message->to($data['email'], 'Receiver')
				                    ->subject('IntellCOMM request for set password');
				            $message->from('muralidharan.bora@gmail.com','Sender');         
				        });
	            //mail sent to set security questions and password end

				//return $client_record;                               			
				$url = url('manager/employees');
				if ($request->ajax()){
		            return response()->json(array(
		              'success' => 'Employee Created Successfully',
		              'modal' => true,
		              'redirect_url' => $url,
		              'status' => 200,
		              ), 200);
		        }else{
		            return redirect()->intended($url)->with('success', 'Employee Created Successfully');
		        }    			       
		}
    }

    public function edit($subdomain,$hashid){
    	$employee_id = Hashids::decode($hashid)[0];
    	$business_managers_employee_roles=BusinessManagersEmployeeRole::all();
    	$employee_record= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
	                   ->join('roles', 'role_id', '=', 'roles.id')
	                   ->join('employees','users.id','=','employees.employee_id')
	                   ->join('businessmanagers_employee_roles','employees.businessmanagers_employee_roles_id','=','businessmanagers_employee_roles.id')
	                   ->where('users.id',$employee_id)
	                   ->where('role_id',4)
	                   ->where('employees.manager_id',Auth::user()->id)
	                   ->select('*','users.id as main_user_id','roles.id as main_role_id','businessmanagers_employee_roles.id as business_manager_level_employee_role_id')
	                   ->first();
	     //all countries dispaly              
	     $countries = DB::table("countries")->pluck("name","id");
       //when edit all states of selected user countrry display(take care)
	    $user_country_id_fetch=DB::table("countries")->where('name',$employee_record['country'])->first();       
	    if($user_country_id_fetch == ""){
         $selected_countery_all_states_foreah="";
	   }else{
	   	  $selected_countery_all_states_foreah = DB::table("states")->where('country_id',$user_country_id_fetch->id)->pluck("name","id");
	   }  
	   //when edit all citys of selected user states display(take care)
	   $user_state_id_fetch=DB::table("states")->where('name',$employee_record['state'])->first();
	    if($user_country_id_fetch == ""){
         $selected_state_all_cities_foreah="";
	    }else{
         $selected_state_all_cities_foreah = DB::table("cities")->where('state_id',$user_state_id_fetch->id)->pluck("name","id"); 
	    }               
    	return view('frontend.business-manager.employee-management.edit-employees',compact('employee_record','business_managers_employee_roles','countries','selected_countery_all_states_foreah','selected_state_all_cities_foreah'));
   }

    public function update(Request $request){
    	//return $request->all();
    	$rules = array(
		'role_name' => 'required',
		'employee_name' => 'required',
		'surname' => 'required',
		'employee_email' => 'required|email',
		'dateof_birth' => 'required',
		'country_code' => 'required',
		'area_code' => 'required|numeric',
		'phone_number' => 'required|numeric',
		'pincode' => 'alpha_num',
		'country' => 'required',
		'state' => 'required',
		'city' => 'required',
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
			$data= $request->all();
			if($data['admin_role_identify'] == "other"){
				if($data['role_name'] == 5){
	        		$emapolee_level_admin_count=Employee::where('manager_id',Auth::user()->id)->where('businessmanagers_employee_roles_id',5)->count();
	        		if($emapolee_level_admin_count == 1){
                        if ($request->ajax()) {
	                       $validator->errors()->add("login_error", "Sorry Manager Level only one admin role can possible");
			                return response()->json($validator->getMessageBag(), 301);
		                 }else{
		                 	return redirect()->back()->with('fail', 'Sorry Manager Level only one admin role can possible')->withInput();
		                 }
	        		}
	        		
	        	}		   
			}
			        
            $dt = Carbon::now();
            $user_record = User::findOrFail($data['employee_id']);
		    $user_record->update([
                            	'name'=>$data['employee_name'],
                            	'surname'=>$data['surname'],
                            	'dateof_birth'=>$data['dateof_birth'],
	                            'email'=>$data['employee_email'],
	                            'country_code'=>$data['country_code'],
	                            'area_code'=>$data['area_code'],
	                            'phone_number'=>$data['phone_number'],
	                            'role_id'=>4,
	                            'active'=>1,
	                            'updated_record_date'=>$dt->toDayDateTimeString(),                         
		                        ]);
		    $user_address_record = UserAddresses::whereUserId($data['employee_id'])->first();
		    $user_address_record->update([
	                            'country'=>$data['country'],
	                            'state'=>$data['state'],
	                            'city'=>$data['city'],
	                            'pincode'=>$data['pincode'],
	                            ]);
            $user_employee_record = Employee::whereEmployeeId($data['employee_id'])->first();
		    $user_employee_record->update([
	                            'businessmanagers_employee_roles_id'=>$data['role_name'],
	                            'manager_id'=>Auth::user()->id,
	                            'updated_record_date'=>$dt->toDayDateTimeString(),
		                        ]);

			//return $client_record;                               			
			$url = url('manager/employees');
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Employee Record Update Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url)->with('success', 'Employee Record Update Successfully');
	        }
			        
		}
    }

    public function delete($subdomain,$id){
    $address=UserAddresses::where('user_id',$id)->first();
    $address->delete();
    $employee=Employee::where('employee_id',$id)->first();
    $employee->delete();
    $user = User::find($id);
    $user->delete();      
   /* $user = User::find($id);
    $user->useraddresses()->delete();
    $user->employee()->delete();
    $user->delete();	*/
	    return response()->json($user);
    }

   public function details($subdomain,$id){
       //return $id;
        $managers_employee_details= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
	                   ->join('roles', 'role_id', '=', 'roles.id')
	                   ->join('employees','users.id','=','employees.employee_id')
	                   ->join('businessmanagers_employee_roles','employees.businessmanagers_employee_roles_id','=','businessmanagers_employee_roles.id')
	                   ->where('users.id',$id)
	                   ->where('role_id',4)
	                   ->where('employees.manager_id',Auth::user()->id)
	                   ->select('*','users.id as main_user_id','roles.id as main_role_id','businessmanagers_employee_roles.id as business_manager_level_employee_role_id')
	                   ->first();
        return $managers_employee_details;
   } 			                  
}







