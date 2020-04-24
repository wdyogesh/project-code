<?php

namespace App\Http\Controllers\Frontend\Manager;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\OtherPartyCategory;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use Mail;

class OtherPartyCategoryController extends Controller {
	
    
  public function index(){
    $other_party_categories = OtherPartyCategory::where('manager_id',Auth::user()->id)->where('soft_delete',0)->get();
    return view('frontend/business-manager/otherparty-category-management/manage-category',compact('other_party_categories'));
  }	

  public function create(){
    return view('frontend/business-manager/otherparty-category-management/create-category',compact('other_party_categories'));
  }	

  public function store(Request $request){
      //return $request->all();
        $rules = array(
		/*'category_name' => 'required|unique:other_party_categories,category_name',*/
		'category_name' => 'required',
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
			$data= $request->all();
			$dt = Carbon::now();
			//business manager level category Unique
			  $manager_otherparty_category_check= OtherPartyCategory::where('manager_id',Auth::user()->id)->where('category_name',$data['category_name'])->first();
			  if(count($manager_otherparty_category_check) == 1){
			  	if($manager_otherparty_category_check != "" && $manager_otherparty_category_check['soft_delete'] == 0){
				  	if ($request->ajax()) {
		                $validator->errors()->add("login_error", "Sorry category already existed in your business");
		                return response()->json($validator->getMessageBag(), 301);
	                 }else{
	                 	return redirect()->back()->with('fail', 'Sorry category already existed in your business')->withInput();
	                 }
			    }elseif($manager_otherparty_category_check != "" && $manager_otherparty_category_check['soft_delete'] == 1){
			    	$manager_otherparty_category_check->update([
                        'soft_delete'=>0,                         
                        'updated_record_date'=>'',                         
                        'updated_at'=>'',                         
	                   ]);
			    	$url = url('manager/manage-other-party-category');
					if ($request->ajax()){
			            return response()->json(array(
			              'success' => 'Category Created Successfully',
			              'modal' => true,
			              'redirect_url' => $url,
			              'status' => 200,
			              ), 200);
			        }else{
			            return redirect()->intended($url)->with('success', 'Category Created Successfully');
			        }
			    }
			  }
			$category_record = OtherPartyCategory::create([
                        	'category_name'=>$data['category_name'],
                        	'manager_id'=>Auth::user()->id,
                             'created_record_date'=>$dt->toDayDateTimeString(),                         
	                        ]);
		                                 			
			$url = url('manager/manage-other-party-category');
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Category Created Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url)->with('success', 'Category Created Successfully');
	        }
                 
		}
  }

  public function edit($subdomain,$hashid){
  	       $category_id = Hashids::decode($hashid)[0];
  	       $record= OtherPartyCategory::where('id',$category_id)->first();
  	       return view('frontend/business-manager/otherparty-category-management/edit-category',compact('record'));
  }	

  public function update(Request $request){
  	 $rules = array(
		'category_name' => 'required',
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
			$data= $request->all();
			$dt = Carbon::now();

			if($data['category_hidden_name'] == $data['category_name']){
				//return 'fine';
             $edit_record= OtherPartyCategory::where('id',$request->get('category_id'))->first();
			  $edit_record->update([
                        	'category_name'=>$data['category_name'],
                        	'manager_id'=>Auth::user()->id,
                            'updated_record_date'=>$dt->toDayDateTimeString(),                         
	                        ]);
			}else{
               //  return 'not fine';
				$manager_otherparty_category_check= OtherPartyCategory::where('manager_id',Auth::user()->id)->where('category_name',$data['category_name'])->first();
				    if(count($manager_otherparty_category_check) != 0){
					  	if($manager_otherparty_category_check != "" && $manager_otherparty_category_check['soft_delete'] == 0){
						  	if ($request->ajax()) {
				                $validator->errors()->add("login_error", "Sorry category already existed in your business");
				                return response()->json($validator->getMessageBag(), 301);
			                 }else{
			                 	return redirect()->back()->with('fail', 'Sorry category already existed in your business')->withInput();
			                 }
						 }elseif($manager_otherparty_category_check != "" && $manager_otherparty_category_check['soft_delete'] == 1){
						    	$manager_otherparty_category_check->update([
			                        'soft_delete'=>0,                         
			                        'updated_record_date'=>$dt->toDayDateTimeString() 
			                    ]);
						    	$url = url('manager/manage-other-party-category');
								if ($request->ajax()){
						            return response()->json(array(
						              'success' => 'Category Updated Successfully',
						              'modal' => true,
						              'redirect_url' => $url,
						              'status' => 200,
						              ), 200);
						        }else{
						            return redirect()->intended($url)->with('success', 'Category Updated Successfully');
						        }
					    }
				  }else{
				  	 $edit_record= OtherPartyCategory::where('id',$request->get('category_id'))->first();
			         $edit_record->update([
                        	'category_name'=>$data['category_name'],
                        	'manager_id'=>Auth::user()->id,
                            'updated_record_date'=>$dt->toDayDateTimeString(),                         
	                        ]);
				  }    

			}
			                      			
			$url = url('manager/manage-other-party-category');
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Category Updated Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url)->with('success', 'Category Updated Successfully');
	        }
                 
		}   
  }

  public function delete($subdomain,$id){
  	//return 'hai';
    $other_party_category=OtherPartyCategory::where('id',$id)->first();
    $other_party_category->update([
                        	'soft_delete'=>1,             
	                        ]);
	return response()->json($other_party_category);
  }			                  
}







