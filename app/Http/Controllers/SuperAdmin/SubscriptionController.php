<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SubscriptionUserLimit;
use App\Models\SubscriptionPackages;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use Mail;

class SubscriptionController extends Controller {
	
    
 /* public function index(){
      return view('admin/subscription-management/subscription-management');		  
  }*/

  public function plans(){
  	 $all_plans=SubscriptionUserLimit::all();
  	return view('admin/subscription-management/subscription-management',compact('all_plans'));
  }
  public function createPlans(){
  	return view('admin/subscription-management/subscription-plans');
  }

  public function subscriptionLimitUsers(Request $request){
       //return $request->all();
  	$messages = [
		         "user_size_from.required" => "Please Select Users Size From.",
		         "user_size_to.required" => "Please Select Users Size To.",
		         "user_size_to.after" => "Users Count Must More Than Form User Size.",
		        ];
    $rules = array(
          				'package_name' => 'required',
          				'data_size' => 'required|numeric',
          				'user_size_from' => 'required',
          				'user_size_to' => 'required',
          				'price' => 'required|numeric',
          			 );
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
			    if($data['user_size_from'] < $data['user_size_to'] || $data['user_size_from'] != $data['user_size_to']){

					$user_size= SubscriptionUserLimit::create([
                        'package_name' =>  $data['package_name'],
                        'data_size' =>  $data['data_size'],
                        'user_size_from' =>  $data['user_size_from'],
                        'user_size_to' =>  $data['user_size_to'],
                        'price' =>  $data['price'],
                    ]);
				}else{
					 return redirect()->back()->with('error', 'To Users Size Must More Than Form User Size');
				}
               

                $url = url('admin/subscription-plans');
	        if ($request->ajax()) {
	        return response()->json(array(
	          'success' => 'User Limit Creted Successfully',
	          'modal' => true,
	          'redirect_url' => $url,
	          'status' => 200,
	          ), 200);
	      }else{
	        return redirect()->intended($url)->with('success', 'Package Createdd Succesfully');
	      }
			}
  }

  public function edit($hashid){
  	 $id = Hashids::decode($hashid)[0];
  	 $edit_record=SubscriptionUserLimit::where('id',$id)->first();
  	 return view('admin/subscription-management/edit-subscription-plan',compact('edit_record'));

  }

  public function update(Request $request){
  		$messages = [
		         "user_size_from.required" => "Please Select Users Size From.",
		         "user_size_to.required" => "Please Select Users Size To.",
		         "user_size_to.after" => "Users Count Must More Than Form User Size.",
		        ];
    $rules = array(
          				'package_name' => 'required',
          				'data_size' => 'required|numeric',
          				'user_size_from' => 'required',
          				'user_size_to' => 'required',
          				'price' => 'required|numeric',
          			 );
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

			    if($data['user_size_from'] < $data['user_size_to'] || $data['user_size_from'] != $data['user_size_to']){
                   $package = SubscriptionUserLimit::findOrFail($data['package_id']);
					$package->update([
                        'package_name' =>  $data['package_name'],
                        'data_size' =>  $data['data_size'],
                        'user_size_from' =>  $data['user_size_from'],
                        'user_size_to' =>  $data['user_size_to'],
                        'price' =>  $data['price'],
                    ]);
				}else{
					 return redirect()->back()->with('error', 'To Users Size Must More Than Form User Size');
				}
               

                $url = url('admin/subscription-plans');
	        if ($request->ajax()) {
	        return response()->json(array(
	          'success' => 'User Limit Creted Successfully',
	          'modal' => true,
	          'redirect_url' => $url,
	          'status' => 200,
	          ), 200);
	      }else{
	        return redirect()->intended($url)->with('success', 'Package Updated Succesfully');
	      }
			}

  }
  
  public function delete($id){
       //return $id;
        $package=SubscriptionUserLimit::where('id',$id)->first();
        $package->delete();
        return response()->json($package);
   } 	

}
