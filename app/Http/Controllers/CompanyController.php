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
use App\Http\Resources\ChatResource;
use App\Http\Resources\CompanyResource;
use App\Models\Career;
use App\Models\Chat;
use App\Models\Company;
use App\Models\CurriculumVitae;
use App\Models\District;
use App\Models\Province;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserCareer;
use App\Services\Career\CareerServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $company = Auth::guard("company")->user();
        return view('pages.companies.company-profile', compact('company'));
    }

    public function update(CompanyUpdateRequest $request)
    {
        $company = Auth::guard("company")->user();
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
        $company = Auth::guard("company")->user();
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
        $company = Auth::guard("company")->user();
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

    public function showChat()
    {
        $latestMessages = Chat::query()
            ->select('chats.*')
            ->where([
                'company_id' => Auth::guard("company")->user()->id
            ])
            ->join(
                DB::raw('(SELECT MAX(id) as latest_id FROM chats
                WHERE company_id = ' . Auth::guard("company")->user()->id . '
                GROUP BY user_id) as latest'),
                'chats.id',
                '=',
                'latest.latest_id'
            )
            ->orderBy('created_at', 'desc')
            ->get();
        $latestMessages = ChatResource::make($latestMessages)->resolve();
        return view('pages.companies.chat', compact('latestMessages'));
    }

    public function list(Request $request)
    {
        Session::flash('locations');
        Session::forget('keyword');
        Session::forget('company-size');
        Session::forget('sort');
        $companies = Company::query();



        if ($request['search']) {
            $companies = $companies->where('company_name', 'like', '%' . $request['search'] . '%');
            Session::flash('keyword', $request['search']);
        }

        if ($request->has('locations')) {
            $locationFilter = explode(',', $request['locations']);
            Session::flash('locations', $request['locations']);
            $locationIds = Province::query()->whereIn('name', $locationFilter)->pluck('code')->toArray();
            $companies = $companies->whereIn('province_id', $locationIds);
        }

        if ($request->has('company-size')) {
            $companySize = $request['company-size'];
            switch ($companySize) {
                case '1':
                    $companies = $companies->where('employee', '<=', 20);
                    break;
                case '2':
                    $companies = $companies->whereBetween('employee', [20, 50]);
                    break;
                case '3':
                    $companies = $companies->where('employee', '>', 50);
                    break;
            }
            Session::flash('company-size', $companySize);
        }

        if ($request->has('sort')) {
            $sort = $request['sort'] == 'latest' ? 'desc' : 'asc';
            Session::flash('sort', $request['sort']);
            $companies = $companies->orderBy('created_at', $sort);
        } else {
            $companies = $companies->orderBy('created_at', 'desc');
        }


        $companies = $companies->paginate(10);
        $companyResources = CompanyResource::make($companies)->resolve();
        return view('pages.companies.company-list', compact('companies', 'companyResources'));
    }
}
