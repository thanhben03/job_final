<?php

namespace App\Http\Resources\Api;

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
                'career' => $item->career,
                'company' => $item->company,
                'note' => $item->note,
                'date' => $item->date,
                'time' => $item->time,
                'status' => $item->status
            ];
        });
    }
}
