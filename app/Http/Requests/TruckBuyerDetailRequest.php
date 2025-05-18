<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TruckBuyerDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Assuming authorization is handled elsewhere
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd('hi');
        return [
            'vin' => 'required',
            'srch_v' => 'required',
            'xevmodl' => 'required',
            'modelV' => 'required',
            'seg' => 'required',
            'exfactry' => 'required',
            'manufacturing_date' => 'required',
            'custmr_typ' => 'required',
            'custmr_name' => 'required',
            'email' => 'email',
            'add' => 'required',
            'landmark' => 'required',
            'Pincode' => 'required',
            'State' => 'required',
            'District' => 'required',
            'City' => 'required',
            'mobile' => 'required|numeric|digits_between:10,10',
            'dob' => 'required',
            'dlr_invoice_no' => 'required',
	        //'invoice_dt' => 'required|before:today',
	        'invoice_dt' => 'required',
            'invoice_amt' => 'required',
            'addmi_inc_amt' => 'required',
            'tot_inv_amt' => 'required',
            'tot_admi_inc_amt' => 'required',
            'amt_custmr' => 'required',
            'pan' => 'required|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/i',
            'pancopy' => 'required|mimes:pdf|max:2048',    // PDF file with max size of 2MB (2048 KB)
            'gstin' => 'required|string|regex:/^([0-9]{2})([A-Z]{5}[0-9]{4}[A-Z])([A-Z0-9]{3})$/i',
            'gstncopy' => 'required|mimes:pdf|max:2048',    // PDF file with max size of 2MB (2048 KB)
            'addi_cust_id' => 'required',
            'cust_id_sec' => 'required',
            'cust_sec_file' => 'required|mimes:pdf|max:2048',    // PDF file with max size of 2MB (2048 KB)
            'gvw' => 'required',
            'data.*.cdnumber' => 'required',
            'data.*.cd_owner_name' => 'required',
            'data.*.gvw' => 'required',
            'data.*.vin_no' => 'required',
            'data.*.status' => 'required',
            'data.*.cd_issue_date' => 'required',
            'data.*.cd_validation_date' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'This field is required',
            'mimes' => 'The customer file copy must be a PDF file.',
            'max' => 'The customer file copy may not be greater than 2MB in size.',
            'numeric' => 'The field must be a number.',
            'digits_between'=>'The field may not be greater than :min and :max characters.',
            'invoice_dt.before' => 'Invoice date should be less than or equal to today.'
        ];
    }
}
