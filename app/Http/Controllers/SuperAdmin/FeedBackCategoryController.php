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
use App\Models\NotesCategory;
use App\Models\ClientNotes;
use App\Models\RegisteredOtherParties;
use App\Models\FeedBackCategory;
use App\Models\OtherPartyInvitedUsers;
use App\Models\OtherPartyCategory;
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
class FeedBackCategoryController extends Controller {

	public function index(){ 
	    $categories=FeedBackCategory::all();
		return view('admin/feedback-category/manage-category',compact('categories'));
	}

    public function create(){
		
	 return view('admin/feedback-category//create-category');
    }

    public function storeCategory(Request $request){
		//return $request->all(); 
		$rules = array(
		'category_name' => 'required|unique:feedback_category,category_name',
		);
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()){
			if($request->ajax()){
			return response()->json($validator->getMessageBag(), 301);
			} else {
			return redirect()->back()->withErrors($validator)
			->withInput();
			}
			$this->throwValidationException($request,$validator);
		}else{
           // return 'hai';
			$data= $request->all();
            $dt = Carbon::now();
		    $client_record = FeedBackCategory::create([
                            	'category_name'=>$data['category_name'],
	                            'created_record_date'=>$dt->toDayDateTimeString(),
		                        ]);                             			
			$url = url('admin/feedback-categories');
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

    public function editCategory($hashid){
        $category_id = Hashids::decode($hashid)[0];
    	$category= FeedBackCategory::where('id',$category_id)->first();
    	return view('admin/feedback-category/edit-category',compact('category'));
    }
    
     /**
	   * Update client information under business manager level.
	   *
	   * @param  Request  $request
	   * @return Response
    */
    public function update(Request $request){
		$rules = array(
		'category_name' => 'required',
		);
		$validator = Validator::make($request->all(), $rules);
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
            if($data['category_name'] != $data['category_hidden_name']){
            	$unique_check=FeedBackCategory::where('category_name',$data['category_name'])->get();
               if(count($unique_check) != 0){
            	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry! Already category existed in your business...");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', "Sorry! Already category existed in your business...")->withInput();
                 }
                }
            }
            $category_record = FeedBackCategory::findOrFail($data['category_id']);
            $category_record->update([
                            	'category_name'=>$data['category_name'],          
	                            'updated_record_date'=>$dt->toDayDateTimeString(),
		                        ]);			
			$url = url('admin/feedback-categories');
	        if($request->ajax()){
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

    public function delete($id){
        $record=FeedBackCategory::where('id',$id)->first();
        $record->delete();
	    return response()->json($record);
    }		                  
}







