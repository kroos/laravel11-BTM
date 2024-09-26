<?php
// Continuence from routes/web.php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SettingController;

Route::resources([
	// 'leave' => HRLeaveController::class,
]);

Route::middleware('auth')->group(function () {
	Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
});
