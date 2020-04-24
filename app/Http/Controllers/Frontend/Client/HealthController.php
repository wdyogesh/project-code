<?php

namespace App\Http\Controllers\Frontend\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\Role;
use App\Models\UserAddresses;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hashids;
use Carbon\Carbon;
use File;
use DB;
class RequestController extends Controller {

	public function index(){ 
      
		return view('frontend/client/request/request');
	}
}







