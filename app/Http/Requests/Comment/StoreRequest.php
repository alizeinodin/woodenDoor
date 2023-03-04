<?php

namespace App\Http\Requests\Comment;

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
            'post_id' => 'required|numeric|exists:posts,id',
            'comment_id' => 'numeric|exists:comments,id',
            'content' => 'required|string'
        ];
    }
}
