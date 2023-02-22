<?php

namespace App\Http\Requests\JobAd;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'string',
            'province' => 'string',
            'type_of_cooperation' => 'in:0,1,2,3',
            'min_salary' => 'numeric',
            'description' => 'string',
            'work_experience' => 'in:0,1,2,3,4,5',
            'min_education_degree' => 'in:0,1,2,3,4,5',
            'military_status' => 'in:0,1,2,3',
            'sex' => 'in:true,false',
        ];
    }
}
