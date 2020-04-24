<?php
namespace App\Http\Controllers\Frontend\Manager;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SecurityQuestions;
use App\Models\BusinessProfessionCategory;
use App\Models\BusinessProfessionTypes;
use App\Models\ManagerAlternativeAccountFindingTable;
use App\Models\ManagerBusinessDetails;
use App\Models\Appointments;
use App\Models\Role;
use App\Models\UserAddresses;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Hashids;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Mail;
use DB;

class TestController extends Controller {

	//Admin Login Form displayed

   public function index(){
   return 'bye'; 
   	    //countries display
   	   /* $countries = DB::table("countries")->pluck("name","id");
	    $security_questions = SecurityQuestions::all();
		$business_profession_types = BusinessProfessionTypes::all();
		$category = BusinessProfessionCategory::all();	
		$business_categories = BusinessProfessionCategory::with('professions')->get();
		return view('frontend.business-manager.registration',compact('countries','security_questions','business_profession_types','business_categories'));*/
    }
	                  

}







