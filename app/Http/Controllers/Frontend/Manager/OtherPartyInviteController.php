<?php

namespace App\Http\Controllers\Frontend\Manager;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\OtherPartyCategory;
use App\Models\OtherPartyInvitedUsers;
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

class OtherPartyInviteController extends Controller {
	
    
  public function index(){         
    $other_party_invited_users = OtherPartyInvitedUsers::where('manager_id',Auth::user()->id)->where('register_by_manager',NULL)->get();
    $data=[];
    foreach ($other_party_invited_users as $key => $other_party_invited_user) {
       $category_name=OtherPartyCategory::where('id',$other_party_invited_user->other_party_category_id)->first();
       $data['category_name']=$category_name['category_name'];
    	 $data['other_party_name']=$other_party_invited_user->other_party_name;
    	 $data['other_party_email']=$other_party_invited_user->other_party_email;
    	 $data['created_record_date']=$other_party_invited_user->created_record_date;
    	 $data['updated_record_date']=$other_party_invited_user->updated_record_date;
       $data['otherparty_id']=$other_party_invited_user->id;
    	 $data['registration_completed']=$other_party_invited_user->registration_completed;
    	if($other_party_invited_user->employee_id == ""){
       $manager_record= User::where('id',$other_party_invited_user->manager_id)->first();
       $data['sent_by_name']=$manager_record['name'];
       $data['sent_by_surname']=$manager_record['surname'];
       $role_getting=Role::where('id',$manager_record['role_id'])->first();
       $data['sent_by_role']=$role_getting['role_name'];

      }else{
       $employee_record= User::where('id',$other_party_invited_user->employee_id)->first();
       $data['sent_by_name']=$employee_record['name'];
       $data['sent_by_surname']=$employee_record['surname'];
       $role_getting=Role::where('id',$employee_record['role_id'])->first();
       $data['sent_by_role']=$role_getting['role_name'];
      }
        $main_other_party_invitation_sent_users[]=$data;
    }
    
    return view('frontend/business-manager/otherparty-invited-users-management/manage-invited-other-party-users',compact('main_other_party_invitation_sent_users'));
  }	

  public function getSendInvitation(){
     $categories=OtherPartyCategory::where('manager_id',Auth::user()->id)->where('soft_delete',0)->get();
    return view('frontend/business-manager/otherparty-invited-users-management/create-invited-other-party-users',compact('categories'));
  }	

  public function postSendInvitation(Request $request){
      //return $request->all();
     $messages = [
         'other_party_user_name.required' => 'Other party user name field is required',
         'other_party_email.unique' => "Already you sent invitation to this mail sorry...",
	     ];
      $rules = array(
    'category_name' => 'required',
		'other_party_user_name' => 'required',
		'other_party_email' => 'required|email',
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
		  $data= $request->all();
			//getting business name start
			$business_user = User::with('businessdetails')->where('id',Auth::user()->id)->first();
			//getting business name end
      //when enter user first have to check mail is in business level employee,client,other parties list(business level every user unique)

      //invited other parties check in manager level
      $invitation_completed_manager_level=OtherPartyInvitedUsers::where('manager_id',Auth::user()->id)->where('other_party_email',$data['other_party_email'])->get();
      if(count($invitation_completed_manager_level) != 0){
          if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry already invitation sent to this mail");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry already invitation sent to this mail')->withInput();
                 }
        }

      //business manager level
        $manager_mail= Auth::user()->email;
        if($manager_mail == $data['other_party_email']){
          if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email you cant send invitation");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email you cant send invitation')->withInput();
                 }
        }
        //business manager alter native level
       $manager_alternative_mail_check= ManagerAlternativeAccountFindingTable::where('main_manager_id',Auth::user()->id)->select('alternative_business_manager_account_user_id')->first();
       $manager_alternative_mail= User::where('id',$manager_alternative_mail_check['alternative_business_manager_account_user_id'])->first();
        if($manager_alternative_mail['email'] == $data['other_party_email']){
          if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email you cant send invitation");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email you cant send invitation')->withInput();
                 }
        }
      //business client level
      $manager_level_client_ids = ManagerClients::where('manager_id',Auth::user()->id)->pluck('client_id')->all();
      $managers_clients_mail_unique_check = User::whereIn('id',$manager_level_client_ids)->where('email',$data['other_party_email'])->get();
       if(count($managers_clients_mail_unique_check) != 0){
            if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email you cant send invitation");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email you cant send invitation')->withInput();
                 }
            }
      //business employee level   
      $manager__level_employee_ids = Employee::where('manager_id',Auth::user()->id)->pluck('employee_id')->all();
          $managers_employee_mail_unique_check = User::whereIn('id',$manager__level_employee_ids)->where('email',$data['other_party_email'])->get();
           if(count($managers_employee_mail_unique_check) != 0){
            if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email you cant send invitation");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email you cant send invitation')->withInput();
                 }
            }

      //business other party level
      $manager_level_otherparty_ids = RegisteredOtherParties::where('manager_id',Auth::user()->id)->pluck('other_party_id')->all();
      $managers_otherparty_mail_unique_check = User::whereIn('id',$manager_level_otherparty_ids)->where('email',$data['other_party_email'])->get();
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

			$othe_party_invitation_store = OtherPartyInvitedUsers::create([
                          'other_party_category_id'=>$data['category_name'],
                        	'other_party_name'=>$data['other_party_user_name'],
                        	'other_party_email'=>$data['other_party_email'],
                        	'manager_id'=>Auth::user()->id,
                            'created_record_date'=>$dt->toDayDateTimeString(),                         
	                        ]);
     $categorie=OtherPartyCategory::where('id',$data['category_name'])->first();
		//Invitation sent through mail start
      $data2 = array('id'=>Hashids::encode($othe_party_invitation_store['id']),'name'=>$othe_party_invitation_store['other_party_name'],'email'=>$othe_party_invitation_store['other_party_email'],'business_name' =>$business_user['businessdetails']['businesss_name'],"other_party_name" => $categorie['category_name'],"other_party_id" => $categorie['id'], "body" => "Test mail", "manager_email" => Auth::user()->email);

      $mail_sent=Mail::send('frontend.mail-templates.other-party-invitation-sent', $data2, function($message) use ($data2){
			        	$message->to($data2['email'], 'Receiver')
			                    ->subject('Invitation Link From IntellCOMM');
			            $message->from('muralidharan.bora@gmail.com','Sender');         
			        });
        //Invitation sent through mail end
		                                 			
			$url = url('manager/invite-other-party');
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Invitation Sent Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url)->with('success', 'Invitation Sent Successfully');
	        }
                 
		}
  }

  public function deleteInvitation($subdomain,$id){
  	$other_party_invitation=OtherPartyInvitedUsers::where('id',$id)->first();
    $other_party_invitation->delete();
	return response()->json($other_party_invitation);
  }                 
}







