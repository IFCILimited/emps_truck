<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelRequest extends FormRequest
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
            'certificate' => 'sometimes|file',
            'certificate_no' => 'required|regex:/^[a-zA-Z0-9]+$/',
            'cmvr_date' => 'required|date',
            'approval_date' => 'required|date',
            'expiry_date' => 'required|date',
            'pmp_compliance' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'certificate.file' => 'The uploaded file is invalid.',
            'certificate_no.required' => 'Please enter the certificate number.',
            'certificate_no.regex' => 'The certificate number must be alphanumeric..',
            'cmvr_date.required' => 'Please select the CMVR date.',
            'cmvr_date.date' => 'The CMVR date must be a valid date.',
            'approval_date.required' => 'Please select the approval date.',
            'approval_date.date' => 'The approval date must be a valid date.',
            'expiry_date.required' => 'Please select the expiry date.',
            'pmp_compliance.required' => 'Please select the Pmp Compliance.',
            'expiry_date.date' => 'The expiry date must be a valid date.',
        ];
    }
}
