<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Validation\Rule;

class CreateMultiInvoiceDocsRequest extends FormRequest
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
        
        // dd($this->request,$this, $this->vhcl_regis_no , $this->temp_reg_no, $this->vhcl_reg_file_exist, $this->vhcl_regis_no && !$this->vhcl_reg_file_exist);
        return [
            'dlr_invoice_no' => 'required',
            'invoice_dt' => 'required',
            'invoice_amt' => 'required',
            // 'vihcle_dt' => 'required',
            // required_without:vhcl_reg_file_exist
            // && !$this->vhcl_reg_file_exist
            // 'vhcl_reg_file' => 'required_with:vhcl_regis_no|mimes:pdf|max:2048',
            'vhcl_reg_file' => 'mimes:pdf|max:2048',
            // 'vhcl_reg_file' => [
            //     Rule::requiredIf(function () {
            //         return $this->vhcl_regis_no == null;    // Conditional requirement based on field_2 value
            //     }),
            //     'mimes:pdf' , 
            //     'max:2048' 
            // ],
            'cst_ack_file' => 'required_without:cust_ack_exist|mimes:pdf|max:2048',
            'invc_copy_file' => 'required_without:cust_invoice_exist|mimes:pdf|max:2048',
            'evoucher_copy_file' => 'required_without:cust_voucher_exist|mimes:pdf|max:2048',
            'selfi_copy_file' => 'required_without:cust_self_file|mimes:pdf|max:2048',
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
            'required_with' => 'This field is required',
            'required_without' =>  'This field is required',
            'required' => 'This field is required',
            'mimes' => 'The customer file copy must be a PDF file.',
            'max' => 'The customer file copy may not be greater than 2MB in size.',
            'numeric' => 'The field must be a number.',
            'digits_between'=>'The field may not be greater than :min and :max characters.'
        ];
    }
}
