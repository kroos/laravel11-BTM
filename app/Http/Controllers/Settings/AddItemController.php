<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// models
// use App\Models\Staff;

// load db facade
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

// for controller output
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;


// load array helper
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

use Session;
use Throwable;
use Exception;
use Log;


class AddItemController extends Controller
{
	function __construct()
	{
		// $this->middleware(['auth']);
		$this->middleware('BTMAdmin');
	}

	public function index(): View
	{
		// $cicategories = ConditionalIncentiveCategory::all();
		// return view('settings.index', ['cicategories' => $cicategories]);
		return view('settings.additem');
	}

}
