<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatSingleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->user->toArray(),
            'company' => $this->company->toArray(),
            'message' => $this->message,
            'read' => $this->read,
            'created_at' => $this->created_at->diffForHumans(),
            'sender' => $this->sender,
        ];
    }
}
