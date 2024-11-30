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

class ManageJobResource extends ResourceCollection
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
                'title' => $career->title,
                'slug' => $career->slug,
                'employee' => $career->employee,
                'min_salary' => [
                    'origin' => $career->min_salary,
                    'convert' => $this->convertPriceString(intval($career->min_salary))
                ],
                'max_salary' => [
                    'origin' => $career->max_salary,
                    'convert' => $this->convertPriceString(intval($career->max_salary))
                ],
                'flag' => $career->reported->count() > 1 ? '1' : '0',
                'address' => $career->address,
                'phone' => $career->phone,
                'experience' => JobExpEnum::getDescription(intval($career->experience)),
                'level' => LevelEnum::getDescription(intval($career->level)),
                'company' => $career->company,
                'work_type' => WorkTypeEnum::getDescription(intval($career->work_type)),
                'skills' => $career->skills,
                'currentPage' => $career->currentPage,
                'perPage' => $career->perPage,
                'total' => $career->total,
                'province' => $career->province,
                'district' => $career->district,
                'updated_at' => $career->updated_at->diffForHumans(),
                'created_at' => $career->created_at->toDateString(),
                'expiration_day' => $career->expiration_day,
                'gender' => GenderEnum::getDescription($career->gender),
                'qualification' => QualificationEnum::getDescription($career->qualification),
                'detail' => $career->detail,
                'cv_applied' => $career->user_careers,
                'appointments' => AppointmentResource::make($career->appointments)->resolve(),
                'from_time' => $career->from_time,
                'to_time' => $career->to_time,
                'published' => $career->status,
                'status' => auth()->user() && $career->user_careers->count() > 0 && auth()->user()->cv() !== null
                    ? ($careerCV = $career->user_careers->whereIn('cv_id', auth()->user()->cv()->pluck('id')->toArray())->first())
                        ? StatusCV::getDescription($careerCV->status)
                        : ''
                    : '',
                'category' => $career->category
            ];
        });


    }
}
