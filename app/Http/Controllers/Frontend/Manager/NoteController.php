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
use App\Models\Appointments;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use Mail;
use DB;
class NoteController extends Controller {

	

     //main client notes functions start
    public function manageNotes($subdoamin,$hashclientid){
        $client_id = Hashids::decode($hashclientid)[0];
        $client_record= User::where('id',$client_id)->first();
        $client_notes=ClientNotes::where('manager_id',Auth::user()->id)->where('client_id',$client_id)->get();
        $data=[];  
        foreach($client_notes as $notes){
          $clients_record=User::where('id',$notes['client_id'])->select('name','surname')->first();
          $data['consultation_type']=$notes['consultation_type'];
          $appointment_record=Appointments::where('id',$notes['appointment_id'])->select('start_date_time')->first();
          $data['appoiintment_date']=$appointment_record['start_date_time'];
          $data['client_id']=$notes['client_id'];
          $data['notes_id']=$notes['id'];
          $data['client_name']=$clients_record['name'];
          $data['client_sur_name']=$clients_record['surname'];
          $category_record = NotesCategory::where('id',$notes['category_name'])->first();
          $data['category_name']=$category_record['category_name'];
          $data['notes']=$notes['notes'];
          $business_manager=User::where('id',$notes['common_user_id'])->first();
          $data['added_by']=$business_manager['name'].' '.$business_manager['surname'];
          $data['added_by_id']=$business_manager['id'];
          $other_party_users=RegisteredOtherParties::where('id',$notes['other_party_id'])->first();
          $other_party_record=User::where('id',$other_party_users['other_party_id'])->first();
          $data['other_party_name']=$other_party_record['name'].' '.$other_party_record['surname'];
          $invited_other_party=OtherPartyInvitedUsers::where('id',$other_party_users['invitation_table_record_id'])->select('other_party_category_id')->first();
          $other_party_category=OtherPartyCategory::where('id',$invited_other_party['other_party_category_id'])->first();
          $data['other_party_category']=$other_party_category['category_name'];
          $data['created_record_date']=$notes['created_record_date'];
         /* $roles=Role::where('id',$business_manager['role_id'])->select('role_name')->first();*/
          /*$data['role_name']=$roles['role_name'];
          $data['file_name']=$notes['file_name'];
          $data['created_record_date']=$notes['created_record_date'];
          $data['updated_record_date']=$notes['updated_record_date'];*/
          $all_client_notes[]=$data;
        }
        //return $all_client_notes;
        //dd($all_client_notes);
        return view('frontend/business-manager/notes/manage-notes',compact('all_client_notes','client_notes','client_record','client_id'));
    }

     //main client notes functions start
    public function searchNotes($subdoamin,Request $request){
        $client_id =  $request->get('client_id');    
        $search = $request->get('search');
        if(empty($search)){
                $client_notes= ClientNotes::where('manager_id',Auth::user()->id)->where('client_id',$client_id)->get();
        }else{
        $client_notes= ClientNotes::where('manager_id',Auth::user()->id)->where('client_id',$client_id)->where('consultation_type', 'LIKE', '%' . $search . '%')->get();
        }
        $data=[];  
        foreach($client_notes as $notes){
          $clients_record=User::where('id',$notes['client_id'])->select('name','surname')->first();
          $data['consultation_type']=$notes['consultation_type'];
          $appointment_record=Appointments::where('id',$notes['appointment_id'])->select('start_date_time')->first();
          $data['appoiintment_date']=$appointment_record['start_date_time']->toDayDateTimeString();
          $data['client_id']=$notes['client_id'];
          $data['notes_id']=$notes['id'];
          $data['client_name']=$clients_record['name'];
          $data['client_sur_name']=$clients_record['surname'];
          $category_record = NotesCategory::where('id',$notes['category_name'])->first();
          $data['category_name']=$category_record['category_name'];
          $data['notes']=$notes['notes'];
          $business_manager=User::where('id',$notes['common_user_id'])->first();
          $data['added_by']=$business_manager['name'].' '.$business_manager['surname'];
          $data['added_by_id']=$business_manager['id'];
          $other_party_users=RegisteredOtherParties::where('id',$notes['other_party_id'])->first();
          $other_party_record=User::where('id',$other_party_users['other_party_id'])->first();
          $data['other_party_name']=$other_party_record['name'].' '.$other_party_record['surname'];
          $invited_other_party=OtherPartyInvitedUsers::where('id',$other_party_users['invitation_table_record_id'])->select('other_party_category_id')->first();
          $other_party_category=OtherPartyCategory::where('id',$invited_other_party['other_party_category_id'])->first();
          $data['other_party_category']=$other_party_category['category_name'];
          $data['created_record_date']=$notes['created_record_date'];
         /* $roles=Role::where('id',$business_manager['role_id'])->select('role_name')->first();*/
          /*$data['role_name']=$roles['role_name'];
          $data['file_name']=$notes['file_name'];
          $data['created_record_date']=$notes['created_record_date'];
          $data['updated_record_date']=$notes['updated_record_date'];*/
          $all_client_notes[]=$data;
          // return response($all_client_notes);
          if(empty($all_client_notes)){
            return false;

          }
        }
        //return $all_client_notes;
        //dd($all_client_notes);
        return view('frontend/business-manager/notes/ajax-manage-notes',compact('all_client_notes','client_notes','client_record'));
    }

    public function createNotes($subdoamin,$hashclientid){
    	$client_id = Hashids::decode($hashclientid)[0];
        $client_record= User::where('id',$client_id)->first();
        $appointments= Appointments::where('client_id',$client_id)->where('manager_id',Auth::user()->id)->where('cancellation','=',null)->get();
        $dt = Carbon::now();
        $appoint=[];
        foreach($appointments as $appointment){
           $appoint['appointment_id']=$appointment['id'];
           $appoint['appointment_date']= $appointment['start_date_time']->toDayDateTimeString();
           $client_name=User::where('id',$appointment['client_id'])->select('name','surname')->first();
           $appoint['client_name']=$client_name['name'].' '. $client_name['surname'];
           $apointment_details[]=$appoint;
        }
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
    	return view('frontend/business-manager/notes/create-client-notes',compact('managers_clients','notes_category','otherparties','client_record','apointment_details'));
    }

    public function postNotes(Request $request){
    	//return $request->all();
    	$messages = [
        "appointments.required" => "Select appointment",
        "other_party.required" => "Select other party.",
        "category_name.required" => "Category required.",
        "notes.required" => "Notes required",
	     ];
    	$rules = array(
        'appointments' => 'required',
		'other_party' => 'required',
		'category_name' => 'required',
		'notes' => 'required',
		);
		/*if($request->file('attachment')){
            $rules = array_add($rules, 'attachment', 'required|max:10000');
			$rules = array_add($rules, 'add_attached_file_name', 'required');
		}*/
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
            $client_registration_id=User::where('id',$data['client_name'])->select('registration_id')->first();
            $dt = Carbon::now();
/*            $files = $request->file('attachment');
            $newfilename="";
			if(!empty($files)){
               $filename = $files->getClientOriginalName();
		       $ext = $files->getClientOriginalExtension();
		       $newfilename = substr($data['add_attached_file_name'], 0, strrpos($filename, '.'));
		       $newfilename = $newfilename . '_' . $client_registration_id['registration_id'] . '_' . uniqid() . '.' . $ext;
		       $files->move('uploads/client_notes_documents', $newfilename);
		    }*/
            $client_record = ClientNotes::create([
                                'consultation_type'=>$data['consultation_type'],
                                'appointment_id'=>$data['appointments'],
                                'client_id'=>$data['client_name'],
                            	'other_party_id'=>$data['other_party'],
                            	'category_name'=>$data['category_name'],
                            	'notes'=>$data['notes'],
                            	/*'file_name'=>$newfilename,*/
                            	'manager_id'=>Auth::user()->id,
                            	'common_user_id'=>Auth::user()->id,
	                            'created_record_date'=>$dt->toDayDateTimeString(),
		                        ]);

			$url = url('manager/notes/'.Hashids::encode($data['client_name']));
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


  public function editNotes($subdomain,$notesid,$hashclientid){
  	   $client_id = Hashids::decode($hashclientid)[0];
       $client_record= User::where('id',$client_id)->first();
       $appointments= Appointments::where('client_id',$client_id)->where('manager_id',Auth::user()->id)->where('cancellation','=',null)->get();
        $dt = Carbon::now();
        $appoint=[];
        foreach($appointments as $appointment){
           $appoint['appointment_id']=$appointment['id'];
          $appoint['appointment_date']= $appointment['start_date_time']->toDayDateTimeString();
           $client_name=User::where('id',$appointment['client_id'])->select('name','surname')->first();
           $appoint['client_name']=$client_name['name'].' '. $client_name['surname'];
           $apointment_details[]=$appoint;
        }
  	    $manager__level_client_ids = ManagerClients::where('manager_id',Auth::user()->id)->pluck('client_id')->all();
        $managers_clients = User::whereIn('id',$manager__level_client_ids)->get();
        $notes_category=NotesCategory::where('manager_id',Auth::user()->id)->where('soft_delete',0)->get();
  	    $notes_id = Hashids::decode($notesid)[0];
    	$notes= ClientNotes::where('id',$notes_id)->first();
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
	    //return $otherparties;
    	return view('frontend/business-manager/notes/edit-notes',compact('managers_clients','notes_category','notes','client_record','otherparties','apointment_details'));
   }

   public function updateNotes(Request $request){
		$messages = [
        "appointments.required" => "Select appointment",
        "other_party.required" => "Select other party.",
        "category_name.required" => "Category required.",
        "notes.required" => "Notes required",
         ];
        $rules = array(
        'appointments' => 'required',
        'other_party' => 'required',
        'category_name' => 'required',
        'notes' => 'required',
        );
		/*if($request->file('attachment')){
			$rules = array_add($rules, 'attachment', 'required|max:10000');
		}*/
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
           /* $files = $request->file('attachment');
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
		    }*/

		    $client_notes_record = ClientNotes::findOrFail($data['notes_id']);
            $client_notes_record->update([
                                'consultation_type'=>$data['consultation_type'],
                                'appointment_id'=>$data['appointments'],
                                'other_party_id'=>$data['other_party'],
                            	'category_name'=>$data['category_name'],
                            	'notes'=>$data['notes'],
	                            'updated_record_date'=>$dt->toDayDateTimeString(),
		                        ]);
			$url = url('manager/notes/'.Hashids::encode($data['client_name']));
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
 
    

    /*public function notesDetails($subdomain,$hasnoteshid,$hashclienthid){
    	$client_id = Hashids::decode($hashclienthid)[0];
        $client_record= User::where('id',$client_id)->first();
  	    $notes_id = Hashids::decode($hasnoteshid)[0];
    	$notes= ClientNotes::where('id',$notes_id)->first();
    	$client_records=User::where('id',$notes['client_id'])->select('name','surname')->first();
		  $data['notes_id']=$notes['id'];
		  $data['client_name']=$client_records['name'];
		  $data['client_sur_name']=$client_records['surname'];
		  $category_record = NotesCategory::where('id',$notes['category_name'])->first();
		  $data['category_name']=$client_records['category_name'];
		  $data['notes']=$notes['notes'];
		  $business_manager=User::where('id',$notes['common_user_id'])->first();
	      $data['added_by']=$business_manager['name'].' '.$business_manager['surname'];
	      $roles=Role::where('id',$business_manager->role_id)->select('role_name')->first();
	      $data['role_name']=$roles['role_name'];
	      $data['file_name']=$notes['file_name'];
	      $data['created_record_date']=$notes['created_record_date'];
	      $data['updated_record_date']=$notes['updated_record_date'];
    	return view('frontend/business-manager/notes/detail-notes',compact('data','client_record'));
  }  */

   public function attachments($subdomain,$hashclienthid,$hashcategoryid=NULL){
        $client_id = Hashids::decode($hashclienthid)[0];
        $client_record= User::where('id',$client_id)->first();
        $categories = NotesCategory::where('manager_id',Auth::user()->id)->get();
        if($hashcategoryid != ""){
            $category_id = Hashids::decode($hashcategoryid)[0];
            $attachments= ClientNotes::where('client_id',$client_id)->where('category_name',$category_id)->where('manager_id',Auth::user()->id)->where('file_name','<>','')->get();
        }else{
             $attachments= ClientNotes::where('client_id',$client_id)->where('manager_id',Auth::user()->id)->where('file_name','<>','')->get(); 
        }	
    	$data=[];
    	foreach($attachments as $attachment){
    		$category_record = NotesCategory::where('id',$attachment['category_name'])->where('manager_id',Auth::user()->id)->first();
    		$data['category_name']=$category_record['category_name'];
    		$data['attachments']=$attachment['file_name'];
    		$attachentsall[]=$data;
    	}
    	//return $attachentsall;
    	return view('frontend/business-manager/notes/attachments',compact('categories','attachentsall','client_record'));
  }  

  public function appointments($subdomain,$hashclienthid){
    	$client_id = Hashids::decode($hashclienthid)[0];
        $client_record= User::where('id',$client_id)->first();
    	$appointments= Appointments::where('client_id',$client_id)->where('manager_id',Auth::user()->id)->where('cancellation','=',null)->get();
    	$data=[];
    	foreach($appointments as $appointment){
            $data['appointment_start_time']=$appointment['start_date_time'];
            $data['appointment_end_time']=$appointment['end_date_time'];
            $added_user=User::where('id',$appointment['practionar_id'])->first();
            $data['appointmnet_with']=$added_user['name'].' '. $added_user['surname'];
            $my_appointments[]=$data;
    	}
    	//return $my_appointments;
    	return view('frontend/business-manager/notes/client-appointments',compact('my_appointments','client_record'));
  }  

  
			                  
}







