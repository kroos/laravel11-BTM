<?php
namespace App\Http\Middleware\Authorization;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// load string helper if somehow user not passing an array
use Illuminate\Support\Str;


class RedirectIfNotLoanOwner
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	// public function handle(Request $request, Closure $next, $highManagement, $dept): Response
	public function handle(Request $request, Closure $next): Response
	{
		// make sure its high management
		// dd($highManagement, $dept);

		dd($request->user()->isLoanOwner());







		// return redirect()->back();
		return $next($request);
	}
}
