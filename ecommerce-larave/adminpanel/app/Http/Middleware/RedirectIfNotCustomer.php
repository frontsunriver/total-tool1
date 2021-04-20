<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
class RedirectIfNotCustomer
{
/**
 * Handle an incoming request.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \Closure  $next
 * @param  string|null  $guard
 * @return mixed
 */
public function handle($request, Closure $next, $guard = 'customer')
{
    if (Auth::guard($guard)->check() || Session::get('guest_checkout') == 1) {
      return $next($request);
    }
    return redirect('/login');
    }
}
