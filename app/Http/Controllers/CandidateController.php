<?php

namespace App\Http\Controllers;

use App\Http\Resources\CareerResource;
use App\Models\Career;
use App\Models\UserCareer;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function __construct(
        UserService $userService
    )
    {
        $this->service = $userService;
    }

    public function index()
    {
        return view('pages.candidates.dashboard');
    }

    public function jobApplied()
    {
        // lay tat ca cv cua nguoi dung
        $cvIds = auth()->user()->cv()->pluck('id')->toArray();

        // lay id cv cac job ma nguoi dung da apply
        $ids = UserCareer::query()->whereIn('cv_id', $cvIds)->pluck('career_id')->toArray();

        // lay cac job
        $careers = Career::query()->whereIn('id', $ids)->paginate(10);
        $data = CareerResource::make($careers)->resolve();

        return view('pages.candidates.job-applied', compact('data', 'careers'));
    }

    public function profile()
    {
        return view('pages.candidates.profile');
    }

    public function myResume()
    {
        return view('pages.candidates.my-resume');
    }

    public function savedJob()
    {
        $ids = auth()->user()->saveJob()->pluck('career_id')->toArray();
        $careers = Career::query()->whereIn('id', $ids)->get();
        $data = CareerResource::make($careers)->resolve();
        return view('pages.candidates.saved-job', compact('careers', 'data'));
    }
}
