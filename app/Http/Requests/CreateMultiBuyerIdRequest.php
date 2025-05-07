<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMultiBuyerIdRequest extends FormRequest
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
            'auth_per_name' => 'required',
            'custmr_typ' => 'required',
            'custmr_name' => 'required',
            'add' => 'required',
            'landmark' => 'required',
            'Pincode' => 'required',
            'City' => 'required',
            'mobile' => 'required|numeric|digits_between:10,10',
            'addi_cust_id' => 'required',
            'cust_sec_file' => 'required_without:prev_file|mimes:pdf|max:2048',
            'vhcl_reg_file' => 'required|mimes:pdf|max:2048'
 
            // 'vin[]' => 'required'
        ];
        
    }

    public function messages()
    {
        return [
            'required_without' =>  'This field is required',
            'required' => 'This field is required',
            'mimes' => 'The customer file copy must be a PDF file.',
            'max' => 'The customer file copy may not be greater than 2MB in size.',
            'numeric' => 'The field must be a number.',
            'digits_between'=>'The field may not be greater than :min and :max characters.'
        ];
    }
}
