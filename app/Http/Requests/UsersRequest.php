<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            // Create user request
            $email_rule = 'required|unique:users';
        }
        else{
            // Update user request (unique ignore itself)
            $email_rule = 'required|unique:users,email,'.$this->user;
        }
        return [
            'name'      => 'required',
            'email'     => $email_rule,
            'password'  => 'required',
            'role_id'   => 'required',
            'photo'     => 'image'
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
            'name.required'     => 'The name field can not be blank.',
            'email.required'    => 'The email field can not be blank.',
            'email.unique'      => 'This email is already registered.',
            'password.required' => 'The password field can not be blank.',
            'role_id.required'  => 'Please select a role.',
            'photo.image'       => 'Please make sure it\'s a photo'
        ];
    }
}
