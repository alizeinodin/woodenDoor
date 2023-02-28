<?php

namespace App\Http\Requests\Post;

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
            'title' => 'string|max:100|unique:posts',
            'description' => 'string|max:76',
            'content' => 'string',
            'post_status' => 'in:0,1,2,3,4',
            'comment_status' => 'in:true,false',
            'score' => 'numeric',
            'uri' => 'string|unique:posts|max:150',
            'index_image' => 'string',
            'category_id' => 'exists:categories, id',
        ];
    }
}
