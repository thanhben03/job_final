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
            'phone' => 'required|digits_between:9,15',
            'email' => 'required|email|max:255',
            'price_per_hours' => 'required|numeric|min:0',
            'gender' => 'required|in:0,1,2',
            'birthday' => 'required|date',
            'type_work' => ['required'], // Assuming these are the only two options
            'introduce' => 'nullable|string|max:500', // Optional field with a maximum length of 500 characters
        ];
    }
}
