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
            'title' => 'required',
            'description' => 'max:100',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'unique:posts',
            'body' => 'required',
            'excerpt' => 'required',
            'feature_img' => 'required_without:feature_img_file|url',
            'feature_img_file' => 'required_without:feature_img|image|max:2048'
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

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $fields = ['feature_img', 'feature_img_file'];

        foreach ($fields as $field) {
            if (!$this->has($field)) {
                $this->replace($this->except($field));
            }
        }
    }
}
