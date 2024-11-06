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

class RedirectIfNotDeptApproverApprv
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
		if ($request->user()->isDeptApprover() == false) {
			return abort(401);
		} else {
			// dd($request->route());
			if ($request->route()->uri == 'loanapprvs' && is_null($request->route()->parameters)) {
				echo $request->route();
			} else {
				dd(count($request->route()->parameters));
			}





			// $stafs = Staff::find($request->route()->parameters['loanapprvs']['nostaf']);
			// $stafdepts = $stafs->belongstomanydepartment()->first()->kodjabatan;
			// // $stafdeptapprv = Arr::has($request->user()->isDeptApprover(), $stafdepts);
			// $stafdeptapprv = in_array($stafdepts, $request->user()->isDeptApprover());
			// // dd($request->user()->isDeptApprover(), $request->route()->parameters['loanapp']['nostaf'], $stafdepts, $stafdeptapprv);
			// if ($stafdeptapprv == false) {
			// 	return abort(401);
			// }
			// return $next($request);
		}
	}
}
