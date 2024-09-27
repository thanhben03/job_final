<?php

namespace App\Http\Controllers;

use App\Http\Resources\CareerResource;
use App\Models\Province;
use App\Models\Skill;
use App\Services\Career\CareerService;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct(
        CareerService $careerService,
    )
    {
        $this->service = $careerService;
    }

    public function index()
    {
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
}
