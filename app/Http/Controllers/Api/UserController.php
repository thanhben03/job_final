<?php

namespace App\Http\Controllers\Api;

use App\Enums\WorkTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\CurriculumVitae;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getAllCV($user_id)
    {
        $cvs = CurriculumVitae::query()->where('user_id', $user_id)->get()->pluck('path', 'id');
        return response()->json($cvs);
    }

    public function infoSystem()
    {
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

    public function updateProfile(Request $request)
    {
        $dataUser = $request->except('workExperiences', 'id');
        $dataExperience = $request->only('workExperiences');
        $user = User::query()->find($request->id);
        $user->update($dataUser);
        $user->save();
        
        if ($user) {
            try {
                DB::beginTransaction();

                if (count($dataExperience) > 0) {
                    $user->experiences()->delete();
                    foreach ($dataExperience['workExperiences'] as $value) {
                        $user->experiences()->create([
                            'from_date' => $value['from_date'],
                            'to_date' => $value['to_date'],
                            'title' => $value['company'],
                            'position' => $value['position'],
                            'description' => $value['description'],
                            'user_id' => $dataUser['id']
                        ]);
                    }
                }

                DB::commit();
                return response()->json(['msg' => 'Cập nhật thành công!', 'user' => $user]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(['msg' => $th->getMessage()], 500);
            }
        }
    }
}
