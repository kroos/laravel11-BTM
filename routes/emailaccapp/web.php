<?php
// Continuence from routes/web.php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmailRegistrationApplicationController;
use App\Http\Controllers\EmailSuggestionController;
use App\Http\Controllers\EmailGroupMemberController;

Route::middleware('auth')->group(function () {

	Route::resources([
		'emailaccapp' => EmailRegistrationApplicationController::class,
		'emailsuggestion' => EmailSuggestionController::class,
		'emailgroupmember' => EmailGroupMemberController::class,
	]);

});
