<?php

namespace App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\FeedBackCategory;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use Mail;

class FeedbackController extends Controller {
    
    public function index(){
        $feedbacks=Feedback::all();
        $data=[];
        foreach($feedbacks as $feedback){
            $business_client=User::where('id',$feedback['business_client_id'])->first();
        	$data['client_name']=$business_client['name'];
        	$data['email']=$business_client['email'];
        	$rating_category=FeedBackCategory::where('id',$feedback['category_id'])->first();
        	$data['category_name']=$rating_category['category_name'];
        	$data['rating']=$feedback['rating'];
        	$data['created_record_date']=$feedback['created_record_date'];
        	$main[]=$data;
        }
     //   return $main;
		return view('admin/feedback-management/feedback-management',compact('main'));
    }	

		             	                  
}

