<?php

use App\Http\Controllers\Web\Admin\PassportApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware(['auth', 'sensitive_auth'])->name('admin.')->group(function () {
    Route::resource('applications', PassportApplicationController::class);
    Route::post('applications/{application}/status', [PassportApplicationController::class, 'updateStatus'])->name('applications.update-status');
});
