<?php

namespace App\Http\Resources;

use App\Enums\StatusCV;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CandidateAppliedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

//    protected $career;

    /**
     * Constructor để nhận $collection và $career.
     */
//    public function __construct($collection, $career)
//    {
//        // Gọi hàm parent với collection được truyền vào.
//        parent::__construct($collection);
//
//        // Lưu career vào biến class
//        $this->career = $career;
//    }

    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'candidates' => $this->user_career->map(function ($user_career) {
                return [
                    'user_career_id' => $user_career->id,
                    'info' => $user_career->curriculum_vitae->user ?? null,
                    'status' => StatusCV::getDescription(intval($user_career->status)),
                    'cv' => $user_career->curriculum_vitae->path ?? null,
                    'applied_day' => $user_career->created_at->toDateString() ?? null,
                ];
            }),
            'title' => $this->title
        ];
    }
}
