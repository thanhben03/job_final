<?php


use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\AuthController;
use App\Models\Province;
use App\Models\Skill;
use Illuminate\Support\Facades\Route;


Route::prefix('api/v1')->group(function () {

    Route::prefix('/jobs')->group(function () {

        Route::get('/', [JobController::class, 'index']);

        Route::get('/all', [JobController::class, 'getAll']);
        Route::get('/filter', [JobController::class, 'getFilterJob']);
        Route::get('/{id}', [JobController::class, 'show']);

    });

    Route::prefix('/provinces')->group(function () {
        Route::get('/', function () {
            $provinces = Province::all();
            return response()->json($provinces);
        });
    });

    Route::prefix('/skills')->group(function () {
        Route::get('/', function () {
            $skills = Skill::all();
            return response()->json($skills);
        });
    });

    Route::prefix('/auth')->group(function () {
        Route::post('/login', [AuthController::class, 'signin']);
    });
});
