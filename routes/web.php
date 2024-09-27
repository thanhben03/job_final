<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('/jobs', JobController::class);

Route::post('/api/v1/applyJob', [JobController::class, 'applyJob'])->name('api.v1.applyJob');
Route::get('/candidates/dashboard', [CandidateController::class, 'index'])->name('candidate.dashboard');
Route::get('/candidates/profile', [CandidateController::class, 'profile'])->name('candidate.profile');
Route::get('/candidates/job-applied', [CandidateController::class, 'jobApplied'])->name('candidate.job-applied');
Route::get('/candidates/my-resume', [CandidateController::class, 'myResume'])->name('candidate.my-resume');
Route::get('/candidates/saved-job', [CandidateController::class, 'savedJob'])->name('candidate.saved-job');
Route::post('/candidates/saved-job', [CandidateController::class, 'processSavedJob'])->name('candidate.process.saved-job');
Route::post('/upload-cv', [CandidateController::class, 'uploadCv'])->name('api.file.upload');
Route::post('/upload-avatar', [CandidateController::class, 'uploadAvatar'])->name('api.file.upload.avatar');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('pdf-to-img', [CandidateController::class, 'pdfToImg'])->name('pdf-to-img');

require __DIR__.'/auth.php';
