<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Enums\JobExpEnum;
use App\Enums\LevelEnum;
use App\Enums\QualificationEnum;
use App\Enums\WorkTypeEnum;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Province;
use App\Models\Skill;
use Illuminate\Http\Request;

class CompanyController extends Controller
{


    public function index()
    {
        return view('pages.companies.dashboard');
    }

    public function profile()
    {

        $company = auth()->user()->company;
        return view('pages.companies.company-profile', compact('company'));
    }

    public function update(CompanyUpdateRequest $request)
    {
        $company = auth()->user()->company;
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
        $company = auth()->user()->company;
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
}
