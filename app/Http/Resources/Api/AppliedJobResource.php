<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AppliedJobResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($item) {
            $career = $item->career;
            return [
                'id' => $career->id,
                'career' => $career,
                'company' => $career->company,
                'status' => $item->status,
                'created_at' => $item->created_at->locale('vi')->diffForHumans()

            ];
        });
    }
}
