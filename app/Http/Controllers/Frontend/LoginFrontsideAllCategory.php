<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SecurityQuestions;
use App\Models\Employee;
use App\Models\ManagerBusinessDetails;
use App\Models\ManagerClients;
use App\Models\RegisteredOtherParties;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Mail;
use DB;
use Illuminate\Support\Str;

class LoginFrontsideAllCategory extends Controller {

	//Site home page will display
	public function index(){
	    return view('frontend.login-as-category');
    }
   //employeeee login form main site functions start
    public function chooseBusinessIfUserHasOneMore(){
    	$business_details=Session::get('business_details');
	    return view('frontend.same_user_different_business_select',compact('business_details'));
    }

    public function getEmployeeMailWithLogin(){
		return view('frontend.employee.employee-login-with-mail');
	}

	public function postEmployeeMailWithLogin(Request $request){
		$rules = array(
	     'email' => 'required|email',                      
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

			    $user = User::where('email',$request->get('email'))->where('role_id',4)->get();
			   if(count($user) != 0){
			   	    if(count($user) == 1){
			   	      $users = User::where('email',$request->get('email'))->where('role_id',4)->first();
			         $manager_id=Employee::where('employee_id',$users['id'])->select('manager_id')->first();
			          $manager_business = User::with('businessdetails')->where('id',$manager_id['manager_id'])->where('role_id',2)->first();
			   	     return response()->json(array(
				                'redirect_url' => route('employee-login',[$manager_business['businessdetails']['businesss_name'],Hashids::encode($users['id'])]),
				                'status'       => 200,
				               ), 200);  
			   	 }else{
			   	 	$user = User::where('email',$request->get('email'))->where('role_id',4)->pluck("id");
			   	    $employees=Employee::whereIn('employee_id',$user)->get();
			   	   $data=[];
			   	   foreach ($employees as $key => $employee) {
			   	     $data['employee_id']=User::where('id',$employee['employee_id'])->select('id')->first();
			   	     $data['business_name']=ManagerBusinessDetails::where('user_id',$employee['manager_id'])->select('businesss_name')->first();
			   	     $maindata[]=$data;
			   	   }
			   	 	Session::put('business_details',$maindata);
			   	 	return response()->json(array(
				                'redirect_url' => route('choose-business'),
				                'status'       => 200,
				               ), 200);
			   	 	//return redirect()->route('choose-business');
			   	 }
			   	         
			   }else{
			   	       if ($request->ajax()) {
		                $validator->errors()->add("login_error", "Your email not existed in our business");
		                return response()->json($validator->getMessageBag(), 301);
			           }
		}	   }  
	  
	}
 //employeeee login form main site functions end


//client login form main site functions start
    public function chooseBusinessIfClientHasOneMore(){
    	$business_details=Session::get('business_client_details');
	    return view('frontend.same_client_different_business_select',compact('business_details'));
    }

    public function getClientMailWithLogin(){
		return view('frontend.client.client-login-with-mail');
	}

	public function postClientMailWithLogin(Request $request){
		$rules = array(
	     'email' => 'required|email',                      
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

			  $user = User::where('email',$request->get('email'))->where('role_id',3)->get();
			     if(count($user) != 0){
			   	    if(count($user) == 1){
			   	      $users = User::where('email',$request->get('email'))->where('role_id',3)->first();
			         $manager_id=ManagerClients::where('client_id',$users['id'])->select('manager_id')->first();
			        $manager_business = User::with('businessdetails')->where('id',$manager_id['manager_id'])->where('role_id',2)->first();
			   	     return response()->json(array(
				                'redirect_url' => route('client-login',[$manager_business['businessdetails']['businesss_name'],Hashids::encode($users['id'])]),
				                'status'       => 200,
				               ), 200);  
			   	 }else{
			   	 	$user = User::where('email',$request->get('email'))->where('role_id',3)->pluck("id");
			   	    $clients=ManagerClients::whereIn('client_id',$user)->get();
			   	   $data=[];
			   	   foreach ($clients as $key => $client) {
			   	     $data['client_id']=User::where('id',$client['client_id'])->select('id')->first();
			   	     $data['business_name']=ManagerBusinessDetails::where('user_id',$client['manager_id'])->select('businesss_name')->first();
			   	     $maindata[]=$data;
			   	   }
			   	 	Session::put('business_client_details',$maindata);
			   	 	return response()->json(array(
				                'redirect_url' => route('choose-client-business'),
				                'status'       => 200,
				               ), 200);
			   	 	//return redirect()->route('choose-client-business');
			   	 }
			   	         
			   }else{
			   	       if ($request->ajax()) {
		                $validator->errors()->add("login_error", "Your email not existed in our business");
		                return response()->json($validator->getMessageBag(), 301);
			           }
		}	   }  
	  
	}
	//client login form main site functions end

	//other party login form main site functions end//client login form main site functions start
    public function chooseBusinessIfOtherPartyHasOneMore(){
    	$business_details=Session::get('business_other_party_details');
    	//dd($business_details);
	    return view('frontend.same_other_party_different_business_select',compact('business_details'));
    }

    public function getOtherPartyMailWithLogin(){
		return view('frontend.other-party.other-party-login-with-mail');
	}

	public function postOtherPartyMailWithLogin(Request $request){
		$rules = array(
	     'email' => 'required|email',                      
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

			  $user = User::where('email',$request->get('email'))->where('role_id',5)->get();
			   if(count($user) != 0){
			   	    if(count($user) == 1){
			   	     $users = User::where('email',$request->get('email'))->where('role_id',5)->first();
			       $manager_id=RegisteredOtherParties::where('other_party_id',$users['id'])->select('manager_id')->first();
			       $manager_business = User::with('businessdetails')->where('id',$manager_id['manager_id'])->where('role_id',2)->first();
			   	     return response()->json(array(
				                'redirect_url' => route('other-party-login',[$manager_business['businessdetails']['businesss_name'],Hashids::encode($users['id'])]),
				                'status'       => 200,
				               ), 200);  
			   	 }else{
			   	 	$user = User::where('email',$request->get('email'))->where('role_id',5)->pluck("id");
			   	    $other_parties=RegisteredOtherParties::whereIn('other_party_id',$user)->get();
			   	   $data=[];
			   	   foreach ($other_parties as $key => $other_party) {
			   	     $data['other_party_id']=User::where('id',$other_party['other_party_id'])->select('id')->first();
			   	     $data['business_name']=ManagerBusinessDetails::where('user_id',$other_party['manager_id'])->select('businesss_name')->first();
			   	     $maindata[]=$data;
			   	   }
			   	 	Session::put('business_other_party_details',$maindata);
			   	 	return response()->json(array(
				                'redirect_url' => route('choose-other-party-business'),
				                'status'       => 200,
				               ), 200);
			   	 	//return redirect()->route('choose-business');
			   	 }
			   	         
			   }else{
			   	       if ($request->ajax()) {
		                $validator->errors()->add("login_error", "Your email not existed in our business");
		                return response()->json($validator->getMessageBag(), 301);
			           }
		}	   }  
	  
	}
	 //other party login form main site functions end




   
}







