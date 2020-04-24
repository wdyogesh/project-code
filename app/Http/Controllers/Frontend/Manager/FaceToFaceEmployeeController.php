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
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use Mail;
use DB;

class FaceToFaceEmployeeController extends Controller {
 
  public function index($subdomain){
                           
    return view('frontend/business-manager/face-to-face-employees/face-to-face-employees');
  }

                        
}







