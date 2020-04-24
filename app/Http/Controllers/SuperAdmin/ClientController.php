<?php

namespace App\Http\Controllers\SuperAdmin;
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
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use Mail;
use DB;

class ClientController extends Controller {
	
    
  public function index(){
  $alternative_acount_table_users=ManagerAlternativeAccountFindingTable::pluck('alternative_business_manager_account_user_id')->all();
	$all_business_clients= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
	                                      ->join('manager_business_details as business', 'business.user_id', '=', 'users.id')
	                                      ->whereNotIn('users.id',$alternative_acount_table_users)
	                                      ->where('role_id',2)
						                   ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date')
						                   ->get();
    //dd($all_business_clients);
    return view('admin/client-management/manage-clients',compact('all_business_clients'));
  }	

  public function createBusinessClient(){
  	$countries = DB::table("countries")->pluck("name","id");
  	    $security_questions = SecurityQuestions::all();
		$business_profession_types = BusinessProfessionTypes::all();
		$category = BusinessProfessionCategory::all();	
		$business_categories = BusinessProfessionCategory::with('professions')->get();
  	    return view('admin/client-management/create-business-clients',compact('all_business_clients','security_questions','business_profession_types','business_categories','countries'));
  }

  public function postCreateBusinessClient(Request $request){
  	    $rules = array(
		'business_name' => 'required|unique:manager_business_details,businesss_name',
		'business_category_type' => 'required',
		'first_name' => 'required',
		'surname' => 'required',
		'email' => 'required|email|unique:users',
		'country_code' => 'required',
		'area_code' => 'required|numeric',
		'phone_number' => 'required|numeric',
		'country' => 'required',
		'state' => 'required',
		'city' => 'required',
		'pincode' => 'required',
		);
		if($request->get('business_category_type') == 'Other professions'){
			$rules = array_add($rules, 'other_business', 'required');
		}
		$validator = Validator::make($request->all(), $rules);
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
	    /*dd($data);*/
	    $dt = Carbon::now();
		$manager_record = User::create([
			            'registration_id' => strtoupper(substr($data['country'], 0, 2))."BM".date('dmHis'),
	                    'name' => $data['first_name'],
	                    'surname' => $data['surname'],
	                    'country_code' => $data['country_code'],
	                    'area_code' => $data['area_code'],
	                    'phone_number' => $data['phone_number'],
	                    'email' => $data['email'],
	                     'role_id'=>2,
	                    'created_record_date'=>$dt->toDayDateTimeString(),
	                    ]);
		 $business_type = $data['business_category_type'];
		if($business_type != 'Other professions'){
		  $busines_type = $business_type;
		  $other_business_type = 0;
			
		}else{
		  $busines_type = $data['other_business'];
		  $other_business_type = 1;
		}
		$business_details = ManagerBusinessDetails::create([
	                    'user_id' => $manager_record->id,
	                    'businesss_name' => $data['business_name'],
	                    'business_type' => $busines_type,
	                    'other_business_type' => $other_business_type,
		            ]);
		$user_address = UserAddresses::create([
	                    'user_id' => $manager_record->id,
	                    'country' => $data['country'],
	                    'state' => isset($data['state'])?$data['state']:'',
	                    'city' => $data['city'],
	                    'pincode' => $data['pincode'],
		            ]);
		 //mail sent to set security questions and password start
		     $data = array('id'=>Hashids::encode($manager_record['id']),'name'=>$manager_record['name'],'email'=>$manager_record['email'], "body" => "Test mail");

              $mail_sent=Mail::send('frontend.mail-templates.password-setup-client', $data, function($message) use ($data){
			        	$message->to($data['email'], 'Receiver')
			                    ->subject('IntellCOMM request for set password');
			            $message->from('muralidharan.bora@gmail.com','Sender');         
			        });
            //mail sent to set security questions and password end
		  $url = url('admin/client-management');
	      if ($request->ajax()) {
	        return response()->json(array(
	          'success' => 'Business Client Account Created Success Successfully',
	          'modal' => true,
	          'redirect_url' => $url,
	          'status' => 200,
	          ), 200);
	      }else{
	        return redirect()->intended($url)->with('success', 'Business Client Account Created Success Successfully');
	      }
		}
  }

  public function businesssManagerDetails($id){
  	 //return $id;
  	$business_manager_details= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
	                                      ->join('manager_business_details as business', 'business.user_id', '=', 'users.id')
	                                      ->join('roles', 'role_id', '=', 'roles.id')
	                                      ->where('users.id',$id)
	                                      ->where('role_id',2)
						                  ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date')
						                   ->first();    
    return $business_manager_details;
  }

  public function editBusinesssManagerDetails($managerhashid){
  	 $manager_id = Hashids::decode($managerhashid)[0];
  	    $security_questions = SecurityQuestions::all();
		$business_profession_types = BusinessProfessionTypes::all();
		$category = BusinessProfessionCategory::all();	
		$business_categories = BusinessProfessionCategory::with('professions')->get();
	$business_manager_details= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
                ->join('manager_business_details as business', 'business.user_id', '=', 'users.id')
	                                      ->join('roles', 'role_id', '=', 'roles.id')
	                                      ->where('users.id', $manager_id)
	                                      ->where('role_id',2)
						                  ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date')
						                   ->first();
		//dd($business_manager_details);
		         //all countries dispaly              
	     $countries = DB::table("countries")->pluck("name","id");
       //when edit all states of selected user countrry display(take care)
	    $user_country_id_fetch=DB::table("countries")->where('name',$business_manager_details['country'])->first();
	    if($user_country_id_fetch == ""){
         $selected_countery_all_states_foreah="";
	   }else{
	   	  $selected_countery_all_states_foreah = DB::table("states")->where('country_id',$user_country_id_fetch->id)->pluck("name","id");
	   }       
	    
	   //when edit all citys of selected user states display(take care)
	   $user_state_id_fetch=DB::table("states")->where('name',$business_manager_details['state'])->first();
	   if($user_state_id_fetch == ""){
         $selected_state_all_cities_foreah="";
	   }else{
	   	  $selected_state_all_cities_foreah = DB::table("cities")->where('state_id',$user_state_id_fetch->id)->pluck("name","id");
	   }
	 				                    
  	    return view('admin/client-management/edit-business-client',compact('all_business_clients','security_questions','business_profession_types','business_categories','business_manager_details','countries','selected_countery_all_states_foreah','selected_state_all_cities_foreah'));

  }

  public function updateBusinesssManagerDetails(Request $request){
  	//dd($request->all());
  	$rules = array(
		'business_name' => 'required',
		'business_category_type' => 'required',
		'first_name' => 'required',
		'surname' => 'required',
		'email' => 'required|email',
		'country_code' => 'required',
		'area_code' => 'required|numeric',
		'phone_number' => 'required|numeric',
		'country' => 'required',
		'state' => 'required',
		'city' => 'required',
		'pincode' => 'required',
		);
		if($request->get('business_category_type') == 'Other professions'){
			$rules = array_add($rules, 'other_business', 'required');
		}
		$validator = Validator::make($request->all(), $rules);
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
	    /*dd($data);*/
	    $dt = Carbon::now();
	    $manager_record = User::findOrFail($data['manager_id']);
		$manager_record->update([
	                    'name' => $data['first_name'],
	                    'surname' => $data['surname'],
	                    'country_code' => $data['country_code'],
	                    'area_code' => $data['area_code'],
	                    'phone_number' => $data['phone_number'],
	                    'email' => $data['email'],
	                    'updated_record_date'=>$dt->toDayDateTimeString(),
	                    ]);
		$business_type = $data['business_category_type'];
		if($business_type != 'Other professions'){
		  $busines_type = $business_type;
		  $other_business_type =0;
			
		}else{
		  $busines_type = $data['other_business'];
		  $other_business_type = 1;
		}

		//return $busines_type;
		$business_details = ManagerBusinessDetails::whereUserId($data['manager_id'])->first();
		$business_details->update([
	                    'user_id' => $manager_record->id,
	                    'businesss_name' => $data['business_name'],
	                    'business_type' => $busines_type,
	                    'other_business_type' => $other_business_type,
		            ]);
		$user_address = UserAddresses::whereUserId($data['manager_id'])->first();
		$user_address->update([
	                    'user_id' => $manager_record->id,
	                    'country' => $data['country'],
	                    'state' => isset($data['state'])?$data['state']:'',
	                    'city' => $data['city'],
	                    'pincode' => $data['pincode'],
		            ]);
		  $url = url('admin/client-management');
	      if ($request->ajax()) {
	        return response()->json(array(
	          'success' => 'Business Client Account Updated Success Successfully',
	          'modal' => true,
	          'redirect_url' => $url,
	          'status' => 200,
	          ), 200);
	      }else{
	        return redirect()->intended($url)->with('success', 'Business Client Account Updated Success Successfully');
	      }
		}
  }

  public function activeBusinesssManagerAccount($managerid){
  	   
  	   return $user_fields=User::where('id',$managerid)->select('active','id')->first();
  }

   public function updateActivivation(Request $request){
  	   //return $request->all();
  	  $rules = array(
		'active' => 'required',
		);
		$validator = Validator::make($request->all(), $rules);
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
	    //return $data['active'];
	    $dt = Carbon::now();
	    $manager_record = User::findOrFail($data['manager_id']);
		$manager_record->update([
	                    'active' => $data['active'],
	                    'updated_record_date'=>$dt->toDayDateTimeString(),
	                    ]);
		//return $manager_record;
		$url = url('admin/client-management');
	      if ($request->ajax()) {
	        return response()->json(array(
	          'success' => 'Business Client Account Activated Successfully',
	          'modal' => true,
	          'redirect_url' => $url,
	          'status' => 200,
	          ), 200);
	      }else{
	        return redirect()->intended($url)->with('success', 'Business Client Account Activated Success Successfully');
	      }
		}
  }

  public function trialPeriodClients(){
	$alternative_acount_table_users=ManagerAlternativeAccountFindingTable::pluck('alternative_business_manager_account_user_id')->all();
    $all_business_clients= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
	                                      ->join('manager_business_details as business', 'business.user_id', '=', 'users.id')
	                                      ->whereNotIn('users.id',$alternative_acount_table_users)
	                                      ->where('role_id',2)
						                   ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date','users.created_at as main_user_created_at')
						                   ->get();
   /* dd($all_business_clients);*/
	$data=[];					                   
	foreach ($all_business_clients as $key => $business_manager_client) {
		$to = \Carbon\Carbon::now();
	    $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $business_manager_client->main_user_created_at);
	    if($from->diffInDays($to) <= 30){
	    	    $data['diff_in_days'] = $from->diffInDays($to);
			    $data['name'] = $business_manager_client->name;
			    $data['surname'] = $business_manager_client->surname;
			    $data['country_code'] = $business_manager_client->country_code;
			    $data['area_code'] = $business_manager_client->area_code;
			    $data['phone_number'] = $business_manager_client->phone_number;
			    $data['email'] = $business_manager_client->email;
			    $data['country'] = $business_manager_client->country;
			    $data['state'] = $business_manager_client->state;
			    $data['city'] = $business_manager_client->city;
			    $data['pincode'] = $business_manager_client->pincode;
			    $data['businesss_name'] = $business_manager_client->businesss_name;
			    $data['business_type'] = $business_manager_client->business_type;
			    $data['main_user_id'] = $business_manager_client->main_user_id;
			    $main[]=$data;

	    }
	}
	//return $main;

  	return view('admin/client-management/trialperiod-business-clients-list',compact('main'));


  }

}

