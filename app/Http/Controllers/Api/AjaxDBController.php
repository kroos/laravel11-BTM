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
use App\Models\Settings\Category;
use App\Models\Settings\Item;

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

	public function listcategory(Request $request): JsonResponse
	{
		$values = Category::where('category','LIKE','%'.$request->search.'%')->get();
		// dd($values);
		foreach ($values as $value) {
				$g['children'][] = [
									'id' => $value->id,
									'text' => $value->category,
								];
		}
		$cat['results'][] = $g;
		return response()->json($cat);
	}

	public function equipmentstatus(Request $request): JsonResponse
	{
		$values = Item::where('status', 1)->where('item','LIKE','%'.$request->search.'%')->get();
		// dd($values);
		foreach ($values as $value) {
				$g['children'][] = [
									'id' => $value->id,
									'text' => $value->item,
									'class' => $value->category_id,
								];
		}
		$equipments['results'][] = $g;
		return response()->json($equipments);
	}

	public function equipmentdescription(Request $request): JsonResponse
	{
		$values = Item::find($request->id);
		// dd($values);
		$equipmentsdesc = [
			'item' => $values->item,
			'brand' => $values->brand,
			'model' => $values->model,
			'serial_number' => $values->serial_number,
			'description' => $values->description,
		];
		return response()->json($equipmentsdesc);
	}












}
