<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\FIrstTimeBusinessClientSubscription;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller {

//Admin Login Form displayed
public function index(){
    $role_id=Auth::user();
    if($role_id['role_id'] == 1) {
      return redirect('admin/dashboard');
    }else{
       return view('admin.login');
    }        
}

//Admin after login showing dashboard
public function login(Request $request){

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
   }
  else{
            $userdata = array(
            'email' => Input::get('email'),
            'password' => Input::get('password')
            );
            if (Auth::validate($userdata)) {
                 if (Auth::attempt($userdata)) {
                      /*  return redirect()->intended('profile');*/   
                       return response()->json(array(
                        'redirect_url' => url('admin/dashboard'),
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

public function dashboard(){
  $business_clients=User::where('role_id',2)->count();
  $subscriptions_count=FIrstTimeBusinessClientSubscription::count();
  return view('admin/dashboard',compact('business_clients','subscriptions_count'));
}

//Admin Logged Out
public function logout(){

    Auth::logout();
    return redirect()->to('admin')->with('message', 'Your are logged out!');
}
       


}







