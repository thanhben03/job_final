<?php

namespace App\Http\Controllers;


use App\Enums\WorkTypeEnum;
use App\Http\Middleware\UserAuthenticated;
use App\Http\Requests\ApplyJobRequest;
use App\Http\Requests\PostJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Http\Resources\CandidateResource;
use App\Http\Resources\CareerDetailResource;
use App\Http\Resources\CareerResource;
use App\Mail\ApplicantNotification;
use App\Models\Career;
use App\Models\Category;
use App\Models\CurriculumVitae;
use App\Models\Province;
use App\Models\ReportedCareer;
use App\Models\SaveCareer;
use App\Models\Skill;
use App\Models\UserCareer;
use App\Services\Career\CareerServiceInterface;
use App\Services\Skill\SkillServiceInterface;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class JobController extends Controller
{
    private SkillServiceInterface $skillService;

    public function __construct(
        CareerServiceInterface $careerService,
        SkillServiceInterface $skillService
    ) {
        $this->service = $careerService;
        $this->skillService = $skillService;

        $this->middleware(UserAuthenticated::class)->except(['index', 'store', 'update', 'matchWithCandidate', 'getReasonDecline']);
    }

    public function index(Request $request)
    {
        Session::flash('job-type');
        Session::flash('skills');
        Session::flash('locations');
        Session::flash('sort');
        Session::forget('keyword');
        Session::forget('category');

        //        $category = Category::query()->where('slug', $category)->firstOrFail();

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
            // $careers = $careers->where('title', 'like', '%' . $request['search'] . '%');
            $careers = $careers->searchFulltext($request['search']);
            Session::flash('keyword', $request['search']);
        }

        if ($request->has('job-type')) {
            // Chuyển chuỗi 'job_type' thành mảng
            $jobTypeFilter = explode(',', $request->input('job-type'));
            Session::flash('job-type', $request['job-type']);

            // Lọc theo các giá trị trong mảng $jobTypeFilter
            $careers = $careers->whereIn('working_time', array_map(function ($jobType) {
                return WorkTypeEnum::getValue($jobType); // Áp dụng enum mapping
            }, $jobTypeFilter));
        }
        if ($request->has('skills')) {
            $skillFilter = explode(',', $request['skills']);
            Session::flash('skills', $request['skills']);

            $skillIds = Skill::query()->whereIn('name', $skillFilter)->pluck('id')->toArray();
            $careers = $careers->hasSkills($skillIds);
        }
        if ($request->has('category')) {
            Session::flash('category', $request['category']);
            $careers = $careers->hasCategory($request['category']);
        }

        if ($request->has('locations')) {

            $locationFilter = explode(',', $request['locations']);
            Session::flash('locations', $request['locations']);
            $locationIds = Province::query()->whereIn('name', $locationFilter)->pluck('code')->toArray();
            $careers = $careers->whereIn('careers.province_id', $locationIds);
            // $careers = $careers->where('province_id', $locationIds[0]);

        }


        //        $careers->where([
        //            'category_id' => $category->id,
        //            'status' => 1
        //        ]);
        $careers = $careers->where([
            'status' => 1,
            'deleted_at' => null
        ])->paginate(10);
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
            //            'category' => $category,
            'careerIdSaved' => $careerIdSaved,
        ]);
    }

    public function show($slug)
    {

        $career = $this->service->getQueryBuilderWithRelations(['company', 'skills']);
        $career = $career
            ->where([
                'slug' => $slug,
                'deleted_at' => null
            ])->get();

        if ($career->count() <= 0) {
            return redirect()->back();
        }
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

        if ($job->spam->count() >= 2) {
            return response()->json([
                'message' => 'This job is being flagged!'
            ], 500);
        }


        if ($job->deleted_at != null || $job->status != 1) {
            return response()->json([
                'message' => 'This job was not found!'
            ], 500);
        }




        // Neu thoi gian ung tuyen da het
        if ($today->greaterThan($job->expiration_day)) {
            return response()->json([
                'message' => 'Application period has expired!'
            ], 500);
        }
        $userCareer = UserCareer::query()->where([
            'career_id' => $data['job_id'],
            'cv_id' => $data['cv_id'],
        ])->first();

        if ($userCareer) {
            return response()->json([
                'message' => 'You have already applied for this job'
            ], 500);
        }
        UserCareer::query()->create([
            'career_id' => $data['job_id'],
            'cv_id' => $data['cv_id'],
        ]);

        $cv = CurriculumVitae::query()->findOrFail($data['cv_id']);
        $applicantInfo = [
            'name' => auth()->user()->fullname,
            'phone' => auth()->user()->phone,
            'email' => auth()->user()->email,
            'letter' => $data['letter']
        ];

        // Gửi email
        Mail::to($job->company->email)->send(
            new ApplicantNotification($applicantInfo, storage_path("app/public/uploads/" . $cv->path))
        );
    }

    public function store(PostJobRequest $request)
    {
        $matchedCandidates = $this->service->store($request);
        Session::put('matchedCandidates', $matchedCandidates);

        // return response()->json([
        //     'message' => 'ok'
        // ]);
        return redirect()->back()->with('msg', 'Career added successfully');
    }

    public function matchWithCandidate(Request $request): \Illuminate\Http\JsonResponse
    {
        $careerID = $request->career_id;
        $career = Career::query()->where('id', $careerID)->first();
        if (!$career) {
            return response()->json([
                'message' => 'Career not found!'
            ], 500);
        }

        if ($career->status == 0) {
            return response()->json([
                'message' => 'Waiting for approval for this job!'
            ], 500);
        }
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
        try {
            $career = $this->service->update($id, $request);
        } catch (\Throwable $th) {
            dd($th);
        }

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
            'career_id' => 'required',
            'report_content' => 'nullable',
            'files' => 'nullable', // Xác định "images" là một mảng
            'files.*' => 'mimes:jpg,jpeg,png,gif,webp|max:2048', // Mỗi phần tử trong mảng phải là hình ảnh
        ], [
            'files.*.mimes' => 'Only accept files with the following formats: jpg, jpeg, png, gif, or webp.', // Custom message cho từng file
        ]);
        try {
            if (strlen($request->report_content) > 100) {
                throw new \Exception('Content must not exceed 100 characters');
            }
            $existJob = Career::query()->findOrFail($request->input('career_id'));
            $existReport = ReportedCareer::query()->where([
                'career_id' => $existJob->id,
                'user_id' => auth()->user()->id
            ])->first();
            if ($existReport) {
                throw new \Exception('You have already reported this job!');
            }
            $uploadedFiles = [];
            // Lưu các file lên Cloudinary hoặc lưu vào storage
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $uploadedFileUrl = cloudinary()->upload($file->getRealPath())->getSecurePath();
                    // Lưu thông tin URL vào mảng để trả về
                    $uploadedFiles[] = $uploadedFileUrl;
                }
            }

            ReportedCareer::query()->create([
                'career_id' => $existJob->id,
                'user_id' => auth()->user()->id,
                'report_content' => $request->report_content,
                'images' => json_encode($uploadedFiles),
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function destroy($jobID)
    {
        $job = Career::query()->findOrFail($jobID);
        $job->deleted_at = 1;
        $job->save();
        //        $job->delete();

        return response()->json(['msg' => 'Career deleted successfully']);
    }

    public function getReasonDecline($id)
    {
        $career = Career::query()->findOrFail($id);

        return response()->json($career->reason);
    }
}
