<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'slug' => 'unique:categories'
        ];

        switch ($this->method()) {
            case "PUT":
            case "PATCH":
                $rules = array_merge($rules, [
                    'name' => 'required|min:2|max:255|unique:categories,name,' . $this->route('category'),
                    'slug' => 'unique:categories,slug,' . $this->route('category')
                ]);
                break;
            case "POST":
            default:
        }

        return $rules;
    }
}
