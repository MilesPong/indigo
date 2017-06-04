<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUserRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|between:6,20|confirmed',
        ];

        switch ($this->method()) {
            case "PUT":
            case "PATCH":
                $rules = array_merge($rules, [
                    'password' => 'sometimes|required|between:6,20|confirmed',
                    'password_confirmation' => 'sometimes|required|same:password',
                    'email' => 'required|email|max:255|unique:users,email,' . $this->route('user')
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
        $pwd = ['password', 'password_confirmation'];

        collect($pwd)->each(function ($item) {
            if (!$this->has($item)) {
                $this->replace($this->except($item));
            }
        });
    }
}
