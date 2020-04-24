<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\SubscriptionUserLimit;
use App\Models\BusinessManagerSubscriptions;
use App\Models\FIrstTimeBusinessClientSubscription;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use Mail;

class BusinessManagersSubscriptions extends Controller {
   
  public function index(){
  	  $all_business_mnagers_subscriptions= User::join('first_time_business_client_subscription as info', 'info.user_id', '=', 'users.id')
  	               ->join('manager_business_details as business', 'business.user_id', '=', 'users.id')
                   ->select('*','users.id as main_user_id')
                   ->get();
  
      return view('admin/business-manager-subscriptions/business-manager-subscriptions',compact('all_business_mnagers_subscriptions'));		  
  }
  public function businessLevelSubscriptions($hashid){
  	  $manager_id = Hashids::decode($hashid)[0];
  	  $business_manager= User::where('id',$manager_id)->first();

     $business_mnager_level_all_subscriptions= BusinessManagerSubscriptions::where('user_id',$manager_id)->get();
  
      return view('admin/business-manager-subscriptions/business-manager-level-idividual-subscriptions',compact('business_mnager_level_all_subscriptions','business_manager'));		  
  }




}
