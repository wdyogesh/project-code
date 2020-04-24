<?php

namespace App\Http\Controllers\Frontend\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\Role;
use App\Models\UserAddresses;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use File;
use DB;
class SettingsController extends Controller {

	public function profile(){ 
         $user_profile = User::with('businessdetails')->with('useraddresses')->whereId(Auth::user()->id)->first();
         $user_role=Role::where('id',$user_profile['role_id'])->select('role_name')->first();
		return view('frontend/client/client-settings/profile',compact('user_profile','user_role'));
	}

	public function editProfile($subdomain,$hashid){ 
        $manager_id = Hashids::decode($hashid)[0];
        $user_profile = User::with('useraddresses')->whereId($manager_id)->first();
          //dd($user_profile);    
       //all countries dispaly              
	     $countries = DB::table("countries")->pluck("name","id");
       //when edit all states of selected user countrry display(take care)
	    $user_country_id_fetch=DB::table("countries")->where('name',$user_profile['useraddresses']['country'])->first();       
	    if($user_country_id_fetch == ""){
         $selected_countery_all_states_foreah="";
	   }else{
	   	  $selected_countery_all_states_foreah = DB::table("states")->where('country_id',$user_country_id_fetch->id)->pluck("name","id");
	   }  
	   //when edit all citys of selected user states display(take care)
	   $user_state_id_fetch=DB::table("states")->where('name',$user_profile['useraddresses']['state'])->first();
	    if($user_country_id_fetch == ""){
         $selected_state_all_cities_foreah="";
	    }else{
          $selected_state_all_cities_foreah = DB::table("cities")->where('state_id',$user_state_id_fetch->id)->pluck("name","id"); 
	    }  
       return view('frontend/client/client-settings/edit-profile',compact('user_profile','countries','selected_countery_all_states_foreah','selected_state_all_cities_foreah'));
	}

	public function updateProfile(Request $request){
		//return $request->all();
    	$messages = [
		       "name.required" => "Name must required.", 
		       "phone_number.required" => "Phone number must required.", 
		       ];
    	   
		$rules = array(
				'name' => 'required',
				'country' => 'required',
				'dateof_birth' => 'required',
				'state' => 'required',
				'city' => 'required',
				'country_code' => 'required',
				'area_code' => 'required|numeric',
				'phone_number' => 'required|numeric',
				'pincode' => 'required|numeric',
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
		    $data= $request->all();		           
            $dt = Carbon::now();
            $role = User::findOrFail(Auth::user()->id);
            $role->name=$data['name'];
            $role->phone_number=$data['phone_number'];
            $role->area_code=$data['area_code'];
            $role->dateof_birth=$data['dateof_birth'];
            $role->country_code=$data['country_code'];
            $role->updated_record_date=$dt->toDayDateTimeString();
            $role->save();

            $address = UserAddresses::whereUserId(Auth::user()->id)->first();
            $address->country=$data['country'];
            $address->state=$data['state'];
            $address->city=$data['city'];
            $address->pincode=$data['pincode'];
            $address->save();		         
	        //return $client_record;     			
			$url = url('client/profile');
	        if($request->ajax()){
	            return response()->json(array(
	              'success' => 'Profile Updated Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
		    }else{
		        return redirect()->intended($url)->with('success', 'Client Updated Successfully');
		    }
				      
		}
	}


	public function changePassword(){ 

		return view('frontend/client/client-settings/change-password');
	}

	public function postPassword(Request $request){ 
	  /* return $request->all();*/
	    $messages = [        
			        "password.required" => "Password field is required.",
			        "password.min" => "Password minimum 8 digits, one capital, small, number, special character",
			        //"password.regex" => "Password atleast one capittal, small, number,special character.",
	                ];
		$rules = array(		
						'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/',
						'repassword' => 'required|same:password',
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
						//return $request->all();
						$manager_password = User::findOrFail(Auth::user()->id);
						$manager_password->password=bcrypt($request->get('password'));
		    			$manager_password->save();
		    			return redirect()->back()->with('success', 'Password  Updated Successfully');
					}
	}

	public function profielePicture(Request $request){
       
	 $rules = array(
		'profile_pic' => 'required|mimes:jpeg,jpg,png|max:1000',
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
		    $data = $request->all();
		    $user_record= User::where('id',$data['user_id'])->first();
		    if(count($user_record) != 0){
		    	    $files = $request->file('profile_pic');
					if(!empty($files)){
		               $filename = $files->getClientOriginalName();
				       $ext = $files->getClientOriginalExtension();
				       $newfilename = substr($filename, 0, strrpos($filename, '.'));
				       $newfilename = uniqid() . '_' . $newfilename . '.' . $ext;
				       $files->move('uploads/profile_pics', $newfilename);
					}
			$user_record->update([
                            	'profile_pic'=>$newfilename,
		                        ]);
		    }
			
			$url = url('client/profile');
		      if ($request->ajax()) {
		        return response()->json(array(
		          'success' => 'Profile Pic Set Successfully',
		          'modal' => true,
		          'redirect_url' => $url,
		          'status' => 200,
		          ), 200);
		      }else{
		        return redirect()->intended($url)->with('success', 'Profile Pic Set Successfully');
		      }
	   }
    }
			                  
}







