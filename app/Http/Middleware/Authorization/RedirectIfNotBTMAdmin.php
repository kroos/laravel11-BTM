<?php
namespace App\Http\Middleware\Authorization;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// load string helper if somehow user not passing an array
use Illuminate\Support\Str;


class RedirectIfNotBTMAdmin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next): Response
	{
		if($request->user()->isBTMAdmin()) {
			return $next($request);
		}
		// return redirect()->back();
		return abort(401);
	}
}
