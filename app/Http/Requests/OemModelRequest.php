<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OemModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'testing_agency' => 'required|string',
            'oem_name' => 'required|string|max:255',
            'ev_model_name' => 'required|string|max:255',
            'variant_name' => 'required|string|max:255',
            'meeting_ev_tech' => 'required|in:Y,N',
            'meeting_qualify_tar' => 'required|in:Y,N',
            'date_vehicle_submission' => 'required|date', 
            'model_type' =>  'required|string',     
            'model_compli_certificate' => 'required|file|mimes:pdf|max:2048',


            'vehicle_segment' => 'required|string',
            'vehicle_category' => 'required|string',
            'tech_type' => 'required|string',
            'battery_type' => 'required|string',
            'battery_power' => 'required|numeric',
            'ex_factory_price' => 'required|numeric',
            'estimate_incentive_amt' => 'required|numeric',

            'specific_density' => 'required|numeric',
            'life_cycle' => 'required|numeric',
            'battery_cat_repulsion' => 'required',
            'number_of_batteries' => 'required|integer', // Assuming 'vehicle_category' is meant to be 'number_of_batteries'
            'total_energy_capacity' => 'required|numeric',
            'battery_make' => 'required|string|max:255',
            'battery_capacity' => 'required|numeric',

            'range' => 'required|numeric|min:0',
            'max_electric_energy_consumption' => 'required|numeric|min:0',
            'minimax_speed' => 'required',
            'minimum_acceleration' => 'required',
            'monitor_device_fitment' => ['required', Rule::in(['Y', 'N'])],
            'company_name' => 'required|string|max:255',
            'device_id' => 'required|string|max:255',
            'fuel_consumption' => ['required', Rule::in(['Y', 'N'])],
            'min_exshowrromprice' => 'required|numeric|min:0',
            'vehicle_img' => 'required|file|mimes:jpeg,jpg,png|max:2048',
            'estimat_incentive_amt' => 'required|numeric|min:0',
            'warranty_period_indicate' => 'required',
            // 'warranty_period_to' => 'required|date',


        ];
    }

    public function messages()
    {
        return [
            'testing_agency.required' => 'Please select a testing agency.',
            'oem_name.required' => 'The OEM name is required.',
            'ev_model_name.required' => 'The EV model name is required.',
            'variant_name.required' => 'The variant name is required.',
            'meeting_ev_tech.required' => 'Please indicate if meeting EV technology function.',
            'meeting_ev_tech.in' => 'Invalid selection for meeting EV technology function.',
            'meeting_qualify_tar.required' => 'Please indicate if meeting qualification targets.',
            'meeting_qualify_tar.in' => 'Invalid selection for meeting qualification targets.',
            'date_vehicle_submission.required' => 'Please enter the date of vehicle submission.',
            'date_vehicle_submission.date' => 'The date of vehicle submission must be a valid date format.',
            'model_type.required' => 'The model type field is required.',
            'model_type.string' => 'The model type field must be a string.',

            'model_compli_certificate.required' => 'The model compliance certificate field is required.',
            'model_compli_certificate.file' => 'The model compliance certificate must be a file.',
            'model_compli_certificate.mimes' => 'The model compliance certificate must be a PDF file.',
            'model_compli_certificate.max' => 'The model compliance certificate must not be larger than 2 MB.',


            'vehicle_segment.required' => 'The vehicle segment is required.',
            'vehicle_category.required' => 'The vehicle category is required.',
            'tech_type.required' => 'The technology type is required.',
            'battery_type.required' => 'The battery type is required.',
            'battery_power.required' => 'The battery power is required.',
            'battery_power.numeric' => 'The battery power must be a number.',
            'ex_factory_price.required' => 'The ex-factory price is required.',
            'ex_factory_price.numeric' => 'The ex-factory price must be a number.',
            'estimate_incentive_amt.required' => 'The estimated incentive amount is required.',
            'estimate_incentive_amt.numeric' => 'The estimated incentive amount must be a number.',


            'specific_density.required' => 'Specific density is required.',
            'specific_density.numeric' => 'Specific density must be a number.',
            'life_cycle.required' => 'Life cycle is required.',
            'life_cycle.numeric' => 'Life cycle must be a number.',
            'battery_cat_repulsion.required' => 'Please add a value for the battery category repulsion.',
            'number_of_batteries.required' => 'The number of batteries required for vehicle propulsion is required.',
            'number_of_batteries.integer' => 'The number of batteries must be an integer.',
            'total_energy_capacity.required' => 'Total energy xEV capacity is required.',
            'total_energy_capacity.numeric' => 'Total energy xEV capacity must be a number.',
            'battery_make.required' => 'Battery make is required.',
            'battery_capacity.required' => 'Battery capacity is required.',
            'battery_capacity.numeric' => 'Battery capacity must be a number.',

            'range.required' => 'The range field is required.',
            'range.numeric' => 'The range must be a number.',
            'range.min' => 'The range must be at least 0.',

            'max_electric_energy_consumption.required' => 'The maximum electric energy consumption field is required.',
            'max_electric_energy_consumption.numeric' => 'The maximum electric energy consumption must be a number.',
            'max_electric_energy_consumption.min' => 'The maximum electric energy consumption must be at least 0.',

            'minimax_speed.required' => 'The minimum/maximum speed field is required.',
            'minimax_speed.numeric' => 'The minimum/maximum speed must be a number.',
            'minimax_speed.min' => 'The minimum/maximum speed must be at least 0.',

            'minimum_acceleration.required' => 'The minimum acceleration field is required.',
            'minimum_acceleration.numeric' => 'The minimum acceleration must be a number.',

            'monitor_device_fitment.required' => 'The monitoring device fitment selection is required.',
            'monitor_device_fitment.in' => 'The selected monitoring device fitment is invalid.',

            'company_name.required' => 'The company name field is required.',
            'company_name.string' => 'The company name must be a string.',
            'company_name.max' => 'The company name may not be greater than 255 characters.',

            'device_id.required' => 'The device ID field is required.',
            'device_id.string' => 'The device ID must be a string.',
            'device_id.max' => 'The device ID may not be greater than 255 characters.',

            'fuel_consumption.required' => 'The fuel consumption field is required.',
            'fuel_consumption.in' => 'The selected fuel consumption option is invalid.',

            'min_exshowrromprice.required' => 'The minimum ex-showroom price field is required.',
            'min_exshowrromprice.numeric' => 'The minimum ex-showroom price must be a number.',
            'min_exshowrromprice.min' => 'The minimum ex-showroom price must be at least 0.',

            'vehicle_img.required' => 'Please upload a vehicle image.',
            'vehicle_img.file' => 'The uploaded file is not valid.',
            'vehicle_img.mimes' => 'The image must be in JPEG, JPG, or PNG format.',
            'vehicle_img.max' => 'The image size must be under 2MB.',

            'estimat_incentive_amt.required' => 'The estimated incentive amount field is required.',
            'estimat_incentive_amt.numeric' => 'The estimated incentive amount must be a number.',
            'estimat_incentive_amt.min' => 'The estimated incentive amount must be at least 0.',

            'warranty_period_indicate.required' => 'The warranty period field is required.',
            // 'warranty_period_to.required' => 'The warranty period field must be a string.',
            // 'warranty_period_from.date' => 'The date of Warranty Period must be a valid date format.',
            // 'warranty_period_to.date' => 'The date of Warranty Period must be a valid date format.',

        ];
    }
}
