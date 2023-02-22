<?php

namespace App\Http\Requests\Company;

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
            'persian_name' => 'string|max:50',
            'english_name' => 'string|max:50',
            'logo_path' => 'string',
            'tel' => 'phone',
            'address' => 'string',
            'website' => 'string',
            'number_of_staff' => 'in:0,1,2,3,4,5',
            'about_company' => 'string',
            'nick_name' => 'string|unique:companies',
            'employer_id' => 'numeric|exists:employer,id',
            'job_category_id' => 'numeric|exists:job_categories,id'
        ];
    }
}
