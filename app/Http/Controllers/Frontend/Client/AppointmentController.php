<?php

namespace App\Http\Controllers\Frontend\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SecurityQuestions;
use App\Models\Appointments;
use App\Models\BusinessProfessionCategory;
use App\Models\BusinessProfessionTypes;
use App\Models\ManagerClients;
use App\Models\ManagerBusinessDetails;
use App\Models\ManagerAlternativeAccountFindingTable;
use App\Models\Employee;
use App\Models\NotesCategory;
use App\Models\ClientNotes;
use App\Models\RegisteredOtherParties;
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
class AppointmentController extends Controller {

	public function index(){ 
		 $manager_id = ManagerClients::where('client_id',Auth::user()->id)->select('manager_id')->first();
		 $my_appointments = Appointments::where('client_id',Auth::user()->id)->where('manager_id',$manager_id['manager_id'])->get();
		 $data=[];
		 foreach ($my_appointments as $key => $appointments) {
		 	 $practionar=User::where('id',$appointments['practionar_id'])->first();
		 	 $start_date_time = $appointments['start_date_time'];
		 	 $end_date_time = $appointments['end_date_time'];
	         $data['practionar_name']=$practionar['name'];
	         $data['practionar_surname']=$practionar['surname'];
	         $data['date']=$start_date = date_format($start_date_time,"m/d/Y");
             $data['start_time']=date('h:i A', strtotime($start_date_time));
             $data['end_time']=date('h:i A', strtotime($end_date_time));
            /* $date = new Carbon;
			 if($date > $start_date_time)
			 {
				$data['progress']='';
			 } else {
				$data['progress']='Expired';
			 }*/
			/* $now = Carbon::now();
			return $start_date = Carbon::parse($start_date_time);
			$end_date = Carbon::parse($end_date_time);
			if($now->between($start_date,$end_date)){
			   $data['progress']='Acitve';
			} else {
			   $data['progress']='Expired';
			}*/
             $all_data[]=$data;
		 }
		return view('frontend/client/appointments/appointments',compact('all_data'));
	}
}







