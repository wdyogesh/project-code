<?php

namespace App\Http\Controllers\Frontend\Manager;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\Appointments;
use App\Models\AppointmentSettings;
use App\Models\Calendar;
use App\Models\SecurityQuestions;
use App\Models\BusinessProfessionCategory;
use App\Models\BusinessProfessionTypes;
use App\Models\ManagerClients;
use App\Models\ManagerBusinessDetails;
use App\Models\Role;
use App\Models\UserAddresses;
use App\Models\ManagerAlternativeAccountFindingTable;
use App\Models\Employee;
use App\Models\Hours;
use App\Models\Minutes;
use App\Models\PractionarAvailabilityAndBreaks;
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
  public function index($subdomain=null,$hashid = 'jR'){  
    //first time basic appointment setting will settup if manager directly click appointments start
    $appointment_setting_record_found_check=AppointmentSettings::where('manager_id',Auth::user()->id)->first();
    if(count($appointment_setting_record_found_check) == 0){
      $appointment_settings = AppointmentSettings::create([
                            'time_slot_size'=>15,
                            'business_time_start'=>7,
                            'business_time_end'=>19,
                            'color_arrived'=>'#ffb3b3',
                            'color_in_process'=>'#ff3377',
                            'color_in_seen'=>'#6ae620',
                            'color_in_dna'=>'#f52507',
                            'color_in_booked'=>'#0033cc',
                            'advance_booking_weeks'=>1,
                            'manager_id'=>Auth::user()->id,                     
                            ]);
    }  
    //first time basic appointment setting will settup if manager directly click appointments end
    $id = Hashids::decode($hashid)[0];
    $face_to_face_consultation_with_client=Employee::where('businessmanagers_employee_roles_id',8)->where('manager_id',Auth::user()->id)->pluck('employee_id')->all();
    $practitioners=User::whereIn('id',$face_to_face_consultation_with_client)->get();
    //return $id;
    $weekend = $id == 5?false:true;
    $manager__level_client_ids = ManagerClients::where('manager_id',Auth::user()->id)->pluck('client_id')->all();
    $managers_clients = User::whereIn('id',$manager__level_client_ids)->get();
    $managers_clients_edit_page = User::whereIn('id',$manager__level_client_ids)->get();
    $data = Appointments::join('users as info', 'info.id', '=', 'appointments.client_id')
                        ->where('appointments.manager_id', Auth::user()->id)
                        ->where('cancellation',NULL)
                        ->select('*','appointments.id as appointment_id')
                        ->get();
  $calendar_setting_record_found_check=AppointmentSettings::where('manager_id',Auth::user()->id)->first();                    
    $events = [];
    // return $data = Appointments::all();
    if($data->count()){
        foreach ($data as $key => $value) {
          $color="#ffb3b3";
          if($value['status']==1){
            $color=$calendar_setting_record_found_check['color_arrived'];
          }elseif($value['status']==2){
            $color=$calendar_setting_record_found_check['color_in_booked'];
          }elseif($value['status']==3){
            $color=$calendar_setting_record_found_check['color_in_dna'];
          }elseif($value['status']==4){
            $color=$calendar_setting_record_found_check['color_in_seen'];
          }elseif($value['status']==5){
            $color=$calendar_setting_record_found_check['color_in_process'];
          }
             
          $events[] = \Calendar::event(
              $value->email,
              false,
              new \DateTime($value->start_date_time),
              new \DateTime($value->end_date_time),
              $value->appointment_id,
              [
             /* 'url' => url('manager/show-appointment-details', $value->appointment_id),*/
              'color' => $color,
              //any other full-calendar supported parameters
              ]
          );
        }
    }
    $calendar = \Calendar::addEvents($events) //add an array with addEvents
                         ->setOptions([      
                    'defaultView' => 'agendaDays',
                    /*'businessHours'=> [               
                                       'dow' => [2,3,4], 
                                       'start'=> '08:00',
                                       'end' => '11:00',
                                      ],*/    
                    'views' => [
                                'agendaDays' => [
                                              'weekends'=>$weekend,
                                              //'hiddenDays'=> [0,6],
                                              'type' => 'agenda',
                                              'allDaySlot'=>false,
                                              'minTime'=> $calendar_setting_record_found_check['business_time_start'].":00",
                                              'maxTime'=> $calendar_setting_record_found_check['business_time_end'].":00", 
                                              'slotDuration'=> "00:".$calendar_setting_record_found_check['time_slot_size'], 
                                              'duration' => [
                                                    'days'=> $id,
                                                           ],                      
                                                 ]          
                                ]

                          ])->setCallbacks([
                                'eventClick' => 'function(event, jsEvent, view){
                                     var data = event.id; 
                                      
                                      $.ajax({
                                         type : "GET",
                                         url : "/manager/client-info",
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
                                          $("#appointment_id_for_arrived_check").val(data.appointment_id);
                                          $("#appointment_id_for_dna_check").val(data.appointment_id);
                                          $("#appointment_id_for_seen_check").val(data.appointment_id);
                                          $("#appointment_id_for_inprocess_check").val(data.appointment_id);
                                          $("#clientId").val(data.client_id);    
                                          $("#calendarModal").modal();
                                          $("#modaldefault").modal("hide");
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
     //business appointment settings
     $appointment_settings=AppointmentSettings::where('manager_id',Auth::user()->id)->first();
     $business_start_time  = date("g:i A", strtotime($appointment_settings['business_time_start'].":00"));
     $business_end_time  = date("g:i A", strtotime($appointment_settings['business_time_end'].":00"));                          
    return view('frontend/business-manager/appointment-management/manage-appointments',compact('calendar','managers_clients','managers_clients_edit_page','countries','practitioners','business_start_time','business_end_time','value'));
  }


  /**
   * Show Appointment Details.
   *
   * @param  Request  $request
   * @return Response $data
  */
  public function clientinfo($subdomain,Request $request){

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
          $manger_id= Auth::user()->id;
          $client_id = $request->get('client_id');
          $practionar_results = DB::select( DB::raw("SELECT * FROM appointments WHERE (CAST(`start_date_time` as time) >= '$start_time' OR CAST(`start_date_time` as time) <= '$end_time' ) AND ( CAST(`end_date_time` as time) >= '$start_time' OR CAST(`end_date_time` as time) <= '$end_time' )AND ( date(start_date_time) = '$date' AND date(`end_date_time`) = '$date') AND manager_id = '$manger_id' AND practionar_id = '$practionar_id'") );

          $client_result = DB::select( DB::raw("SELECT * FROM appointments WHERE (CAST(`start_date_time` as time) >= '$start_time' OR CAST(`start_date_time` as time) <= '$end_time' ) AND ( CAST(`end_date_time` as time) >= '$start_time' OR CAST(`end_date_time` as time) <= '$end_time' )AND ( date(start_date_time) = '$date' AND date(`end_date_time`) = '$date') AND manager_id = '$manger_id' AND client_id = '$client_id'") );

         $appointment_settings = AppointmentSettings::where('manager_id',Auth::user()->id)->first();
         $totalWeeks =  date("Y-m-d", strtotime("+".$appointment_settings['advance_booking_weeks']. "week"));
         //this condition for advance booking date limit start
          if(strtotime($request->get('appointment_date')) > strtotime($totalWeeks)){
             $validator->after(function() use ($validator) {        
            $appointment_settings = AppointmentSettings::where('manager_id',Auth::user()->id)->first();
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
                          $validator->after(function() use ($validator) {
                          $validator->errors()->add('start_time', 'You cant  book appointment on this time slot because Practitioner has another booking on this time');
                          });
                  }elseif(count($client_result)  != 0){
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
        $manager_mail= Auth::user()->email;
        if($manager_mail == $data['client_email']){
          if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
        }

        //business manager alter native level
       $manager_alternative_mail_check= ManagerAlternativeAccountFindingTable::where('main_manager_id',Auth::user()->id)->select('alternative_business_manager_account_user_id')->first();
       $manager_alternative_mail= User::where('id',$manager_alternative_mail_check['alternative_business_manager_account_user_id'])->first();
        if($manager_alternative_mail['email'] == $data['client_email']){
          if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
        }
      //business client level
      $manager_level_client_ids = ManagerClients::where('manager_id',Auth::user()->id)->pluck('client_id')->all();
      $managers_clients_mail_unique_check = User::whereIn('id',$manager_level_client_ids)->where('email',$data['client_email'])->get();
       if(count($managers_clients_mail_unique_check) != 0){
            if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
            }
      //business employee level   
      $manager__level_employee_ids = Employee::where('manager_id',Auth::user()->id)->pluck('employee_id')->all();
          $managers_employee_mail_unique_check = User::whereIn('id',$manager__level_employee_ids)->where('email',$data['client_email'])->get();
           if(count($managers_employee_mail_unique_check) != 0){
            if ($request->ajax()) {
                  $validator->errors()->add("login_error", "Sorry user already existed in your business with same email");
                  return response()->json($validator->getMessageBag(), 301);
                 }else{
                  return redirect()->back()->with('fail', 'Sorry user already existed in your business with same email')->withInput();
                 }
            }
          //end 
           $appointment_settings = AppointmentSettings::where('manager_id',Auth::user()->id)->first();
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
                                  'created_record_date'=>$dt->toDayDateTimeString(),
                                ]);
            $appointment_record = Appointments::create([
                                'client_id'=>$client_record->id,
                                'start_date_time'=>$appointment_start_time_date,
                                'end_date_time'=>$appointment_end_time_date,
                                'practionar_id'=>$request->get('employee_practitioner_id'),
                                'record_created_date'=>$dt->toDayDateTimeString(),
                                'manager_id'=>$data['manager_id'],
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
             $practionar_record=User::where('id', $appointment_record['practionar_id'])->first();
             $business_details=ManagerBusinessDetails::where('user_id',Auth::user()->id)->select('businesss_name')->first();
             $data = array('id'=>Hashids::encode($client_record['id']),'name'=>$client_record['name'],'surname'=>$client_record['surname'],'email'=>$client_record['email'],'practionar_name'=>$practionar_record['name'],'practionar_surname'=>$practionar_record['surname'],'practionar_email'=>$practionar_record['email'],'appointment_start_date_time'=>$appointment_record['start_date_time'],'appointment_start_date_time'=>$appointment_record['end_date_time'],'business_name'=>$business_details['businesss_name'],"body" => "Test mail");
            $mail_sent=Mail::send('frontend.mail-templates.appointment-notification', $data, function($message) use ($data){
                  $message->to($data['email'], 'Receiver')
                          ->subject('IntellCOMM Appointment Schedule');
                  $message->from(Auth::user()->email,'Sender');         
              });
            //mail sent to appointment notification   


          }else{
          $appointment_settings = AppointmentSettings::where('manager_id',Auth::user()->id)->first();
          $appointment_record = Appointments::create([
                                'client_id'=>$data['client_id'],
                                'start_date_time'=>$appointment_start_time_date,
                                'end_date_time'=>$appointment_end_time_date,
                                'practionar_id'=>$request->get('employee_practitioner_id'),
                                'record_created_date'=>$dt->toDayDateTimeString(),
                                'manager_id'=>$data['manager_id'],
                                'status'=>2,
                                'comment'=>$request->get('comment'),
                         
                              ]); 
          }

           //mail sent to appointment notification with out client registration
             $practionar_record=User::where('id', $appointment_record['practionar_id'])->first();
             $client_record=User::where('id', $appointment_record['client_id'])->first();
             $business_details=ManagerBusinessDetails::where('user_id',Auth::user()->id)->select('businesss_name')->first();
             $data = array('id'=>Hashids::encode($client_record['id']),'name'=>$client_record['name'],'surname'=>$client_record['surname'],'email'=>$client_record['email'],'practionar_name'=>$practionar_record['name'],'practionar_surname'=>$practionar_record['surname'],'practionar_email'=>$practionar_record['email'],'appointment_start_date_time'=>$appointment_record['start_date_time'],'appointment_end_date_time'=>$appointment_record['end_date_time'],'business_name'=>$business_details['businesss_name'],"body" => "Test mail");
            $mail_sent=Mail::send('frontend.mail-templates.appointment-notification', $data, function($message) use ($data){
                  $message->to($data['email'], 'Receiver')
                          ->subject('IntellCOMM Appointment Schedule');
                  $message->from(Auth::user()->email,'Sender');         
              });
            //mail sent to appointment notification   

          /* return $client_record;*/                                               
          $url = url('manager/appointments');
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
  public function editAppointment($subdomain,$id){
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
  public function updateAppointment($subdomain,Request $request){
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
                $url = url('manager/appointments');
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
  public function delelte($subdomain,$id){
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
  public function cancel($subdomain,$id){
   $appointment = Appointments::findOrFail($id);
   $appointment->arrived = 1;
   $appointment->save();
   return response()->json($id);
  } 
 
  public function details($subdomain,$id){
     $id=Hashids::encode($id);
     return response()->json($id);
  }
  public function arrivedStatusCheck($subdomain,$appointmentid){
     $appointment_status_change=Appointments::where('id',$appointmentid)->where('manager_id',Auth::user()->id)->first();
     $appointment_status_change->update([
                              'status'=>1,
                             ]);
     return response()->json('arrived');
  }

  public function dnaStatusCheck($subdomain,$appointmentid){
     $appointment_status_change=Appointments::where('id',$appointmentid)->where('manager_id',Auth::user()->id)->first();
     $appointment_status_change->update([
                              'status'=>3,
                             ]);
     return response()->json('dna');
  }
  public function inprocessStatusCheck($subdomain,$appointmentid){
     $appointment_status_change=Appointments::where('id',$appointmentid)->where('manager_id',Auth::user()->id)->first();
     $appointment_status_change->update([
                              'status'=>5,
                             ]);
     return response()->json('inprocess');
  }
  public function seenStatusCheck($subdomain,$appointmentid){
     $appointment_status_change=Appointments::where('id',$appointmentid)->where('manager_id',Auth::user()->id)->first();
     $appointment_status_change->update([
                              'status'=>4,
                             ]);
     return response()->json('seen');
  }

  //appointment calendar settings start

  public function appointmentSettings(){
    $count_record=AppointmentSettings::where('manager_id',Auth::user()->id)->first();
    if(count($count_record) == 1){
      return redirect()->to('manager/edit-appointment-settings/'.Hashids::encode($count_record['id']));
    }

   return view('frontend/business-manager/appointment-management/appointment-setting');
  }
  public function postAppointmentSettings(Request $request){
    $messages = [
        "business_time_end.after" => "Business end time must more than start time",
     ];   
    $rules = array(
    'time_slot_size' => 'required',
    'business_time_start' => 'required',
    //'business_time_end' => 'required',
    'color_arrived' => 'required',
    'color_in_process' => 'required',
    'color_in_seen' => 'required',
    'color_in_dna' => 'required',
    'color_in_booked' => 'required',
    'advance_booking_weeks' => 'required',
    );
    if($request->get('business_time_start') > $request->get('business_time_end')){
      //return $request->get('business_time_end');
      $rules = array_add($rules,'business_time_end', 'required|after:business_time_start');
    }
    $validator = Validator::make($request->all(), $rules,$messages);
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
      $appointment_settings = AppointmentSettings::create([
                            'time_slot_size'=>$data['time_slot_size'],
                            'business_time_start'=>$data['business_time_start'],
                            'business_time_end'=>$data['business_time_end'],
                            'color_arrived'=>$data['color_arrived'],
                            'color_in_process'=>$data['color_in_process'],
                            'color_in_seen'=>$data['color_in_seen'],
                            'color_in_dna'=>$data['color_in_dna'],
                            'color_in_booked'=>$data['color_in_booked'],
                            'advance_booking_weeks'=>$data['advance_booking_weeks'],
                            'manager_id'=>Auth::user()->id,                     
                            ]);                           
      $url = url('manager/edit-appointment-settings/'.Hashids::encode($appointment_settings->id));
      if ($request->ajax()){
                return response()->json(array(
                  'success' => 'Settings Created Succcess fully',
                  'modal' => true,
                  'redirect_url' => $url,
                  'status' => 200,
                  ), 200);
            }else{
                return redirect()->intended($url)->with('success', 'Settings Created Succcess fully');
            }                
    }
  }

  public function editAppointmentSettings($subdomain,$hashid){
    $appointment_settings_id = Hashids::decode($hashid)[0];
    $count_record=AppointmentSettings::where('manager_id',Auth::user()->id)->first();
    if(count($count_record) == 1){
       //return  $count_record;
       return view('frontend/business-manager/appointment-management/edit-appointment-setting',compact('count_record'));
    }
   return redirect()->to('manager/appointment-settings');
  }

  public function updateAppointmentSettings($subdomain,Request $request){
    $messages = [
        "business_time_end.after" => "Business end time must more than start time",
     ];   
    $rules = array(
    'time_slot_size' => 'required',
    'business_time_start' => 'required',
    //'business_time_end' => 'required',
    'color_arrived' => 'required',
    'color_in_process' => 'required',
    'color_in_seen' => 'required',
    'color_in_dna' => 'required',
    'color_in_booked' => 'required',
    'advance_booking_weeks' => 'required',
    );
    if($request->get('business_time_start') > $request->get('business_time_end')){
      //return $request->get('business_time_end');
      $rules = array_add($rules,'business_time_end', 'required|after:business_time_start');
    }
    $validator = Validator::make($request->all(), $rules,$messages);
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
      $update_settings=AppointmentSettings::where('id',$data['appointment_setting_id'])->first();
      $update_settings->update([
                            'time_slot_size'=>$data['time_slot_size'],
                            'business_time_start'=>$data['business_time_start'],
                            'business_time_end'=>$data['business_time_end'],
                            'color_arrived'=>$data['color_arrived'],
                            'color_in_process'=>$data['color_in_process'],
                            'color_in_seen'=>$data['color_in_seen'],
                            'color_in_dna'=>$data['color_in_dna'],
                            'color_in_booked'=>$data['color_in_booked'],                   
                            'advance_booking_weeks'=>$data['advance_booking_weeks'],                   
                            ]);                           
      $url = url('manager/edit-appointment-settings/'.Hashids::encode($update_settings->id));
      if ($request->ajax()){
                return response()->json(array(
                  'success' => 'Settings Created Succcess fully',
                  'modal' => true,
                  'redirect_url' => $url,
                  'status' => 200,
                  ), 200);
            }else{
                return redirect()->intended($url)->with('success', 'Settings Created Succcess fully');
            }                
    }
  }

  //appointment calendar settings end


  //practionar  settings start
    public function allPractionars(){
       $managers_face_to_face_employees= User::join('user_addresses as info', 'info.user_id', '=', 'users.id')
                   ->join('roles', 'role_id', '=', 'roles.id')
                   ->join('employees','users.id','=','employees.employee_id')
                   ->join('businessmanagers_employee_roles','employees.businessmanagers_employee_roles_id','=','businessmanagers_employee_roles.id')
                   ->where('role_id',4)
                   ->where('employees.manager_id',Auth::user()->id)
                   ->where('employees.businessmanagers_employee_roles_id',8)
                   ->select('*','users.id as main_user_id','users.created_record_date as main_user_table_created_record_date','users.updated_record_date as main_user_table_updated_record_date','roles.id as main_role_id','businessmanagers_employee_roles.id as business_manager_level_employee_role_id')
                   ->get();
      return view('frontend/business-manager/appointment-management/practionar-settings',compact('managers_face_to_face_employees'));
    } 

    public function faceToFaceAvailabilityForm($subdomain,$hashemployeeid,$dayname=null){
    if($dayname == ''){
      $dayname="Sunday";
    }elseif($dayname == 'mon'){
      $dayname="Monday";
    }elseif($dayname == 'tue'){
      $dayname="Tuesday";
    }elseif($dayname == 'wed'){
      $dayname="Wednesday";
    }elseif($dayname == 'thu'){
      $dayname="Thursday";
    }elseif($dayname == 'fri'){
      $dayname="Friday";
    }elseif($dayname == 'sat'){
      $dayname="Saturday";
    }
    $practionar_id = Hashids::decode($hashemployeeid)[0];
    $practionar=User::where('id',$practionar_id)->first();

    //for update edit in same form access start
     $practionar_record_find_in_available_table=PractionarAvailabilityAndBreaks::where('practionar_employee_id',$practionar_id)->where('manager_id',Auth::user()->id)->where('day_name',$dayname)->first();
     $day_name= $practionar_record_find_in_available_table['day_name'];
     $manager_id= $practionar_record_find_in_available_table['manager_id'];
    
    if($practionar_record_find_in_available_table['practionar_employee_id'] != ""){
      $practionar_employee_id= $practionar_record_find_in_available_table['practionar_employee_id'];
    }else{
       $practionar_employee_id= "";
    }
    if($practionar_record_find_in_available_table['availability_start_time'] != ""){
      $availability_start_time= date('h:i', strtotime($practionar_record_find_in_available_table['availability_start_time']));
    }else{
       $availability_start_time= "";
    }

    if($practionar_record_find_in_available_table['availability_end_time'] != ""){
      $availability_end_time= date('h:i', strtotime($practionar_record_find_in_available_table['availability_end_time']));
    }else{
      $availability_end_time="";
    }

    if($practionar_record_find_in_available_table['break1_start_time'] != ""){
      $break1_start_time= date('h:i', strtotime($practionar_record_find_in_available_table['break1_start_time']));
    }else{
      $break1_start_time= "";
    }

    if($practionar_record_find_in_available_table['break1_end_time'] != ""){
     $break1_end_time= date('h:i', strtotime($practionar_record_find_in_available_table['break1_end_time']));
    }else{
      $break1_end_time="";
    }

    if($practionar_record_find_in_available_table['break2_start_time'] != ""){
      $break2_start_time= date('h:i', strtotime($practionar_record_find_in_available_table['break2_start_time']));
    }else{
       $break2_start_time="";
    }

    if($practionar_record_find_in_available_table['break2_end_time'] != ""){
      $break2_end_time= date('h:i', strtotime($practionar_record_find_in_available_table['break2_end_time']));
    }else{
      $break2_end_time="";
    }

    if($practionar_record_find_in_available_table['break3_start_time'] != ""){
       $break3_start_time= date('h:i', strtotime($practionar_record_find_in_available_table['break3_start_time']));
    }else{
      $break3_start_time="";
    }

    if($practionar_record_find_in_available_table['break3_end_time'] != ""){
     $break3_end_time= date('h:i', strtotime($practionar_record_find_in_available_table['break3_end_time']));
    }else{
      $break3_end_time="";
    } 
    //for update edit in same form access end

      return view('frontend/business-manager/appointment-management/practionar-availabilaty_days_breaks',compact('practionar','hashemployeeid','dayname','practionar_id','practionar_record_find_in_available_table','day_name','availability_start_time','availability_end_time','break1_start_time','break1_end_time','break2_start_time','break2_end_time','break3_start_time','break3_end_time','practionar_employee_id'));
    } 

    public function save(Request $request){
       $messages = [
                  "availability_start_time.required" => "Please select availability start time",
                  "availability_end_time.required" => "Please select availability end time",
                  "availability_end_time.after" => "Availability end time must be after start time",
                ];
      $rules = array(
                  'availability_start_time' => 'required',
                  'availability_end_time' => 'required|after:availability_start_time',
                 );
      $validator = Validator::make($request->all(), $rules,$messages);
      //validation for business time with availability time.


     $availability_from_time=date("H:i", strtotime($request->get('availability_start_time')));
     $availability_to_time=date("H:i", strtotime($request->get('availability_end_time')));
     $appointment_settings = AppointmentSettings::where('manager_id',Auth::user()->id)->first();
     $str_start= $appointment_settings['business_time_start'];
     $str_end= $appointment_settings['business_time_end'];
     $start_busines_at=($str_start<10 ? '0'.$str_start:$str_start).":00";
     $start_busines_to=($str_end<10 ? '0'.$str_end:$str_end).":00";
     //available time checking validation start
     if($start_busines_at > $availability_from_time) {
         $validator->after(function() use ($validator) {
          $validator->errors()->add('availability_start_time', 'Your availability time must between besiness time');
          });
      }
      if($start_busines_to < $availability_to_time) {
         $validator->after(function() use ($validator) {
          $validator->errors()->add('availability_end_time', 'Your availability time must between besiness time');
          });
      }
      //available time checking validation end

      //break1 time checking validation start
      if($request->get('break1_start_time') != null && $request->get('break1_end_time') != null) {
          $break1_start_time=date("H:i", strtotime($request->get('break1_start_time')));
          $break1_end_time=date("H:i", strtotime($request->get('break1_end_time')));
          $availability_from_time=date("H:i", strtotime($request->get('availability_start_time')));
          $availability_to_time=date("H:i", strtotime($request->get('availability_end_time'))); 
          if($break1_start_time == $break1_end_time){
                $validator->after(function() use ($validator) {
                $validator->errors()->add('break1_start_time', 'Break-1 end time and  break-1 start time should not equal');
              });
          }elseif($break1_start_time > $break1_end_time){
            $validator->after(function() use ($validator) {
                $validator->errors()->add('break1_start_time', 'Break-1 end time more than break-1 start time');
              });
          }
          if($break1_start_time < $availability_from_time){
                $validator->after(function() use ($validator) {
                $validator->errors()->add('break1_start_time', 'Break-1 end time and  break-1 start between available time');
              });
          }
          if($break1_start_time > $availability_to_time){
                $validator->after(function() use ($validator) {
                $validator->errors()->add('break1_start_time', 'Break-1 end time and  break-1 start between available time');
              });
          }
          if($break1_end_time > $availability_to_time){
                $validator->after(function() use ($validator) {
                $validator->errors()->add('break1_start_time', 'Break-1 end time and  break-1 start between available time');
              });
          }

      }
      //break1 time checking validation end

      //break2 time checking validation start
      if($request->get('break2_start_time') != null && $request->get('break2_end_time') != null) {
          $break1_end_time=date("H:i", strtotime($request->get('break1_end_time')));
          $break2_start_time=date("H:i", strtotime($request->get('break2_start_time')));
          $break2_end_time=date("H:i", strtotime($request->get('break2_end_time')));
          $availability_from_time=date("H:i", strtotime($request->get('availability_start_time')));
          $availability_to_time=date("H:i", strtotime($request->get('availability_end_time'))); 
          if($break2_start_time == $break2_end_time){
                $validator->after(function() use ($validator) {
                $validator->errors()->add('break2_start_time', 'Break-2 end time and  break-2 start time should not equal');
              });
          }elseif($break2_start_time > $break2_end_time){
            $validator->after(function() use ($validator) {
                $validator->errors()->add('break2_start_time', 'Break-2 end time more than break-2 start time');
              });
          }
          //this condition for after break1 time breake2 have to start
          if($break1_end_time > $break2_start_time){
             $validator->after(function() use ($validator) {
                $validator->errors()->add('break2_start_time', 'Must break-2 have to start after break-1 end time');
              });
          }
          //this condition for after break1 time breake2 have to start end
          if($break2_start_time < $availability_from_time){
                $validator->after(function() use ($validator) {
                $validator->errors()->add('break2_start_time', 'Break-2 end time and  break-2 start between available time');
              });
          }
          if($break2_start_time > $availability_to_time){
                $validator->after(function() use ($validator) {
                $validator->errors()->add('break2_start_time', 'Break-2 end time and  break-2 start between available time');
              });
          }
          if($break2_end_time > $availability_to_time){
                $validator->after(function() use ($validator) {
                $validator->errors()->add('break2_start_time', 'Break-2 end time and  break-2 start between available time');
              });
          }

      }
      //break2 time checking validation end

      //break3 time checking validation start
      if($request->get('break3_start_time') != null && $request->get('break3_end_time') != null) {
          $break2_end_time=date("H:i", strtotime($request->get('break2_end_time')));
          $break3_start_time=date("H:i", strtotime($request->get('break3_start_time')));
          $break3_end_time=date("H:i", strtotime($request->get('break3_end_time')));
          $availability_from_time=date("H:i", strtotime($request->get('availability_start_time')));
          $availability_to_time=date("H:i", strtotime($request->get('availability_end_time'))); 
          if($break3_start_time == $break3_end_time){
                $validator->after(function() use ($validator) {
                $validator->errors()->add('break3_start_time', 'Break-3 end time and  break-3 start time should not equal');
              });
          }elseif($break3_start_time > $break3_end_time){
            $validator->after(function() use ($validator) {
                $validator->errors()->add('break3_start_time', 'Break-3 end time more than break-3 start time');
              });
          }
          //this condition for after break2 time breake3 have to start
          if($break2_end_time > $break3_start_time){
             $validator->after(function() use ($validator) {
                $validator->errors()->add('break2_start_time', 'Must break-3 have to start after break-2 end time');
              });
          }
          //this condition for after break2 time breake3 have to start end
          if($break3_start_time < $availability_from_time){
                $validator->after(function() use ($validator) {
                $validator->errors()->add('break3_start_time', 'Break-3 end time and  break-3 start between available time');
              });
          }
          if($break3_start_time > $availability_to_time){
                $validator->after(function() use ($validator) {
                $validator->errors()->add('break3_start_time', 'Break-3 end time and  break-3 start between available time');
              });
          }
          if($break3_end_time > $availability_to_time){
                $validator->after(function() use ($validator) {
                $validator->errors()->add('break3_start_time', 'Break-3 end time and  break-3 start between available time');
              });
          }

      }
      //break3 time checking validation end
     
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
      $data= $request->all();
      //break1 starting
      if($data['break1_start_time'] != null){
        $break1_start=date("H:i", strtotime($data['break1_start_time']));
      }else{
        $break1_start="";
      }

      if($data['break1_end_time'] != null){
        $break1_end=date("H:i", strtotime($data['break1_end_time']));
      }else{
        $break1_end="";
      }
       //break1 ending

       //break2 starting
      if($data['break2_start_time'] != null){
        $break2_start=date("H:i", strtotime($data['break2_start_time']));
      }else{
        $break2_start="";
      }

      if($data['break2_end_time'] != null){
        $break2_end=date("H:i", strtotime($data['break2_end_time']));
      }else{
        $break2_end="";
      }
       //break2 ending

       //break3 starting
      if($data['break3_start_time'] != null){
        $break3_start=date("H:i", strtotime($data['break3_start_time']));
      }else{
        $break3_start="";
      }

      if($data['break3_end_time'] != null){
        $break3_end=date("H:i", strtotime($data['break3_end_time']));
      }else{
        $break3_end="";
      }
       //break3 ending
       $employee_record = PractionarAvailabilityAndBreaks::create([
                             'availability_start_time'=>date("H:i", strtotime($data['availability_start_time'])),
                             'availability_end_time'=>date("H:i", strtotime($data['availability_end_time'])),
                             'break1_start_time'=>$break1_start,
                             'break1_end_time'=>$break1_end,
                             'break2_start_time'=>$break2_start,
                             'break2_end_time'=>$break2_end,
                             'break3_start_time'=>$break3_start,
                             'break3_end_time'=>$break3_end,     
                             'day_name'=>$data['dayname'],     
                             'manager_id'=>Auth::user()->id,     
                             'practionar_employee_id'=>$data['practionar_id'],         
                            ]);
        /* return $client_record;*/                                               
          $url = url('manager/face-to-face-consultation-settings');
              if ($request->ajax()) {
                      return response()->json(array(
                        'success' => 'Apoointment Created Successfully',
                        'modal' => true,
                        'redirect_url' => $url,
                        'status' => 200,
                        ), 200);
              }else{
                      return redirect()->intended($url)->with('success', 'Practionar available days and breaks created success fully');
              }           
      }
    }
  //practionar  settings end


                        
}







me'=>date("H:i", strtotime($data['availability_end_time'])),
                             'break1_start_time'=>$break1_start,
                             'break1_end_time'=>$break1_end,
                             'break2_start_time'=>$break2_start,
                             'break2_end_time'=>$break2_end,
                             'break3_start_time'=>$break3_start,
                             'break3_end_time'=>$break3_end,     
                             'day_name'=>$data['dayname'],     
                             'manager_id'=>Auth::user()->id,     
                             'practionar_employee_id'=>$data['practionar_id'],         
                            ]);
       }
      
        /* return $client_record;*/                                               
          $url = url('manager/face-to-face-consultation-settings');
              if ($request->ajax()) {
                      return response()->json(array(
                        'success' => 'Apoointment Created Successfully',
                        'modal' => true,
                        'redirect_url' => $url,
                        'status' => 200,
                        ), 200);
              }else{
                      return redirect()->intended($url)->with('success', 'Practionar available days and breaks created success fully');
              }           
      }
    }
  //practionar  settings end


                        
}







