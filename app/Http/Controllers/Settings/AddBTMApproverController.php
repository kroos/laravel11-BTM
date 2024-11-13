<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// models
use App\Models\Staff;
use App\Models\Jabatan;
use App\Models\Settings\BTMApprover;

// load db facade
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

// for controller output
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

// load array helper
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

// load Carbon
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \Carbon\CarbonInterval;

use Session;
use Throwable;
use Exception;
use Log;

class AddBTMApproverController extends Controller
{
	function __construct()
	{
		// $this->middleware(['auth']);
		$this->middleware('BTMAdmin');
	}

	public function index(): View
	{
		return view('settings.btmapprover.index');
	}

	public function create(): View
	{
		$stffbtms = Jabatan::where('kodjabatan', 'PTM2')->get();
		foreach ($stffbtms as $stffbtm) {
			$stfbtm = $stffbtm->belongstomanystaff()->where('status', 'A')->get();
		}
		return view('settings.btmapprover.create', ['stfbtm' => $stfbtm]);
	}

	public function store(Request $request):JsonResponse
	{
		// dd($request->all());
		$data = $request->validate([
				'nostaf' => 'required|alpha_num:ascii"',
				// 'active' => 'boolean',
			], [
				'nostaf' => 'Please insert :attribute',
				// 'active' => 'Please choose :attribute at #:position',	//:index
			], [
				'nostaf' => 'Staff Name',
				// 'active' => '',
		]);

		if($request->active == 'true') {
			BTMApprover::updateOrCreate([
					'nostaf' => $request->nostaf
				], [
					'active' => 1
				]);
			$message = 'Staff Appointed!';
		}

		if($request->active == 'false'){
				BTMApprover::updateOrCreate([
						'nostaf' => $request->nostaf
					], [
						'active' => 0
					]);
				$message = 'Unappointed Staff!';
			}
			return response()->json([
				'message' => 'Unappointed Staff!',
				'status' => 'success'
			]);
	}

	public function show(BTMApprover $btmapprover): View
	{
		//
	}

	public function edit(BTMApprover $btmapprover): View
	{
	}

	public function update(Request $request, BTMApprover $btmapprover)
	{
		dd($request->all());
		$request->validate([
				'nostaf' => 'required|string"',
				'active' => 'required|boolean',
			], [
				'nostaf' => 'Please insert :attribute',
				'active' => 'Please choose :attribute at #:position',	//:index
			], [
				'nostaf' => 'Staff Name',
				'active' => '',
		]);
		$btmapprover->updateOrCreate([
				'nostaf' -> $request->nostaf
			],[
				'active' => $request->active
			]);
		return response()->json([
			'message' => 'Staff Appointed!',
			'status' => 'success'
		]);
	}

	public function destroy(BTMApprover $btmapprover): JsonResponse
	{
	}

}
