<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperatorRegistrationRequest extends FormRequest
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
            'dealer_name' => 'required|string|max:255',
            'dealer_code' => 'required|string|max:255',
            'gstin_number' => ['required', 'string', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/'],
            'authorized_person_name' => 'required|string|max:255',
            'pin_code' => 'required|string|size:6',
            'address' => 'required|string|max:255',
            'landline_no' => 'string|digits_between:8,12',
            'landmark' => 'required|string|max:255',
            'mobile_no' => 'required|string|size:10|regex:/^[0-9]{10}$/',
            'state' => 'required|string|max:255',
            // 'fax_no' => 'nullable|regex:/^[0-9]{0,10}$/',
            'district' => 'required|string|max:255',
            'email_id' => 'required|email',
        ];
    }
}
