<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// models
use App\Models\Staff;
use App\Models\Jabatan;
use App\Models\Settings\Approver;

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

use Session;
use Throwable;
use Exception;
use Log;


class AddApproverController extends Controller
{
	// function __construct()
	// {
	// 	$this->middleware(['auth']);
	// }

	public function index(): View
	{
		$apprs = Approver::where('active', 1)->get();
		return view('settings.addapprover.index', ['apprs' => $apprs]);
	}

	public function create(): View
	{
		return view('settings.addapprover.create');
	}

	public function store(Request $request): RedirectResponse
	{
		//
	}

	public function show(Staff $staff): View
	{
		//
	}

	public function edit(HRLeaveAnnual $staff): View
	{
		// return view('humanresources.hrdept.setting.Staff.edit', ['Staff' => $Staff]);
	}

	public function update(Request $request, Staff $staff): RedirectResponse
	{
		// $Staff->update($request->except(['_method', '_token']));
		// Session::flash('flash_message', 'Data successfully updated!');
		// return Redirect::route('Staff.index');
	}

	public function destroy(Staff $staff): JsonResponse
	{
		//
	}

}
