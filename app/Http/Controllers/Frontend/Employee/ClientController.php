<?php

namespace App\Http\Controllers\Frontend\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SecurityQuestions;
use App\Models\BusinessProfessionCategory;
use App\Models\BusinessProfessionTypes;
use App\Models\ManagerClients;
use App\Models\ManagerBusinessDetails;
use App\Models\RegisteredOtherParties;
use App\Models\Role;
use App\Models\Employee;
use App\Models\UserAddresses;
use App\Models\ManagerAlternativeAccountFindingTable;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use Mail;
use DB;
class ClientController extends Controller {

    /**
	   * Show the all clients under business manager level.
	*/ 
	public function index($subdomain){
    $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
	$all_software_manager_clients= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
                   ->join('manager_clients','users.id','=','manager_clients.client_id')
                   ->where('manager_clients.manager_id',$manager_id->manager_id)
                   ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date','manager_clients.id as client_table_id','manager_clients.created_record_date as client_table_created_date','manager_clients.updated_record_date as client_table_update_date')
                   ->get();
      //  dd($all_software_manager_clients);            
	return view('frontend/employee/client-management/manage-clients',compact('all_software_manager_clients'));
	}

    /**
   * Create clients under business manager level.
   * all roles under business manager level
   * @return Response Array $security_questions
   */ 
    public function create($subdomain){
		//return 'hai';
		$countries = DB::table("countries")->pluck("name","id");
	    $security_questions = SecurityQuestions::all();
		return view('frontend/employee/client-management/create-clients',compact('security_questions','countries'));
    }

     /**
	   * Store Roles of employees under business manager level.
	   *
	   * @param  Request  $request
	   * @return Response
    */
    public function store(Request $request){
		//return $request->all(); 
		$rules = array(
		'client_name' => 'required',
		'surname' => 'required',
		'client_email' => 'required|email',
		'country_code' => 'required',
		'phone_number' => 'required|numeric',
		'dateof_birth' => 'required',
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
           // return 'hai';
			$manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
			$data= $request->all();
			//when enter user first have to check mail is in business level employee,client,other parties list(business level every user unique)

			//business manager level
			$manager_record=User::where('id',$manager_id['manager_id'])->first();
			  if($manager_record['email'] == $data['client_email']){
			  	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
			  }
			 //business manager alter native level
			 $manager_alternative_mail_check= ManagerAlternativeAccountFindingTable::where('main_manager_id',$manager_id['manager_id'])->select('alternative_business_manager_account_user_id')->first();
			 $manager_alternative_mail= User::where('id',$manager_alternative_mail_check['alternative_business_manager_account_user_id'])->first();
			  if($manager_alternative_mail['email'] == $data['client_email']){
			  	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
			  }

			 //business employee level		
			$manager__level_employee_ids = Employee::where('manager_id',$manager_id['manager_id'])->pluck('employee_id')->all();
	        $managers_employee_mail_unique_check = User::whereIn('id',$manager__level_employee_ids)->where('email',$data['client_email'])->get();
	         if(count($managers_employee_mail_unique_check) != 0){
	        	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
	          }
			//business client level	
			$manager_level_client_ids = ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
	       $managers_client_mail_unique_check = User::whereIn('id',$manager_level_client_ids)->where('email',$data['client_email'])->get();
	        if(count($managers_client_mail_unique_check) != 0){
	        	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry Client already registerd with this email in you business");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry Client already registerd with this email in you business')->withInput();
                 }
	          }

             //business other party level
			$manager_level_otherparty_ids = RegisteredOtherParties::where('manager_id',$manager_id['manager_id'])->pluck('other_party_id')->all();
			$managers_otherparty_mail_unique_check = User::whereIn('id',$manager_level_otherparty_ids)->where('email',$data['client_email'])->get();
			 if(count($managers_otherparty_mail_unique_check) != 0){
	        	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
	          }   
	        //end	
	        //return 'hi';	          
            $dt = Carbon::now();
		    $client_record = User::create([
		    	                'registration_id' => strtoupper(substr($data['country'], 0, 2))."CL".date('dmHis'),
                            	'name'=>$data['client_name'],
                            	'surname'=>$data['surname'],
	                            'email'=>$data['client_email'],
	                            'country_code'=>$data['country_code'],
	                            'phone_number'=>$data['phone_number'],
	                            'dateof_birth'=>$data['dateof_birth'],
	                            'role_id'=>3,
	                            'active'=>1,
	                            'created_record_date'=>$dt->toDayDateTimeString(),
		                        ]);
		    $client_addess = UserAddresses::create([
                            	'user_id'=>$client_record->id,
                            	 'country'=>$data['country'],
	                            'state'=>$data['state'],
	                            'city'=>$data['city'],
                            	/*'address'=>$data['address'],*/
	                            ]);
		    $manager_clients = ManagerClients::create([
	                            'client_id'=>$client_record->id,
	                            'manager_id'=>$manager_id['manager_id'],
	                            'employee_id_created_by'=>Auth::user()->id,
	                            'created_record_date'=>$dt->toDayDateTimeString(),
		                        ]);
		    $client_register_under_manager_business_name=ManagerBusinessDetails::where('user_id',$manager_id['manager_id'])->first();
		    //mail sent to set security questions and password start
		     $data = array('id'=>Hashids::encode($client_record['id']),'name'=>$client_record['name'],'email'=>$client_record['email'],'business_name' =>$client_register_under_manager_business_name['businesss_name'] ,"body" => "Test mail");

            $mail_sent=Mail::send('frontend.mail-templates.client-password-setup', $data, function($message) use ($data){
			        	$message->to($data['email'], 'Receiver')
			                    ->subject('IntellCOMM request for set password');
			            $message->from('muralidharan.bora@gmail.com','Sender');         
			        });
            //mail sent to set security questions and password end

			//return $client_record;                               			
			$url = url('employee/clients');
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Client Created Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url)->with('success', 'Client Created Successfully');
	        }
			        
		}
    }

    /**
	   * Edit the client details.
	   *
	   * @param  int  $hashid
	   * @return Response
    */ 
    public function edit($subdomain,$hashid){

    	$manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
    	$client_id = Hashids::decode($hashid)[0];
    	$client_record= User::where('id',$client_id)->first();
    	/*$client_record= User::where('id',$client_id)->first();*/
    	$managers_client_record= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
                   ->join('manager_clients','users.id','=','manager_clients.client_id')
                   ->where('manager_clients.manager_id',$manager_id['manager_id'])
                   ->where('users.id',$client_id)
                   ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date','manager_clients.id as client_table_id')
                   ->first();
        //dd($managers_client_record);

         //all countries dispaly              
	     $countries = DB::table("countries")->pluck("name","id");
       //when edit all states of selected user countrry display(take care)
	    $user_country_id_fetch=DB::table("countries")->where('name',$managers_client_record['country'])->first();
	    if($user_country_id_fetch == ""){
         $selected_countery_all_states_foreah="";
	   }else{      
	     $selected_countery_all_states_foreah = DB::table("states")->where('country_id',$user_country_id_fetch->id)->pluck("name","id");
	   }
	   //when edit all citys of selected user states display(take care)
	   $user_state_id_fetch=DB::table("states")->where('name',$managers_client_record['state'])->first();
	   if($user_state_id_fetch == ""){
         $selected_state_all_cities_foreah="";
	   }else{             
	   $selected_state_all_cities_foreah = DB::table("cities")->where('state_id',$user_state_id_fetch->id)->pluck("name","id");
	   }         
   
    	return view('frontend/employee/client-management/edit-clients',compact('managers_client_record','countries','selected_countery_all_states_foreah','selected_state_all_cities_foreah','client_record'));
    }
    
     /**
	   * Update client information under business manager level.
	   *
	   * @param  Request  $request
	   * @return Response
    */
    public function update(Request $request){
    	//return $request->all();
    	$messages = [
		       "client_name.required" => "Client name must required.", 
		       "client_email.required" => "Client email must required.", 
		       "country_code.required" => "Country code must required.", 
		       "phone_number.required" => "Client name must required.", 
		       "dateof_birth.required" => "Date of birth must required.", 
		       ];
    	   
		$rules = array(
				'client_name' => 'required',
				'surname' => 'required',
				'client_email' => 'required|email',
				'country_code' => 'required',
				'phone_number' => 'required|numeric',
				'dateof_birth' => 'required',
				/*'address' => 'required',*/
				'country' => 'required',
				'state' => 'required',
				'city' => 'required',
			     );
		$validator = Validator::make($request->all(), $rules,$messages);
		if ($validator->fails()){
			if($request->ajax()){
			return response()->json($validator->getMessageBag(), 301);
			}else{
			return redirect()->back()->withErrors($validator);
			}
			$this->throwValidationException(
			$request, $validator
			);
		}else{         
		    $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();     
		    $data= $request->all();		           
            $dt = Carbon::now();
            $user_record = User::findOrFail($data['client_id']);
            $user_record->update([
                            	'name'=>$data['client_name'],
                            	'surname'=>$data['surname'],
	                            'email'=>$data['client_email'],
	                            'country_code'=>$data['country_code'],
	                            'phone_number'=>$data['phone_number'],
	                            'dateof_birth'=>$data['dateof_birth'],
	                            'role_id'=>3,
	                            'active'=>1,
	                            'created_record_date'=>$dt->toDayDateTimeString(),
		                        ]);
            $user_address_record = UserAddresses::whereUserId($data['client_id'])->first();
		    $user_address_record->update([
                            	'user_id'=>$user_record->id,
                            	 'country'=>$data['country'],
	                            'state'=>$data['state'],
	                            'city'=>$data['city'],
	                            ]);
		    $user_client_record = ManagerClients::whereClientId($data['client_id'])->first();
		    $user_client_record->update([
	                            'client_id'=>$user_record->id,
	                            'manager_id'=>$manager_id['manager_id'],
	                            'employee_id_created_by'=>Auth::user()->id,
	                            'updated_record_date'=>$dt->toDayDateTimeString(),
		                        ]);	         
	        //return $client_record;     			
			$url = url('employee/client-details/'.Hashids::encode($user_record['id']));
	        if($request->ajax()){
	            return response()->json(array(
	              'success' => 'Client Updated Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
		    }else{
		        return redirect()->intended($url)->with('success', 'Client Updated Successfully');
		    }
				      
		}

    }

    /**
	   * Delete clients under business manager level.
	   *
	   *  @param  int  $id
	   * @return Response $role
    */
    public function delete($subdomain,$id){
        $address=UserAddresses::where('user_id',$id)->first();
	    $address->delete();
	    $client=ManagerClients::where('client_id',$id)->first();
	    $client->delete();
	    $user = User::find($id);
	    $user->delete(); 

	    /*$user = User::find($id);
        $user->client()->delete();
        $user->delete();	*/
	    return response()->json($user);
    }

    public function details($subdomain,$hashid){
    	$client_id = Hashids::decode($hashid)[0];
        $client_record= User::where('id',$client_id)->first();
        $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
        $managers_client_record= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
                   ->join('manager_clients','users.id','=','manager_clients.client_id')
                   ->where('manager_clients.manager_id',$manager_id['manager_id'])
                   ->where('users.id',$client_id)
                   ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date','manager_clients.id as client_table_id')
                   ->first();
        //dd($managers_client_record);  
    	return view('frontend/employee/client-management/details',compact('client_record','managers_client_record'));
    }
			                  
}







