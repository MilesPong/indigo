<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreUpdatePageRequest
 * @package App\Http\Requests
 */
class StoreUpdatePageRequest extends FormRequest
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
            'title' => 'required',
            'slug' => 'unique:pages',
            'body' => 'required',
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules = array_merge($rules, [
                    'slug' => [
                        Rule::unique('pages')->ignore($this->route('page'))
                    ]
                ]);
                break;
            case 'POST':
            default:
        }

        return $rules;
    }
}
