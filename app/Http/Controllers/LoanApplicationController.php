<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// models
use App\Models\LoanApplication;
use App\Models\LoanEquipment;
use App\Models\Jabatan;
use App\Models\Settings\BTMApprover;
use App\Models\Login;

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
use App\Mail\ToApprover;
use App\Mail\ToApplicantUpdate;
use App\Mail\ToBTMLoanCreate;
use App\Mail\ToBTMLoanUpdate;

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
		$this->middleware('loanOwner', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
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
		// need to find approver -> find jabatan and then find approver
		$dept = \Auth::user()->belongstostaff->belongstomanydepartment->first()->kodjabatan;
		$apprv = Jabatan::find($dept);
		if($apprv->belongstomanyappr()->count()) {
			return view('loan.create');
		} else {
			return view('loan.create')->with('danger', 'Please inform BTM there are no Approver for you. BTM need to set the Approver.');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request): RedirectResponse
	{
		// dd(Jabatan::find(\Auth::user()->belongstostaff->belongstomanydepartment->first()->kodjabatan)->belongstomanyappr->first());
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

			// need to find approver -> find jabatan and then find approver
			$dept = \Auth::user()->belongstostaff->belongstomanydepartment->first()->kodjabatan;
			$apprv = Jabatan::find($dept)->belongstomanyappr;
			// dd($apprv->belongstomanyappr()->first());
			if($apprv->count()) {
				// send to approver
				Mail::to(Login::find($apprv->first()->nostaf)->email, $apprv->first()->nama)
					// ->cc($moreUsers)
					// ->bcc($evenMoreUsers)
					->send(new ToApprover($r, $apprv));
			}

		// finally send it to admin
		if (BTMApprover::where('active', 1)->count()) {
			foreach(BTMApprover::where('active', 1)->get() as $ad) {
				$adm = Login::where('nostaf', $ad->nostaf)->where('is_active', 1)->first();
				// dd($adm, $r);
				// Mail::to($adm->email, $adm->name)
				Mail::to($adm)
					// ->cc($moreUsers)
					// ->bcc($evenMoreUsers)
					->send(new ToBTMLoanCreate($adm, $r));
			};
		};
		} else {
			return redirect()->back()->with('danger', 'There are some error. Please try again later.');
		}
		return redirect()->route('loanapp.index')->with('success', 'Successfully Apply Loan Equipment & Informing The Approver');
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

			// mail to self
			Mail::to($loanapp->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->email, $loanapp->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->nama)
				// ->cc($moreUsers)
				// ->bcc($evenMoreUsers)
				->send(new ToApplicantUpdate($loanapp));

			// finally send it to admin
			if (BTMApprover::where('active', 1)->count()) {
				foreach(BTMApprover::where('active', 1)->get() as $ad) {
					$adm = Login::where('nostaf', $ad->nostaf)->where('is_active', 1)->first();
					Mail::to($adm->email, $adm->name)
						// ->cc($moreUsers)
						// ->bcc($evenMoreUsers)
						->send(new ToBTMLoanUpdate($adm, $loanapp));
				};
			};

		} else {
			return redirect()->back()->with('danger', 'There are some error. Please try again later.');
		}
		return redirect()->route('loanapp.index')->with('success', 'Successfully Update Loan Equipment');
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
