<?php
namespace App\Http\Controllers\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// models
use App\Models\EmailRegistrationApplication;
use App\Models\EmailSuggestion;
use App\Models\EmailGroupMember;
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

class BTMEmailApplicationController extends Controller
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
		$emails = EmailRegistrationApplication::where('active', 1)->whereIn('status_email_id', [1,3])->get();
		return view('settings.btmemail.index', ['emails' => $emails]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): View
	{
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
	public function show(EmailRegistrationApplication $btmemailapplication)/*: View*/
	{
		$pdf = Pdf::loadView('settings.btmemail.show', ['email' => $btmemailapplication])->setOption(['dpi' => 120]);
		return $pdf->stream('BTM-ER-'.Carbon::parse($btmemailapplication->created_at)->format('ym').str_pad( $btmemailapplication->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// return view('settings.btmemail.show', ['email' => $btmemailapplication]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(EmailRegistrationApplication $btmemailapplication): View
	{
		return view('settings.btmemail.edit', ['btmemailapplication' => $btmemailapplication]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, EmailRegistrationApplication $btmemailapplication): RedirectResponse
	{
		$request->validate([
				'nostaf' => 'required',
				'group_email' => 'nullable',
				'emreg.*.email_suggestion' => 'required|alpha:ascii',
				'emreg.*.temp_password' => 'required_if_accepted:emreg.*.approved_email|nullable|alpha_num:ascii',
				'emreg.*.approved_email' => 'required_if_accepted:emreg.*.temp_password|nullable|',
				'emregmem.*.email_member_department' => 'required_if_accepted:group_email',
				'emregmem.*.email_member' => 'required_if_accepted:group_email',
			], [
				'nostaf' => 'Please insert :attribute',
				'group_email' => 'Please click :attribute',
				'emreg.*.email_suggestion.required' => 'Please insert :attribute at #:position',
				'emreg.*.temp_password' => 'Please insert :attribute at #:position',
				'emreg.*.approved_email' => 'Please checked :attribute at #:position',
				'emregmem.*.email_member_department' => 'Please choose :attribute at #:position',	//:index
				'emregmem.*.email_member' => 'Please choose :attribute at #:position',	//:index
			], [
				'nostaf' => 'Staff ID',
				'group_email' => 'Group Email',
				'emreg.*.email_suggestion' => 'Email ID',
				'emreg.*.temp_password' => 'Temporary Password',
				'emreg.*.approved_email' => 'Approved Email',
				'emregmem.*.email_member_department' => 'Department',
				'emregmem.*.email_member' => 'Staff',
		]);
		dd($request->all());

		$data = $request->only(['nostaf', 'group_email']);
		$data += ['active' => 1];
		$data += ['status_email_id' => 3];
		$r = $btmemailapplication->update($data);

		if ($request->has('emreg')) {
			foreach($request->emreg as $k => $v) {
				EmailSuggestion::updateOrCreate([
						'id' => $v['id'],
						'email_application_id' => $btmemailapplication->id
					],
					[
						'email_suggestion' => $v['email_suggestion']
				]);
			};
		};

		if ($request->has('emregmem')) {
			foreach($request->emregmem as $k1 => $v1) {
				EmailGroupMember::updateOrCreate([
						'id' => $v1['id'],
						'email_application_id' => $btmemailapplication->id
					],
					[
						'department_id' => $v1['email_member_department'],
						'email_staff' => $v1['email_member']
				]);
			};
		};

		Pdf::loadView('email.show', ['email' => $btmemailapplication])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-ER-'.Carbon::parse($btmemailapplication->created_at)->format('ym').str_pad( $btmemailapplication->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// mail to self
		Mail::to($btmemailapplication->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->email, $btmemailapplication->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->name)
			// ->cc($moreUsers)
			// ->bcc($evenMoreUsers)
			->send(new ToApplicantEmailUpdate($btmemailapplication));

		// finally send it to admin
		if (BTMApprover::where('active', 1)->count()) {
			foreach(BTMApprover::where('active', 1)->get() as $ad) {
				$adm = Login::where('nostaf', $ad->nostaf)->where('is_active', 1)->first();
				Mail::to($adm->email, $adm->name)
					// ->cc($moreUsers)
					// ->bcc($evenMoreUsers)
					->send(new ToBTMEmailUpdate($adm, $btmemailapplication));
			};
		};

		return redirect()->route('emailaccapp.index')->with('success', 'Successfully Updated Registered Email Application & Informing The Approver');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(EmailRegistrationApplication $btmemailapplication): JsonResponse
	{
		$btmemailapplication->update(['active' => 0]);
		return response()->json([
			'message' => 'Success deleted Email Registration Application',
			'status' => 'success'
		]);
	}
}