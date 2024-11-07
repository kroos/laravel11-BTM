<?php
namespace App\Http\Middleware\Authorization;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// load string helper if somehow user not passing an array
use Illuminate\Support\Str;

// load model
use \App\Models\Staff;

// load helper
use Illuminate\Support\Arr;

class RedirectIfNotDeptApprover
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
		// dd($request->route()->parameters);
		if ($request->user()->isDeptApprover() == false) {
			return abort(401);
		} else {

			if (($request->route()->uri == 'loanapprvs' || $request->route()->uri == 'loanapp') && (count($request->route()->parameters) == 0)) {
				return $next($request);
			} elseif(($request->route()->uri == 'loanapprvs' || $request->route()->uri == 'loanapp') && (count($request->route()->parameters) != 0)) {
				// get uri
				$uri = $request->route()->uri;
				$stafs = Staff::find($request->route()->parameters["$uri"]['nostaf']);
				$stafdepts = $stafs->belongstomanydepartment()->first()->kodjabatan;
				// $stafdeptapprv = Arr::has($request->user()->isDeptApprover(), $stafdepts);
				$stafdeptapprv = in_array($stafdepts, $request->user()->isDeptApprover());
				// dd($request->user()->isDeptApprover(), $request->route()->parameters['loanapp']['nostaf'], $stafdepts, $stafdeptapprv);
				if ($stafdeptapprv == false) {
					return abort(401);
				}
			}
			return $next($request);
		}
	}

if (expr) {

} elseif (expr) {

}


}
