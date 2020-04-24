<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
class APIController extends Controller
{
    public function index()
    {
        $countries = DB::table("countries")->pluck("name","id");
        return view('countrys',compact('countries'));
    }
    public function getStateList(Request $request)
    {
        /*return $request->country;*/
       $countrie = DB::table("countries")->where('name',$request->country)->first();
        $states = DB::table("states")
                    ->where("country_id",$countrie->id)
                    ->pluck("name","id");
        return response()->json($states);
    }
    public function getCityList(Request $request)
    {
        $state = DB::table("states")->where('name',$request->state)->first();
        $cities = DB::table("cities")
                    ->where("state_id",$state->id)
                    ->pluck("name","id");
        return response()->json($cities);
    }

    public function countrycodes($name){
        $country=DB::table('countries')->where('name',$name)->first();
        return response()->json($country);
    }

    
}