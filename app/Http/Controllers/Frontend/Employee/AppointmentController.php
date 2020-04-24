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
use App\Models\Employee;
use App\Models\UserAddresses;
use App\Models\ManagerAlternativeAccountFindingTable;
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
  
  /**
   * Show the appointments in calendar view in business manager level.
    @Author: 
    @Date:
    @Name:
    @Retunn Type
    @Return variables
    @Desc
    @Name of the function
    @Paramters
  */  
  public function index($subdoamin,$hashid = 'jR'){
    $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
    $id = Hashids::decode($hashid)[0];
    $face_to_face_consultation_with_client=Employee::where('businessmanagers_employee_roles_id',8)->where('manager_id',$manager_id['manager_id'])->pluck('employee_id')->all();
    $practitioners=User::whereIn('id',$face_to_face_consultation_with_client)->get();
    //return $id;
    $weekend = $id == 5?false:true;
    $manager__level_client_ids = ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
    $managers_clients = User::whereIn('id',$manager__level_client_ids)->get();
    $managers_clients_edit_page = User::whereIn('id',$manager__level_client_ids)->get();
    $data = Appointments::join('users as info', 'info.id', '=', 'appointments.client_id')
                        ->where('appointments.manager_id',$manager_id['manager_id'])
                        ->where('cancellation',NULL)
                        ->select('*','appointments.id as appointment_id')
                        ->get();
    $events = [];
    // return $data = Appointments::all();
    if($data->count()){
        foreach ($data as $key => $value) {
          $events[] = \Calendar::event(
              $value->email,
              false,
              new \DateTime($value->start_date_time),
              new \DateTime($value->end_date_time),
              $value->appointment_id,
              [
             /* 'url' => url('manager/show-appointment-details', $value->appointment_id),*/
              'color' => 'brown',
              //any other full-calendar supported parameters
              ]
          );
        }
    }
    $calendar = \Calendar::addEvents($events) //add an array with addEvents
                         ->setOptions([
                                     
               
            
                    'defaultView' => 'agendaDays',
                    'views' => [
                                'agendaDays' => [
                                              'weekends'=>$weekend,
                                              'type' => 'agenda',
                                              'allDaySlot'=>false,
                                              'minTime'=> "07:00:00",
                                              'maxTime'=> "20:00:00", 
                                              'slotDuration'=> "00:15:00", 
                                              'duration' => [
                                                    'days'=> $id,
                                                           ],          
                                                 ]
                                ]

                          ])

                         ->setCallbacks([
                                'eventClick' => 'function(event, jsEvent, view){
                                     var data = event.id; 
                                      
                                      $.ajax({
                                         type : "GET",
                                         url : "/employee/client-info",
                                         data: {appointment_id:data},
                                         success: function(data) {
                                          console.log(data.appointment_id);
                                          $("#modalpractionarname").html(data.practionar_name);
                                          $("#modalTitle").html(data.name);
                                          $("#modalEmail").html(data.email);
                                          $("#modalPhone").html(data.phone_number);
                                          $("#modalAppointmentDate").html(data.appointment_date);
                                          $("#modalStartTime").html(data.start_time);
                                          $("#modalEndTime").html(data.end_time);
                                          $("#modalAppointmentId").val(data.appointment_id);
                                          $("#modalCancelAppointmentId").val(data.appointment_id);
                                          $("#AppointmentId").val(data.appointment_id);
                                          $("#clientId").val(data.client_id);
                                          $("#modaldefault").modal("hide");
                                          $("#calendarModal").modal();
                                          $("#read").show();
                                          $("#record-edit").hide();
                                          },
                                         error :  function(data)
                                         {
                                           alert("error");

                                         }
                                      });
                                      
                                   }'
                              ]);
     $countries = DB::table("countries")->pluck("name","id");                            
    return view('frontend/employee/appointment-management/manage-appointments',compact('calendar','managers_clients','managers_clients_edit_page','countries','practitioners','manager_id'));
  }


  /**
   * Show Appointment Details.
   *
   * @param  Request  $request
   * @return Response $data
  */
  public function clientinfo($subdoamin,Request $request){

      $client_appointment_details = Appointments::join('users as info', 'info.id', '=', 'appointments.client_id')
                                  ->where('appointments.id', $request->get('appointment_id'))
                                  ->select('*','appointments.id as appointment_id')
                                  ->first();
      $start_date_time = $client_appointment_details->start_date_time;
      $start_date = date_format($start_date_time,"m/d/Y");
      $start_time=date('h:i A', strtotime($start_date_time));
      $end_date_time = $client_appointment_details->end_date_time;
      $end_time=date('h:i A', strtotime($end_date_time));
      $data=[];
      $data['appointment_id']=$client_appointment_details->appointment_id;
      $practionar_record=User::where('id',$client_appointment_details->practionar_id)->first();
      $data['practionar_name']=$practionar_record['name'];
      $data['client_id']=$client_appointment_details->client_id;
      $data['name']=$client_appointment_details->name;
      $data['email']=$client_appointment_details->email;
      $data['phone_number']=$client_appointment_details->phone_number;
      $data['appointment_date']=$start_date;
      $data['start_time']=$start_time;
      $data['end_time']=$end_time;
      return $data;
  }

  /**
   * Store Appointment Details.
   *
   * @param  Request  $request
   * @return Response
   */
  public function store($subdoamin,Request $request){
   $messages = [
                  "client_id.required" => "Please Select Client Name.",
                  "employee_practitioner_id.required" => "Please select Practitioner.",
                ];
    $rules = array(
                  'employee_practitioner_id' => 'required',
                  'appointment_date' => 'required|date|after:yesterday',
                  'start_time' => 'required',
                  'end_time' => 'required|after:start_time',
                 );
    if($request->get('checkbox') == 1) {
        $rules = array_add($rules, 'client_name', 'required');
        $rules = array_add($rules, 'surname', 'required');
        $rules = array_add($rules, 'client_email', 'required|email');
        $rules = array_add($rules, 'country_code', 'required');
        $rules = array_add($rules, 'phone_number', 'required|numeric');
        $rules = array_add($rules, 'dateof_birth', 'required');
        $rules = array_add($rules, 'country', 'required');
        $rules = array_add($rules, 'state', 'required');
        $rules = array_add($rules, 'city', 'required');
      }else{
         $rules = array_add($rules, 'client_id', 'required');
      }
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
       // return 'hai';
         
         //return $data['checkbox'];
          $data= $request->all();
          /*Start date and time convertion start */
          $date = date("Y-m-d", strtotime($data['appointment_date']));
          $start_time=$data['start_time'];
          $combined_start_date_and_time = $date . ' ' . $start_time;
          $start_date_time = strtotime($combined_start_date_and_time);
          $appointment_start_time_date =  date("Y-m-d H:i:s", $start_date_time);
          /*Start date and time convertion end */ 

          /*End date and time convertion start */          
          $end_time=$data['end_time'];
          $combined_end_date_and_time = $date . ' ' . $end_time;
          $end_date_time = strtotime($combined_end_date_and_time);
          $appointment_end_time_date =  date("Y-m-d H:i:s", $end_date_time);
          /*End date and time convertion end */         
          $dt = Carbon::now();
          if(isset($data['checkbox']) == 1){
            $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
          //when enter user first have to check mail is in business level employee,client,other parties list(business level every user unique)

      //business manager level
      $manager_record=User::where('id',$manager_id['manager_id'])->first();
        if($manager_record['email'] == $data['client_email']){
          if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
        }
       //business manager alter native level
       $manager_alternative_mail_check= ManagerAlternativeAccountFindingTable::where('main_manager_id',$manager_id['manager_id'])->select('alternative_business_manager_account_user_id')->first();
       $manager_alternative_mail= User::where('id',$manager_alternative_mail_check['alternative_business_manager_account_user_id'])->first();
        if($manager_alternative_mail['email'] == $data['client_email']){
          if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
        }

       //business employee level    
      $manager__level_employee_ids = Employee::where('manager_id',$manager_id['manager_id'])->pluck('employee_id')->all();
          $managers_employee_mail_unique_check = User::whereIn('id',$manager__level_employee_ids)->where('email',$data['client_email'])->get();
           if(count($managers_employee_mail_unique_check) != 0){
            if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
            }
      //business client level 
      $manager_level_client_ids = ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
         $managers_client_mail_unique_check = User::whereIn('id',$manager_level_client_ids)->where('email',$data['client_email'])->get();
          if(count($managers_client_mail_unique_check) != 0){
            if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry Client already registerd with this email in you business");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry Client already registerd with this email in you business')->withInput();
                 }
            }
          //end
            //return $request->all();
             $client_record = User::create([
                              'registration_id' => strtoupper(substr($data['country'], 0, 2))."CL".date('dmHis'),
                              'name'=>$data['client_name'],
                              'surname'=>$data['surname'],
                              'email'=>$data['client_email'],
                              'country_code'=>$data['country_code'],
                              'phone_number'=>$data['phone_number'],
                              'dateof_birth'=>$data['dateof_birth'],
                              'role_id'=>3,
                              'active'=>1,
                              'created_record_date'=>$dt->toDayDateTimeString(),
                            ]);

            $client_addess = UserAddresses::create([
                                  'user_id'=>$client_record->id,
                                  'country'=>$data['country'],
                                  'state'=>$data['state'],
                                  'city'=>$data['city'],
                                  ]);

            $manager_clients = ManagerClients::create([
                                  'client_id'=>$client_record->id,
                                  'manager_id'=>$data['manager_id'],
                                  'employee_id_created_by'=>Auth::user()->id,
                                  'created_record_date'=>$dt->toDayDateTimeString(),
                                ]);
            $appointment_record = Appointments::create([
                                'client_id'=>$client_record->id,
                                'start_date_time'=>$appointment_start_time_date,
                                'end_date_time'=>$appointment_end_time_date,
                                'record_created_date'=>$dt->toDayDateTimeString(),
                                'practionar_id'=>$data['employee_practitioner_id'],
                                'manager_id'=>$data['manager_id'],
                                'employee_id_create_appoinment'=>Auth::user()->id,
                         
                              ]);
                // return $appointment_record;                  
            //mail sent to set security questions and password start
             $data = array('id'=>Hashids::encode($client_record['id']),'name'=>$client_record['name'],'email'=>$client_record['email'], "body" => "Test mail");

                $mail_sent=Mail::send('frontend.mail-templates.password-setup-client', $data, function($message) use ($data){
                    $message->to($data['email'], 'Receiver')
                              ->subject('IntellCOMM request for set password');
                      $message->from('muralidharan.bora@gmail.com','Sender');         
                  });
            //mail sent to set security questions and password end

          }else{
          $appointment_record = Appointments::create([
                                'client_id'=>$data['client_id'],
                                'start_date_time'=>$appointment_start_time_date,
                                'end_date_time'=>$appointment_end_time_date,
                                'practionar_id'=>$request->get('employee_practitioner_id'),
                                'record_created_date'=>$dt->toDayDateTimeString(),
                                'manager_id'=>$data['manager_id'],
                                'employee_id_create_appoinment'=>Auth::user()->id,
                         
                              ]); 
          }
          /* return $client_record;*/                                               
          $url = url('employee/appointments');
              if ($request->ajax()) {
                      return response()->json(array(
                        'success' => 'Apoointment Created Successfully',
                        'modal' => true,
                        'redirect_url' => $url,
                        'status' => 200,
                        ), 200);
              }else{
                      return redirect()->intended($url)->with('success', 'Appointment Created Successfully');
              }           
      }
  }

  /**
   * Edit the Appointment details.
   *
   * @param  int  $id
   * @return Response $data
  */
  public function editAppointment($subdoamin,$id){

    $client_appointment_edit = Appointments::where('id',$id)->first();
    $data['appointment_id'] = $client_appointment_edit->id;
    $data['client_id'] = $client_appointment_edit->client_id;
    $data['practionar_id'] = $client_appointment_edit->practionar_id;
    $date_time = $client_appointment_edit->start_date_time;
    $data['date'] = date_format($date_time,"m/d/Y");
    $data['start_time']=date('h:i A', strtotime($client_appointment_edit->start_date_time));  
    $data['end_time']=date('h:i A', strtotime( $client_appointment_edit->end_date_time));
    return $data;
  }
   
  /**
   * Update Appointment Details.
   *
   * @param  Request  $request
   * @return Response
   */ 
  public function updateAppointment($subdoamin,Request $request){
    $messages = [
            "client_id.required" => "Please Select Client Name.",
            ];
    $rules = array(
                  'employee_practitioner_id' => 'required',
                  'client_id' => 'required',
                  'appointment_date' => 'required|date|after:yesterday',
                  'start_time' => 'required',
                  'end_time' => 'required|after:start_time',
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
                 // return 'hai';
                $data= $request->all();
                /*Start date and time convertion start */          
                $date = date("Y-m-d", strtotime($data['appointment_date']));
                $start_time=$data['start_time'];
                $combined_start_date_and_time = $date . ' ' . $start_time;
                $start_date_time = strtotime($combined_start_date_and_time);
                $appointment_start_time_date =  date("Y-m-d H:i:s", $start_date_time);
                /*Start date and time convertion end */ 

                /*End date and time convertion start */          
                $end_time=$data['end_time'];
                $combined_end_date_and_time = $date . ' ' . $end_time;
                $end_date_time = strtotime($combined_end_date_and_time);
                $appointment_end_time_date =  date("Y-m-d H:i:s", $end_date_time);
                /*End date and time convertion end */         
                $dt = Carbon::now();
                $appointment_record = Appointments::findOrFail($data['appointment_id']);
                $appointment_record->practionar_id=$data['employee_practitioner_id'];
                $appointment_record->client_id=$data['client_id'];
                $appointment_record->start_date_time=$appointment_start_time_date;
                $appointment_record->end_date_time=$appointment_end_time_date;
                $appointment_record->record_updated_date=$dt->toDayDateTimeString();
                $appointment_record->save();                                              
                $url = url('employee/appointments');
                if ($request->ajax()) {
                    return response()->json(array(
                      'success' => 'Apoointment Updated Successfully',
                      'modal' => true,
                      'redirect_url' => $url,
                      'status' => 200,
                      ), 200);
                }else{
                    return redirect()->intended($url)->with('success', 'Appointment Updated Successfully');
                }  
              }
  }

  /**
   * Delete the Appointment details.
   *
   * @param  int  $id
   * @return Response $appointment
  */
  public function delelte($subdoamin,$id){
   
    $appointment = Appointments::findOrFail($id);
    if ($appointment != null) {
      $appointment->delete();
      return response()->json($appointment);
    }

  } 

 /**
   * Cancel the Appointment details.
   *
   * @param  int  $id
   * @return Response $appointment
  */
  public function cancel($subdoamin,$id){
   $id=Hashids::encode($id);
  /* $appointment = Appointments::findOrFail($id);
   $appointment->cancellation = 1;
   $appointment->save();*/
   return response()->json($id);
  }
                        
}







AccountFindingTable::where('main_manager_id',$manager_id['manager_id'])->select('alternative_business_manager_account_user_id')->first();
       $manager_alternative_mail= User::where('id',$manager_alternative_mail_check['alternative_business_manager_account_user_id'])->first();
        if($manager_alternative_mail['email'] == $data['client_email']){
          if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
        }
*/
       //business employee level    
     /* $manager__level_employee_ids = Employee::where('manager_id',$manager_id['manager_id'])->pluck('employee_id')->all();
          $managers_employee_mail_unique_check = User::whereIn('id',$manager__level_employee_ids)->where('email',$data['client_email'])->get();
           if(count($managers_employee_mail_unique_check) != 0){
            if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
            }*/
      //business client level 
      /*$manager_level_client_ids = ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
         $managers_client_mail_unique_check = User::whereIn('id',$manager_level_client_ids)->where('email',$data['client_email'])->get();
          if(count($managers_client_mail_unique_check) != 0){
            if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry Client already registerd with this email in you business");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry Client already registerd with this email in you business')->withInput();
                 }
            }*/
          //end
            //return $request->all();
            /* $client_record = User::create([
                              'registration_id' => strtoupper(substr($data['country'], 0, 2))."CL".date('dmHis'),
                              'name'=>$data['client_name'],
                              'surname'=>$data['surname'],
                              'email'=>$data['client_email'],
                              'country_code'=>$data['country_code'],
                              'phone_number'=>$data['phone_number'],
                              'dateof_birth'=>$data['dateof_birth'],
                              'role_id'=>3,
                              'active'=>1,
                              'created_record_date'=>$dt->toDayDateTimeString(),
                            ]);

            $client_addess = UserAddresses::create([
                                  'user_id'=>$client_record->id,
                                  'country'=>$data['country'],
                                  'state'=>$data['state'],
                                  'city'=>$data['city'],
                                  ]);

            $manager_clients = ManagerClients::create([
                                  'client_id'=>$client_record->id,
                                  'manager_id'=>$data['manager_id'],
                                  'employee_id_created_by'=>Auth::user()->id,
                                  'created_record_date'=>$dt->toDayDateTimeString(),
                                ]);
            $appointment_record = Appointments::create([
                                'client_id'=>$client_record->id,
                                'start_date_time'=>$appointment_start_time_date,
                                'end_date_time'=>$appointment_end_time_date,
                                'record_created_date'=>$dt->toDayDateTimeString(),
                                'practionar_id'=>$data['employee_practitioner_id'],
                                'manager_id'=>$data['manager_id'],
                                'employee_id_create_appoinment'=>Auth::user()->id,
                         
                              ]);*/
                // return $appointment_record;                  
            //mail sent to set security questions and password start
            /* $data = array('id'=>Hashids::encode($client_record['id']),'name'=>$client_record['name'],'email'=>$client_record['email'], "body" => "Test mail");

                $mail_sent=Mail::send('frontend.mail-templates.password-setup-client', $data, function($message) use ($data){
                    $message->to($data['email'], 'Receiver')
                              ->subject('IntellCOMM request for set password');
                      $message->from('muralidharan.bora@gmail.com','Sender');         
                  });*/
            //mail sent to set security questions and password end
/*
          }else{
          $appointment_record = Appointments::create([
                                'client_id'=>$data['client_id'],
                                'start_date_time'=>$appointment_start_time_date,
                                'end_date_time'=>$appointment_end_time_date,
                                'practionar_id'=>$request->get('employee_practitioner_id'),
                                'record_created_date'=>$dt->toDayDateTimeString(),
                                'manager_id'=>$data['manager_id'],
                                'employee_id_create_appoinment'=>Auth::user()->id,
                         
                              ]); 
          }
          $url = url('employee/appointments');
              if ($request->ajax()) {
                      return response()->json(array(
                        'success' => 'Apoointment Created Successfully',
                        'modal' => true,
                        'redirect_url' => $url,
                        'status' => 200,
                        ), 200);
              }else{
                      return redirect()->intended($url)->with('success', 'Appointment Created Successfully');
              }           
      }
  }
*/
  public function store($subdomain,Request $request){
 // return $request->all();
    $messages = [
                  "client_id.required" => "Please Select Client Name.",
                  "employee_practitioner_id.required" => "Please select Practitioner.",
                  "start_time.required" => "You can't book appointment before business time",
                ];
    $rules = array(
                  'employee_practitioner_id' => 'required',
                  'appointment_date' => 'required|date|after:yesterday',
                  'start_time' => 'required',
                  'end_time' => 'required|after:start_time',
                 );
    if($request->get('checkbox') == 1) {
        $rules = array_add($rules, 'client_name', 'required');
        $rules = array_add($rules, 'surname', 'required');
        $rules = array_add($rules, 'client_email', 'required|email');
        $rules = array_add($rules, 'country_code', 'required');
        $rules = array_add($rules, 'phone_number', 'required|numeric');
        $rules = array_add($rules, 'dateof_birth', 'required');
        $rules = array_add($rules, 'country', 'required');
        $rules = array_add($rules, 'state', 'required');
        $rules = array_add($rules, 'city', 'required');
      }else{
         $rules = array_add($rules, 'client_id', 'required');
      }
    $validator = Validator::make($request->all(), $rules,$messages);

          $date = date("Y-m-d", strtotime($request->get('appointment_date')));
          $start_time=$request->get('start_time');
          $combined_start_date_and_time = $date . ' ' . $start_time;
          $start_date_time = strtotime($combined_start_date_and_time);
          $appointment_start_time_date =  date("Y-m-d H:i:s", $start_date_time);

          $end_time=$request->get('end_time');
          $combined_end_date_and_time = $date . ' ' . $end_time;
          $end_date_time = strtotime($combined_end_date_and_time);
          $appointment_end_time_date =  date("Y-m-d H:i:s", $end_date_time);   
          // $result = Appointments::where('manager_id',Auth::user()->id)->where('practionar_id',$request->get('employee_practitioner_id'))->where('start_date_time',$appointment_start_time_date)->get();  
          $practionar_id = $request->get('employee_practitioner_id');
          $managerr_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
          $manger_id= $managerr_id['manager_id'];
          $client_id = $request->get('client_id');
          $practionar_results = DB::select( DB::raw("SELECT * FROM appointments WHERE (CAST(`start_date_time` as time) >= '$start_time' OR CAST(`start_date_time` as time) <= '$end_time' ) AND ( CAST(`end_date_time` as time) >= '$start_time' OR CAST(`end_date_time` as time) <= '$end_time' )AND ( date(start_date_time) = '$date' AND date(`end_date_time`) = '$date') AND manager_id = '$manger_id' AND practionar_id = '$practionar_id'") );

          $client_result = DB::select( DB::raw("SELECT * FROM appointments WHERE (CAST(`start_date_time` as time) >= '$start_time' OR CAST(`start_date_time` as time) <= '$end_time' ) AND ( CAST(`end_date_time` as time) >= '$start_time' OR CAST(`end_date_time` as time) <= '$end_time' )AND ( date(start_date_time) = '$date' AND date(`end_date_time`) = '$date') AND manager_id = '$manger_id' AND client_id = '$client_id'") );

         $appointment_settings = AppointmentSettings::where('manager_id',$manger_id)->first();
         $totalWeeks =  date("Y-m-d", strtotime("+".$appointment_settings['advance_booking_weeks']. "week"));
         //this condition for advance booking date limit start
          if(strtotime($request->get('appointment_date')) > strtotime($totalWeeks)){
            $validator->after(function() use ($validator) {  
            $managerr_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
            $manger_id= $managerr_id['manager_id'];       
            $appointment_settings = AppointmentSettings::where('manager_id',$manger_id)->first();
            $totalWeeks =  date("Y-m-d", strtotime("+".$appointment_settings['advance_booking_weeks']. "week"));
             $validator->errors()->add('appointment_date', 'You cant book appointment after'. $totalWeeks. 'date');
           });
          }
          //this condition for advance booking date limit end

          if($request->get('appointment_date')){
          $current_date_with_time = date('m/d/Y h:i a', time());
          if(strtotime( $current_date_with_time)> strtotime($request->get('appointment_date').$request->get('start_time') ))
          {
           $validator->after(function() use ($validator) {
             $validator->errors()->add('start_time', 'You cant book appointment today past time');
           });
          }else{
                //Custom validatte start time and business time start
                  if(strtotime($request->get('start_time')) < strtotime($request->get('business_start_time')) )
                  {
                    //$request->get('start_time') =  '';
                    $validator->after(function() use ($validator) {
                             $validator->errors()->add('start_time', 'Start time must be more than business start time');
                       });
                  } elseif(strtotime($request->get('start_time')) > strtotime($request->get('business_end_time')) ){
                      $validator->after(function() use ($validator) {

                      $validator->errors()->add('start_time', 'Start time must be less than business end time');
                      });
                  }elseif(count($practionar_results)  != 0){
                    //return 'erro1';
                          $validator->after(function() use ($validator) {
                          $validator->errors()->add('start_time', 'You cant  book appointment on this time slot because Practitioner has another booking on this time');
                          });
                  }elseif(count($client_result)  != 0){
                     return 'erro2';
                    $validator->after(function() use ($validator) {
                    $validator->errors()->add('start_time', 'You cant  book appointment on this time slot because client has another booking on this time');
                    });
                 }
            }



    }

      //Custom validatte start time and business time end    
      //Custom validatte start time and business time start
     if(strtotime($request->get('end_time')) > strtotime($request->get('start_time')) ){
        if(strtotime($request->get('end_time')) > strtotime($request->get('business_end_time')) )
        {
        //$request->get('start_time') =  '';
          $validator->after(function() use ($validator) {

                   $validator->errors()->add('end_time', 'End time must be less than business end time');
             });
        }elseif(strtotime($request->get('end_time')) < strtotime($request->get('business_start_time'))){
            $validator->after(function() use ($validator) {

            $validator->errors()->add('end_time', 'End time must be more than business start time');
            });
        }
      }
     //Custom validatte start time and business time end
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
       // return 'hai';
         $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
         //return $data['checkbox'];
          $data['checkbox']="";
          $data= $request->all();
          /*Start date and time convertion start */
          $date = date("Y-m-d", strtotime($data['appointment_date']));
          $start_time=$data['start_time'];
          $combined_start_date_and_time = $date . ' ' . $start_time;
          $start_date_time = strtotime($combined_start_date_and_time);
          $appointment_start_time_date =  date("Y-m-d H:i:s", $start_date_time);
          /*Start date and time convertion end */ 

          /*End date and time convertion start */          
          $end_time=$data['end_time'];
          $combined_end_date_and_time = $date . ' ' . $end_time;
          $end_date_time = strtotime($combined_end_date_and_time);
          $appointment_end_time_date =  date("Y-m-d H:i:s", $end_date_time);
          /*End date and time convertion end */         
          $dt = Carbon::now();
          if(isset($data['checkbox']) == 1){
           //when enter user first have to check mail is in business level employee,client,other parties list(business level every user unique)
      //business manager level
        $manager_record=User::where('id',$manager_id['manager_id'])->first();
        if($manager_record['email'] == $data['client_email']){
          if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
        }
       //business manager alter native level
       $manager_alternative_mail_check= ManagerAlternativeAccountFindingTable::where('main_manager_id',$manager_id['manager_id'])->select('alternative_business_manager_account_user_id')->first();
       $manager_alternative_mail= User::where('id',$manager_alternative_mail_check['alternative_business_manager_account_user_id'])->first();
        if($manager_alternative_mail['email'] == $data['client_email']){
          if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
        }

       //business employee level    
      $manager__level_employee_ids = Employee::where('manager_id',$manager_id['manager_id'])->pluck('employee_id')->all();
          $managers_employee_mail_unique_check = User::whereIn('id',$manager__level_employee_ids)->where('email',$data['client_email'])->get();
           if(count($managers_employee_mail_unique_check) != 0){
            if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
            }
      //business client level 
      $manager_level_client_ids = ManagerClients::where('manager_id',$manager_id['manager_id'])->pluck('client_id')->all();
         $managers_client_mail_unique_check = User::whereIn('id',$manager_level_client_ids)->where('email',$data['client_email'])->get();
          if(count($managers_client_mail_unique_check) != 0){
            if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry Client already registerd with this email in you business");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry Client already registerd with this email in you business')->withInput();
                 }
            }
          //end
           $appointment_settings = AppointmentSettings::where('manager_id',$manager_id['manager_id'])->first();
             $client_record = User::create([
                              'registration_id' => strtoupper(substr($data['country'], 0, 2))."CL".date('dmHis'),
                              'name'=>$data['client_name'],
                              'surname'=>$data['surname'],
                              'email'=>$data['client_email'],
                              'country_code'=>$data['country_code'],
                              'phone_number'=>$data['phone_number'],
                              'dateof_birth'=>$data['dateof_birth'],
                              'role_id'=>3,
                              'active'=>1,
                              'created_record_date'=>$dt->toDayDateTimeString(),
                            ]);
            $client_addess = UserAddresses::create([
                                  'user_id'=>$client_record->id,
                                  'country'=>$data['country'],
                                  'state'=>$data['state'],
                                  'city'=>$data['city'],
                                  ]);
            $manager_clients = ManagerClients::create([
                                  'client_id'=>$client_record->id,
                                  'manager_id'=>$manager_id['manager_id'],
                                  'created_record_date'=>$dt->toDayDateTimeString(),
                                ]);
            $appointment_record = Appointments::create([
                                'client_id'=>$client_record->id,
                                'start_date_time'=>$appointment_start_time_date,
                                'end_date_time'=>$appointment_end_time_date,
                                'practionar_id'=>$request->get('employee_practitioner_id'),
                                'record_created_date'=>$dt->toDayDateTimeString(),
                                'manager_id'=>$manager_id['manager_id'],
                                'employee_id_create_appoinment'=>Auth::user()->id,
                                'status'=>2,
                                'comment'=>$request->get('comment'),
                         
                              ]); 
            //mail sent to set security questions and password start
             $data = array('id'=>Hashids::encode($client_record['id']),'name'=>$client_record['name'],'email'=>$client_record['email'], "body" => "Test mail");

                $mail_sent=Mail::send('frontend.mail-templates.password-setup-client', $data, function($message) use ($data){
                    $message->to($data['email'], 'Receiver')
                              ->subject('IntellCOMM request for set password');
                    $message->from('muralidharan.bora@gmail.com','Sender');         
                  });
            //mail sent to set security questions and password end

           //mail sent to appointment with client registration time notification
              $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
              $manager_record=User::where('id',$manager_id)->first();
             $practionar_record=User::where('id', $appointment_record['practionar_id'])->first();
             $business_details=ManagerBusinessDetails::where('user_id',$manager_id['manager_id'])->select('businesss_name')->first();
             $data = array('id'=>Hashids::encode($client_record['id']),'name'=>$client_record['name'],'surname'=>$client_record['surname'],'email'=>$client_record['email'],'practionar_name'=>$practionar_record['name'],'practionar_surname'=>$practionar_record['surname'],'practionar_email'=>$practionar_record['email'],'appointment_start_date_time'=>$appointment_record['start_date_time'],'appointment_start_date_time'=>$appointment_record['end_date_time'],'business_name'=>$business_details['businesss_name'],'manager_email'=>$manager_record['email'],"body" => "Test mail");
            $mail_sent=Mail::send('frontend.mail-templates.appointment-notification', $data, function($message) use ($data){
                  $message->to($data['email'], 'Receiver')
                          ->subject('IntellCOMM Appointment Schedule');
                  $message->from($data['manager_email'],'Sender');         
              });
            //mail sent to appointment notification   


          }else{
          $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
          $appointment_settings = AppointmentSettings::where('manager_id',$manager_id['manager_id'])->first();
          $appointment_record = Appointments::create([
                                'client_id'=>$data['client_id'],
                                'start_date_time'=>$appointment_start_time_date,
                                'end_date_time'=>$appointment_end_time_date,
                                'practionar_id'=>$request->get('employee_practitioner_id'),
                                'record_created_date'=>$dt->toDayDateTimeString(),
                                'manager_id'=>$manager_id['manager_id'],
                                'employee_id_create_appoinment'=>Auth::user()->id,
                                'status'=>2,
                                'comment'=>$request->get('comment'),
                         
                              ]); 
          }

           //mail sent to appointment notification with out client registration
             $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
             $manager_record=User::where('id',$manager_id)->first();
             $practionar_record=User::where('id', $appointment_record['practionar_id'])->first();
             $client_record=User::where('id', $appointment_record['client_id'])->first();
             $business_details=ManagerBusinessDetails::where('user_id',$manager_id['manager_id'])->select('businesss_name')->first();
             $data = array('id'=>Hashids::encode($client_record['id']),'name'=>$client_record['name'],'surname'=>$client_record['surname'],'email'=>$client_record['email'],'practionar_name'=>$practionar_record['name'],'practionar_surname'=>$practionar_record['surname'],'practionar_email'=>$practionar_record['email'],'appointment_start_date_time'=>$appointment_record['start_date_time'],'appointment_end_date_time'=>$appointment_record['end_date_time'],'business_name'=>$business_details['businesss_name'],'manager_email'=>$manager_record['email'],"body" => "Test mail");
            $mail_sent=Mail::send('frontend.mail-templates.appointment-notification', $data, function($message) use ($data){
                  $message->to($data['email'], 'Receiver')
                          ->subject('IntellCOMM Appointment Schedule');
                  $message->from(Auth::user()->email,'Sender');         
              });
            //mail sent to appointment notification   

          /* return $client_record;*/                                               
          $url = url('employee/appointments');
              if ($request->ajax()) {
                      return response()->json(array(
                        'success' => 'Apoointment Created Successfully',
                        'modal' => true,
                        'redirect_url' => $url,
                        'status' => 200,
                        ), 200);
              }else{
                      return redirect()->intended($url)->with('success', 'Appointment Created Successfully');
              }           
      }
  }

  /**
   * Edit the Appointment details.
   *
   * @param  int  $id
   * @return Response $data
  */
  public function editAppointment($subdoamin,$id){

    $client_appointment_edit = Appointments::where('id',$id)->first();
    $data['appointment_id'] = $client_appointment_edit->id;
    $data['client_id'] = $client_appointment_edit->client_id;
    $data['practionar_id'] = $client_appointment_edit->practionar_id;
    $date_time = $client_appointment_edit->start_date_time;
    $data['date'] = date_format($date_time,"m/d/Y");
    $data['start_time']=date('h:i A', strtotime($client_appointment_edit->start_date_time));  
    $data['end_time']=date('h:i A', strtotime( $client_appointment_edit->end_date_time));
    return $data;
  }
   
  /**
   * Update Appointment Details.
   *
   * @param  Request  $request
   * @return Response
   */ 
  public function updateAppointment($subdoamin,Request $request){
    $messages = [
            "client_id.required" => "Please Select Client Name.",
            ];
    $rules = array(
                  'employee_practitioner_id' => 'required',
                  'client_id' => 'required',
                  'appointment_date' => 'required|date|after:yesterday',
                  'start_time' => 'required',
                  'end_time' => 'required|after:start_time',
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
                 // return 'hai';
                $data= $request->all();
                /*Start date and time convertion start */          
                $date = date("Y-m-d", strtotime($data['appointment_date']));
                $start_time=$data['start_time'];
                $combined_start_date_and_time = $date . ' ' . $start_time;
                $start_date_time = strtotime($combined_start_date_and_time);
                $appointment_start_time_date =  date("Y-m-d H:i:s", $start_date_time);
                /*Start date and time convertion end */ 

                /*End date and time convertion start */          
                $end_time=$data['end_time'];
                $combined_end_date_and_time = $date . ' ' . $end_time;
                $end_date_time = strtotime($combined_end_date_and_time);
                $appointment_end_time_date =  date("Y-m-d H:i:s", $end_date_time);
                /*End date and time convertion end */         
                $dt = Carbon::now();
                $appointment_record = Appointments::findOrFail($data['appointment_id']);
                $appointment_record->practionar_id=$data['employee_practitioner_id'];
                $appointment_record->client_id=$data['client_id'];
                $appointment_record->start_date_time=$appointment_start_time_date;
                $appointment_record->end_date_time=$appointment_end_time_date;
                $appointment_record->record_updated_date=$dt->toDayDateTimeString();
                $appointment_record->save();                                              
                $url = url('employee/appointments');
                if ($request->ajax()) {
                    return response()->json(array(
                      'success' => 'Apoointment Updated Successfully',
                      'modal' => true,
                      'redirect_url' => $url,
                      'status' => 200,
                      ), 200);
                }else{
                    return redirect()->intended($url)->with('success', 'Appointment Updated Successfully');
                }  
              }
  }

  /**
   * Delete the Appointment details.
   *
   * @param  int  $id
   * @return Response $appointment
  */
  public function delelte($subdoamin,$id){
   
    $appointment = Appointments::findOrFail($id);
    if ($appointment != null) {
      $appointment->delete();
      return response()->json($appointment);
    }

  } 

 /**
   * Cancel the Appointment details.
   *
   * @param  int  $id
   * @return Response $appointment
  */
  public function cancel($subdoamin,$id){
   $id=Hashids::encode($id);
  /* $appointment = Appointments::findOrFail($id);
   $appointment->cancellation = 1;
   $appointment->save();*/
   return response()->json($id);
  }

  public function details($subdomain,$id){
     $id=Hashids::encode($id);
     return response()->json($id);
  }
  public function arrivedStatusCheck($subdomain,$appointmentid){
     $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
     $appointment_status_change=Appointments::where('id',$appointmentid)->where('manager_id',$manager_id['manager_id'])->first();
     $appointment_status_change->update([
                              'status'=>1,
                             ]);
     return response()->json('arrived');
  }

  public function dnaStatusCheck($subdomain,$appointmentid){
    $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
     $appointment_status_change=Appointments::where('id',$appointmentid)->where('manager_id',$manager_id['manager_id'])->first();
     $appointment_status_change->update([
                              'status'=>3,
                             ]);
     return response()->json('dna');
  }
  public function inprocessStatusCheck($subdomain,$appointmentid){
    $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
     $appointment_status_change=Appointments::where('id',$appointmentid)->where('manager_id',$manager_id['manager_id'])->first();
     $appointment_status_change->update([
                              'status'=>5,
                             ]);
     return response()->json('inprocess');
  }
  public function seenStatusCheck($subdomain,$appointmentid){
    $manager_id = Employee::where('employee_id',Auth::user()->id)->select('manager_id')->first();
     $appointment_status_change=Appointments::where('id',$appointmentid)->where('manager_id',$manager_id['manager_id'])->first();
     $appointment_status_change->update([
                              'status'=>4,
                             ]);
     return response()->json('seen');
  }
                        
}







