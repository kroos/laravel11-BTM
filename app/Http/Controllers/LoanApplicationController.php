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

// load notification
use Illuminate\Support\Facades\Notification;
use App\Notifications\LoanEquipment\Create\ApplicantLoanCreate;
use App\Notifications\LoanEquipment\Create\ApplicantLoanApproverCreate;
use App\Notifications\LoanEquipment\Create\ApplicantLoanBTMCreate;
use App\Notifications\LoanEquipment\Update\ApplicantLoanUpdate;
use App\Notifications\LoanEquipment\Update\ApplicantLoanApproverUpdate;
use App\Notifications\LoanEquipment\Update\ApplicantLoanBTMUpdate;
use App\Notifications\LoanEquipment\Delete\ApplicantLoanDelete;
use App\Notifications\LoanEquipment\Delete\ApplicantLoanApproverDelete;
use App\Notifications\LoanEquipment\Delete\ApplicantLoanBTMDelete;

// send email
use Illuminate\Support\Facades\Mail;

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
				'location' => 'required',
				'acknowledge' => 'required',
				'lequ.*.equipment_id' => 'required',
			], [
				'date_loan_from' => 'Please insert :attribute',
				'date_loan_to' => 'Please insert :attribute',
				'loan_purpose' => 'Please insert :attribute',
				'location' => 'Please insert :attribute',
				'acknowledge' => 'Please click on :attribute',
				'lequ.*.equipment_id' => 'Please choose :attribute at #:position',	//:index
			], [
				'date_loan_from' => 'Date From',
				'date_loan_to' => 'Date To',
				'loan_purpose' => 'Purpose of Loan',
				'location' => 'Location',
				'acknowledge' => 'Acknowledgement',
				'lequ.*.equipment_id' => 'Equipment',
		]);

		$data = $request->only(['date_loan_from', 'date_loan_to', 'location']);
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
		}

		// pdf user & approval
		Pdf::loadView('loan.show', ['loanapp' => $r])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-'.Carbon::parse($r->created_at)->format('ym').str_pad( $r->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// pdf admin
		Pdf::loadView('settings.btm.show', ['btmloanapplication' => $r])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-ADM-'.Carbon::parse($r->created_at)->format('ym').str_pad( $r->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// notifications to self by mail and db
		// used with multiple db connection
		$user = \App\Models\Login::on('mysql1')->find(\Auth::id());
		$user->notify(new ApplicantLoanCreate($r));

		// notifications to approver (if any) by mail and db
		Jabatan::find(
			\Auth::user()->belongstostaff->belongstomanydepartment->first()->kodjabatan
		)
		->belongstomanyappr()
		->with('hasmanylogin')
		->get()
		->flatMap->hasmanylogin
		->map(function ($login) use ($r) {
			$login->setConnection('mysql3');
			return $login->notify(new ApplicantLoanApproverCreate($r));
		});

		// finally // notifications to admin by mail and db
		BTMApprover::where('active', 1)
		->get()
		->each(function ($approver) use ($r) {
			$adm = Login::where('nostaf', $approver->nostaf)
			->where('is_active', 1)
			->first();

			if ($adm) {
				$adm->setConnection('mysql3');
				$adm->notify(new ApplicantLoanBTMCreate($r));
			}
		});

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
				'location' => 'required',
				'lequ.*.equipment_id' => 'required',
			], [
				'date_loan_from' => 'Please insert :attribute',
				'date_loan_to' => 'Please insert :attribute',
				'loan_purpose' => 'Please insert :attribute',
				'location' => 'Please insert :attribute',
				'lequ.*.equipment_id' => 'Please choose :attribute at #:position',	//:index
			], [
				'date_loan_from' => 'Date From',
				'date_loan_to' => 'Date To',
				'loan_purpose' => 'Purpose of Loan',
				'location' => 'Location',
				'lequ.*.equipment_id' => 'Equipment',
		]);

		$data = $request->only(['date_loan_from', 'date_loan_to', 'location']);
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
		}

		// pdf user & approval
		Pdf::loadView('loan.show', ['loanapp' => $loanapp])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-'.Carbon::parse($loanapp->created_at)->format('ym').str_pad( $loanapp->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// pdf admin
		Pdf::loadView('settings.btm.show', ['btmloanapplication' => $loanapp])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-ADM-'.Carbon::parse($loanapp->created_at)->format('ym').str_pad( $loanapp->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// notifications to self by mail and db
		// used with multiple db connection
		$login = $loanapp->belongstostaff->hasmanylogin()->first();
		$login->setConnection('mysql3');
		$login->notify(new ApplicantLoanUpdate($loanapp));

		// notifications to approver (if any) by mail and db
		Jabatan::find(
			$loanapp->belongstostaff->belongstomanydepartment->first()->kodjabatan
		)
		->belongstomanyappr()
		->with('hasmanylogin')
		->get()
		->flatMap->hasmanylogin
		->map(function ($login) use ($loanapp) {
			$login->setConnection('mysql3');
			return $login->notify(new ApplicantLoanApproverUpdate($loanapp));
		});

		// finally // notifications to admin by mail and db
		BTMApprover::where('active', 1)
		->get()
		->each(function ($approver) use ($loanapp) {
			$adm = Login::where('nostaf', $approver->nostaf)
			->where('is_active', 1)
			->first();

			if ($adm) {
				$adm->setConnection('mysql3');
				$adm->notify(new ApplicantLoanBTMUpdate($loanapp));
			}
		});

		return redirect()->route('loanapp.index')->with('success', 'Successfully Update Loan Equipment');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(LoanApplication $loanapp): JsonResponse
	{
		// pdf user & approval
		Pdf::loadView('loan.show', ['loanapp' => $loanapp])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-'.Carbon::parse($loanapp->created_at)->format('ym').str_pad( $loanapp->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// pdf admin
		Pdf::loadView('settings.btm.show', ['btmloanapplication' => $loanapp])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-ADM-'.Carbon::parse($loanapp->created_at)->format('ym').str_pad( $loanapp->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// notifications to self by mail and db
		// used with multiple db connection
		$login = $loanapp->belongstostaff->hasmanylogin()->first();
		$login->setConnection('mysql3');
		$login->notify(new ApplicantLoanDelete($loanapp));

		// notifications to approver (if any) by mail and db
		Jabatan::find(
			$loanapp->belongstostaff->belongstomanydepartment->first()->kodjabatan
		)
		->belongstomanyappr()
		->with('hasmanylogin')
		->get()
		->flatMap->hasmanylogin
		->map(function ($login) use ($loanapp) {
			$login->setConnection('mysql3');
			return $login->notify(new ApplicantLoanApproverDelete($loanapp));
		});

		// finally // notifications to admin by mail and db
		BTMApprover::where('active', 1)
		->get()
		->each(function ($approver) use ($loanapp) {
			$adm = Login::where('nostaf', $approver->nostaf)
			->where('is_active', 1)
			->first();

			if ($adm) {
				$adm->setConnection('mysql3');
				$adm->notify(new ApplicantLoanBTMDelete($loanapp));
			}
		});

		$loanapp->update(['active' => 0]);
		return response()->json([
			'message' => 'Success deleted Loan Application',
			'status' => 'success'
		]);
	}
}
