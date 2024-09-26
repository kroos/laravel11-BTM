<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PplController;
use App\Http\Controllers\AssignmentController;
// use App\Http\Controllers\PostController;

Route::apiResources([
	// 'ppls' => PplController::class,
	// 'posts' => PostController::class,
	// 'assignments' => AssignmentController::class,
]);

// same as above
// Route::get('/ppls', [ItemController::class, 'index']);
// Route::prefix('/ppls')->group(function() {
// 	Route::post('/store', [ItemController::class, 'store']);
// 	Route::get('/{id}', [ItemController::class, 'show']);
// 	Route::patch('/{id}', [ItemController::class, 'update']);
// 	Route::delete('/{id}', [ItemController::class, 'destroy']);
// });

