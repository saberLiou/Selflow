<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsRequest extends FormRequest
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
            // Create post request
            $photo_rule = 'required|image';
        }
        else{
            // Update post request
            $photo_rule = 'image';
        }
        return [
            'title'       => 'required',
            'category_id' => 'required',
            'photo'       => $photo_rule ,
            'user_id'     => 'required',
            'body'        => 'required'
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
            'title.required'        => 'The title field can not be blank.',
            'category_id.required'  => 'Please select a category.',
            'photo.required'        => 'Please choose a picture for this post.',
            'photo.image'           => 'Please make sure it\'s a photo',
            'user_id.required'      => 'Please select an author or administrator',
            'body.required'         => 'The description field can not be blank.',
        ];
    }
}
