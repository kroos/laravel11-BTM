<?php
namespace App\Http\Controllers\Settings\RegAccICMS;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

// for controller output
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

// models
use App\Models\ICMSRequester;

// load db facade
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

// load validation
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// load batch and queue
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

// load helper
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

// load pdf
use Barryvdh\DomPDF\Facade\Pdf;

// load Carbon library
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \Carbon\CarbonInterval;

use Session;
use Throwable;
use Exception;
use Log;

class AdminICMSRequesterController extends Controller
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
		$regaccicms = ICMSRequester::all();
		return view('settings.regaccicms.index', ['regaccicms' => $regaccicms]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): View
	{
		//
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
	public function show(ICMSRequester $btmicmsrequester): Response
	{
		$pdf = Pdf::loadView('settings.regaccicms.show', ['regaccicm' => $btmicmsrequester])->setOption(['dpi' => 120]);
		return $pdf->stream('BTM-RAICMS-'.Carbon::parse($btmicmsrequester->created_at)->format('ym').str_pad( $btmicmsrequester->id, 3, "0", STR_PAD_LEFT).'.pdf')/*->save(storage_path('app/public/pdf/').)*/;
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(ICMSRequester $btmicmsrequester): View
	{
		return view('settings.regaccicms.edit', ['btmicmsrequester' => $btmicmsrequester]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, ICMSRequester $btmicmsrequester): RedirectResponse
	{
		// dd($request->all());
		$validator = Validator::make($request->all(), [
				'emreg.*.nama' => 'required|string',
				'emreg.*.position' => 'required|string',
				'emreg.*.proposed_id' => 'required|alpha_num',
				'emreg.*.password' => 'required',
				'emreg.*.menu_setting_only' => '',
				'emreg.*.icms_module_id' => 'required|array|min:1',
				'emreg.*.icms_module_id.remarks' => 'required_if:emreg.*.icms_module_id,9',
				'status_request_id' => 'required',
				'btm_remarks' => 'required_if:status_request_id,2|nullable|string',
				'acknowledge' => 'required',
			], [
				'emreg.*.nama' => 'Please insert :attribute at #:position',
				'emreg.*.position' => 'Please insert :attribute at #:position',
				// 'emreg.*.proposed_id' => 'Please insert :attribute at #:position',
				'emreg.*.password'   => ':attribute wajib diisi di posisi  #:position',
				'emreg.*.menu_setting_only'   => ':attribute wajib diisi.',
				'emreg.*.proposed_id.required'   => ':attribute wajib diisi di posisi  #:position',
				'emreg.*.proposed_id.alpha_num'  => ':attribute hanya boleh mengandungi huruf dan nombor tanpa ruang atau simbol di posisi  #:position',
				'emreg.*.icms_module_id' => 'Please check on :attribute at #:position',
				'emreg.*.icms_module_id.remarks' => 'Please insert :attribute',
				'status_request_id' => 'Sila buat pilihan anda untuk :attribute',
				'btm_remarks' => 'Sila isi bahagian :attribute ketika anda menolak permohonan ini.',
				'acknowledge' => 'Please click on :attribute',
			], [
				'emreg.*.nama' => 'Nama Staff',
				'emreg.*.position' => 'Jawatan',
				'emreg.*.proposed_id' => 'Cadangan ID',
				'emreg.*.password' => 'Kata Laluan',
				'emreg.*.menu_setting_only' => 'Penetapan Menu Sahaja',
				'emreg.*.icms_module_id' => 'PENETAPAN TAHAP CAPAIAN ICMS',
				'emreg.*.icms_module_id.remarks' => 'Sila Nyatakan',
				'status_request_id' => 'Permohonan Akaun & ICMS',
				'btm_remarks' => 'Catatan Bahagian Teknologi Maklumat',
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

		$btmicmsrequester->update([
			'btm_approver' => \Auth::user()->nostaf,
			'btm_date' => now(),
			'btm_date' => $request->btm_remarks,
			'status_request_id' => $request->status_request_id,
		]);

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
				'password' => $v['password'],
				'menu_setting_only' => $v['menu_setting_only'],
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
		Pdf::loadView('regaccicms.show', ['regaccicm' => $regaccicm])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-RAICMS-'.Carbon::parse($regaccicm->created_at)->format('ym').str_pad( $regaccicm->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// send to self
		Mail::to($regaccicm->belongstostaff->hasmanylogin()->first()->email, $regaccicm->belongstostaff->hasmanylogin()->first()->nama)
			// ->cc($moreUsers)
			// ->bcc($evenMoreUsers)
			->send(new ToApplicant($regaccicm));

		// send to approver (if available)
		$dept = \Auth::user()->belongstostaff->belongstomanydepartment->first()->kodjabatan;
		$apprv = Jabatan::find($dept)->belongstomanyappr;
		// dd($apprv->belongstomanyappr()->first());
		if($apprv->count()) {
			// send to approver
			Mail::to(Login::find($apprv->first()->nostaf)->email, $apprv->first()->nama)
				// ->cc($moreUsers)
				// ->bcc($evenMoreUsers)
				->send(new ToApprover($regaccicm, $apprv));
		}

		// finally send it to admin
		// $user->notify(new ToBTM($regaccicm));
		if (BTMApprover::where('active', 1)->count()) {
			// $regaccicm will "dissolve" when lopp process
			foreach(BTMApprover::where('active', 1)->get() as $ad) {
				$adm = Login::where('nostaf', $ad->nostaf)->where('is_active', 1)->first();
				Mail::to($adm->email, $adm->name)
				->send(new ToBTM($adm, $regaccicm));
			}
		}
		return redirect()->route('regaccicms.index')->with('success', 'Successfully update record data and send email');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(ICMSRequester $btmicmsrequester): RedirectResponse
	{
		// $regaccicm->hasmanyapplicant()->belongstomanyicmsmodule()->detach();
		$btmicmsrequester->hasmanyapplicant()
			->with('belongstomanyicmsmodule') // eager load to avoid N+1
			->get()
			->each(function ($applicant) {
				$applicant->belongstomanyicmsmodule()->detach();
			});
		$btmicmsrequester->hasmanyapplicant()->delete();
		$btmicmsrequester->delete();
		return response()->json([
			'message' => 'Success Cancel Request Application',
			'status' => 'success'
		]);
	}
}
