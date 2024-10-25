<?php

namespace App\Http\Controllers;

use App\Http\Resources\CareerResource;
use App\Models\Province;
use App\Models\Skill;
use App\Services\Career\CareerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct(
        CareerService $careerService,
    )
    {
        $this->service = $careerService;
    }

    public function index(Request $request)
    {
        session()->forget('conversation_history');
        $skills = Skill::all();
        $provinces = Province::all();

        $careers = $this->service
            ->getQueryBuilderWithRelations(['company', 'skills']);
        $careers = $careers->paginate(10);
        $data = CareerResource::make($careers)->resolve();
        return view('pages.home', [
            'skills' => $skills,
            'provinces' => $provinces,
            'data' => $data,
            'careers' => $careers,
        ]);
    }

    public function fetchDataSelect($type)
    {

        switch ($type) {
            case 'position':
                $pos = DB::table('positions')->get()->pluck('title')->toArray();
                return response()->json($pos);
            case 'soft-skill':
                $softSkills = DB::table('soft_skills')->get()->pluck('skill_name')->toArray();
                return response()->json($softSkills);
            case 'skill':
                $skills = DB::table('skills')->get()->pluck('name')->toArray();
                return response()->json($skills);
            case 'province':
                $provinces = DB::table('provinces')->get()->pluck('name')->toArray();
                return response()->json($provinces);
        }
    }
}
