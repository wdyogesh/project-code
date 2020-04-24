<?php

namespace App\Http\Controllers\Frontend\Manager;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Models\Role;
use App\Models\UserAddresses;
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
use File;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Stripe\Error\Card;
class AddMoneyController extends Controller {

    public function payWithStripe()
    {   $data=Session::get('selected_package');
        $package_plan_access= SubscriptionUserLimit::where('id',$data['package_id'])->first();
        return view('frontend.business-manager.paywithstripe',compact('package_plan_access'));
    }

    public function postPaymentWithStripe(Request $request)
    {
          $data=Session::get('selected_package');
          $package_plan_access= SubscriptionUserLimit::where('id',$data['package_id'])->first();
        //return $request->all();
        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
            'amount' => 'required',
        ]);
        $input = $request->all();
        if ($validator->passes()) {           
            $input = array_except($input,array('_token'));            
            $stripe = Stripe::make('sk_test_99Lffg17pShejD3c4NnQP4KR');
            //dd($stripe);

            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number'    => $request->get('card_no'),
                        'exp_month' => $request->get('ccExpiryMonth'),
                        'exp_year'  => $request->get('ccExpiryYear'),
                        'cvc'       => $request->get('cvvNumber'),
                    ],
                ]);
               //dd($token);
                if (!isset($token['id'])) {
                    \Session::put('error','The Stripe Token was not generated correctly');
                    return redirect()->back();
                }
                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => 'USD',
                    'amount'   => $package_plan_access['price'],
                    'description' => 'Add in wallet',
                ]);
                //dd($charge);
                if($charge['status'] == 'succeeded') {

            //database store selscted package start
                $dt = Carbon::now();
                $search_manger_before_subscribed_or_not= FIrstTimeBusinessClientSubscription::where('user_id',$data['user_id'])->count();
                if($search_manger_before_subscribed_or_not == 0){
                    $first_time_manager_subscriptions=FIrstTimeBusinessClientSubscription::create([
                                'user_id' => $data['user_id'],
                                ]);
                }
                $manager_subscriptions = BusinessManagerSubscriptions::create([
                                'user_id' => $data['user_id'],
                                'package_name' => $package_plan_access['package_name'],
                                'data_size' => $package_plan_access['data_size'],
                                'user_size_from' => $package_plan_access['user_size_from'],
                                'user_size_to' => $package_plan_access['user_size_to'],
                                'price' => $package_plan_access['price'],
                                'subscription_date'=>$dt->toDayDateTimeString(),
                                'currency_type'=>'USD',
                                'payment_status'=>$charge['status'],
                                ]);
        //database store selscted package end
                    \Session::put('success','Money add successfully in wallet');
                    return redirect()->back();
                } else {
                    \Session::put('error','Money not add in wallet!!');
                    return redirect()->back();
                }
            } catch (Exception $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }
        \Session::put('error','All fields are required!!');
        return redirect()->back();
    }    

   
}







