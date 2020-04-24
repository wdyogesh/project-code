<?php

namespace App\Http\Controllers\Frontend\Employee;
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
use App\Models\Attachments;
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
class AttachmentsController extends Controller {
   public function index($subdomain,$hashclienthid,$attachmentheading=NULL){
       $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
       $client_id = Hashids::decode($hashclienthid)[0];
       $fileter_attachment_headings=Attachments::where('manager_id',$manager_id['manager_id'])->where('client_id',$client_id)->get();
       if($attachmentheading == ""){
          $attachments=Attachments::where('manager_id',$manager_id['manager_id'])->where('client_id',$client_id)->get();
       }else{
         $attachments=Attachments::where('manager_id',$manager_id['manager_id'])->where('client_id',$client_id)->where('heading',$attachmentheading)->get();
       }
      
       $client_record= User::where('id',$client_id)->first();
      return view('frontend/employee/notes/attachments',compact('client_record','attachments','fileter_attachment_headings'));
  }

  public function createAttachment($subdomain,$hashclienthid){
       $client_id = Hashids::decode($hashclienthid)[0];
       $client_record= User::where('id',$client_id)->first();
      return view('frontend/employee/notes/add-attachment',compact('client_record'));
  }
  public function postAttachment($subdomain,Request $request){
    $messages = [
        "heading.required" => "Heading required.",
        "file.required" => "File required",
       ];
      $rules = array(
        'heading' => 'required',
        'file' => 'required',
    );
    if($request->file('file')){
            $rules = array_add($rules, 'file', 'required|max:10000');
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
      $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
      $client_registration_id=User::where('id',$data['client_name'])->select('registration_id')->first();
      $dt = Carbon::now();
      $files = $request->file('file');
      $newfilename="";
      if(!empty($files)){
           $filename = $files->getClientOriginalName();
           $ext = $files->getClientOriginalExtension();
           $newfilename = substr($data['heading'], 0, strrpos($filename, '.'));
           $newfilename = $newfilename . '_' . $client_registration_id['registration_id'] . '_' . uniqid() . '.' . $ext;
           $files->move('uploads/attachments', $newfilename);
        }
            $client_record = Attachments::create([
                                'heading'=>$data['heading'],
                                'client_id'=>$data['client_name'],
                                'file'=>$newfilename,
                                'manager_id'=>$manager_id['manager_id'],
                                'common_user_id'=>Auth::user()->id,
                                'created_record_date'=>$dt->toDayDateTimeString(),
                            ]);

      $url = url('employee/client-attachments/'.Hashids::encode($data['client_name']));
      if ($request->ajax()){
              return response()->json(array(
                'success' => 'Attachment Uploaded Successfully',
                'modal' => true,
                'redirect_url' => $url,
                'status' => 200,
                ), 200);
          }else{
              return redirect()->intended($url)->with('success', 'Attachment Uploaded Successfully');
          }           
    }
       
  } 

   public function editAttachment($subdomain,$attachmentid,$hashclienthid){
       $client_id = Hashids::decode($hashclienthid)[0];
       $attachment_id = Hashids::decode($attachmentid)[0];
       $client_record= User::where('id',$client_id)->first();
       $attachment_record=Attachments::where('id',$attachment_id)->first();
      return view('frontend/employee/notes/edit-attachment',compact('client_record','attachment_record'));
  }

  public function updateAttachment($subdomain,Request $request){
     $messages = [
        "heading.required" => "Heading required.",
        "file.required" => "File required",
       ];
      $rules = array(
        'heading' => 'required',
       /* 'file' => 'required',*/
      );
    if($request->file('file')){
            $rules = array_add($rules, 'file', 'required|max:10000');
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
           $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
           $client_record= User::where('id',$data['client_name'])->first();
            $dt = Carbon::now();
            $files = $request->file('file');
            $newfilename="";
            $client_attachment_record = Attachments::findOrFail($data['attached_record_id']);
             if(!empty($files)){
                 $filename = $files->getClientOriginalName();
                 $ext = $files->getClientOriginalExtension();
                 $newfilename = substr($data['heading'], 0, strrpos($filename, '.'));
                 $newfilename = $newfilename . '_' . $client_record['registration_id'] . '_' . uniqid() . '.' . $ext;
                 $files->move('uploads/attachments', $newfilename);
             }else{
                 $newfilename =$data['attached_file_name'];
             }
            $client_attachment_record->update([
                                'heading'=>$data['heading'],
                                'client_id'=>$data['client_name'],
                                'file'=>$newfilename,
                                'manager_id'=>$manager_id['manager_id'],
                                'common_user_id'=>Auth::user()->id,
                                'updated_record_date'=>$dt->toDayDateTimeString(),
                            ]);
       $url = url('employee/client-attachments/'.Hashids::encode($data['client_name']));
      if ($request->ajax()){
              return response()->json(array(
                'success' => 'Attachment Updated Successfully',
                'modal' => true,
                'redirect_url' => $url,
                'status' => 200,
                ), 200);
          }else{
              return redirect()->intended($url)->with('success', 'Attachment Updated Successfully');
          }
      
              
    }
    
  }

  public function deleteAttachment($subdomain,$id){
      $record=Attachments::where('id',$id)->first();
      $record->delete();
      return response()->json($record);
    }
 

}







