<?php

namespace App\Http\Resources;

use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SavedJobResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($item) {
            $career = Career::query()->where('id', $item->career_id)->first();

            return [
                'id' => $career->id,
                'career' => [
                    'id' => $career->id,
                    'title' => $career->title,
                    'company_name' => $career->company->company_name,
                    'avatar' => env('APP_URL') . '/images/avatar/'.$career->company->company_avatar,
                    'location' => $career->province->name,
                ],
            ];
        });
    }
}
