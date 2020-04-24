<?php

namespace App\Http\Controllers\Frontend\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\Appointments;
use App\Models\Calendar;
use App\Models\SecurityQuestions;
use App\Models\BusinessProfessionCategory;
use App\Models\BusinessProfessionTypes;
use App\Models\ManagerClients;
use App\Models\ManagerBusinessDetails;
use App\Models\Role;
use App\Models\Emails;
use App\Models\TrashMails;
use App\Models\OtherPartyCategory;
use App\Models\RegisteredOtherParties;
use App\Models\OtherPartyInvitedUsers;
use App\Models\ReadMails;
use App\Models\ImportantMails;
use App\Models\Employee;
use App\Models\ThreadMailsReply;
use App\Models\UserAddresses;
use App\Models\MailGroup;
use App\Models\NotesCategory;
use App\Models\ClientNotes;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use Mail;
use File;

class MailController extends Controller {

  public function index($subdomain,$keyword =NULL){
   $employee_trash_table_messages=TrashMails::where('user_id',Auth::user()->id)->pluck('email_table_id')->all();
   $employee_unread_table_messages=ReadMails::where('user_id',Auth::user()->id)->pluck('email_table_id')->all();
    
   $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
   $manager_level_employees=Employee::where('manager_id',$manager_id['manager_id'])->pluck('employee_id')->all();
   $manager_level_clients=ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
   $manager_level_other_parties=RegisteredOtherParties::where('manager_id',$manager_id['manager_id'])->pluck('other_party_id')->all();
     if($keyword == ''){
          //All underead inbox messages with check important message query
        $inbox_messages = Emails::leftJoin('important_emails as info', function($join){
            $join->on('info.email_table_id', '=', 'emails.id');
            $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
        })->whereNotIn('emails.id',$employee_trash_table_messages)->whereNotIn('emails.id',$employee_unread_table_messages)->where('to_id',Auth::user()->id)->where('is_drafts',0)->select('*','emails.id as master_table_email_id')->get();
        //All read inbox messages with check important message query
        $inbox_read_messages = Emails::leftJoin('important_emails as info', function($join){
            $join->on('info.email_table_id', '=', 'emails.id');
            $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
        })->whereNotIn('emails.id',$employee_trash_table_messages)->whereIn('emails.id',$employee_unread_table_messages)->where('to_id',Auth::user()->id)->where('is_drafts',0)->select('*','emails.id as master_table_email_id')->get();
      
     }elseif($keyword == 'em'){
        //All underead inbox messages with check important message query
        $inbox_messages = Emails::leftJoin('important_emails as info', function($join){
            $join->on('info.email_table_id', '=', 'emails.id');
            $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
        })->whereNotIn('emails.id',$employee_trash_table_messages)->whereNotIn('emails.id',$employee_unread_table_messages)->whereIn('from_id',$manager_level_employees)->where('to_id',Auth::user()->id)->where('is_drafts',0)->select('*','emails.id as master_table_email_id')->get();
        //All read inbox messages with check important message query
        $inbox_read_messages = Emails::leftJoin('important_emails as info', function($join){
            $join->on('info.email_table_id', '=', 'emails.id');
            $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
        })->whereNotIn('emails.id',$employee_trash_table_messages)->whereIn('emails.id',$employee_unread_table_messages)->whereIn('from_id',$manager_level_employees)->where('to_id',Auth::user()->id)->where('is_drafts',0)->select('*','emails.id as master_table_email_id')->get();
      
     }elseif($keyword == 'cl'){
       //All underead inbox messages with check important message query
        $inbox_messages = Emails::leftJoin('important_emails as info', function($join){
            $join->on('info.email_table_id', '=', 'emails.id');
            $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
        })->whereNotIn('emails.id',$employee_trash_table_messages)->whereNotIn('emails.id',$employee_unread_table_messages)->whereIn('from_id',$manager_level_clients)->where('to_id',Auth::user()->id)->where('is_drafts',0)->select('*','emails.id as master_table_email_id')->get();
        //All read inbox messages with check important message query
        $inbox_read_messages = Emails::leftJoin('important_emails as info', function($join){
            $join->on('info.email_table_id', '=', 'emails.id');
            $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
        })->whereNotIn('emails.id',$employee_trash_table_messages)->whereIn('emails.id',$employee_unread_table_messages)->whereIn('from_id',$manager_level_clients)->where('to_id',Auth::user()->id)->where('is_drafts',0)->select('*','emails.id as master_table_email_id')->get();
      
     }elseif($keyword == 'ot'){
        //All underead inbox messages with check important message query
        $inbox_messages = Emails::leftJoin('important_emails as info', function($join){
            $join->on('info.email_table_id', '=', 'emails.id');
            $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
        })->whereNotIn('emails.id',$employee_trash_table_messages)->whereNotIn('emails.id',$employee_unread_table_messages)->whereIn('from_id',$manager_level_other_parties)->where('to_id',Auth::user()->id)->where('is_drafts',0)->select('*','emails.id as master_table_email_id')->get();
        //All read inbox messages with check important message query
        $inbox_read_messages = Emails::leftJoin('important_emails as info', function($join){
            $join->on('info.email_table_id', '=', 'emails.id');
            $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
        })->whereNotIn('emails.id',$employee_trash_table_messages)->whereIn('emails.id',$employee_unread_table_messages)->whereIn('from_id',$manager_level_other_parties)->where('to_id',Auth::user()->id)->where('is_drafts',0)->select('*','emails.id as master_table_email_id')->get();
     }
    
    //dd($inbox_read_messages); 
     return view('frontend/employee/mail-box-management/mail-box-management',compact('inbox_messages','inbox_read_messages'));
  }

  public function sentItems(){
   $manager_trash_table_messages=TrashMails::where('user_id',Auth::user()->id)->pluck('email_table_id')->all();
    //sent box messages with check important message query
    $sent_messages = Emails::leftJoin('important_emails as info', function($join){
        $join->on('info.email_table_id', '=', 'emails.id');
        $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
    })->whereNotIn('emails.id',$manager_trash_table_messages)->where('from_id',Auth::user()->id)->where('is_drafts',0)->where('master_message_id',NULL)->select('*','emails.id as master_table_email_id')->get();
    //dd($sent_messages);

    return view('frontend/employee/mail-box-management/sent-items',compact('sent_messages'));
  }

  /*public function drafts(){
  	$manager_trash_table_messages=TrashMails::where('user_id',Auth::user()->id)->pluck('email_table_id')->all();
    $draft_messages = Emails::leftJoin('important_emails as info', function($join){
		    $join->on('info.email_table_id', '=', 'emails.id');
		    $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
		})->whereNotIn('emails.id',$manager_trash_table_messages)->where('from_id',Auth::user()->id)->where('manager_id',Auth::user()->id)->where('is_drafts',1)->select('*','emails.id as master_table_email_id')->get();
    return view('frontend/business-manager/mail-box-management/draft-items',compact('draft_messages'));
  }*/

  public function getImportant(){
  	 $manager_important_messages=ImportantMails::where('user_id',Auth::user()->id)->pluck('email_table_id')->all();
  	 //Important box messages query
    $important_messages = Emails::leftJoin('important_emails as info', function($join){
		    $join->on('info.email_table_id', '=', 'emails.id');
		    $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
		})->whereIn('emails.id',$manager_important_messages)->select('*','emails.id as master_table_email_id')->get();
    //dd($important_messages);

   return view('frontend/employee/mail-box-management/important-messages',compact('important_messages'));

  }

   public function getTrash(){
      $manager_trash_table_messages=TrashMails::where('user_id',Auth::user()->id)->where('is_perminant_delete',0)->pluck('email_table_id')->all();
  	  
  	  $trash_messages = Emails::leftJoin('important_emails as info', function($join){
		    $join->on('info.email_table_id', '=', 'emails.id');
		    $join->on('info.user_id', '=', \DB::raw(Auth::user()->id));
		})->whereIn('emails.id',$manager_trash_table_messages)->select('*','emails.id as master_table_email_id')->get();
   return view('frontend/employee/mail-box-management/trash-messages',compact('trash_messages'));
  }

  public function compose($subdomain,$keyword=NULL,$clientorotherparty=NULL){
     $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
     $notes_categores=NotesCategory::where('manager_id',$manager_id['manager_id'])->where('soft_delete',0)->get();
     $other_party_categories=OtherPartyCategory::where('manager_id',$manager_id['manager_id'])->where('soft_delete',0)->get();
     $users="";
    if($keyword == 'all'){
      $manager__level_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->pluck('employee_id')->all();
      $manager__level_client_ids = ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
      $manager__level_other_party_ids = RegisteredOtherParties::where('manager_id',$manager_id['manager_id'])->pluck('other_party_id')->all();
      $collection = collect([$manager__level_employees_ids,$manager__level_client_ids, $manager__level_other_party_ids]);
      $collapsed = $collection->collapse();
      $users = User::whereIn('id',$collapsed->all())->select('id','email','name','surname','role_id')->get();
    }elseif($keyword == 'em'){
      $manager__level_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->pluck('employee_id')->all();
      $users = User::whereIn('id',$manager__level_employees_ids)->where('id','<>',Auth::user()->id)->select('id','email','name','surname','role_id')->get();
     }elseif($keyword == 'em-admin'){
      $manager__level_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->where('businessmanagers_employee_roles_id',5)->pluck('employee_id')->all();
      $users = User::whereIn('id',$manager__level_employees_ids)->where('id','<>',Auth::user()->id)->select('id','email','name','surname','role_id')->get();
     }elseif($keyword == 'em-reception'){
      $manager__level_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->where('businessmanagers_employee_roles_id',6)->pluck('employee_id')->all();
      $users = User::whereIn('id',$manager__level_employees_ids)->where('id','<>',Auth::user()->id)->select('id','email','name','surname','role_id')->get();
     }elseif($keyword == 'em-operational'){
      $manager__level_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->where('businessmanagers_employee_roles_id',7)->pluck('employee_id')->all();
      $users = User::whereIn('id',$manager__level_employees_ids)->where('id','<>',Auth::user()->id)->select('id','email','name','surname','role_id')->get();
     }elseif($keyword == 'em-facetoface'){
      $manager__level_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->where('businessmanagers_employee_roles_id',8)->pluck('employee_id')->all();
      $users = User::whereIn('id',$manager__level_employees_ids)->where('id','<>',Auth::user()->id)->select('id','email','name','surname','role_id')->get();
     }elseif($keyword == 'cl' && $clientorotherparty == ""){
      $manager__level_employees_ids = ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
      $users = User::whereIn('id',$manager__level_employees_ids)->select('id','email','name','surname','role_id')->get();
     }elseif($keyword == 'cl' && $clientorotherparty != ""){
         $id = Hashids::decode($clientorotherparty);
         $manager__level_category_based_client_ids = ClientNotes::whereIn('category_name',$id)->where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
         $users = User::whereIn('id',$manager__level_category_based_client_ids)->select('id','email','name','surname','role_id')->get();
     }elseif($keyword == 'ot' && $clientorotherparty == ""){
      $manager__level_employees_ids = RegisteredOtherParties::where('manager_id',$manager_id['manager_id'])->pluck('other_party_id')->all();
      $users = User::whereIn('id',$manager__level_employees_ids)->select('id','email','name','surname','role_id')->get();
     }elseif($keyword == 'ot' && $clientorotherparty != ""){
       $id = Hashids::decode($clientorotherparty);
       $invited_other_party=OtherPartyInvitedUsers::whereIn('other_party_category_id',$id)->where('manager_id',$manager_id['manager_id'])->pluck('id')->all();
       $manager__level_other_parties_ids = RegisteredOtherParties::whereIn('invitation_table_record_id',$invited_other_party)->where('manager_id',$manager_id['manager_id'])->pluck('other_party_id')->all();
       $users = User::whereIn('id',$manager__level_other_parties_ids)->select('id','email','name','surname','role_id')->get();
     }else{
      $id = Hashids::decode($keyword);
      $users = User::whereIn('id',$id)->select('id','email','name','surname','role_id')->get();
     }
    // return $users;
    return view('frontend/employee/mail-box-management/mail-compose',compact('users','keyword','notes_categores','other_party_categories'));
  }

 public function messageDetailsRead($subdomain,$hashid,$hashPagename){
   $id = Hashids::decode($hashid)[0];
   $dummy_page_wise_numbers=Hashids::decode($hashPagename)[0];
   //only inbox page read items when we click on message, start
   if($dummy_page_wise_numbers == 1){
   	  $page_name = 'Inbox';
   	}else{
   	  $page_name ='other_page';
   	}
  //only inbox page read items when we calic on message end
   /*read message convertion when click first time on message start*/
  $count_read_mails_check= ReadMails::where('email_table_id',$id)->where('user_id',Auth::user()->id)->count();
  if($count_read_mails_check == 0 && $page_name != "other_page"){
     $read_mails = ReadMails::create([
	                    'email_table_id' => $id,
	                    'user_id' => Auth::user()->id,
	                    'is_read' =>1,
	                    'is_deleted' =>0,
	                    ]);
  }
   /* read message convertion when click first time on message end*/
   $message_record_detail = Emails::where('id',$id)->first();
   $reply_messages=ThreadMailsReply::where('master_message_id',$id)->pluck('sub_message_id')->all();
   $thread_reply_messages=Emails::whereIn('id',$reply_messages)->get();
   $from_mail_access_for = Emails::where('id',$id)->where('from_id',$message_record_detail['from_id'])->select('from_id','to_id')->first();
   $from_mail=User::where('id',$from_mail_access_for['from_id'])->select('email')->first();
   $to_mail=User::where('id',$from_mail_access_for['to_id'])->select('email')->first();
  // return $dummy_page_wise_numbers;
   return view('frontend/employee/mail-box-management/read-message',compact('message_record_detail','from_mail','to_mail','dummy_page_wise_numbers','thread_reply_messages'));
  }


  public function emailData($subdomain,Request $request){
        $term = trim($request->q);
        $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first(); 
        if($request->category == "all"){
          $manager__level_group_ids = User::where('mail_group_manager_id',$manager_id['manager_id'])->pluck('id')->all(); 
          $manager__level_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->where('employee_id', '<>',Auth::user()->id)->pluck('employee_id')->all();
          $manager__level_client_ids = ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
          $manager__level_otherparties_ids = RegisteredOtherParties::where('manager_id',$manager_id['manager_id'])->pluck('other_party_id')->all();
          $collection = collect([$manager__level_employees_ids,$manager__level_client_ids,$manager__level_group_ids,$manager__level_otherparties_ids,[$manager_id['manager_id']]]);
          $collapsed = $collection->collapse();
        }elseif($request->category == "em"){
          $manager__level_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->where('employee_id', '<>',Auth::user()->id)->pluck('employee_id')->all();
          $collection = collect([$manager__level_employees_ids]);
          $collapsed = $collection->collapse();
        }elseif($request->category == "em-admin"){
          $manager__level_admin_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->where('employee_id', '<>',Auth::user()->id)->where('businessmanagers_employee_roles_id',5)->pluck('employee_id')->all();
          $collection = collect([$manager__level_admin_employees_ids]);
          $collapsed = $collection->collapse();
        }elseif($request->category == "em-reception"){
          $manager__level_reception_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->where('employee_id', '<>',Auth::user()->id)->where('businessmanagers_employee_roles_id',6)->pluck('employee_id')->all();
          $collection = collect([$manager__level_reception_employees_ids]);
          $collapsed = $collection->collapse();
        }elseif($request->category == "cl"){
           $manager__level_client_ids = ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
           $collection = collect([$manager__level_client_ids]);
           $collapsed = $collection->collapse();
        }elseif($request->category == "ot"){
           $manager__level_otherparties_ids = RegisteredOtherParties::where('manager_id',$manager_id['manager_id'])->pluck('other_party_id')->all();
           $collection = collect([$manager__level_otherparties_ids]);
           $collapsed = $collection->collapse();
        }else{
          $manager__level_group_ids = User::where('mail_group_manager_id',$manager_id['manager_id'])->pluck('id')->all(); 
          $manager__level_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->where('employee_id', '<>',Auth::user()->id)->pluck('employee_id')->all();
          $manager__level_client_ids = ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
          $manager__level_otherparties_ids = RegisteredOtherParties::where('manager_id',$manager_id['manager_id'])->pluck('other_party_id')->all();
          $collection = collect([$manager__level_employees_ids,$manager__level_client_ids,$manager__level_group_ids,$manager__level_otherparties_ids,[$manager_id['manager_id']]]);
          $collapsed = $collection->collapse();
        } 
    /*   return $collapsed; */
       $tags1 = User::whereIn('id',$collapsed->all())->where('email', 'LIKE', '%'.$term.'%');
       $tags2 = User::whereIn('id',$collapsed->all())->where('name', 'LIKE', '%'.$term.'%');
       $tags = User::whereIn('id',$collapsed->all())->where('surname', 'LIKE', '%'.$term.'%')->union($tags1)->union($tags2)->take(5)->get();
       $formatted_tags = [];
         foreach ($tags as $tag) {
          /*$role_name=Role::where('id',$tag->role_id)->select('role_name')->first();
           if($role_name['role_name'] == 'Super Admin'){
             $role='Admin';
           }elseif($role_name['role_name'] == 'Business Manager'){
            $role='Manager';
           }elseif($role_name['role_name'] == 'Clients'){
            $role='Client';
           }elseif($role_name['role_name'] == 'Staff'){
            $role='Staff';
           }elseif($role_name['role_name'] == 'Other Parties'){
            $role='Other Party';
           } */
          $name= $tag['name'].' '.$tag['surname']; 
          $emil=$tag->email;
          /*$role_with_mail=$emil.' '.'['.$role.']';*/
          $name_with_mail=$emil.' '.'['.$name.']';
          $formatted_tags[] = ['id' => $tag->id, 'text' => $name_with_mail];
        }
        return \Response::json($formatted_tags);
  }

  public function postManagerSendMail($subdomain,Request $request){
  	//return $request->all();
  	$messages = [
        "to.required" => "Please Fill To Address",
	     ];
  	$rules = array(
  		'to' => 'required',
  		'subject' => 'required',
  		'message' => 'required',
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
       $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
		    $receivers_list_array=$request->get('to');
		    $data = $request->all(); 
		    $receivers_list_array=$request->get('to');
        //here i have devied group mail id and normail ids. normail ids directly we can give loop, but group id have to wrtite another loop.
        $direct_send_mail_send_users_records=User::where('mail_group_manager_id',null)->whereIn('id',$receivers_list_array)->pluck('id')->all();
        $group_mail_send_records=MailGroup::whereIn('group_user_id',$receivers_list_array)->where('manager_id',$manager_id['manager_id'])->pluck('group_user_id')->all();
        //above middile side comment two instrections very important
		    if($request->get('drafts') == 'active'){
  		          $is_drafts = 1;
  	         }else{
  	         	  $is_drafts = 0;
  	         }
      //group mail check and send start      
      if(count($group_mail_send_records) != 0){
          foreach($group_mail_send_records as $key => $group_mail_send_record){
            $implode_user_data=MailGroup::where('group_user_id',$group_mail_send_record)->select('selected_ids')->where('manager_id',$manager_id['manager_id'])->first();
            $user_data=explode(',', $implode_user_data['selected_ids']);
                foreach($user_data as $key2 => $user_id){
                  $data = $request->all();
                  $dt = Carbon::now(); 
                  $user=User::where('id',$user_id)->select('email','registration_id')->first();
                  $image= Input::file('attachments');
                  $files = $request->file('attachments');
                  if(!empty($files)){
                    //first time loop attachments will upload and store
                    //second time loop onwards attachments will not upload only store by using seesion name what's the name stored in loop one
                    if($key2 == 0){
                      $data2=[];
                         foreach ($files as $file) {   
                             $filename = $file->getClientOriginalName();
                             $ext = $file->getClientOriginalExtension();
                             $newfilename = substr($filename, 0, strrpos($filename, '.'));
                             $newfilename = uniqid() . '_' . $newfilename . '.' . $ext;
                             $file->move('uploads/mail-attachments', $newfilename);
                             $data2['store_file_names'] = $newfilename;
                             $all_file_names[]=$data2;  
                          }             
                        $dabase_storing_attached_file_names=[];
                           foreach ($all_file_names as $key => $value2) {
                            $dabase_storing_attached_file_names[] = $value2['store_file_names'];    
                           }
                        $attached_file_names = implode(',',$dabase_storing_attached_file_names);
                        Session::put('database_attached_file_names_second_loop', $attached_file_names);
                      }else{
                                     $attached_file_names = Session::get('database_attached_file_names_second_loop');
                      }
                        
                  
                    }else{
                      $attached_file_names ="";
                    }     
                    //return $is_drafts;
                      $manager_record = Emails::create([
                                  'to_id' => $user_id,
                                  'manager_id' => $manager_id['manager_id'],
                                  'common_user_id' => Auth::user()->id,
                                  'from_id' => Auth::user()->id,
                                  'subject' => $data['subject'],
                                  'message' => $data['message'],
                                  'date'=>$dt->toDayDateTimeString(),
                                  'is_drafts'=>$is_drafts,
                                  'email_address'=>$user['email'],
                                  'attachments'=>$attached_file_names,
                                  ]);
                        }

              }
      } 
    //group mail check and send end

      /*direct send mail start*/
			foreach($direct_send_mail_send_users_records as $key => $value){
			  $data = $request->all();
				$dt = Carbon::now(); 
        $user=User::where('id',$value)->select('email','registration_id')->first();
				$image= Input::file('attachments');
				$files = $request->file('attachments');
				if(!empty($files)){
					//first time loop attachments will upload and store
					//second time loop onwards attachments will not upload only store by using seesion name what's the name stored in loop one
					if($key == 0){
						$data2=[];
							 foreach ($files as $file) {	 
						       $filename = $file->getClientOriginalName();
						       $ext = $file->getClientOriginalExtension();
						       $newfilename = substr($filename, 0, strrpos($filename, '.'));
						       $newfilename = uniqid() . '_' . $newfilename . '.' . $ext;
						       $file->move('uploads/mail-attachments', $newfilename);
						       $data2['store_file_names'] = $newfilename;
						       $all_file_names[]=$data2;	
							  }							
							$dabase_storing_attached_file_names=[];
								 foreach ($all_file_names as $key => $value2) {
								 	$dabase_storing_attached_file_names[] = $value2['store_file_names'];	 	
								 }
							$attached_file_names = implode(',',$dabase_storing_attached_file_names);
							Session::put('database_attached_file_names_second_loop', $attached_file_names);
						}else{
                           $attached_file_names = Session::get('database_attached_file_names_second_loop');
						}	
				}else{
					$attached_file_names ="";
				}			
				//return $is_drafts;
			    $manager_record = Emails::create([
	                    'to_id' => $value,
	                    'manager_id' => Auth::user()->id,
	                    'common_user_id' => Auth::user()->id,
	                    'from_id' => Auth::user()->id,
	                    'subject' => $data['subject'],
	                    'message' => $data['message'],
	                    'date'=>$dt->toDayDateTimeString(),
	                    'is_drafts'=>$is_drafts,
	                    'email_address'=>$user['email'],
	                    'attachments'=>$attached_file_names,
	                    ]);
			} 
      /*direct send mail end*/
			$url = url('employee/mail-box');
	      if ($request->ajax()) {
	        return response()->json(array(
	          'success' => 'Message hasbeen sent successfully...',
	          'modal' => true,
	          'redirect_url' => $url,
	          'status' => 200,
	          ), 200);
	      }else{
	        return redirect()->intended($url)->with('success', 'Message hasbeen sent successfully...');
	      }
	   }
    
  }

  public function trash($subdomain,Request $request){
     //return $request->all();
   // return TrashMails::all();
   $trash_records=Emails::whereIn('id',$request->get('selected'))->select('id')->get();
     foreach ($trash_records as $key => $trash_record) {
     	//return $trash_record;
        $move_to_trash = TrashMails::create([
	                    'email_table_id' => $trash_record['id'],
	                    'user_id' => Auth::user()->id,
	                    'page_name' =>$request->get('page_name'),
	                    'is_active' =>1,
	                    'is_deleted' =>1,
	                    ]);
     }
     return redirect()->back();  
  }
  public function getDetailMessageTrash($subdomain,Request $request){
   $trash_detail_message_record=Emails::where('id',$request->get('detail_message'))->select('id')->first();
   $move_to_trash = TrashMails::create([
                      'email_table_id' => $trash_detail_message_record['id'],
                      'user_id' => Auth::user()->id,
                      'is_active' =>1,
                      'is_deleted' =>1,
                      ]);
    if($request->get('page_name') == 1 || $request->get('page_name') == 2){
       return redirect()->to('employee/mail-box');
    }elseif($request->get('page_name') == 3){
       return redirect()->to('employee/sent-items');
    }elseif($request->get('page_name') == 4){
       return redirect()->to('employee/drafts');
    }elseif($request->get('page_name') == 6){
       return redirect()->to('employee/important-message');
    }     
  }

  public function important($subdomain,$id){
      $manager_important_message_check=ImportantMails::where('user_id',Auth::user()->id)->where('email_table_id',$id)->first();
      if(count($manager_important_message_check) == 0){
      	 $important_message_save = ImportantMails::create([
                    'email_table_id' => $id,
                    'user_id' => Auth::user()->id,
                    'is_important' =>1,
                    'is_deleted' =>1,
                    ]);
      }else{
         $manager_important_message_check->delete();
      }    
    
     return redirect()->back();  
  }

  public function restore($subdomain,$id){
  	$restore_message=TrashMails::where('email_table_id',$id)->where('user_id',Auth::user()->id)->first();
	   
	$restore_message->delete(); 
	return redirect()->back();
  }

  public function perminentDelete($subdomain,Request $request){
  	  //return $request->get('selected');
  	//below first two queries are from cooming side(Inbox) and going side messages delete(sent items, drafts)
  	 /* $master_email_table_sender_side_messages=Emails::whereIn('id',$request->get('selected'))->where('common_user_id',Auth::user()->id)->delete();
  	  $master_email_table_reply__form_out_side_messages=Emails::whereIn('id',$request->get('selected'))->where('to_id',Auth::user()->id)->delete();
	   $trash_table_record_found=TrashMails::whereIn('email_table_id',$request->get('selected'))->where('user_id',Auth::user()->id)->delete();
	   $important_table_record_found=ImportantMails::whereIn('email_table_id',$request->get('selected'))->where('user_id',Auth::user()->id)->delete();*/
	   //return 'hi';

      $trash_table_record_found=TrashMails::whereIn('email_table_id',$request->get('selected'))->where('user_id',Auth::user()->id)->get();
      foreach($trash_table_record_found as $trash_table_record){
        $trash=TrashMails::where('id',$trash_table_record->id)->first();
        $trash->update([
                        'is_perminant_delete'=>1,
                      ]);                 
       }
	   return redirect()->back();
  } 
  public function getDetailMessagePerminantDelete($subdomain,Request $request){
  	  //return $request->get('page_name');
  	  //return $request->get('detail_message');
  	  //below first two queries are from cooming side(Inbox) and going side messages delete(sent items, drafts)
  	 $master_email_table=Emails::where('id',$request->get('detail_message'))->where('common_user_id',Auth::user()->id)->delete();
  	   $master_email_table_reply__form_out_side_messages=Emails::where('id',$request->get('detail_message'))->where('to_id',Auth::user()->id)->delete();
	   $trash_table_record_found=TrashMails::where('email_table_id',$request->get('detail_message'))->where('user_id',Auth::user()->id)->delete();
	   $important_table_record_found=ImportantMails::where('email_table_id',$request->get('detail_message'))->where('user_id',Auth::user()->id)->delete();
	    return redirect()->to('employee/trash');
  }

  public function getReplyMessage($subdomain,$hash_message_id,$hash_page_name){
      $message_id = Hashids::decode($hash_message_id)[0];
      $page_name_dummy_number = Hashids::decode($hash_page_name)[0];
      $reply_to_message_record= Emails::where('id',$message_id)->first();

    return view('frontend/employee/mail-box-management/reply-message',compact('reply_to_message_record','message_id','page_name_dummy_number'));
  }
  public function postReplyMessage($subdomain,Request $request){
    $messages = [
        "to.required" => "Please Fill To Address",
       ];
  $rules = array(
    'to' => 'required',
    'subject' => 'required',
    'message' => 'required',
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
       $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first(); 
        $receivers_list_array=$request->get('to');
        $data = $request->all(); 
        $receivers_list_array=$request->get('to');
        //here i have devied group mail id and normail ids. normail ids directly we can give loop, but group id have to wrtite another loop.
        $direct_send_mail_send_users_records=User::where('mail_group_manager_id',null)->whereIn('id',$receivers_list_array)->pluck('id')->all();
        $group_mail_send_records=MailGroup::whereIn('group_user_id',$receivers_list_array)->where('manager_id',$manager_id['manager_id'])->pluck('group_user_id')->all();
        //above middile side comment two instrections very important
        if($request->get('drafts') == 'active'){
                $is_drafts = 1;
             }else{
                $is_drafts = 0;
             }
      //group mail check and send start      
      if(count($group_mail_send_records) != 0){
          foreach($group_mail_send_records as $key => $group_mail_send_record){
            $implode_user_data=MailGroup::where('group_user_id',$group_mail_send_record)->select('selected_ids')->where('manager_id',$manager_id['manager_id'])->first();
            $user_data=explode(',', $implode_user_data['selected_ids']);
                foreach($user_data as $key2 => $user_id){
                  $data = $request->all();
                  $dt = Carbon::now(); 
                  $user=User::where('id',$user_id)->select('email','registration_id')->first();
                  $image= Input::file('attachments');
                  $files = $request->file('attachments');
                  if(!empty($files)){
                    //first time loop attachments will upload and store
                    //second time loop onwards attachments will not upload only store by using seesion name what's the name stored in loop one
                    if($key2 == 0){
                      $data2=[];
                         foreach ($files as $file) {   
                             $filename = $file->getClientOriginalName();
                             $ext = $file->getClientOriginalExtension();
                             $newfilename = substr($filename, 0, strrpos($filename, '.'));
                             $newfilename = uniqid() . '_' . $newfilename . '.' . $ext;
                             $file->move('uploads/mail-attachments', $newfilename);
                             $data2['store_file_names'] = $newfilename;
                             $all_file_names[]=$data2;  
                          }             
                        $dabase_storing_attached_file_names=[];
                           foreach ($all_file_names as $key => $value2) {
                            $dabase_storing_attached_file_names[] = $value2['store_file_names'];    
                           }
                        $attached_file_names = implode(',',$dabase_storing_attached_file_names);
                        Session::put('database_attached_file_names_second_loop', $attached_file_names);
                      }else{
                                     $attached_file_names = Session::get('database_attached_file_names_second_loop');
                      }
                        
                  
                    }else{
                      $attached_file_names ="";
                    }     
                    //return $is_drafts;
                    $reply_message = Emails::create([
                      'to_id' => $user_id,
                      'manager_id' =>$manager_id['manager_id'],
                      'common_user_id' => Auth::user()->id,
                      'from_id' => Auth::user()->id,
                      'subject' => $data['subject'],
                      'message' => $data['message'],
                      'date'=>$dt->toDayDateTimeString(),
                      'is_drafts'=>$is_drafts,
                      'email_address'=>$user['email'],
                      'attachments'=>$attached_file_names,
                      'master_message_id'=>$data['master_message_id'],
                      ]);
                  $reply_manager_thread = ThreadMailsReply::create([
                      'master_message_id' => $data['master_message_id'],
                      'sub_message_id' => $reply_message['id'],
                      ]);
                        }

              }
      } 
    //group mail check and send end

      foreach($direct_send_mail_send_users_records as $key => $value){
        $data = $request->all();
        $dt = Carbon::now(); 
                $user=User::where('id',$value)->select('email','registration_id')->first();
        $image= Input::file('attachments');
        $files = $request->file('attachments');
        if(!empty($files)){
          //first time loop attachments will upload and store
          //second time loop onwards attachments will not upload only store by using seesion name what's the name stored in loop one
          if($key == 0){
            $data2=[];
               foreach ($files as $file) {   
                   $filename = $file->getClientOriginalName();
                   $ext = $file->getClientOriginalExtension();
                   $newfilename = substr($filename, 0, strrpos($filename, '.'));
                   $newfilename = uniqid() . '_' . $newfilename . '.' . $ext;
                   $file->move('uploads/mail-attachments', $newfilename);
                   $data2['store_file_names'] = $newfilename;
                   $all_file_names[]=$data2;  
                }             
              $dabase_storing_attached_file_names=[];
                 foreach ($all_file_names as $key => $value2) {
                  $dabase_storing_attached_file_names[] = $value2['store_file_names'];    
                 }
              $attached_file_names = implode(',',$dabase_storing_attached_file_names);
              Session::put('database_attached_file_names_second_loop', $attached_file_names);
            }else{
                           $attached_file_names = Session::get('database_attached_file_names_second_loop');
            }
              
              
        }else{
          $attached_file_names ="";
        }     
        //return $is_drafts;
          $reply_message = Emails::create([
                      'to_id' => $value,
                      'manager_id' =>$manager_id['manager_id'],
                      'common_user_id' => Auth::user()->id,
                      'from_id' => Auth::user()->id,
                      'subject' => $data['subject'],
                      'message' => $data['message'],
                      'date'=>$dt->toDayDateTimeString(),
                      'is_drafts'=>$is_drafts,
                      'email_address'=>$user['email'],
                      'attachments'=>$attached_file_names,
                      'master_message_id'=>$data['master_message_id'],
                      ]);
          $reply_manager_thread = ThreadMailsReply::create([
                      'master_message_id' => $data['master_message_id'],
                      'sub_message_id' => $reply_message['id'],
                      ]);
      } 
       $url = url('employee/mail-box');
        if ($request->ajax()) {
          return response()->json(array(
            'success' => 'Message hasbeen sent successfully...',
            'modal' => true,
            'redirect_url' => $url,
            'status' => 200,
            ), 200);
        }else{
          return redirect()->intended($url)->with('success', 'Message hasbeen sent successfully...');
        }
     }
  }
//group creation in messaging start
  public function manageGroup(){
    $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
    $mail_group= User::join('email_group as info', 'info.group_user_id', '=', 'users.id')
                   ->where('info.manager_id',$manager_id['manager_id'])
                   ->select('*','users.id as user_table_id','users.mail_group_manager_id as user_table_store_manager_id','info.id as email_group_table_id','info.manager_id as email_group_table_store_manager_id')
                   ->get();
    //$mail_group=MailGroup::all();
    return view('frontend/employee/mail-box-management/manage-group',compact('mail_group'));
  }

  public function addGroup(){
      $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
     $manager__level_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->where('employee_id', '<>', Auth::user()->id)->pluck('employee_id')->all();
      $employees = User::whereIn('id',$manager__level_employees_ids)->select('id','email','name','surname','role_id')->get();
    
      $manager__level_clients_ids = ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
      $clients = User::whereIn('id',$manager__level_clients_ids)->select('id','email','name','surname','role_id')->get();
     
      $manager__level_other_parties_ids = RegisteredOtherParties::where('manager_id',$manager_id['manager_id'])->pluck('other_party_id')->all();
      $other_parties = User::whereIn('id',$manager__level_other_parties_ids)->select('id','email','name','surname','role_id')->get();
      return view('frontend/employee/mail-box-management/add-group',compact('employees','clients','other_parties'));
  }

  public function storeGroup($subdomain,Request $request){
    $rules = array(
    'group_name' => 'required',
    'email' => 'required|alpha_num',
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
            $mail_complete_attached_word=$request->get('email').'@intellcomm.com';
            $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
            $record = User::where('name',$request->get('group_name'))->where('mail_group_manager_id',$manager_id['manager_id'])->first();
                 if(count($record) != 0){
                  $url = url('employee/create-group');
                  if ($request->ajax()) {
                     $validator->errors()->add("login_error", "Already this group name existed");
                      return response()->json($validator->getMessageBag(), 301);
                     }else{
                      return redirect()->back() ->withInput()->with('fail', 'Already this group name existed');
                     }  
            }

            $record = User::where('email',$mail_complete_attached_word)->where('mail_group_manager_id',$manager_id['manager_id'])->first();
                 if(count($record) != 0){
                  $url = url('employee/create-group');
                  if ($request->ajax()) {
                     $validator->errors()->add("login_error", "Already this group email existed");
                      return response()->json($validator->getMessageBag(), 301);
                     }else{
                      return redirect()->back() ->withInput()->with('fail', 'Already this group email existed');
                     }  
            }
            $data['employee']="";
            $data['clients']="";
            $data['otherparties']="";
            $data= $request->all();
            if(empty($data['employee']) && empty($data['clients']) && empty($data['otherparties'])){
                  $url = url('employee/add-group');
                  if ($request->ajax()) {
                     $validator->errors()->add("login_error", "Please Select Any User");
                      return response()->json($validator->getMessageBag(), 301);
                     }else{
                      return redirect()->back() ->withInput()->with('fail', 'Please Select Any User');
                     }           
            }
            if(isset($data['employee'])){
              $employee_list=$data['employee'];
            }else{
              $employee_list=[];
            }

            if(isset($data['clients'])){
              $client_list=$data['clients'];
            }else{
              $client_list=[];
            }
            if(isset($data['otherparties'])){
              $other_party_list=$data['otherparties'];
            }else{
              $other_party_list=[];
            }
            $result = array_merge($employee_list,$client_list,$other_party_list);
            $all_group_users = implode(",",$result);

            /*$collection = collect([$employee_list,$client_list,$other_party_list]);
            $collapsed = $collection->collapse();*/
            $user_table_store_group = User::create([
                              'name'=>$data['group_name'],
                              'email'=>$data['email'],
                              'mail_group_manager_id'=>$manager_id['manager_id'],
                              'mail_group_common_user_id'=>Auth::user()->id,
                              'mail_group_email_first_name'=>$data['email'],
                            ]); 

            $message_table_store_group = MailGroup::create([
                              'group_user_id'=>$user_table_store_group->id,
                              'selected_ids'=>$all_group_users,
                              'manager_id'=>$manager_id['manager_id'],
                            ]);                                   
            $url = url('employee/manage-group');
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

  public function editGroup($subdomain,$hashgroupid){
    $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
    $group_id = Hashids::decode($hashgroupid)[0];
   $manager__level_employees_ids = Employee::where('manager_id',$manager_id['manager_id'])->where('employee_id', '<>', Auth::user()->id)->pluck('employee_id')->all();
      $employees = User::whereIn('id',$manager__level_employees_ids)->select('id','email','name','surname','role_id')->get();
    $employees = User::whereIn('id',$manager__level_employees_ids)->select('id','email','name','surname','role_id')->get();

    $manager__level_clients_ids = ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
    $clients = User::whereIn('id',$manager__level_clients_ids)->select('id','email','name','surname','role_id')->get();
   
    $manager__level_other_parties_ids = RegisteredOtherParties::where('manager_id',$manager_id['manager_id'])->pluck('other_party_id')->all();
    $other_parties = User::whereIn('id',$manager__level_other_parties_ids)->select('id','email','name','surname','role_id')->get();

    $record= User::join('email_group as info', 'info.group_user_id', '=', 'users.id')
                   ->where('users.id',$group_id) 
                   ->where('info.manager_id',$manager_id['manager_id'])
                   ->select('*','users.id as user_table_id','users.mail_group_manager_id as user_table_store_manager_id','info.id as email_group_table_id','info.manager_id as email_group_table_store_manager_id')
                   ->first();

   // $record=MailGroup::where('id',$group_id)->first();
   // return $record['selected_ids'];
    return view('frontend/employee/mail-box-management/edit-group',compact('employees','clients','other_parties','record','data'));
  }

  public function posteditGroup($subdomain,Request $request){
    $rules = array(
    'group_name' => 'required',
    'email' => 'required|alpha_num',
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
            $mail_complete_attached_word=$request->get('email').'@intellcomm.com';
            $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
            $data['employee']="";
            $data['clients']="";
            $data['otherparties']="";
            $data= $request->all();
             if($data['group_name'] != $data['hidden_group_name']){
                 $record = User::where('name',$data['group_name'])->where('mail_group_manager_id',$manager_id['manager_id'])->first();
                 if(count($record) != 0){
                  $url = url('employee/edit-group');
                  if ($request->ajax()) {
                     $validator->errors()->add("login_error", "Already this group name existed");
                      return response()->json($validator->getMessageBag(), 301);
                     }else{
                      return redirect()->back() ->withInput()->with('fail', 'Already name group email existed');
                     }  
                 }
             }

             if($mail_complete_attached_word != $data['hidden_email']){
                 $record = User::where('email',$mail_complete_attached_word)->where('mail_group_manager_id',$manager_id['manager_id'])->first();
                 if(count($record) != 0){
                  $url = url('employee/edit-group');
                  if ($request->ajax()) {
                     $validator->errors()->add("login_error", "Already this group email existed");
                      return response()->json($validator->getMessageBag(), 301);
                     }else{
                      return redirect()->back() ->withInput()->with('fail', 'Already this group email existed');
                     }  
                 }
             }
            if(empty($data['employee']) && empty($data['clients']) && empty($data['otherparties'])){
                  $url = url('employee/edit-group');
                  if ($request->ajax()) {
                     $validator->errors()->add("login_error", "Please Select Any User");
                      return response()->json($validator->getMessageBag(), 301);
                     }else{
                      return redirect()->back() ->withInput()->with('fail', 'Please Select Any User');
                     }           
            }
            if(isset($data['employee'])){
              $employee_list=$data['employee'];
            }else{
              $employee_list=[];
            }

            if(isset($data['clients'])){
              $client_list=$data['clients'];
            }else{
              $client_list=[];
            }
            if(isset($data['otherparties'])){
              $other_party_list=$data['otherparties'];
            }else{
              $other_party_list=[];
            }
            $result = array_merge($employee_list,$client_list,$other_party_list);
            $all_group_users = implode(",",$result);
            $record_user = User::where('id',$data['group_id'])->first();
            $record_user->update([
                              'name'=>$data['group_name'],
                              'email'=>$mail_complete_attached_word,
                              'mail_group_email_first_name'=>$data['email'],
                            ]); 
            $record_ail_group = MailGroup::where('group_user_id',$data['group_id'])->first();
            $record_ail_group->update([
                              'selected_ids'=>$all_group_users,
                            ]);                                                          
            $url = url('employee/manage-group');
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
    //return $id;
    $record=User::where('id',$id)->first();
    $record->delete();
    $record=MailGroup::where('group_user_id',$id)->first();
    $record->delete();
    return response()->json($record);
  }

}







