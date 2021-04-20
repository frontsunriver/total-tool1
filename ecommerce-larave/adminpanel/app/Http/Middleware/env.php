<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;
class env
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
      if(Auth::guard('customer')->check()){
        $user = auth()->guard('customer')->user();
        if($user->role_id != 1){
          Auth::guard('customer')->logout();
          return redirect('/maintance');
        }
        else{
        return $next($request);
       }
      }
      else{
        return redirect('/maintance');
      }
    }
}
