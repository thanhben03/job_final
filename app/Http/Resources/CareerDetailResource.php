<?php

namespace App\Http\Resources;

use App\Enums\JobExpEnum;
use App\Enums\LevelEnum;
use App\Enums\WorkTypeEnum;
use App\Trait\ConvertPriceString;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Collection\Collection;

class CareerDetailResource extends JsonResource
{
    use ConvertPriceString;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $request->id,
            'title' => $request->title,
            'slug' => $request->slug,
            'min_salary' => $this->convertPriceString(intval($request->min_salary)),
            'max_salary' => $this->convertPriceString(intval($request->max_salary)),
            'address' => $request->address,
            'phone' => $request->phone,
            'experience' => JobExpEnum::getDescription(intval($request->experience)),
            'level' => LevelEnum::getDescription(intval($request->level)),
            'company' => $request->company,
            'work_type' => WorkTypeEnum::getDescription(intval($request->work_type)),
            'skills' => $request->skills,
            'currentPage' => $request->currentPage,
            'perPage' => $request->perPage,
            'total' => $request->total,
            'province' => $request->province->name,
            'updated_at' => $request->updated_at->diffForHumans(),
            'detail' => $request->detail ?? new Collection()
        ];
    }
}
