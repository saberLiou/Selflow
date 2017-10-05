<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
        if ($this->method() == "POST"){
            // Create name request
            $name_role = 'required|unique:categories';
        }
        else{
            // Update name request (unique ignore itself)
            $name_role = 'required|unique:categories,name,'.$this->category;
        }
        return [
            'name' => $name_role
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The name field can not be blank.',
            'name.unique'   => 'The category has already existed.'
        ];
    }
}
