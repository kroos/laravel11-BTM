<?php
// Continuence from routes/web.php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmailRegistrationApplicationController;

Route::middleware('auth')->group(function () {

	Route::resources([
		'emailaccapp' => EmailRegistrationApplicationController::class,
	]);

});
