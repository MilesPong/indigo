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
            'password' => 'required|min:6|confirmed',
        ];

        switch ($this->method()) {
            case "PUT":
            case "PATCH":
                // TODO password is not required while in update event
                $rules = array_merge($rules, [
                    'password' => 'sometimes|min:6|confirmed',
                    // 'password_confirmation' => 'required_with:password|min:6',
                    'email' => 'required|email|max:255|unique:users,email,' . $this->route('user')
                ]);
                break;
            case "POST":
            default:
        }

        return $rules;
    }
}
