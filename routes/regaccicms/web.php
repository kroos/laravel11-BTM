<?php
use Illuminate\Support\Facades\Route;

// load controller
use App\Http\Controllers\ICMSRequesterController;
use App\Http\Controllers\ICMSRequesterApplicantController;
use App\Http\Controllers\Settings\RegAccICMS\AdminICMSRequesterController;

Route::middleware('auth')->group(function () {
	Route::resources([
		'regaccicms' => ICMSRequesterController::class,
		'regaccicmsapplicant' => ICMSRequesterApplicantController::class,
		'adminregaccicms' => AdminICMSRequesterController::class,		// admin
	]);
});
