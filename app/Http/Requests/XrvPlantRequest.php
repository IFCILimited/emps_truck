<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XrvPlantRequest extends FormRequest
{
  
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            

            'evplant.*.plant_name' => 'required|string|max:255',
            'evplant.*.plant_address' => 'required|string|max:255',
            'evplant.*.plant_email' => 'required|email|max:255',
            'evplant.*.plant_state' => 'required|string|max:255',
            'evplant.*.plant_district' => 'required|string|max:255',
            'evplant.*.plant_city' => 'required|string|max:255',
            'evplant.*.plant_pincode' => 'required|string|max:255',
            'evplant.*.plant_landline' => 'required|string|numeric|digits_between:8,12',

            
        ];
    }

    public function messages()
{
    return [
        

        // Manufacturing Plants Wizard
        'evplant.*.plant_name.required' => 'The plant name field is required.',
        'evplant.*.plant_name.string' => 'The plant name must be a string.',
        'evplant.*.plant_name.max' => 'The plant name may not be greater than :max characters.',
        'evplant.*.plant_address.required' => 'The plant address field is required.',
        'evplant.*.plant_address.string' => 'The plant address must be a string.',
        'evplant.*.plant_address.max' => 'The plant address may not be greater than :max characters.',
        'evplant.*.plant_email.required' => 'The plant email field is required.',
        'evplant.*.plant_email.email' => 'The plant email must be a valid email address.',
        'evplant.*.plant_email.max' => 'The plant email may not be greater than :max characters.',
        'evplant.*.plant_state.required' => 'The plant state field is required.',
        'evplant.*.plant_state.string' => 'The plant state must be a string.',
        'evplant.*.plant_state.max' => 'The plant state may not be greater than :max characters.',
        'evplant.*.plant_district.required' => 'The plant district field is required.',
        'evplant.*.plant_district.string' => 'The plant district must be a string.',
        'evplant.*.plant_district.max' => 'The plant district may not be greater than :max characters.',
        'evplant.*.plant_city.required' => 'The plant city field is required.',
        'evplant.*.plant_city.string' => 'The plant city must be a string.',
        'evplant.*.plant_city.max' => 'The plant city may not be greater than :max characters.',
        'evplant.*.plant_pincode.required' => 'The plant pincode field is required.',
        'evplant.*.plant_pincode.string' => 'The plant pincode must be a string.',
        'evplant.*.plant_pincode.max' => 'The plant pincode may not be greater than :max characters.',
        'evplant.*.plant_landline.required' => 'The plant landline field is required.',
        'evplant.*.plant_landline.string' => 'The plant landline must be a string.',
        'evplant.*.plant_landline.max' => 'The plant landline may not be greater than :max characters.',
        'evplant.*.plant_landline.digits_between' => 'The plant landline may not be greater than :min and :max characters.',
        'evplant.*.plant_landline.numeric' => 'The plant landline is numeric.',

    ];
}
}
