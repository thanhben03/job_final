<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCompanyRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_address' => 'required|string|max:255',
            'company_phone' => 'required|regex:/^[0-9]{10}$/', // Assuming phone number is 10 digits
            'company_username' => 'required|string|max:255|unique:companies,company_name', // Ensure unique
            'company_password' => 'required|string|min:8', // Minimum password length
            'employee' => 'required|integer|min:1',
            'website' => 'nullable|url|max:255', // Optional website field
        ];
    }
}
