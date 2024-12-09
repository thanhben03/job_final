<?php


use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OpenAIController;
use App\Http\Controllers\CandidateController;
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
        Route::get('/get-saved-job/{id}', [JobController::class, 'getSavedJob']);
        Route::get('/get-applied-job/{id}', [JobController::class, 'getAppliedJob']);
        Route::get('/get-appointment/{id}', [JobController::class, 'getAppointment']);
        Route::post('/report-job', [JobController::class, 'reportJob']);

    });

    Route::post('/update-appointment', [JobController::class, 'updateAppointment']);
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



    Route::get('/notifications/{id}', [UserController::class, 'notifications']);
    Route::get('/notifications/delete-all/{id}', [UserController::class, 'deleteAllNotifications']);


    Route::get('/get-cv/{user_id}', [UserController::class, 'getAllCV']);
    Route::post('/upload-cv', [UserController::class, 'uploadCV']);
    Route::post('/upload-avatar', [UserController::class, 'uploadAvatar']);
    Route::get('/delete-cv/{cvId}', [CandidateController::class, 'deleteCV']);
    Route::post('/set-default-cv', [UserController::class, 'setDefaultCV']);
    Route::post('/chatbot', [OpenAIController::class, 'getResponse']);
    Route::get('/get-chat/{user_id}', [UserController::class, 'getAllChatByUser']);
    Route::get('/get-chat/{user_id}/{company_id}', [UserController::class, 'getDetailChat']);

    Route::post('/send-message-to-company', [UserController::class, 'sendMessageToCompany']);


});

Route::prefix('/api/v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'signin']);
});
