<?php
// Continuence from routes/web.php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Settings\AddItemController;
use App\Http\Controllers\Settings\AddApproverController;

Route::resources([
	'addapprover' => AddApproverController::class,
]);

Route::middleware('auth')->group(function () {
	Route::get('/additem', [AddItemController::class, 'index'])->name('additem.index');
});


