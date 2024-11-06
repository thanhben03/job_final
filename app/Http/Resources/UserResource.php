<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {

        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'birthday' => $this->birthday,
            'avatar' => $this->avatar,
            'introduce' => $this->introduce,
            'price_per_hours' => $this->price_per_hours,
            'type_work' => $this->type_work,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'gender' => $this->gender,
            'province_id' => $this->province_id,
            'address' => $this->address,
            'main_cv' => $this->main_cv,
            'ban' => $this->ban,
            'workExperiences' => $this->experiences
        ];
    }
}
