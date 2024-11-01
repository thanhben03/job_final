<?php

namespace App\Http\Controllers\Api;

use App\Enums\WorkTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\CurriculumVitae;
use App\Models\Province;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllCV ($user_id) {
        $cvs = CurriculumVitae::query()->where('user_id', $user_id)->get()->pluck('path', 'id');
        return response()->json($cvs);
    }

    public function infoSystem () {
        $provinces = Province::all()->pluck('name', 'code');
        $workType = WorkTypeEnum::getLabels();
        $workTypeConvert = [];

        foreach ($workType as $key => $value) {
            $workTypeConvert[] = [
                'key' => $key,
                'value' => $value
            ];
        }

        return response()->json([
            'provinces' => $provinces,
            'workType' => $workTypeConvert
        ]);
    }
}
