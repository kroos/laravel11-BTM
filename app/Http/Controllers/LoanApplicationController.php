<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// models
use App\Models\LoanApplication;
use App\Models\LoanEquipment;

// load db facade
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

// for controller output
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

// load pdf
use Barryvdh\DomPDF\Facade\Pdf;

// send email
use Illuminate\Support\Facades\Mail;
use App\Mail\ToApplicant;

// load helper
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

// load Carbon
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \Carbon\CarbonInterval;

use Session;
use Throwable;
use Exception;
use Log;

class LoanApplicationController extends Controller
{
	function __construct()
	{
		// $this->middleware(['auth']);
		$this->middleware('loanOwner', ['only' => ['show', 'edit', 'update', 'destroy']]);
		$this->middleware('deptApprover', ['only' => ['show', 'edit']]);
		// $this->middleware('BTMAdmin');
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(): View
	{
		$loans = LoanApplication::where('active', 1)->get();
		return view('loan.index', ['loans' => $loans]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): View
	{
		return view('loan.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request): RedirectResponse
	{
		// dd($request->all());
		$request->validate([
				'date_loan_from' => 'required|date_format:"Y-m-d"',
				'date_loan_to' => 'required|date_format:"Y-m-d"',
				'loan_purpose' => 'required',
				'lequ.*.equipment_id' => 'required',
			], [
				'date_loan_from' => 'Please insert :attribute',
				'date_loan_to' => 'Please insert :attribute',
				'loan_purpose' => 'Please insert :attribute',
				'lequ.*.equipment_id' => 'Please choose :attribute at #:position',	//:index
			], [
				'date_loan_from' => 'Date From',
				'date_loan_to' => 'Date To',
				'loan_purpose' => 'Purpose of Loan',
				'lequ.*.equipment_id' => 'Equipment',
		]);

		$data = $request->only(['date_loan_from', 'date_loan_to']);
		$data += ['loan_purpose' => ucwords(Str::lower(trim($request->loan_purpose)))];
		$data += ['active' => 1];
		$data += ['status_loan_id' => 3];
		if ($request->has('lequ')) {
			$r = \Auth::user()->belongstostaff->hasmanyloan()->create($data);
			foreach ($request->lequ as $k => $v) {
				$r->hasmanyequipments()->create([
					'equipment_id' => $v['equipment_id'],
					'status_item_id' => 1,
				]);
			}

			Pdf::loadView('loan.show', ['loanapp' => $r])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-'.Carbon::parse($r->created_at)->format('ym').str_pad( $r->id, 3, "0", STR_PAD_LEFT).'.pdf');

			// send to self
			Mail::to($r->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->email, $r->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->nama)
				// ->cc($moreUsers)
				// ->bcc($evenMoreUsers)
				->send(new ToApplicant($r));

		} else {
			return redirect()->back()->with('danger', 'There are some error. Please try again later.');
		}
		return redirect()->route('loanapps.index')->with('success', 'Successfully Apply Loan Equipment & Informing The Approver');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(LoanApplication $loanapp)/*: View*/
	{
		$pdf = Pdf::loadView('loan.show', ['loanapp' => $loanapp])->setOption(['dpi' => 120]);
		return $pdf->stream('BTM-LE-'.Carbon::parse($loanapp->created_at)->format('ym').str_pad( $loanapp->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// return view('loan.show', ['loanapp' => $loanapp]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(LoanApplication $loanapp): View
	{
		return view('loan.edit', ['loanapp' => $loanapp]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, LoanApplication $loanapp): RedirectResponse
	{
		// dd($request->all());
		$request->validate([
				'date_loan_from' => 'required|date_format:"Y-m-d"',
				'date_loan_to' => 'required|date_format:"Y-m-d"',
				'loan_purpose' => 'required',
				'lequ.*.equipment_id' => 'required',
			], [
				'date_loan_from' => 'Please insert :attribute',
				'date_loan_to' => 'Please insert :attribute',
				'loan_purpose' => 'Please insert :attribute',
				'lequ.*.equipment_id' => 'Please choose :attribute at #:position',	//:index
			], [
				'date_loan_from' => 'Date From',
				'date_loan_to' => 'Date To',
				'loan_purpose' => 'Purpose of Loan',
				'lequ.*.equipment_id' => 'Equipment',
		]);

		$data = $request->only(['date_loan_from', 'date_loan_to']);
		$data += ['loan_purpose' => ucwords(Str::lower(trim($request->loan_purpose)))];
		$data += ['active' => 1];
		$data += ['status_loan_id' => 3];
		if ($request->has('lequ')) {
			$loanapp->update($data);
			foreach ($request->lequ as $k => $v) {
				// $loanapp->hasmanyequipments()->updateOrCreate(
				LoanEquipment::updateOrCreate(
					[
						'id' => $v['id'],
						'application_id' => $loanapp->id,
					],
					[
						'equipment_id' => $v['equipment_id'],
						'status_item_id' => 1,
					]
				);
			}

			Pdf::loadView('loan.show', ['loanapp' => $loanapp])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-'.Carbon::parse($loanapp->created_at)->format('ym').str_pad( $loanapp->id, 3, "0", STR_PAD_LEFT).'.pdf');

			Mail::to($loanapp->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->email, $loanapp->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->nama)
				// ->cc($moreUsers)
				// ->bcc($evenMoreUsers)
				->send(new ToApplicantUpdate($loanapp));
		} else {
			return redirect()->back()->with('danger', 'There are some error. Please try again later.');
		}
		return redirect()->route('loanapps.index')->with('success', 'Successfully Update Loan Equipment');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(LoanApplication $loanapp): JsonResponse
	{
		$loanapp->update(['active' => 0]);
		return response()->json([
			'message' => 'Success deleted Loan Application',
			'status' => 'success'
		]);
	}
}
