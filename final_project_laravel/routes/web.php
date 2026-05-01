<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Admin\EmployeeController;
use App\Http\Controllers\Web\Admin\PassportApplicationController;
use App\Http\Controllers\Web\Admin\SettingsController;
use App\Http\Controllers\Web\InquiryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InquiryController::class, 'index'])->name('inquiry.index');
Route::get('/inquiry', [InquiryController::class, 'show'])->name('inquiry.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('applications', PassportApplicationController::class);
        Route::post('applications/{application}/status', [PassportApplicationController::class, 'updateStatus'])->name('applications.update-status');

        Route::resource('employees', EmployeeController::class);
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
