<?php

namespace App\Http\Resources;

use App\Enums\GenderEnum;
use App\Enums\WorkTypeEnum;
use App\Trait\ConvertPriceString;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateSingleResource extends JsonResource
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
            'id' => $this->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'type_work' => WorkTypeEnum::getDescription($this?->type_work) ?? null,
            'gender' => GenderEnum::getDescription($this->gender),
            'price_per_hours' => $this->convertPriceString(intval($this->price_per_hours)),
            'created_at' => $this->created_at->diffForHumans(),
            'match_count' => $this->match_count ?? 0,
            'matches' => $this->matche
        ];
    }
}
