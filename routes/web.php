<?php

use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\AuthenticatedCompanyController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\UserAuthenticated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('/jobs', JobController::class);

Route::post('/api/v1/applyJob', [JobController::class, 'applyJob'])->name('api.v1.applyJob');
Route::get('/api/v1/get-district/{province_id}', [LocationController::class, 'getDistrict'])->name('api.v1.get-district');

Route::post('/job', [JobController::class, 'store'])->name('job.store');
Route::post('/job/update-user-career', [JobController::class, 'updateUserCareer'])->name('job.update.user.career');
Route::post('/job/report/', [JobController::class, 'reportJob'])->name('job.report');

Route::post('/match-with-candidate', [JobController::class, 'matchWithCandidate'])->name('match.with.candidate');
Route::get('/match-with-job/{id}', [CandidateController::class, 'matchWithJob'])->name('match.with.job');


Route::middleware(UserAuthenticated::class)->group(function () {
    Route::get('/candidates/dashboard', [CandidateController::class, 'index'])->name('candidate.dashboard');
    Route::get('/candidates/profile', [CandidateController::class, 'profile'])->name('candidate.profile');
    Route::get('/candidates/job-applied', [CandidateController::class, 'jobApplied'])->name('candidate.job-applied');
    Route::get('/candidates/my-resume', [CandidateController::class, 'myResume'])->name('candidate.my-resume');
    Route::get('/candidates/saved-job', [CandidateController::class, 'savedJob'])->name('candidate.saved-job');
    Route::post('/candidates/saved-job', [CandidateController::class, 'processSavedJob'])->name('candidate.process.saved-job');
    Route::get('/candidates/create-cv/{id?}', [CandidateController::class, 'createCv'])->name('candidate.create-cv');
    Route::get('/candidates/store-cv', [CandidateController::class, 'storeCV'])->name('candidate.store-cv');
    Route::get('/candidates/delete-cv/{cvId}', [CandidateController::class, 'deleteCV'])->name('candidate.delete-cv');
    Route::post('/candidates/report', [CandidateController::class, 'reportCandidate'])->name('candidate.report');
    Route::get('/candidates/review-cv', [CandidateController::class, 'showReviewCV'])->name('candidate.show.review-cv');
    Route::post('/candidates/review-cv', [CandidateController::class, 'reviewCV'])->name('candidate.review-cv');
    Route::get('/candidates/appointment', [CandidateController::class, 'showAppointment'])->name('candidate.show.appointment');
    Route::get('/candidates/chat/{to_user?}', [CandidateController::class, 'showChat'])->name('candidate.show.chat');
    Route::get('/candidates/list', [CandidateController::class, 'showListCandidate'])->name('candidate.list');
    Route::get('/candidates/detail/{id}', [CandidateController::class, 'showDetailCandidate'])->name('candidate.detail');
});



Route::post('/upload-cv', [CandidateController::class, 'uploadCv'])->name('api.file.upload');
Route::post('/upload-avatar', [CandidateController::class, 'uploadAvatar'])->name('api.file.upload.avatar');
Route::post('/upload-avatar-company', [CandidateController::class, 'uploadAvatarCompany'])->name('api.file.upload.avatar.company');

Route::middleware('auth:company')->group(function () {
    Route::get('/companies/dashboard', [CompanyController::class, 'index'])->name('company.dashboard');
    Route::get('/companies/profile', [CompanyController::class, 'profile'])->name('company.profile');
    Route::get('/companies/post-job', [CompanyController::class, 'showPostJob'])->name('company.show.post-job');
    Route::get('/companies/manage-job', [CompanyController::class, 'showManageJob'])->name('company.manage-job');
    Route::get('/companies/detail-job/{slug}', [CompanyController::class, 'showDetailJob'])->name('company.show.detail-job');
    Route::get('/companies/candidate-applied/{job_id}', [CompanyController::class, 'showCandidateAppliedJob'])->name('company.show.detail-job');
    Route::put('/companies/update', [CompanyController::class, 'update'])->name('company.profile.update');
    Route::get('/companies/chat', [CompanyController::class, 'showChat'])->name('company.show.chat');
    Route::get('/companies/candidate-list', [CompanyController::class, 'showCandidateList'])->name('company.show.candidate.list');

});
Route::get('/companies/detail/{companyId}', [CompanyController::class, 'companyDetail'])->name('company.detail');
Route::get('/companies/list', [CompanyController::class, 'list'])->name('company.list');

//Route::get('/company/login', [AuthenticatedCompanyController::class, 'create'])->name('company.showLogin');
//Route::post('/company/login', [AuthenticatedCompanyController::class, 'store'])->name('company.login');


Route::post('/appointments', [AppointmentController::class, 'store'])->name('store.appointment');
Route::get('/appointments/{user_id}', [AppointmentController::class, 'getAppointments']);
Route::post('/appointments/{id}/accept', [AppointmentController::class, 'acceptAppointment']);
Route::post('/appointments/{id}/reject', [AppointmentController::class, 'rejectAppointment']);
Route::post('/appointments/{appointmentId}/update', [AppointmentController::class, 'updateAppointment'])->name('appointment.update.time');

Route::get('/notification/read-message', [NotificationController::class, 'readMessage'])->name('read.all.message');
Route::get('/notification/read-message-company', [NotificationController::class, 'readMessageCompany'])->name('read.all.company.message');

Route::post('/chat/send-to-user', [ChatController::class, 'sendMessageToUser'])->name('send.chat.to.user');
Route::post('/chat/send-to-company', [ChatController::class, 'sendMessageToCompany'])->name('send.chat.to.company');
Route::get('/chat/view-chat/{companyId}', [ChatController::class, 'viewChatForUser'])->name('chat.getChat');
Route::get('/chat/view-chat-company/{userId}', [ChatController::class, 'viewChatForCompany'])->name('chat.getChat.company');
Route::post('/chat/quick-chat/', [ChatController::class, 'quickChat'])->name('quick.chat');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('pdf-to-img', [CandidateController::class, 'pdfToImg'])->name('pdf-to-img');

require __DIR__.'/auth.php';
require __DIR__.'/company-auth.php';
require __DIR__.'/social-auth.php';
require __DIR__.'/api.php';

