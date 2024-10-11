<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChatResource extends ResourceCollection
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
                'user' => $item->user->toArray(),
                'company' => $item->company->toArray(),
                'message' => $item->message,
                'read' => $item->read,
                'created_at' => $item->created_at->diffForHumans(),
                'sender' => $item->sender,
            ];
        });
    }
}
