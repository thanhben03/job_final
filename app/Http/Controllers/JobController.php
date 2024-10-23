<?php

namespace App\Http\Controllers;


use App\Enums\WorkTypeEnum;
use App\Http\Requests\ApplyJobRequest;
use App\Http\Requests\PostJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Http\Resources\CandidateResource;
use App\Http\Resources\CareerDetailResource;
use App\Http\Resources\CareerResource;
use App\Models\Career;
use App\Models\CurriculumVitae;
use App\Models\Province;
use App\Models\ReportedCareer;
use App\Models\SaveCareer;
use App\Models\Skill;
use App\Models\UserCareer;
use App\Services\Career\CareerServiceInterface;
use App\Services\Skill\SkillServiceInterface;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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
        Session::forget('keyword');
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
            Session::flash('keyword', $request['search']);
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
            'user_id' => auth()?->user()?->id
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
            'cv_id' => auth()?->user()?->cv()->pluck('id')->toArray()
        ])->first();
        $resumes = auth()?->user()?->cv;
        return view('pages.jobs.job-detail', [
            'career' => $career[0],
            'cv_id' => auth()->user()->cv[0]?->id ?? 0,
            'isApplied' => !!$isApplied,
            'resumes' => $resumes,
        ]);
    }
    public function applyJob(ApplyJobRequest $request)
    {
        $data = $request->validated();
        $today = now();

        $job = Career::query()->findOrFail($data['job_id']);

        // Neu thoi gian ung tuyen da het
        if ($today->greaterThan($job->expiration_day)) {
            return response()->json([
                'msg' => 'Application period has expired!'
            ], 500);
        }
        $userCareer = UserCareer::query()->where([
            'career_id' => $data['job_id'],
            'cv_id' => $data['cv_id'],
        ])->first();

        if ($userCareer) {
            return response()->json([
                'msg' => 'You have already applied for this job'
            ], 500);
        }
        UserCareer::query()->create([
            'career_id' => $data['job_id'],
            'cv_id' => $data['cv_id'],
        ]);
    }

    public function store(PostJobRequest $request)
    {
        $matchedCandidates = $this->service->store($request);
        Session::put('matchedCandidates', $matchedCandidates);
        return redirect()->back()->with('msg', 'Career added successfully');
    }

    public function matchWithCandidate(Request $request)
    {
        $careerID = $request->career_id;
        $type = $request->type;
        $career = $this->service->getQueryBuilderWithRelations(['skills'])->find($careerID)->toArray();
        $extractInfo = $this->service->extractInfoRequire($career);

        if ($type == "filter_cv") {
            $candidates = $this->service->matchWithCandidate($extractInfo, $careerID);
        } else {
            $candidates = $this->service->matchWithCandidate($extractInfo);

        }
        return response()->json([
            'candidates' => $candidates,
        ]);

    }

    public function update($id, UpdateJobRequest $request)
    {
        $career = $this->service->update($id, $request);

        return redirect()->back()->with('msg', 'Career Updated Successfully !');
    }

    public function updateUserCareer(Request $request)
    {
        $data = $request->all();

        try {
            $updatedRows = UserCareer::where('id', $data['id'])->update(['status' => $data['status']]);

            if ($updatedRows === 0) {
                return response()->json(['msg' => 'UserCareer not found or no changes made'], 404);
            }

            return response()->json(['msg' => 'Status updated successfully']);
        } catch (\Throwable $th) {

            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    public function reportJob(Request $request)
    {
        $request->validate([
            'career_id' => 'required|exists:careers,id',
        ]);
        try {
            $existJob = Career::query()->findOrFail($request->input('career_id'));
            $existReport = ReportedCareer::query()->where([
                'career_id' => $existJob->id,
                'user_id' => auth()->user()->id
            ])->first();
            if ($existReport) {
                throw new \Exception('You have already reported this job!');
            }

            ReportedCareer::query()->create([
                'career_id' => $existJob->id,
                'user_id' => auth()->user()->id

            ]);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    public function destroy($jobID)
    {
        $job = Career::query()->findOrFail($jobID);
        $job->delete();

        return response()->json(['msg' => 'Career deleted successfully']);
    }
}
