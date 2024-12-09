<?php

namespace App\Http\Resources;

use App\Enums\GenderEnum;
use App\Enums\JobExpEnum;
use App\Enums\LevelEnum;
use App\Enums\QualificationEnum;
use App\Enums\StatusCV;
use App\Enums\WorkTypeEnum;
use App\Models\UserCareer;
use App\Trait\ConvertPriceString;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JobAppliedResource extends ResourceCollection
{

    use ConvertPriceString;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($career) {
            return [
                'id' => $career->id,
                'title' => $career->career->title,
                'slug' => $career->career->slug,
                'employee' => $career->career->employee,
                'min_salary' => [
                    'origin' => $career->career->min_salary,
                    'convert' => $this->convertPriceString(intval($career->career->min_salary))
                ],
                'max_salary' => [
                    'origin' => $career->career->max_salary,
                    'convert' => $this->convertPriceString(intval($career->career->max_salary))
                ],
                'flag' => $career->career->reported->count() > 1 ? '1' : '0',
                'address' => $career->career->address,
                'phone' => $career->career->phone,
                'experience' => JobExpEnum::getDescription(intval($career->career->experience)),
                'level' => LevelEnum::getDescription(intval($career->career->level)),
                'company' => $career->career->company,
                'work_type' => WorkTypeEnum::getDescription(intval($career->career->work_type)),
                'skills' => $career->career->skills,
                'currentPage' => $career->career->currentPage,
                'perPage' => $career->career->perPage,
                'total' => $career->career->total,
                'province' => $career->career->province,
                'district' => $career->career->district,
                'updated_at' => $career->career->updated_at->diffForHumans(),
                'created_at' => $career->career->created_at->toDateString(),
                'expiration_day' => $career->career->expiration_day,
                'gender' => GenderEnum::getDescription($career->career->gender),
                'qualification' => QualificationEnum::getDescription($career->career->qualification),
                'detail' => $career->career->detail,
                'cv_applied' => $career->career->user_careers,
                'appointments' => AppointmentResource::make($career->career->appointments)->resolve(),
                'from_time' => $career->career->from_time,
                'to_time' => $career->career->to_time,
                'published' => $career->career->status,
                'status' => StatusCV::getDescription($career->status),
                'category' => $career->career->category
            ];
        });


    }
}
