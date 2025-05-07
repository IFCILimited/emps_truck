<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserDataRequest extends FormRequest
{
    public function authorize()
    {
        // Here you can determine if the user is authorized to make this request
        return true;
    }

    public function rules()
    {
        return [
            'auth_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|numeric',
            'designation' => 'required|string|max:255',
            'isapproved' => 'required|in:Y,N',
            'isactive' => 'required|in:Y,N',
        ];
    }

    public function messages()
    {
        return [
            'auth_name.required' => 'The Auth Name field is required.',
            'email.required' => 'The Email field is required.',
            'email.email' => 'The Email must be a valid email address.',
            'mobile.required' => 'The Mobile field is required.',
            'mobile.numeric' => 'The Mobile field must be a number.',
            'designation.required' => 'The Designation field is required.',
            'isapproved.required' => 'The Is Approved field is required.',
            'isapproved.in' => 'The Is Approved field must be either Yes or No.',
            'isactive.required' => 'The Is Active field is required.',
            'isactive.in' => 'The Is Active field must be either Yes or No.',
        ];
    }
}
