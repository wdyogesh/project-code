<?php

namespace App\Http\Controllers\Frontend\Manager;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\Appointments;
use App\Models\Audit;
use App\Models\Calendar;
use App\Models\SecurityQuestions;
use App\Models\BusinessProfessionCategory;
use App\Models\BusinessProfessionTypes;
use App\Models\Employee;
use App\Models\ManagerClients;
use App\Models\ManagerBusinessDetails;
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

class AuditController extends Controller {
	
    
  public function index(){
    $employee_ids=Employee::where('manager_id', Auth::user()->id)->pluck('employee_id');
    $audits_manager=Audit::where('user_id',Auth::user()->id)->get();
  	/*dd($audits_manager);*/
  	$data=[];
  	foreach($audits_manager as $audit){
  		//here i applied only main role next you can apply emmployee role remember
  		$managers_employees= User::join('roles as mainroles', 'mainroles.id', '=', 'users.role_id')
                   ->where('users.id',$audit->user_id)
                   ->select('users.name','mainroles.role_name')
                   ->first();
       
  	    $data['effect_table_name']=$audit->auditable_type::getTableName();              
        $data['changed_by']= $managers_employees['name'];           
        $data['role']= $managers_employees['role_name']; 
        $data['event']= $audit->event; 
        $data['date']= $audit->updated_at; 
        $data['audit_id']= $audit->id; 
        $data['ip_address']= $audit->ip_address; 
        $data['user_agent']= $audit->user_agent; 
        $data['old_values']= $audit->old_values; 
        $data['new_values']= $audit->new_values; 
        $main[]=$data;          

  	}

  	/*return $main[0]['changed_by'];*/
  	/*dd($main);*/
  /*	dd($audits_manager); */
    return view('frontend/business-manager/audit-management/audit-management',compact('main'));
  }

  public function details($subdomain,$id){
      $audits_manager=Audit::whereId($id)->first();  
      /*dd($audits_manager->new_values);	 */
     /*return $data=$audits_manager->new_values;*/
      $new_inserted_data=json_decode($audits_manager->new_values);
      $old_data=json_decode($audits_manager->old_values);
     // return $data
      return view('frontend/business-manager/audit-management/load_audit_details',compact('new_inserted_data','old_data'));

  	
  }			                  
}







