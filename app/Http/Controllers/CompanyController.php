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
use App\Http\Resources\ListInviteResource;
use App\Mail\InviteInterview;
use App\Models\Career;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Company;
use App\Models\District;
use App\Models\Province;
use App\Models\Skill;
use App\Models\User;
use App\Models\InviteInterview as Interview;
use App\Models\Notification;
use App\Models\UserCareer;
use App\Services\Career\CareerServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CompanyController extends Controller
{

    public function __construct(
        CareerServiceInterface $careerService,
    ) {
        parent::__construct();
        $this->service = $careerService;
    }

    public function accountNotActive () {

        if (Auth::guard('company')->user()->is_active == 0) {
            return view('pages.companies.account-not-active');
        }

        return redirect()->route('company.dashboard');

    }

    public function index()
    {
        $company = Auth::guard('company')->user();
        $postedJobCount = $company->careers()->count();
        $appliedCount = UserCareer::query()->whereIn('career_id', $company->careers->pluck('id'))->count();
        $messageCount = Chat::query()->where('company_id', $company->id)->count();
        $notificationCount = Notification::query()->where('company_id', $company->id)->count();
        
        return view('pages.companies.dashboard',compact('postedJobCount', 'appliedCount', 'messageCount', 'notificationCount'));
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

        $skills = Skill::all();
        $workType = WorkTypeEnum::asSelectArray();
        $exps = JobExpEnum::asSelectArray();
        $qualifications = QualificationEnum::asSelectArray();
        $genders = GenderEnum::asSelectArray();
        $levels = LevelEnum::asSelectArray();
        $provinces = Province::all()->pluck('name', 'code');
        $categories = Category::all();
        return view(
            'pages.companies.post-job',
            compact(
                'skills',
                'workType',
                'exps',
                'qualifications',
                'provinces',
                'genders',
                'levels',
                'categories'
            )
        );
    }

    public function showEditJob ($id) {
        $career = Career::query()->where('id', $id)->get();
        $career = CareerResource::make($career)->resolve()[0];
        $skills = Skill::all();
        $workType = WorkTypeEnum::asSelectArray();
        $exps = JobExpEnum::asSelectArray();
        $qualifications = QualificationEnum::asSelectArray();
        $genders = GenderEnum::asSelectArray();
        $provinces = Province::all()->pluck('name', 'code');
        $levels = LevelEnum::asSelectArray();
        $categories = Category::all();
        $districts = District::query()->where('province_code', $career['province']->code)->get();


        return view('pages.companies.edit-job', 
        compact('districts','career', 'skills', 'workType', 'exps', 'qualifications', 'genders', 'provinces', 'levels', 'categories')
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
        return view(
            'pages.companies.detail-job',
            compact('career', 'skills', 'workType', 'exps', 'qualifications', 'genders', 'levels', 'provinces', 'districts')
        );
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

    public function showCandidateList()
    {
        return view('pages.companies.candidate-list');
    }

    public function companyDetail(Request $request, $companyId)
    {
        $company = Company::query()->where('id', $companyId)->get();
        $company = CompanyResource::make($company)->resolve()[0];
        if ($request->wantsJson()) {
            return response()->json($company);
        }
        $company['careers'] = $company['careers']->sortByDesc('created_at')->take(10);

        return view('pages.companies.company-detail', compact('company'));
    }

    public function sendInviteInterview(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'position' => 'required',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'location' => 'required|string',
            'time' => 'required'
        ]);

        $data = $request->all();
        $code = rand(100000, 999999);
        try {
            $userExist  = User::query()->find($data['candidate_id']);
            $body = [
                'title' => $data['title'],
                'content' => $data['content'],
                'position' => $data['position'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'time' => $data['time'],
                'location' => $data['location'],
                'company_name' => \auth()->guard('company')->user()->company_name,
                'user' => $userExist,
                'code' => $code
            ];

            Mail::to($userExist->email)->send(new InviteInterview($body));
            Interview::query()->create([
                'user_id' => $userExist->id,
                'company_id' => \auth()->guard('company')->user()->id,
                'code' => $code
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Invitation sent'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'msg' => $e->getMessage(),
            ], 404);
        }
    }

    public function showListInvite()
    {
        $invites = Interview::query()->where([
            'company_id' => \auth()->guard('company')->user()->id
        ])
            ->orderBy('id', 'desc')
            ->get();

        $invites = ListInviteResource::make($invites)->resolve();
        return view('pages.companies.list-invite', compact('invites'));
    }
}
