<?php

namespace App\Http\Requests;

use App\Enums\WorkTypeEnum;
use App\Models\User;
use BenSampo\Enum\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => 'required|string|max:255',
            'address' => 'required',
            'phone' => 'required|digits_between:9,15',
            'email' => 'required|email|max:255',
            'price_per_hours' => 'required|numeric|min:0',
            'gender' => 'required|in:0,1,2',
            'birthday' => 'required|date',
            'province_id' => 'required',
            'type_work' => ['required'],
            'introduce' => 'nullable|string|max:500',
            'skill_ids' => 'nullable',
            'from_date' => 'nullable',
            'to_date' => 'nullable',
            'title' => 'nullable',
            'position' => 'nullable',
            'description' => 'nullable'
        ];
    }
}
