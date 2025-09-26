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
				'emreg.*.nama' => 'required|string',
				'emreg.*.position' => 'required|string',
				'emreg.*.proposed_id' => 'required|alpha_num',
				'emreg.*.icms_module_id' => 'required|array|min:1',
				'emreg.*.icms_module_id.dll' => 'required_if:emreg.*.icms_module_id,9',
				'acknowledge' => 'required',
			], [
				'emreg.*.nama' => 'Please insert :attribute at #:position',
				'emreg.*.position' => 'Please insert :attribute at #:position',
				// 'emreg.*.proposed_id' => 'Please insert :attribute at #:position',
				'emreg.*.proposed_id.required'   => ':attribute wajib diisi.',
				'emreg.*.proposed_id.alpha_num'  => ':attribute hanya boleh mengandungi huruf dan nombor tanpa ruang atau simbol.',
				'emreg.*.icms_module_id' => 'Please check on :attribute at #:position',
				'emreg.*.icms_module_id.dll' => 'Please insert :attribute',
				'acknowledge' => 'Please click on :attribute',
			], [
				'emreg.*.nama' => 'Nama Staff',
				'emreg.*.position' => 'Jawatan',
				'emreg.*.proposed_id' => 'Cadangan ID',
				'emreg.*.icms_module_id' => 'PENETAPAN TAHAP CAPAIAN ICMS',
				'emreg.*.icms_module_id.dll' => 'Sila Nyatakan',
				'acknowledge' => 'Acknowledgement',
		]);
		$validator->after(function ($validator) use ($request) {
			foreach ($request->input('emreg', []) as $index => $emreg) {
				if (isset($emreg['icms_module_id']) && in_array(9, $emreg['icms_module_id'])) {
					if (empty($emreg['icms_module_id']['dll'] ?? null)) {
						$validator->errors()->add(
							"emreg.$index.icms_module_id.dll",
							'Ruang input "Sila Nyatakan" diperlukan apabila memilih modul "Lain-lain, Sila Nyatakan. (Others, Please Specify)".'
						);
					}
				}
			}
		});

		$validator->validate();
		$requester = \Auth::user()->belongstostaff->hasmanyicmsrequester()->create(['status_request_id' => 3]);

		foreach($request->emreg as $k => $v) {
			// populate icms_requester_applicants
			$ra = $requester->hasmanyapplicant()->create([
				'nostaf' => $v['nama'],
				'position' => $v['position'],
				'username' => $v['proposed_id'],
			]);

			// populate icms_applicant_modules
			foreach ($v['icms_module_id'] as $ke => $va) {
				if ($ke === 'dll') {
					continue;
				}

				// reset for each applicant
				$pivotData = [];

				foreach ($v['icms_module_id'] as $ke => $va) {
					if ($ke === 'dll') {
						continue;
					}

					$pivotData[$va] = [
						'remarks' => ($va == 9) ? ($v['icms_module_id']['dll'] ?? null) : null,
					];
				}
			};
			$ra->belongstomanyicmsmodule()->attach($pivotData);
		};

		// need to create pdf and send email
		// pdf user & approval
		Pdf::loadView('regaccicms.show', ['regaccicm' => $requester])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-RAICMS-'.Carbon::parse($requester->created_at)->format('ym').str_pad( $requester->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// pdf admin
		Pdf::loadView('settings.regaccicms.show', ['regaccicm' => $requester])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-RAICMS-ADM-'.Carbon::parse($requester->created_at)->format('ym').str_pad( $requester->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// notifications to self by mail and db
		// used with multiple db connection
		\Auth::user()->setConnection('mysql3');
		\Auth::user()->notify(new ApplicantICMSCreate($requester));

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
				'emreg.*.nama' => 'required|string',
				'emreg.*.position' => 'required|string',
				'emreg.*.proposed_id' => 'required|alpha_num',
				'emreg.*.icms_module_id' => 'required|array|min:1',
				'emreg.*.icms_module_id.remarks' => 'required_if:emreg.*.icms_module_id,9',
				'acknowledge' => 'required',
			], [
				'emreg.*.nama' => 'Please insert :attribute at #:position',
				'emreg.*.position' => 'Please insert :attribute at #:position',
				// 'emreg.*.proposed_id' => 'Please insert :attribute at #:position',
				'emreg.*.proposed_id.required'   => ':attribute wajib diisi.',
				'emreg.*.proposed_id.alpha_num'  => ':attribute hanya boleh mengandungi huruf dan nombor tanpa ruang atau simbol.',
				'emreg.*.icms_module_id' => 'Please check on :attribute at #:position',
				'emreg.*.icms_module_id.remarks' => 'Please insert :attribute',
				'acknowledge' => 'Please click on :attribute',
			], [
				'emreg.*.nama' => 'Nama Staff',
				'emreg.*.position' => 'Jawatan',
				'emreg.*.proposed_id' => 'Cadangan ID',
				'emreg.*.icms_module_id' => 'PENETAPAN TAHAP CAPAIAN ICMS',
				'emreg.*.icms_module_id.remarks' => 'Sila Nyatakan',
				'acknowledge' => 'Acknowledgement',
		]);
		$validator->after(function ($validator) use ($request) {
			foreach ($request->input('emreg', []) as $index => $emreg) {
				if (isset($emreg['icms_module_id']) && in_array(9, $emreg['icms_module_id'])) {
					if (empty($emreg['icms_module_id']['remarks'] ?? null)) {
						$validator->errors()->add(
							"emreg.$index.icms_module_id.remarks",
							'Ruang input "Sila Nyatakan" diperlukan apabila memilih modul "Lain-lain, Sila Nyatakan. (Others, Please Specify)".'
						);
					}
				}
			}
		});

		$validator->validate();

		foreach($request->emreg as $k => $v) {
			// populate icms_requester_applicants

			// can use this method but i made a mistake on frontend
			// $g[] = Arr::except($v, ['icms_module_id']);

			$ra = $regaccicm->hasmanyapplicant()->updateOrCreate([
				'id' => $v['id'],
				],[
				'nostaf' => $v['nama'],
				'position' => $v['position'],
				'username' => $v['proposed_id'],
			]);

$d[$k] = $v['icms_module_id'];

			foreach ($v['icms_module_id'] as $va) {
				// $f[$k][$ke] = $va;
				// if (Arr::exists($array, 'name')) {
				// 	// Key 'name' exists in the array
				// }

				$f[$k][$va] = [
					'remarks' => ($va == 9) ? ($v['icms_module_id']['remarks']) : null,
				];

			}

			$modules = $v['icms_module_id'] ?? [];
			$syncData = HelperArray::prepareModulesForSync($modules);
			$syncData1[] = HelperArray::prepareModulesForSync($modules);

			// this will produce:
			// [2 => [], 4 => []]
			// [2 => [], 4 => [], 6 => [], 9 => ['remarks' => 'Vcbvcb Vcb Vcb']]
			// [2 => []]
			// [1 => []]

			// sync with pivot
			$ra->belongstomanyicmsmodule()->sync($syncData);
		};
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
