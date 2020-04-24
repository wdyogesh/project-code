<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SecurityQuestions;
use App\Models\BusinessProfessionCategory;
use App\Models\BusinessProfessionTypes;
use App\Models\ManagerClients;
use App\Models\ManagerBusinessDetails;
use App\Models\ManagerAlternativeAccountFindingTable;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Ticketings;
use App\Models\TicketMessages;
use App\Models\UserAddresses;
use App\Models\ForgotCredentialRequests;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use Mail;
use DB;
class ResetCredentialsSendLink extends Controller {
    
	public function index(){
	    $my_requests= ForgotCredentialRequests::where('request_by_internal_user_id',NULL)->orderBy('status', 'asc')->get();
		return view('admin/reset-credentials-link/all-requests',compact('my_requests'));
	}

    public function send($role,$hashrequestid){  
        $dt = Carbon::now(); 
		$requestid_id = Hashids::decode($hashrequestid)[0];
		$request_table_id=ForgotCredentialRequests::where('id',$requestid_id)->first();
		$user_manager_record= User::where('id',$request_table_id['business_manager_id'])->first();
		$user_record= User::where('id',$request_table_id['request_by_manager_user_id'])->first();
        $manager_business=ManagerBusinessDetails::where('user_id',$user_record['id'])->first();
	    $data = array('id'=>Hashids::encode($user_record['id']),'request_id'=>$request_table_id['request_id'],'name'=>$user_record['name'],'surname'=>$user_record['surname'],'email'=>$user_record['email'],'manager_email'=>$user_manager_record['email'],'business_name' =>$manager_business['businesss_name'], "body" => "Test mail");
	    $mail_sent=Mail::send('frontend.mail-templates.send-link-by-admin-to-reset-password-security-questions', $data, function($message) use ($data){
				        	$message->to($data['email'], 'Receiver')
				                    ->subject($data['business_name'].'request for re-set security question and password');
				            $message->from(Auth::user()->email,'Sender');         
				        });
	   $table=ForgotCredentialRequests::where('id',$requestid_id)->first();
	   $table->update([
	                    'status'=>1,
	                    'updated_record_date'=>$dt->toDayDateTimeString(),
	                 ]);
	   return redirect()->back()->with('success', 'Reset link sent successfully');

	}  
  	                  
}







