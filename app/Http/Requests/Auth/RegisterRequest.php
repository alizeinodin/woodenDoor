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
        return false;
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'sex' => 'required|in:MALE,FEMALE',
        ];
    }
}
