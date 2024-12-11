<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// models
use App\Models\EmailGroupMember;

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

class EmailGroupMemberController extends Controller
{
	function __construct()
	{
		// $this->middleware(['auth']);
		// $this->middleware('loanOwner', ['only' => ['show', 'edit', 'update', 'destroy']]);
		// $this->middleware('deptApprover', ['only' => ['show', 'edit']]);
		// $this->middleware('BTMAdmin');
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(): View
	{
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
	public function show(EmailGroupMember $emailgroupmember): View
	{
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(EmailGroupMember $emailgroupmember): View
	{
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, EmailGroupMember $emailgroupmember): RedirectResponse
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(EmailGroupMember $emailgroupmember): JsonResponse
	{
		$emailgroupmember->delete();
		return response()->json([
			'status' => 'success',
			'message' => 'Success deleted Loan Equipment',
		]);
	}
}
