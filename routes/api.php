<?php


use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Models\Province;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::prefix('api/v1')->group(function () {

    Route::prefix('/jobs')->group(function () {

        Route::get('/', [JobController::class, 'index']);

        Route::get('/all', [JobController::class, 'getAll']);
        Route::get('/filter', [JobController::class, 'getFilterJob']);
        Route::get('/{id}', [JobController::class, 'show']);
        Route::post('/apply-job', [JobController::class, 'applyJob']);
        Route::post('/save-job', [JobController::class, 'saveJob']);
        Route::post('/report-job', [JobController::class, 'reportJob']);

    });

    Route::prefix('/provinces')->group(function () {
        Route::get('/', function () {
            $provinces = Province::all();
            return response()->json($provinces);
        });
    });

    Route::get('/info-system', [UserController::class, 'infoSystem']);
    Route::post('/update-profile', [UserController::class, 'updateProfile']);

    Route::prefix('/skills')->group(function () {
        Route::get('/', function () {
            $skills = Skill::all();
            return response()->json($skills);
        });
    });

    Route::prefix('/auth')->group(function () {
        Route::post('/login', [AuthController::class, 'signin']);
    });


    Route::get('/get-cv/{user_id}', [UserController::class, 'getAllCV']);
});
