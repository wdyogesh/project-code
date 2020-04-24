<?php

namespace App\Http\Controllers\Frontend\Manager;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\Role;
use App\Models\UserAddresses;
use App\Models\OtherPartyInvitedUsers;
use App\Models\OtherPartyCategory;
use App\Models\RegisteredOtherParties;
use App\Models\ManagerAlternativeAccountFindingTable;
use App\Models\ManagerClients;
use App\Models\ManagerBusinessDetails;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use Mail;
use DB;

class OtherPartyController extends Controller {
	
    
  public function index(){
  	  //original manager's employee management condition start	
     $managers_registered_other_party_users= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
                   ->join('roles', 'role_id', '=', 'roles.id')
                   ->join('registered_other_parties','users.id','=','registered_other_parties.other_party_id')
                   ->where('role_id',5)
                   ->where('registered_other_parties.manager_id',Auth::user()->id)
                   ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date','roles.id as main_role_id','registered_other_parties.active as other_party_active')
                   ->get();
          //dd($managers_registered_other_party_users);
                   $data=[];
        foreach ($managers_registered_other_party_users as $key => $managers_registered_other_party_user) {     
               $other_party_invited_users = OtherPartyInvitedUsers::where('id',$managers_registered_other_party_user->invitation_table_record_id)->first();
                 $invitation_category_name=OtherPartyCategory::where('id',$other_party_invited_users['other_party_category_id'])->select('category_name')->first();
		         $data['main_user_id']=$managers_registered_other_party_user['main_user_id']; 
		         $data['registration_id']=$managers_registered_other_party_user['registration_id'];
		    	 $data['name']=$managers_registered_other_party_user->name;
		    	 $data['country_code']=$managers_registered_other_party_user->country_code;
		    	 $data['area_code']=$managers_registered_other_party_user->area_code;
		    	 $data['phone_number']=$managers_registered_other_party_user->phone_number;
		    	 $data['email']=$managers_registered_other_party_user->email;
		         $data['country']=$managers_registered_other_party_user->country;
		         $data['invitation_category_name']=$invitation_category_name['category_name'];
		         $data['main_user_table_created_record_date']=$managers_registered_other_party_user['main_user_table_created_record_date'];
		         $data['other_party_active']=$managers_registered_other_party_user->other_party_active;
		        $main_other_party_register_users[]=$data;
		                   
              }             
           //dd($main_other_party_register_users);
   return view('frontend/business-manager/otherparty-management/manage-otherparty',compact('main_other_party_register_users'));
  }	 
  public function details($subdomain,$hash_user_id){
  	 $user_id = Hashids::decode($hash_user_id)[0];
  	  //original manager's employee management condition start	
     $managers_registered_other_party_users= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
                   ->join('roles', 'role_id', '=', 'roles.id')
                   ->join('registered_other_parties','users.id','=','registered_other_parties.other_party_id')
                   ->where('role_id',5)
                   ->where('users.id',$user_id)
                   ->where('registered_other_parties.manager_id',Auth::user()->id)
                   ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date','roles.id as main_role_id')
                   ->get();
      //dd($managers_registered_other_party_users);
                   $data=[];
        foreach ($managers_registered_other_party_users as $key => $managers_registered_other_party_user) {     
               $other_party_invited_users = OtherPartyInvitedUsers::where('id',$managers_registered_other_party_user->invitation_table_record_id)->first();
                 $invitation_category_name=OtherPartyCategory::where('id',$other_party_invited_users['other_party_category_id'])->select('category_name')->first();
		         $data['main_user_id']=$managers_registered_other_party_user['main_user_id'];
		         $data['account_verification']=$invitation_category_name['category_name'];
		         $data['registration_id']=$managers_registered_other_party_user['registration_id'];
		    	 $data['name']=$managers_registered_other_party_user->name;
		    	 $data['country_code']=$managers_registered_other_party_user->country_code;
		    	 $data['area_code']=$managers_registered_other_party_user->area_code;
		    	 $data['phone_number']=$managers_registered_other_party_user->phone_number;
		    	 $data['email']=$managers_registered_other_party_user->email;
		         $data['country']=$managers_registered_other_party_user->country;
		         $data['state']=$managers_registered_other_party_user->state;
		         $data['city']=$managers_registered_other_party_user->city;
		         $data['invitation_category_name']=$invitation_category_name['category_name'];
		         $data['main_user_table_created_record_date']=$managers_registered_other_party_user['main_user_table_created_record_date'];
		        $main_other_party_register_users[]=$data;
		                   
              }             
          //dd($main_other_party_register_users);
   return view('frontend/business-manager/otherparty-management/details-otherparty',compact('main_other_party_register_users'));
  }

  public function activeInactive($subdomain,$hash_other_party_user_id,$hash_manager_id){
  	 $other_party_user_id = Hashids::decode($hash_other_party_user_id)[0];
  	 $manager_id = Hashids::decode($hash_manager_id)[0];
  	 $otherparty_user=RegisteredOtherParties::where('other_party_id',$other_party_user_id)->where('manager_id',$manager_id)->first();
  	 if($otherparty_user['active'] == 1){
  	 	//return 'hai';
  	 	$otherparty_user->update([
                               'active' => 0,                      
	                        ]);
  	 }else{
  	    $otherparty_user->update([
                               'active' => 1                       
	                        ]);
  	 }

     /*$otherparty_user=User::where('id',$other_party_user_id)->first();
     if($otherparty_user['active'] == 1){
      //return 'hai';
      $otherparty_user->update([
                               'active' => 0,                      
                          ]);
     }else{
        $otherparty_user->update([
                               'active' => 1                     
                          ]);
     }*/


  	 return redirect()->back();
  }

  public function otherPartyRegistration(){
    $countries = DB::table("countries")->pluck("name","id");
    $other_party_category=OtherPartyCategory::where('manager_id',Auth::user()->id)->where('soft_delete',0)->get();
    return view('frontend/business-manager/otherparty-management/otherparty-registration',compact('countries','other_party_category'));
  }

  public function store(Request $request){
    //return $request->all();
      
       $rules = array(
      'category_name' => 'required',
      'name' => 'required|regex:/[a-zA-Z]+/',
      'email' => 'required|email',
      'country_code' => 'required',
      'area_code' => 'required|numeric',
      'phone_number' => 'required|numeric',
      'country' => 'required',
      'state' => 'required',
      'city' => 'required',
      'pincode' => 'required|numeric',
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
          $data = $request->all();
          $dt = Carbon::now();
          //when enter user first have to check mail is in business level employee,client,other parties list(business level every user unique)

      //business manager level
        $business_manager_record= User::where('id',Auth::user()->id)->first();
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
            //return 'hai';
          $other_party_record = User::create([
                             'registration_id' => strtoupper(substr($data['country'], 0, 2))."OP".date('dmHis'),
                             'name'=>$data['name'],
                              'email'=>$data['email'],
                              'country_code'=>$data['country_code'],
                              'area_code'=>$data['area_code'],
                              'phone_number'=>$data['phone_number'],
                              'role_id'=>5,
                              'active'=>1,
                              'created_record_date'=>$dt->toDayDateTimeString(),                         
                            ]);
      $othe_party_invitation_store = OtherPartyInvitedUsers::create([
                          'other_party_category_id'=>$data['category_name'],
                          'other_party_name'=>$data['name'],
                          'other_party_email'=>$data['email'],
                          'manager_id'=>Auth::user()->id,
                          'register_by_manager'=>Auth::user()->id,
                          'registration_completed'=>1,
                          'created_record_date'=>$dt->toDayDateTimeString(),                         
                          ]);    
          
      $registered_other_party = RegisteredOtherParties::create([
                                'other_party_id'=>$other_party_record->id,
                                'manager_id'=>Auth::user()->id,
                                'invitation_table_record_id'=>$othe_party_invitation_store->id,
                                ]);
      $registered_other_address=UserAddresses::create([
                                'user_id'=>$other_party_record->id,
                                'country'=>$data['country'],
                                'state'=>$data['state'],
                                'city'=>$data['city'],
                                'pincode'=>$data['pincode'],
                                ]);
      //mail sent to set security questions and password start
         
           /*you can provide to employee to which business he registered*/
      $other_party_register_under_manager_business_name=ManagerBusinessDetails::where('user_id',$business_manager_record['id'])->first();

      $data = array('id'=>Hashids::encode($other_party_record['id']),'name'=>$other_party_record['name'],'email'=>$other_party_record['email'],'business_name' =>$other_party_register_under_manager_business_name['businesss_name'], "body" => "Test mail");

      //mail sent to set security questions and password start
      $mail_sent=Mail::send('frontend.mail-templates.other-party-setup-password', $data, function($message) use ($data){
              $message->to($data['email'], 'Receiver')
                        ->subject('IntellCOMM request for set password');
                $message->from('muralidharan.bora@gmail.com','Sender');         
            });
      //mail sent to set security questions and password end
        //return $client_record;                                    
        $url = url('manager/manage-other-parties');
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

 }







