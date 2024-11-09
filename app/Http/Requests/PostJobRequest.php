<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Enums\JobExpEnum;
use App\Enums\LevelEnum;
use App\Enums\QualificationEnum;
use App\Enums\WorkTypeEnum;
use BenSampo\Enum\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
//            'slug' => 'required|string|max:255',
            'min_salary' => 'nullable|integer|min:0',
            'max_salary' => 'nullable|integer|gte:min_salary',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'experience' => ['required'],
            'level' => ['required'], // Assuming TINYINT range
            'employee' => 'nullable|integer|min:1',
            'gender' => ['required'], // Assuming 0 for male and 1 for female
            'working_time' => ['required'], // Assuming TINYINT range
            'from_time' => 'nullable|date_format:H:i',
            'to_time' => 'nullable|date_format:H:i|after:from_time',
            'expiration_day' => 'nullable|date|after_or_equal:today',
            'qualification' => ['required'], // Assuming TINYINT range
//            'company_id' => 'required|integer|exists:companies,id',
            'province_id' => 'nullable|string|max:255',
            'district_id' => 'nullable|string|max:255',
            'description' => 'required',
            'benefit' => 'required',
            'key_responsibilities' => 'required',
            'requirement' => 'required',
            'skill_ids' => 'nullable',
            'category_id' => 'required',
        ];
    }
}
