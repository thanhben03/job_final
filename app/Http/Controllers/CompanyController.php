<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Enums\JobExpEnum;
use App\Enums\LevelEnum;
use App\Enums\QualificationEnum;
use App\Enums\StatusCV;
use App\Enums\WorkTypeEnum;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CandidateAppliedResource;
use App\Http\Resources\CareerResource;
use App\Models\Career;
use App\Models\CurriculumVitae;
use App\Models\District;
use App\Models\Province;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserCareer;
use App\Services\Career\CareerServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CompanyController extends Controller
{

    public function __construct(
        CareerServiceInterface $careerService,
    )
    {
        parent::__construct();
        $this->service = $careerService;
    }

    public function index()
    {

        return view('pages.companies.dashboard');
    }

    public function profile()
    {

        $company = Session::get('company');
        return view('pages.companies.company-profile', compact('company'));
    }

    public function update(CompanyUpdateRequest $request)
    {
        $company = Session::get('company');
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $company->fill($data);

        try {
            $company->save();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return redirect()->back()->with('msg', 'Saved successfully!');
    }

    public function resume()
    {
        $company = Session::get('company');
        return view('pages.companies.resume', compact('company'));
    }

    public function showPostJob()
    {
        if (Session::has('matchedCandidates')) {
            dd(Session::get('matchedCandidates'));
        }
        $skills = Skill::all();
        $workType = WorkTypeEnum::asSelectArray();
        $exps = JobExpEnum::asSelectArray();
        $qualifications = QualificationEnum::asSelectArray();
        $genders = GenderEnum::asSelectArray();
        $levels = LevelEnum::asSelectArray();
        $provinces = Province::all()->pluck('name', 'code');
        return view('pages.companies.post-job', compact(
            'skills',
            'workType',
            'exps',
            'qualifications',
            'provinces',
            'genders',
            'levels')
                    );
    }

    public function showManageJob()
    {
        $company = Session::get('company');
        $careers = $this->service->getAllById($company->id);
        $careers = CareerResource::make($careers)->resolve();


        return view('pages.companies.manage-job', compact('careers'));
    }

    public function showDetailJob($slug)
    {
        $career = $this->service->getQueryBuilderWithRelations(['company', 'skills']);
        $career = $career->where('slug', $slug)->get();
        $career = CareerResource::make($career)->resolve()[0];

        $skills = Skill::all();
        $workType = WorkTypeEnum::asSelectArray();
        $exps = JobExpEnum::asSelectArray();
        $qualifications = QualificationEnum::asSelectArray();
        $genders = GenderEnum::asSelectArray();
        $levels = LevelEnum::asSelectArray();
        $provinces = Province::all()->pluck('name', 'code');
        $districts = District::query()->where('province_code', $career['province']->code)->get();
        return view('pages.companies.detail-job',
            compact('career', 'skills', 'workType', 'exps', 'qualifications', 'genders', 'levels', 'provinces', 'districts'));
    }

    public function showCandidateAppliedJob($job_id)
    {
        $career = Career::query()->findOrFail($job_id);
        $career = CandidateAppliedResource::make($career)->resolve();
        $statusCV = StatusCV::asSelectArray();

        return view('pages.companies.candidate-applied', compact('career', 'statusCV'));
    }
}
