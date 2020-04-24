<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class ManagerMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
       $role_id=Auth::user();
        $isManager = false;  
        if($role_id['role_id'] == 2)
        {
            $isManager = true;
        }else{
            //return redirect()->to('manager-login');
            return redirect()->to('manager-logout');
            //return redirect()->to('http://intell-comm.com/manager-login');
        }
	    // snippet ci-dessous selon doc de Laravel
	    if( !$isManager )
	    {
	        if ($request->ajax()) {
	            return response('Unauthorized.', 401);
	        } else {
	           return redirect()->to('http://intell-comm.com/manager-login')->with('message','Sorry, You Are Unauthorized Person to access...'); //todo h peut-etre une fenetre modale pour dire acces refusé ici...
	        }
	    }

	    return $next($request);
	}
}
