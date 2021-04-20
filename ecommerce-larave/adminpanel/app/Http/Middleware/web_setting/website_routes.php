<?php

namespace App\Http\Middleware\web_setting;

use Closure;
use Auth;
use DB;

class website_routes
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
      $check =  DB::table('settings')
                 ->where('name','is_web_purchased')
                 ->where('value',1)
                 ->first();
        if($check == null){
          return  redirect('not_allowed');
        }else{
          return $next($request);
        }
    }
}
