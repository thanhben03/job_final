<?php

namespace App\Http\Controllers;


use App\Enums\WorkTypeEnum;
use App\Http\Resources\CareerDetailResource;
use App\Http\Resources\CareerResource;
use App\Models\CurriculumVitae;
use App\Models\Province;
use App\Models\SaveCareer;
use App\Models\Skill;
use App\Models\UserCareer;
use App\Services\Career\CareerServiceInterface;
use App\Services\Skill\SkillServiceInterface;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JobController extends Controller
{
    private SkillServiceInterface $skillService;

    public function __construct(
        CareerServiceInterface $careerService,
        SkillServiceInterface $skillService
    )
    {
        $this->service = $careerService;
        $this->skillService = $skillService;
    }

    public function index(Request $request)
    {
        Session::flash('job-type');
        Session::flash('skills');
        Session::flash('locations');
        Session::flash('sort');
        if ($request->has('sort')) {
            $sort = $request['sort'] == 'latest' ? 'desc' : 'asc';
            Session::flash('sort', $request['sort']);
            $careers = $this->service
                ->getQueryBuilderWithRelationsUpdated(['company', 'skills'], $sort);
        } else {
            $careers = $this->service
                ->getQueryBuilderWithRelations(['company', 'skills']);
        }

        if ($request['search']) {
            $careers = $careers->where('title', 'like', '%' . $request['search'] . '%');
        }
        if ($request->has('job-type')) {
            // Chuyển chuỗi 'job_type' thành mảng
            $jobTypeFilter = explode(',', $request->input('job-type'));
            Session::flash('job-type', $request['job-type']);

            // Lọc theo các giá trị trong mảng $jobTypeFilter
            $careers = $careers->whereIn('working_time', array_map(function($jobType) {
                return WorkTypeEnum::getValue($jobType); // Áp dụng enum mapping
            }, $jobTypeFilter));

        }
        if ($request->has('skills')) {
            $skillFilter = explode(',', $request['skills']);
            Session::flash('skills', $request['skills']);

            $skillIds = Skill::query()->whereIn('name', $skillFilter)->pluck('id')->toArray();
            $careers = $careers->hasSkills($skillIds);
        }

        if ($request->has('locations')) {
            $locationFilter = explode(',', $request['locations']);
            Session::flash('locations', $request['locations']);
            $locationIds = Province::query()->whereIn('name', $locationFilter)->pluck('code')->toArray();
            $careers = $careers->whereIn('province_id', $locationIds);
        }



        $careers = $careers->paginate(10);
        $data = CareerResource::make($careers);
        $skills = $this->skillService->getAll();
        $provinces = Province::query()->get(['code', 'name']);
        $careerIdSaved = SaveCareer::query()->where([
            'user_id' => auth()->user()->id
        ])->pluck('career_id')->toArray();

        return view('pages.jobs.job-list', [
            'careers' => $careers,
            'skills' => $skills,
            'provinces' => $provinces,
            'data' => $data->resolve(),
            'careerIdSaved' => $careerIdSaved,
        ]);
    }

    public function show($slug)
    {
        $career = $this->service->getQueryBuilderWithRelations(['company', 'skills']);
        $career = $career->where('slug', $slug)->get();
        $career = CareerResource::make($career)->resolve();
        $isApplied  = UserCareer::query()->where([
            'career_id' => $career[0]['id'],
            'cv_id' => auth()->user()->cv()->pluck('id')->toArray()
        ])->first();
        $resumes = auth()->user()->cv;
        return view('pages.jobs.job-detail', [
            'career' => $career[0],
            'cv_id' => auth()->user()->cv[0]?->id ?? 0,
            'isApplied' => !!$isApplied,
            'resumes' => $resumes,
        ]);
    }
    public function applyJob(Request $request)
    {
        $jobId = $request->input('jobId');
        $cv = CurriculumVitae::query()
            ->where('user_id', auth()->user()->id)
            ->first();
        UserCareer::query()->create([
            'career_id' => $jobId,
            'cv_id' => $cv->id,
        ]);
    }
}
