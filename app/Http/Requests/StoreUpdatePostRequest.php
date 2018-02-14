<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\DraftFix;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdatePostRequest extends FormRequest
{
    use DraftFix;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required',
            'description' => 'required|max:100',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'unique:posts',
            'body' => 'required',
            'feature_img' => 'required',
        ];

        switch ($this->method()) {
            case "PUT":
            case "PATCH":
                $rules = array_merge($rules, [
                    'slug' => [
                        Rule::unique('posts')->ignore($this->route('post'))
                    ]
                ]);
                break;
            case "POST":
            default:
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->fixDraftInput();
    }
}
