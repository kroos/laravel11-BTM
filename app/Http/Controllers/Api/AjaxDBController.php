<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;

// load Carbon
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \Carbon\CarbonInterval;

// load batch and queue
// use Illuminate\Bus\Batch;
// use Illuminate\Support\Facades\Bus;

// load pdf
use Barryvdh\DomPDF\Facade\Pdf;

// send email
use Illuminate\Support\Facades\Mail;

// load notification
use Illuminate\Support\Facades\Notification;
use App\Notifications\LoanEquipment\Approver\ApplicantLoanUpdate;
use App\Notifications\LoanEquipment\Approver\ApplicantLoanApproverUpdate;
use App\Notifications\LoanEquipment\Approver\ApplicantLoanBTMUpdate;
use App\Notifications\EmailApplication\Approver\ApplicantEmailUpdate;
use App\Notifications\EmailApplication\Approver\ApplicantEmailApproverUpdate;
use App\Notifications\EmailApplication\Approver\ApplicantEmailBTMUpdate;
use App\Notifications\RegisterAccountICMS\Approver\ApplicantICMSUpdate;
use App\Notifications\RegisterAccountICMS\Approver\ApplicantICMSApproverUpdate;
use App\Notifications\RegisterAccountICMS\Approver\ApplicantICMSBTMUpdate;

// for controller output
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

// load model
use App\Models\Jabatan;
use App\Models\Staff;
use App\Models\Login;
use App\Models\LoanApplication;
use App\Models\StatusEquipment;
use App\Models\StaffJabatan;
use App\Models\EmailRegistrationApplication;
use App\Models\ICMSModule;
use App\Models\ICMSRequester;
use App\Models\Settings\Category;
use App\Models\Settings\Item;
use App\Models\Settings\BTMApprover;

// load helper
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

use Log;
use Session;
use Exception;
use Throwable;

class AjaxDBController extends Controller
{
	function __construct()
	{
	}

	public function liststaff(Request $request): JsonResponse
	{
		$values = Staff::where('status', 'A')
											->with('hasmanylogin')
											->when($request->search, function($query) use ($request){
												$query->where('nama','LIKE','%'.$request->search.'%')
												->orWhere('nostaf','LIKE','%'.$request->search.'%');
											})
											->orderBy('nama')
											->get();
		foreach ($values as $value) {
			$g['children'][] = [
								'id' => $value->nostaf,
								'text' => $value->nostaf.' => '.$value->nama,
								'element' => $value->hasmanylogin?->first()?->email,
							];
		}
		$staff['results'][] = $g;
		return response()->json($staff);
	}

	public function listjabatan(Request $request): JsonResponse
	{
		$values = Jabatan::where('aktif', 1)
												->when($request->kodjabatan, function($query) use ($request){
													$query->where('kodjabatan', $request->kodjabatan);
												})
												->when($request->kodjabatan, function($query) use ($request){
													$query->where('namajabatan','LIKE','%'.$request->search.'%');
												})
												->orderBy('namajabatan')
												->get();
		// dd($values);
		foreach ($values as $value) {
				$g['children'][] = [
									'id' => $value->kodjabatan,
									'text' => $value->namajabatan,
								];
		}
		$jabatan['results'][] = $g;
		return response()->json($jabatan);
	}

	public function listcategory(Request $request): JsonResponse
	{
		$values = Category::where('category','LIKE','%'.$request->search.'%')->get();
		// dd($values);
		foreach ($values as $value) {
			$g[] = [
								'id' => $value->id,
								'cat' => $value->category,
							];
		}
		return response()->json($g);
	}

	public function listicmsmodule(): JsonResponse
	{
		$ims = ICMSModule::all();
		foreach($ims as $im) {
			$g[] = [
								'id' => $im->id,
								'text' => $im->icms_module,
							];
		}
		// $icmsmod['results'][] = $g;
		return response()->json($g);
	}

	public function equipmentstatus(Request $request): JsonResponse
	{
		// dd($request->all());
		// Fetch subcategories with optional search
		$values = Item::where('status', 1)
										->when($request->categoryId, function ($query) use ($request){
											$query->where('category_id', $request->categoryId);
										})
										->when($request->search, function ($query) use ($request) {
												$query->where('name', 'LIKE', '%' . $request->search . '%');
										})
										// ->get(['id', 'item', 'category_id']);
										->get();
		// dd($values->count());
		if ($values->count()) {
			foreach ($values as $value) {
				$g['children'][] = [
									'id' => $value->id,
									'text' => $value->item,
									'class' => $value->category_id,
								];
			}
		} else {
				$g = [];
		}
		$equipments['results'][] = $g;
		return response()->json($equipments);
	}

	public function status(Request $request): JsonResponse
	{
		$values = StatusEquipment::where('status_item','LIKE','%'.$request->search.'%')->get();
		// dd($values);
		foreach ($values as $value) {
				$g['children'][] = [
									'id' => $value->id,
									'text' => $value->status_item,
								];
		}
		$equipments['results'][] = $g;
		return response()->json($equipments);
	}

	public function equipmentdescription(Request $request): JsonResponse
	{
		$values = Item::find($request->id);
		// dd($values);
		$equipmentsdesc = [
			'item' => $values->item,
			'brand' => $values->brand,
			'model' => $values->model,
			'serial_number' => $values->serial_number,
			'description' => $values->description,
		];
		return response()->json($equipmentsdesc);
	}

	public function loancalendar()
	{
		$outstation = LoanApplication::where('active', 1)->orWhereIn('status_loan_id', [1,3])->get();
		if ($outstation->count()) {
			foreach ($outstation as $v) {
				$loanDetails = [
							'title' => 'Loan by '.$v->belongstostaff->nama,
							'start' => $v->date_loan_from,
							'end' => Carbon::parse($v->date_loan_to)->addDay(),
							// 'url' => route('hrleave.show', $v->id),
							'allDay' => true,
							'extendedProps' => [
													'status' => 'Status: '.$v->belongstostatusloan->status_loan
												],
							// 'description' => 'Loan by '.$v->belongstostaff->nama,
							'color' => 'blue',
							'textColor' => 'white',
							'borderColor' => 'blue',
					];
				// Get all equipment descriptions and join them as a single string
				$descriptions = 'Loan by '.$v->belongstostaff->nama.' => '.$v->hasmanyequipments()->get()->pluck('belongstoequipment.item')->join(', ');

				// Add the descriptions to the loan details
				$loanDetails['description'] = $descriptions;

				// Add the loan details to the output array
				$out[] = $loanDetails;
			}
		} else {
			$out[] = [];
		}
		return response()->json( $out );
	}

	public function listemailjabatan(Request $request)
	{
		$je = Jabatan::find($request->dept_id)->belongstomanystaff()->get();
		$p = [];
		foreach ($je as $e) {
			$activeLogin = $e->hasmanylogin()->where('is_active', 1)
											->when($request->email, function($query) use ($request){
												$query->where('email', $request->email);
											})
											->first();
			if ($activeLogin !== null && $activeLogin->email !== null) {
					$p[] = $e->hasmanylogin()
										->where('is_active', 1)
										->when($request->email, function($query) use ($request){
											$query->where('email', $request->email);
										})
										->pluck('email', 'name');
			}
		}
		return response()->json($p);
	}

	public function loanappsapprv(Request $request, LoanApplication $loanapp): JsonResponse
	{
		$request->validate([
				'acknowledge' => 'required|accepted',
				'status' => 'required',
				'remarks_approver' => 'required_if:status,2',
				'approver_staff' => 'required',
			], [
				'acknowledge' => 'Please checked on :attribute',
				'status' => 'Please choose your :attribute',
				'remarks_approver' => 'Please fill up :attribute',
				'approver_staff' => 'Missing :attribute'
			], [
				'acknowledge' => 'Acknowledgement',
				'status' => 'Approval',
				'remarks_approver' => 'Remarks',
				'approver_staff' => 'Staff ID',
		]);

		$dle = ['approver_status_id' => $request->status];
		$dle += ['approver_remarks' => ucwords(Str::lower(trim($request->remarks_approver)))];
		$dle += ['approver_staff' => \Auth::user()->nostaf];
		$dle += ['approver_date' => now()];
		if ($request->status == 2) {
			$dle += ['status_loan_id' => 2];
		}

		$loanapp->update($dle);

		// pdf user & approval
		Pdf::loadView('loan.show', ['loanapp' => $loanapp])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-'.Carbon::parse($loanapp->created_at)->format('ym').str_pad( $loanapp->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// pdf admin
		Pdf::loadView('settings.btm.show', ['btmloanapplication' => $loanapp])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-ADM-'.Carbon::parse($loanapp->created_at)->format('ym').str_pad( $loanapp->id, 3, "0", STR_PAD_LEFT).'.pdf');


		// notifications to user by mail and db
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

		return response()->json([
			'message' => 'Success granted approval for the loan',
			'status' => 'success'
		]);
	}

	public function emailappsapprv(Request $request, EmailRegistrationApplication $emailapp): JsonResponse
	{
		// dd($request->all());
		$request->validate([
				'acknowledge' => 'required|accepted',
				'status' => 'required',
				'remarks_approver' => 'required_if:status,2',
				'approver_staff' => 'required',
			], [
				'acknowledge' => 'Please checked on :attribute',
				'status' => 'Please choose your :attribute',
				'remarks_approver' => 'Please fill up :attribute',
				'approver_staff' => 'Missing :attribute'
			], [
				'acknowledge' => 'Acknowledgement',
				'status' => 'Approval',
				'remarks_approver' => 'Remarks',
				'approver_staff' => 'Staff ID',
		]);

		$dle = ['approver_status_id' => $request->status];
		$dle += ['approver_remarks' => ucwords(Str::lower(trim($request->remarks_approver)))];
		$dle += ['approver_staff' => \Auth::user()->nostaf];
		$dle += ['approver_date' => now()];
		if ($request->status == 2) {
			$dle += ['status_email_id' => 2];
		}

		$emailapp->update($dle);

		Pdf::loadView('email.show', ['email' => $emailapp])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-ER-'.Carbon::parse($emailapp->created_at)->format('ym').str_pad( $emailapp->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// pdf admin
		Pdf::loadView('settings.btmemail.show', ['email' => $emailapp])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-ER-ADM-'.Carbon::parse($emailapp->created_at)->format('ym').str_pad( $emailapp->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// notifications to self by mail and db
		// used with multiple db connection
		$loginUser = $emailapp->belongstostaff->hasmanylogin()->first();
		$loginUser->setConnection('mysql3');
		$loginUser->notify(new ApplicantEmailUpdate($emailapp));

		// notifications to approver (if any) by mail and db
		Jabatan::find(
			$emailapp->belongstostaff->belongstomanydepartment->first()->kodjabatan
		)
		->belongstomanyappr()
		->with('hasmanylogin')
		->get()
		->flatMap->hasmanylogin
		->map(function ($login) use ($emailapp) {
			$login->setConnection('mysql3');
			return $login->notify(new ApplicantEmailApproverUpdate($emailapp));
		});

		// finally // notifications to admin by mail and db
		BTMApprover::where('active', 1)
		->get()
		->each(function ($approver) use ($emailapp) {
			$adm = Login::where('nostaf', $approver->nostaf)
			->where('is_active', 1)
			->first();

			if ($adm) {
				$adm->setConnection('mysql3');
				$adm->notify(new ApplicantEmailBTMUpdate($emailapp));
			}
		});

		return response()->json([
			'message' => 'Success granted approval for the email registration',
			'status' => 'success'
		]);
	}

	public function regaccappsapprv(Request $request, ICMSRequester $regaccappsapprv): JsonResponse
	{
		// dd($request->all(), \Auth::user());
		// return response()->json([]);
		$request->validate([
				'acknowledge' => 'required|accepted',
				'status' => 'required',
				'remarks_approver' => 'required_if:status,2',
				'approver_staff' => 'required',
			], [
				'acknowledge' => 'Please checked on :attribute',
				'status' => 'Please choose your :attribute',
				'remarks_approver' => 'Please fill up :attribute',
				'approver_staff' => 'Missing :attribute'
			], [
				'acknowledge' => 'Acknowledgement',
				'status' => 'Approval',
				'remarks_approver' => 'Remarks',
				'approver_staff' => 'Staff ID',
		]);

		$dle = ['approver_status_id' => $request->status];
		$dle += ['approver_remarks' => ucwords(Str::lower(trim($request->remarks_approver)))];
		$dle += ['approver_staff' => \Auth::user()->nostaf];
		$dle += ['approver_date' => now()];
		if ($request->status == 2) {
			$dle += ['status_request_id' => 2];
		}

		$regaccappsapprv->update($dle);

		// need to create pdf and send email
		// pdf user & approval
		Pdf::loadView('regaccicms.show', ['regaccicm' => $regaccappsapprv])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-RAICMS-'.Carbon::parse($regaccappsapprv->created_at)->format('ym').str_pad( $regaccappsapprv->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// pdf admin
		Pdf::loadView('settings.regaccicms.show', ['regaccicm' => $regaccappsapprv])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-RAICMS-ADM-'.Carbon::parse($regaccappsapprv->created_at)->format('ym').str_pad( $regaccappsapprv->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// notifications to self by mail and db
		// used with multiple db connection
		$login = $regaccappsapprv->belongstostaff->hasmanylogin()->first();
		$login->setConnection('mysql3');
		$login->notify(new ApplicantICMSUpdate($regaccappsapprv));

		// notifications to approver (if any) by mail and db
		Jabatan::find(
			$regaccappsapprv->belongstostaff->belongstomanydepartment->first()->kodjabatan
		)
		->belongstomanyappr()
		->with('hasmanylogin')
		->get()
		->flatMap->hasmanylogin
		->map(function ($login) use ($regaccappsapprv) {
			$login->setConnection('mysql3');
			return $login->notify(new ApplicantICMSApproverUpdate($regaccappsapprv));
		});

		// finally // notifications to admin by mail and db
		BTMApprover::where('active', 1)
		->get()
		->each(function ($approver) use ($regaccappsapprv) {
			$adm = Login::where('nostaf', $approver->nostaf)
			->where('is_active', 1)
			->first();

			if ($adm) {
				$adm->setConnection('mysql3');
				$adm->notify(new ApplicantICMSBTMUpdate($regaccappsapprv));
			}
		});

		return response()->json([
			'message' => 'Success granted approval for the ICMS Registeration Account',
			'status' => 'success'
		]);
	}





}

