<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateTagRequest extends FormRequest
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
            'name' => 'required|min:2|max:255|unique:tags',
            'description' => 'max:255',
            'slug' => 'required|unique:tags'
        ];

        switch ($this->method()) {
            case "PUT":
            case "PATCH":
                $rules = [
                    'name' => [
                        'required',
                        'min:2',
                        'max:255',
                        Rule::unique('tags')->ignore($this->route('tag'))
                    ],
                    'description' => 'max:255',
                    'slug' => [
                        'required',
                        Rule::unique('tags')->ignore($this->route('tag'))
                    ]
                ];
                break;
            case "POST":
            default:
        }

        return $rules;
    }
}
