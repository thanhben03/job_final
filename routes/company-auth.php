<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Company\Auth\LoginCompanyController;
use App\Http\Controllers\Company\Auth\RegisteredCompanyController;
use Illuminate\Support\Facades\Route;



Route::prefix('companies')->as('company.')->middleware('guest:company')->group(function () {
    Route::get('/login', [LoginCompanyController::class, 'create'])->name('login');
    Route::post('/login', [LoginCompanyController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisteredCompanyController::class, 'create'])->name('register');

    Route::post('/register', [RegisteredCompanyController::class, 'store'])->name('register.store');

});

Route::prefix('companies')->as('company.')->middleware('auth:company')->group(function () {

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [LoginCompanyController::class, 'destroy'])->name('logout');
});
