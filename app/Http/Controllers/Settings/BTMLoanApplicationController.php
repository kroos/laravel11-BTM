<?php
namespace App\Http\Controllers\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// models
use App\Models\LoanApplication;
use App\Models\LoanEquipment;
use App\Models\Jabatan;

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
use App\Mail\ToApplicantBTMApproval;

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

class BTMLoanApplicationController extends Controller
{
	function __construct()
	{
		$this->middleware('BTMAdmin');
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(): View
	{
		$loans = LoanApplication::where('active', 1)->whereIn('status_loan_id', [1,3])->get();
		return view('settings.btm.index', ['loans' => $loans]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): View
	{
		return view('settings.btm.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request): RedirectResponse
	{

	}

	/**
	 * Display the specified resource.
	 */
	public function show(LoanApplication $btmloanapplication)/*: View*/
	{
		$pdf = Pdf::loadView('settings.btm.show', ['btmloanapplication' => $btmloanapplication])->setOption(['dpi' => 120]);
		return $pdf->stream('BTM-LE-'.Carbon::parse($btmloanapplication->created_at)->format('ym').str_pad( $btmloanapplication->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// return view('settings.btm.show', ['btmloanapplication' => $btmloanapplication]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(LoanApplication $btmloanapplication): View
	{
		return view('settings.btm.edit', ['loanapp' => $btmloanapplication]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, LoanApplication $btmloanapplication): RedirectResponse
	{
		// dd($request->all());
		$request->validate([
				'date_loan_from' => 'required|date_format:"Y-m-d"',
				'date_loan_to' => 'required|date_format:"Y-m-d"',
				'loan_purpose' => 'required',
				'lequ.*.equipment_id' => 'required',
				'lequ.*.taken_on' => 'nullable|date_format:"Y-m-d"',
				'lequ.*.return_on' => 'nullable|date_format:"Y-m-d"',
				'lequ.*.status_item_id' => 'nullable',
				'lequ.*.status_condition_remarks' => 'required_unless:lequ.*.status_item_id, 1',
				'status_loan_id' => 'required',
				'btm_remarks' => 'required_if:status_loan_id, 2',
			], [
				'date_loan_from' => 'Please insert :attribute',
				'date_loan_to' => 'Please insert :attribute',
				'loan_purpose' => 'Please insert :attribute',
				'lequ.*.equipment_id' => 'Please choose :attribute at #:position',	//:index
				'lequ.*.taken_on' => 'Please choose :attribute at #:position',
				'lequ.*.return_on' => 'Please choose :attribute at #:position',
				'lequ.*.status_item_id' => 'Please choose :attribute at #:position',
				'lequ.*.status_condition_remarks' => 'Please choose :attribute at #:position',
				'status_loan_id' => 'Please choose :attribute',
				'btm_remarks' => 'Please insert :attribute',
			], [
				'date_loan_from' => 'Date From',
				'date_loan_to' => 'Date To',
				'loan_purpose' => 'Purpose of Loan',
				'lequ.*.equipment_id' => 'Equipment',
				'lequ.*.taken_on' => 'Equipment Taken On',
				'lequ.*.return_on' => 'Equipment Return On',
				'lequ.*.status_item_id' => 'Equipment Status After Return',
				'lequ.*.status_condition_remarks' => 'Equipment Remarks',
				'status_loan_id' => 'Loan Status',
				'btm_remarks' => 'BTM Remarks',
		]);

		$data = $request->only(['date_loan_from', 'date_loan_to']);
		$data += ['loan_purpose' => ucwords(Str::lower(trim($request->loan_purpose)))];
		$data += ['status_loan_id' => $request->status_loan_id];
		$data += ['btm_approver' => \Auth::user()->nostaf];
		$data += ['btm_date' => now()];
		$data += ['btm_remarks' => ucwords(Str::lower(trim($request->btm_remarks)))];
		if ($request->has('lequ')) {
			$btmloanapplication->update($data);
			foreach ($request->lequ as $k => $v) {
				// $btmloanapplication->hasmanyequipments()->updateOrCreate(
				LoanEquipment::updateOrCreate(
					[
						'id' => $v['id'],
						'application_id' => $btmloanapplication->id,
					],
					[
						'equipment_id' => $v['equipment_id'],
						'status_item_id' => $v['status_item_id'],
						'taken_on' => $v['taken_on'],
						'return_on' => $v['return_on'],
						'status_condition_remarks' => ucwords(Str::lower(trim($v['status_condition_remarks']))),
					]
				);
			}

			Pdf::loadView('settings.btm.show', ['btmloanapplication' => $btmloanapplication])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-'.Carbon::parse($btmloanapplication->created_at)->format('ym').str_pad( $btmloanapplication->id, 3, "0", STR_PAD_LEFT).'.pdf');

			// mail to self
			Mail::to($btmloanapplication->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->email, $btmloanapplication->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->nama)
				// ->cc($moreUsers)
				// ->bcc($evenMoreUsers)
				->send(new ToApplicantBTMApproval($btmloanapplication));
		} else {
			return redirect()->back()->with('danger', 'There are some error. Please try again later.');
		}
		return redirect()->route('btmloanapplications.index')->with('success', 'Successfully Update Loan Equipment');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(LoanApplication $btmloanapplication): JsonResponse
	{

	}
}
