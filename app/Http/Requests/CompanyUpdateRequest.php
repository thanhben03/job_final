<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'company_username' => 'nullable|string|alpha_dash|max:255|unique:companies,company_username',
            'password' => 'nullable|string|min:8|confirmed',
            'email' => 'required|string|email|max:255|unique:companies,email',
            'company_address' => 'nullable|string|max:255',
            'company_phone' => 'nullable|string|regex:/^[0-9]{10,15}$/',
            'company_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'employee' => 'nullable|integer|min:0',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|string|max:255',
            'introduce' => 'nullable|string',
            'facebook_link' => 'nullable|string|max:255',
            'twitter_link' => 'nullable|string|max:255',
            'instagram_link' => 'nullable|string|max:255',
        ];
    }
}
