<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductionDataRequest extends FormRequest
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
        return [
            'production.*.model_name' => 'required',
            'production.*.model_code' => 'required',
            'production.*.manufacturing_date' => 'required|date',
            'production.*.vin_chassis_no' => 'required',
            'production.*.colour' => 'required',
            'production.*.motor_number' => 'required',
            'production.*.battery_number' => 'required',
            'production.*.battery_make' => 'required',
            'production.*.battery_capacity' => 'required',
            'production.*.battery_chemistry' => 'required',
            'production.*.dva_indicative' => 'required',
            'production.*.pmp_compliance' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'production.*.model_name.required' => 'The model name is required.',
            'production.*.model_code.required' => 'The model code is required.',
            'production.*.manufacturing_date.required' => 'The manufacturing date is required.',
            'production.*.manufacturing_date.date' => 'The manufacturing date must be a valid date.',
            'production.*.vin_chassis_no.required' => 'The VIN chassis number is required.',
            'production.*.colour.required' => 'The colour is required.',
            'production.*.motor_number.required' => 'The motor number is required.',
            'production.*.battery_number.required' => 'The battery number is required.',
            'production.*.battery_make.required' => 'The battery make is required.',
            'production.*.battery_capacity.required' => 'The battery capacity is required.',
            'production.*.battery_chemistry.required' => 'The battery chemistry is required.',
            'production.*.dva_indicative.required' => 'The DVA indicative is required.',
            'production.*.pmp_compliance.required' => 'The PMP compliance is required.',
        ];
    }
}
