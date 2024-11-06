<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class NotificationResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map( function ($item) {
            return [
                'id' => $item->id,
                'message' => $item->message,
                'company' => Company::query()->where('id', $item->from_id)->first(),
                'created_at' => $item->created_at->diffForHumans()
            ];
        });
    }
}
