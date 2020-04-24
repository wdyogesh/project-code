<?php

namespace App\Http\Controllers\Frontend\Manager;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\BusinessManagersEmployeeRole;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;

class BusinessManagersEmployeeRoleController extends Controller {

   /**
   * Show the all roles of employees under business manager level.
   */ 
    public function index(){ 

     /*$Business_manager_employee_roles = BusinessManagersEmployeeRole::where('manager_id',Auth::user()->id)->get();*/
     $Business_manager_employee_roles = BusinessManagersEmployeeRole::all();
	
	 return view('frontend.business-manager.employee-role-management.manag_roles',compact('Business_manager_employee_roles'));
    }
    
    /**
   * Create roles of employees under business manager level.
   */ 
    public function createRole(){ 
    	  
	 return view('frontend.business-manager.employee-role-management.create-role');
    }
    
    /**
	   * Store Roles of employees under business manager level.
	   *
	   * @param  Request  $request
	   * @return Response
    */
    public function storeRole(Request $request){ 
      /* return $request->all();*/
        $messages = [
				     "role_name.required" => "Role name required.",
				    ];
        $rules = array(
		'role_name' => 'required',
		);
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
           // return 'hai';
			$data= $request->all();	
			
	        $rolename_exist = BusinessManagersEmployeeRole::manager()->where('employee_role_name',$data['role_name'])->get();
            if(count($rolename_exist) != 0){

            return redirect()->back()->withInput()->with('fail', 'Sorry!.., Role Already Existed');
            	
            }else{	           
		            $dt = Carbon::now();
				    $role = BusinessManagersEmployeeRole::create([
		                            	'employee_role_name'=>$data['role_name'],
			                            'active'=>1,
			                            'created_record_date'=>$dt->toDayDateTimeString(),
				                        ]);	    
					//return $role;                               			
					$url = url('manager/employee-roles');
					if ($request->ajax()){
			            return response()->json(array(
			              'success' => 'Role Created Successfully',
			              'modal' => true,
			              'redirect_url' => $url,
			              'status' => 200,
			              ), 200);
			        }else{
			            return redirect()->intended($url)->with('success', 'Role Created Successfully');
			        }
			}    
			        
		}
    }
    
    /**
	   * Edit the role details.
	   *
	   * @param  int  $hashid
	   * @return Response $roles_record_edit
    */
    public function editRole($hashid){
    	$role_id = Hashids::decode($hashid)[0];
    	$roles_record_edit= BusinessManagersEmployeeRole::where('id',$role_id)->first();
    	return view('frontend.business-manager.employee-role-management.edit-role',compact('roles_record_edit'));
    }

    /**
	   * Update Roles of employees under business manager level.
	   *
	   * @param  Request  $request
	   * @return Response
    */
    public function updateRole(Request $request){
    	//return $request->all();
    	$messages = [
				     "role_name.required" => "Role name must required.",
				    ];
    	   
		$rules = array(
					'role_name' => 'required',
			        );
		$validator = Validator::make($request->all(), $rules,$messages);
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
            $role = BusinessManagersEmployeeRole::findOrFail($data['role_id']);
            $role->employee_role_name=$data['role_name'];
            $role->updated_record_date=$dt->toDayDateTimeString();
            $role->save();		         
	        //return $role;			
			$url = url('manager/employee-roles');
	        if($request->ajax()){
	            return response()->json(array(
	              'success' => 'Role Updated Successfully',
	              'modal' => true,
	              'redirect_url' => $url,
	              'status' => 200,
	              ), 200);
		    }else{
		        return redirect()->intended($url)->with('success', 'Role Record Updated Successfully');
		    }
				  
		}

    }

    /**
	   * Delete Roles of employees under business manager level.
	   *
	   *  @param  int  $id
	   * @return Response $role
    */
    public function deleteRole($id){      
        $role = BusinessManagersEmployeeRole::find($id);
        $role->delete();	
	    return response()->json($role);
    }			                  
}







