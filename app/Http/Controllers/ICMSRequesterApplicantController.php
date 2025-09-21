<?php
namespace App\Http\Controllers;


// for controller output
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Illuminate\View\View;

// models
use App\Models\ICMSRequesterApplicant;

// load db facade
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Http;

// load validation
use Illuminate\Http\Request;

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

class ICMSRequesterApplicantController extends Controller
{
	function __construct()
	{
		// $this->middleware(['auth']);
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(): View
	{
		//
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
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(ICMSRequesterApplicant $regaccicmsapplicant): View
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(ICMSRequesterApplicant $regaccicmsapplicant): View
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, ICMSRequesterApplicant $regaccicmsapplicant): RedirectResponse
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(ICMSRequesterApplicant $regaccicmsapplicant): JsonResponse
	{
		$regaccicmsapplicant->belongstomanyicmsmodule()->detach();
		$regaccicmsapplicant->delete();
		return response()->json([
			'message' => 'Success Delete Request Application',
			'status' => 'success'
		]);
	}
}
