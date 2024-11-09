<?php

namespace App\Http\Resources\Api;

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
                'user' => [
                    'id' => $item->user->id,
                    'avatar' => env('APP_URL').'/images/avatar/'.$item->user->avatar,
                ],
                'company' => [
                    'id' => $item->company->id,
                    'name' => $item->company->company_name,
                    'avatar' => env('APP_URL').'/images/avatar/'.$item->company->company_avatar,
                ],
                'message' => $item->message,
                'read' => $item->read,
                'created_at' => $item->created_at->diffForHumans(),
                'sender' => $item->sender,
            ];
        });
    }
}
