<?php

namespace App\Http\Resources;

use App\Enums\GenderEnum;
use App\Enums\WorkTypeEnum;
use App\Trait\ConvertPriceString;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CandidateResource extends ResourceCollection
{
    use ConvertPriceString;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'fullname' => $item->fullname,
                'flag' => $item->reported->count() > 1 ? '1' : '0',
                'email' => $item->email,
                'introduce' => $item->introduce,
                'experiences' => $item->experiences,
                'avatar' => $item->avatar,
                'skills' => $item->skills,
                'address' => $item->address,
                'phone' => $item->phone,
                'province' => $item?->province ?? '',
                'main_cv' => $item->mainCV,
                'type_work' => WorkTypeEnum::getDescription($item->type_work),
                'gender' => GenderEnum::getDescription($item->gender),
                'price_per_hours' => $this->convertPriceString(intval($item->price_per_hours)),
            ];
        });
    }
}
