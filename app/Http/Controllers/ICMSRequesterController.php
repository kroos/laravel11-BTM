<?php
namespace App\Http\Controllers;

// for controller output
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// models
use App\Models\ICMSRequester;
use App\Models\Jabatan;
use App\Models\Settings\BTMApprover;
use App\Models\Login;

// load db facade
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

// load validation
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

// load email & notifications
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

use App\Notifications\RegisterAccountICMS\Create\ApplicantICMSCreate;
use App\Notifications\RegisterAccountICMS\Create\ApplicantICMSApproverCreate;
use App\Notifications\RegisterAccountICMS\Create\ApplicantICMSBTMCreate;
use App\Notifications\RegisterAccountICMS\Update\ApplicantICMSUpdate;
use App\Notifications\RegisterAccountICMS\Update\ApplicantICMSApproverUpdate;
use App\Notifications\RegisterAccountICMS\Update\ApplicantICMSBTMUpdate;
use App\Notifications\RegisterAccountICMS\Delete\ApplicantICMSDelete;
use App\Notifications\RegisterAccountICMS\Delete\ApplicantICMSApproverDelete;
use App\Notifications\RegisterAccountICMS\Delete\ApplicantICMSBTMDelete;

// load batch and queue
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

// load helper
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Helpers\HelperArray;

// load Carbon library
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \Carbon\CarbonInterval;

use Session;
use Throwable;
use Exception;
use Log;

// load pdf
use Barryvdh\DomPDF\Facade\Pdf;

class ICMSRequesterController extends Controller
{
	function __construct()
	{
		// $this->middleware(['auth']);
		$this->middleware('ICMSAccountOwner', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(): View
	{
		// $regaccicms = \Auth::user()->belongstostaff->hasmanyicmsrequester()->get();
		$regaccicms = ICMSRequester::all();
		return view('regaccicms.index', ['regaccicms' => $regaccicms]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): View
	{
		return view('regaccicms.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request): RedirectResponse
	{
		// dd($request->all());
		$validator = Validator::make($request->all(), [
				'applicants' => 'required|array|min:1',
				'applicants' => 'required|array|min:1',
				'applicants.*.nama' => 'required|string',
				'applicants.*.position' => 'required|string',
				'applicants.*.username' => 'nullable|alpha_num',
				'applicants.*.icms_module_id' => 'required|array|min:1',
				'applicants.*.icms_module_id.remarks' => 'required_if:applicants.*.icms_module_id,9',
				'acknowledge' => 'required',
			], [
				'applicants.*.nama' => 'Please insert :attribute at #:position',
				'applicants.*.position' => 'Please insert :attribute at #:position',
				// 'applicants.*.username' => 'Please insert :attribute at #:position',
				'applicants.*.username.required'   => ':attribute wajib diisi.',
				'applicants.*.username.alpha_num'  => ':attribute hanya boleh mengandungi huruf dan nombor tanpa ruang atau simbol.',
				'applicants.*.icms_module_id' => 'Please check on :attribute at #:position',
				'applicants.*.icms_module_id.remarks' => 'Please insert :attribute',
				'acknowledge' => 'Please click on :attribute',
			], [
				'applicants' => 'Pemohon',
				'applicants.*.nama' => 'Nama Staff',
				'applicants.*.position' => 'Jawatan',
				'applicants.*.username' => 'Cadangan ID',
				'applicants.*.icms_module_id' => 'PENETAPAN TAHAP CAPAIAN ICMS',
				'applicants.*.icms_module_id.remarks' => 'Sila Nyatakan',
				'acknowledge' => 'Acknowledgement',
		]);
		$validator->after(function ($validator) use ($request) {
			foreach ($request->input('applicants', []) as $index => $applicants) {
				if (isset($applicants['icms_module_id']) && in_array(9, $applicants['icms_module_id'])) {
					if (empty($applicants['icms_module_id']['remarks'] ?? null)) {
						$validator->errors()->add(
							"applicants.$index.icms_module_id.remarks",
							'Ruang input "Sila Nyatakan" diperlukan apabila memilih modul "Lain-lain, Sila Nyatakan. (Others, Please Specify)".'
						);
					}
				}
			}
		});

		$validator->validate();
		$requester = \Auth::user()->belongstostaff->hasmanyicmsrequester()->create(['status_request_id' => 3]);

		foreach ($request->applicants as $applicant) {

		// create applicant row
			$ra = $requester->hasmanyapplicant()->create([
				'nostaf'   => $applicant['nama'],
				'position' => $applicant['position'],
				'username' => $applicant['username'],
			]);

			$pivotData = [];
			$remarks = $applicant['icms_module_id']['remarks'] ?? null;

			foreach ($applicant['icms_module_id'] as $key => $moduleId) {
				// skip the remarks item
				if ($key === 'remarks') continue;

				$moduleId = (int) $moduleId;

				// remarks only for module 9
				$pivotData[$moduleId] = [
					'remarks' => ($moduleId === 9) ? $remarks : null,
				];
			}

			$ra->belongstomanyicmsmodule()->attach($pivotData);
		}

		// need to create pdf and send email
		// pdf user & approval
		Pdf::loadView('regaccicms.show', ['regaccicm' => $requester])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-RAICMS-'.Carbon::parse($requester->created_at)->format('ym').str_pad( $requester->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// pdf admin
		Pdf::loadView('settings.regaccicms.show', ['regaccicm' => $requester])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-RAICMS-ADM-'.Carbon::parse($requester->created_at)->format('ym').str_pad( $requester->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// notifications to self by mail and db
		// used with multiple db connection
		$user = \App\Models\Login::on('mysql1')->find(\Auth::id());
		$user->notify(new ApplicantICMSCreate($requester));

		// notifications to approver (if any) by mail and db
		Jabatan::find(
			\Auth::user()->belongstostaff->belongstomanydepartment->first()->kodjabatan
		)
		->belongstomanyappr()
		->with('hasmanylogin')
		->get()
		->flatMap->hasmanylogin
		->map(function ($login) use ($requester) {
			$login->setConnection('mysql3');
			return $login->notify(new ApplicantICMSApproverCreate($requester));
		});

		// finally // notifications to admin by mail and db
		BTMApprover::where('active', 1)
		->get()
		->each(function ($approver) use ($requester) {
			$adm = Login::where('nostaf', $approver->nostaf)
			->where('is_active', 1)
			->first();

			if ($adm) {
				$adm->setConnection('mysql3');
				$adm->notify(new ApplicantICMSBTMCreate($requester));
			}
		});

		return redirect()->route('regaccicms.index')->with('success', 'Successfully record data and send email');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(ICMSRequester $regaccicm): Response
	{
		// return view('regaccicms.show', ['regaccicm' => $regaccicm]);
		$pdf = Pdf::loadView('regaccicms.show', ['regaccicm' => $regaccicm])->setOption(['dpi' => 120]);
		return $pdf->stream('BTM-RAICMS-'.Carbon::parse($regaccicm->created_at)->format('ym').str_pad( $regaccicm->id, 3, "0", STR_PAD_LEFT).'.pdf')/*->save(storage_path('app/public/pdf/').)*/;
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(ICMSRequester $regaccicm): View
	{
		return view('regaccicms.edit', ['regaccicm' => $regaccicm]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, ICMSRequester $regaccicm): RedirectResponse
	{
		// dd($request->all());
		$validator = Validator::make($request->all(), [
				'applicants' => 'required|array|min:1',
				'applicants.*.nama' => 'required',
				'applicants.*.position' => 'required|string',
				'applicants.*.username' => 'nullable|alpha_num',
				'applicants.*.icms_module_id' => 'required|array|min:1',
				'applicants.*.icms_module_id.remarks' => 'required_if:applicants.*.icms_module_id,9',
				'acknowledge' => 'required',
			], [
				'applicants.*.nama' => 'Please insert :attribute at #:position',
				'applicants.*.position' => 'Please insert :attribute at #:position',
				// 'applicants.*.username' => 'Please insert :attribute at #:position',
				'applicants.*.username.required'   => ':attribute wajib diisi.',
				'applicants.*.username.alpha_num'  => ':attribute hanya boleh mengandungi huruf dan nombor tanpa ruang atau simbol.',
				'applicants.*.icms_module_id' => 'Please check on :attribute at #:position',
				'applicants.*.icms_module_id.remarks' => 'Please insert :attribute',
				'acknowledge' => 'Please click on :attribute',
			], [
				'applicants.*.nama' => 'Nama Staff',
				'applicants.*.position' => 'Jawatan',
				'applicants.*.username' => 'Cadangan ID',
				'applicants.*.icms_module_id' => 'PENETAPAN TAHAP CAPAIAN ICMS',
				'applicants.*.icms_module_id.remarks' => 'Sila Nyatakan',
				'acknowledge' => 'Acknowledgement',
		]);
		$validator->after(function ($validator) use ($request) {
			foreach ($request->input('applicants', []) as $index => $applicants) {
				if (isset($applicants['icms_module_id']) && in_array(9, $applicants['icms_module_id'])) {
					if (empty($applicants['icms_module_id']['remarks'] ?? null)) {
						$validator->errors()->add(
							"applicants.$index.icms_module_id.remarks",
							'Ruang input "Sila Nyatakan" diperlukan apabila memilih modul "Lain-lain, Sila Nyatakan. (Others, Please Specify)".'
						);
					}
				}
			}
		});

		$validator->validate();

		// $regaccicm->hasmanyapplicant()->get()->map(function($item1){
		// 	return $item1->belongstomanyicmsmodule()->detach();
		// });
		// $regaccicm->hasmanyapplicant()->delete();

		foreach ($request->applicants as $v) {

    // update or create applicant row
			$ra = $regaccicm->hasmanyapplicant()->updateOrCreate(
        ['id' => $v['id'] ?? null],     // match for update
        [
        	'nostaf'   => $v['nama'],
        	'position' => $v['position'],
        	'username' => $v['username'],
        ]
      );

			$modules = $v['icms_module_id'] ?? [];
			$remarks = $modules['remarks'] ?? null;

    // build sync data for pivot table
			$syncData = [];
			foreach ($modules as $key => $moduleId) {
			if ($key === 'remarks') continue; // skip remarks array key

				$moduleId = (int) $moduleId;

				$syncData[$moduleId] = [
					'remarks' => ($moduleId === 9) ? $remarks : null
				];
			}

			// sync pivot data
			$ra->belongstomanyicmsmodule()->sync($syncData);
    }
		// dd($d, $f, $syncData1);

		// need to create pdf and send email
		// pdf user & approval
		Pdf::loadView('regaccicms.show', ['regaccicm' => $regaccicm])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-RAICMS-'.Carbon::parse($regaccicm->created_at)->format('ym').str_pad( $regaccicm->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// pdf admin
		Pdf::loadView('settings.regaccicms.show', ['regaccicm' => $regaccicm])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-RAICMS-ADM-'.Carbon::parse($regaccicm->created_at)->format('ym').str_pad( $regaccicm->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// notifications to self by mail and db
		// used with multiple db connection
		$login = $regaccicm->belongstostaff->hasmanylogin()->first();
		$login->setConnection('mysql3');
		$login->notify(new ApplicantICMSUpdate($regaccicm));

		// notifications to approver (if any) by mail and db
		Jabatan::find(
			$regaccicm->belongstostaff->belongstomanydepartment->first()->kodjabatan
		)
		->belongstomanyappr()
		->with('hasmanylogin')
		->get()
		->flatMap->hasmanylogin
		->map(function ($login) use ($regaccicm) {
			$login->setConnection('mysql3');
			return $login->notify(new ApplicantICMSApproverUpdate($regaccicm));
		});

		// finally // notifications to admin by mail and db
		BTMApprover::where('active', 1)
		->get()
		->each(function ($approver) use ($regaccicm) {
			$adm = Login::where('nostaf', $approver->nostaf)
			->where('is_active', 1)
			->first();

			if ($adm) {
				$adm->setConnection('mysql3');
				$adm->notify(new ApplicantICMSBTMUpdate($regaccicm));
			}
		});
		return redirect()->route('regaccicms.index')->with('success', 'Successfully update record data and send email');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(ICMSRequester $regaccicm): JsonResponse
	{
		// need to create pdf and send email
		// pdf user & approval
		Pdf::loadView('regaccicms.show', ['regaccicm' => $regaccicm])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-RAICMS-'.Carbon::parse($regaccicm->created_at)->format('ym').str_pad( $regaccicm->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// pdf admin
		Pdf::loadView('settings.regaccicms.show', ['regaccicm' => $regaccicm])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-RAICMS-ADM-'.Carbon::parse($regaccicm->created_at)->format('ym').str_pad( $regaccicm->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// notifications to self by mail and db
		// used with multiple db connection
		$login = $regaccicm->belongstostaff->hasmanylogin()->first();
		$login->setConnection('mysql3');
		$login->notify(new ApplicantICMSDelete($regaccicm));

		// notifications to approver (if any) by mail and db
		Jabatan::find(
			$regaccicm->belongstostaff->belongstomanydepartment->first()->kodjabatan
		)
		->belongstomanyappr()
		->with('hasmanylogin')
		->get()
		->flatMap->hasmanylogin
		->map(function ($login) use ($regaccicm) {
			$login->setConnection('mysql3');
			return $login->notify(new ApplicantICMSApproverDelete($regaccicm));
		});

		// finally // notifications to admin by mail and db
		BTMApprover::where('active', 1)
		->get()
		->each(function ($approver) use ($regaccicm) {
			$adm = Login::where('nostaf', $approver->nostaf)
			->where('is_active', 1)
			->first();

			if ($adm) {
				$adm->setConnection('mysql3');
				$adm->notify(new ApplicantICMSBTMDelete($regaccicm));
			}
		});

		// $regaccicm->hasmanyapplicant()->belongstomanyicmsmodule()->detach();
		$regaccicm->hasmanyapplicant()
			->with('belongstomanyicmsmodule') // eager load to avoid N+1
			->get()
			->each(function ($applicant) {
				$applicant->belongstomanyicmsmodule()->detach();
			});
		$regaccicm->hasmanyapplicant()->delete();
		$regaccicm->delete();
		return response()->json([
			'message' => 'Success Cancel Request Application',
			'status' => 'success'
		]);
	}
}
