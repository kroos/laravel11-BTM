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

// load pdf
use Barryvdh\DomPDF\Facade\Pdf;

// send email
use Illuminate\Support\Facades\Mail;
use App\Mail\ToApplicantUnApproved;
use App\Mail\ToApplicantUpdate;

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
use App\Models\Login;
use App\Models\LoanApplication;
use App\Models\StatusEquipment;
use App\Models\StaffJabatan;
use App\Models\Settings\Category;
use App\Models\Settings\Item;

class AjaxDBController extends Controller
{
	function __construct()
	{
	}

	public function liststaff(Request $request): JsonResponse
	{
		$values = Staff::where('status', 'A')
											->where('nama','LIKE','%'.$request->search.'%')
											->orderBy('nama')
											->get();
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
		$values = Jabatan::where('aktif', 1)
												->where('namajabatan','LIKE','%'.$request->search.'%')
												->orderBy('namajabatan')
												->get();
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
				$g[] = [
									'id' => $value->id,
									'cat' => $value->category,
								];
		}
		return response()->json($g);
	}

	public function equipmentstatus(Request $request): JsonResponse
	{
		// dd($request->all());
		// Fetch subcategories with optional search
		$values = Item::where('status', 1)
										->when($request->categoryId, function ($query) use ($request){
											$query->where('category_id', $request->categoryId);
										})
										->when($request->search, function ($query) use ($request) {
												$query->where('name', 'LIKE', '%' . $request->search . '%');
										})
										// ->get(['id', 'item', 'category_id']);
										->get();
		// dd($values->count());
		if ($values->count()) {
			foreach ($values as $value) {
				$g['children'][] = [
									'id' => $value->id,
									'text' => $value->item,
									'class' => $value->category_id,
								];
			}
		} else {
				$g = [];
		}
		$equipments['results'][] = $g;
		return response()->json($equipments);
	}

	public function status(Request $request): JsonResponse
	{
		$values = StatusEquipment::where('status_item','LIKE','%'.$request->search.'%')->get();
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

	public function loanappsapprv(Request $request, LoanApplication $loanapp): JsonResponse
	{
		// dd($request->all(), \Auth::user());
		// return response()->json([]);
		$request->validate([
				'acknowledge' => 'required|accepted',
				'status' => 'required',
				'remarks_approver' => 'required_if:status,2',
				'approver_staff' => 'required',
			], [
				'acknowledge' => 'Please checked on :attribute',
				'status' => 'Please choose your :attribute',
				'remarks_approver' => 'Please fill up :attribute',
				'approver_staff' => 'Missing :attribute'
			], [
				'acknowledge' => 'Acknowledgement',
				'status' => 'Approval',
				'remarks_approver' => 'Remarks',
				'approver_staff' => 'Staff ID',
		]);

		if ($request->status == 2) {
			$loanapp->update([
				'status_loan_id' => 2,
				'approver_status_id' => $request->status,
				'approver_staff' => $request->approver_staff,
				'approver_date' => now(),
				'approver_remarks' => ucwords(Str::lower(trim($request->remarks_approver))),
				'status_loan_id' => 2,
			]);

			Pdf::loadView('loan.show', ['loanapp' => $loanapp])->setOption(['dpi' => 120])->save(storage_path('app/public/pdf/').'BTM-LE-'.Carbon::parse($loanapp->created_at)->format('ym').str_pad( $loanapp->id, 3, "0", STR_PAD_LEFT).'.pdf');

			// dd($loanapp->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->email, $loanapp->belongstostaff->nama);
			// mail to loan owner of unapproved loan
			Mail::to($loanapp->belongstostaff->hasmanylogin()->where('is_active', 1)->first()->email, $loanapp->belongstostaff->nama)
				// ->cc($moreUsers)
				// ->bcc($evenMoreUsers)
				->send(new ToApplicantUnApproved($loanapp));

		} elseif ($request->status == 1) {
			$loanapp->update([
				'approver_status_id' => $request->status,
				'approver_staff' => $request->approver_staff,
				'approver_date' => now(),
				'approver_remarks' => ucwords(Str::lower(trim($request->remarks_approver))),
			]);
		}
		return response()->json([
			'message' => 'Success granted approval for the loan',
			'status' => 'success'
		]);
	}

	public function loancalendar()
	{
		$outstation = LoanApplication::where('active', 1)->orWhereIn('status_loan_id', [1,3])->get();
		if ($outstation->count()) {
			foreach ($outstation as $v) {
				$loanDetails = [
							'title' => 'Loan by '.$v->belongstostaff->nama,
							'start' => $v->date_loan_from,
							'end' => Carbon::parse($v->date_loan_to)->addDay(),
							// 'url' => route('hrleave.show', $v->id),
							'allDay' => true,
							'extendedProps' => [
													'status' => 'Status: '.$v->belongstostatusloan->status_loan
												],
							// 'description' => 'Loan by '.$v->belongstostaff->nama,
							'color' => 'blue',
							'textColor' => 'white',
							'borderColor' => 'blue',
					];
					// Get all equipment descriptions and join them as a single string
					$descriptions = 'Loan by '.$v->belongstostaff->nama.' => '.$v->hasmanyequipments()->get()->pluck('belongstoequipment.item')->join(', ');

					// Add the descriptions to the loan details
					$loanDetails['description'] = $descriptions;

					// Add the loan details to the output array
					$out[] = $loanDetails;
			}
		} else {
			$out[] = [];
		}
		return response()->json( $out );
	}

	public function listemailjabatan(Request $request)
	{
		$je = Jabatan::find($request->dept_id)->belongstomanystaff()->get();
		$p = [];
		foreach ($je as $e) {
			$activeLogin = $e->hasmanylogin()->where('is_active', 1)->first();
			if ($activeLogin !== null && $activeLogin->email !== null) {
					$p[] = $e->hasmanylogin()->where('is_active', 1)->pluck('email', 'name');
			}
		}
		return response()->json($p);
	}






}
