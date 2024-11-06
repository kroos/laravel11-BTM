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
	function __construct()
	{
		$this->middleware(['auth']);
		$this->middleware('BTMAdmin');
	}

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
		$request->validate([
				'approver.*.nostaf' => 'required',
				'approver.*.kod_jabatan' => 'required',
			], [
				'approver.*.nostaf' => 'Please choose :attribute',
				'approver.*.kod_jabatan.required' => 'Please choose :attribute',
			], [
				'approver.*.nostaf' => 'Approver',
				'approver.*.kod_jabatan' => 'Department',
		]);
		// dd($request->all());
		if ($request->has('approver')) {
			foreach ($request->approver as $k => $v) {
				Approver::create([
					'nostaf' => $v['nostaf'],
					'kod_jabatan' => $v['kod_jabatan'],
					'active' => 1,
				]);
			}
		} else {
			return redirect()->back()->with('danger', 'There are some error.');
		}
		return redirect()->route('addapprover.index')->with('success', 'Successfully Add Approver');
	}

	public function show(Approver $addapprover): View
	{
		//
	}

	public function edit(Approver $addapprover): View
	{
		return view('settings.addapprover.edit', ['approvers' => $addapprover]);
	}

	public function update(Request $request, Approver $addapprover): RedirectResponse
	{
		// $Staff->update($request->except(['_method', '_token']));
		// Session::flash('flash_message', 'Data successfully updated!');
		// return Redirect::route('Staff.index');
	}

	public function destroy(Approver $addapprover): JsonResponse
	{
		// dd($addapprover);
		// $addapprover->delete();
		$data = ['active' => 0];
		$addapprover->update($data);
		// Approver::destroy($addapprover->id);
		return response()->json([
			'message' => 'Data deleted',
			'status' => 'success'
		]);
	}

}
