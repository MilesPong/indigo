<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdatePostRequest extends FormRequest
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
            'title' => 'required|max:25',
            'description' => 'max:100',
            'category_id' => 'required',
            'slug' => 'unique:posts',
            'content' => 'required'
        ];

        switch ($this->method()) {
            case "PUT":
            case "PATCH":
                $rules = array_merge($rules, [
                    'slug' => 'unique:posts,slug,' . $this->route('post')
                ]);
                break;
            case "POST":
            default:
        }

        return $rules;
    }
}
