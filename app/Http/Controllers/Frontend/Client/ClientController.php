<?php

namespace App\Http\Controllers\Frontend\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SecurityQuestions;
use App\Models\Appointments;
use App\Models\Employee;
use App\Models\BusinessProfessionCategory;
use App\Models\BusinessProfessionTypes;
use App\Models\ManagerAlternativeAccountFindingTable;
use App\Models\ManagerBusinessDetails;
use App\Models\ManagerClients;
use App\Models\Role;
use App\Models\UserAddresses;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Hashids;
use Mail;
use DB;
use Illuminate\Support\Str;

class ClientController extends Controller {

	//Admin Login Form displayed

	public function login($subdomain,Request $request){
         $data=$request->all();
        $kay_user_send_login_forgot="";
        $user_email="";
        foreach($data as $key => $value){
           $kay_user_send_login_forgot=$key;
           $client_id = Hashids::decode($key)[0];
           $user_email=User::where('id',$client_id)->select('email')->first();
        }
		return view('frontend/client/login',compact('user_email','kay_user_send_login_forgot'));
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
         $manager_level_clients_ids = ManagerClients::where('manager_id',$manager_id['user_id'])->pluck('client_id')->all();
        // return Input::get('email');
        $users=User::whereIn('id',$manager_level_clients_ids)->where('email',Input::get('email'))->select('email','id')->first();
         if(count($users) == 0){
                if ($request->ajax()) {
                $validator->errors()->add("login_error", "Soryy! you are entered wrong credentials");
                     return response()->json($validator->getMessageBag(), 301);
                 }else{
                    return redirect()->back()->with('fail', 'Soryy! you are entered wrong credentials')->withInput();
                 }
          }
	        if (Auth::attempt(['email' => Input::get('email'), 'password' =>Input::get('password'), 'id' => $users['id']])){   
                   //return 'main';
	                $verification_account=Auth::user()->account_verification; 
		            if(Auth::user()->account_verification == 0){
                         return response()->json(array(
		                'redirect_url' => url('client/client-verificatin-account'),
		                'status'       => 200,
		               ), 200); 
		            }    
	                   return response()->json(array(
		                'redirect_url' => url('client/dashboard'),
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
    		return view('frontend.client.verification_account');
    	}else{
    		return redirect()->to('client/dashboard');
    	}
    	
    }
    
    //mail link sent for verification mail
    public function verificationAccountLink($subdomain,$hashid){
    	$client_id = Hashids::decode($hashid)[0];
    	$client_record=User::where('id',$client_id)->first();
    	if($client_record['account_verification'] == 0){
    		$data = array('id'=>Hashids::encode($client_record['id']),'name'=>$client_record['name'],'email'=>$client_record['email'], "body" => "Test mail");
        $mail_sent=Mail::send('frontend.mail-templates.client-verification-link', $data, function($message) use ($data){
			        	$message->to($data['email'], 'Receiver')
			                    ->subject('IntellCOMM verification link');
			            $message->from('muralidharan.bora@gmail.com','Sender');         
			        });
       return redirect()->back()->with('success', 'Please check your registered mailbox for the verification email. Click and verify.')->withInput();
    }else{
    	return redirect()->to('client/dashboard');
    }
    	
         
    }

    public function verificationAccountComplete($subdomain,$id){
    	$manager_id = Hashids::decode($id)[0];
    	$manager_record=User::where('id',$manager_id)->first();
    	$manager_record->update([
	                    'account_verification' => 1,
	                    ]);
    	return redirect()->to('client/dashboard');
    }

	public function dashboard(Request $request){
		$manager_id = ManagerClients::where('client_id',Auth::user()->id)->select('manager_id')->first();                   
        if(Auth::user()->account_verification == 0){
         return redirect()->to('client/client-verificatin-account');
       }
		return view('frontend/client/dashboard');
	}

//Admin Logged Out
	public function logout(){

	    Auth::logout();
	    return redirect()->to('/')->with('message', 'Your are now logged out!');
	}


			                  

}







