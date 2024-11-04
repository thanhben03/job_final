<?php

namespace App\Http\Resources;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AppointmentResource extends ResourceCollection
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
                'company' => Company::query()->find($item->company_id),
                'date' => $item->date,
                'time' => $item->time,
                'status' => $item->status,
                'note' => $item->note,
                'created_at' => $item->created_at->toDateString(),
                'candidate' => User::query()->find($item->user_id),
                'career' => $item->career
            ];
        });
    }
}
