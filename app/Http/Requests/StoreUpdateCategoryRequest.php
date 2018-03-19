<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateCategoryRequest extends FormRequest
{
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
            'name' => 'required|min:2|max:255|unique:categories',
            'slug' => 'required|unique:categories'
        ];

        switch ($this->method()) {
            case "PUT":
            case "PATCH":
                $rules = array_merge($rules, [
                    'name' => [
                        'required',
                        'min:2',
                        'max:255',
                        Rule::unique('categories')->ignore($this->route('category'))
                    ],
                    'slug' => [
                        'required',
                        Rule::unique('categories')->ignore($this->route('category'))
                    ]
                ]);
                break;
            case "POST":
            default:
        }

        return $rules;
    }
}
