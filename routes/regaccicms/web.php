<?php
use Illuminate\Support\Facades\Route;

// load controller
use App\Http\Controllers\ICMSRequesterController;

Route::middleware('auth')->group(function () {
	Route::resources([
		'regaccicms' => ICMSRequesterController::class,
	]);
});
