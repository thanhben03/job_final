<?php

use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckBannedUser;
use App\Http\Middleware\CheckBannerCompany;
use App\Http\Middleware\CompanyAuthenticated;
use App\Http\Middleware\UserAuthenticated;
use Illuminate\Contracts\Session\Session;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/fetch-data-select/{type}', [HomeController::class, 'fetchDataSelect'])->name('fetch.data.select');

//Route::resource('/jobs', JobController::class);


//Route::get('/jobs/{category}', [JobController::class, 'index'])->name('jobs.index');
//Route::get('/jobs/{category}/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');

Route::post('/api/v1/applyJob', [JobController::class, 'applyJob'])->name('api.v1.applyJob');
Route::get('/api/v1/get-district/{province_id}', [LocationController::class, 'getDistrict'])->name('api.v1.get-district');

Route::post('/job', [JobController::class, 'store'])->name('job.store');
Route::post('/job/update-user-career', [JobController::class, 'updateUserCareer'])->name('job.update.user.career');
Route::post('/job/report/', [JobController::class, 'reportJob'])->name('job.report');
Route::get('/job/get-reason-decline/{id}', [JobController::class, 'getReasonDecline']);

Route::post('/match-with-candidate', [JobController::class, 'matchWithCandidate'])->name('match.with.candidate');
Route::get('/match-with-job/{id}', [CandidateController::class, 'matchWithJob'])->name('match.with.job');
Route::get('/match-with-job-cv-upload/{cv_id}', [OpenAIController::class, 'getInfoFromCV'])->name('match.with.job.cv');


Route::middleware([UserAuthenticated::class, CheckBannedUser::class])->group(function () {
    Route::get('/candidates/dashboard', [CandidateController::class, 'index'])->name('candidate.dashboard');
    Route::get('/candidates/profile', [CandidateController::class, 'profile'])->name('candidate.profile');
    Route::get('/candidates/job-applied', [CandidateController::class, 'jobApplied'])->name('candidate.job-applied');
    Route::get('/candidates/my-resume', [CandidateController::class, 'myResume'])->name('candidate.my-resume');
    Route::get('/candidates/saved-job', [CandidateController::class, 'savedJob'])->name('candidate.saved-job');
    Route::post('/candidates/saved-job', [CandidateController::class, 'processSavedJob'])->name('candidate.process.saved-job');
    Route::get('/candidates/create-cv/{id?}', [CandidateController::class, 'createCv'])->name('candidate.create-cv');
    Route::get('/candidates/store-cv', [CandidateController::class, 'storeCV'])->name('candidate.store-cv');
    Route::get('/candidates/delete-cv/{cvId}', [CandidateController::class, 'deleteCV'])->name('candidate.delete-cv');
    Route::get('/candidates/review-cv', [CandidateController::class, 'showReviewCV'])->name('candidate.show.review-cv');
    Route::post('/candidates/review-cv', [CandidateController::class, 'reviewCV'])->name('candidate.review-cv');
    Route::get('/candidates/appointment', [CandidateController::class, 'showAppointment'])->name('candidate.show.appointment');
    Route::get('/candidates/chat/{to_user?}', [CandidateController::class, 'showChat'])->name('candidate.show.chat');
});



Route::post('/upload-cv', [CandidateController::class, 'uploadCv'])->name('api.file.upload');
Route::post('/upload-avatar', [CandidateController::class, 'uploadAvatar'])->name('api.file.upload.avatar');
Route::post('/upload-avatar-company', [CandidateController::class, 'uploadAvatarCompany'])->name('api.file.upload.avatar.company');

Route::middleware([CompanyAuthenticated::class, CheckBannerCompany::class])->group(function () {
    Route::get('/companies/dashboard', [CompanyController::class, 'index'])->name('company.dashboard');
    Route::get('/companies/profile', [CompanyController::class, 'profile'])->name('company.profile');
    Route::get('/companies/post-job', [CompanyController::class, 'showPostJob'])->name('company.show.post-job');
    Route::get('/companies/edit-job/{id}', [CompanyController::class, 'showEditJob'])->name('company.show.edit-job');
    Route::get('/companies/manage-job', [CompanyController::class, 'showManageJob'])->name('company.manage-job');
    Route::get('/companies/detail-job/{slug}', [CompanyController::class, 'showDetailJob'])->name('company.show.detail-job');
    Route::get('/companies/candidate-applied/{job_id}', [CompanyController::class, 'showCandidateAppliedJob'])->name('company.show.detail-job');
    Route::put('/companies/update/{company_id}', [CompanyController::class, 'update'])->name('company.profile.update');
    Route::get('/companies/chat', [CompanyController::class, 'showChat'])->name('company.show.chat');
    Route::get('/companies/list-invite', [CompanyController::class, 'showListInvite'])->name('company.show.invite');
    Route::get('/companies/candidate-list', [CompanyController::class, 'showCandidateList'])->name('company.show.candidate.list');
    Route::post('/companies/send-invite-interview', [CompanyController::class, 'sendInviteInterview'])->name('company.send.invite.interview');
    Route::get('/candidates/download-cv/{user_id}', [CandidateController::class, 'downloadCV']);

    Route::post('/candidates/report', [CandidateController::class, 'reportCandidate'])->name('candidate.report');
    Route::get('/candidates/list', [CandidateController::class, 'showListCandidate'])->name('candidate.list');
    Route::get('/candidates/detail/{id}', [CandidateController::class, 'showDetailCandidate'])->name('candidate.detail');
});

Route::get('/companies/detail/{companyId}', [CompanyController::class, 'companyDetail'])->name('company.detail');
Route::get('/companies/list', [CompanyController::class, 'list'])->name('company.list');
Route::get('/companies/account-not-active', [CompanyController::class, 'accountNotActive'])->name('company.account-not-active');



Route::post('/appointments', [AppointmentController::class, 'store'])->name('store.appointment');
Route::get('/appointments/{user_id}', [AppointmentController::class, 'getAppointments']);
Route::post('/appointments/{id}/accept', [AppointmentController::class, 'acceptAppointment']);
Route::post('/appointments/{id}/reject', [AppointmentController::class, 'rejectAppointment']);
Route::post('/appointments/cancel', [AppointmentController::class, 'cancel']);
Route::post('/appointments/{appointmentId}/update', [AppointmentController::class, 'updateAppointment'])->name('appointment.update.time');

Route::get('/notification/read-message', [NotificationController::class, 'readMessage'])->name('read.all.message');
Route::get('/notification/delete-all/{type}', [NotificationController::class, 'deleteAll'])->name('delete.all');
Route::get('/notification/read-message-company', [NotificationController::class, 'readMessageCompany'])->name('read.all.company.message');

Route::post('/chat/send-to-user', [ChatController::class, 'sendMessageToUser'])->name('send.chat.to.user');
Route::post('/chat/send-to-company', [ChatController::class, 'sendMessageToCompany'])->name('send.chat.to.company');
Route::get('/chat/view-chat/{companyId}', [ChatController::class, 'viewChatForUser'])->name('chat.getChat');
Route::get('/chat/view-chat-company/{userId}', [ChatController::class, 'viewChatForCompany'])->name('chat.getChat.company');
Route::post('/chat/quick-chat/', [ChatController::class, 'quickChat'])->name('quick.chat');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('pdf-to-img', [CandidateController::class, 'pdfToImg'])->name('pdf-to-img');

Route::get('invite-interview', [CandidateController::class, 'acceptInterview']);
Route::middleware(StartSession::class)->post('/chatbot', [OpenAIController::class, 'getResponse'])->name('chat.bot');


Route::get('/set-main-cv/{id}', [CandidateController::class, 'setMainCv'])->name('set.main.cv');

Route::get('/language/{locale?}', [HomeController::class, 'setLanguage'])->name('set.language');

Route::post('/test', [OpenAIController::class, 'test2']);


require __DIR__ . '/auth.php';
require __DIR__ . '/company-auth.php';
require __DIR__ . '/social-auth.php';
require __DIR__ . '/api.php';
