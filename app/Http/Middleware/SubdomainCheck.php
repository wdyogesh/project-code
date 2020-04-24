<?php
namespace App\Http\Middleware;

use Closure;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Session;
use App\User;
use App\Models\ManagerBusinessDetails;
class SubdomainCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
   public function handle($request, Closure $next)
   {
     $pieces = explode('.', $request->getHost());
     $check_business=ManagerBusinessDetails::where('businesss_name',$pieces[0])->get();
    if(count($check_business) == 0)
    {
         return redirect()->to('manager/login')
    }
    return $next($request);
  }
}