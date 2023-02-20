<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|unique:users|min:3|max:50',
            'email' => 'required|unique:users|email|max:50',
            'password' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'sex' => 'required|in:MALE,FEMALE',

            'type' => 'required|boolean',

            'province' => 'string|max:50',
            'address' => 'string|max:200',
            'about_me' => 'string|max200',
            'min_salary' => 'numeric|min:0|max:9999999999',
            'military_status' => 'in:0,1,2,3,4',
            'job_position_title' => 'string|max:50',
            'job_position_status' => 'in:0,1,2,3,4',

            'persian_name' => 'required_if:type,false|string|max:50',
            'english_name' => 'required_if:type,false|string|max:50',
            'logo_path' => 'string',
            'tel' => 'phone',
            'address_company' => 'string',
            'website' => 'string',
            'number_of_staff' => 'in:0,1,2,3,4,5',
            'about_company' => 'string',
            'nick_name' => 'required_if:type,false|string|unique:companies',
            'employer_id' => 'numeric'
        ];
    }
}
