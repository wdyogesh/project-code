<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class OtherPartyMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
       $role_id=Auth::user();
        $isEmployee = false;  
        if($role_id['role_id'] == 5)
        {
            $isEmployee = true;
        }else{
            return redirect()->to('other-party-login');
        }
	    // snippet ci-dessous selon doc de Laravel
	    if( !$isEmployee )
	    {
	        if ($request->ajax()) {
	            return response('Unauthorized.', 401);
	        } else {
	            return redirect()->to('other-party-login')->with('message','Sorry, You Are Unauthorized Person to access...'); //todo h peut-etre une fenetre modale pour dire acces refusé ici...
	        }
	    }

	    return $next($request);
	}
}
