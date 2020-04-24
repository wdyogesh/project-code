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
use App\Models\Role;
use App\Models\Ticketings;
use App\Models\TicketMessages;
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
class TicketingController extends Controller {
    
	public function index(){
	    $my_tickets= Ticketings::all();
		return view('admin/ticket-management/my-tickets',compact('my_tickets'));
	}

   /* public function create(){   
		return view('admin/ticket-management/create-ticket');
	}*/

	/*public function send(Request $request){
		$rules = array(
		'category' => 'required',
		'subject' => 'required',
		'problem' => 'required',
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
		    $ticket_record = Ticketings::create([
                            	'ticket_id'=> strtoupper("BM".date('dmHis')),
                            	'subject'=>$data['subject'],
                            	'manager_id'=>Auth::user()->id,
	                            'category'=>$data['category'],
	                            'status'=>'Not Opened',
	                            'record_created_date'=>$dt->toDayDateTimeString(),
	                            'record_updated_date'=>$dt->toDayDateTimeString(),
		                        ]);
		        $files = $request->file('attachments');
				if(!empty($files)){
				       $filename = $files->getClientOriginalName();
				       $ext = $files->getClientOriginalExtension();
				       $newfilename = substr($filename, 0, strrpos($filename, '.'));
				       $newfilename = uniqid() . '_' . $newfilename . '.' . $ext;
				       $files->move('uploads/ticketing-documents', $newfilename);
				   }else{
					   $newfilename ="";
				   }			
		    $client_addess = TicketMessages::create([
                            	'ticket_id'=>$ticket_record->id,
                            	'message'=>$data['problem'],
                            	'manager_id'=>Auth::user()->id,
                            	'common_user_id'=>Auth::user()->id,
                            	'admin_id'=>1,
	                            'attachments'=>$newfilename,
	                            'record_created_date'=>$dt->toDayDateTimeString(),
	                            'record_updated_date'=>$dt->toDayDateTimeString(),
	                            ]);                             			
			$url = url('manager/my-tickets');
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Ticket Created Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url)->with('success', 'Ticket Created Successfully');
	        }
	    
			        
		}
    }
*/
    public function thread($ticketid){
    	$ticket_id = Hashids::decode($ticketid)[0];
    	$main_ticket=Ticketings::where('id',$ticket_id)->first();
    	$main_ticket->update([
	                            'status'=>'Open',
		                    ]);
		$thread = TicketMessages::where('ticket_id',$ticket_id)->orderBy('created_at', 'asc')->get();
		$data=[];
		foreach($thread as $thread_messsage){
		  $data['message']=$thread_messsage['message'];
		  $data['file']=$thread_messsage['attachments'];
		  $data['created_date']=$thread_messsage['record_created_date'];
          $communticate_user_id=$thread_messsage['common_user_id'];
          $user=User::where('id',$communticate_user_id)->first();
          $data['name']=$user['name'].' '.$user['surname'];
          $main_thread[]=$data;
		}
		//dd($main_thread);
        return view('admin/ticket-management/ticket-thread',compact('main_ticket','main_thread'));
    }


    public function reply(Request $request){
		//return $request->all(); 
		$rules = array(
		'problem' => 'required',
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
			$hash_ticket_id=Hashids::encode($data['ticket_id']);          
            $dt = Carbon::now();
            $ticketing=Ticketings::where('id',$data['ticket_id'])->first();
		    $ticketing->update([
	                            'record_updated_date'=>$dt->toDayDateTimeString(),
		                      ]);
		    $files = $request->file('attachments');
			if(!empty($files)){
			       $filename = $files->getClientOriginalName();
			       $ext = $files->getClientOriginalExtension();
			       $newfilename = substr($filename, 0, strrpos($filename, '.'));
			       $newfilename = uniqid() . '_' . $newfilename . '.' . $ext;
			       $files->move('uploads/ticketing-documents', $newfilename);
			   }else{
				   $newfilename ="";
			   }			
		    $client_addess = TicketMessages::create([
                            	'ticket_id'=>$ticketing->id,
                            	'message'=>$data['problem'],
                            	'manager_id'=>Auth::user()->id,
                            	'common_user_id'=>Auth::user()->id,
                            	'admin_id'=>1,
	                            'attachments'=>$newfilename,
	                            'record_created_date'=>$dt->toDayDateTimeString(),
	                            'record_updated_date'=>$dt->toDayDateTimeString(),
	                            ]);                             			
			$url = url('admin/open-thread/'.$hash_ticket_id);
			if ($request->ajax()){
	            return response()->json(array(
	              'success' => 'Ticket Created Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
	        }else{
	            return redirect()->intended($url)->with('success', 'Ticket Created Successfully');
	        }
	    
			        
		}
    }


    public function closedTicket($id){
         $ticketing=Ticketings::where('id',$id)->first();
		 $ticketing->update([
	                          'closed'=>1,
	                          'status'=>'Closed',
		                   ]);
		 return redirect()->back();
    }



   
  	                  
}







