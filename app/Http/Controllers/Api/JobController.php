<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CareerDetailResource;
use App\Http\Resources\CareerResource;
use App\Models\Career;
use App\Models\Province;
use App\Models\Skill;
use App\Services\Career\CareerServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JobController extends Controller
{
    public function __construct(CareerServiceInterface $careerService)
    {
        $this->service = $careerService;
    }

    public function index()
    {
        $careers = $this->service->getAll()->take(5);
        $careers = CareerResource::make($careers)->resolve();
        return response()->json($careers);
    }

    public function getAll(Request $request)
    {
        $careers = Career::query();
        if ($request->has('search')) {
            $careers->where('title', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->has('locations')) {
            $locationFilter = explode(',', $request['locations']);
            Session::flash('locations', $request['locations']);
            $locationIds = Province::query()->whereIn('name', $locationFilter)->pluck('code')->toArray();
            $careers = $careers->whereIn('province_id', $locationIds);
        }
        if ($request->has('skills')) {
            $skillFilter = explode(',', $request['skills']);
            Session::flash('skills', $request['skills']);

            $skillIds = Skill::query()->whereIn('name', $skillFilter)->pluck('id')->toArray();
            $careers = $careers->hasSkills($skillIds);
        }



        $careers = $careers->paginate(10);
        $data = CareerResource::make($careers)->resolve();
        return response()->json([
            'jobs' => $data,
            'total' => $careers->total()
        ]);
    }


    public function show($jobId)
    {
        $job = Career::query()->where('id', $jobId)->get();
        $job = CareerResource::make($job)->resolve()[0];
        return response()->json($job);
    }

}
