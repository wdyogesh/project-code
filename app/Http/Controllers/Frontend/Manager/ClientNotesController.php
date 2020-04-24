<?php

namespace App\Http\Controllers\Frontend\Manager;
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
class ClientNotesController extends Controller {

	public function index(){ 
	     $notes_category=NotesCategory::where('manager_id',Auth::user()->id)->where('soft_delete',0)->get();
	     $data=[];
	     foreach($notes_category as $category){
	     	$data['category_id']=$category->id;
	     	$data['category_name']=$category->category_name;
	     	$business_manager=User::where('id',$category->common_user_id)->first();
	     	$data['added_by']=$business_manager['name'].' '.$business_manager['surname'];
	     	$roles=Role::where('id',$business_manager['role_id'])->select('role_name')->first();
	     	$data['role_name']=$roles['role_name'];
	     	$data['created_record_date']=$category->created_record_date;
	     	$data['updated_record_date']=$category->updated_record_date;
	     	$all_records[]=$data;
	     }
		return view('frontend/business-manager/client-notes/notes-category/manage-notes-category',compact('all_records'));
	}

    public function create(){
		
	 return view('frontend/business-manager/client-notes/notes-category/create-category');
    }

    public function storeCategory(Request $request){
		//return $request->all(); 
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
           // return 'hai';
			$data= $request->all();
            $dt = Carbon::now();
           $unique_check=NotesCategory::where('category_name',$data['category_name'])->where('manager_id',Auth::user()->id)->first();
            if(count($unique_check) != 0){
            	if($unique_check['soft_delete'] == 1){
	            		$notes_cat=NotesCategory::where('id',$unique_check['id'])->first();
	            		$notes_cat->update([
	                            	'soft_delete'=>0,
	                            	'common_user_id'=>Auth::user()->id,
		                            'created_record_date'=>$dt->toDayDateTimeString(),
		                            'updated_record_date'=>'',
		                            'updated_at'=>'',
			                        ]);
			            $url = url('manager/manage-notes-category');
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
            	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry! Already category existed in your business...");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', "Sorry! Already category existed in your business...")->withInput();
                 }
            }
		    $client_record = NotesCategory::create([
                            	'category_name'=>$data['category_name'],
                            	'manager_id'=>Auth::user()->id,
                            	'common_user_id'=>Auth::user()->id,
	                            'created_record_date'=>$dt->toDayDateTimeString(),
		                        ]);                             			
			$url = url('manager/manage-notes-category');
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

    public function editCategory($subdomain,$hashid){
        $category_id = Hashids::decode($hashid)[0];
    	$notes_category= NotesCategory::where('id',$category_id)->first();
    	return view('frontend/business-manager/client-notes/notes-category/edit-category',compact('notes_category'));
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
            	$unique_check=NotesCategory::where('category_name',$data['category_name'])->where('manager_id',Auth::user()->id)->get();
               if(count($unique_check) != 0){
            	if ($request->ajax()) {
	                $validator->errors()->add("login_error", "Sorry! Already category existed in your business...");
	                return response()->json($validator->getMessageBag(), 301);
                 }else{
                 	return redirect()->back()->with('fail', "Sorry! Already category existed in your business...")->withInput();
                 }
                }
            }
            $category_record = NotesCategory::findOrFail($data['category_id']);
            $category_record->update([
                            	'category_name'=>$data['category_name'],          
	                            'updated_record_date'=>$dt->toDayDateTimeString(),
		                        ]);			
			$url = url('manager/manage-notes-category');
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

    public function delete($subdomain,$id){
        $record=NotesCategory::where('id',$id)->first();
        $record->update([
                         'soft_delete'=>1,  	
		                ]);
	    return response()->json($record);
    }

    //main client notes functions start
    public function manageNotes(){
    	$client_notes=ClientNotes::where('manager_id',Auth::user()->id)->get();
    	$data=[];
    	foreach($client_notes as $notes){
    	  $client_record=User::where('id',$notes['client_id'])->select('name','surname')->first();
    	  $data['notes_id']=$notes['id'];
    	  $data['client_name']=$client_record['name'];
    	  $data['client_sur_name']=$client_record['surname'];
    	  $category_record = NotesCategory::where('id',$notes['category_name'])->first();
    	  $data['category_name']=$category_record['category_name'];
    	  $data['notes']=$notes['notes'];
    	  $business_manager=User::where('id',$notes['common_user_id'])->first();
	      $data['added_by']=$business_manager['name'].' '.$business_manager['surname'];
	      $roles=Role::where('id',$business_manager['role_id'])->select('role_name')->first();
	      $data['role_name']=$roles['role_name'];
	      $data['file_name']=$notes['file_name'];
	      $data['created_record_date']=$notes['created_record_date'];
	      $data['updated_record_date']=$notes['updated_record_date'];
    	  $all_client_notes[]=$data;
    	}
    	//return $all_client_notes;
    	//dd($all_client_notes);
    	return view('frontend/business-manager/client-notes/notes/manage-notes',compact('all_client_notes'));
    }

    public function createNotes(){
    	$manager__level_client_ids = ManagerClients::where('manager_id',Auth::user()->id)->pluck('client_id')->all();
        $managers_clients = User::whereIn('id',$manager__level_client_ids)->get();
        $notes_category=NotesCategory::where('manager_id',Auth::user()->id)->where('soft_delete',0)->get();
        $other_party_users=RegisteredOtherParties::where('manager_id',Auth::user()->id)->get();
        $data=[];
        foreach($other_party_users as $other_party){
        	$data['id']=$other_party['id'];
        	$user=User::where('id',$other_party['other_party_id'])->first();
        	$data['user_name']=$user['name'];
        	$invited_other_party=OtherPartyInvitedUsers::where('id',$other_party['invitation_table_record_id'])->select('other_party_category_id')->first();
        	$other_party_category=OtherPartyCategory::where('id',$invited_other_party['other_party_category_id'])->first();
        	$data['category_name']=$other_party_category['category_name'];
        	$otherparties[]=$data;
        }
    	return view('frontend/business-manager/client-notes/notes/create-client-notes',compact('managers_clients','notes_category','otherparties'));
    }

    public function postNotes(Request $request){
    	//return $request->all();
    	$messages = [
        "other_party.required" => "Other Party required.",
        "client_name.required" => "Client Name required.",
        "category_name.required" => "Category required.",
        "notes.required" => "Notes Required",
	     ];
    	$rules = array(
		'other_party' => 'required',
		'client_name' => 'required',
		'category_name' => 'required',
		'notes' => 'required',
		);
		if($request->file('attachment')){
			$rules = array_add($rules, 'attachment', 'required|max:10000');
		}
		$validator = Validator::make($request->all(),$rules,$messages);
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
            $files = $request->file('attachment');
            $newfilename="";
			if(!empty($files)){
               $filename = $files->getClientOriginalName();
		       $ext = $files->getClientOriginalExtension();
		       $newfilename = substr($filename, 0, strrpos($filename, '.'));
		       $newfilename = uniqid() . '_' . $newfilename . '.' . $ext;
		       $files->move('uploads/client_notes_documents', $newfilename);
		    }
            $client_record = ClientNotes::create([
                            	'client_id'=>$data['client_name'],
                            	'category_name'=>$data['category_name'],
                            	'notes'=>$data['notes'],
                            	'file_name'=>$newfilename,
                            	'manager_id'=>Auth::user()->id,
                            	'common_user_id'=>Auth::user()->id,
	                            'created_record_date'=>$dt->toDayDateTimeString(),
		                        ]);

			$url = url('manager/manage-client-notes');
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Notes Created Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url)->with('success', 'Notes Created Successfully');
	        }
	    
			        
		}
    }


  public function editNotes($subdomain,$hashid){
  	    $manager__level_client_ids = ManagerClients::where('manager_id',Auth::user()->id)->pluck('client_id')->all();
        $managers_clients = User::whereIn('id',$manager__level_client_ids)->get();
        $notes_category=NotesCategory::where('manager_id',Auth::user()->id)->where('soft_delete',0)->get();
  	    $notes_id = Hashids::decode($hashid)[0];
    	$notes= ClientNotes::where('id',$notes_id)->first();
    	
	 // return $data;
    	return view('frontend/business-manager/client-notes/notes/edit-notes',compact('managers_clients','notes_category','notes'));
   }

   public function updateNotes(Request $request){
		$messages = [
        "client_name.required" => "Client Name required.",
        "category_name.required" => "Category required.",
        "notes.required" => "Notes Required",
	     ];
    	$rules = array(
		'client_name' => 'required',
		'category_name' => 'required',
		'notes' => 'required',
		);
		if($request->file('attachment')){
			$rules = array_add($rules, 'attachment', 'required|max:10000');
		}
		$validator = Validator::make($request->all(),$rules,$messages);
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
            $files = $request->file('attachment');
            $newfilename="";
            $client_notes_record = ClientNotes::findOrFail($data['notes_id']);
			if(!empty($files)){
               $filename = $files->getClientOriginalName();
		       $ext = $files->getClientOriginalExtension();
		       $newfilename = substr($filename, 0, strrpos($filename, '.'));
		       $newfilename = uniqid() . '_' . $newfilename . '.' . $ext;
		       $files->move('uploads/client_notes_documents', $newfilename);
		    }else{
		     $newfilename =$client_notes_record['file_name'];
		    }

		    //$client_notes_record = ClientNotes::findOrFail($data['notes_id']);
            $client_notes_record->update([
                            	'client_id'=>$data['client_name'],
                            	'category_name'=>$data['category_name'],
                            	'notes'=>$data['notes'],
                            	'file_name'=>$newfilename,
	                            'updated_record_date'=>$dt->toDayDateTimeString(),
		                        ]);

			$url = url('manager/manage-client-notes');
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Notes Updated Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url)->with('success', 'Notes Updated Successfully');
	        }
	    
			        
		}
				      
		}

	public function deleteNotes($subdomain,$id){
        $record=ClientNotes::where('id',$id)->first();
	    $record->delete();
	    return response()->json($record);
    }
 
    

    public function notesDetails($subdomain,$hashid){
  	    $notes_id = Hashids::decode($hashid)[0];
    	$notes= ClientNotes::where('id',$notes_id)->first();
    	$client_record=User::where('id',$notes['client_id'])->select('name','surname')->first();
		  $data['notes_id']=$notes['id'];
		  $data['client_name']=$client_record['name'];
		  $data['client_sur_name']=$client_record['surname'];
		  $category_record = NotesCategory::where('id',$notes['category_name'])->first();
		  $data['category_name']=$category_record['category_name'];
		  $data['notes']=$notes['notes'];
		  $business_manager=User::where('id',$notes['common_user_id'])->first();
	      $data['added_by']=$business_manager['name'].' '.$business_manager['surname'];
	      $roles=Role::where('id',$business_manager->role_id)->select('role_name')->first();
	      $data['role_name']=$roles['role_name'];
	      $data['file_name']=$notes['file_name'];
	      $data['created_record_date']=$notes['created_record_date'];
	      $data['updated_record_date']=$notes['updated_record_date'];
	 // return $data;
    	return view('frontend/business-manager/client-notes/notes/detail-notes',compact('data'));
  }  
    
			                  
}







