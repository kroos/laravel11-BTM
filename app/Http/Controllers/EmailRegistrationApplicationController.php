<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// models
use App\Models\EmailRegistrationApplication;
use App\Models\EmailSuggestion;
use App\Models\EmailGroupMember;
use App\Models\Login;
use App\Models\Jabatan;
use App\Models\Settings\BTMApprover;

// load notification
use Illuminate\Support\Facades\Notification;
use App\Notifications\ApplicantEmailAlert;
use App\Notifications\ApplicantEmaiHODlAlert;
use App\Notifications\ApplicantEmailBTMAlert;

// load db facade
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

// for controller output
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

// validation
use Illuminate\Validation\Rule;
use App\Rules\UniqueEmail;

// load pdf
use Barryvdh\DomPDF\Facade\Pdf;

// send email
use Illuminate\Support\Facades\Mail;
use App\Mail\ToApplicantEmail;
use App\Mail\ToApprover;
use App\Mail\ToApproverEmail;
use App\Mail\ToApplicantUpdate;
use App\Mail\ToApplicantEmailUpdate;
use App\Mail\ToBTMEmailCreate;
use App\Mail\ToBTMEmailUpdate;

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

class EmailRegistrationApplicationController extends Controller
{
	function __construct()
	{
		// $this->middleware(['auth']);
		$this->middleware('emailOwner', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(): View
	{
		$emails = EmailRegistrationApplication::where('active', 1)->get();
		return view('email.index', ['emails' => $emails]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): View
	{
		return view('email.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request): RedirectResponse
	{
		// dd($request->all());
		$request->validate([
				'nostaf' => 'required',
				'group_email' => 'nullable',
				'emreg.*.email_suggestion' => 'required|alpha_num:ascii',
				'emreg' => [new UniqueEmail],
				'emregmem.*.email_member_department' => 'required_if_accepted:group_email',
				'emregmem.*.email_member' => 'required_if_accepted:group_email',
			], [
				'nostaf' => 'Please insert :attribute',
				'group_email' => 'Please click :attribute',
				'emreg.*.email_suggestion.required' => 'Please insert :attribute at #:position',
				'emregmem.*.email_member_department' => 'Please choose :attribute at #:position',	//:index
				'emregmem.*.email_member' => 'Please choose :attribute at #:position',	//:index
			], [
				'nostaf' => 'Staff ID',
				'group_email' => 'Group Email',
				'emreg.*.email_suggestion' => 'Email ID',
				'emregmem.*.email_member_department' => 'Department',
				'emregmem.*.email_member' => 'Staff',
		]);

		$data = $request->only(['nostaf', 'group_email']);
		$data += ['active' => 1];
		$data += ['status_email_id' => 3];
		$r = \Auth::user()->belongstostaff->hasmanyemailregistration()->create($data);

		if ($request->has('emreg')) {
			foreach($request->emreg as $k => $v) {
				$r->hasmanyemailsuggestion()->create([
					'email_suggestion' => $v['email_suggestion']
				]);
			};
		};

		if ($request->has('emregmem')) {
			foreach($request->emregmem as $k1 => $v1) {
				$r->hasmanyemailgroupmember()->create([
					'department_id' => $v1['email_member_department'],
					'email_staff' => $v1['email_member']
				]);
			};
		};

		// used with multiple db connection
		// $user = Login::find(\Auth::user()->nostaf);
		// $user->setConnection('mysql3');
		// $user->notify(new ApplicantEmailAlert());

		// alert self
		// Notification::send(\Auth::user(), new ApplicantAlert());
		// Login::find(\Auth::user()->nostaf)->notify(new ApplicantAlert());

		Pdf::loadView('email.show', ['email' => $r])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-ER-'.Carbon::parse($r->created_at)->format('ym').str_pad( $r->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// send to self
		Mail::to($r->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->email, $r->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->nama)
			// ->cc($moreUsers)
			// ->bcc($evenMoreUsers)
			->send(new ToApplicantEmail($r));

		// need to find approver -> find jabatan and then find approver
		$dept = \Auth::user()->belongstostaff->belongstomanydepartment->first()->kodjabatan;
		$apprv = Jabatan::find($dept)->belongstomanyappr()->get();
		// dd($apprv);
		if($apprv->count()) {
			foreach ($apprv as $v) {
				// dd($v);
				// send to approver
				Mail::to(Login::find($v->nostaf)->email, $v->nama)
					// ->cc($moreUsers)
					// ->bcc($evenMoreUsers)
					->send(new ToApproverEmail($r, $v));

				// used with multiple db connection
				$user1 = Login::find($v->nostaf);
				$user1->setConnection('mysql3');
				$user1->notify(new ApplicantEmailAlert());
			}
		}

		// finally send it to admin
		if (BTMApprover::where('active', 1)->count()) {
			foreach(BTMApprover::where('active', 1)->get() as $ad) {
				$adm = Login::where('nostaf', $ad->nostaf)->where('is_active', 1)->first();
				Mail::to($adm->email, $adm->name)
					// ->cc($moreUsers)
					// ->bcc($evenMoreUsers)
					->send(new ToBTMEmailCreate($adm, $r));

				// used with multiple db connection
				// $user1 = Login::find($v->nostaf);
				$adm->setConnection('mysql3');
				$adm->notify(new ApplicantEmailAlert());
			};
		};
		return redirect()->route('emailaccapp.index')->with('success', 'Successfully Submitted new Email Registration & Informing The Approver');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(EmailRegistrationApplication $emailaccapp)/*: View*/
	{
		$pdf = Pdf::loadView('email.show', ['email' => $emailaccapp])->setOption(['dpi' => 120]);
		return $pdf->stream('BTM-ER-'.Carbon::parse($emailaccapp->created_at)->format('ym').str_pad( $emailaccapp->id, 3, "0", STR_PAD_LEFT).'.pdf');
		// return view('email.show', ['email' => $emailaccapp]);
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(EmailRegistrationApplication $emailaccapp): View
	{
		return view('email.edit', ['emailaccapp' => $emailaccapp]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, EmailRegistrationApplication $emailaccapp): RedirectResponse
	{
		// dd($request->all());
		$request->validate([
				'nostaf' => 'required',
				'group_email' => 'nullable',
				'emreg.*.email_suggestion' => 'required|alpha_num:ascii',
				'emregmem.*.email_member_department' => 'required_if_accepted:group_email',
				'emregmem.*.email_member' => 'required_if_accepted:group_email',
			], [
				'nostaf' => 'Please insert :attribute',
				'group_email' => 'Please click :attribute',
				'emreg.*.email_suggestion.required' => 'Please insert :attribute at #:position',
				'emregmem.*.email_member_department' => 'Please choose :attribute at #:position',	//:index
				'emregmem.*.email_member' => 'Please choose :attribute at #:position',	//:index
			], [
				'nostaf' => 'Staff ID',
				'group_email' => 'Group Email',
				'emreg.*.email_suggestion' => 'Email ID',
				'emregmem.*.email_member_department' => 'Department',
				'emregmem.*.email_member' => 'Staff',
		]);

		$data = $request->only(['nostaf', 'group_email']);
		$data += ['active' => 1];
		$data += ['status_email_id' => 3];
		$r = $emailaccapp->update($data);

		if ($request->has('emreg')) {
			foreach($request->emreg as $k => $v) {
				EmailSuggestion::updateOrCreate([
						'id' => $v['id'],
						'email_application_id' => $emailaccapp->id
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
						'email_application_id' => $emailaccapp->id
					],
					[
						'department_id' => $v1['email_member_department'],
						'email_staff' => $v1['email_member']
				]);
			};
		};

		Pdf::loadView('email.show', ['email' => $emailaccapp])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-ER-'.Carbon::parse($emailaccapp->created_at)->format('ym').str_pad( $emailaccapp->id, 3, "0", STR_PAD_LEFT).'.pdf');

		// mail to self
		Mail::to($emailaccapp->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->email, $emailaccapp->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->name)
			// ->cc($moreUsers)
			// ->bcc($evenMoreUsers)
			->send(new ToApplicantEmailUpdate($emailaccapp));

		// finally send it to admin
		if (BTMApprover::where('active', 1)->count()) {
			foreach(BTMApprover::where('active', 1)->get() as $ad) {
				$adm = Login::where('nostaf', $ad->nostaf)->where('is_active', 1)->first();
				Mail::to($adm->email, $adm->name)
					// ->cc($moreUsers)
					// ->bcc($evenMoreUsers)
					->send(new ToBTMEmailUpdate($adm, $emailaccapp));
			};
		};
		return redirect()->route('emailaccapp.index')->with('success', 'Successfully Updated Registered Email Application & Informing The Approver');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(EmailRegistrationApplication $emailaccapp): JsonResponse
	{
		$emailaccapp->update(['active' => 0]);
		return response()->json([
			'message' => 'Success deleted Email Registration Application',
			'status' => 'success'
		]);
	}
}
