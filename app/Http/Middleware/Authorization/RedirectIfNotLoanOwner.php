<?php
namespace App\Http\Middleware\Authorization;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// load string helper if somehow user not passing an array
use Illuminate\Support\Str;

// load model
use App\Models\Staff;


class RedirectIfNotLoanOwner
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
		// dd($request->route());

		// preliminary settings
		$ruri = $request->route()->uri;
		$uri = explode('/', $ruri)[0];

		// for 'show', 'edit', 'update', 'destroy'
		if (count($request->route()->parameters)) {
			// dd($request->route()->parameters[$uri]['nostaf']);
			// for loan owner non approver
			if($request->route()->parameters[$uri]['nostaf'] == \Auth::user()->nostaf) {
				return $next($request);
			}

			// for dept approver
			if ($request->user()->isDeptApprover()) {
				// find dept for user
				$deptapprvs = \Auth::user()->belongstostaff->belongstomanydeptappr()->get();
				$m = [];
				foreach ($deptapprvs as $deptapprv) {
					$m[] = $deptapprv->kodjabatan;
				}
		 		$stafs = Staff::find($request->route()->parameters["$uri"]['nostaf']);
		 		$stafdepts = $stafs->belongstomanydepartment()->first()->kodjabatan;

		 		// find the same between session and url
		 		$stafdeptapprv = in_array($stafdepts, $m);
		 		if ($stafdeptapprv) {
		 			return $next($request);
		 		}
			}


		} else {
			// for 'index', 'create', 'store'

			// block dept approver from accessing create and store method
			if ($request->user()->isDeptApprover()) {
				// dd(explode('.', $request->route()->action['as'])[1]);
				$out = explode('.', $request->route()->action['as'])[1];
				if ($out != 'create') {
					return $next($request);
				}
			} else {
				return $next($request);
			}
		}

		if ($request->user()->isBTMAdmin()) {
			return $next($request);
		}

		return abort(401);
	}
}
