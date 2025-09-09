<?php
// Continuence from routes/web.php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoanApplicationController;
use App\Http\Controllers\LoanEquipmentController;

Route::middleware('auth')->group(function () {

	Route::resources([
		'loanapp' => LoanApplicationController::class,
		'loanequipments' => LoanEquipmentController::class,
	]);









});
