<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class web_installed
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
      $check = DB::table('settings')->where('is_web_purchased',0)->first();
      if(!empty($check)){
        return redirect('/web_not_installed');
      }
        return $next($request);
    }
}
