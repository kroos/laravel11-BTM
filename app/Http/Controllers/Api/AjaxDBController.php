<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;

// load Carbon
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \Carbon\CarbonInterval;

// load batch and queue
// use Illuminate\Bus\Batch;
// use Illuminate\Support\Facades\Bus;

// for controller output
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

// load helper
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

use Log;
use Session;
use Exception;
use Throwable;

// load model
use App\Models\Jabatan;
use App\Models\Staff;

class AjaxDBController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function liststaff(Request $request): JsonResponse
	{
		$values = Staff::where('status', 'A')->where('nama','LIKE','%'.$request->search.'%')->orderBy('nama')->get();
		foreach ($values as $value) {
			$g['children'][] = [
								'id' => $value->nostaf,
								'text' => $value->nama,
							];
		}
		$staff['results'][] = $g;
		return response()->json($staff);
	}

	public function listjabatan(Request $request): JsonResponse
	{
		$values = Jabatan::where('aktif', 1)->where('namajabatan','LIKE','%'.$request->search.'%')->orderBy('namajabatan')->get();
		// dd($values);
		foreach ($values as $value) {
				$g['children'][] = [
									'id' => $value->kodjabatan,
									'text' => $value->namajabatan,
								];
		}
		$jabatan['results'][] = $g;
		return response()->json($jabatan);
	}

	public function equipmentstatus(Request $request): JsonResponse
	{
		$values = Item::where('status_item','LIKE','%'.$request->search.'%')->orderBy('id')->get();
		// dd($values);
		foreach ($values as $value) {
				$g['children'][] = [
									'id' => $value->id,
									'text' => $value->status_item,
								];
		}
		$equipments['results'][] = $g;
		return response()->json($equipments);
	}











}
