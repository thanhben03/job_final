<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListCVResource extends ResourceCollection
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
               'path' => $item->path,
               'thumbnail' => $item->thumbnail,
               'created_at' => $item->created_at->toDateString(),
           ];
        });
    }
}
