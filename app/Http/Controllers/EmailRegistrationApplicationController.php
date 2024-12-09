<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// models
use App\Models\EmailRegistrationApplication;
use App\Models\EmailSuggestion;
use App\Models\EmailGroupMember;
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
		// $this->middleware('loanOwner', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
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
				'emreg.*.email_suggestion' => 'required|alpha:ascii',
				'emregmem.*.email_member_department' => 'required_if_accepted:group_email',
				'emregmem.*.email_member' => 'required_if_accepted:group_email',
			], [
				'nostaf' => 'Please insert :attribute',
				'group_email' => 'Please click :attribute',
				'emreg.*.email_suggestion' => 'Please insert :attribute at #:position',
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
	}

	/**
	 * Display the specified resource.
	 */
	public function show(LoanApplication $loanapp)/*: View*/
	{
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(LoanApplication $loanapp): View
	{
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, LoanApplication $loanapp): RedirectResponse
	{
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(LoanApplication $loanapp): JsonResponse
	{
	}
}
