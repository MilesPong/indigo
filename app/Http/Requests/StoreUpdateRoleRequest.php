<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRoleRequest extends FormRequest
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
            'name' => 'required|unique:roles|max:20',
            'display_name' => 'max:50',
            'description' => 'string',
            'permission.*' => 'exists:permissions,id'
        ];

        switch ($this->method()) {
            case 'POST':
                return $rules;
            case 'PUT':
            case 'PATCH':
                return array_merge($rules, [
                    'name' => 'required|max:20|unique:roles,name,' . $this->route('role')
                ]);
            default:
        }
    }
}
