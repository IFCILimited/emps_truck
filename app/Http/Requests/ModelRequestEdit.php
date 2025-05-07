<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelRequestEdit extends FormRequest
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
            'certificate' => 'sometimes|file|mimes:pdf|max:20600',
            'certificate_no' => 'required',
            'cmvr_date' => 'required|date',
            'approval_date' => 'required|date',
            'expiry_date' => 'required|date',
            'pmp_compliance' => 'required',
            'warranty_check' => 'required',
            'factory_price' => 'required|numeric',
            'spec_density' => 'required|numeric',
            'life_cyc' => 'required|numeric',
            'min_ex_show_price' => 'required|numeric',
            'range' => 'required|numeric',
            'max_elect_consumption' => 'required|numeric',
            'min_max_speed' => 'required',
            'min_acceleration' => 'required',
            'vehicle_sub_to_test_agency_apprv' => 'required',
            'assessment_report' => 'required|file|mimes:pdf|max:20600',

        ];
    }
    public function messages()
{
    return [
        'certificate.sometimes' => 'The certificate file is required only sometimes.',
        'certificate.file' => 'The certificate must be a file.',
        'certificate_no.required' => 'The certificate number is required.',
        // 'certificate_no.regex' => 'The certificate number must be alphanumeric.',
        'cmvr_date.required' => 'The CMVR date is required.',
        'cmvr_date.date' => 'The CMVR date must be a valid date.',
        'approval_date.required' => 'The approval date is required.',
        'approval_date.date' => 'The approval date must be a valid date.',
        'expiry_date.required' => 'The expiry date is required.',
        'expiry_date.date' => 'The expiry date must be a valid date.',
        'pmp_compliance.required' => 'PMP compliance is required.',
        'warranty_check.required' => 'Warranty check is required.',
        'factory_price.required' => 'The factory price is required.',
        'factory_price.numeric' => 'The factory price must be a number.',
        'spec_density.required' => 'The specific density is required.',
        'spec_density.numeric' => 'The specific density must be a number.',
        'life_cyc.required' => 'The life cycle is required.',
        'life_cyc.numeric' => 'The life cycle must be a number.',
        'min_ex_show_price.required' => 'The minimum ex-showroom price is required.',
        'min_ex_show_price.numeric' => 'The minimum ex-showroom price must be a number.',
        'range.required' => 'The range is required.',
        'range.numeric' => 'The range must be a number.',
        'max_elect_consumption.required' => 'The maximum electrical consumption is required.',
        'max_elect_consumption.numeric' => 'The maximum electrical consumption must be a number.',
        'min_max_speed.required' => 'The minimum maximum speed is required.',
        'min_max_speed.numeric' => 'The minimum maximum speed must be a number.',
        'min_acceleration.required' => 'The minimum acceleration is required.',
        'min_acceleration.numeric' => 'The minimum acceleration must be a number.',
        'vehicle_sub_to_test_agency_apprv.required' => 'Vehicle subject to test agency approval is required.',
        'assessment_report.required' => 'The assessment report file is required.',
        'assessment_report.mimes' => 'The assessment report must be a PDF file.',
        'assessment_report.max' => 'The assessment report must not exceed 20 MB.',
        'assessment_report.file' => 'The uploaded assessment report must be a valid file.',
    ];
}
}
