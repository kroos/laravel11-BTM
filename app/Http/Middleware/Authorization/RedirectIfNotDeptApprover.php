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
		if ($request->user()->isDeptApprover() == true) {
			// find dept for user
			$deptapprvs = \Auth::user()->belongstostaff->belongstomanydeptappr()->get();
			$m = [];
			foreach ($deptapprvs as $deptapprv) {
				$m[] = $deptapprv->kodjabatan;
			}

			// find dept from the uri
			$ruri = $request->route()->uri;
			$uri = trim(explode('/', $ruri)[0], 's');
			// dd($m, $ruri, $uri, $request->route()->parameters);

			if (count($request->route()->parameters)) {
				$stafs = Staff::find($request->route()->parameters["$uri"]['nostaf']);
				$stafdepts = $stafs->belongstomanydepartment()->first()->kodjabatan;
				$stafdeptapprv = in_array($stafdepts, $m);
				// dd($request->user()->isDeptApprover(), $request->route()->parameters['loanapp']['nostaf'], $stafdepts, $stafdeptapprv);
				if ($stafdeptapprv) {
					return $next($request);
				}
			}




		}
		return abort(401);
	}
}
