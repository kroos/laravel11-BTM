<?php
namespace App\Http\Controllers;


// for controller output
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// models
use App\Models\ICMSModule;

// load db facade
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

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

class ICMSModuleController extends Controller
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
    public function show(ICMSModule $iCMSModule): View
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ICMSModule $iCMSModule): View
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ICMSModule $iCMSModule): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ICMSModule $iCMSModule): RedirectResponse
    {
        //
    }
}
