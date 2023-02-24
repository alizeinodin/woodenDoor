<?php

namespace App\Http\Requests\Company;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'persian_name' => 'required|string|max:50',
            'english_name' => 'required|string|max:50',
            'file' => 'image|mimes:jpeg,jpg,png,svg|max:1000',
            'tel' => 'numeric',
            'address' => 'string',
            'website' => 'string',
            'number_of_staff' => 'in:0,1,2,3,4,5',
            'about_company' => 'string',
            'nick_name' => 'required|string|unique:companies',
            'employer_id' => 'numeric|exists:employer,id',
            'job_category_id' => 'numeric|exists:job_categories,id'
        ];
    }
}
