<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyResource extends ResourceCollection
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
                'company_name' => $item->company_name,
                'company_address' => $item->company_address,
                'company_phone' => $item->company_phone,
                'company_email' => $item->company_email,
                'website' => $item->website,
                'company_avatar' => $item->company_avatar,
                'banner' => $item->banner,
                'introduce' => $item->introduce,
                'facebook_link' => $item->facebook_link,
                'twitter_link' => $item->twitter_link,
                'instagram_link' => $item->instagram_link,
                'careers' => $item->careers,
            ];
        });
    }
}
