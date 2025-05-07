<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyerDetailRequestUpdate extends FormRequest
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
	        'invoice_dt' => 'required|before:today',
            'invoice_amt' => 'required',
            'addmi_inc_amt' => 'required',
            'tot_inv_amt' => 'required',
            'tot_admi_inc_amt' => 'required',
            'amt_custmr' => 'required',
            'pan' => 'required|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]$/i',
            'gstin' => 'required|string|regex:/^([0-9]{2})([A-Z]{5}[0-9]{4}[A-Z])([A-Z0-9]{3})$/i',
            'addi_cust_id' => 'required',
            'cust_id_sec' => 'required',
            'vhcl_reg_file' => 'required|mimes:pdf|max:2048'
 
            
            // 'cst_ack_file' => 'required|mimes:pdf|max:2048',
            // 'invc_copy_file' => 'required|mimes:pdf|max:2048',
            // 'evoucher_copy_file' => 'required|mimes:pdf|max:2048',
            // 'selfi_copy_file' => 'required|mimes:pdf|max:2048',
            // 'temp_reg' => [
            //     'required_with:temp_reg_num',
            //     'nullable',
            //     'regex:/^T[0-9]{4}[A-Z]{2}[0-9]{4}[A-Z]{1,2}$/'
            // ],
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
