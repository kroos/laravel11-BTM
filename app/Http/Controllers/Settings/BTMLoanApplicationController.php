<?php
namespace App\Http\Controllers\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// models
use App\Models\LoanApplication;
use App\Models\LoanEquipment;
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

class BTMLoanApplicationController extends Controller
{
	function __construct()
	{
		// $this->middleware(['auth']);
		$this->middleware('BTMAdmin');
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
		return view('loan.create');
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
