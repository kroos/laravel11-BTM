<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\PplController;
// use App\Http\Controllers\AssignmentController;
// use App\Http\Controllers\PostController;

use App\Http\Controllers\Api\AjaxDBController;

Route::middleware('auth')->group(function () {
	Route::apiResources([
		// 'ppls' => PplController::class,
		// 'posts' => PostController::class,
		// 'assignments' => AssignmentController::class,
	]);

});

	// Route::get('/ppls', [ItemController::class, 'index'])->name('loginuser');
	// Route::prefix('/ppls')->group(function() {
	// 	Route::post('/store', [ItemController::class, 'store']);
	// 	Route::get('/{id}', [ItemController::class, 'show']);
	// 	Route::patch('/{id}', [ItemController::class, 'update']);
	// 	Route::delete('/{id}', [ItemController::class, 'destroy']);
	// });

	Route::get('/liststaff', [AjaxDBController::class, 'liststaff'])->name('liststaff');
	Route::get('/listjabatan', [AjaxDBController::class, 'listjabatan'])->name('listjabatan');
	Route::get('/equipmentstatus', [AjaxDBController::class, 'equipmentstatus'])->name('equipmentstatus');
	Route::get('/listcategory', [AjaxDBController::class, 'listcategory'])->name('listcategory');
	Route::get('/equipmentdescription', [AjaxDBController::class, 'equipmentdescription'])->name('equipmentdescription');
	Route::get('/status', [AjaxDBController::class, 'status'])->name('status');
	Route::patch('/loanappapprv/{loanapp}', [AjaxDBController::class, 'loanappsapprv'])->name('loanappsapprv');
	Route::patch('/emailappapprv/{emailapp}', [AjaxDBController::class, 'emailappsapprv'])->name('emailappsapprv');
	Route::get('/loancalendar', [AjaxDBController::class, 'loancalendar'])->name('loancalendar');
	Route::get('/listemailjabatan', [AjaxDBController::class, 'listemailjabatan'])->name('listemailjabatan');

