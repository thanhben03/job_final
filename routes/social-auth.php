<?php

use App\Http\Controllers\SocialLoginController;
use Illuminate\Support\Facades\Route;


Route::get('/auth/{type}', [SocialLoginController::class, 'showLogin'])->name('auth.login');

Route::get('/auth/{type}/callback', [SocialLoginController::class, 'handleCallback']);
