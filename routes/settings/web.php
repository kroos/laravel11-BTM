<?php
// Continuence from routes/web.php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Settings\AddItemController;
use App\Http\Controllers\Settings\AddApproverController;
use App\Http\Controllers\Settings\AddBTMApproverController;
use App\Http\Controllers\Settings\BTMLoanApplicationController;
use App\Http\Controllers\Settings\BTMEmailApplicationController;
use App\Http\Controllers\LoanApplicationController;
use App\Http\Controllers\LoanEquipmentController;

Route::middleware('auth')->group(function () {

	Route::get('/additem', [AddItemController::class, 'index'])->name('additem.index');

	Route::resources([
		'addapprover' => AddApproverController::class,
		'loanapp' => LoanApplicationController::class,
		'loanequipments' => LoanEquipmentController::class,
		'btmapprover' => AddBTMApproverController::class,
		'btmloanapplications' => BTMLoanApplicationController::class,
		'btmemailapplications' => BTMEmailApplicationController::class,
	]);

});
