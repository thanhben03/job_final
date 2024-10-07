<?php

namespace App\Http\Resources;

use App\Enums\GenderEnum;
use App\Enums\WorkTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CandidateResource extends ResourceCollection
{
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
                'email' => $item->email,
                'phone' => $item->phone,
                'type_work' => WorkTypeEnum::getValue($item->type_work),
                'gender' => GenderEnum::getDescription($item->gender),
            ];
        });
    }
}
