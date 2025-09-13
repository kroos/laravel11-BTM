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

// load db facade
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

// load validation
use Illuminate\Support\Facades\Validator;

// load batch and queue
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

// load helper
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

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
	/**
	 * Display a listing of the resource.
	 */
	public function index(): View
	{
		$regaccicms = \Auth::user()->belongstostaff->hasmanyicmsrequester()->get();
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
				'emreg.*.proposed_id' => 'required|string',
				'emreg.*.icms_module_id' => 'required|array|min:1',
				// 'emreg.*.icms_module_id.dll' => 'required_if:emreg.*.icms_module_id.*,9',
				'acknowledge' => 'required',
			], [
				'emreg.*.nama' => 'Please insert :attribute at #:position',
				'emreg.*.position' => 'Please insert :attribute at #:position',
				'emreg.*.proposed_id' => 'Please insert :attribute at #:position',
				'emreg.*.icms_module_id' => 'Please check on :attribute at #:position',
				// 'emreg.*.icms_module_id.dll' => 'Please insert :attribute',
				'acknowledge' => 'Please click on :attribute',
			], [
				'emreg.*.nama' => 'Nama Staff',
				'emreg.*.position' => 'Jawatan',
				'emreg.*.proposed_id' => 'Cadangan ID',
				'emreg.*.icms_module_id' => 'PENETAPAN TAHAP CAPAIAN ICMS',
				// 'emreg.*.icms_module_id.dll' => 'Sila Nyatakan',
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

				$pivotData[$va] = [
					'remarks' => ($va == 9) ? ($v['icms_module_id']['dll'] ?? null) : null,
				];
			};
			$ra->belongstomanyicmsmodule()->attach($pivotData);
		};








		// need to create pdf and send email
		// Pdf::loadView('loan.show', ['loanapp' => $r])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-'.Carbon::parse($r->created_at)->format('ym').str_pad( $r->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// // send to self
		// Mail::to($r->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->email, $r->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->nama)
		// 	// ->cc($moreUsers)
		// 	// ->bcc($evenMoreUsers)
		// 	->send(new ToApplicant($r));

		return redirect()->route('regaccicms.index')->with('success', 'Successfully record data and send email');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(ICMSRequester $regaccicm): Response
	{
		// return view('regaccicms.show', ['regaccicm' => $regaccicm]);
		// $pdf = Pdf::loadView('transactions.show', ['transaction' => $transaction])->setOption(['dpi' => 120]);
		// return $pdf->stream('DAT-'.Carbon::parse($transaction->created_at)->format('ym').str_pad( $transaction->id, 3, "0", STR_PAD_LEFT).'.pdf');

		$pdf = Pdf::loadView('regaccicms.show', ['regaccicm' => $regaccicm])->setOption(['dpi' => 120]);
		return $pdf->stream('BTM-RAICMS-'.Carbon::parse($regaccicm->created_at)->format('ym').str_pad( $regaccicm->id, 3, "0", STR_PAD_LEFT).'.pdf')/*->save(storage_path('app/public/pdf/').)*/;
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(ICMSRequester $regaccicm): View
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, ICMSRequester $regaccicm): RedirectResponse
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(ICMSRequester $regaccicm): RedirectResponse
	{
		//
	}
}
