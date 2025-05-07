<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class DealerRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Assuming no specific authorization is required
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
{
    // dd(unique:users);
    // dd($this->unique::dealer_registrations, 'mobile_no');
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

public function messages()
{
    return [
        'dealer_name.required' => 'The dealer name field is required.',
        'dealer_code.required' => 'The dealer code field is required.',
        'gstin_number.required' => 'The GSTIN number field is required.',
        'gstin_number.regex' => 'The GSTIN number format is invalid.',
        'authorized_person_name.required' => 'The authorized person name field is required.',
        'pin_code.required' => 'The pin code field is required.',
        'address.required' => 'The address field is required.',
        // 'landline_no.required' => 'The landline number field is required.',
        'landline_no.regex' => 'The landline number format is invalid.',
        'landline_no.unique' => 'The landline number has already been taken.',
        'landmark.required' => 'The landmark field is required.',
        'mobile_no.required' => 'The mobile number field is required.',
        'mobile_no.regex' => 'The mobile number format is invalid.',
        'mobile_no.unique' => 'The mobile number has already been taken.',
        'state.required' => 'The state field is required.',
        'fax_no.regex' => 'The fax number format is invalid.',
        'district.required' => 'The district field is required.',
        'email_id.required' => 'The email field is required.',
        'email_id.email' => 'The email must be a valid email address.',
        'email_id.unique' => 'The email has already been taken.',
    ];
}

}
